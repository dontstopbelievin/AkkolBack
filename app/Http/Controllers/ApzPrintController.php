<?php

namespace App\Http\Controllers;

use App\Apz;
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

        $content = view('pdf_templates.apz', ['apz' => $apz])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        return response()->json(['file' => base64_encode($mpdf->Output('', Destination::STRING_RETURN))], 200);
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
                $template = 'pdf_templates.tc_water';
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

            default:
                return response()->json(['message' => 'ТУ не найдена'], 404);
        }

        $content = view($template, ['apz' => $apz])->render();
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        return response()->json(['file' => base64_encode($mpdf->Output('', Destination::STRING_RETURN))], 200);
    }
}
