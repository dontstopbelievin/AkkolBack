<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <style type="text/css">
        p {text-align: center}
        table {vertical-align: top}
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
    </style>
</head>
<body>
    <div style="page-break-after:always">
        <p><b>АРХИТЕКТУРНО-ПЛАНИРОВОЧНОЕ ЗАДАНИЕ (АПЗ) НА ПРОЕКТИРОВАНИЕ</b></p>
        <p>№{{ $apz->apzHeadResponse->doc_number }} от {{ date('d-m-Y', strtotime($apz->apzHeadResponse->created_at)) }}</p>
        <br/>
        <p><b>Наименование объекта</b>: {{ $apz->project_name }}</p>
        <p><b>Адрес проектируемого объекта, Район</b>: {{ $apz->project_address }}, {{ $apz->region }}</p>
        <p><b>Заказчик</b> (застройшик, инвестор): {{ $apz->customer }}</p>
        <p><b>Проектировщик №ГСЛ, категория</b>: {{ $apz->designer }}</p>
        <p><b>Заявитель</b>: {{ $apz->applicant }}</p>
        <p><b>Адрес и телефон заявителя</b>: {{ $apz->address }}, {{ $apz->phone }}</p>
        <p><b>Дата и время заявления</b>: {{ date('d-m-Y', strtotime($apz->created_at)) }}</p>
        <br />
        <div class="row">
            <p><b>1. Характеристика участка</b></p>
        </div>

        <br>

        <table class="row" width="100%">
            <tr>
                <td width="50%"><p>1. Местонахождение участка</p></td>
                <td><p>{{ $apz->project_address }}, {{ $apz->region }}</p></td>
            </tr>

            <tr>
                <td><p>2. Наличие застройки (строения и сооружения, существующие на участке, в том числе коммуникации, инженерны сооружения, элементы благоустройства и др.)</p></td>
                <td><p>Краткое описание</p></td>
            </tr>

            <tr>
                <td><p>3. Геодезическая изученность (наличие съемок, их масштабы)</p></td>
                <td><p>Краткое описание</p></td>
            </tr>

            <tr>
                <td><p>4. Инженерно-геологическая изученность (имеющиеся материалы инженерно-геологических, гидрогеологических, почвенно-ботанических и других изысканий)</p></td>
                <td><p>Краткое описание</p></td>
            </tr>
        </table>

        <div class="row">
            <p><b>2. Характеристика проектируемого объекта</b></p>
        </div>

        <table class="row" width="100%">
            <tr>
                <td width="50%"><p>1. Функциональное значение объекта</p></td>
                <td><p>Краткое описание</p></td>
            </tr>

            <tr>
                <td><p>2. Этажность</p></td>
                <td><p>Краткое описание</p></td>
            </tr>

            <tr>
                <td><p>3. Планировочная система</p></td>
                <td><p>По проекту с учетом функционального назначения объекта</p></td>
            </tr>

            <tr>
                <td><p>4. Конструктивная схема</p></td>
                <td><p>По проекту</p></td>
            </tr>

            <tr>
                <td><p>5. Инженерное обеспечение</p></td>
                <td><p>Краткое описание</p></td>
            </tr>

            <tr>
                <td><p>6. Класс энергоэффективности</p></td>
                <td><p>Нормативное с краткими описаниями</p></td>
            </tr>
        </table>

        <br />
        <div class="row">
            <p><b>3. Требования к инженерным сетям</b></p>
        </div>

        @if($apz->commission->apzElectricityResponse || $apz->commission->apzGasResponse)
            <table width="100%">
                <tr>
                    @if($apz->commission->apzElectricityResponse)
                        <td width="50%">
                            <table border="1" width="100%">
                                <tr>
                                    <th colspan="2">Электроснабжение</th>
                                </tr>
                                <tr>
                                    <td>Требуемая мощность (кВт)</td>
                                    <td>{{ $apz->commission->apzElectricityResponse->req_power }}</td>
                                </tr>
                                <tr>
                                    <td>Характер нагрузки (фаза)</td>
                                    <td>{{ $apz->commission->apzElectricityResponse->phase }}</td>
                                </tr>
                                <tr>
                                    <td>Категория по надежности (кВт)</td>
                                    <td>{{ $apz->commission->apzElectricityResponse->safe_category }}</td>
                                </tr>
                                <tr>
                                    <td>Точка подключения</td>
                                    <td>{{ $apz->commission->apzElectricityResponse->connection_point }}</td>
                                </tr>
                                <tr>
                                    <td>Рекомендация</td>
                                    <td>{{ $apz->commission->apzElectricityResponse->recommendation }}</td>
                                </tr>
                                <tr>
                                    <td>Согласно техническим условиям</td>
                                    <td>№ {{ $apz->commission->apzElectricityResponse->doc_number }}</td>
                                </tr>
                                <tr>
                                    <td>Дата выдачи ТУ</td>
                                    <td>{{ date('d-m-Y', strtotime($apz->commission->apzElectricityResponse->created_at)) }}</td>
                                </tr>
                            </table>
                            <br />
                        </td>
                    @endif

                    @if($apz->commission->apzGasResponse)
                        <td width="50%">
                            <table border="1" width="100%">
                                <tr>
                                    <th colspan="2">Газоснабжение</th>
                                </tr>
                                <tr>
                                    <td>Точка подключения</td>
                                    <td>{{ $apz->commission->apzGasResponse->connection_point }}</td>
                                </tr>
                                <tr>
                                    <td>Диаметр газопровода (мм)</td>
                                    <td>{{ $apz->commission->apzGasResponse->gas_pipe_diameter }}</td>
                                </tr>
                                <tr>
                                    <td>Предполагаемый объем (м<sup>3</sup>/час)</td>
                                    <td>{{ $apz->commission->apzGasResponse->assumed_capacity }}</td>
                                </tr>
                                <tr>
                                    <td>Предусмотрение</td>
                                    <td>{{ $apz->commission->apzGasResponse->reconsideration }}</td>
                                </tr>
                                <tr>
                                    <td>Согласно техническим условиям</td>
                                    <td>№ {{ $apz->commission->apzGasResponse->doc_number }}</td>
                                </tr>
                                <tr>
                                    <td>Дата выдачи ТУ</td>
                                    <td>{{ date('d-m-Y', strtotime($apz->commission->apzGasResponse->created_at)) }}</td>
                                </tr>
                            </table>
                        </td>
                    @endif
                </tr>
            </table>
        @endif

        <br />

        @if($apz->commission->apzWaterResponse)
            <table border="1" width="100%">
                <tr>
                    <th colspan="2">Водоснабжение</th>
                </tr>
                <tr>
                    <td width="60%">Общая потребность в воде (м<sup>3</sup>/сутки)</td>
                    <td>{{ $apz->commission->apzWaterResponse->gen_water_req }}</td>
                </tr>
                <tr>
                    <td>Хозпитьевые нужды (м<sup>3</sup>/сутки)</td>
                    <td>{{ $apz->commission->apzWaterResponse->drinking_water }}</td>
                </tr>
                <tr>
                    <td>Производственные нужды (м<sup>3</sup>/сутки)</td>
                    <td>{{ $apz->commission->apzWaterResponse->prod_water }}</td>
                </tr>
                <tr>
                    <td>Расходы пожаротушения внутренные (л/сек)</td>
                    <td>{{ $apz->commission->apzWaterResponse->fire_fighting_water_in }}</td>
                </tr>
                <tr>
                    <td>Расходы пожаротушения внешные (л/сек)</td>
                    <td>{{ $apz->commission->apzWaterResponse->fire_fighting_water_out }}</td>
                </tr>
                <tr>
                    <td>Точка подключения</td>
                    <td>{{ $apz->commission->apzWaterResponse->connection_point }}</td>
                </tr>
                <tr>
                    <td>Рекомендация</td>
                    <td>{{ $apz->commission->apzWaterResponse->recommendation }}</td>
                </tr>
                <tr>
                    <td>Согласно техническим условиям</td>
                    <td>№ {{ $apz->commission->apzWaterResponse->doc_number }}</td>
                </tr>
                <tr>
                    <td>Дата выдачи ТУ</td>
                    <td>{{ date('d-m-Y', strtotime($apz->commission->apzWaterResponse->created_at)) }}</td>
                </tr>
            </table>
        @endif

        <br />

        @if($apz->commission->apzHeatResponse)
            <table border="1" width="100%">
                <tr>
                    <th colspan="2">Теплоснабжение</th>
                </tr>

                @if ($apz->commission->apzHeatResponse->resource)
                    <tr>
                        <td width="60%">Источник</td>
                        <td>{{ $apz->commission->apzHeatResponse->resource }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_point)
                    <tr>
                        <td>Точка подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_point }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->trans_pressure)
                    <tr>
                        <td>Давление теплоносителя {{ $apz->commission->apzHeatResponse->connection_point }}</td>
                        <td>{{ $apz->commission->apzHeatResponse->trans_pressure }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->load_contract_num)
                    <tr>
                        <td>Тепловые нагрузки по договору №</td>
                        <td>{{ $apz->commission->apzHeatResponse->load_contract_num }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->main_in_contract)
                    <tr>
                        <td>Отопление (Гкал/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->main_in_contract }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->ven_in_contract)
                    <tr>
                        <td>Вентиляция (Гкал/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->ven_in_contract }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_in_contract)
                    <tr>
                        <td>Горячее водоснабжение (ср/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_in_contract }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_in_contract_max)
                    <tr>
                        <td>Горячее водоснабжение (макс/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_in_contract_max }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->name)
                    <tr>
                        <td>Наименование</td>
                        <td>{{ $apz->commission->apzHeatResponse->name }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->area)
                    <tr>
                        <td>Отапливаемая площадь</td>
                        <td>{{ $apz->commission->apzHeatResponse->area }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->transporter)
                    <tr>
                        <td>Транспортировка тепловой энергии осуществляется по</td>
                        <td>{{ $apz->commission->apzHeatResponse->transporter }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->two_pipe_pressure_in_tc)
                    <tr>
                        <td>Давление теплоносителя в ТК (2-трубной схеме)</td>
                        <td>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_tc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->two_pipe_pressure_in_sc)
                    <tr>
                        <td>Давление в подающем водоводе (2-трубной схеме)</td>
                        <td>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_sc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->two_pipe_pressure_in_rc)
                    <tr>
                        <td>Давление в обратном водоводе (2-трубной схеме)</td>
                        <td>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_rc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_tc)
                    <tr>
                        <td>Давление теплоносителя в ТК (4-трубной схеме, отопление)</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_tc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_sc)
                    <tr>
                        <td>Давление в подающем водоводе (4-трубной схеме, отопление)</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_sc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_rc)
                    <tr>
                        <td>Давление в обратном водоводе (4-трубной схеме, отопление)</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_rc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_four_pipe_pressure_in_tc)
                    <tr>
                        <td>Давление теплоносителя в ТК (4-трубной схеме, ГВС)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_tc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_four_pipe_pressure_in_sc)
                    <tr>
                        <td>Давление в подающем водоводе (4-трубной схеме, ГВС)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_sc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_four_pipe_pressure_in_rc)
                    <tr>
                        <td>Давление в обратном водоводе (4-трубной схеме, ГВС)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_rc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->temperature_chart)
                    <tr>
                        <td>Температурный график</td>
                        <td>{{ $apz->commission->apzHeatResponse->temperature_chart }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->reconcile_connections_with)
                    <tr>
                        <td>Дополнительные условия и место подключения согласовать с</td>
                        <td>{{ $apz->commission->apzHeatResponse->reconcile_connections_with }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_terms)
                    <tr>
                        <td>Условия подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_terms }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heating_networks_design)
                    <tr>
                        <td>Проектирование тепловых сетей</td>
                        <td>{{ $apz->commission->apzHeatResponse->heating_networks_design }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->final_heat_loads)
                    <tr>
                        <td>Окончательные тепловые нагрузки</td>
                        <td>{{ $apz->commission->apzHeatResponse->final_heat_loads }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_networks_relaying)
                    <tr>
                        <td>Перекладка тепловых сетей</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_networks_relaying }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->condensate_return)
                    <tr>
                        <td>Возврат конденсата</td>
                        <td>{{ $apz->commission->apzHeatResponse->condensate_return }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->thermal_energy_meters)
                    <tr>
                        <td>Приборы учета тепловой энергии</td>
                        <td>{{ $apz->commission->apzHeatResponse->thermal_energy_meters }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_supply_system)
                    <tr>
                        <td>Система теплоснабжения</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_supply_system }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_supply_system_note)
                    <tr>
                        <td>Примечание к системе теплоснабжения</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_supply_system_note }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_scheme)
                    <tr>
                        <td>Схема подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_scheme }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_scheme_note)
                    <tr>
                        <td>Примечание к схеме подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_scheme_note }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->after_control_unit_installation)
                    <tr>
                        <td>По завершении монтажа узла управления</td>
                        <td>{{ $apz->commission->apzHeatResponse->after_control_unit_installation }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->negotiation)
                    <tr>
                        <td>Согласование</td>
                        <td>{{ $apz->commission->apzHeatResponse->negotiation }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->technical_conditions_terms)
                    <tr>
                        <td>Срок действия технических условий</td>
                        <td>{{ $apz->commission->apzHeatResponse->technical_conditions_terms }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->addition)
                    <tr>
                        <td>Дополнительное</td>
                        <td>{{ $apz->commission->apzHeatResponse->addition }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->doc_number)
                    <tr>
                        <td>Согласно техническим условиям</td>
                        <td>№ {{ $apz->commission->apzHeatResponse->doc_number }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->created_at)
                    <tr>
                        <td>Дата выдачи ТУ</td>
                        <td>{{ date('d-m-Y', strtotime($apz->commission->apzHeatResponse->created_at)) }}</td>
                    </tr>
                @endif
            </table>
        @endif

        <br/>
        <p>Архитектурно-планировочное задание (АПЗ) и технические условия действуют в течение всего срока нормативной продолжительности строительства, утвержденной в составе проектной (проектно-сметной) документации</p>
        <br/>
        <p><b>город Алматы 2017 год</b></p>
    </div>

    <div>
        <p><b>ЖОБАЛАУҒА АРНАЛҒАН СӘУЛЕТ-ЖОСПАРЛАУ ТАПСЫРМАСЫ(СЖТ)</b></p>
        <p>2017 жылғы "09" қазандағы #413</p>
        <br/>
        <p><b>Объектінің атауы</b>: {{ $apz->project_name }}</p>
        <p><b>Объектінің мекенжайы, Аудан</b>: {{ $apz->project_address }}, {{ $apz->region }}</p>
        <p><b>Тапсырыс беруші (құрылыс салушы, инвестор)</b>: {{ $apz->customer }}</p>
        <p><b>Жобалаушы №МҚЛ, санаты</b>: {{ $apz->designer }}</p>
        <p><b>Арыз беруші</b>: {{ $apz->applicant }}</p>
        <p><b>Арыз берушінің мекенжайы мен телефоны</b>: {{ $apz->address }}, {{ $apz->phone }}</p>
        <br />

        <table width="100%">
            @if($apz->apzElectricity || $apz->apzGas)
                <tr>
                    @if($apz->apzElectricity)
                        <td width="50%">
                            <table border="1">
                                <tr>
                                    <th colspan="2">Электрмен жабдықтау бойынша мәлімет</th>
                                </tr>
                                <tr>
                                    <td>Требуемая мощность (кВт)</td>
                                    <td>{{ $apz->apzElectricity->required_power }}</td>
                                </tr>
                                <tr>
                                    <td>Характер нагрузки (фаза)</td>
                                    <td>{{ $apz->apzElectricity->phase }}</td>
                                </tr>
                                <tr>
                                    <td>Категория по надежности (кВт)</td>
                                    <td>{{ $apz->apzElectricity->safety_category }}</td>
                                </tr>
                                <tr>
                                    <td>Из указ. макс. нагрузки относ. к э-приемникам (кВА)</td>
                                    <td>{{ $apz->apzElectricity->max_load_device }}</td>
                                </tr>
                                <tr>
                                    <td>Существующая максимальная нагрузка (кВА)</td>
                                    <td>{{ $apz->apzElectricity->max_load }}</td>
                                </tr>
                                <tr>
                                    <td>Мощность трансформаторов (кВА)</td>
                                    <td>{{ $apz->apzElectricity->allowed_power }}</td>
                                </tr>
                            </table>
                            <br />
                        </td>
                    @endif

                    @if($apz->apzGas)
                        <td width="50%">
                            @if($apz->apzGas)
                                <table border="1">
                                    <tr>
                                        <th colspan="2">Газбен жабдықтау бойынша мәлімет</th>
                                    </tr>
                                    <tr>
                                        <td>Общая потребность (м<sup>3</sup>/час)</td>
                                        <td>{{ $apz->apzGas->general }}</td>
                                    </tr>
                                    <tr>
                                        <td>На приготовление пищи (м<sup>3</sup>/час)</td>
                                        <td>{{ $apz->apzGas->cooking }}</td>
                                    </tr>
                                    <tr>
                                        <td>Отопление (м<sup>3</sup>/час)</td>
                                        <td>{{ $apz->apzGas->heat }}</td>
                                    </tr>
                                    <tr>
                                        <td>Вентиляция (м<sup>3</sup>/час)</td>
                                        <td>{{ $apz->apzGas->ventilation }}</td>
                                    </tr>
                                    <tr>
                                        <td>Кондиционирование (м<sup>3</sup>/час)</td>
                                        <td>{{ $apz->apzGas->conditioner }}</td>
                                    </tr>
                                    <tr>
                                        <td>Горячее водоснабжение (м<sup>3</sup>/час)</td>
                                        <td>{{ $apz->apzGas->water }}</td>
                                    </tr>
                                </table>
                                <br />
                            @endif
                        </td>
                    @endif
                </tr>
            @endif
        </table>

        <br />

        @if($apz->commission->apzWaterResponse)
            <table border="1" width="100%">
                <tr>
                    <th colspan="2">Сумен жабдықтау бойынша мәлімет</th>
                </tr>
                <tr>
                    <td width="60%">Общая потребность в воде (м<sup>3</sup>/сутки)</td>
                    <td>{{ $apz->commission->apzWaterResponse->gen_water_req }}</td>
                </tr>
                <tr>
                    <td>Хозпитьевые нужды (м<sup>3</sup>/сутки)</td>
                    <td>{{ $apz->commission->apzWaterResponse->drinking_water }}</td>
                </tr>
                <tr>
                    <td>Производственные нужды (м<sup>3</sup>/сутки)</td>
                    <td>{{ $apz->commission->apzWaterResponse->prod_water }}</td>
                </tr>
                <tr>
                    <td>Расходы пожаротушения внутренные (л/сек)</td>
                    <td>{{ $apz->commission->apzWaterResponse->fire_fighting_water_in }}</td>
                </tr>
                <tr>
                    <td>Расходы пожаротушения внешные (л/сек)</td>
                    <td>{{ $apz->commission->apzWaterResponse->fire_fighting_water_out }}</td>
                </tr>
                <tr>
                    <td>Точка подключения</td>
                    <td>{{ $apz->commission->apzWaterResponse->connection_point }}</td>
                </tr>
                <tr>
                    <td>Рекомендация</td>
                    <td>{{ $apz->commission->apzWaterResponse->recommendation }}</td>
                </tr>
                <tr>
                    <td>Согласно техническим условиям</td>
                    <td>№ {{ $apz->commission->apzWaterResponse->doc_number }}</td>
                </tr>
                <tr>
                    <td>Дата выдачи ТУ</td>
                    <td>{{ date('d-m-Y', strtotime($apz->commission->apzWaterResponse->created_at)) }}</td>
                </tr>
            </table>
        @endif

        <br />

        @if($apz->commission->apzHeatResponse)
            <table border="1" width="100%">
                <tr>
                    <th colspan="2">Жылумен жабдықтау бойынша мәлімет</th>
                </tr>
                @if ($apz->commission->apzHeatResponse->resource)
                    <tr>
                        <td width="60%">Источник</td>
                        <td>{{ $apz->commission->apzHeatResponse->resource }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_point)
                    <tr>
                        <td>Точка подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_point }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->trans_pressure)
                    <tr>
                        <td>Давление теплоносителя {{ $apz->commission->apzHeatResponse->connection_point }}</td>
                        <td>{{ $apz->commission->apzHeatResponse->trans_pressure }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->load_contract_num)
                    <tr>
                        <td>Тепловые нагрузки по договору №</td>
                        <td>{{ $apz->commission->apzHeatResponse->load_contract_num }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->main_in_contract)
                    <tr>
                        <td>Отопление (Гкал/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->main_in_contract }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->ven_in_contract)
                    <tr>
                        <td>Вентиляция (Гкал/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->ven_in_contract }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_in_contract)
                    <tr>
                        <td>Горячее водоснабжение (ср/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_in_contract }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_in_contract_max)
                    <tr>
                        <td>Горячее водоснабжение (макс/ч)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_in_contract_max }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->name)
                    <tr>
                        <td>Наименование</td>
                        <td>{{ $apz->commission->apzHeatResponse->name }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->area)
                    <tr>
                        <td>Отапливаемая площадь</td>
                        <td>{{ $apz->commission->apzHeatResponse->area }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->transporter)
                    <tr>
                        <td>Транспортировка тепловой энергии осуществляется по</td>
                        <td>{{ $apz->commission->apzHeatResponse->transporter }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->two_pipe_pressure_in_tc)
                    <tr>
                        <td>Давление теплоносителя в ТК (2-трубной схеме)</td>
                        <td>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_tc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->two_pipe_pressure_in_sc)
                    <tr>
                        <td>Давление в подающем водоводе (2-трубной схеме)</td>
                        <td>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_sc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->two_pipe_pressure_in_rc)
                    <tr>
                        <td>Давление в обратном водоводе (2-трубной схеме)</td>
                        <td>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_rc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_tc)
                    <tr>
                        <td>Давление теплоносителя в ТК (4-трубной схеме, отопление)</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_tc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_sc)
                    <tr>
                        <td>Давление в подающем водоводе (4-трубной схеме, отопление)</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_sc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_rc)
                    <tr>
                        <td>Давление в обратном водоводе (4-трубной схеме, отопление)</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_rc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_four_pipe_pressure_in_tc)
                    <tr>
                        <td>Давление теплоносителя в ТК (4-трубной схеме, ГВС)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_tc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_four_pipe_pressure_in_sc)
                    <tr>
                        <td>Давление в подающем водоводе (4-трубной схеме, ГВС)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_sc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->water_four_pipe_pressure_in_rc)
                    <tr>
                        <td>Давление в обратном водоводе (4-трубной схеме, ГВС)</td>
                        <td>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_rc }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->temperature_chart)
                    <tr>
                        <td>Температурный график</td>
                        <td>{{ $apz->commission->apzHeatResponse->temperature_chart }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->reconcile_connections_with)
                    <tr>
                        <td>Дополнительные условия и место подключения согласовать с</td>
                        <td>{{ $apz->commission->apzHeatResponse->reconcile_connections_with }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_terms)
                    <tr>
                        <td>Условия подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_terms }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heating_networks_design)
                    <tr>
                        <td>Проектирование тепловых сетей</td>
                        <td>{{ $apz->commission->apzHeatResponse->heating_networks_design }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->final_heat_loads)
                    <tr>
                        <td>Окончательные тепловые нагрузки</td>
                        <td>{{ $apz->commission->apzHeatResponse->final_heat_loads }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_networks_relaying)
                    <tr>
                        <td>Перекладка тепловых сетей</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_networks_relaying }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->condensate_return)
                    <tr>
                        <td>Возврат конденсата</td>
                        <td>{{ $apz->commission->apzHeatResponse->condensate_return }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->thermal_energy_meters)
                    <tr>
                        <td>Приборы учета тепловой энергии</td>
                        <td>{{ $apz->commission->apzHeatResponse->thermal_energy_meters }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_supply_system)
                    <tr>
                        <td>Система теплоснабжения</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_supply_system }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->heat_supply_system_note)
                    <tr>
                        <td>Примечание к системе теплоснабжения</td>
                        <td>{{ $apz->commission->apzHeatResponse->heat_supply_system_note }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_scheme)
                    <tr>
                        <td>Схема подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_scheme }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->connection_scheme_note)
                    <tr>
                        <td>Примечание к схеме подключения</td>
                        <td>{{ $apz->commission->apzHeatResponse->connection_scheme_note }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->after_control_unit_installation)
                    <tr>
                        <td>По завершении монтажа узла управления</td>
                        <td>{{ $apz->commission->apzHeatResponse->after_control_unit_installation }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->negotiation)
                    <tr>
                        <td>Согласование</td>
                        <td>{{ $apz->commission->apzHeatResponse->negotiation }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->technical_conditions_terms)
                    <tr>
                        <td>Срок действия технических условий</td>
                        <td>{{ $apz->commission->apzHeatResponse->technical_conditions_terms }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->addition)
                    <tr>
                        <td>Дополнительное</td>
                        <td>{{ $apz->commission->apzHeatResponse->addition }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->doc_number)
                    <tr>
                        <td>Согласно техническим условиям</td>
                        <td>№ {{ $apz->commission->apzHeatResponse->doc_number }}</td>
                    </tr>
                @endif

                @if ($apz->commission->apzHeatResponse->created_at)
                    <tr>
                        <td>Дата выдачи ТУ</td>
                        <td>{{ date('d-m-Y', strtotime($apz->commission->apzHeatResponse->created_at)) }}</td>
                    </tr>
                @endif
            </table>
        @endif
        <br/>
        <p>Сәулет-жоспарлау тапсырмасы (СЖТ) және техникалық талаптар жобалау (жобалау-сметалық) құжаттарының құрамында бекітілген құрылыстың бүкіл нормативтік ұзақтылығы мерзімі ішінде қолданылады.</p>
        <br/>
        <p style="text-align: center;">
            <barcode code="{{ implode(' ', [$apz->apzHeadResponse->user->last_name, $apz->apzHeadResponse->user->first_name, $apz->apzHeadResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
            <barcode code="{{ implode(' ', [$apz_sign->user->last_name, $apz_sign->user->first_name, $apz_sign->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
        </p>
        <p><b>Алматы қаласы 2017 жыл</b></p>
    </div>
</body>
</html>
