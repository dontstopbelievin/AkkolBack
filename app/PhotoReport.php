<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\type;

/**
 * App\PhotoReport
 *
 * @property int $id
 * @property string $company_name Наименование компании
 * @property string $company_legal_address Юридический адрес компании
 * @property string $company_factual_address Дата заявки
 * @property string $photo_address Адрес рекламы
 * @property string $company_region Регион компании
 * @property string $iin ИИН
 * @property string $company_phone Телефон компании
 * @property string $start_date Период с
 * @property string $end_date Период до
 * @property int|null $status_id Статус
 * @property string $comments Комментарий
 * @property int|null $user_id Заявитель
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereCompanyFactualAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereCompanyLegalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereCompanyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereCompanyRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereIin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport wherePhotoAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PhotoReport whereUserId($value)
 * @mixin \Eloquent
 */
class PhotoReport extends Model
{
    protected $table = 'photoreports';
}
