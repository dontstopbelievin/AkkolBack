<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzHeadResponse;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\FileItem;
use App\FileItemType;
use App\Http\Controllers\Controller;
use App\File;
use App\FileCategory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ApzHeadController extends Controller
{
    /**
     * Show apz list for region
     *
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function all($status)
    {
        $query = Apz::with(Apz::getApzBaseRelationList());

        if (Input::get('status')) {
            $query->whereHas('stateHistory', function($query) {
                $query->where('state_id', Input::get('status') == 'accepted' ? ApzState::HEAD_APPROVED : ApzState::HEAD_DECLINED );
            });
        }

        if (Input::get('start_date')) {
            $query->where('created_at', '>=', Input::get('start_date'));
        }

        if (Input::get('end_date')) {
            $query->where('created_at', '<', Input::get('end_date'));
        }

        switch ($status) {
            case 'accepted':
                $query->whereHas('stateHistory', function ($query) {
                    $query->where('state_id', ApzState::HEAD_APPROVED);
                });
                break;

            case 'declined':
                $query->whereHas('stateHistory', function ($query) {
                    $query->where('state_id', ApzState::HEAD_DECLINED);
                });
                break;

            case 'active':
            default:
                $query->where('status_id', ApzStatus::CHIEF_ARCHITECT);
                break;
        }

        return response()->json($query->orderBy('created_at', 'desc')->paginate(20), 200);
    }

    /**
     * Show apz for region
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
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
        $apz = Apz::where('id', $id)->first();
        $file_request = $request->file('file');
        $request = $request->all();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $response = new ApzHeadResponse();
            $response->apz_id = $apz->id;
            $response->user_id = Auth::user()->id;
            $response->response_text = $request['Message'];
            $response->response = ($request["Response"] == "true") ? true : false;
            $response->doc_number = $request["DocNumber"];
            $response->save();

            if ($file_request) {
                $file_name = md5($file_request->getClientOriginalName() . microtime());
                $file_ext = $file_request->getClientOriginalExtension();
                $file_url = 'head_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                Storage::put($file_url, file_get_contents($file_request));

                if (!Storage::disk('local')->exists($file_url)) {
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
                $file_item->item_type_id = FileItemType::HEAD_RESPONSE;
                $file_item->save();
            }

            DB::commit();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getTrace()], 500);
        }
    }

    /**
     * Region decision
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request, $id)
    {
        $apz = Apz::where('id', $id)->first();
        $response = ApzHeadResponse::where(['apz_id' => $id])->first();

        if (!$apz || !$response) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = $request["Response"] == "true" ? ApzStatus::ACCEPTED : ApzStatus::ARCHITECT;
            $apz->save();

            if ($request["Response"] == "true") {
                $head_state = new ApzStateHistory();
                $head_state->apz_id = $apz->id;
                $head_state->state_id = ApzState::HEAD_APPROVED;
                $head_state->save();
            } else {
                $head_state = new ApzStateHistory();
                $head_state->apz_id = $apz->id;
                $head_state->state_id = ApzState::HEAD_DECLINED;
                $head_state->comment = $response->response;
                $head_state->save();

                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::TO_REGION;
                $region_state->comment = $response->response_text;
                $region_state->save();
            }

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getTrace()], 500);
        }
    }

    /**
     * Generate XML
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function generateXml($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $output = view('xml_templates.head_response', ['apz' => $apz, 'user' => Auth::user()])->render();
        $xml = "<?xml version=\"1.0\" ?>\n" . $output;

        return response($xml, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Save XML
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function saveXml(Request $request, $id)
    {
        try {
            $apz =  Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

            if (!$apz) {
                throw new \Exception('АПЗ не найден');
            }

            $output = view('xml_templates.head_response', ['apz' => $apz, 'user' => Auth::user()])->render();
            $server_xml = simplexml_load_string("<?xml version=\"1.0\" ?>\n" . $output);

            $current_xml = simplexml_load_string($request->xml);

            if ($server_xml->content->asXML() != $current_xml->content->asXML()) {
                throw new \Exception('Некорректный XML');
            }

            $client = new Client();
            $user = Auth::user();

            $response = $client->post('http://89.218.17.203:3380/validate_xml', [
                'form_params' => [
                    'xml' => $request->xml
                ],
            ]);

            if (!$response->getStatusCode() == 200) {
                throw new \Exception('Не удалось пройти валидацию');
            }

//            $iin = json_decode($response->getBody(), true);
//
//            if ($iin != $user->iin) {
//                return response()->json(['message' => 'Выбран ключ другого пользователя'], 500);
//            }

            $head_response = ApzHeadResponse::where(['apz_id' => $apz->id])->first();

            if (!$head_response) {
                return response()->json(['message' => 'Не найден ответ от провайдера'], 500);
            }

            $file = File::addXmlItem('head_xml', FileCategory::XML_HEAD, 'sign_files/' . $apz->id, $request->xml);

            if (!$file) {
                throw new \Exception('Не удалось сохранить модель File');
            }

            $file_item = FileItem::addItem($file, $head_response->id, FileItemType::HEAD_RESPONSE);

            if (!$file_item) {
                throw new \Exception('Не удалось сохранить модель FileItem');
            }

            return response()->json(['status' => true], '200');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
