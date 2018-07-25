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
        $files = [
            FileCategory::IDENTITY_CARD => $request->personalIdFile,
            FileCategory::APPROVED_ASSIGNMENT => $request->confirmedTaskFile,
            FileCategory::TITLE_DOCUMENT => $request->titleDocumentFile,
            FileCategory::PAYMENT_PHONE => $request->paymentPhotoFile,
            FileCategory::SURVEY => $request->survey,
            FileCategory::JUSTIFICATION_CLAIMED_CAPACITY => $request->claimedCapacityJustification
        ];

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

            foreach ($files as $key => $value) {
                switch ($key) {
                    case FileCategory::IDENTITY_CARD:
                        $file_id = isset($request->personalIdFile['id']) ? $request->personalIdFile['id'] : null;
                        break;

                    case FileCategory::APPROVED_ASSIGNMENT:
                        $file_id = isset($request->confirmedTaskFile['id']) ? $request->confirmedTaskFile['id'] : null;
                        break;

                    case FileCategory::TITLE_DOCUMENT:
                        $file_id = isset($request->titleDocumentFile['id']) ? $request->titleDocumentFile['id'] : null;
                        break;

                    case FileCategory::PAYMENT_PHONE:
                        $file_id = isset($request->paymentPhotoFile['id']) ? $request->paymentPhotoFile['id'] : null;
                        break;

                    case FileCategory::SURVEY:
                        $file_id = isset($request->survey['id']) ? $request->survey['id'] : null;
                        break;

                    case FileCategory::JUSTIFICATION_CLAIMED_CAPACITY:
                        $file_id = isset($request->claimedCapacityJustification['id']) ? $request->claimedCapacityJustification['id'] : null;
                        break;

                    default:
                        throw new \Exception('Категория не найдена');
                }

                $file_id = (int)$file_id;

                $old_item = FileItem::where(['item_id' => $apz->id, 'item_type_id' => FileItemType::APZ])
                    ->whereHas('file', function($query) use ($key) {
                        $query->where(['category_id' => $key]);
                    })->first();

                if (($old_item && $file_id && ($old_item->file->id != $file_id)) || !$file_id && $old_item) {
                    $old_item->delete();
                }

                if (($file_id && !$old_item) || ($file_id && ($old_item->file->id != $file_id))) {
                    $file_item = new FileItem();
                    $file_item->file_id = $file_id;
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
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function all($status)
    {
        $apzs = Apz::where('user_id', Auth::user()->id);

        switch ($status) {
            case 'draft':
                $apzs->where('status_id', ApzStatus::DRAFT);
                break;

            case 'accepted':
                $apzs->where('status_id', ApzStatus::ACCEPTED);
                break;

            case 'declined':
                $apzs->where('status_id', ApzStatus::DECLINED);
                break;

            case 'active':
            default:
                $apzs->whereNotIn('status_id', [ApzStatus::ACCEPTED, ApzStatus::DECLINED, ApzStatus::DRAFT]);
                break;
        }

        return response()->json($apzs->orderBy('created_at', 'desc')->paginate(20), 200);
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
