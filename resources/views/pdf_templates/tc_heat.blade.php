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
                <p><span></span>№<span>{{ $apz->commission->apzHeatResponse->doc_number }}</span></p>
                <p class="underline">на  № 312&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;от&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20.11.2018</p>
                <p class="third">вх.№ 22878&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;от&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21.11.2018 </p>

            </div>

            <div class="too">
                <h4>ТОО «Asia Prom Resources»  </h4>
            </div>
        </header>

        <div class="section">

            <div>
                <ol>
                    <li>Теплоснабжение осуществляется от источников</li>
                    <li>Точка подключения: {{ $apz->commission->apzHeatResponse->connection_point }}. Дополнительные условия и место подключения согласовать с ЦЭР ТОО «АлТС»  (тел. 274-04-47).<br/>
                        <span style="color: #00b050">- Подключение выполнить по технологии присоединения к предызолированным трубопроводам.<br/>
                        - <b>Размещение зданий и сооружений Вашего объекта предусмотреть на расстоянии с учетом соблюдения охранной зоны тепловых сетей 2dy_____ мм,
                        проложенных __________ Вашего объекта. В противном случае выполнить их вынос из-под пятна застройки с переключением существующих потребителей.
                                Проект выноса тепловых сетей согласовать с ТОО «АлТС».</b></span><br />
                        Регулирование отпуска тепла: качественное по температурному графику –<sup>о</sup>С.
                    </li>
                    <li>Давление теплоносителя в тепловой камере {{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_tc }}:<br/>
                        <span>- в подающем водоводе 	 _,_ ати<br/>
                              - в обратном водоводе 	 _,_ ати</span>
                    </li>
                    <li>Тепловые сети запроектировать с применением предварительно изолированных трубопроводов с устройством системы оперативного дистанционного контроля.
                        Способ прокладки тепловых сетей определить проектом с учетом требований МСН 4.02-02-2004 «Тепловые сети».
                        После выполнения работ комплект исполнительной документации на бумажном носителе и в электронном исполнении, зарегистрированный в                 КГУ «Управление архитектуры и градостроительства г. Алматы», передать в ТОО «АлТС».
                    </li>
                    <li>Тепловые нагрузки, Гкал/ч:
                        <table class="heat_info">
                            <tr>
                                <td rowspan="2">Наименование нагрузки</td>
                                <td rowspan="2">Запрашиваемые</td>
                                <td rowspan="2">По договору               №           от            г.</td>
                                <td colspan="2">Прирост</td>
                            </tr>
                            <tr>
                                <td class="last-col">Гкал/ч</td>
                                <td class="last-col">%</td>
                            </tr>
                            <tr>
                                <td>Отопление</td>
                                <td>&nbsp;</td>
                                <td>см.договор</td>
                                <td class="last-col">???</td>
                                <td class="last-col">???</td>
                            </tr>
                            <tr>
                                <td>Вентиляция</td>
                                <td></td>
                                <td></td>
                                <td class="last-col">0</td>
                                <td class="last-col">???</td>
                            </tr>
                            <tr>
                                <td>Горячее водоснаб-жение, макс/ч</td>
                                <td></td>
                                <td></td>
                                <td class="last-col">0</td>
                                <td class="last-col">???</td>
                            </tr>
                            <tr>
                                <td>Горячее водоснаб-жение, ср/ч</td>
                                <td></td>
                                <td></td>
                                <td class="last-col"></td>
                                <td class="last-col"></td>
                            </tr>
                            <tr>
                                <th>ИТОГО:</th>
                                <th>000</th>
                                <th>000</th>
                                <th class="last-col">???</th>
                                <th class="last-col">???</th>
                            </tr>
                        </table>
                    </li>
                    <li>Окончательные тепловые нагрузки уточнить проектом и согласовать с Оперативно-диспетчерским управлением ТОО «АлТС» (тел.: 378-07-00, вн.1007).
                        Договор на оказание услуг по передаче и распределению тепловой энергии будет заключен на согласованную уточненную тепловую нагрузку.
                        В соответствии с п. 12.1 СНиП РК 4.02-42-2006 «Отопление, вентиляция и кондиционирование» в системе вентиляции при обосновании предусмотреть
                        устройства утилизации теплоты вентиляционных выбросов (рекуперация, рециркуляция вытяжного воздуха) с учетом пунктов 12.2, 12.5 СНиП РК 4.02-42-2006
                        «Отопление, вентиляция и кондиционирование».
                    </li>
                    <li style="color: #00b050">В связи с увеличением циркуляционного расхода выполнить перекладку тепловых сетей от ТК ___  до ТК ___ с увеличением диаметра с 2Dу___ мм на 2Dу___ мм.
                        Реконструируемые тепловые сети в установленном порядке передать на баланс ТОО «АлТС». <br/>
                        - Выполнить поверочный расчет диаметров трубопроводов внутриплощадочных тепловых сетей с учетом дополнительно подключаемой нагрузки. В случае необходимости – выполнить их замену.

                    </li>
                    <li style="color: #00b050">Возврат конденсата не предусмотрен.</li>
                    <li> На вводе <span style="color: #00b050"> для каждой категории абонентов</span> установить <span style="color: #00b050">прибор</span> учета тепловой энергии, оборудованный модемной связью.
                        <span style="color: #00b050">Системы отопления и горячего водоснабжения каждой квартиры оборудовать индивидуальными приборами учета расхода теплоты и горячей воды с возможностью
                            дистанционного снятия показаний.</span> Проект на установку системы учета, схему организации учета,
                        место установки приборов учета  согласовать со Службой контроля приборов учета тепловой энергии ТОО «АлТС» (тел.: 341-07-77, вн. 2140).</li>
                    <li style="color: #00b050">Система теплоснабжения:<br />
                        a)открытая. Предусмотреть догрев ГВС в межотопительный период.<br/>
                        б)закрытая.<br/>
                        <span style="color: #000;"> Предусмотреть тепловую изоляцию разводящих трубопроводов и стояков системы горячего водоснабжения.</span>
                        При присоединении распределительной гребенки индивидуальных потребителей к  стояку общедомовой системы горячего водоснабжения предусмотреть установку обратного клапана.
                    </li>
                    <li style="color: #00b050">Подключение выполнить через<br/>
                        а) узел управления с автоматическим регулированием теплопотребления по зависимой схеме. В случае применения в системе отопления трубопроводов из полимерных материалов – проектирование
                        вести с учетом требований п. 7.1.3 СНиП РК 4.02-42-2006 «Отопление, вентиляция и кондиционирование».<br/>
                        б) узел управления с автоматическим регулированием теплопотребления по независимой схеме.<br/>
                        <b style="color: #000;">По завершении монтажа узла управления выполнить пуско-наладочные работы по автоматизации теплового пункта.</b>
                    </li>
                    <li>После предварительного согласования с ЦЭР ТОО «АлТС» проектную документацию (чертежи марки ОВ, ТС, сводный план инженерных сетей) согласовать с
                        Техническим отделом ТОО «АлТС» (тел.: 378-07-00, вн. 1023). Согласованный проект на бумажном и электронном носителях предоставить в ТОО «АлТС».
                    </li>
                    <li><b>Срок действия технических условий:</b> нормативный период проектирования и строительства, предусмотренный в проектно-сметной документации.</li>
                    <li></li>
                </ol>
            </div>
            <div class="footer">
                <h3 style="text-align:left;float: left;width: 350px;color: #000;">Главный инженер</h3>
                <h3  style="color: #000;">Д. Кирдяйкин</h3>
                <h2 style="color: red">Долг перед ТОО «АлТС»:</h2>
                <p>Исп. {{ $apz->commission->apzHeatResponse->user->name }}<br/>
                    тел.: 378-07-00 вн.{{ $apz->phone }}
                </p>
            </div>

        </div>
    </div>
    </div>
    <p style="text-align: center;">
        <barcode code="{{ implode(' ', [$apz->commission->apzHeatResponse->user->last_name, $apz->commission->apzHeatResponse->user->first_name, $apz->commission->apzHeatResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
    </p>
</body>
</html>
