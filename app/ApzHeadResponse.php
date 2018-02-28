<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;

/**
 */
class ApzHeadResponse extends Model
{
    protected $table = "apz_head_responses";

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
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
            FileItemType::HEAD_RESPONSE
        );
    }
}
