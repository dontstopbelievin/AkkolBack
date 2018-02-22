<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\Http\Controllers\Controller;
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
        /**
         * TODO Переделать запросы. Временное решение
         */
        $process = Apz::where([
            'status_id' => ApzStatus::APZ_DEPARTMENT
        ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
            $query->whereIn('state_id', [ApzState::APZ_APPROVED, ApzState::APZ_DECLINED]);
        })->get();

        $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
            $query->where('state_id', ApzState::APZ_APPROVED);
        })->get();

        return response()->json([
            'in_process' => $process,
            'accepted' => $accepted,
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
     * Region decision
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function decision($id)
    {
        $apz = Apz::where('id', $id)->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = ApzStatus::CHIEF_ARCHITECT;
            $apz->save();

            $region_state = new ApzStateHistory();
            $region_state->apz_id = $apz->id;
            $region_state->state_id = ApzState::APZ_APPROVED;
            $region_state->save();

            $engineer_state = new ApzStateHistory();
            $engineer_state->apz_id = $apz->id;
            $engineer_state->state_id = ApzState::TO_HEAD;
            $engineer_state->save();

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
        }
    }
}
