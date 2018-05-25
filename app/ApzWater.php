<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzWater
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float $requirement Общая потребность (м3/сутки)
 * @property float $requirement_hour Общая потребность (м3/час питьевой воды)
 * @property float $requirement_sec Общая потребность (л/сек макс)
 * @property float|null $drinking Хозпитьевые нужды (м3/сутки)
 * @property float|null $drinking_hour Хозпитьевые нужды (м3/час)
 * @property float|null $drinking_sec Хозпитьевые нужды (л/сек макс)
 * @property float|null $production Производственные нужды (м3/сутки)
 * @property float|null $production_hour Производственные нужды (м3/час)
 * @property float|null $production_sec Производственные нужды (л/сек макс)
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
     * Save item in database
     *
     * @param Request $request
     * @param integer $apz_id
     *
     * @return self
     */
    public function saveItem($request, $apz_id)
    {
        $this->requirement = $request->waterRequirement;
        $this->requirement_hour = $request->waterRequirementHour;
        $this->requirement_sec = $request->waterRequirementSec;
        $this->drinking = $request->waterDrinking;
        $this->drinking_hour = $request->waterDrinkingHour;
        $this->drinking_sec = $request->waterDrinkingSec;
        $this->production = $request->waterProduction;
        $this->production_hour = $request->waterProductionHour;
        $this->production_sec = $request->waterProductionSec;
        $this->fire_fighting = $request->waterFireFighting;
        $this->sewage = $request->waterSewage;

        if (array_filter($this->getAttributes())) {
            $this->apz_id = $apz_id;
            $this->save();
        }

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
