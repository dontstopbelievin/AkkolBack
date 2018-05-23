<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzHeadResponse;
use App\ApzProviderElectricityResponse;
use App\ApzProviderGasResponse;
use App\ApzProviderHeadResponse;
use App\ApzProviderHeatBlockResponse;
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
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApzProviderController extends Controller
{
    /**
     * Show apz list for region
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function all($provider)
    {
        switch ($provider) {
            case 'Water':
                $base_role = Role::WATER;
                $approved_state = ApzState::WATER_APPROVED;
                $declined_state = ApzState::WATER_DECLINED;
                $response = 'apzWaterResponse';
                $is_performer = Auth::user()->hasRole('PerformerWater');
                break;

            case 'Gas':
                $base_role = Role::GAS;
                $approved_state = ApzState::GAS_APPROVED;
                $declined_state = ApzState::GAS_DECLINED;
                $response = 'apzGasResponse';
                $is_performer = Auth::user()->hasRole('PerformerGas');
                break;

            case 'Electricity':
                $base_role = Role::ELECTRICITY;
                $approved_state = ApzState::ELECTRICITY_APPROVED;
                $declined_state = ApzState::ELECTRICITY_DECLINED;
                $response = 'apzElectricityResponse';
                $is_performer = Auth::user()->hasRole('PerformerElectricity');
                break;

            case 'Phone':
                $base_role = Role::PHONE;
                $approved_state = ApzState::PHONE_APPROVED;
                $declined_state = ApzState::PHONE_DECLINED;
                $response = 'apzPhoneResponse';
                $is_performer = Auth::user()->hasRole('PerformerPhone');
                break;

            case 'Heat':
                $base_role = Role::HEAT;
                $approved_state = ApzState::HEAT_APPROVED;
                $declined_state = ApzState::HEAT_DECLINED;
                $response = 'apzHeatResponse';
                $is_performer = Auth::user()->hasRole('PerformerHeat');
                break;

            default:
                return response()->json(['message' => 'Служба не найдена'], 500);
        }

        $apzs = Apz::where(['status_id' => ApzStatus::PROVIDER])
            ->with(Apz::getApzBaseRelationList())
            ->whereHas('commission.users', function($query) use ($base_role) {
                $query->where('role_id', $base_role);
            })->get();

        $result = ['in_process' => [], 'awaiting'=> [], 'accepted' => [], 'declined' => []];

        foreach ($apzs as $item) {
            $accepted = $item->stateHistory->filter(function ($value) use ($approved_state) {
                return $value->state_id == $approved_state;
            });

            $declined = $item->stateHistory->filter(function ($value) use ($declined_state) {
                return $value->state_id == $declined_state;
            });

            if (sizeof($accepted) > 0) {
                $result['accepted'][] = $item;
                continue;
            }

            if (sizeof($declined) > 0) {
                $result['declined'][] = $item;
                continue;
            }

            if ($item->status_id == ApzStatus::PROVIDER && $item->commission->$response && $is_performer) {
                $result['awaiting'][] = $item;
                continue;
            }

            if ($item->status_id == ApzStatus::PROVIDER) {
                $result['in_process'][] = $item;
                continue;
            }
        }

        return response()->json($result, 200);
    }

    /**
     * Show apz for region
     *
     * @param string $provider
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($provider, $id)
    {
        $query = Apz::where(['id' => $id])->with(Apz::getApzProviderRelationList());

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
     * @param Request $request
     * @param string $provider
     * @param integer $id
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
                $response->response = in_array($request['Response'], ['accept', 'answer']) ? true : false;
                $response->gen_water_req = $request['GenWaterReq'];
                $response->drinking_water = $request['DrinkingWater'];
                $response->prod_water = $request['ProdWater'];
                $response->fire_fighting_water_in = $request['FireFightingWaterIn'];
                $response->fire_fighting_water_out = $request['FireFightingWaterOut'];
                $response->connection_point = $request['ConnectionPoint'];
                $response->recommendation = $request['Recomendation'];
                $response->estimated_water_flow_rate = $request['EstimatedWaterFlowRate'];
                $response->existing_water_consumption = $request['ExistingWaterConsumption'];
                $response->sewage_estimated_water_flow_rate = $request['SewageEstimatedWaterFlowRate'];
                $response->sewage_existing_water_consumption = $request['SewageExistingWaterConsumption'];
                $response->water_pressure = $request['WaterPressure'];
                $response->water_customer_duties = $request['WaterCustomerDuties'];
                $response->sewage_customer_duties = $request['SewageCustomerDuties'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                if ($request['Response'] == 'accept') {
                    $custom_tc = FileItem::where(['item_type_id' => FileItemType::WATER_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                        $query->where('category_id', FileCategory::CUSTOM_TC);
                    })->first();

                    if ($custom_tc) {
                        Storage::delete($custom_tc->file->url);
                        $custom_tc->file->delete();
                        $custom_tc->delete();
                    }
                }

                if ($request->files) {
                    foreach ($request->files as $key => $value) {
                        if ($key == 'file') {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::WATER_RESPONSE, 'item_id' => $response->id])->get();
                        } else {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::WATER_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                                $query->where('category_id', FileCategory::CUSTOM_TC);
                            })->get();
                        }

                        if ($old_files) {
                            foreach ($old_files as $old_file) {
                                Storage::delete($old_file->file->url);

                                $old_file->file->delete();
                                $old_file->delete();
                            }
                        }

                        $file_name = md5($value->getClientOriginalName() . microtime());
                        $file_ext = $value->getClientOriginalExtension();
                        $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                        Storage::put($file_url, file_get_contents($value));

                        if (!Storage::disk('local')->exists($file_url)) {
                            return response()->json(['message' => 'Файл не сохранен'], 500);
                        }

                        $file = new File();
                        $file->name = $value->getClientOriginalName();
                        $file->url = $file_url;
                        $file->extension = $value->getClientOriginalExtension();
                        $file->content_type = $value->getClientMimeType();
                        $file->size = $value->getClientSize();
                        $file->hash = $file_name;
                        $file->category_id = in_array($request['Response'], ['accept', 'answer']) ? ($key == 'file' ? FileCategory::TECHNICAL_CONDITION : FileCategory::CUSTOM_TC) : FileCategory::MOTIVATED_REJECT;
                        $file->user_id = Auth::user()->id;
                        $file->save();

                        $file_item = new FileItem();
                        $file_item->file_id = $file->id;
                        $file_item->item_id = $response->id;
                        $file_item->item_type_id = FileItemType::WATER_RESPONSE;
                        $file_item->save();
                        $response->files;
                    }
                }

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
                $response->response = in_array($request['Response'], ['accept', 'answer']) ? true : false;
                $response->req_power = $request['ElecReqPower'];
                $response->phase = $request['ElecPhase'];
                $response->safe_category = $request['ElecSafeCategory'];
                $response->connection_point = $request['ConnectionPoint'];
                $response->recommendation = $request['Recomendation'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                if ($request['Response'] == 'accept') {
                    $custom_tc = FileItem::where(['item_type_id' => FileItemType::ELECTRICITY_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                        $query->where('category_id', FileCategory::CUSTOM_TC);
                    })->first();

                    if ($custom_tc) {
                        Storage::delete($custom_tc->file->url);
                        $custom_tc->file->delete();
                        $custom_tc->delete();
                    }
                }

                if ($request->files) {
                    foreach ($request->files as $key => $value) {
                        if ($key == 'file') {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::ELECTRICITY_RESPONSE, 'item_id' => $response->id])->get();
                        } else {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::ELECTRICITY_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                                $query->where('category_id', FileCategory::CUSTOM_TC);
                            })->get();
                        }

                        if ($old_files) {
                            foreach ($old_files as $old_file) {
                                Storage::delete($old_file->file->url);

                                $old_file->file->delete();
                                $old_file->delete();
                            }
                        }

                        $file_name = md5($value->getClientOriginalName() . microtime());
                        $file_ext = $value->getClientOriginalExtension();
                        $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                        Storage::put($file_url, file_get_contents($value));

                        if (!Storage::disk('local')->exists($file_url)) {
                            return response()->json(['message' => 'Файл не сохранен'], 500);
                        }

                        $file = new File();
                        $file->name = $value->getClientOriginalName();
                        $file->url = $file_url;
                        $file->extension = $value->getClientOriginalExtension();
                        $file->content_type = $value->getClientMimeType();
                        $file->size = $value->getClientSize();
                        $file->hash = $file_name;
                        $file->category_id = in_array($request['Response'], ['accept', 'answer']) ? ($key == 'file' ? FileCategory::TECHNICAL_CONDITION : FileCategory::CUSTOM_TC) : FileCategory::MOTIVATED_REJECT;
                        $file->user_id = Auth::user()->id;
                        $file->save();

                        $file_item = new FileItem();
                        $file_item->file_id = $file->id;
                        $file_item->item_id = $response->id;
                        $file_item->item_type_id = FileItemType::ELECTRICITY_RESPONSE;
                        $file_item->save();
                        $response->files;
                    }
                }

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
                $response->response = in_array($request['Response'], ['accept', 'answer']) ? true : false;
                $response->connection_point = $request['ConnectionPoint'];
                $response->gas_pipe_diameter = $request['GasPipeDiameter'];
                $response->assumed_capacity = $request['AssumedCapacity'];
                $response->reconsideration = $request['Reconsideration'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                if ($request['Response'] == 'accept') {
                    $custom_tc = FileItem::where(['item_type_id' => FileItemType::GAS_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                        $query->where('category_id', FileCategory::CUSTOM_TC);
                    })->first();

                    if ($custom_tc) {
                        Storage::delete($custom_tc->file->url);
                        $custom_tc->file->delete();
                        $custom_tc->delete();
                    }
                }

                if ($request->files) {
                    foreach ($request->files as $key => $value) {
                        if ($key == 'file') {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::GAS_RESPONSE, 'item_id' => $response->id])->get();
                        } else {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::GAS_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                                $query->where('category_id', FileCategory::CUSTOM_TC);
                            })->get();
                        }

                        if ($old_files) {
                            foreach ($old_files as $old_file) {
                                Storage::delete($old_file->file->url);

                                $old_file->file->delete();
                                $old_file->delete();
                            }
                        }

                        $file_name = md5($value->getClientOriginalName() . microtime());
                        $file_ext = $value->getClientOriginalExtension();
                        $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                        Storage::put($file_url, file_get_contents($value));

                        if (!Storage::disk('local')->exists($file_url)) {
                            return response()->json(['message' => 'Файл не сохранен'], 500);
                        }

                        $file = new File();
                        $file->name = $value->getClientOriginalName();
                        $file->url = $file_url;
                        $file->extension = $value->getClientOriginalExtension();
                        $file->content_type = $value->getClientMimeType();
                        $file->size = $value->getClientSize();
                        $file->hash = $file_name;
                        $file->category_id = in_array($request['Response'], ['accept', 'answer']) ? ($key == 'file' ? FileCategory::TECHNICAL_CONDITION : FileCategory::CUSTOM_TC) : FileCategory::MOTIVATED_REJECT;
                        $file->user_id = Auth::user()->id;
                        $file->save();

                        $file_item = new FileItem();
                        $file_item->file_id = $file->id;
                        $file_item->item_id = $response->id;
                        $file_item->item_type_id = FileItemType::GAS_RESPONSE;
                        $file_item->save();
                        $response->files;
                    }
                }

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
                $response->response = in_array($request['Response'], ['accept', 'answer']) ? true : false;
                $response->resource = $request['HeatResource'];
                $response->second_resource = $request['HeatSecondResource'];
                $response->load_contract_num = $request['HeatLoadContractNum'];
                $response->connection_point = $request['ConnectionPoint'];
                $response->addition = $request['Addition'];
                $response->doc_number = $request['DocNumber'];
                $response->name = $request["Name"];
                $response->area = $request["Area"];
                $response->transporter = $request["Transporter"];
                $response->main_in_contract = $request['HeatMainInContract'];
                $response->ven_in_contract = $request['HeatVenInContract'];
                $response->water_in_contract = $request['HeatWaterInContract'];
                $response->water_in_contract_max = $request['HeatWaterMaxInContract'];
                $response->two_pipe_tc_name = $request["Two_pipe_tc_name"];
                $response->two_pipe_pressure_in_tc = $request["Two_pipe_pressure_in_tc"];
                $response->two_pipe_pressure_in_sc = $request["Two_pipe_pressure_in_sc"];
                $response->two_pipe_pressure_in_rc = $request["Two_pipe_pressure_in_rc"];
                $response->heat_four_pipe_tc_name = $request["Heat_four_pipe_tc_name"];
                $response->heat_four_pipe_sc_name = $request["Heat_four_pipe_sc_name"];
                $response->heat_four_pipe_pressure_in_tc = $request["Heat_four_pipe_pressure_in_tc"];
                $response->heat_four_pipe_pressure_in_sc = $request["Heat_four_pipe_pressure_in_sc"];
                $response->heat_four_pipe_pressure_in_rc = $request["Heat_four_pipe_pressure_in_rc"];
                $response->water_four_pipe_pressure_in_tc = $request["Water_four_pipe_pressure_in_tc"];
                $response->water_four_pipe_pressure_in_sc = $request["Water_four_pipe_pressure_in_sc"];
                $response->water_four_pipe_pressure_in_rc = $request["Water_four_pipe_pressure_in_rc"];
                $response->temperature_chart = $request["Temperature_chart"];
                $response->reconcile_connections_with = $request["Reconcile_connections_with"];
                $response->connection_terms = $request["Connection_terms"];
                $response->heating_networks_design = $request["Heating_networks_design"];
                $response->final_heat_loads = $request["Final_heat_loads"];
                $response->heat_networks_relaying = $request["Heat_networks_relaying"];
                $response->condensate_return = $request["Condensate_return"];
                $response->thermal_energy_meters = $request["Thermal_energy_meters"];
                $response->heat_supply_system = $request["Heat_supply_system"];
                $response->heat_supply_system_note = $request["Heat_supply_system_note"];
                $response->connection_scheme = $request["Connection_scheme"];
                $response->connection_scheme_note = $request["Connection_scheme_note"];
                $response->negotiation = $request["Negotiation"];
                $response->technical_conditions_terms = $request["Technical_conditions_terms"];
                $response->save();

                if (json_decode($request['heatBlocks'])) {
                    if ($response->blocks) {
                        ApzProviderHeatBlockResponse::where(['response_id' => $response->id])->delete();
                    }

                    foreach (json_decode($request['heatBlocks']) as $item) {
                        $block = new ApzProviderHeatBlockResponse();
                        $block->response_id = $response->id;
                        $block->block_id = $item->id;
                        $block->main = $item->main;
                        $block->ven = $item->ven;
                        $block->water = $item->water;
                        $block->water_max = $item->waterMax;
                        $block->save();
                    }
                }

                if ($request['Response'] == 'accept') {
                    $custom_tc = FileItem::where(['item_type_id' => FileItemType::HEAT_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                        $query->where('category_id', FileCategory::CUSTOM_TC);
                    })->first();

                    if ($custom_tc) {
                        Storage::delete($custom_tc->file->url);
                        $custom_tc->file->delete();
                        $custom_tc->delete();
                    }
                }

                if ($request->files) {
                    foreach ($request->files as $key => $value) {
                        if ($key == 'file') {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::HEAT_RESPONSE, 'item_id' => $response->id])->get();
                        } else {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::HEAT_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                                $query->where('category_id', FileCategory::CUSTOM_TC);
                            })->get();
                        }

                        if ($old_files) {
                            foreach ($old_files as $old_file) {
                                Storage::delete($old_file->file->url);

                                $old_file->file->delete();
                                $old_file->delete();
                            }
                        }

                        $file_name = md5($value->getClientOriginalName() . microtime());
                        $file_ext = $value->getClientOriginalExtension();
                        $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                        Storage::put($file_url, file_get_contents($value));

                        if (!Storage::disk('local')->exists($file_url)) {
                            return response()->json(['message' => 'Файл не сохранен'], 500);
                        }

                        $file = new File();
                        $file->name = $value->getClientOriginalName();
                        $file->url = $file_url;
                        $file->extension = $value->getClientOriginalExtension();
                        $file->content_type = $value->getClientMimeType();
                        $file->size = $value->getClientSize();
                        $file->hash = $file_name;
                        $file->category_id = in_array($request['Response'], ['accept', 'answer']) ? ($key == 'file' ? FileCategory::TECHNICAL_CONDITION : FileCategory::CUSTOM_TC) : FileCategory::MOTIVATED_REJECT;
                        $file->user_id = Auth::user()->id;
                        $file->save();

                        $file_item = new FileItem();
                        $file_item->file_id = $file->id;
                        $file_item->item_id = $response->id;
                        $file_item->item_type_id = FileItemType::HEAT_RESPONSE;
                        $file_item->save();
                        $response->files;
                    }
                }

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
                $response->response = in_array($request['Response'], ['accept', 'answer']) ? true : false;
                $response->service_num = $request['ResponseServiceNum'];
                $response->capacity = $request['ResponseCapacity'];
                $response->sewage = $request['ResponseSewage'];
                $response->client_wishes = $request['ResponseClientWishes'];
                $response->doc_number = $request['DocNumber'];
                $response->save();

                if ($request['Response'] == 'accept') {
                    $custom_tc = FileItem::where(['item_type_id' => FileItemType::PHONE_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                        $query->where('category_id', FileCategory::CUSTOM_TC);
                    })->first();

                    if ($custom_tc) {
                        Storage::delete($custom_tc->file->url);
                        $custom_tc->file->delete();
                        $custom_tc->delete();
                    }
                }

                if ($request->files) {
                    foreach ($request->files as $key => $value) {
                        if ($key == 'file') {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::PHONE_RESPONSE, 'item_id' => $response->id])->get();
                        } else {
                            $old_files = FileItem::where(['item_type_id' => FileItemType::PHONE_RESPONSE, 'item_id' => $response->id])->whereHas('file', function($query) {
                                $query->where('category_id', FileCategory::CUSTOM_TC);
                            })->get();
                        }

                        if ($old_files) {
                            foreach ($old_files as $old_file) {
                                Storage::delete($old_file->file->url);

                                $old_file->file->delete();
                                $old_file->delete();
                            }
                        }

                        $file_name = md5($value->getClientOriginalName() . microtime());
                        $file_ext = $value->getClientOriginalExtension();
                        $file_url = 'provider_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

                        Storage::put($file_url, file_get_contents($value));

                        if (!Storage::disk('local')->exists($file_url)) {
                            return response()->json(['message' => 'Файл не сохранен'], 500);
                        }

                        $file = new File();
                        $file->name = $value->getClientOriginalName();
                        $file->url = $file_url;
                        $file->extension = $value->getClientOriginalExtension();
                        $file->content_type = $value->getClientMimeType();
                        $file->size = $value->getClientSize();
                        $file->hash = $file_name;
                        $file->category_id = in_array($request['Response'], ['accept', 'answer']) ? ($key == 'file' ? FileCategory::TECHNICAL_CONDITION : FileCategory::CUSTOM_TC) : FileCategory::MOTIVATED_REJECT;
                        $file->user_id = Auth::user()->id;
                        $file->save();

                        $file_item = new FileItem();
                        $file_item->file_id = $file->id;
                        $file_item->item_id = $response->id;
                        $file_item->item_type_id = FileItemType::PHONE_RESPONSE;
                        $file_item->save();
                        $response->files;
                    }
                }

                return response()->json($response, 200);

            default:
                return response()->json(['message' => 'Провайдер не найден'], 404);
        }
    }

    /**
     * ApzHead decision
     *
     * @param Request $request
     * @param string $role
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function headDecision(Request $request, $role, $id)
    {
        $user = Auth::user();
        $apz = Apz::where(['id' => $id])->first();

        if (!$apz || !$user->hasRole($role)) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $decision = new ApzProviderHeadResponse();
        $decision->apz_id = $apz->id;
        $decision->user_id = $user->id;
        $decision->role_id = $user->getRole($role)->id;
        $decision->comments = $request->comment;

        if (!$decision->save()) {
            return response()->json(['message' => 'Не удалось сохранить ответ'], 500);
        }

        $response = ApzProviderHeadResponse::with('user')->where(['apz_id' => $apz->id, 'role_id' => $user->getRole($role)->id])->get();

        return response()->json(['message' => 'Ответ успешно сохранен', 'head_responses' => $response], 200);
    }

    /**
     * Save apz
     *
     * @param string $provider
     * @param integer $id
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
                    $role = Role::WATER;

                    $apz->apzWater->status = $response->response ? 1 : 0 ;
                    $apz->apzWater->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::WATER_APPROVED : ApzState::WATER_DECLINED;
                    $provider_state->save();
                    break;

                case 'electro':
                    $response = ApzProviderElectricityResponse::where(['commission_id' => $commission->id])->first();
                    $role = Role::ELECTRICITY;

                    $apz->apzElectricity->status = $response->response ? 1 : 0 ;
                    $apz->apzElectricity->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::ELECTRICITY_APPROVED : ApzState::ELECTRICITY_DECLINED;
                    $provider_state->save();
                    break;

                case 'gas':
                    $response = ApzProviderGasResponse::where(['commission_id' => $commission->id])->first();
                    $role = Role::GAS;

                    $apz->apzGas->status = $response->response ? 1 : 0 ;
                    $apz->apzGas->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::GAS_APPROVED : ApzState::GAS_DECLINED;
                    $provider_state->save();
                    break;

                case 'heat':
                    $response = ApzProviderHeatResponse::where(['commission_id' => $commission->id])->first();
                    $role = Role::HEAT;

                    $apz->apzHeat->status = $response->response ? 1 : 0 ;
                    $apz->apzHeat->save();

                    $provider_state = new ApzStateHistory();
                    $provider_state->apz_id = $apz->id;
                    $provider_state->state_id = $response->response ? ApzState::HEAT_APPROVED : ApzState::HEAT_DECLINED;
                    $provider_state->save();
                    break;

                case 'phone':
                    $response = ApzProviderPhoneResponse::where(['commission_id' => $commission->id])->first();
                    $role = Role::PHONE;

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

            $commission_user = CommissionUser::where(['commission_id' => $commission->id, 'role_id' => $role])->first();
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
     * Generate xml
     *
     * @param string $provider
     * @param integer $id
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Save generated xml
     *
     * @param Request $request
     * @param string $role
     * @param integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function saveXml(Request $request, $role, $id)
    {
        try {
            $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

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

            $response = $client->post('http://89.218.17.203:3380/validate_xml', [
                'form_params' => [
                    'xml' => $request->xml
                ],
            ]);

            if (!$response->getStatusCode() == 200) {
                throw new \Exception('Не удалось пройти валидацию');
            }

//            $user = Auth::user();
//            $iin = json_decode($response->getBody(), true);
//
//            if ($iin != $user->iin) {
//                return response()->json(['message' => 'Выбран ключ другого пользователя'], 500);
//            }

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
        } catch (RequestException $e) {
            return response()->json(['message' => json_decode($e->getResponse()->getBody(), true)], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
