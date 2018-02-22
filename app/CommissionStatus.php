<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 */
class CommissionStatus extends Model
{
    protected $table = 'commissions_statuses';

    const IN_PROCESS    = 1; // В процессе
    const FINISHED      = 2; // Завершен
}