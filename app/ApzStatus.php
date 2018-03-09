<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ApzStatus
 *
 * @property int $id
 * @property string $name Название
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApzStatus extends Model
{
    const DECLINED          = 1; // Отказано
    const ACCEPTED          = 2; // Принято
    const ARCHITECT         = 3; // Архитектор
    const ENGINEER          = 4; // Инженер
    const PROVIDER          = 5; // Провайдер
    const APZ_DEPARTMENT    = 6; // Отдел АПЗ
    const CHIEF_ARCHITECT   = 7; // Главный архитектор
}