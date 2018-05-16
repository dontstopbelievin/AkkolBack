<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ApzAnswerTemplate
 *
 * @mixin \Eloquent
 */
class ApzAnswerTemplate extends Model
{
    use SoftDeletes;

    protected $table = "apz_answer_templates";
    protected $dates = ['deleted_at'];
}
