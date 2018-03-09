<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * App\ApzProviderWaterResponse
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property float $gen_water_req Общая потребность в воде
 * @property float $drinking_water На хозпитьевые нужды
 * @property float $prod_water На производственные нужды
 * @property float $fire_fighting_water_in Потребные расходы внутреннего пожаротушения
 * @property float $fire_fighting_water_out Потребные расходы наружного пожаротушения
 * @property string|null $connection_point Точка подключения
 * @property string|null $recommendation Рекомендация
 * @property string $doc_number Номер документа
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Commission $commission
 * @property-read \App\CommissionUser $commissionUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereConnectionPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereDrinkingWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereFireFightingWaterIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereFireFightingWaterOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereGenWaterReq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereProdWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderWaterResponse whereUserId($value)
 * @mixin \Eloquent
 */
class ApzProviderWaterResponse extends Model
{
    protected $table = "apz_provider_water_responses";

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
            FileItemType::WATER_RESPONSE
        );
    }

    /**
     * Get commission
     */
    public function commissionUser()
    {
        return $this->hasOne(CommissionUser::class, 'commission_id', 'commission_id')->where('user_id', 'user_id');
    }

    /**
     * Get commission
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
