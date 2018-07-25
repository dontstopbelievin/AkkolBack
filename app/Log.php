<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const NOTICE = 'NOTICE';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';

    protected $fillable = [
        'code', 'ip_address', 'browser', 'user_id', 'data', 'level'
    ];
}
