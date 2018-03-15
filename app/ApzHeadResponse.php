<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ApzHeadResponse
 *
 * @property int $id
 * @property int $apz_id ИД АПЗ
 * @property int $user_id ИД пользователя
 * @property string|null $response_text Ответ
 * @property string|null $comments Комментарий
 * @property int $response Флаг принятие
 * @property string $doc_number
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Apz $apz
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereApzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereDocNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ApzHeadResponse whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\User $user
 */
class ApzHeadResponse extends Model
{
    protected $table = "apz_head_responses";

    /**
     * Get apz
     */
    public function apz()
    {
        return $this->hasOne(Apz::class, 'id', 'apz_id');
    }

    /**
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get files
     */
    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'files_items',
            'item_id',
            'file_id'
        )->wherePivot(
            'item_type_id',
            FileItemType::HEAD_RESPONSE
        );
    }
}
