<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $level
 * @property integer $parent_id
 * @property Role $parent
 * @property User[] $users
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    const TEMPORARY         = 1;
    const ADMIN             = 2;
    const CITIZEN           = 3;
    const URBAN             = 4;
    const PROVIDER          = 5;
    const INDIVIDUAL        = 6;
    const BUSINESS          = 7;
    const HEAD              = 8;
    const REGION            = 9;
    const ENGINEER          = 10;
    const GAS               = 11;
    const ELECTRICITY       = 12;
    const WATER             = 13;
    const HEAT              = 14;
    const PHONE             = 15;
    const ALATAU            = 16;
    const ALMATY            = 17;
    const AUEZOV            = 18;
    const BOSTANDYK         = 19;
    const JETISU            = 20;
    const MEDEU             = 21;
    const NAURYZBAI         = 22;
    const TURKSIB           = 23;
    const PHOTOREPORTER     = 24;
    const APZ_DEPARTMENT    = 25;

    /**
     * Get users
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
