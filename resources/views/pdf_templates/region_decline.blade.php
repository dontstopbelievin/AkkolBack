<?php
/**
 * @var \App\Apz $apz
 * @var \App\ApzStateHistory $state
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <style>
        .header_table {
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .header_top td {
            text-align: center;
            font-size: 14px;
            padding-bottom: 5px;
        }

        .header_top img {
            width: 90px;
        }

        .header_bottom td {
            border-top: 2px solid #000;
            vertical-align: top;
        }

        .header_bottom td {
            font-size: 11px;
        }
    </style>
</head>
<body>
    <table class="header_table">
        <tr class="header_top">
            <td width="40%"><b>«АЛМАТЫ ҚАЛАСЫ СӘУЛЕТ ЖӘНЕ ҚАЛА ҚҰРЫЛЫСЫ БАСҚАРМАСЫ»</b><br />КОММУНАЛДЫҚ МЕМЛЕКЕТТІК МЕКЕМЕСІ</td>
            <td width="20%" style="vertical-align: top;"><img src="../public/images/logo.png" alt="logo"></td>
            <td width="40%">КОМУНАЛЬНОЕ ГОСУДАРСТВЕННОЕ УЧРЕЖДЕНИЕ<br /><b>«УПРАВЛЕНИЕ АРХИТЕКТУРЫ И ГРАДОСТРОИТЕЛЬСТВА ГОРОДА АЛМАТЫ»</b></td>
        </tr>
        <tr class="header_bottom">
            <td>
                050000 Алматы қаласы, Абылай хан данғылы, 91<br />
                тел.: (727) 279-57-38, 279-54-90<br />
                тел./факс: (727) 279-58-24<br />
                e-mail: uaigkz@mail.ru
                <p style="font-size: 14px; margin-top: 10px">
                    ____________________№____________________<br />
                    __________________________________________
                </p>
            </td>
            <td></td>
            <td style="text-align: right;">
                050000 г. Алматы, пр. Абылай хан, 91<br />
                тел.: (727) 279-57-38, 279-54-90<br />
                тел./факс: (727) 279-58-24<br />
                e-mail: uaigkz@mail.ru
            </td>
        </tr>
    </table>
    {!! $state->comment !!}
</body>
</html>
