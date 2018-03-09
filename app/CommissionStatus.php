<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CommissionStatus
 *
 * @property int $id
 * @property string $name Название
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommissionStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommissionStatus extends Model
{
    protected $table = 'commissions_statuses';

    const IN_PROCESS    = 1; // В процессе
    const FINISHED      = 2; // Завершен
}