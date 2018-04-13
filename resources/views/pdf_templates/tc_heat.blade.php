<?php
/**
* @var \App\Apz $apz
*/

$response = $apz->commission->apzHeatResponse;
$table = ['main' => 0, 'ven' => 0, 'water_max' => 0];
$table_result = 0;
?>

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
        .wrap{
            width: 700px;
            margin:0 auto;
            overflow: hidden;
            /*border:solid 1px #ccc;*/
        }
        .logo{
            width:800px;
            /*border:solid 1px #000;*/
            text-align: center;
            margin-bottom:10px;
        }
        .divider{
            border-bottom: solid 2px #000;
            width:600px;
            margin:0 auto;
        }
        .small_text table td{
            font-size: 9px;
            padding-left: 95px;
            font-family: "Times New Roman";
        }

        .number{
            width:250px;
            float: left;
        }
        .number p{
            font-size: 12px;
            text-align: center;
            margin-left: 20px;

        }
        .number .underline{
            text-decoration: underline;
            margin-left: 22px;
            font-size: 12px;
        }
        .number .third{
            margin-left: 22px;
        }
        .too{
            width: 250px;
            float: right;
            margin-right:30px;
            margin-top:55px;
        }
        .section h3{
            text-align: center;
            color: #00b050;
            font-size: 14px;
        }
        .section h3 span{
            font-size: 10px;
        }
        .heat_info th, .heat_info td{
            border:solid 1px #000;
        }
        .heat_info{
            border-collapse: collapse;
            font-size:13.5px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .last-col{
            width:80px;
        }
        .footer {
            margin-left: 40px;
            margin-top: 20px;
        }
        .footer h3, .footer h2{
            text-align: left;
        }
        .footer h2{
            font-size: 18px;
            margin-top:40px;
        }
        .footer p{
            font-size: 10px;
            text-align: left;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div id="root">

        <div class="wrap">

            <header>
                <div class="logo">
                    <img src="../public/images/heat_pdf_logo.png" alt="heat_logo">
                </div>

                <div class="divider"></div>

                <div class="small_text">
                    <table>
                        <tr>
                            <td>050026, Алматы қаласы, Байзақов көшесі, 221,</td>
                            <td>050026, город Алматы, улица Байзакова, 221,</td>
                        </tr>
                        <tr>
                            <td>СТН 600700574582, БСН 060640007336,</td>
                            <td>РНН 600700574582, БИН 060640007336,</td>
                        </tr>
                        <tr>
                            <td>тел.: 8(727) 341-07-00, факс: 8(727) 378-06-73</td>
                            <td>тел.: 8(727) 341-07-00, факс: 8(727) 378-06-73</td>
                        </tr>

                    </table>

                </div>

                <div class="number">
                    <p><span></span>№<span>{{ $response->doc_number }}</span> ({{ $apz->id }})</p>
                    <p class="third">от {{ date('d.m.Y', strtotime($response->created_at)) }}</p>

                </div>

                <div class="too">
                    <h4>{{ $apz->customer }}</h4>
                </div>
            </header>

            <h2 style="text-align: center; margin-bottom: 0;">Технические условия</h2>

            @if($response->load_contract_num)
                <p style="font-weight: bold; margin: 0">

                    @if(sizeof($response->blocks) > 1)
                        на реконструкцию системы теплопотребления
                        {{ $apz->object_level }}-этажных {{ $apz->object_type }}<br />
                    @else
                        на подключение к тепловым сетям
                        {{ $apz->object_level }}-этажного {{ $apz->object_type }}<br />
                    @endif

                    (S<sub>общ</sub> = {{ $apz->object_area }} м<sup>2</sup>), расположенный по адресу: {{ $apz->project_address  }}<br />
                    (кадастровый номер земельного участка {{ $apz->cadastral_number  }})</p>
            @else
                <p style="font-weight: bold; margin: 0">на подключение к тепловым сетям {{ $apz->object_level }}-этажного {{ $apz->object_type }}<br />, расположенный по адресу: {{ $apz->project_address  }}<br />
                    (кадастровый номер земельного участка {{ $apz->cadastral_number  }})</p>
            @endif

            <div class="section">

                <div>
                    <ol>
                        @if ($response->second_resource)
                            <li>Теплоснабжение осуществляется от источников:<br />
                                - {{ $response->resource }}<br />
                                - {{ $response->second_resource }}
                            </li>
                        @else
                            <li>Теплоснабжение осуществляется от источников: $response->resource }}.</li>
                        @endif

                        <li>Точка подключения: {{ $response->connection_point }}. Дополнительные условия и место подключения согласовать с {{ $response->reconcile_connections_with }}<br/>
                            Регулирование отпуска тепла: качественное по температурному графику {{ $response->temperature_chart }}<sup>о</sup>С.<br />
                            {{ $response->connection_terms }}
                        </li>
                        <li>
                            @if($response->two_pipe_tc_name)
                                Давление теплоносителя в тепловой камере {{ $response->two_pipe_pressure_in_tc }}:<br/>
                                <span>- в подающем водоводе {{ $response->two_pipe_pressure_in_sc }} ати<br/>- в обратном водоводе {{ $response->two_pipe_pressure_in_rc }} ати</span>
                            @else
                                Давление теплоносителя в тепловой камере {{ $response->heat_four_pipe_pressure_in_tc }}:<br/>
                                <span>- в подающем водоводе {{ $response->heat_four_pipe_pressure_in_sc }} ати<br/>- в обратном водоводе {{ $response->heat_four_pipe_pressure_in_rc }} ати</span><br />
                                Давление теплоносителя в тепловой камере {{ $response->water_four_pipe_pressure_in_tc }}:<br/>
                                <span>- в подающем водоводе {{ $response->water_four_pipe_pressure_in_sc }} ати<br/>- в обратном водоводе {{ $response->water_four_pipe_pressure_in_rc }} ати</span>
                            @endif
                        </li>

                        @if ($response->heating_networks_design)
                            <li>{{ $response->heating_networks_design }}</li>
                        @endif

                        <li>Тепловые нагрузки, Гкал/ч:
                            <table class="heat_info" width="100%">
                                <tr>
                                    <td rowspan="2">Наименование нагрузки</td>
                                    <td colspan="{{ count($response->blocks) }}">Запрашиваемые</td>
                                    <td rowspan="2">По договору <br />№{{ $response->load_contract_num }}</td>
                                    <td colspan="2">Прирост</td>
                                </tr>
                                <tr>
                                    @foreach($response->blocks as $key => $value)
                                        <td class="last-col">Литер {{ $key + 1 }}</td>
                                    @endforeach

                                    <td class="last-col">Гкал/ч</td>
                                    <td class="last-col">%</td>
                                </tr>
                                <tr>
                                    <td>Отопление</td>

                                    @foreach($response->blocks as $value)
                                        @php
                                            $table['main'] += $value->main;
                                        @endphp

                                        <td class="last-col">{{ $value->main }}</td>
                                    @endforeach

                                    <td>{{ $response->main_in_contract }}</td>
                                    <td class="last-col">{{ $response->main_in_contract ? $response->main_in_contract - $table['main'] : $table['main'] }}
                                    </td>
                                    <td class="last-col">
                                        @if ($response->main_in_contract)
                                            {{ round((($response->main_in_contract - $table['main']) / $response->main_in_contract) * 100, 2, PHP_ROUND_HALF_DOWN) }}
                                        @else
                                            100
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Вентиляция</td>

                                    @foreach($response->blocks as $value)
                                        @php
                                            $table['ven'] += $value->main;
                                        @endphp

                                        <td class="last-col">{{ $value->ven }}</td>
                                    @endforeach

                                    <td>{{ $response->ven_in_contract }}</td>
                                    <td class="last-col">{{ $response->ven_in_contract ? $response->ven_in_contract - $table['ven'] : $table['ven'] }}</td>
                                    <td class="last-col">
                                        @if ($response->ven_in_contract)
                                            {{ round((($response->ven_in_contract - $table['ven']) / $response->ven_in_contract) * 100, 2, PHP_ROUND_HALF_DOWN) }}
                                        @else
                                            100
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>ГВС, макс/ч</td>

                                    @foreach($response->blocks as $value)
                                        @php
                                            $table['water_max'] += $value->main;
                                        @endphp

                                        <td class="last-col">{{ $value->water_max }}</td>
                                    @endforeach

                                    <td>{{ $response->water_in_contract_max }}</td>
                                    <td class="last-col">{{ $response->water_in_contract_max ? $response->water_in_contract_max - $table['water_max'] : $table['water_max'] }}</td>
                                    <td class="last-col">
                                        @if ($response->water_in_contract_max)
                                            {{ round((($response->water_in_contract_max - $table['water_max']) / $response->water_in_contract_max) * 100, 2, PHP_ROUND_HALF_DOWN) }}
                                        @else
                                            100
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>ИТОГО:</th>

                                    @foreach($response->blocks as $value)
                                        @php
                                            $table_result += $value->main + $value->ven + $value->water;
                                        @endphp

                                        <th class="last-col">{{ $value->main + $value->ven + $value->water }}</th>
                                    @endforeach

                                    <th>{{ $response->main_in_contract + $response->ven_in_contract + $response->water_in_contract_max }}</th>
                                    <th class="last-col">
                                        @php
                                            $in_contract = $response->main_in_contract + $response->ven_in_contract + $response->water_in_contract_max;
                                        @endphp

                                        @if ($in_contract == 0)
                                            {{ $table_result }}
                                        @else
                                            {{ $in_contract - $table_result }}
                                        @endif
                                    </th>
                                    <th class="last-col">{{ round((($in_contract - $table_result) / $table_result) * 100, 2, PHP_ROUND_HALF_DOWN) }}</th>
                                </tr>
                            </table>
                        </li>
                        <li>{{ $response->final_heat_loads }}</li>

                        @if ($response->second_resource)
                            <li>
                                Транспортировка тепловой энергии от котельной {{ $response->resource }} осуществляется по 2-х трубной схеме.<br />
                                Транспортировка тепловой энергии от котельной {{ $response->second_resource }} осуществляется по 4-х трубной схеме.
                            </li>
                        @endif

                        @if ($response->heat_networks_relaying)
                            <li>{{ $response->heat_networks_relaying }}</li>
                        @endif

                        @if ($response->condensate_return)
                            <li>{{ $response->condensate_return }}</li>
                        @endif

                        @if ($response->thermal_energy_meters)
                            <li>{{ $response->thermal_energy_meters }}</li>
                        @endif

                        <li>Система теплоснабжения: {{ $response->heat_supply_system }}<br />
                            {{ $response->heat_supply_system_note }}
                        </li>

                        <li>Подключение выполнить через {{ $response->connection_scheme }}<br/>
                            {{ $response->connection_scheme_note }}
                        </li>

                        @if ($response->negotiation)
                            <li>{{ $response->negotiation }}</li>
                        @endif

                        @if ($response->technical_conditions_terms)
                            <li><b>Срок действия технических условий:</b> {{ $response->technical_conditions_terms }}</li>
                        @endif
                    </ol>
                </div>
                <div class="footer" style="position: relative;">
                    <table width="100%" style="text-align: left;">
                        <tbody>
                            <tr>
                                <td><h3>Главный инженер<br/>Д. Кирдяйкин</h3></td>
                                <td><barcode code="{{ implode(' ', [$response->user->last_name, $response->user->first_name, $response->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Исп. {{ $response->user->name }}<br/>
                                        e-mail.: {{ $response->user->email }}
                                    </p>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
