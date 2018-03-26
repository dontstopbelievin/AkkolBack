<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <style type="text/css">
        .logo{
            text-align: center;
            margin-bottom: 50px;
        }
        img{
            height: 130px;
        }
        .inform p{
            text-align: left;
        }
        p {text-align: center}
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
        <div class="logo">
            <img src="../public/images/electro.jpg" alt="telephone_logo">
        </div>
        <p>
            <b>ТЕХНИЧЕСКИЕ УСЛОВИЯ «НА ЭЛЕКТРОСНАБЖЕНИЕ»</b>
        </p>
        <p>
            {{--№ {{ $apz->commission->apzElectricityResponse->doc_number }} от {{ date('d-m-Y', strtotime($apz->commission->apzElectricityResponse->created_at)) }}--}}
        </p>
        <br/>
        <div class="inform">


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
        </div>
        <br />
        <div class="row">
            <p>
                <b>1. Требования заявителя</b>
            </p>
        </div>

        <table width="100%">
            <tr>
                <td width="80%"><p>1. Разрешенная по договору мощность трансформаторов</p></td>
                <td><p>{{ $apz->apzElectricity->allowed_power }} кВА</p></td>
            </tr>

            <tr>
                <td><p>2. Требуемая мощность</p></td>
                <td><p>{{ $apz->apzElectricity->required_power }} кВт</p></td>
            </tr>

            <tr>
                <td><p>3. Характер нагрузки (фаза)</p></td>
                <td><p>{{ $apz->apzElectricity->phase }}</p></td>
            </tr>

            <tr>
                <td><p>4. Категория по надежности</p></td>
                <td><p>{{ $apz->apzElectricity->safety_category }} кВт</p></td>
            </tr>

            <tr>
                <td><p>5. Из указанной макс. нагрузки относятся к электроприемникам</p></td>
                <td><p>{{ $apz->apzElectricity->max_load_device }} кВА</p></td>
            </tr>

            <tr>
                <td><p>6. Существующая максимальная нагрузка</p></td>
                <td>{{ $apz->apzElectricity->max_load }} кВА</td>
            </tr>
        </table>

        <div class="row">
            <p>
                <b>2. Требования по техническим условиям</b>
            </p>
        </div>

        <table width="100%">
            <tr>
                <td width="50%"><p>1. Требуемая мощность</p></td>
                {{--<td><p>{{ $apz->commission->apzElectricityResponse->req_power }} кВт</p></td>--}}
            </tr>

            <tr>
                <td><p>2. Характер нагрузки (фаза)</p></td>
                {{--<td><p>{{ $apz->commission->apzElectricityResponse->phase }}</p></td>--}}
            </tr>

            <tr>
                <td><p>3. Категория по надежности</p></td>
                {{--<td><p>{{ $apz->commission->apzElectricityResponse->safe_category }} кВт</p></td>--}}
            </tr>

            <tr>
                <td><p>4. Точка подключения</p></td>
                {{--<td><p>{{ $apz->commission->apzElectricityResponse->connection_point }}</p></td>--}}
            </tr>

            <tr>
                <td><p>5. Рекомендация</p></td>
                {{--<td><p>{{ $apz->commission->apzElectricityResponse->recommendation }}</p></td>--}}
            </tr>
        </table>
        <br/>
        <p>Технические условия (ТУ) действуют в течение всего срока нормативной продолжительности строительства, утвержденной в составе проектной (проектно-сметной) документации</p>
        <p style="text-align: center;">
            {{--<barcode code="{{ implode(' ', [$apz->commission->apzElectricityResponse->user->last_name, $apz->commission->apzElectricityResponse->user->first_name, $apz->commission->apzElectricityResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />--}}
        </p>
        <p>
            <b>город Алматы 2017 год</b>
        </p>
    </div>
</body>
</html>
