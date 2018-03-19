<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * App\Role
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $user_id ИД пользователя
 * @property string|null $region Район
 * @property string|null $project_type Тип проекта
 * @property string|null $applicant Наименование заявителя
 * @property string|null $address Адрес
 * @property string|null $phone Телефон
 * @property string|null $customer Заказчик
 * @property string|null $designer Проектировщик №ГСЛ, категория
 * @property string|null $object_type Тип объекта
 * @property string|null $object_level Этажность
 * @property string|null $object_client Заказчик
 * @property string|null $object_area Площадь здания (кв.м)
 * @property string|null $object_rooms Количество квартир (номеров, кабинетов)
 * @property string|null $object_term Срок строительства по нормам
 * @property string|null $project_name Наименование проектируемого объекта
 * @property string|null $project_address Адрес проектируемого объекта
 * @property string|null $project_address_coordinates Координаты проектируемого объекта
 * @property string|null $cadastral_number Кадастровый номер
 * @property int|null $status_id ИД статуса
 * @property-read \App\ApzElectricity $apzElectricity
 * @property-read \App\ApzGas $apzGas
 * @property-read \App\ApzHeadResponse $apzHeadResponse
 * @property-read \App\ApzHeat $apzHeat
 * @property-read \App\ApzPhone $apzPhone
 * @property-read \App\ApzSewage $apzSewage
 * @property-read \App\ApzStatus $apzStatus
 * @property-read \App\ApzWater $apzWater
 * @property-read \App\Commission $commission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ApzStateHistory[] $stateHistory
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereApplicant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereCadastralNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereDesigner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereObjectArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereObjectClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereObjectLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereObjectRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereObjectTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereObjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereProjectAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereProjectAddressCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereProjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Apz whereUserId($value)
 * @mixin \Eloquent
 */
class Apz extends Model
{
    /**
     * Add item in database
     *
     * @param Request $request
     * @return self
     */
    public function addItem($request)
    {
        $this->user_id = Auth::user()->id;
        $this->region = $request->Region;
        $this->applicant = $request->Applicant;
        $this->address = $request->Address;
        $this->phone = $request->Phone;
        $this->customer = $request->Customer;
        $this->designer = $request->Designer;
        $this->object_type = $request->ObjectType;
        $this->object_level = $request->ObjectLevel;
        $this->object_client = $request->ObjectClient;
        $this->object_area = $request->ObjectArea;
        $this->object_rooms = $request->OBjectRooms;
        $this->object_term = $request->ObjectTerm;
        $this->project_name = $request->ProjectName;
        $this->project_address = $request->ProjectAddress;
        $this->project_address_coordinates = $request->ProjectAddressCoordinates;
        $this->cadastral_number = $request->CadastralNumber;
        $this->status_id = ApzStatus::ARCHITECT;
        $this->save();

        return $this;
    }

    public static function getApzBaseRelationList()
    {
        return [
            'apzElectricity',
            'apzGas',
            'apzHeat',
            'apzPhone',
            'apzSewage',
            'apzWater',
            'commission.apzElectricityResponse.files',
            'commission.apzGasResponse.files',
            'commission.apzHeatResponse.files',
            'commission.apzPhoneResponse.files',
            'commission.apzWaterResponse.files',
            'apzHeadResponse.files',
            'stateHistory',
            'files'
        ];
    }

    public static function getApzEngineerRelationList()
    {
        $base_array = self::getApzBaseRelationList();

        array_push($base_array, 'commission.users.role', 'commission.users.status');

        return $base_array;
    }

    public static function getApzProviderRelationList()
    {
        $base_array = self::getApzBaseRelationList();

        array_push($base_array, 'user');

        return $base_array;
    }

    /**
     * Get electricity
     */
    public function apzElectricity()
    {
        return $this->hasOne(ApzElectricity::class, 'apz_id', 'id');
    }

    /**
     * Get gas
     */
    public function apzGas()
    {
        return $this->hasOne(ApzGas::class, 'apz_id', 'id');
    }

    /**
     * Get heat
     */
    public function apzHeat()
    {
        return $this->hasOne(ApzHeat::class, 'apz_id', 'id');
    }

    /**
     * Get phone
     */
    public function apzPhone()
    {
        return $this->hasOne(ApzPhone::class, 'apz_id', 'id');
    }

    /**
     * Get sewage
     */
    public function apzSewage()
    {
        return $this->hasOne(ApzSewage::class, 'apz_id', 'id');
    }

    /**
     * Get water
     */
    public function apzWater()
    {
        return $this->hasOne(ApzWater::class, 'apz_id', 'id');
    }

    /**
     * Get status
     */
    public function commission()
    {
        return $this->hasOne(Commission::class, 'apz_id', 'id');
    }

    /**
     * Get head response
     */
    public function apzHeadResponse()
    {
        return $this->hasOne(ApzHeadResponse::class, 'apz_id', 'id');
    }

    /**
     * Get states
     */
    public function stateHistory()
    {
        return $this->hasMany(ApzStateHistory::class, 'apz_id', 'id');
    }

    /**
     * Get status
     */
    public function apzStatus()
    {
        return $this->hasOne(ApzStatus::class, 'id', 'status_id');
    }

    /**
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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
            FileItemType::APZ
        );
    }
}
