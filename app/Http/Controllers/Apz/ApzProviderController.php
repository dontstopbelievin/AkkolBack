<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzHeadResponse;
use App\ApzProviderElectricityResponse;
use App\ApzProviderGasResponse;
use App\ApzProviderHeatResponse;
use App\ApzProviderPhoneResponse;
use App\ApzProviderWaterResponse;
use App\ApzStateHistory;
use App\ApzStatus;
use App\ApzState;
use App\Commission;
use App\CommissionStatus;
use App\CommissionUser;
use App\CommissionUserStatus;
use App\FileItem;
use App\FileItemType;
use App\Http\Controllers\Controller;
use App\File;
use App\FileCategory;
use App\Role;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApzProviderController extends Controller
{
    /**
     * Show apz list for region
     *
     * @return \Illuminate\Http\Response
     */
    public function all($provider)
    {
        /**
         * TODO Переделать запросы. Временное решение
         */
        switch ($provider) {
            case 'Water':
                $process = Apz::where([
                    'status_id' => ApzStatus::PROVIDER
                ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
                    $query->whereIn('state_id', [ApzState::WATER_APPROVED, ApzState::WATER_DECLINED]);
                })->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::WATER);
                })->get();

                $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::WATER_APPROVED);
                })->get();

                $declined = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::WATER_DECLINED);
                })->get();

                break;

            case 'Gas':
                $process = Apz::where([
                    'status_id' => ApzStatus::PROVIDER
                ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
                    $query->whereIn('state_id', [ApzState::GAS_APPROVED, ApzState::GAS_DECLINED]);
                })->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::GAS);
                })->get();

                $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::GAS_APPROVED);
                })->get();

                $declined = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::GAS_DECLINED);
                })->get();

                break;

            case 'Electricity':
                $process = Apz::where([
                    'status_id' => ApzStatus::PROVIDER
                ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
                    $query->whereIn('state_id', [ApzState::ELECTRICITY_APPROVED, ApzState::ELECTRICITY_DECLINED]);
                })->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::ELECTRICITY);
                })->get();

                $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::ELECTRICITY_APPROVED);
                })->get();

                $declined = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::ELECTRICITY_DECLINED);
                })->get();

                break;

            case 'Phone':
                $process = Apz::where([
                    'status_id' => ApzStatus::PROVIDER
                ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
                    $query->whereIn('state_id', [ApzState::PHONE_APPROVED, ApzState::PHONE_DECLINED]);
                })->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::PHONE);
                })->get();

                $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::PHONE_APPROVED);
                })->get();

                $declined = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::PHONE_DECLINED);
                })->get();

                break;

            case 'Heat':
                $process = Apz::where([
                    'status_id' => ApzStatus::PROVIDER
                ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
                    $query->whereIn('state_id', [ApzState::HEAT_APPROVED, ApzState::HEAT_DECLINED]);
                })->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::HEAT);
                })->get();

                $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::HEAT_APPROVED);
                })->get();

                $declined = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
                    $query->where('state_id', ApzState::HEAT_DECLINED);
                })->get();

                break;

            default:
                return response()->json(['message' => 'Провайдер не найден'], 404);
        }

        return response()->json([
            'in_process' => $process,
            'accepted' => $accepted,
            'declined' => $declined
        ], 200);
    }

    /**
     * Show apz for region
     *
     * @return \Illuminate\Http\Response
     */
    public function show($provider, $id)
    {
        $query = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList());

        switch ($provider) {
            case 'Water':
                $query->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::WATER);
                });

                break;

            case 'Gas':
                $query->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::GAS);
                });

                break;

            case 'Electricity':
                $query->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::ELECTRICITY);
                });

                break;

            case 'Heat':
                $query->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::HEAT);
                });

                break;

            case 'Phone':
                $query->whereHas('commission.users', function($query) {
                    $query->where('role_id', Role::PHONE);
                });

                break;
        }

        $apz = $query->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
    }

    /**
     * Save apz
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $provider, $id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        switch ($provider) {
            case 'water':
                $response = ApzProviderWaterResponse::where(['commission_id' => $apz->commission->id])->first();

                if (!$response) {
                    $response = new ApzProviderWaterResponse();
                }

                $response->commission_id = $apz->commission->id;
                $response->apz_id = $apz->id;
                $response->user_id = Auth::user()->id;
                $response->response_text = $request['Message'];
                $response->response = ($request["Response"] == "true") ? true : false;
                $response->gen_water_req = $request['GenWaterReq'];
                $response->drinking_water = $request['DrinkingWater'];
                $response->prod_water = $request['ProdWater'];
                $response->fire_fighting_water_in = $request['FireFightingWaterIn'];
                $response->fire_fighting_water_out = $request['FireFightingWaterOut'];
                $response->connection_point = $request['ConnectionPoint'];
                $response->recommendation = $request['Recomendation'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                $old_file = FileItem::where(['item_type_id' => FileItemType::WATER_RESPONSE, 'item_id' => $response->id])->first();

                if ($old_file) {
                    Storage::delete($old_file->file->url);

                    $old_file->file->delete();
                    $old_file->delete();
                }

                $file_name = md5($request->file('file')->getClientOriginalName() . microtime());
                $file_ext = $request->file('file')->getClientOriginalExtension();
                $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                Storage::put($file_url, file_get_contents($request->file('file')));

                if (!Storage::disk('local')->exists($file_url)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $request->file('file')->getClientOriginalName();
                $file->url = $file_url;
                $file->extension = $request->file('file')->getClientOriginalExtension();
                $file->content_type = $request->file('file')->getClientMimeType();
                $file->size = $request->file('file')->getClientSize();
                $file->hash = $file_name;
                $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
                $file->user_id = Auth::user()->id;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $response->id;
                $file_item->item_type_id = FileItemType::WATER_RESPONSE;
                $file_item->save();
                $response->files;

                return response()->json($response, 200);

            case 'electro':
                $response = ApzProviderElectricityResponse::where(['commission_id' => $apz->commission->id])->first();

                if (!$response) {
                    $response = new ApzProviderElectricityResponse();
                }

                $response->commission_id = $apz->commission->id;
                $response->apz_id = $apz->id;
                $response->user_id = Auth::user()->id;
                $response->response_text = $request['Message'];
                $response->response = ($request["Response"] == "true") ? true : false;
                $response->req_power = $request['ElecReqPower'];
                $response->phase = $request['ElecPhase'];
                $response->safe_category = $request['ElecSafeCategory'];
                $response->connection_point = $request['ConnectionPoint'];
                $response->recommendation = $request['Recomendation'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                $old_file = FileItem::where(['item_type_id' => FileItemType::ELECTRICITY_RESPONSE, 'item_id' => $response->id])->first();

                if ($old_file) {
                    Storage::delete($old_file->file->url);

                    $old_file->file->delete();
                    $old_file->delete();
                }

                $file_name = md5($request->file('file')->getClientOriginalName() . microtime());
                $file_ext = $request->file('file')->getClientOriginalExtension();
                $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                Storage::put($file_url, file_get_contents($request->file('file')));

                if (!Storage::disk('local')->exists($file_url)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $request->file('file')->getClientOriginalName();
                $file->url = $file_url;
                $file->extension = $request->file('file')->getClientOriginalExtension();
                $file->content_type = $request->file('file')->getClientMimeType();
                $file->size = $request->file('file')->getClientSize();
                $file->hash = $file_name;
                $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
                $file->user_id = Auth::user()->id;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $response->id;
                $file_item->item_type_id = FileItemType::ELECTRICITY_RESPONSE;
                $file_item->save();
                $response->files;

                return response()->json($response, 200);

            case 'gas':
                $response = ApzProviderGasResponse::where(['commission_id' => $apz->commission->id])->first();

                if (!$response) {
                    $response = new ApzProviderGasResponse();
                }

                $response->commission_id = $apz->commission->id;
                $response->apz_id = $apz->id;
                $response->user_id = Auth::user()->id;
                $response->response_text = $request['Message'];
                $response->response = ($request["Response"] == "true") ? true : false;
                $response->connection_point = $request['ConnectionPoint'];
                $response->gas_pipe_diameter = $request['GasPipeDiameter'];
                $response->assumed_capacity = $request['AssumedCapacity'];
                $response->reconsideration = $request['Reconsideration'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                $old_file = FileItem::where(['item_type_id' => FileItemType::GAS_RESPONSE, 'item_id' => $response->id])->first();

                if ($old_file) {
                    Storage::delete($old_file->file->url);

                    $old_file->file->delete();
                    $old_file->delete();
                }

                $file_name = md5($request->file('file')->getClientOriginalName() . microtime());
                $file_ext = $request->file('file')->getClientOriginalExtension();
                $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                Storage::put($file_url, file_get_contents($request->file('file')));

                if (!Storage::disk('local')->exists($file_url)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $request->file('file')->getClientOriginalName();
                $file->url = $file_url;
                $file->extension = $request->file('file')->getClientOriginalExtension();
                $file->content_type = $request->file('file')->getClientMimeType();
                $file->size = $request->file('file')->getClientSize();
                $file->hash = $file_name;
                $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
                $file->user_id = Auth::user()->id;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $response->id;
                $file_item->item_type_id = FileItemType::GAS_RESPONSE;
                $file_item->save();
                $response->files;

                return response()->json($response, 200);

            case 'heat':
                $response = ApzProviderHeatResponse::where(['commission_id' => $apz->commission->id])->first();

                if (!$response) {
                    $response = new ApzProviderHeatResponse();
                }

                $response->commission_id = $apz->commission->id;
                $response->apz_id = $apz->id;
                $response->user_id = Auth::user()->id;
                $response->response_text = $request['Message'];
                $response->response = ($request["Response"] == "true") ? true : false;
                $response->resource = $request['HeatResource'];
                $response->trans_pressure = $request['HeatTransPressure'];
                $response->load_contract_num = $request['HeatLoadContractNum'];
                $response->main_in_contract = $request['HeatMainInContract'];
                $response->ven_in_contract = $request['HeatVenInContract'];
                $response->water_in_contract = $request['HeatWaterInContract'];
                $response->connection_point = $request['ConnectionPoint'];
                $response->addition = $request['Addition'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                $old_file = FileItem::where(['item_type_id' => FileItemType::HEAT_RESPONSE, 'item_id' => $response->id])->first();

                if ($old_file) {
                    Storage::delete($old_file->file->url);

                    $old_file->file->delete();
                    $old_file->delete();
                }

                $file_name = md5($request->file('file')->getClientOriginalName() . microtime());
                $file_ext = $request->file('file')->getClientOriginalExtension();
                $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                Storage::put($file_url, file_get_contents($request->file('file')));

                if (!Storage::disk('local')->exists($file_url)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $request->file('file')->getClientOriginalName();
                $file->url = $file_url;
                $file->extension = $request->file('file')->getClientOriginalExtension();
                $file->content_type = $request->file('file')->getClientMimeType();
                $file->size = $request->file('file')->getClientSize();
                $file->hash = $file_name;
                $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
                $file->user_id = Auth::user()->id;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $response->id;
                $file_item->item_type_id = FileItemType::HEAT_RESPONSE;
                $file_item->save();
                $response->files;

                return response()->json($response, 200);

            case 'phone':
                $response = ApzProviderPhoneResponse::where(['commission_id' => $apz->commission->id])->first();

                if (!$response) {
                    $response = new ApzProviderPhoneResponse();
                }

                $response->commission_id = $apz->commission->id;
                $response->apz_id = $apz->id;
                $response->user_id = Auth::user()->id;
                $response->response_text = $request['Message'];
                $response->response = ($request["Response"] == "true") ? true : false;
                $response->service_num = $request['ResponseServiceNum'];
                $response->capacity = $request['ResponseCapacity'];
                $response->sewage = $request['ResponseSewage'];
                $response->client_wishes = $request['ResponseClientWishes'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                $old_file = FileItem::where(['item_type_id' => FileItemType::PHONE_RESPONSE, 'item_id' => $response->id])->first();

                if ($old_file) {
                    Storage::delete($old_file->file->url);

                    $old_file->file->delete();
                    $old_file->delete();
                }

                $file_name = md5($request->file('file')->getClientOriginalName() . microtime());
                $file_ext = $request->file('file')->getClientOriginalExtension();
                $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                Storage::put($file_url, file_get_contents($request->file('file')));

                if (!Storage::disk('local')->exists($file_url)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $request->file('file')->getClientOriginalName();
                $file->url = $file_url;
                $file->extension = $request->file('file')->getClientOriginalExtension();
                $file->content_type = $request->file('file')->getClientMimeType();
                $file->size = $request->file('file')->getClientSize();
                $file->hash = $file_name;
                $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
                $file->user_id = Auth::user()->id;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $response->id;
                $file_item->item_type_id = FileItemType::PHONE_RESPONSE;
                $file_item->save();
                $response->files;

                return response()->json($response, 200);

            default:
                return response()->json(['message' => 'Провайдер не найден'], 404);
        }
    }

    /**
     * Save apz
     *
     * @return \Illuminate\Http\Response
     */
    public function update($provider, $id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();
        $commission = Commission::where(['apz_id' => $id])->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            switch ($provider) {
                case 'water':
                    $response = ApzProviderWaterResponse::where(['commission_id' => $commission->id])->first();

                    $apz->apzWater->status = $response->response ? 1 : 0 ;
                    $apz->apzWater->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::WATER_APPROVED : ApzState::WATER_DECLINED;
                    $provider_state->save();
                    break;

                case 'electro':
                    $response = ApzProviderElectricityResponse::where(['commission_id' => $commission->id])->first();

                    $apz->apzElectricity->status = $response->response ? 1 : 0 ;
                    $apz->apzElectricity->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::ELECTRICITY_APPROVED : ApzState::ELECTRICITY_DECLINED;
                    $provider_state->save();
                    break;

                case 'gas':
                    $response = ApzProviderGasResponse::where(['commission_id' => $commission->id])->first();

                    $apz->apzGas->status = $response->response ? 1 : 0 ;
                    $apz->apzGas->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::GAS_APPROVED : ApzState::GAS_DECLINED;
                    $provider_state->save();
                    break;

                case 'heat':
                    $response = ApzProviderHeatResponse::where(['commission_id' => $commission->id])->first();

                    $apz->apzHeat->status = $response->response ? 1 : 0 ;
                    $apz->apzHeat->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::HEAT_APPROVED : ApzState::HEAT_DECLINED;
                    $provider_state->save();
                    break;

                case 'phone':
                    $response = ApzProviderPhoneResponse::where(['commission_id' => $commission->id])->first();

                    $apz->apzPhone->status = $response->response ? 1 : 0 ;
                    $apz->apzPhone->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::PHONE_APPROVED : ApzState::PHONE_DECLINED;
                    $provider_state->save();
                    break;

                default:
                    return response()->json(['message' => 'Провайдер не найден'], 404);
            }

            if (!$response) {
                return response()->json(['message' => 'Ответ не найден'], 404);
            }

            $commission_user = CommissionUser::where(['commission_id' => $commission->id, 'user_id' => $response->user_id])->first();
            $commission_user->status_id = $response->response ? CommissionUserStatus::ACCEPTED : CommissionUserStatus::DECLINED;
            $commission_user->save();

            if (!$response->response) {
                $apz->status_id = ApzStatus::ARCHITECT;
                $apz->save();

                $commission->status_id = CommissionStatus::FINISHED;
                $commission->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_REGION;
                $engineer_state->comment = $response->response_text;
                $engineer_state->save();
            } elseif (sizeof($commission->users()->where('status_id', '<>', CommissionUserStatus::IN_PROCESS)->get()) == sizeof($commission->users)) {
                $apz->status_id = ApzStatus::ENGINEER;
                $apz->save();

                $commission->status_id = CommissionStatus::FINISHED;
                $commission->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_ENGINEER;
                $engineer_state->save();
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
        $request = $request->all();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = $request["response"] ? ApzStatus::ENGINEER : ApzStatus::DECLINED;
            $apz->save();

            if ($request["response"]) {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::REGION_APPROVED;
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_ENGINEER;
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
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
        }
    }

    public function generateXml($provider, $id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        if (!in_array($provider, ['water', 'electricity', 'gas', 'heat', 'phone'])) {
            return response()->json(['message' => 'Провайдер не найден'], 404);
        }

        $output = view('xml_templates.' . $provider . '_provider', ['apz' => $apz])->render();
        $xml = "<?xml version=\"1.0\" ?>\n" . $output;

        return response($xml, 200)->header('Content-Type', 'text/plain');
    }

    public function saveXml(Request $request, $role, $id)
    {
        try {
            $apz =  Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

            if (!$apz) {
                throw new \Exception('АПЗ не найден');
            }

            $output = view('xml_templates.' . $role . '_provider', ['apz' => $apz])->render();
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

            $iin = json_decode($response->getBody(), true);

            if ($iin != $user->iin) {
                return response()->json(['message' => 'Выбран ключ другого пользователя'], 500);
            }

            switch ($role) {
                case 'water':
                    $provider = ApzProviderWaterResponse::where(['apz_id' => $apz->id])->first();

                    if (!$provider) {
                        return response()->json(['message' => 'Не найден ответ от провайдера'], 500);
                    }

                    $file = File::addXmlItem('water_xml', FileCategory::XML_WATER, 'sign_files/' . $apz->id, $request->xml);

                    if (!$file) {
                        throw new \Exception('Не удалось сохранить модель File');
                    }

                    $file_item = FileItem::addItem($file, $provider->id, FileItemType::WATER_RESPONSE);

                    if (!$file_item) {
                        throw new \Exception('Не удалось сохранить модель FileItem');
                    }
                    break;

                case 'gas':
                    $provider = ApzProviderGasResponse::where(['apz_id' => $apz->id])->first();

                    if (!$provider) {
                        return response()->json(['message' => 'Не найден ответ от провайдера'], 500);
                    }

                    $file = File::addXmlItem('gas_xml', FileCategory::XML_GAS, 'sign_files/' . $id, $request->xml);

                    if (!$file) {
                        throw new \Exception('Не удалось сохранить модель File');
                    }

                    $file_item = FileItem::addItem($file, $provider->id, FileItemType::GAS_RESPONSE);

                    if (!$file_item) {
                        throw new \Exception('Не удалось сохранить модель FileItem');
                    }
                    break;

                case 'electricity':
                    $provider = ApzProviderElectricityResponse::where(['apz_id' => $apz->id])->first();

                    if (!$provider) {
                        return response()->json(['message' => 'Не найден ответ от провайдера'], 500);
                    }

                    $file = File::addXmlItem('electricity_xml', FileCategory::XML_ELECTRICITY, 'sign_files/' . $apz->id, $request->xml);

                    if (!$file) {
                        throw new \Exception('Не удалось сохранить модель File');
                    }

                    $file_item = FileItem::addItem($file, $provider->id, FileItemType::ELECTRICITY_RESPONSE);

                    if (!$file_item) {
                        throw new \Exception('Не удалось сохранить модель FileItem');
                    }
                    break;

                case 'heat':
                    $provider = ApzProviderHeatResponse::where(['apz_id' => $apz->id])->first();

                    if (!$provider) {
                        return response()->json(['message' => 'Не найден ответ от провайдера'], 500);
                    }

                    $file = File::addXmlItem('heat_xml', FileCategory::XML_HEAT, 'sign_files/' . $apz->id, $request->xml);

                    if (!$file) {
                        throw new \Exception('Не удалось сохранить модель File');
                    }

                    $file_item = FileItem::addItem($file, $provider->id, FileItemType::HEAT_RESPONSE);

                    if (!$file_item) {
                        throw new \Exception('Не удалось сохранить модель FileItem');
                    }
                    break;

                case 'phone':
                    $provider = ApzProviderPhoneResponse::where(['apz_id' => $apz->id])->first();

                    if (!$provider) {
                        return response()->json(['message' => 'Не найден ответ от провайдера'], 500);
                    }

                    $file = File::addXmlItem('phone_xml', FileCategory::XML_PHONE, 'sign_files/' . $apz->id, $request->xml);

                    if (!$file) {
                        throw new \Exception('Не удалось сохранить модель File');
                    }

                    $file_item = FileItem::addItem($file, $provider->id, FileItemType::PHONE_RESPONSE);

                    if (!$file_item) {
                        throw new \Exception('Не удалось сохранить модель FileItem');
                    }
                    break;

                default:
                    throw new \Exception('Роль не найдена');
            }

            return response()->json(['status' => true], '200');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
