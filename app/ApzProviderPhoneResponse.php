<?php

namespace App;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzProviderPhoneResponse extends Model
{
    protected $table = "apz_provider_phone_responses";

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
            FileItemType::PHONE_RESPONSE
        );
    }
}
