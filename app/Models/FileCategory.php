<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\type;

class FileCategory extends Model
{
    protected $table = "files_categories";

    const SKETCH                    = 1; // Эскизный проект
    const APZ                       = 2; // Архитектурно-планировочное задание
    const IDENTITY_CARD             = 3; // Удостоверение личности
    const ATTORNEY_IDENTITY_CARD    = 4; // Удостоверение личности поверенного
    const POWER_OF_ATTORNEY         = 5; // Доверенность
    const BUDGET_PLAN               = 6; // Бюджетное планирование
    const USER_MANUAL               = 7; // Инструкция пользователя
    const REQUISITES                = 8; // Реквизиты
    const APPROVED_ASSIGNMENT       = 9; // Утвержденное задание
    const TITLE_DOCUMENT            = 10; // Правоустанавл. документ
    const MOTIVATED_REJECT          = 11; // Мотивированный отказ
    const TECHNICAL_CONDITION       = 12; // Техническое условие
}