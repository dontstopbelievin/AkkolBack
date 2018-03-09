<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzGas
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float $general Общая потребность
 * @property float|null $cooking На приготовление пищи
 * @property float $heat Отопление
 * @property float|null $ventilation Вентиляция
 * @property float|null $conditioner Кондиционирование
 * @property float|null $water Горячее водоснабжение
 * @property int $status Статус (0-declined, 1-accepted, 2-active)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereConditioner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereCooking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereGeneral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereHeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereVentilation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzGas whereWater($value)
 * @mixin \Eloquent
 */
class ApzGas extends Model
{
    protected $table = "apz_gases";

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
        $this->general = $request->GasGeneral;
        $this->cooking = $request->GasCooking;
        $this->heat = $request->GasHeat;
        $this->ventilation = $request->GasVentilation;
        $this->conditioner = $request->GasConditioner;
        $this->water = $request->GasWater;
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
