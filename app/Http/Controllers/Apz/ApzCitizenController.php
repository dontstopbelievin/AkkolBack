<?php

namespace App\Http\Controllers\Apz;

use App\Apz;
use App\ApzElectricity;
use App\ApzGas;
use App\ApzHeat;
use App\ApzPhone;
use App\ApzSewage;
use App\ApzStatus;
use App\ApzWater;
use App\Http\Controllers\Controller;
use App\File;
use App\FileCategory;
use App\FileItem;
use App\FileItemType;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApzCitizenController extends Controller
{
    /**
     * Save Apz
     *
     * @param Request $request
     * @param integer|boolean $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id = false)
    {
        DB::beginTransaction();

        try {
            $apz = $id ? Apz::where(['id' => $id, 'status_id' => ApzStatus::DRAFT])->firstOrFail() : new Apz();

            if ($apz->saveItem($request)) {
                $apz_water = $apz->apzWater ? $apz->apzWater : new ApzWater();
                $apz_water->saveItem($request, $apz->id);

                $apz_electricity = $apz->apzElectricity ? $apz->apzElectricity : new ApzElectricity();
                $apz_electricity->saveItem($request, $apz->id);

                $apz_gas = $apz->apzGas ? $apz->apzGas : new ApzGas();
                $apz_gas->saveItem($request, $apz->id);

                $apz_heat = $apz->apzHeat ? $apz->apzHeat : new ApzHeat();
                $apz_heat->saveItem($request, $apz->id);

                $apz_phone = $apz->apzPhone ? $apz->apzPhone : new ApzPhone();
                $apz_phone->saveItem($request, $apz->id);

                $apz_sewage = $apz->apzSewage ? $apz->apzSewage : new ApzSewage();
                $apz_sewage->saveItem($request, $apz->id);
            }

            if (count($request->files) > 0) {
                foreach ($request->files as $key => $value) {
                    $file_name = md5($value->getClientOriginalName() . microtime());
                    $file_ext = $value->getClientOriginalExtension();
                    $category = $key == 'personalIdFile' ? FileCategory::IDENTITY_CARD : ($key == 'confirmedTaskFile' ? FileCategory::APPROVED_ASSIGNMENT : ($key == 'titleDocumentFile' ? FileCategory::TITLE_DOCUMENT : ($key == 'paymentPhotoFile' ? FileCategory::PAYMENT_PHONE : FileCategory::SURVEY)));

                    // Удаление старого файла
                    $old_file_list = $apz->files->filter(function ($value) use ($category) {
                        return $value->category_id == $category;
                    });

                    if (sizeof($old_file_list) > 0) {
                        $old_file = $old_file_list->first();

                        if (File::destroy($old_file->id)) {
                            Storage::delete($old_file->url);
                        }
                    }

                    $fileUrl = 'usersfiles/' . Auth::user()->id . '/apz/' . $apz->id . '/' . $file_name . '.' . $file_ext;

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
                    $file->hash = $file_name;
                    $file->category_id = $category;
                    $file->user_id = Auth::user()->id;
                    $file->save();

                    $file_item = new FileItem();
                    $file_item->file_id = $file->id;
                    $file_item->item_id = $apz->id;
                    $file_item->item_type_id = FileItemType::APZ;
                    $file_item->save();
                }
            }

            DB::commit();
            return response()->json($apz, 200);
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

    /**
     * Search company
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function companySearch(Request $request)
    {
        $client = new Client();

        $response = $client->post('http://www.elicense.kz/LicensingContent/SimpleSearchLicense', [
            'form_params' => [
                'IinBinEquality' => '1',
                'IinBinStr' => $request->bin,
                'lang' => 'ru'
            ],
        ]);

        $body = $response->getBody();
        $start = strpos($body,"<table class=\"DefaultTablde\">");
        $end = strpos($body,"table",$start + 10) + 8;

        if ($start == null) {
            return null;
        }

        $result = substr($body, $start, $end - $start);

        $sxe = simplexml_load_string($result);

        if ($sxe === false) {
            echo 'Ошибка при разборе документа';
            exit;
        }

        $items = $sxe->xpath("/table/tr");
        $array = [];

        foreach ($items as $key => $node) {
            if ($key == 0) {
                continue;
            }

            // $key - 1 обязателен. Без него метод будет возвращать объект вместо массива
            $array[$key - 1] = [
                'license_number' => (string)$node->td[1],
                'document_id' => (string)$node->td[2],
                'nicad' => (string)$node->td[3],
                'offer_id' => (string)$node->td[4],
                'offer_nicad' => (string)$node->td[5],
                'licensor' => (string)$node->td[6],
                'licensee' => (string)$node->td[7],
                'kind_of_activity' => (string)$node->td[8],
                'status' => (string)$node->td[9]->span
            ];
        }

        return response()->json(['list' => $array], 200);
    }
}
