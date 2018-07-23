<?php
/**
 * @var \App\Apz $apz
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <!-- Styles -->
    <style type="text/css">
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .center {
            text-align: center;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: 10px;
            margin-left: 30px;
        }
        .text p {
            margin: 0;
        }
        .logo {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img width="130" src="../public/images/water_logo.png" alt="water_logo">
    </div>
    <hr>
    <div>
        <table width="100%">
            <tr>
                <td class="left">
                    <p><span></span>№<span>{{ $apz->commission->apzWaterResponse->doc_number }}</span> ({{ $apz->id }})<br />
                    от {{ date('d.m.Y', strtotime($apz->commission->apzWaterResponse->created_at)) }}</p>
                </td>
                <td class="right">
                    <p class="right"><b>{{ $apz->applicant }}</b></p>
                </td>
            </tr>
        </table>
        <div class="row border-visible">
            <p class="center"><b>ТЕХНИЧЕСКИЕ УСЛОВИЯ «НА ВОДОСНАБЖЕНИЕ»</b></p>
            <div class="col-2">
                {{--<p>--}}
                    {{--№ {{ $apz->commission->apzWaterResponse->doc_number }}--}}
                {{--</p>--}}
            </div>
            <div class="col-4"></div>
        </div>

        <div class="row">
            <p>
                <b>Наименование объекта</b>: {{ $apz->project_name }}
            </p>
        </div>
        <div class="row">
            <p>
                <b>Адрес проектируемого объекта, Район</b>: {{ $apz->project_address }}, {{ $apz->region }}
            </p>
        </div>

        <div class="row">
            <p class="center">
                <b>I Водопотребление</b>
            </p>

            <table width="80%" style="margin: auto;">
                <tr>
                    <td width="50%"><p>с расчетным расходом воды</p></td>
                    <td><p>{{ $apz->commission->apzWaterResponse->estimated_water_flow_rate }} м<sup>3</sup> </p></td>
                </tr>

                <tr>
                    <td><p>с существующим расходом воды</p></td>
                    <td><p>{{ $apz->commission->apzWaterResponse->existing_water_consumption }} м<sup>3</sup> </p></td>
                </tr>

                <tr>
                    <td><p>общий объем водопотребления</p></td>
                    <td><p>{{ $apz->commission->apzWaterResponse->gen_water_req }} м<sup>3</sup> </p></td>
                </tr>

                <tr>
                    <td><p>внутреннее пожаротушение</p></td>
                    <td><p>{{ $apz->commission->apzWaterResponse->fire_fighting_water_in }} л/сек.</p></td>
                </tr>

                <tr>
                    <td><p>наружное пожаротушение</p></td>
                    <td><p>{{ $apz->commission->apzWaterResponse->fire_fighting_water_out }} л/сек.</p></td>
                </tr>
            </table>
        </div>

        <br>

        <div class="row text" style="page-break-after:always">
            {!! $apz->commission->apzWaterResponse->tc_text_water !!}
            <p class="center" style="margin-top: 10px">
                <b>II.	Другие требования.</b>
            </p>
            {!! $apz->commission->apzWaterResponse->tc_text_water_requirements !!}
            <p class="center" style="margin-top: 10px">
                <b>III.	Общие положения.</b>
            </p>
            {!! $apz->commission->apzWaterResponse->tc_text_water_general !!}
        </div>
    </div>

    <div style="page-break-after:always; vertical-align: top;">
        <div class="logo">
            <img width="130" src="../public/images/water_logo.png" alt="water_logo">
        </div>
        <hr>
        <table width="100%">
            <tr>
                <td class="left">
                    <p><span></span>№<span>{{ $apz->commission->apzWaterResponse->doc_number }}</span> ({{ $apz->id }})<br />
                        от {{ date('d.m.Y', strtotime($apz->commission->apzWaterResponse->created_at)) }}</p>
                </td>
                <td class="right">
                    <p class="right"><b>{{ $apz->applicant }}</b></p>
                </td>
            </tr>
        </table>
        <p class="center">
            <b>ТЕХНИЧЕСКИЕ УСЛОВИЯ «НА ВОДООТВЕДЕНИЕ»</b>
        </p>

        <div class="row">
            <p>
                <b>Наименование объекта</b>: {{ $apz->project_name }}
            </p>
        </div>
        <div class="row">
            <p>
                <b>Адрес проектируемого объекта, Район</b>: {{ $apz->project_address }}, {{ $apz->region }}
            </p>
        </div>

        <p class="center">
            <b>I Водоотведение</b>
        </p>

        <table width="80%" style="margin: auto;">
            <tr>
                <td width="50%"><p>с расчетным расходом сточных вод</p></td>
                <td><p>{{ $apz->commission->apzWaterResponse->sewage_estimated_water_flow_rate }} м<sup>3</sup> в сутки</p></td>
            </tr>

            <tr>
                <td><p>с существующим расходом сточ. вод</p></td>
                <td><p>{{ $apz->commission->apzWaterResponse->sewage_existing_water_consumption }} м<sup>3</sup> в сутки</p></td>
            </tr>

            <tr>
                <td><p>общий объем водоотведения</p></td>
                <td><p>{{ $apz->commission->apzWaterResponse->gen_water_req }}м<sup>3</sup> в сутки</p></td>
            </tr>
        </table>

        <br>

        <div class="row text">
            {!! $apz->commission->apzWaterResponse->tc_text_sewage !!}
            <p class="center" style="margin-top: 10px">
                <b>II.	Другие требования.</b>
            </p>
            {!! $apz->commission->apzWaterResponse->tc_text_sewage_requirements !!}
            <p class="center" style="margin-top: 10px">
                <b>III.	Общие положения.</b>
            </p>
            {!! $apz->commission->apzWaterResponse->tc_text_sewage_general !!}
        </div>

        <p style="text-align: center;">
            @if ($apz->commission->apzWaterResponse->isSigned())
                <barcode code="{{ implode(' ', [$apz->commission->apzWaterResponse->user->last_name, $apz->commission->apzWaterResponse->user->first_name, $apz->commission->apzWaterResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
            @endif
        </p>
    </div>
</body>
</html>
