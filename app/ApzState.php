<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 */
class ApzState extends Model
{
    protected $table = "apz_states";

    const TO_REGION             = 1;
    const REGION_APPROVED       = 2;
    const REGION_DECLINED       = 3;
    const TO_ENGINEER           = 4;
    const ENGINEER_APPROVED     = 5;
    const ENGINEER_DECLINED     = 6;
    const TO_PROVIDERS          = 7;
    const WATER_APPROVED        = 8;
    const WATER_DECLINED        = 9;
    const GAS_APPROVED          = 10;
    const GAS_DECLINED          = 11;
    const ELECTRICITY_APPROVED  = 12;
    const ELECTRICITY_DECLINED  = 13;
    const PHONE_APPROVED        = 14;
    const PHONE_DECLINED        = 15;
    const HEAT_APPROVED         = 16;
    const HEAT_DECLINED         = 17;
    const TO_APZ                = 18;
    const APZ_APPROVED          = 19;
    const APZ_DECLINED          = 20;
    const TO_HEAD               = 21;
    const HEAD_APPROVED         = 22;
    const HEAD_DECLINED         = 23;
}