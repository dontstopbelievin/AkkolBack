<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SketchApzDepartmentResponse extends Model
{
    protected $table = "sketch_apz_department_responses";

    /**
     * Get sketch
     */
    public function sketch()
    {
        return $this->hasOne(Sketch::class, 'id', 'sketch_id');
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
            '=',
            FileItemType::SKETCH_APZ_DEPARTMENT_RESPONSE
        );
    }
}
