<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzDepartmentResponse;
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
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function all($status)
    {
        $data = Apz::with(Apz::getApzBaseRelationList());

        switch ($status) {
            case 'accepted':
                $data->whereHas('stateHistory', function ($query) {
                    $query->where('state_id', ApzState::APZ_APPROVED);
                });
                break;

            case 'declined':
                $data->whereHas('stateHistory', function ($query) {
                    $query->where('state_id', ApzState::APZ_DECLINED);
                });
                break;

            case 'active':
            default:
                $data->where('status_id', ApzStatus::APZ_DEPARTMENT);
                break;
        }

        return response()->json($data->orderBy('created_at', 'desc')->paginate(20), 200);
    }

    /**
     * Show apz for region
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzDepartmentRelationList())->first();

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

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $response = ApzDepartmentResponse::where(['apz_id' => $apz->id])->first();

            if (!$response) {
                $response = new ApzDepartmentResponse();
            }

            $response->apz_id = $apz->id;
            $response->user_id = Auth::user()->id;
            $response->doc_number = $request->docNumber;
            $response->basis_for_development_apz = $request->basisForDevelopmentApz;
            $response->building_presence = $request->buildingPresence;
            $response->address = $request->address;
            $response->geodetic_study = $request->geodeticStudy;
            $response->engineering_geological_study = $request->engineeringGeologicalStudy;
            $response->planning_system = $request->planningSystem;
            $response->functional_value_of_object = $request->functionalValueOfObject;
            $response->floor_sum = $request->floorSum;
            $response->structural_scheme = $request->structuralScheme;
            $response->engineering_support = $request->engineeringSupport;
            $response->energy_efficiency_class = $request->energyEfficiencyClass;
            $response->spatial_solution = $request->spatialSolution;
            $response->draft_master_plan = $request->draftMasterPlan;
            $response->vertical_layout = $request->verticalLayout;
            $response->landscaping_and_gardening = $request->landscapingAndGardening;
            $response->parking = $request->parking;
            $response->use_of_fertile_soil_layer = $request->useOfFertileSoilLayer;
            $response->small_architectural_forms = $request->smallArchitecturalForms;
            $response->lighting = $request->lighting;
            $response->stylistics_of_architecture = $request->stylisticsOfArchitecture;
            $response->nature_combination = $request->natureCombination;
            $response->color_solution = $request->colorSolution;
            $response->advertising_and_information_solution = $request->advertisingAndInformationSolution;
            $response->night_lighting = $request->nightLighting;
            $response->input_nodes = $request->inputNodes;
            $response->conditions_for_low_mobile_groups = $request->conditionsForLowMobileGroups;
            $response->compliance_noise_conditions = $request->complianceNoiseConditions;
            $response->plinth = $request->plinth;
            $response->facade = $request->facade;
            $response->heat_supply = $request->heatSupply;
            $response->water_supply = $request->waterSupply;
            $response->sewerage = $request->sewerage;
            $response->power_supply = $request->powerSupply;
            $response->gas_supply = $request->gasSupply;
            $response->phone_supply = $request->phoneSupply;
            $response->drainage = $request->drainage;
            $response->irrigation_systems = $request->irrigationSystems;
            $response->engineering_surveys_obligation = $request->engineeringSurveysObligation;
            $response->demolition_obligation = $request->demolitionObligation;
            $response->transfer_communications_obligation = $request->transferCommunicationsObligation;
            $response->conservation_plant_obligation = $request->conservationPlantObligation;
            $response->temporary_fencing_construction_obligation = $request->temporaryFencingConstructionObligation;
            $response->additional_requirements = $request->additionalRequirements;
            $response->general_requirements = $request->generalRequirements;
            $response->notes = $request->notes;
            $response->save();

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
