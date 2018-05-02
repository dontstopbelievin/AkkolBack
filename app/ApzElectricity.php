<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzElectricity
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float|null $required_power Требуемая мощность
 * @property string|null $phase Характер нагрузки
 * @property string|null $safety_category Категория по надежности
 * @property float|null $max_load_device Из указанной макс. нагрузки относятся к электроприемникам
 * @property float|null $max_load Существующая максимальная нагрузка
 * @property float|null $allowed_power Мощность трансформаторов
 * @property int $status Статус (0-declined, 1-accepted, 2-active)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereAllowedPower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereMaxLoad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereMaxLoadDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity wherePhase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereRequiredPower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereSafetyCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzElectricity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApzElectricity extends Model
{
    protected $table = "apz_electricity";

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
        $this->required_power = $request->electricRequiredPower;
        $this->phase = $request->electricityPhase;
        $this->safety_category = $request->electricSafetyCategory;
        $this->max_load_device = $request->electricMaxLoadDevice;
        $this->max_load = $request->electricMaxLoad;
        $this->allowed_power = $request->electricAllowedPower;

        if (array_filter($this->getAttributes())) {
            $this->apz_id = $apz_id;
            $this->save();
        }

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