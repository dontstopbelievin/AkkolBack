<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzHeatBlock
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float|null $main Отопление
 * @property float|null $ventilation Вентиляция
 * @property float|null $water Горячее водоснабжение
 * @property float|null $water_max Горячее водоснабжение (макс/ч)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @mixin \Eloquent
 */
class ApzHeatBlock extends Model
{
    protected $table = "apz_heats_blocks";

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
        $this->main = $request->HeatMain;
        $this->ventilation = $request->HeatVentilation;
        $this->water = $request->HeatWater;
        $this->water_max = $request->HeatWaterMax;
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