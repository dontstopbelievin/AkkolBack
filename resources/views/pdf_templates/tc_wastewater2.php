<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>

    <!-- Styles -->
    <style type="text/css">
        p, table
        {
            text-align: center;
        }
        p .left
        {
            text-align: left;
        }
        .row
        {
            display: flex;
            flex-wrap: wrap;
            margin-right: 10px;
            margin-left: 30px;
        }
        .left{
            float: left!important;
            width:350px;
            height:150px;
            text-align: left;
        }
        .right{
            float: right!important;

        }
        .left p{
            text-align: left;
            margin-bottom: 40px;
        }

        .right p{
            text-align: right;
        }
        .name{
            float: left;
        }
        .name p{
            text-align: left;
        }
        .line{
            text-align: center;
            margin-bottom: 20px;
        }
        .text-left{
            text-align: left;
        }
        .title{
            margin-top: 70px;
        }
        table.text-left{
            padding-left: 120px;
        }
    </style>
</head>
<body>
<div>
    <div class="header">
        <p><b>Т Е Х Н И Ч Е С К И Е У С Л О В И Я «НА ВОДОСНАБЖЕНИЕ»</b></p><br />
        <div class="left">
<!--            <p><b>№ {{ $apz->commission->apzWasteWater2Response->doc_number }}</b></p>-->
            <p><i>05/3-7777-x от 22.12.2017</i></p>
        </div>
        <div class="right ">
            <p>СОГЛАСОВАНО<br />
                Государственное коммунальное<br />
                предприятие на праве хозяйственного<br />
                ведения «Алматы Су» Управления<br />
                энергетики и коммунального хозяйства<br />
                города Алматы (далее-Предприятие)<br />
            </p>
        </div>
    </div>

    <div class="container-fluid">
        <div class="name col-12">
            <p><i>Иванову И.И </i></p>
        </div>
        <div class="line col-12">
            <small><b>(кому выдается)</b></small>
        </div>
    </div>



    <div style="height: 80px;" class="container-fluid">
        <p class="text-left">
            <b>Наименование объекта</b>: {{ $apz->project_name }}
        </p>
    </div>
    <div style="height: 70px;" class="container-fluid">
        <p class="text-left"><b>Адрес:</b> {{ $apz->project_address }}, {{ $apz->region }}</p>
    </div>

    <p class="title">
        <b>I Водопотребление</b>
    </p>

    <table class="text-left" width="100%" >
        <tr>
            <td width="60%"><p>с расчетным расходом воды</p></td>
            <td><p>куб. м в </p></td>
        </tr>

        <tr>
            <td><p>с существующим расходом воды</p></td>
            <td><p>куб. м в </p></td>
        </tr>

        <tr>
            <td><p>общий объем водопотребления</p></td>
            <td><p><!--{{ $apz->commission->apzWaterResponse->gen_water_req }}--> куб. м в </p></td>
        </tr>

        <tr>
            <td><p>внутреннее пожаротушение</p></td>
            <td><p><!--{{ $apz->commission->apzWaterResponse->fire_fighting_water_in }}--> л/сек.</p></td>
        </tr>

        <tr>
            <td><p>наружное пожаротушение</p></td>
            <td><p><!--{{ $apz->commission->apzWaterResponse->fire_fighting_water_out }}--> л/сек.</p></td>
        </tr>
    </table>

    <br>

    <div class="container-fluid" style="page-break-after:always">
        <div style="height: 240px;"><b>1.1	Для подключения к городским сетям и сооружениям Заказчик обязан:</b></div>

        <b>1.2</b>  Давление в сети городского водопровода в точке подключения составляет ???? м вод. ст.<br/>
        <b>1.3</b>	В случае прохождения по территории Вашего земельного участка существующих ведомственных (частных) сетей водопровода, предусмотреть перенос данных сетей за границы отведенного земельного участка согласно требованиям СНиП, по согласованию с владельцами сетей.<br/>
        Размещение зданий, сооружений и ограждений, прилегающих к ним территорий Вашего объекта до существующих ведомственных (частных) сетей водопровода предусмотреть на расстоянии согласно требованиям СНиП, в противном случае предусмотреть перенос данных водопроводных сетей согласно требованиям СНиП.<br/>
        Проект выноса ведомственных (частных) сетей водопровода дополнительно согласовать с владельцами водопровода.<br/>
        При этом, переключение существующих потребителей предусмотреть от выносимых сетей водопровода.<br/>
        <b>1.4</b>	Установка приборов учета производится по согласованию с департаментом по сбыту Предприятия в соответствии со следующими требованиями:<br/>
        1.	Оборудование	узла учета, информационно-измерительных систем и<br/>
        автоматизированных систем учета энергопотребления, включая проектирование, демонтаж, монтаж (первичная и последующая установка), выполняются организациями, имеющими соответствующие разрешительные документы.<br/>

        2.	Диаметр условного прохода прибора учета воды следует выбирать, исходя из среднечасового расхода воды за период потребления (сутки, смену), который не должен превышать эксплуатационный. Расчет диаметра водомера выполнить как неотъемлемую часть проекта.<br/>
        3.	При монтаже прибора учета воды соблюдать технические требования зав ода-изготовителя в зависимости от типа и метрологического класса прибора учета воды. Монтаж всех приборов учета необходимо осуществлять строго в горизонтальном положении и обеспечить метрологический класс точности не ниже «С».<br/>
        4.	Узлы учета воды выполнить в местах, максимально приближенных к границе балансовой принадлежности трубопровода, либо в колодце на врезке. При монтаже индивидуальных приборов учета воды в многоквартирных жилых домах, обеспечить вывод показаний приборов учета на лестничную площадку.<br/>
        5.	Приборы учета воды оснастить средствами дистанционной передачи данных совместимыми с информационно-измерительной системой департамента по сбыту Предприятия.<br/>
        <b>1.5</b>	Внутреннее и наружное пожаротушение предусмотреть согласно требованиям СНиП, по расчету.<br/>
        Для нужд автоматического пожаротушения предусмотреть строительство резервуаров и насосной станции по расчету.<br/>
        На основных колодцах и пожарных гидрантах предусмотреть унифицированные знаки.<br/>
        <p>
            <b>II.	Другие требования.</b>
        </p>
        <b>2.1</b>	Заявитель (заказчик) обязан, в течении срока действия данных технических условий, с момента их получения, разработать и согласовать: проект водоснабжения объекта; проекты выноса, строительства и реконструкции существующих инженерных сетей и сооружений. В случае неисполнения заявителем (заказчиком) перечисленных выше обязательств в установленные сроки, технические условия считаются аннулированными в одностороннем порядке и претензии не принимаются.<br/>
        <b>2.2</b>	На стадии проектирования представить материалы генплана застройки территории объекта. Проект дополнительно согласовать с эксплуатационными службами департамента водопроводных сетей Предприятия. Копию согласованного проекта, выполненного согласно техническим условиям, представить для контроля в производственно-техническое управление Предприятия.<br/>
        <b>2.3</b>	При проектировании учесть наличие существующих систем водоснабжения. Для проектируемых холодильных установок, моек и технологических нужд предусмотреть оборотное водоснабжение.<br/>
        <b>2.4</b>	При проектировании и строительстве сетей водопровода применять упруго-запирающуюся запорную арматуру герметичности класса "А”.<br/>
        Для стальных труб предусмотреть электрохимзащиту, антикорозинное покрытие и гидроизоляцию типа «весьма усиленная», для полимерных труб предусмотреть материал согласно ГОСТ 18599-2001, соответствующий требованиям питьевой воде и укладку труб произвести согласно инструкции по проектированию и монтажу полиэтиленовых труб, предусмотреть укладку сигнальной (детекционной) ленты «водопровод» с металическим проводником.<br/>
        <b>2.5</b>	Проектирование и строительство (реконструкция) сетей и сооружений по данным техническим условиям должно быть завершено до начала строительства объекта или одновременно с ним.<br/>
        <b>2.6	В сводной смете строительно-монтажных работ предусмотреть затраты:</b><br/>
        а)	на подключение (переключение) построенных инженерных сетей объекта в действующие городские водопроводные сети;<br/>
        б)	на опорожнение трубопроводов и их дезинфекцию;<br/>
        в)	затраты на подключение в водопроводные сети, гидроиспытания и другие дополнительные работы (услуги) в случае их необходимости.<br/>
        <b>2.7</b>	До начала работ по прокладке инженерных сетей необходимо уведомить Управление ГАСК города Алматы о производстве работ.<br/>
        Выполненные работы по прокладке водопровода предъявлять для освидетельствования эксплуатационным службам департамента водопроводных сетей Предприятия и службам технического надзора.<br/>
        <b>2.8</b>	В случае проектирования и выполнения строительства сетей водопровода по территориям, находящимся в частном землепользовании, необходимо получить предварительное (нотариально заверенное) согласование от владельца земельного участка<br/>

        <b>2.9</b>	Выполнить исполнительную съемку построенных инженерных сетей.
        По завершении строительства объекта, до пуска его в эксплуатацию, сети и сооружения предъявить к сдаче эксплуатационными службами департамента водопроводных сетей и департаменту по сбыту Предприятия.<br/>
        <b>2.10</b>	Подключение к сетям водопровода, законченного строительством объекта, производится на основании согласованного Акта технической готовности систем водоснабжения.<br/>
        <p>
            <b>III.	Общие положения.</b>
        </p>
        <b>3.1</b>	В случае невыполнения заявителем (заказчиком), выданных технических условий в полном объеме, Предприятие не несет ответственность за водоснабжение этих объектов.<br/>
        <b>3.2</b>	Заявитель (заказчик) обязан в договорах с потенциальными владельцами жилых и коммерческих помещений указать о возможных перерывах в водоснабжении и водоотведении до окончания строительства сетей и сооружений по обеспечению города водными ресурсами.<br/>
        <b>3.3</b>	Предприятие оставляет за собой право внесения изменений и/или дополнений в выданные технические условия, если вновь принятыми нормативными правовыми актами (документами) Республики Казахстан будет изменен порядок и/или условия подключения объектов к системам водоснабжения.<br/>
        <b>3.4</b>	В случае ухудшения ситуации с водоснабжением города и районов нахождения объектов заявителя (заказчика), а так же в целях защиты прав существующих потребителей, Предприятие вправе внести необходимые изменения и/или дополнения в технические условия заявителя (заказчика).<br/>
        <b>3.5</b>	При самовольном присоединении (подключении) субабонента(ов) к сети заявителя (заказчика), последний обязан немедленно уведомить об этом эксплуатационные службы департамента водопроводных сетей Предприятия и принять меры по ликвидации (отключению) самовольного подключения. В противном случае владелец сети несет ответственность и возмещает все затраты, понесенные Предприятием и другими организациями, в случае возникновения повреждений, а также ущерб при возникновении аварийных ситуаций в следствии самовольного присоединения.<br/>
        <b>3.6	Технические условия действительны на нормативный срок строительства с момента их подписания и регистрации в производственно-техническом управлении Предприятия. Нормативный срок строительства определяется Управлением Архитектуры и Градостроительства города Алматы согласно архитектурно-планировочного задания.</b>
    </div>
</div>

<div class="header">
    <div class="left">
<!--        <p><b>№ {{ $apz->commission->apzWasteWaterResponse->doc_number }}</b></p>-->
        <p><i>05/3-5555-x от 22.12.2017</i></p>
    </div>
    <p><b>Т Е Х Н И Ч Е С К И Е У С Л О В И Я «НА ВОДООТВЕДЕНИЕ»</b></p><br />
    <div class="right ">
        <p>СОГЛАСОВАНО<br />
            Государственное коммунальное<br />
            предприятие на праве хозяйственного<br />
            ведения «Алматы Су» Управления<br />
            энергетики и коммунального хозяйства<br />
            города Алматы (далее-Предприятие)<br />
        </p>
    </div>
</div>

<div class="container-fluid">
    <div class="name col-12">
        <p><i>Иванову И.И </i></p>
    </div>
    <div class="line col-12">
        <small><b>(кому выдается)</b></small>
    </div>
</div>



<div style="height: 80px;" class="container-fluid">
    <p class="text-left">
        <b>Наименование объекта</b>: {{ $apz->project_name }}
    </p>
</div>
<div style="height: 70px;" class="container-fluid">
    <p class="text-left"><b>Адрес:</b> {{ $apz->project_address }}, {{ $apz->region }}</p>
</div>

<p class="title">
    <b>I Водопотребление</b>
</p>

<table class="text-left" width="100%" >
    <tr>
        <td width="60%"><p>с расчетным расходом воды</p></td>
        <td><p>куб. м в </p></td>
    </tr>

    <tr>
        <td><p>с существующим расходом воды</p></td>
        <td><p>куб. м в </p></td>
    </tr>

    <tr>
        <td><p>общий объем водопотребления</p></td>
        <td><p><!--{{ $apz->commission->apzWaterResponse->gen_water_req }}--> куб. м в </p></td>
    </tr>

    <tr>
        <td><p>внутреннее пожаротушение</p></td>
        <td><p><!--{{ $apz->commission->apzWaterResponse->fire_fighting_water_in }}--> л/сек.</p></td>
    </tr>

    <tr>
        <td><p>наружное пожаротушение</p></td>
        <td><p><!--{{ $apz->commission->apzWaterResponse->fire_fighting_water_out }}--> л/сек.</p></td>
    </tr>
</table>

<br>

<div class="container-fluid" style="page-break-after:always">
    <div style="height: 150px;"><b>1.1	Для присоединения к городским сетям и сооружениям водоотведения Заказчик обязан:</b></div>


    <b>1.2</b>	В случае прохождения по территории Вашего земельного участка существующих ведомственных (частных) сетей водоотведения, предусмотреть перенос данных сетей за границы отведенного земельного участка согласно требованиям СНиП , по согласованию с владельцами сетей.<br/>
    Размещение зданий, сооружений и ограждений, прилегающих к ним территорий Вашего объекта до существующих ведомственных (частных) сетей водоотведения предусмотреть на расстоянии согласно требованиям СНиП, в противном случае предусмотреть перенос данных сетей водоотведения согласно требованиям СНиП.<br/>
    Проект выноса ведомственных (частных) сетей водоотведения дополнительно согласовать с владельцами сетей водоотведения.<br/>
    При этом, переключение существующих потребителей предусмотреть в выносимые сети водоотведения.<br/>
    <b>1.3</b> 	В случае прохождения по территории Вашего земельного участка существующих ливневых сетей канализации, предусмотреть перенос данных сетей за границы отведенного земельного участка, выполнить согласно требованиям СНиП по согласованию с уполномоченным органом.<br/>
    <b>1.4</b>	Минимальный диаметр колодцев на сетях водоотведения города Алматы принять 1500мм.<br/>
    <b>1.5</b>	Для предприятий очистку сточных вод предусмотреть согласно требованиям СНиП и утвержденным ПДК загрязняющих веществ в производственных сточных водах, сбрасываемых в городские сети водоотведения.<br/>
    Для кафе, ресторанов и объектов общественного питания предусмотреть установку жироуловителя.<br/>
    <b>1.6</b>	Локальные очистные сооружения водоотведения и сооружения оборотной системы водоснабжения согласовать с местным территориальным департаментом по защите прав потребителей Агентства Республики Казахстан по защите прав потребителей.<br/>
    Септики предусмотреть согласно требованиям СНиП, после освидетельствования совместной комиссией департамента водоотведения Предприятия и акимата района расположения объекта.<br/>
    <b>1.7</b>	Сброс условно чистых вод осуществить в арычную сеть города или на полив газонов и зеленых насаждений.<br/>
    <b>1.8</b>	При проектировании наружных сетей водоотведения от объектов, имеющих санитарно- технические приборы, расположенные ниже отметки колодцев на существующей сети водоотведения, для исключения подтопления следует предусмотреть установку запорных устройств в подвалах или колодцах системы водоотведения на выпуске, препятствующих обратному току сточных вод с учетом подпоров на существующих сетях водоотведения.<br/>
    <p>
        <b>II.	Другие требования.</b>
    </p>
    <b>2.1</b>	Заявитель (заказчик) обязан в течении срока действия данных технических условий, с момента их получения, разработать и согласовать проект водоотведения объекта
    (подключения, выноса, строительства и реконструкции существующих инженерных сетей и сооружений). В <i>случае</i> неисполнения заявителем (заказчиком) перечисленных выше обязательств
    в установленные сроки,технические условия считаются аннулированными в одностороннем порядке и претензии не принимаются.<br/>
    <b>2.2</b>  На стадии проектирования представить материалы генплана застройки территории объекта. Проект дополнительно согласовать с эксплуатационными участками департамента водоотведения Предприятия.
    Копию согласованного проекта, выполненного согласно техническим условиям, представить для контроля в производственно ¬техническое управление Предприятия.<br/>
    <b>2.3</b>	При проектировании учесть наличие существующих систем водоотведения.
    Для проектируемых холодильных установок, моек и технологических нужд предусмотреть оборотное водоснабжение.<br/>
    <b>2.4</b>	При проектировании и строительстве напорных трубопроводов водоотведения применять упруго-запирающуюся запорную арматуру герметичности класса "А”.<br/>
    Для стальных труб предусмотреть электрохимзащиту, антикорозинное покрытие и гидроизоляцию типа «весьма усиленная», для полимерных труб предусмотреть укладку сигнальной (детекционной) ленты с металическим проводником.<br/>
    <b>2.5</b>	Проектирование и строительство (реконструкция) сетей и сооружений по данным техническим условиям должно быть завершено до начала строительства объекта или одновременно с ним.<br/>
    <b>2.6	В сводной смете строительно-монтажных работ предусмотреть затраты:</b><br/>
    а)	на технический надзор за строительством сетей и сооружений водоотведения;<br/>
    б)	на подключение (переключение) построенных инженерных сетей объекта в действующие городские сети водоотведения;<br/>
    в)	на опорожнение трубопроводов и их дезинфекцию;<br/>
    г)	затраты на врезку в сети водоотведения, гидроиспытания и другие дополнительные работы (услуги) в случае их необходимости.<br/>
    <b>2.7</b>	До начала работ по прокладке инженерных сетей необходимо уведомить Управление ГАСК города Алматы о производстве работ.<br/>
    Выполненные работы по прокладке водопровода предъявлять для освидетельствования эксплуатационным службам департамента водопроводных сетей Предприятия и службам технического надзора.<br/>
    <b>2.8</b>	В случае проектирования и выполнения строительства сетей водопровода по территориям, находящимся в частном землепользовании, необходимо получить предварительное (нотариально заверенное) согласование от владельца земельного участка<br/>

    <b>2.9</b>	Выполнить исполнительную съемку построенных инженерных сетей.
    По завершении строительства объекта, до пуска его в эксплуатацию, сети и сооружения предъявить к сдаче эксплуатационными службами департамента водопроводных сетей и департаменту по сбыту Предприятия.<br/>
    <b>2.10</b>	Подключение к сетям водоотведения, законченного строительством объекта, производится на основании согласованного Акта технической готовности систем водоотведения.<br/>
    <p>
        <b>III.	Общие положения.</b>
    </p>
    <b>3.1</b>	В случае невыполнения заявителем (заказчиком), выданных технических условий в полном объеме, Предприятие не несет ответственность за водоснабжение этих объектов.<br/>
    <b>3.2</b>	Заявитель (заказчик) обязан в договорах с потенциальными владельцами жилых и коммерческих помещений указать о возможных перерывах в водоснабжении и водоотведении до окончания строительства сетей и сооружений по обеспечению города водными ресурсами.<br/>
    <b>3.3</b>	Предприятие оставляет за собой право внесения изменений и/или дополнений в выданные технические условия, если вновь принятыми нормативными правовыми актами (документами) Республики Казахстан будет изменен порядок и/или условия подключения объектов к системам водоснабжения.<br/>
    <b>3.4</b>	В случае ухудшения ситуации с водоснабжением города и районов нахождения объектов заявителя (заказчика), а так же в целях защиты прав существующих потребителей, Предприятие вправе внести необходимые изменения и/или дополнения в технические условия заявителя (заказчика).<br/>
    <b>3.5</b>	При самовольном присоединении (подключении) субабонента(ов) к сети заявителя (заказчика), последний обязан немедленно уведомить об этом эксплуатационные службы департамента водопроводных сетей Предприятия и принять меры по ликвидации (отключению) самовольного подключения. В противном случае владелец сети несет ответственность и возмещает все затраты, понесенные Предприятием и другими организациями, в случае возникновения повреждений, а также ущерб при возникновении аварийных ситуаций в следствии самовольного присоединения.<br/>
    <b>3.6	Технические условия действительны на нормативный срок строительства с момента их подписания и регистрации в производственно-техническом управлении Предприятия. Нормативный срок строительства определяется Управлением Архитектуры и Градостроительства города Алматы согласно архитектурно-планировочного задания.</b>
</div>
</div>

<p style="text-align: center;">
    <barcode code="{{ implode(' ', [$apz->commission->apzWaterResponse->user->last_name, $apz->commission->apzWaterResponse->user->first_name, $apz->commission->apzWaterResponse->user->middle_name]) }}" type="QR" class="barcode" size="1" error="M" />
</p>
</body>
</html>