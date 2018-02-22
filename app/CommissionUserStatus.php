<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 */
class CommissionUserStatus extends Model
{
    protected $table = 'commissions_users_statuses';

    const IN_PROCESS    = 1; // В процессе
    const ACCEPTED      = 2; // Принято
    const DECLINED      = 3; // Отказано
}