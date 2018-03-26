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
        }
        img{
            height: 130px;
        }

        .top p{
            text-align: right;
        }
        .inform li{
            text-align: left;
            line-height: 1.8em;
        }
        .left{
            float: left!important;
            width:350px;
            text-align: left;
        }
        .right{
            float: right!important;

        }
        .left p{
            text-align: left;
            font-weight: bold;
        }

        .right p{
            text-align: right;
            font-weight: bold;
        }
        .footer{
            width:900px;
        }
        .footer li{
            font-style: italic;
            list-style-type: none;
            line-height: 1.8em;
        }
        .footer p{
            text-align: left;
        }
        p {text-align: center; line-height: 2.2em;}


    </style>
</head>
<body>
    <div class="logo">
        <img src="../public/images/kaztransgaz.png" alt="gaz_logo">
    </div>
    <div class="top">
        <p><i>вх. № {{ $apz->commission->apzGasResponse->doc_number }} от {{ date('d-m-Y', strtotime($apz->commission->apzGasResponse->created_at)) }}г.</i></p>
        <p><b>{{ $apz->applicant }}</b></p>
    </div>
    <div id="root">
        <p>
            <b>ТЕХНИЧЕСКИЕ УСЛОВИЯ на АПЗ <br />№ _______________________________ <br />на проектирование и подключение к газораспределительным сетям</b>
        </p>
        <br/>
        <div class="inform">
        <ol>
            <li><b>Наименование объекта</b>: {{ $apz->project_name }}</li>
            <li><b>Адрес: {{ $apz->project_address }}, {{ $apz->region }}</b> (отопление, пищеприготовление и горячее водоснабжение)<br/>
                Расход газа-не более <b>10</b> м<sup>3</sup>/час.

            </li>
            <li><b>Точка подключения:</b> существующий газопровод низкого давления, проложенный в надземном исполнении в районе данного жилого дома, (конкретно определить при проектировании);<br/>
                   Диаметр газопровода в точке подключения- <b>Д<sub> у</sub>&nbsp; 89 мм.</b><br/>
                   <b>Присоединение вновь смонтированного газопровода к действующим сетям и пуск газа в  газопотребляющее оборудование производить после ввода в эксплуатацию объекта строительства,
                       согласно требованиям Государственных нормативных документов в сфере Архитектурной, градостроительной и строительной деятельности. </b>
            </li>
            <li><b>Проектом предусмотреть:</b><br/>
                - применение выполнение гидравлического расчета с учетом всех существующих, подключаемых потребителей, а также перспективы развития, для расчетов принять теплотворную способность природного газа Q<sup>p</sup>=8000 Ккал/м <sub>3</sub>;<br/>
                - Прокладку газопровода высокого (0,6 МПа), среднего и низкого давления выполнить вне территории частных владений, в подземном исполнении из полиэтиленовых труб, с прокладкой сигнальной ленты и медной проволоки в соответствии
                с "Требованиями по безопасности объектов систем газоснабжения", СН РК 4.03-01-2011, СНиП РК 3.01-01-2008, МСП 4.03-103-2005.<br/>
                - труб, материалов, оборудования в строгом соответствии с требованиями нормативных документов, стандартов и ГОСТов;<br/>
                - для защиты от коррозии окраску надземных газопроводов и сооружений на них масляной краской в два слоя, желтыми цветом;<br/>
                - аварийное отключающее устройство - необслуживаемый шаровый кран в точке врезки в надземном исполнении;<br/>
                - монтаж газопровода низкого давления, установку газоиспользующего оборудования, устройство вентиляционного канала и дымохода в соответствии с "Требованиями по безопасности объектов систем газоснабжения", МСН 4.03-01-2003, СН РК 4.02-12-2002, СН РК 4.03-01-2011;<br/>
                - проектирование и производство монтажных работ выполнять силами организации, имеющей лицензии на указанные работы в соответствии с требованиями МСН 4.03-01-2003 и "Требованиями по безопасности объектов систем газоснабжения";<br/>
                - в помещениях, где установлено газоиспользующие оборудование, рекомендовать систему аварийного отключения газа с сигнализатором загазованности;<br/>
                - установку прибора учета газа - средства измерения и другие технические средства, внесенных в Государственный реестр РК, которые выполняют следующие функции: измерение, накопление, хранение, отображение информации о расходе, объеме,температуре, давлении газа
                и времени работы приборов с учетом мощности установленного газопотребляющего оборудования, в защищенных от попадании солнечных лучей и атмосферных осадков, доступных для обслужования местах.<br/>
                - <b>присоединение к действующему газопроводу согласовать с его собственником;</b><br/>
            </li>
        </ol>
        <br />

        </div>
        <div class="left">
            <p>Начальник ПТО</p>
        </div>
        <div class="right">
            <p>Е.Балабеков</p>
        </div>

        <div class="footer">
            <p><b>Рекомендации:</b></p>
            <ul>
                <li>- перспектива развития газоснабжения;</li>
                <li>- предусмотреть помещение под установку газопотребляющего оборудования согласно СНИП и МСН;</li>
                <li>- отдельные разделы разработанного проекта согласовать с ПТО АлПФ АО "КТГА";</li>
                <li>- технический надзор за строительством объекта осуществлять лицами, имеющими аттестат эксперта, оказывающего экспертные работы и инжиниринговые услуги;</li>
                <li>- предоставить полученные в специализированной организации акты на дымоходы и вентиляционные каналы;</li>
                <li>- врезку в действующие газопроводы и пуск газа производить при наличии исполнительно-технической документации, вне отопительного периода, в соответствии с требованиями МСН 4.03-01-2003;</li>
                <li>- после окончания работ сдать исполнительно-техническую документацию, технические паспорта на газоиспользующее оборудование и рабочий проект в газораспределительную (эксплуатирующую) организацию;</li>
                <li>- при аварийном отключении газа на период ремонтных работ необходимо иметь резервный вид топлива;</li>
                <li>- технические условия действительны в течение нормативной продолжительности строительства, утвержденной в составе проектной (проектно-смешной) документации.</li>
            </ul>
        </div>

        <br/>
        <p style="text-align: center;">
            <barcode code="{{ implode(' ', [$apz->commission->apzGasResponse->user->last_name, $apz->commission->apzGasResponse->user->first_name, $apz->commission->apzGasResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        </p>
        <p>
            <b>город Алматы 2017 год</b>
        </p>
    </div>
</body>
</html>
