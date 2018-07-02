<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sketch
 *
 * @mixin \Eloquent
 */
class Sketch extends Model
{
    protected $table = 'sketches';

    public static function getSketchBaseRelationList()
    {
        return [
            'apzDepartmentResponse.files',
            'files.category',
        ];
    }

    /**
     * Get response
     */
    public function apzDepartmentResponse()
    {
        return $this->hasOne(SketchApzDepartmentResponse::class, 'sketch_id', 'id');
    }

    /**
     * Get status
     */
    public function sketchStatus()
    {
        return $this->hasOne(SketchStatus::class, 'id', 'status_id');
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
            FileItemType::SKETCH
        );
    }
}
