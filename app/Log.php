<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'code', 'ip_address', 'browser', 'user_id', 'data', 'level'
    ];
}
