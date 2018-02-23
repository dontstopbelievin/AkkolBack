<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzGas extends Model
{
    protected $table = "apz_gases";

    /**
     * Add item in database
     *
     * @param Request $request
     * @param integer $apz_id
     *
     * @return self
     */
    public function addItem($request, $apz_id)
    {
        $this->apz_id = $apz_id;
        $this->general = $request->GasGeneral;
        $this->cooking = $request->GasCooking;
        $this->heat = $request->GasHeat;
        $this->ventilation = $request->GasVentilation;
        $this->conditioner = $request->GasConditioner;
        $this->water = $request->GasWater;
        $this->save();

        return $this;
    }

    /**
     * Get user
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }
}
