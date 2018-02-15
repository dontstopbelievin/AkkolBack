<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class Commission extends Model
{
    protected $table = "commissions";

    /**
     * Get electricity response
     */
    public function apzElectricityResponse()
    {
        return $this->belongsTo(ApzProviderElectricityResponse::class);
    }

    /**
     * Get gas response
     */
    public function apzGasResponse()
    {
        return $this->belongsTo(ApzProviderGasResponse::class);
    }

    /**
     * Get heat response
     */
    public function apzHeatResponse()
    {
        return $this->belongsTo(ApzProviderHeatResponse::class);
    }

    /**
     * Get phone response
     */
    public function apzPhoneResponse()
    {
        return $this->belongsTo(ApzProviderPhoneResponse::class);
    }

    /**
     * Get water response
     */
    public function apzWaterResponse()
    {
        return $this->belongsTo(ApzProviderWaterResponse::class);
    }

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }
}
