<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <style type="text/css">
        p, table {text-align: center}
        .row
        {
            display: flex;
            flex-wrap: wrap;
            margin-right: 10px;
            margin-left: 30px;
        }
        .col-6
        {
            flex: 0 0 50%;
            max-width: 50%;
        }
        #root
        {
            position: relative;
        }
    </style>
</head>
<body>
    <div id="root">
        <p>
            <b>ТЕХНИЧЕСКИЕ УСЛОВИЯ «НА ТЕПЛОСНАБЖЕНИЕ»</b>
        </p>
        <p>
            № {{ $apz->commission->apzHeatResponse->doc_number }} от {{ date('d-m-Y', strtotime($apz->commission->apzHeatResponse->created_at)) }}
        </p>
        <br/>
        <p>
            <b>Наименование объекта</b>: {{ $apz->project_name }}
        </p>
        <p>
            <b>Адрес проектируемого объекта, Район</b>: {{ $apz->project_address }}, {{ $apz->region }}
        </p>
        <p>
            <b>Заказчик</b> (застройшик, инвестор): {{ $apz->customer }}
        </p>
        <p>
            <b>Проектировщик №ГСЛ, категория</b>: {{ $apz->designer }}
        </p>
        <p>
            <b>Заявитель</b>: {{ $apz->applicant }}
        </p>
        <p>
            <b>Адрес и телефон заявителя</b>: {{ $apz->address }}, {{ $apz->phone }}
        </p>
        <p>
            <b>Дата и время заявления</b>: {{ date('d-m-Y', strtotime($apz->created_at)) }}
        </p>
        <br />
        <div class="row">
            <p>
                <b>1. Требования заявителя</b>
            </p>
        </div>

        <table width="100%">
            <tr>
                <td width="50%"><p>1. Общая тепловая нагрузка</p></td>
                <td>{{ $apz->apzHeat->general }} Гкал/ч</td>
            </tr>

            <tr>
                <td><p>2. Отопление</p></td>
                <td><p>{{ $apz->apzHeat->main }} Гкал/ч</p></td>
            </tr>

            <tr>
                <td><p>3. Вентиляция</p></td>
                <td><p>{{ $apz->apzHeat->ventilation }} Гкал/ч</p></td>
            </tr>

            <tr>
                <td><p>4. Горячее водоснабжение</p></td>
                <td><p>{{ $apz->apzHeat->water }} Гкал/ч</p></td>
            </tr>

            <tr>
                <td><p>5. Технологические нужды(пар)</p></td>
                <td><p>{{ $apz->apzHeat->tech }} Т/ч</p></td>
            </tr>

            <tr>
                <td><p>6. Разделить нагрузку по жилью и по встроенным помещениям</p></td>
                <td><p>{{ $apz->apzHeat->distribution }} м3 в час</p></td>
            </tr>
        </table>

        <div class="row">
            <p>
                <b>2. Требования по техническим условиям</b>
            </p>
        </div>

        <table width="100%">
            <tr>
                <td width="50%"><p>1. Теплоснабжение осуществляется от источников</p></td>
                <td><p>{{ $apz->commission->apzHeatResponse->resource }}</p></td>
            </tr>

            <tr>
                <td><p>2. Точка подключения</p></td>
                <td><p>{{ $apz->commission->apzHeatResponse->connection_point }}</p></td>
            </tr>

            <tr>
                <td><p>3. Давление теплоносителя в тепловой камере {{ $apz->commission->apzHeatResponse->connection_point }}</p></td>
                <td><p>{{ $apz->commission->apzHeatResponse->trans_pressure }}</p></td>
            </tr>
            <tr>
                <td><p>4. Отопление</p></td>
                <td>{{ $apz->commission->apzHeatResponse->main_in_contract }} Гкал/ч</td>
            </tr>

            <tr>
                <td><p>5. Вентиляция</p></td>
                <td><p>{{ $apz->commission->apzHeatResponse->ven_in_contract }} Гкал/ч</p></td>
            </tr>

            <tr>
                <td><p>6. Горячее водоснабжение</p></td>
                <td><p>{{ $apz->commission->apzHeatResponse->water_in_contract }} Гкал/ч</p></td>
            </tr>

            <tr>
                <td><p>7. Дополнительное</p></td>
                <td>{{ $apz->commission->apzHeatResponse->addition }}</td>
            </tr>

        </table>

        <br/>
        <p>Технические условия (ТУ) действуют в течение всего срока нормативной продолжительности строительства, утвержденной в составе проектной (проектно-сметной) документации</p>
        <p style="text-align: center;">
            <barcode code="{{ implode(' ', [$apz->commission->apzHeatResponse->user->last_name, $apz->commission->apzHeatResponse->user->first_name, $apz->commission->apzHeatResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        </p>
        <p>
            <b>город Алматы 2017 год</b>
        </p>
    </div>
</body>
</html>
