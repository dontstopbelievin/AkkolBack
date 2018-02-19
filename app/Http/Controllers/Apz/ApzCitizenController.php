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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        ->with('apzElectricity', 'apzGas', 'apzHeat', 'apzPhone', 'apzSewage', 'apzWater')
        ->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        return response()->json($apz, 200);
    }
}
