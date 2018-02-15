<?php
namespace App\Http\Controllers;
use App\Models\File;
use App\Models\FileCategory;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index()
    {
        return view('file.index');
    }

    public function all()
    {
        try {
            $userId = Auth::user()->id;
            $getAll = FileCategory::select('id', 'name', 'url', 'hash', 'extension', 'size', 'category_id', 'created_at')
                ->where(['user_id' => $userId])
                ->get();
            return response()->json([$getAll], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Файлы не найдены'], 401);
        }
    }

    public function categoriesList()
    {
        try {
            $getCategories = FileCategory::select('id', 'name_ru', 'name_kz')->get();
            return response()->json([$getCategories], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Категории не найдены'], 401);
        }
    }

    public function download($id)
    {
        try {
            $userId = Auth::user()->id;
            $getFile = File::select('id', 'name', 'url', 'hash')
                ->where(['id' => $id, 'user_id' => $userId])
                ->get();
            return response()->json([$getFile], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Файл не найден, либо у вас нет прав'], 401);
        }
    }

    public function upload(Request $request)
    {
        try {
            $file = $request->file('file');

            if (empty($file)) {
                return false;
            }

            $userId = Auth::user()->id;
            $fileName = md5($file->getClientOriginalName() . microtime());
            $fileExt = $file->getClientOriginalExtension();
            $fileUrl = 'usersfiles/' . $userId . '/' . $fileName . '.' . $fileExt;

            Storage::put($fileUrl, file_get_contents($file));

            $fileModel = new File();
            $fileModel->name = $request->upload_name ? $request->upload_name : $fileName;
            $fileModel->url = $fileUrl;
            $fileModel->extension = $fileExt;
            $fileModel->content_type = $file->getClientMimeType();
            $fileModel->size = $file->getClientSize();
            $fileModel->hash = $fileName;
            $fileModel->category_id = $request->upload_category;
            $fileModel->description = $request->upload_description;
            $fileModel->user_id = $userId;
            $fileModel->save();
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Во время загрузки произошла ошибка'], 401);
        }

    }
}