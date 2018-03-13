<?php

namespace App;

use App\FileItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * App\File
 *
 * @property int $id ИД
 * @property string $name Название
 * @property string|null $description Описание
 * @property string $url Ссылка на файл
 * @property string $hash Хэш файла
 * @property string $extension Расширение
 * @property string $content_type Тип
 * @property string $size Размер
 * @property int|null $category_id ИД категории
 * @property int|null $user_id ИД пользователя
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\FileCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FileItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUserId($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    /**
     * @param string $name
     * @param string $url
     * @param string $category
     * @param string $content
     * @return self | bool
     */
    public static function addXmlItem($name, $category, $url, $content)
    {
        $file_name = md5($name . microtime());
        $file_url = $url . '/' . $file_name . '.xml';

        Storage::put($file_url, $content);

        if (!Storage::disk('local')->exists($file_url)) {
            return false;
        }

        $item = new File();
        $item->name = $name;
        $item->url = $file_url;
        $item->extension = 'xml';
        $item->content_type = 'text/xml';
        $item->size = filesize(Storage::path($file_url));
        $item->hash = $file_name;
        $item->category_id = $category;
        $item->user_id = Auth::user()->id;

        if (!$item->save()) {
            return false;
        }

        return $item;
    }

    /**
     * Get items
     */
    public function items()
    {
        return $this->hasMany(FileItem::class, 'file_id', 'id');
    }

    /**
     * Get category
     */
    public function category()
    {
        return $this->hasOne(FileCategory::class, 'id', 'category_id');
    }

    /**
     * Get user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
