<?php

namespace App;

use App\FileItem;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Get items
     */
    public function items()
    {
        return $this->hasMany(FileItem::class, 'file_id', 'id');
    }

    /**
     * Get category
     */
    public function category()
    {
        return $this->hasOne(FileCategory::class, 'id', 'category_id');
    }
}
