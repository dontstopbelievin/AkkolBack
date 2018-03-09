<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Commission
 *
 * @property int $id
 * @property int $apz_id ИД АПЗ
 * @property int|null $user_id ИД пользователя
 * @property int|null $status_id ИД статуса
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @property-read \App\ApzProviderElectricityResponse $apzElectricityResponse
 * @property-read \App\ApzProviderGasResponse $apzGasResponse
 * @property-read \App\ApzProviderHeatResponse $apzHeatResponse
 * @property-read \App\ApzProviderPhoneResponse $apzPhoneResponse
 * @property-read \App\ApzProviderWaterResponse $apzWaterResponse
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CommissionUser[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commission whereUserId($value)
 * @mixin \Eloquent
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
