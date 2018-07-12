<?php
/**
 * @var \App\Apz $apz
 */

$response = $apz->apzDepartmentResponse;
$first_counter = 1;
$second_counter = 1;
$third_counter = 1;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <style>
        body {
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
        }

        table td {
            border: 1px solid;
            vertical-align: top;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .notes p {
            margin: 0;
        }

        @page :first {
            footer: html_firstpage;
        }
    </style>
</head>
<body>
<div>
    <div style="page-break-after:always">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        <h2 style="text-align: center; font-size: 13px; margin: 40px 0;">АРХИТЕКТУРНО-ПЛАНИРОВОЧНОЕ ЗАДАНИЕ (АПЗ) НА ПРОЕКТИРОВАНИЕ</h2>

        <div style="text-align: center;">
            {{ $response->doc_number or '' }} от {{ date('d.m.Y', strtotime($response->created_at)) }}
        </div>

        <p>Наименование объекта: {{ $apz->project_name }}, {{ $apz->project_address }}, {{ $apz->region }}</p>
        <p>Заказчик (застройщик, инвестор): {{ $apz->customer }}</p>

        <htmlpagefooter name="firstpage" style="display:none">
            <div style="text-align: center; margin-top: 400px">
                <b>город Алматы {{ date('Y', strtotime($response->created_at)) }} год</b>
            </div>
        </htmlpagefooter>
    </div>

    <table>
        @if ($response->basis_for_development_apz)
            <tr>
                <td>Основание для разработки архитектурно-планировочного задания (АПЗ)</td>
                <td>{!! $response->basis_for_development_apz !!}</td>
            </tr>
        @endif

        <tr>
            <td colspan="2"><b>{{ $first_counter++ }}. ХАРАКТЕРИСТИКА УЧАСТКА</b></td>
        </tr>

        @if ($response->address)
            <tr>
                <td>{{ $second_counter++ }}. Местонахождение участка</td>
                <td>{!! $response->address !!}</td>
            </tr>
        @endif

        @if($response->building_presence)
            <tr>
                <td>{{ $second_counter++ }}. Наличие застройки (строения и сооружения, существующие на участке, в том числе коммуникации, инженерные сооружения, элементы благоустройства и другие)</td>
                <td>{!! $response->building_presence !!}</td>
            </tr>
        @endif

        @if($response->geodetic_study)
            <tr>
                <td>{{ $second_counter++ }}. Геодезическая изученность (наличие съемок, их масштабы)</td>
                <td>{!! $response->geodetic_study !!}</td>
            </tr>
        @endif

        @if($response->engineering_geological_study)
            <tr>
                <td>{{ $second_counter++ }}. Инженерно-геологическая изученность (имеющиеся материалы инженерно-геологических, гидрогеологичес-ких, почвенно-ботанических и других изысканий)</td>
                <td>{!! $response->engineering_geological_study !!}</td>
            </tr>
        @endif

        <tr>
            <td colspan="2"><b>{{ $first_counter++ }}. ХАРАКТЕРИСТИКА ПРОЕКТИРУЕМОГО ОБЪЕКТА</b></td>
        </tr>

        @php
            $second_counter = 1;
        @endphp

        @if($response->functional_value_of_object)
            <tr>
                <td>{{ $second_counter++ }}. Функциональное значение объекта</td>
                <td>{!! $response->functional_value_of_object !!}</td>
            </tr>
        @endif

        @if($response->floor_sum)
            <tr>
                <td>{{ $second_counter++ }}. Этажность</td>
                <td>{!! $response->floor_sum !!}</td>
            </tr>
        @endif

        @if($response->planning_system)
            <tr>
                <td>{{ $second_counter++ }}. Планировочная система</td>
                <td>{!! $response->planning_system !!}</td>
            </tr>
        @endif

        @if($response->structural_scheme)
            <tr>
                <td>{{ $second_counter++ }}. Конструктивная схема</td>
                <td>{!! $response->structural_scheme !!}</td>
            </tr>
        @endif

        @if($response->engineering_support)
            <tr>
                <td>{{ $second_counter++ }}. Инженерное обеспечение</td>
                <td>{!! $response->engineering_support !!}</td>
            </tr>
        @endif

        @if($response->energy_efficiency_class)
            <tr>
                <td>{{ $second_counter++ }}. Класс энергоэффективности</td>
                <td>{!! $response->energy_efficiency_class !!}</td>
            </tr>
        @endif

        @if($response->template_type != 'redevelopment')
            <tr>
                <td colspan="2"><b>{{ $first_counter++ }}. ГРАДОСТРОИТЕЛЬНЫЕ ТРЕБОВАНИЯ</b></td>
            </tr>

            @php
                $second_counter = 1;
            @endphp

            @if($response->spatial_solution)
                <tr>
                    <td>{{ $second_counter++ }}. Объемно-пространственное решение</td>
                    <td>{!! $response->spatial_solution !!}</td>
                </tr>
            @endif

            @if($response->draft_master_plan)
                <tr>
                    <td>{{ $second_counter++ }}. Проект генерального плана</td>
                    <td>{!! $response->draft_master_plan !!}</td>
                </tr>
            @endif

            @if($response->vertical_layout)
                <tr>
                    <td>{{ $second_counter - 1 }}-{{ $third_counter++ }}. вертикальная планировка</td>
                    <td>{!! $response->vertical_layout !!}</td>
                </tr>
            @endif

            @if($response->landscaping_and_gardening)
                <tr>
                    <td>{{ $second_counter - 1 }}-{{ $third_counter++ }}. благоустройство и озеленение</td>
                    <td>{!! $response->landscaping_and_gardening !!}</td>
                </tr>
            @endif

            @if($response->parking)
                <tr>
                    <td>{{ $second_counter - 1 }}-{{ $third_counter++ }}. парковка автомобилей</td>
                    <td>{!! $response->parking !!}</td>
                </tr>
            @endif

            @if($response->use_of_fertile_soil_layer)
                <tr>
                    <td>{{ $second_counter - 1 }}-{{ $third_counter++ }}. использование плодородного слоя почвы</td>
                    <td>{!! $response->use_of_fertile_soil_layer !!}</td>
                </tr>
            @endif

            @if($response->small_architectural_forms)
                <tr>
                    <td>{{ $second_counter - 1 }}-{{ $third_counter++ }}. малые архитектурные формы</td>
                    <td>{!! $response->small_architectural_forms !!}</td>
                </tr>
            @endif

            @if($response->lighting)
                <tr>
                    <td>{{ $second_counter - 1 }}-{{ $third_counter++ }}. освещение</td>
                    <td>{!! $response->lighting !!}</td>
                </tr>
            @endif
        @endif

        <tr>
            <td colspan="2"><b>{{ $first_counter++ }}. АРХИТЕКТУРНЫЕ ТРЕБОВАНИЯ</b></td>
        </tr>

        @php
            $second_counter = 1;
        @endphp

        @if($response->stylistics_of_architecture)
            <tr>
                <td>{{ $second_counter++ }}. Стилистика архитектурного образа</td>
                <td>{!! $response->stylistics_of_architecture !!}</td>
            </tr>
        @endif

        @if($response->nature_combination)
            <tr>
                <td>{{ $second_counter++ }}. Характер сочетания с окружающей застройкой</td>
                <td>{!! $response->nature_combination !!}</td>
            </tr>
        @endif

        @if($response->color_solution)
            <tr>
                <td>{{ $second_counter++ }}. Цветовое решение</td>
                <td>{!! $response->color_solution !!}</td>
            </tr>
        @endif

        @if($response->advertising_and_information_solution)
            <tr>
                <td>{{ $second_counter++ }}. Рекламно-информационное решение, в том числе:</td>
                <td>{!! $response->advertising_and_information_solution !!}</td>
            </tr>
        @endif

        @if($response->night_lighting)
            <tr>
                <td>{{ $second_counter - 1 }}-1 ночное световое оформление</td>
                <td>{!! $response->night_lighting !!}</td>
            </tr>
        @endif

        @if($response->input_nodes)
            <tr>
                <td>{{ $second_counter++ }}. Входные узлы</td>
                <td>{!! $response->input_nodes !!}</td>
            </tr>
        @endif

        @if($response->conditions_for_low_mobile_groups)
            <tr>
                <td>{{ $second_counter++ }}. Создание условий для жизнедеятельности маломобильных групп населения</td>
                <td>{!! $response->conditions_for_low_mobile_groups !!}</td>
            </tr>
        @endif

        @if($response->compliance_noise_conditions)
            <tr>
                <td>{{ $second_counter++ }}. Соблюдение условий по звукошумовым показателям</td>
                <td>{!! $response->compliance_noise_conditions !!}</td>
            </tr>
        @endif

        @if($response->template_type != 'redevelopment')
            <tr>
                <td colspan="2"><b>{{ $first_counter++ }}. ТРЕБОВАНИЯ К НАРУЖНОЙ ОТДЕЛКЕ</b></td>
            </tr>

            @php
                $second_counter = 1;
            @endphp

            @if($response->plinth)
                <tr>
                    <td>{{ $second_counter++ }}. Цоколь</td>
                    <td>{!! $response->plinth !!}</td>
                </tr>
            @endif

            @if($response->facade)
                <tr>
                    <td>{{ $second_counter++ }}. Фасад. Ограждающие конструкций</td>
                    <td>{!! $response->facade !!}</td>
                </tr>
            @endif
        @endif

        <tr>
            <td colspan="2"><b>{{ $first_counter++ }}. ТРЕБОВАНИЯ К ИНЖЕНЕРНЫМ СЕТЯМ</b></td>
        </tr>

        @php
            $second_counter = 1;
        @endphp

        @if($response->heat_supply)
            <tr>
                <td>{{ $second_counter++ }}. Теплоснабжение</td>
                <td>{!! $response->heat_supply !!}</td>
            </tr>
        @endif

        @if($response->water_supply)
            <tr>
                <td>{{ $second_counter++ }}. Водоснабжение</td>
                <td>{!! $response->water_supply !!}</td>
            </tr>
        @endif

        @if($response->sewerage)
            <tr>
                <td>{{ $second_counter++ }}. Канализация</td>
                <td>{!! $response->sewerage !!}</td>
            </tr>
        @endif

        @if($response->power_supply)
            <tr>
                <td>{{ $second_counter++ }}. Электроснабжение</td>
                <td>{!! $response->power_supply !!}</td>
            </tr>
        @endif

        @if($response->gas_supply)
            <tr>
                <td>{{ $second_counter++ }}. Газоснабжение</td>
                <td>{!! $response->gas_supply !!}</td>
            </tr>
        @endif

        @if($response->phone_supply)
            <tr>
                <td>{{ $second_counter++ }}. Телекоммуникация и телерадиовещания</td>
                <td>{!! $response->phone_supply !!}</td>
            </tr>
        @endif

        @if($response->drainage)
            <tr>
                <td>{{ $second_counter++ }}. Дренаж (при необходимости) и ливневая канализация</td>
                <td>{!! $response->drainage !!}</td>
            </tr>
        @endif

        @if($response->irrigation_systems)
            <tr>
                <td>{{ $second_counter++ }}. Стационарные поливочные системы</td>
                <td>{!! $response->irrigation_systems !!}</td>
            </tr>
        @endif

        <tr>
            <td colspan="2"><b>{{ $first_counter++ }}. ОБЯЗАТЕЛЬСТВА, ВОЗЛАГАЕМЫЕ НА ЗАСТРОЙЩИКА</b></td>
        </tr>

        @php
            $second_counter = 1;
        @endphp

        @if($response->engineering_surveys_obligation)
            <tr>
                <td>{{ $second_counter++ }}. По инженерным изысканиям</td>
                <td>{!! $response->engineering_surveys_obligation !!}</td>
            </tr>
        @endif

        @if($response->demolition_obligation)
            <tr>
                <td>{{ $second_counter++ }}. По сносу (переносу) существующих строений и сооружений</td>
                <td>{!! $response->demolition_obligation !!}</td>
            </tr>
        @endif

        @if($response->transfer_communications_obligation)
            <tr>
                <td>{{ $second_counter++ }}. По переносу существующих подземных и надземных коммуникаций</td>
                <td>{!! $response->transfer_communications_obligation !!}</td>
            </tr>
        @endif

        @if($response->conservation_plant_obligation)
            <tr>
                <td>{{ $second_counter++ }}. По сохранению и/или пересадке зеленых насаждений</td>
                <td>{!! $response->conservation_plant_obligation !!}</td>
            </tr>
        @endif

        @if($response->temporary_fencing_construction_obligation)
            <tr>
                <td>{{ $second_counter++ }}. По строительству временного ограждения участка</td>
                <td>{!! $response->temporary_fencing_construction_obligation !!}</td>
            </tr>
        @endif

        @if($response->additional_requirements)
            <tr>
                <td><b>{{ $first_counter++ }}. Дополнительные требования</b></td>
                <td>{!! $response->additional_requirements !!}</td>
            </tr>
        @endif

        @if($response->general_requirements)
            <tr>
                <td><b>{{ $first_counter++ }}. Общие требования</b></td>
                <td>{!! $response->general_requirements !!}</td>
            </tr>
        @endif
    </table>

    @if($response->notes)
        <div class="notes" style="margin-top: 20px">
            <p>Примечания:</p>
            {!! $response->notes !!}
        </div>
    @endif

    <div style="text-align: center; margin-top: 20px">
        @if ($apz->apzHeadResponse)
            <barcode code="{{ implode(' ', [$apz->apzHeadResponse->user->last_name, $apz->apzHeadResponse->user->first_name, $apz->apzHeadResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        @endif

        @if ($apz_sign)
            <barcode code="{{ implode(' ', [$apz_sign->user->last_name, $apz_sign->user->first_name, $apz_sign->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        @endif

        @if ($region_sign)
            <barcode code="{{ implode(' ', [$region_sign->user->last_name, $region_sign->user->first_name, $region_sign->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        @endif
    </div>
</div>
</body>
</html>
