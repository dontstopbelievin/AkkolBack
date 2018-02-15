<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzElectricity extends Model
{
    protected $table = "apz_electricity";

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
        $this->required_power = $request->ElectricRequiredPower;
        $this->phase = $request->ElectricityPhase;
        $this->safety_category = $request->ElectricSafetyCategory;
        $this->max_load_device = $request->ElectricMaxLoadDevice;
        $this->max_load = $request->ElectricMaxLoad;
        $this->allowed_power = $request->ElectricAllowedPower;
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