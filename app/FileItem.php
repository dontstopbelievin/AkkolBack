<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FileItem
 *
 * @property int $id ИД
 * @property int|null $file_id ИД файла
 * @property string $item_id ИД родителя
 * @property int|null $item_type_id ИД типа связи
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\File $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItem whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItem whereItemTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FileItem extends Model
{
    protected $table = 'files_items';

    /**
     * @param File $file
     * @param integer $item
     * @param integer $type
     * @return self | bool
     */
    public static function addItem($file, $item, $type)
    {
        $file_item = new FileItem();
        $file_item->file_id = $file->id;
        $file_item->item_id = $item;
        $file_item->item_type_id = $type;

        if (!$file_item->save()) {
            return false;
        }

        return $file_item;
    }

    /**
     * Get file
     */
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
