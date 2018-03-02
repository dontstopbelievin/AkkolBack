<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileItem extends Model
{
    protected $table = 'files_items';

    /**
     * Get file
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
