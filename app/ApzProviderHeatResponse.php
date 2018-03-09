<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzProviderHeatResponse
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property string|null $resource Источник
 * @property string|null $trans_pressure Давление теплоносителя в тепловой камере
 * @property string|null $load_contract_num Тепловые нагрузки по договору
 * @property string|null $main_in_contract Отопление
 * @property string|null $ven_in_contract Вентиляция
 * @property string|null $water_in_contract Горячее водоснабжение
 * @property string|null $connection_point Точка подключения
 * @property string|null $addition Дополнительное
 * @property string $doc_number Номер документа
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Commission $commission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereAddition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereConnectionPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereLoadContractNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereMainInContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTransPressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereVenInContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereWaterInContract($value)
 * @mixin \Eloquent
 */
class ApzProviderHeatResponse extends Model
{
    protected $table = "apz_provider_heat_responses";

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
            FileItemType::HEAT_RESPONSE
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
