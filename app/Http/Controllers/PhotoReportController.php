<?php
namespace App\Http\Controllers;
use App\Models\PhotoReport;
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
        try {
            $userId = Auth::user()->id;
            $getPersonal = PhotoReport::select('id')->where(['user_id' => $userId])->get();
            return response()->json($getPersonal, 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Заявки не найдены'], 401);
        }
    }

    public function create(Request $request)
    {
        try {
            $photoReportModel = new PhotoReport();
            $photoReportModel->company_name = $request->CompanyName;
            $photoReportModel->company_legal_address = $request->CompanyLegalAddress;
            $photoReportModel->company_factual_address = $request->CompanyFactualAddress;
            $photoReportModel->photo_address = $request->PhotoAddress;
            $photoReportModel->company_region = $request->CompanyRegion;
            $photoReportModel->iin = $request->IIN;
            $photoReportModel->company_phone = $request->CompanyPhone;
            $photoReportModel->start_date = $request->StartDate;
            $photoReportModel->end_date = $request->EndDate;
            $photoReportModel->comments = $request->Comments;
            $photoReportModel->user_id = Auth::user()->id;
            $photoReportModel->save();
            return response()->json(['message' => 'Заявка успешно отправлена!'], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'При создании заявки произошла ошибка'], 401);
        }
    }

    public function response(Request $request)
    {

    }
}