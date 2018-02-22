<?php

namespace App\Models;

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
}
