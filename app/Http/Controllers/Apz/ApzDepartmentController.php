<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\File;
use App\FileCategory;
use App\FileItem;
use App\FileItemType;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApzDepartmentController extends Controller
{
    /**
     * Show apz list for region
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $data = Apz::with(Apz::getApzBaseRelationList())->get();
        $result = ['in_process' => [], 'accepted' => [], 'declined' => []];

        foreach ($data as $item) {
            $in_process = $item->stateHistory->filter(function ($value) {
                return in_array($value->state_id, [ApzState::APZ_APPROVED, ApzState::APZ_DECLINED]);
            });

            $accepted = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::APZ_APPROVED;
            });

            $declined = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::APZ_DECLINED;
            });

            if (sizeof($in_process) == 0 || $item->status_id == ApzStatus::APZ_DEPARTMENT) {
                $result['in_process'][] = $item;
                continue;
            }

            if (sizeof($accepted) > 0) {
                $result['accepted'][] = $item;
                continue;
            }

            if (sizeof($declined) > 0) {
                $result['declined'][] = $item;
                continue;
            }
        }

        return response()->json($result, 200);
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
     * Region decision
     *
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request, $id)
    {
        $apz = Apz::where('id', $id)->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = $request['response'] == 'true' ? ApzStatus::CHIEF_ARCHITECT : ApzStatus::ARCHITECT ;
            $apz->save();

            $region_state = new ApzStateHistory();
            $region_state->apz_id = $apz->id;
            $region_state->state_id = $request['response'] == 'true' ? ApzState::APZ_APPROVED : ApzState::APZ_DECLINED;
            $region_state->save();

            $engineer_state = new ApzStateHistory();
            $engineer_state->apz_id = $apz->id;
            $engineer_state->state_id = $request['response'] == 'true' ? ApzState::TO_HEAD : ApzState::TO_REGION;
            $engineer_state->comment = $request["message"];
            $engineer_state->save();

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
        }
    }

    public function generateXml($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $output = view('xml_templates.apz_department', ['apz' => $apz, 'user' => Auth::user()])->render();
        $xml = "<?xml version=\"1.0\" ?>\n" . $output;

        return response($xml, 200)->header('Content-Type', 'text/plain');
    }

    public function saveXml(Request $request, $id)
    {
        try {
            $apz =  Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

            if (!$apz) {
                throw new \Exception('АПЗ не найден');
            }

            $output = view('xml_templates.apz_department', ['apz' => $apz, 'user' => Auth::user()])->render();
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

            $file = File::addXmlItem('apz_xml', FileCategory::XML_APZ, 'sign_files/' . $apz->id, $request->xml);

            if (!$file) {
                throw new \Exception('Не удалось сохранить модель File');
            }

            $file_item = FileItem::addItem($file, $id, FileItemType::APZ);

            if (!$file_item) {
                throw new \Exception('Не удалось сохранить модель FileItem');
            }

            return response()->json(['status' => true], '200');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
