<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FileItemType
 *
 * @property int $id ИД
 * @property string $name Название
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItemType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItemType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItemType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FileItemType extends Model
{
    protected $table = 'files_items_types';

    const APZ                               = 1; // Архитектурно-планировочное задание
    const SKETCH                            = 2; // Эскизный проект
    const PHOTO_REPORT                      = 3; // Фотоотчеты
    const WATER_RESPONSE                    = 4; // ТУ/МО Водоснабжение
    const GAS_RESPONSE                      = 5; // ТУ/МО Газоснабжение
    const PHONE_RESPONSE                    = 6; // ТУ/МО Телефонизация
    const ELECTRICITY_RESPONSE              = 7; // ТУ/МО Электроснабжение
    const HEAT_RESPONSE                     = 8; // ТУ/МО Теплоснабжение
    const HEAD_RESPONSE                     = 9; // ТУ/МО Главный архитектор
    const APZ_DEPARTMENT_RESPONSE           = 10; // Ответ от отдела АПЗ
    const SKETCH_APZ_DEPARTMENT_RESPONSE    = 11; // Ответ от отдела АПЗ (эскизный проект)
}
