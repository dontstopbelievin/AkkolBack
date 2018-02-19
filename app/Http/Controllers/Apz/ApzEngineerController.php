<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\Commission;
use App\CommissionUser;
use App\Http\Controllers\Controller;
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
        /**
         * TODO Переделать запросы. Временное решение
         */
        $process = Apz::where([
            'status_id' => ApzStatus::ENGINEER
        ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
            $query->whereIn('state_id', [ApzState::ENGINEER_APPROVED, ApzState::ENGINEER_DECLINED]);
        })->get();

        $accepted = Apz::where([
            'status_id' => ApzStatus::ENGINEER
        ])->with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
            $query->where('state_id', ApzState::ENGINEER_APPROVED);
        })->get();

        $declined = Apz::where([
            'status_id' => ApzStatus::ENGINEER
        ])->with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
            $query->where('state_id', ApzState::ENGINEER_DECLINED);
        })->get();

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
    public function show($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
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

        DB::beginTransaction();

        try {
            $apz->status_id = ApzStatus::PROVIDER;
            $apz->save();

            $commission = new Commission();
            $commission->apz_id = $apz->id;
            $commission->user_id = Auth::user()->id;
            $commission->is_active = true;
            $commission->save();

            foreach ($request['commission_users'] as $item) {
                $commission_user = new CommissionUser();
                $commission_user->commission_id = $commission->id;
                $commission_user->user_id = $item;
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
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
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
            $apz->status_id = $request["response"] == "true" ? ApzStatus::APZ_DEPARTMENT : ApzStatus::DECLINED;
            $apz->save();

            if ($request["response"] == "true") {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::ENGINEER_APPROVED;
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_APZ;
                $engineer_state->save();
            } else {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::ENGINEER_DECLINED;
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
}
