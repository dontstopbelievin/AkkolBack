<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
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