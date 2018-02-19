<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
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