<?php
namespace App\Http\Controllers;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PhotoReportController extends Controller
{
    public function index()
    {
        return view('photoreport.index');
    }

    public function personal()
    {

    }

    public function create(Request $request)
    {

    }

    public function response(Request $request)
    {

    }
}