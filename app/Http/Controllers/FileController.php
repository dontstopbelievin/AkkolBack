<?php
namespace App\Http\Controllers;
use App\Models\File;
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

    public function upload(Request $request)
    {
        $file = $request->file('file');

        if(empty($file)) {
            return false;
        }

        $userId = Auth::user()->id;
        $fileName = md5($file->getClientOriginalName() . microtime());
        $fileExt = $file->getClientOriginalExtension();
        $fileUrl = 'usersfiles/'. $userId .'/'. $fileName .'.'. $fileExt;

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

        //File::saveFiles($request);
    }
}