<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzAnswerTemplate;
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
use Illuminate\Support\Facades\Input;

class ApzRegionController extends Controller
{
    /**
     * Show apz list for region
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $region = Auth::user()->roles()->where('level', 3)->first();

        if (!$region) {
            return response()->json(['message' => 'У вас недостаточно прав для доступа к данной странице'], 403);
        }

        $query = Apz::where(['region' => $region->name])->whereRaw('DATE(DATE_ADD(created_at, INTERVAL 1 DAY)) < NOW()')->with(Apz::getApzBaseRelationList());

        if (Input::get('status')) {
            $query->whereHas('stateHistory', function($query) {
                $query->where('state_id', Input::get('status') == 'accepted' ? ApzState::REGION_APPROVED : ApzState::REGION_DECLINED );
            });
        }

        if (Input::get('start_date')) {
            $query->where('created_at', '>=', Input::get('start_date'));
        }

        if (Input::get('end_date')) {
            $query->where('created_at', '<', Input::get('end_date'));
        }

        $data = $query->get();
        $result = ['in_process' => [], 'awaiting'=> [], 'accepted' => [], 'declined' => []];

        foreach ($data as $item) {
            $accepted = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::REGION_APPROVED;
            });

            $declined = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::REGION_DECLINED;
            });

            if (in_array($item->status_id, [ApzStatus::ENGINEER, ApzStatus::PROVIDER, ApzStatus::APZ_DEPARTMENT, ApzStatus::CHIEF_ARCHITECT])) {
                $result['awaiting'][] = $item;
                continue;
            }

            if ($item->status_id == ApzStatus::ARCHITECT) {
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
        $answer_templates = ApzAnswerTemplate::where(['user_id' => Auth::user()->id, 'is_active' => 1])->get();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json(['apz' => $apz, 'templates' => $answer_templates], 200);
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
        $request = $request->all();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = $request["response"] == "true" ? ($request["direct"] == "apz" ? ApzStatus::APZ_DEPARTMENT : ApzStatus::ENGINEER) : ApzStatus::DECLINED;
            $apz->save();

            if ($request["response"] == "true") {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::REGION_APPROVED;
                $region_state->comment = $request["message"];
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = $request["direct"] == "apz" ? ApzState::TO_APZ : ApzState::TO_ENGINEER;
                $engineer_state->comment = $request["message"];
                $engineer_state->save();
            } else {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::REGION_DECLINED;
                $region_state->comment = $request["message"];
                $region_state->save();
            }

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function generateXml($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $output = view('xml_templates.region', ['apz' => $apz, 'user' => Auth::user()])->render();
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

            $output = view('xml_templates.region', ['apz' => $apz, 'user' => Auth::user()])->render();
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

            $file = File::addXmlItem('apz_xml', FileCategory::XML_REGION, 'sign_files/' . $apz->id, $request->xml);

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
