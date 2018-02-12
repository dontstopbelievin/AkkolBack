<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $iin
 * @property string $bin
 * @property string $company_name
 * @property string $password
 * @property Role[] $roles
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'first_name', 'last_name', 'middle_name', 'iin', 'bin', 'company_name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Search param for api auth.
     *
     * @param string $username
     * @return string
     */
    public function findForPassport($username) {
        $iin = $this->where('iin', $username)->first();
        $bin = $this->where('bin', $username)->first();

        if($iin) {
            return $iin;
        }

        return $bin;
    }

    /**
     * Check if user has any role
     *
     * @param string $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * Check if user has role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Get roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
