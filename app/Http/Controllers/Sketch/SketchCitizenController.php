<?php

namespace App\Http\Controllers\Sketch;

use App\Http\Controllers\Controller;
use App\File;
use App\FileItem;
use App\FileItemType;
use App\Sketch;
use App\SketchStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SketchCitizenController extends Controller
{
    /**
     * Create sketch
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $sketch = new Sketch();
            $sketch->applicant = $request->applicant;
            $sketch->customer = $request->customer;
            $sketch->address = $request->address;
            $sketch->designer = $request->designer;
            $sketch->phone = $request->phone;
            $sketch->project_name = $request->project_name;
            $sketch->project_address = $request->project_address;
            $sketch->sketch_date = $request->sketch_date;
            $sketch->user_id = Auth::user()->id;
            $sketch->status_id = SketchStatus::IN_PROCESS;
            $sketch->save();

            if (sizeof($request->file_list) > 0) {
                foreach ($request->file_list as $item) {
                    $file = File::find($item);

                    if (!$file) {
                        throw new \Exception('Не удалось найти файл');
                    }

                    $file_item = new FileItem();
                    $file_item->file_id = $file->id;
                    $file_item->item_id = $sketch->id;
                    $file_item->item_type_id = FileItemType::SKETCH;
                    $file_item->save();
                }
            }

            DB::commit();
            return response()->json($sketch, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Show sketch list for user
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $sketches = Sketch::where('user_id', Auth::user()->id)->get();

        return response()->json($sketches, 200);
    }

    /**
     * Show sketch
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sketch = Sketch::with(['files', 'files.category'])->where([
            'id' => $id,
            'user_id' => Auth::user()->id
        ])->first();

        if (!$sketch) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($sketch, 200);
    }
}
