<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzWater
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float $requirement Общая потребность в воде
 * @property float|null $drinking На хозпитьевые нужды
 * @property float|null $production На производственные нужды
 * @property float|null $fire_fighting Потребные расходы наружного пожаротушения
 * @property float $sewage Канализация
 * @property int $status Статус (0-declined, 1-accepted, 2-active)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereDrinking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereFireFighting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereProduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereRequirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereSewage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzWater whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApzWater extends Model
{
    protected $table = "apz_waters";

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
        $this->requirement = $request->WaterRequirement;
        $this->drinking = $request->WaterDrinking;
        $this->production = $request->WaterProduction;
        $this->fire_fighting = $request->WaterFireFighting;
        $this->sewage = $request->WaterSewage;
        $this->save();

        return $this;
    }

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }
}
