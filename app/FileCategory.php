<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\type;

/**
 * App\FileCategory
 *
 * @property int $id ИД
 * @property string $name_ru Название на русском
 * @property string $name_kz Название на казахском
 * @property string|null $description_ru Описание на русском
 * @property string|null $description_kz Описание на казахском
 * @property string $allowed_ext Разрешенные расширение файлов
 * @property int $is_visible Флаг видимости
 * @property int|null $role_id ИД роли
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereAllowedExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
    const XML_WATER                 = 13; // XML Водоснабжение
    const XML_GAS                   = 14; // XML Газоснабжение
    const XML_ELECTRICITY           = 15; // XML Электроснабжение
    const XML_HEAT                  = 16; // XML Теплоснабжение
    const XML_PHONE                 = 17; // XML Телефонизация
    const XML_APZ                   = 18; // XML Отдел АПЗ
    const XML_HEAD                  = 19; // XML Главный архитектор
    const XML_REGION                = 20; // XML регионального архитектора
    const PAYMENT_PHONE             = 21; // Скан оплаты телефонизации
}