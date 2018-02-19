<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzProviderElectricityResponse extends Model
{
    protected $table = "apz_provider_electricity_responses";

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
    }

    /**
     * Get commission
     */
    public function commission()
    {
        return $this->hasOne(Commission::class, 'id', 'commission_id');
    }
}