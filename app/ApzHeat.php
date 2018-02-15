<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzHeat extends Model
{
    protected $table = "apz_heats";

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
        $this->general = $request->HeatGeneral;
        $this->main = $request->HeatMain;
        $this->ventilation = $request->HeatVentilation;
        $this->water = $request->HeatWater;
        $this->tech = $request->HeatTech;
        $this->distribution = $request->HeatDistribution;
        $this->saving = $request->HeatSaving;
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