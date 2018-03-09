<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzProviderElectricityResponse
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property string|null $req_power Требуемая мощность
 * @property string|null $phase Характер нагрузки
 * @property string|null $safe_category Категория по надежности
 * @property string|null $connection_point Точка подключения
 * @property string|null $recommendation Рекомендация
 * @property string $doc_number Номер документа
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Commission $commission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereConnectionPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse wherePhase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereReqPower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereSafeCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderElectricityResponse whereUserId($value)
 * @mixin \Eloquent
 */
class ApzProviderElectricityResponse extends Model
{
    protected $table = "apz_provider_electricity_responses";

    /**
     * Add item in database
     *
     * @param Request $request
     * @param integer $apz_id
     *
     * @return self
     */
    public function addItem($request, $apz_id)
    {
    }

    /**
     * Get commission
     */
    public function commission()
    {
        return $this->hasOne(Commission::class, 'id', 'commission_id');
    }

    /**
     * Get files
     */
    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'files_items',
            'item_id',
            'file_id'
        )->wherePivot(
            'item_type_id',
            FileItemType::ELECTRICITY_RESPONSE
        );
    }

    /**
     * Get commission
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
