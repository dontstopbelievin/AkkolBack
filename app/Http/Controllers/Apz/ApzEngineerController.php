<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\Commission;
use App\CommissionStatus;
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
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function all($status)
    {
        $data = Apz::with(Apz::getApzBaseRelationList());

        switch ($status) {
            case 'awaiting':
                $data->where('status_id', ApzStatus::PROVIDER);
                break;

            case 'accepted':
                $data->whereHas('stateHistory', function ($query) {
                    $query->where('state_id', ApzState::ENGINEER_APPROVED);
                });
                break;

            case 'declined':
                $data->whereHas('stateHistory', function ($query) {
                    $query->where('state_id', ApzState::ENGINEER_DECLINED);
                });
                break;

            case 'active':
            default:
                $data->where('status_id', ApzStatus::ENGINEER);
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
        $apz = Apz::where(['id' => $id])->with(Apz::getApzEngineerRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        if ($apz->commission) {
            foreach ($apz->commission->users as $user) {
                $user['days'] = holidayDiffInDays($user->created_at, null, 2);
            }
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
            $commission->comment = $request['comment'];
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
            $apz->status_id = $request['direct'] == 'apz' ? ApzStatus::APZ_DEPARTMENT : ApzStatus::ARCHITECT;
            $apz->save();

            $commission = Commission::where(['apz_id' => $id])->first();

            if ($commission) {
                $commission->status_id = CommissionStatus::FINISHED;
                $commission->save();
            }

            if ($request["response"] == "true") {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::ENGINEER_APPROVED;
                $region_state->comment = $request["message"];
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = $request['direct'] == 'apz' ? ApzState::TO_APZ : ApzState::TO_REGION;
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
