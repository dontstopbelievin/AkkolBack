<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzPhone
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float|null $service_num Количество ОТА и услуг в разбивке физ.лиц и юр.лиц
 * @property string|null $capacity Телефонная емкость
 * @property string|null $sewage Планируемая телефонная канализация
 * @property string|null $client_wishes Пожелания заказчика
 * @property int $status Статус (0-declined, 1-accepted, 2-active)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereClientWishes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereServiceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereSewage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzPhone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApzPhone extends Model
{
    protected $table = "apz_phones";

    /**
     * Add item in database
     *
     * @param Request $request
     * @param integer $apz_id
     *
     * @return self
     */
    public function saveItem($request, $apz_id)
    {
        $this->service_num = $request->phoneServiceNum;
        $this->capacity = $request->phoneCapacity;
        $this->sewage = $request->phoneSewage;
        $this->client_wishes = $request->phoneClientWishes;
        $this->apz_id = $apz_id;
        $this->save();

        return $this;
    }

    /**
     * Get user
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }
}