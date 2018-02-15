<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzPhone extends Model
{
    protected $table = "apz_phones";

    /**
     * Add item in database
     *
     * @param Request $request
     * @param integer $apz_id
     *
     * @return self
     */
    public function addItem($request, $apz_id)
    {
        $this->apz_id = $apz_id;
        $this->service_num = $request->PhoneServiceNum;
        $this->capacity = $request->PhoneCapacity;
        $this->sewage = $request->PhoneSewage;
        $this->client_wishes = $request->PhoneClientWishes;
        $this->save();

        return $this;
    }

    /**
     * Get user
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }
}