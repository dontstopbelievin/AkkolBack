<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\ApzStateHistory
 *
 * @property int $id
 * @property int $apz_id ИД АПЗ
 * @property int $state_id ИД состояние
 * @property string|null $comment Коментарии
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\ApzState $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStateHistory whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStateHistory whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStateHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStateHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStateHistory whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzStateHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApzStateHistory extends Model
{
    protected $table = "apz_states_history";

    /**
     * Get state
     */
    public function state()
    {
        return $this->hasOne(ApzState::class, 'id', 'state_id');
    }
}