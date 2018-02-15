<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzWater extends Model
{
    protected $table = "apz_waters";

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
        $this->requirement = $request->WaterRequirement;
        $this->drinking = $request->WaterDrinking;
        $this->production = $request->WaterProduction;
        $this->fire_fighting = $request->WaterFireFighting;
        $this->sewage = $request->WaterSewage;
        $this->save();

        return $this;
    }

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }
}
