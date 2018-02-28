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

        $query = Apz::where(['region' => $region->name])->with(Apz::getApzBaseRelationList());

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
        $result = ['in_process' => [], 'accepted' => [], 'declined' => []];

        foreach ($data as $item) {
            $in_process = $item->stateHistory->filter(function ($value) {
                return in_array($value->state_id, [ApzState::REGION_APPROVED, ApzState::REGION_DECLINED]);
            });

            $accepted = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::REGION_APPROVED;
            });

            $declined = $item->stateHistory->filter(function ($value) {
                return $value->state_id == ApzState::REGION_DECLINED;
            });

            if (sizeof($in_process) == 0) {
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
            $apz->status_id = $request["response"] == "true" ? ApzStatus::ENGINEER : ApzStatus::DECLINED;
            $apz->save();

            if ($request["response"] == "true") {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::REGION_APPROVED;
                $region_state->comment = $request["message"];
                $region_state->save();

                $engineer_state = new ApzStateHistory();
                $engineer_state->apz_id = $apz->id;
                $engineer_state->state_id = ApzState::TO_ENGINEER;
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
}
