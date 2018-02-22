<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzHeadResponse;
use App\ApzState;
use App\ApzStateHistory;
use App\ApzStatus;
use App\FileItem;
use App\FileItemType;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApzHeadController extends Controller
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
            'status_id' => ApzStatus::CHIEF_ARCHITECT
        ])->with(Apz::getApzBaseRelationList())->whereDoesntHave('stateHistory', function($query) {
            $query->whereIn('state_id', [ApzState::HEAD_APPROVED, ApzState::HEAD_DECLINED]);
        })->get();

        $accepted = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
            $query->where('state_id', ApzState::HEAD_APPROVED);
        })->get();

        $declined = Apz::with(Apz::getApzBaseRelationList())->whereHas('stateHistory', function($query) {
            $query->where('state_id', ApzState::HEAD_DECLINED);
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
     * Region decision
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request, $id)
    {
        $apz = Apz::where('id', $id)->first();
        $file_request = $request->file('file');
        $request = $request->all();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            $apz->status_id = $request["Response"] == "true" ? ApzStatus::ACCEPTED : ApzStatus::DECLINED;
            $apz->save();

            $response = new ApzHeadResponse();
            $response->apz_id = $apz->id;
            $response->user_id = Auth::user()->id;
            $response->response_text = $request['Message'];
            $response->response = ($request["Response"] == "true") ? true : false;
            $response->doc_number = $request["DocNumber"];
            $response->save();

            if ($request["Response"] == "true") {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::HEAD_APPROVED;
                $region_state->save();
            } else {
                $region_state = new ApzStateHistory();
                $region_state->apz_id = $apz->id;
                $region_state->state_id = ApzState::HEAD_DECLINED;
                $region_state->comment = $request["Message"];
                $region_state->save();
            }

            $file_name = md5($file_request->getClientOriginalName() . microtime());
            $file_ext = $file_request->getClientOriginalExtension();
            $file_url = 'head_responses/' . $apz->id . '/' . $file_name . '.' . $file_ext;

            Storage::put($file_url, file_get_contents($file_request));

            if (!Storage::disk('local')->exists($file_url)) {
                throw new \Exception('Файл не сохранен');
            }

            $file = new File();
            $file->name = $file_request->getClientOriginalName();
            $file->url = $file_url;
            $file->extension = $file_request->getClientOriginalExtension();
            $file->content_type = $file_request->getClientMimeType();
            $file->size = $file_request->getClientSize();
            $file->hash = $file_name;
            $file->category_id = ($request["Response"] == "true") ? FileCategory::TECHNICAL_CONDITION : FileCategory::MOTIVATED_REJECT;
            $file->user_id = Auth::user()->id;
            $file->save();

            $file_item = new FileItem();
            $file_item->file_id = $file->id;
            $file_item->item_id = $response->id;
            $file_item->item_type_id = FileItemType::HEAD_RESPONSE;
            $file_item->save();

            DB::commit();
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getTrace()], 500);
        }
    }
}
