<?php

namespace App\Http\Controllers\Sketch;

use App\FileCategory;
use App\Http\Controllers\Controller;
use App\File;
use App\FileItem;
use App\FileItemType;
use App\Sketch;
use App\SketchApzDepartmentResponse;
use App\SketchStatus;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SketchApzDepartmentController extends Controller
{
    /**
     * Show sketch list for user
     *
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function all($status)
    {
        switch ($status) {
            case 'accepted':
                $sketches = Sketch::where('status_id', SketchStatus::ACCEPTED);
                break;

            case 'declined':
                $sketches = Sketch::where('status_id', SketchStatus::DECLINED);
                break;

            case 'active':
            default:
                $sketches = Sketch::whereNotIn('status_id', [SketchStatus::ACCEPTED, SketchStatus::DECLINED]);
                break;
        }

        return response()->json($sketches->orderBy('created_at', 'desc')->paginate(20), 200);
    }

    /**
     * Show sketch
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sketch = Sketch::with(Sketch::getSketchBaseRelationList())->where(['id' => $id])->first();

        if (!$sketch) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($sketch, 200);
    }

    /**
     * Save decision
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id)
    {
        $sketch = Sketch::where('id', $id)->first();
        $file_request = $request->file('file');

        if (!$sketch) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        \DB::beginTransaction();

        try {
            $response = SketchApzDepartmentResponse::where(['sketch_id' => $sketch->id])->first();

            if (!$response) {
                $response = new SketchApzDepartmentResponse();
            }

            $response->sketch_id = $id;
            $response->user_id = Auth::user()->id;
            $response->response_text = $request['Message'];
            $response->response = $request['Response'] == 'true' ? true : false;
            $response->save();

            if ($file_request) {
                $file_name = md5($file_request->getClientOriginalName() . microtime());
                $file_ext = $file_request->getClientOriginalExtension();
                $file_url = 'sketch/response/apz_department/' . $sketch->id . '/' . $file_name . '.' . $file_ext;

                \Storage::put($file_url, file_get_contents($file_request));

                if (!\Storage::disk('local')->exists($file_url)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $file_request->getClientOriginalName();
                $file->url = $file_url;
                $file->extension = $file_request->getClientOriginalExtension();
                $file->content_type = $file_request->getClientMimeType();
                $file->size = $file_request->getClientSize();
                $file->hash = $file_name;
                $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
                $file->user_id = Auth::user()->id;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $response->id;
                $file_item->item_type_id = FileItemType::SKETCH_APZ_DEPARTMENT_RESPONSE;
                $file_item->save();
            }

            \DB::commit();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['message' => $e->getTrace()], 500);
        }
    }

    /**
     * Region decision
     *
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request, $id)
    {
        $sketch = Sketch::where('id', $id)->first();

        if (!$sketch) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        \DB::beginTransaction();

        try {
            $sketch->status_id = $request['Response'] == 'true' ? SketchStatus::ACCEPTED : SketchStatus::ACCEPTED;
            $sketch->save();

            \DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
        }
    }

    public function generateXml($id)
    {
        $sketch = Sketch::where(['id' => $id])->with(Sketch::getSketchBaseRelationList())->first();

        if (!$sketch) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $output = view('xml_templates.sketch.apz_department', ['sketch' => $sketch, 'user' => Auth::user()])->render();
        $xml = "<?xml version=\"1.0\" ?>\n" . $output;

        return response($xml, 200)->header('Content-Type', 'text/plain');
    }

    public function saveXml(Request $request, $id)
    {
        try {
            $sketch =  Sketch::where(['id' => $id])->with(Sketch::getSketchBaseRelationList())->first();

            if (!$sketch) {
                throw new \Exception('АПЗ не найден');
            }

            $output = view('xml_templates.sketch.apz_department', ['sketch' => $sketch, 'user' => Auth::user()])->render();
            $server_xml = simplexml_load_string("<?xml version=\"1.0\" ?>\n" . $output);

            $current_xml = simplexml_load_string($request->xml);

            if ($server_xml->content->asXML() != $current_xml->content->asXML()) {
                throw new \Exception('Некорректный XML');
            }

            $client = new Client();

            $response = $client->post('http://89.218.17.203:3380/validate_xml', [
                'form_params' => [
                    'xml' => $request->xml
                ],
            ]);

            if (!$response->getStatusCode() == 200) {
                throw new \Exception('Не удалось пройти валидацию');
            }

            $file = File::addXmlItem('sketch_apz_xml', FileCategory::XML_APZ, 'sign_files/sketch/' . $sketch->id, $request->xml);

            if (!$file) {
                throw new \Exception('Не удалось сохранить модель File');
            }

            $file_item = FileItem::addItem($file, $sketch->apzDepartmentResponse->id, FileItemType::SKETCH_APZ_DEPARTMENT_RESPONSE);

            if (!$file_item) {
                throw new \Exception('Не удалось сохранить модель FileItem');
            }

            return response()->json(['status' => true], '200');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
