<?php

namespace App\Http\Controllers;

use App\Apz;
use App\ApzElectricity;
use App\ApzGas;
use App\ApzHeat;
use App\ApzPhone;
use App\ApzSewage;
use App\ApzWater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApzController extends Controller
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
            return response()->json(['message' => 'Заявка успешно отправлена'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Не удалось отправить заявку'], 500);
        }
    }

    /**
     * Show apz list for user
     *
     * @return \Illuminate\Http\Response
     */
    public function getApzByUser()
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
    public function getApzDetail($id)
    {
        $apz = Apz::where([
            'id' => $id,
            'user_id' => Auth::user()->id
        ])
        ->with('apz_electricity', 'apz_gas', 'apz_heat', 'apz_phone', 'apz_sewage', 'apz_water')
        ->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
    }

    /**
     * Show apz list for region
     *
     * @return \Illuminate\Http\Response
     */
    public function getApzByRegion()
    {
        $region = Auth::user()->roles()->where('level', 3)->first();

        if (!$region) {
            return response()->json(['message' => 'У вас недостаточно прав для доступа к данной странице'], 403);
        }

        $apzs = Apz::where([
            'region' => $region->name
        ])->with([
            'apzElectricity',
            'apzGas',
            'apzHeat',
            'apzPhone',
            'apzSewage',
            'apzWater',
            'commission.apzElectricityResponse',
            'commission.apzGasResponse',
            'commission.apzHeatResponse',
            'commission.apzPhoneResponse',
            'commission.apzWaterResponse',
        ])->get();

        return response()->json($apzs, 200);
    }

}
