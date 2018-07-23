<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileSign extends Model
{
    protected $table = 'files_signs';

    /**
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get file
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
