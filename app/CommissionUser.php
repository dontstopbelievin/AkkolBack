<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
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
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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
