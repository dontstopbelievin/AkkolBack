<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzProviderGasResponse
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property string|null $connection_point Точка подключения
 * @property float $gas_pipe_diameter Диаметр газопровода
 * @property float $assumed_capacity Предполагаемый объем
 * @property string|null $reconsideration Предусмотрение
 * @property string $doc_number Номер документа
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Commission $commission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereAssumedCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereConnectionPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereGasPipeDiameter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereReconsideration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $apz_id ИД АПЗ
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderGasResponse whereApzId($value)
 */
class ApzProviderGasResponse extends Model
{
    protected $table = "apz_provider_gas_responses";

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
    }

    /**
     * Get commission
     */
    public function commission()
    {
        return $this->hasOne(Commission::class, 'id', 'commission_id');
    }

    /**
     * Check if signed
     */
    public function isSigned()
    {
        $item = FileItem::where([
            'item_id' => $this->id,
            'item_type_id' => FileItemType::GAS_RESPONSE
        ])->whereHas('file', function ($query) {
            $query->category_id = FileCategory::XML_GAS;
        });

        return $item;
    }

    /**
     * Get files
     */
    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'files_items',
            'item_id',
            'file_id'
        )->wherePivot(
            'item_type_id',
            FileItemType::GAS_RESPONSE
        );
    }

    /**
     * Get commission
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
