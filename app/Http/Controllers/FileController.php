<?php
namespace App\Http\Controllers;
use App\File;
use App\FileCategory;
use App\Role;
use Illuminate\Http\Request;
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
            $getAll = File::select('id', 'name', 'description', 'url', 'hash', 'extension', 'size', 'category_id', 'created_at')
                ->with('category')
                ->where(['user_id' => $userId])
                ->whereHas('category', function($query) {
                    $query->where('is_visible', 1);
                })
                ->get();
            return response()->json($getAll, 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function images()
    {
        try {
            $userId = Auth::user()->id;
            $query = File::select('id', 'name', 'content_type', 'description', 'url', 'hash', 'extension', 'size', 'category_id', 'created_at')
                ->with('category')
                ->where('user_id', $userId)
                ->where('content_type', 'like', '%image%')
                ->whereHas('category', function($query) {
                    $query->where('is_visible', 1);
                })
                ->get();

            foreach ($query as $item) {
                $item['base64'] = base64_encode(file_get_contents(storage_path('app/' . $item->url)));
            }
            return response()->json($query, 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function categoriesList()
    {
        try {
            $query = FileCategory::select(['id', 'name_ru', 'name_kz'])->where('is_visible', 1);

            if (!Auth::user()->hasRole('Admin')) {
                $query->where('role_id', null);
            }

            return response()->json($query->get(), 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Категории не найдены'], 404);
        }
    }

    public function getFromCategory($id)
    {
        $user = Auth::user();
        $files = File::where(['category_id' => $id, 'user_id' => $user->id])->get();

        return response()->json($files, 200);
    }

    public function getFromSystemCategory($name)
    {
        try {
            switch ($name) {
                case 'budget':
                    $files = File::where('category_id', FileCategory::BUDGET_PLAN)->get();
                    break;

                default:
                    return response()->json(['message' => 'Категория не найдена'], 404);
            }

            return response()->json($files, 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function downloadSystemFile($type, $id)
    {
        try {
            switch ($type) {
                case 'budget':
                    $file = File::where(['id' => $id, 'category_id' => FileCategory::BUDGET_PLAN])->first();
                    break;

                default:
                    return response()->json(['message' => 'Категория не найдена'], 404);
            }

            $filePath = storage_path('app/' . $file->url);

            return response()->json(['file' => base64_encode(file_get_contents($filePath)), 'file_name' => $file->name], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function download($id)
    {
        try {
            $file = File::select('id', 'name', 'url', 'hash', 'category_id', 'user_id', 'content_type')->where(['id' => $id])->first();
//            $user = Auth::user();
//            $can_download = false;
//
//            switch ($file->category_id) {
//                case FileCategory::IDENTITY_CARD:
//                case FileCategory::APPROVED_ASSIGNMENT:
//                case FileCategory::TITLE_DOCUMENT:
//                    if ($user->hasAnyRole(['Provider', 'Urban', 'Engineer', 'Head']) || $file->user_id == $user->id) {
//                        $can_download = true;
//                    }
//                    break;
//
//                case FileCategory::MOTIVATED_REJECT:
//                case FileCategory::TECHNICAL_CONDITION:
//                    $apz = Apz::where(['id' => $file->items[0]->item_id])->first();
//
//                    if ($user->hasAnyRole(['Head']) || $file->user_id == $user->id || in_array($apz->status_id, [ApzStatus::DECLINED, ApzStatus::ACCEPTED])) {
//                        $can_download = true;
//                    }
//                    break;
//                default:
//                    if ($file->user_id == $user->id) {
//                        $can_download = true;
//                    }
//                    break;
//            }
//
//            if (!$can_download) {
//                throw new \Exception('Отказано в доступе');
//            }

            $filePath = storage_path('app/' . $file->url);

            return response()->json(['file' => base64_encode(file_get_contents($filePath)), 'file_name' => $file->name], 200);
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
            $fileModel->name = $request->name ? $request->name . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName();
            $fileModel->url = $fileUrl;
            $fileModel->extension = $fileExt;
            $fileModel->content_type = $file->getClientMimeType();
            $fileModel->size = $file->getClientSize();
            $fileModel->hash = $fileName;
            $fileModel->category_id = $request->category;
            $fileModel->description = $request->description;
            $fileModel->user_id = $userId;
            $fileModel->save();

            return response()->json($fileModel, 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Во время загрузки произошла ошибка'], 401);
        }
    }

    public function delete($id)
    {
        try {
            if (!Auth::user()->hasRole('Admin')) {
                throw new \Exception('Недостаточно прав');
            }

            $file = File::where('id', $id)->first();

            if (!$file) {
                throw new \Exception('Файл не найден');
            }

            $file->delete();

            return response()->json(['message' => 'Файл успешно удален'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Не удалось удалить файл'], 401);
        }
    }
}