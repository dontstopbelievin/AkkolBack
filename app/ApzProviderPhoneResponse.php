<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzProviderPhoneResponse
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property float|null $service_num Количество ОТА и услуг в разбивке физ.лиц и юр.лиц
 * @property string|null $capacity Телефонная емкость
 * @property string|null $sewage Планируемая телефонная канализация
 * @property string|null $client_wishes Пожелания заказчика
 * @property string $doc_number
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Commission $commission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereClientWishes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereServiceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereSewage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderPhoneResponse whereUserId($value)
 * @mixin \Eloquent
 */
class ApzProviderPhoneResponse extends Model
{
    protected $table = "apz_provider_phone_responses";

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
            FileItemType::PHONE_RESPONSE
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
