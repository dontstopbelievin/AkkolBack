<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzHeat
 *
 * @property int $id
 * @property int|null $apz_id ИД АПЗ
 * @property float|null $general Общая тепловая нагрузка
 * @property float|null $tech Технологические нужды
 * @property string|null $distribution Разделить нагрузку по жилью и по встроенным помещениям
 * @property string|null $saving Энергосберегающее мероприятие
 * @property int $status Статус (0-declined, 1-accepted, 2-active)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereDistribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereGeneral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereSaving($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereTech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereVentilation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeat whereWater($value)
 * @mixin \Eloquent
 */
class ApzHeat extends Model
{
    protected $table = "apz_heats";

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
        $this->general = $request->heatGeneral;
        $this->tech = $request->heatTech;
        $this->distribution = $request->heatDistribution;
        $this->saving = $request->heatSaving;

        if ($request->blocks && array_filter(array_slice($request->blocks, 0, 1)[0])) {
            ApzHeatBlock::where(['apz_id' => $apz_id])->delete();

            foreach ($request->blocks as $item) {
                $block = new ApzHeatBlock();
                $block->apz_id = $apz_id;
                $block->main = $item['heatMain'];
                $block->ventilation = $item['heatVentilation'];
                $block->water = $item['heatWater'];
                $block->water_max = $item['heatWaterMax'];
                $block->save();
            }
        }

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

    /**
     * Get blocks
     */
    public function blocks()
    {
        return $this->hasMany(ApzHeatBlock::class, 'apz_id', 'apz_id');
    }
}