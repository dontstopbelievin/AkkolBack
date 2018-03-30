<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ApzProviderHeadResponse
 *
 * @property int $id
 * @property int $user_id ИД пользователя
 * @property int $apz_id ИД АПЗ
 * @property int $role_id ИД роли
 * @property string|null $comments Комментарий
 * @property int $is_accepted Флаг принятие
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class ApzProviderHeadResponse extends Model
{
    protected $table = "apz_provider_heads_responses";

    /**
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
