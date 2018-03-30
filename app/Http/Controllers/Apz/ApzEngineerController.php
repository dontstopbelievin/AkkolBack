<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\Commission;
use App\CommissionUser;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApzEngineerController extends Controller
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
                return in_array($value->state_id, [ApzState::ENGINEER_APPROVED, ApzState::ENGINEER_DECLINED]);
            });

            $accepted = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::ENGINEER_APPROVED;
            });

            $declined = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::ENGINEER_DECLINED;
            });

            if (sizeof($in_process) == 0 && in_array($item->status_id, [ApzStatus::ENGINEER, ApzStatus::PROVIDER])) {
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
        $apz = Apz::where(['id' => $id])->with(Apz::getApzEngineerRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
    }

    /**
     * Get commission
     *
     * @return \Illuminate\Http\Response
     */
    public function getCommission($apz_id)
    {
        $apz = Apz::where(['id' => $apz_id])->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $commission = Commission::where(['apz_id' => $apz_id])->with([
            'apzElectricityResponse.files',
            'apzGasResponse.files',
            'apzHeatResponse.files',
            'apzPhoneResponse.files',
            'apzWaterResponse.files',
            'users.role',
        ])->first();

        return response()->json($commission, 200);
    }

    /**
     * Create commission
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function createCommission(Request $request, $id)
    {
        $apz = Apz::where('id', $id)->first();
        $request = $request->all();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        if (sizeof($request['commission_users']) == 0) {
            return response()->json(['message' => 'Не выбран пользователь'], 500);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = ApzStatus::PROVIDER;
            $apz->save();

            $commission = new Commission();
            $commission->apz_id = $apz->id;
            $commission->user_id = Auth::user()->id;
            $commission->save();

            foreach ($request['commission_users'] as $value) {
                $role = Role::where(['name' => $value])->first();

                $commission_user = new CommissionUser();
                $commission_user->commission_id = $commission->id;
                $commission_user->role_id = $role->id;
                $commission_user->save();
            }

            $state_history = new ApzStateHistory();
            $state_history->apz_id = $apz->id;
            $state_history->state_id = ApzState::TO_PROVIDERS;
            $state_history->save();

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Engineer decision
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
            $apz->status_id = $request["response"] == "true" ? ApzStatus::APZ_DEPARTMENT : ApzStatus::ARCHITECT;
            $apz->save();

            if ($request["response"] == "true") {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::ENGINEER_APPROVED;
                $region_state->comment = $request["message"];
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_APZ;
                $engineer_state->comment = $request["message"];
                $engineer_state->save();
            } else {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::ENGINEER_DECLINED;
                $region_state->comment = $request["message"];
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_REGION;
                $engineer_state->comment = $request["message"];
                $engineer_state->save();
            }

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
