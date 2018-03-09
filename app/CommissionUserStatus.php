<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CommissionUserStatus
 *
 * @property int $id
 * @property string $name Название
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUserStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUserStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUserStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionUserStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommissionUserStatus extends Model
{
    protected $table = 'commissions_users_statuses';

    const IN_PROCESS    = 1; // В процессе
    const ACCEPTED      = 2; // Принято
    const DECLINED      = 3; // Отказано
}