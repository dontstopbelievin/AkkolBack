<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApzDepartmentResponse extends Model
{
    protected $table = "apz_apz_department_responses";

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }

    /**
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
