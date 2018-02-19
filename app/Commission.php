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
        return $this->hasOne(ApzProviderElectricityResponse::class, 'commission_id' , 'id');
    }

    /**
     * Get gas response
     */
    public function apzGasResponse()
    {
        return $this->hasOne(ApzProviderGasResponse::class, 'commission_id' , 'id');
    }

    /**
     * Get heat response
     */
    public function apzHeatResponse()
    {
        return $this->hasOne(ApzProviderHeatResponse::class, 'commission_id' , 'id');
    }

    /**
     * Get phone response
     */
    public function apzPhoneResponse()
    {
        return $this->hasOne(ApzProviderPhoneResponse::class, 'commission_id' , 'id');
    }

    /**
     * Get water response
     */
    public function apzWaterResponse()
    {
        return $this->hasOne(ApzProviderWaterResponse::class, 'commission_id' , 'id');
    }

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }

    /**
     * Get apz
     */
    public function users()
    {
        return $this->hasMany(CommissionUser::class, 'commission_id', 'id');
    }
}
