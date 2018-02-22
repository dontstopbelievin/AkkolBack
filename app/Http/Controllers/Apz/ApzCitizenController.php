<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzElectricity;
use App\ApzGas;
use App\ApzHeat;
use App\ApzPhone;
use App\ApzSewage;
use App\ApzWater;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileCategory;
use App\FileItem;
use App\FileItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApzCitizenController extends Controller
{
    /**
     * Create Apz
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $apz = new Apz();
            $apz->addItem($request);

            $apz_water = new ApzWater();
            $apz_water->addItem($request, $apz->id);

            $apz_electricity = new ApzElectricity();
            $apz_electricity->addItem($request, $apz->id);

            $apz_gas = new ApzGas();
            $apz_gas->addItem($request, $apz->id);

            $apz_heat = new ApzHeat();
            $apz_heat->addItem($request, $apz->id);

            $apz_phone = new ApzPhone();
            $apz_phone->addItem($request, $apz->id);

            $apz_sewage = new ApzSewage();
            $apz_sewage->addItem($request, $apz->id);

            DB::commit();
            return response()->json($apz, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
        }
    }

    /**
     * Upload files
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $apz = Apz::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
        $userId = Auth::user()->id;

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        DB::beginTransaction();

        try {
            foreach ($request->files as $key => $value) {
                $fileName = md5($value->getClientOriginalName() . microtime());
                $fileExt = $value->getClientOriginalExtension();
                $fileUrl = 'usersfiles/' . $userId . '/apz/' . $apz->id . '/' . $fileName . '.' . $fileExt;

                Storage::put($fileUrl, file_get_contents($value));

                if (!Storage::disk('local')->exists($fileUrl)) {
                    throw new \Exception('Файл не сохранен');
                }

                $file = new File();
                $file->name = $value->getClientOriginalName();
                $file->url = $fileUrl;
                $file->extension = $value->getClientOriginalExtension();
                $file->content_type = $value->getClientMimeType();
                $file->size = $value->getClientSize();
                $file->hash = $fileName;
                $file->category_id = $key == 'PersonalIdFile' ? FileCategory::IDENTITY_CARD : ($key == 'ConfirmedTaskFile' ? FileCategory::APPROVED_ASSIGNMENT : FileCategory::TITLE_DOCUMENT);
                $file->user_id = $userId;
                $file->save();

                $file_item = new FileItem();
                $file_item->file_id = $file->id;
                $file_item->item_id = $apz->id;
                $file_item->item_type_id = FileItemType::APZ;
                $file_item->save();
            }

            DB::commit();
            return response()->json(['message' => 'Файлы успешно сохранены'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show apz list for user
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $apzs = Apz::where('user_id', Auth::user()->id)->get();

        return response()->json($apzs, 200);
    }

    /**
     * Show apz
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apz = Apz::where([
            'id' => $id,
            'user_id' => Auth::user()->id
        ])
        //->with('apzElectricity', 'apzGas', 'apzHeat', 'apzPhone', 'apzSewage', 'apzWater', 'files')
        ->with(Apz::getApzBaseRelationList())
        ->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
    }
}
