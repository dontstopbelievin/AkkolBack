<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzProviderHeatResponse
 *
 * @property int $id
 * @property int|null $response_id ИД ответа
 * @property int|null $block_id ИД блока
 * @property string|null $main_in_contract Отопление
 * @property string|null $ven_in_contract Вентиляция
 * @property string|null $water_in_contract Горячее водоснабжение
 * @property string|null $water_in_contract_max Горячее водоснабжение (макс/ч)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class ApzProviderHeatBlockResponse extends Model
{
    protected $table = "apz_provider_heat_block_responses";

    /**
     * Get response
     */
    public function response()
    {
        return $this->hasOne(ApzProviderHeatResponse::class, 'id', 'response_id');
    }
}
