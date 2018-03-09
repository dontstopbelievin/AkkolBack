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
 * @property float|null $feksal Фекcальных
 * @property float|null $production Производственно-загрязненных
 * @property float|null $to_city Условно-чистых сбрасываемых на городскую канализацию
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
        $this->feksal = $request->SewageFeksal;
        $this->production = $request->SewageProduction;
        $this->to_city = $request->SewageToCity;
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