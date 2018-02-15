<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzSewage extends Model
{
    protected $table = "apz_sewages";

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
        $this->amount = $request->SewageAmount;
        $this->feksal = $request->SewageFeksal;
        $this->production = $request->SewageProduction;
        $this->to_city = $request->SewageToCity;
        $this->client_wishes = $request->SewageClientWishes;
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