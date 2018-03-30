<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\CommissionUser
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int|null $role_id ИД роли
 * @property int|null $status_id ИД статуса
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Commission $commission
 * @property-read \App\Role $role
 * @property-read \App\CommissionUserStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUser whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUser whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommissionUser extends Model
{
    protected $table = "commissions_users";

    /**
     * Add item in database
     *
     * @param Request $request
     *
     * @return self
     */
    public function addItem($request)
    {
    }

    /**
     * Get commission
     */
    public function commission()
    {
        return $this->hasOne(Commission::class, 'id', 'commission_id');
    }

    /**
     * Get role
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     * Get role
     */
    public function status()
    {
        return $this->hasOne(CommissionUserStatus::class, 'id', 'status_id');
    }
}
