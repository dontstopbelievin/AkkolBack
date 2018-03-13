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
            <b>ТЕХНИЧЕСКИЕ УСЛОВИЯ «НА ТЕЛЕФОНИЗАЦИЮ»</b>
        </p>
        <p>
            № {{ $apz->commission->apzPhoneResponse->doc_number }} от {{ date('d-m-Y', strtotime($apz->commission->apzPhoneResponse->created_at)) }}
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
                <td width="50%"><p>1. Количество ОТА и услуг в разбивке физ.лиц и юр.лиц</p></td>
                <td><p>{{ $apz->apzPhone->service_num }}</p></td>
            </tr>

            <tr>
                <td><p>2. Телефонная емкость</p></td>
                <td><p>{{ $apz->apzPhone->capacity }}</p></td>
            </tr>

            <tr>
                <td><p>3. Планируемая телефонная канализация</p></td>
                <td><p>{{ $apz->apzPhone->sewage }}</p></td>
            </tr>

            <tr>
                <td><p>4. Пожелания заказчика (тип оборудования, тип кабеля и др.)</p></td>
                <td>{{ $apz->apzPhone->client_wishes }}</td>
            </tr>
        </table>

        <div class="row">
            <p>
                <b>2. Требования по техническим условиям</b>
            </p>
        </div>

        <table width="100%">
            <tr>
                <td width="50%"><p>1. Количество ОТА и услуг в разбивке физ.лиц и юр.лиц</p></td>
                <td><p>{{ $apz->commission->apzPhoneResponse->service_num }}</p></td>
            </tr>

            <tr>
                <td><p>2. Телефонная емкость</p></td>
                <td><p>{{ $apz->commission->apzPhoneResponse->capacity }}</p></td>
            </tr>

            <tr>
                <td><p>3. Планируемая телефонная канализация</p></td>
                <td><p>{{ $apz->commission->apzPhoneResponse->sewage }}</p></td>
            </tr>

            <tr>
                <td><p>4. Пожелания заказчика (тип оборудования, тип кабеля и др.)</p></td>
                <td>{{ $apz->commission->apzPhoneResponse->client_wishes }}</td>
            </tr>
        </table>

        <br/>
        <p>Технические условия (ТУ) действуют в течение всего срока нормативной продолжительности строительства, утвержденной в составе проектной (проектно-сметной) документации</p>
        <p style="text-align: center;">
            <barcode code="{{ implode(' ', [$apz->commission->apzPhoneResponse->user->last_name, $apz->commission->apzPhoneResponse->user->first_name, $apz->commission->apzPhoneResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        </p>
        <p>
            <b>город Алматы 2017 год</b>
        </p>
    </div>
</body>
</html>
