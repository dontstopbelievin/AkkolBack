<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzSewage
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float $amount Общее количество сточных вод
 * @property float $amount_hour Общее количество сточных вод (м3/час макс)
 * @property float|null $feksal Фекcальных
 * @property float|null $feksal_hour Фекальных (м3/час макс)
 * @property float|null $production Производственно-загрязненных
 * @property float|null $production_hour Производственно-загрязненных(м3/час макс)
 * @property float|null $to_city Условно-чистых сбрасываемых на городскую канализацию
 * @property float|null $to_city_hour Условно-чистых сбрасываемых на городскую сеть (м3/час макс)
 * @property string|null $client_wishes Пожелание заказчика
 * @property int $status Статус (0-declined, 1-accepted, 2-active)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereClientWishes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereFeksal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereProduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereToCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzSewage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApzSewage extends Model
{
    protected $table = "apz_sewages";

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
        $this->apz_id = $apz_id;
        $this->amount = $request->SewageAmount;
        $this->amount_hour = $request->SewageAmountHour;
        $this->feksal = $request->SewageFeksal;
        $this->feksal_hour = $request->SewageFeksalHour;
        $this->production = $request->SewageProduction;
        $this->production_hour = $request->SewageProductionHour;
        $this->to_city = $request->SewageToCity;
        $this->to_city_hour = $request->SewageToCityHour;
        $this->client_wishes = $request->SewageClientWishes;
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