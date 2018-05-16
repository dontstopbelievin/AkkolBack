<?php

namespace App\Http\Controllers;

use App\Apz;
use App\ApzState;
use App\FileCategory;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class ApzPrintController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function printApz($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $apz_sign = $apz->files->filter(function ($value) {
            return $value->category_id == FileCategory::XML_APZ;
        })->first();

        $region_sign = $apz->files->filter(function ($value) {
            return $value->category_id == FileCategory::XML_REGION;
        })->first();

        $content = view('pdf_templates.apz', ['apz' => $apz, 'apz_sign' => $apz_sign, 'region_sign' => $region_sign])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        return response()->json(['file' => base64_encode($mpdf->Output('', Destination::STRING_RETURN))], 200);
    }

    /**
     * Method for developers
     *
     * @param string $role
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function outputPdf($role, $id)
    {
        if (\App::environment() != 'local') {
            abort(404);
        }

        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $apz_sign = $apz->files->filter(function ($value) {
            return $value->category_id == FileCategory::XML_APZ;
        })->first();

        $region_sign = $apz->files->filter(function ($value) {
            return $value->category_id == FileCategory::XML_REGION;
        })->first();

        switch ($role) {
            case 'apz':
                $template = 'pdf_templates.apz';
                break;

            case 'water':
                $template = $apz->object_type == 'ИЖС' ? 'pdf_templates.tc_water' : 'pdf_templates.tc_water_second';
                break;

            case 'electro':
                $template = 'pdf_templates.tc_electro';
                break;

            case 'gas':
                $template = 'pdf_templates.tc_gas';
                break;

            case 'phone':
                $template = 'pdf_templates.tc_phone';
                break;

            case 'heat':
                $template = 'pdf_templates.tc_heat';
                break;

            case 'wastewater':
                $template = 'pdf_templates.tc_wastewater';
                break;

            case 'wastewater2':
                $template = 'pdf_templates.tc_wastewater2';
                break;

            default:
                return response()->json(['message' => 'Роль не найдена'], 404);
        }

        $content = view($template, ['apz' => $apz, 'apz_sign' => $apz_sign, 'region_sign' => $region_sign])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        return $mpdf->Output();
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function printTc($tc, $id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        switch ($tc) {
            case 'water':
                $template = $apz->object_type == 'ИЖС' ? 'pdf_templates.tc_water' : 'pdf_templates.tc_water_second';
                break;

            case 'electro':
                $template = 'pdf_templates.tc_electro';
                break;

            case 'gas':
                $template = 'pdf_templates.tc_gas';
                break;

            case 'phone':
                $template = 'pdf_templates.tc_phone';
                break;

            case 'heat':
                $template = 'pdf_templates.tc_heat';
                break;
            case 'wastewater':
                $template = 'pdf_templates.tc_wastewater';
                break;

            case 'wastewater2':
                $template = 'pdf_templates.tc_wastewater2';
                break;
            default:
                return response()->json(['message' => 'ТУ не найдена'], 404);
        }

        $content = view($template, ['apz' => $apz])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        return response()->json(['file' => base64_encode($mpdf->Output('', Destination::STRING_RETURN))], 200);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function printRegionAnswer($id)
    {
        $apz = Apz::where(['id' => $id])->with(Apz::getApzBaseRelationList())->first();

        if (!$apz) {
            return response()->json(['message' => 'Заявка не найдена'], 404);
        }

        $state = $apz->stateHistory->first(function ($value) {
            return $value->state_id == ApzState::REGION_DECLINED;
        });

        if (!$state) {
            return response()->json(['message' => 'Произошла ошибка'], 500);
        }

        $template = 'pdf_templates.region_decline';

        $content = view($template, ['apz' => $apz, 'state' => $state])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        return response()->json(['file' => base64_encode($mpdf->Output('', Destination::STRING_RETURN))], 200);
    }
}
