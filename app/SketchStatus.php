<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SketchStatus
 *
 * @property int $id
 * @property string $name Название
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SketchStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SketchStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SketchStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SketchStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SketchStatus extends Model
{
    const DECLINED          = 1; // Отказано
    const ACCEPTED          = 2; // Принято
    const IN_PROCESS        = 3; // В процессе
}