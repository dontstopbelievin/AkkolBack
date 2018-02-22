<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileItemType extends Model
{
    protected $table = 'files_items_types';

    const APZ                   = 1; // Архитектурно-планировочное задание
    const SKETCH                = 2; // Эскизный проект
    const PHOTO_REPORT          = 3; // Фотоотчеты
    const WATER_RESPONSE        = 4; // ТУ/МО Водоснабжение
    const GAS_RESPONSE          = 5; // ТУ/МО Газоснабжение
    const PHONE_RESPONSE        = 6; // ТУ/МО Телефонизация
    const ELECTRICITY_RESPONSE  = 7; // ТУ/МО Электроснабжение
    const HEAT_RESPONSE         = 8; // ТУ/МО Теплоснабжение
    const HEAD_RESPONSE         = 9; // ТУ/МО Главный архитектор
}
