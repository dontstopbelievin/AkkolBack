<?php

namespace App;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * App\Role
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
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
