<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzProviderHeatResponse
 *
 * @property int $id
 * @property int|null $commission_id ИД комиссии
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property string|null $resource Источник
 * @property string|null $second_resource Второй источник
 * @property string|null $trans_pressure Давление теплоносителя в тепловой камере
 * @property string|null $load_contract_num Тепловые нагрузки по договору
 * @property string|null $connection_point Точка подключения
 * @property string|null $addition Дополнительное
 * @property string $doc_number Номер документа
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $apz_id ИД АПЗ
 * @property string|null $name Наименование
 * @property string|null $water_in_contract_max Горячее водоснабжение (макс/ч)
 * @property string|null $area Отапливаемая площадь
 * @property string|null $transporter Транспортировка тепловой энергии осуществляется по
 * @property string|null $two_pipe_tc_name Название ТК (2-трубной схеме)
 * @property string|null $two_pipe_pressure_in_tc Давление теплоносителя в ТК (2-трубной схеме)
 * @property string|null $two_pipe_pressure_in_sc Давление в подающем водоводе (2-трубной схеме)
 * @property string|null $two_pipe_pressure_in_rc Давление в обратном водоводе (2-трубной схеме)
 * @property string|null $heat_four_pipe_tc_name Название ТК (4-трубной схеме, отопление)
 * @property string|null $heat_four_pipe_sc_name Название ТК (4-трубной схеме, отопление)
 * @property string|null $heat_four_pipe_pressure_in_tc Давление теплоносителя в ТК (4-трубной схеме, отопление)
 * @property string|null $heat_four_pipe_pressure_in_sc Давление в подающем водоводе (4-трубной схеме, отопление)
 * @property string|null $heat_four_pipe_pressure_in_rc Давление в обратном водоводе (4-трубной схеме, отопление)
 * @property string|null $water_four_pipe_pressure_in_tc Давление теплоносителя в ТК (4-трубной схеме, ГВС)
 * @property string|null $water_four_pipe_pressure_in_sc Давление в подающем водоводе (4-трубной схеме, ГВС)
 * @property string|null $water_four_pipe_pressure_in_rc Давление в обратном водоводе (4-трубной схеме, ГВС)
 * @property string|null $temperature_chart Температурный график
 * @property string|null $reconcile_connections_with Дополнительные условия и место подключения согласовать с
 * @property string|null $connection_terms Условия подключения
 * @property string|null $heating_networks_design Проектирование тепловых сетей
 * @property string|null $final_heat_loads Окончательные тепловые нагрузки
 * @property string|null $heat_networks_relaying Перекладка тепловых сетей
 * @property string|null $condensate_return Возврат конденсата
 * @property string|null $thermal_energy_meters Приборы учета тепловой энергии
 * @property string|null $heat_supply_system Система теплоснабжения
 * @property string|null $heat_supply_system_note Примечание к системе теплоснабжения
 * @property string|null $connection_scheme Схема подключения
 * @property string|null $connection_scheme_note Примечание к схеме подключения
 * @property string|null $after_control_unit_installation По завершении монтажа узла управления
 * @property string|null $negotiation Согласование
 * @property string|null $technical_conditions_terms Срок действия технических условий
 * @property-read \App\User $user
 * @property-read \App\Commission $commission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereAddition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereCommissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereConnectionPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereLoadContractNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereMainInContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTransPressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereVenInContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereWaterInContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereAfterControlUnitInstallation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereCondensateReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereConnectionScheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereConnectionSchemeNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereConnectionTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereFinalHeatLoads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatFourPipePressureInRc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatFourPipePressureInSc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatFourPipePressureInTc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatNetworksRelaying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatSupplySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatSupplySystemNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereHeatingNetworksDesign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereNegotiation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereReconcileConnectionsWith($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTechnicalConditionsTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTemperatureChart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereThermalEnergyMeters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTransporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTwoPipePressureInRc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTwoPipePressureInSc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereTwoPipePressureInTc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereWaterFourPipePressureInRc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereWaterFourPipePressureInSc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereWaterFourPipePressureInTc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzProviderHeatResponse whereWaterInContractMax($value)
 * @mixin \Eloquent
 */
class ApzProviderHeatResponse extends Model
{
    protected $table = "apz_provider_heat_responses";

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
            'item_type_id' => FileItemType::HEAT_RESPONSE
        ])->whereHas('file', function ($query) {
            $query->category_id = FileCategory::XML_HEAT;
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
            FileItemType::HEAT_RESPONSE
        );
    }

    /**
     * Get commission
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get blocks
     */
    public function blocks()
    {
        return $this->hasMany(ApzProviderHeatBlockResponse::class, 'response_id', 'id');
    }
}
