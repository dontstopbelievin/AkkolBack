<root>
    <content>
        <user id="{{ $apz->user->id }}">
            <name>{{ $apz->user->name }}></name>
            <email>{{ $apz->user->email }}</email>

            @if ($apz->user->iin)
                <iin>{{ $apz->user->iin }}</iin>
            @endif

            @if ($apz->user->bin)
                <bin>{{ $apz->user->bin }}</bin>
            @endif

            @if ($apz->user->company_name)
                <company_name>{{ $apz->user->company_name }}</company_name>
            @endif

            <created_at>{{ $apz->user->created_at }}</created_at>
        </user>

        <apz id="{{ $apz->id }}">
            <region>{{ $apz->region }}</region>
            <project_type>{{ $apz->project_type }}</project_type>
            <applicant>{{ $apz->applicant }}</applicant>
            <address>{{ $apz->address }}</address>
            <phone>{{ $apz->phone }}</phone>
            <customer>{{ $apz->customer }}</customer>
            <designer>{{ $apz->designer }}</designer>
            <object_type>{{ $apz->object_type }}</object_type>
            <object_level>{{ $apz->object_level }}</object_level>
            <object_client>{{ $apz->object_client }}</object_client>
            <object_area>{{ $apz->object_area }}</object_area>
            <object_rooms>{{ $apz->object_rooms }}</object_rooms>
            <object_term>{{ $apz->object_term }}</object_term>
            <project_name>{{ $apz->project_name }}</project_name>
            <project_address>{{ $apz->project_address }}</project_address>
            <project_address_coordinates>{{ $apz->project_address_coordinates }}</project_address_coordinates>
            <cadastral_number>{{ $apz->cadastral_number }}</cadastral_number>
            <status>{{ $apz->apzStatus->name }}</status>
            <created_at>{{ $apz->created_at }}</created_at>

            <water>
                <requirement>{{ $apz->apzWater->requirement }}</requirement>
                <drinking>{{ $apz->apzWater->drinking }}</drinking>
                <production>{{ $apz->apzWater->production }}</production>
                <fire_fighting>{{ $apz->apzWater->fire_fighting }}</fire_fighting>
                <sewage>{{ $apz->apzWater->sewage }}</sewage>
                <status>{{ $apz->apzWater->status }}</status>
            </water>

            <electricity>
                <required_power>{{ $apz->apzElectricity->required_power }}</required_power>
                <phase>{{ $apz->apzElectricity->phase }}</phase>
                <safety_category>{{ $apz->apzElectricity->safety_category }}</safety_category>
                <max_load_device>{{ $apz->apzElectricity->max_load_device }}</max_load_device>
                <max_load>{{ $apz->apzElectricity->max_load }}</max_load>
                <allowed_power>{{ $apz->apzElectricity->allowed_power }}</allowed_power>
                <status>{{ $apz->apzElectricity->status }}</status>
            </electricity>

            <gas>
                <general>{{ $apz->apzGas->general }}</general>
                <cooking>{{ $apz->apzGas->cooking }}</cooking>
                <heat>{{ $apz->apzGas->heat }}</heat>
                <ventilation>{{ $apz->apzGas->ventilation }}</ventilation>
                <conditioner>{{ $apz->apzGas->conditioner }}</conditioner>
                <water>{{ $apz->apzGas->water }}</water>
                <status>{{ $apz->apzGas->status }}</status>
            </gas>

            <heat>
                <general>{{ $apz->apzHeat->general }}</general>
                <main>{{ $apz->apzHeat->main }}</main>
                <ventilation>{{ $apz->apzHeat->ventilation }}</ventilation>
                <water>{{ $apz->apzHeat->water }}</water>
                <tech>{{ $apz->apzHeat->tech }}</tech>
                <distribution>{{ $apz->apzHeat->distribution }}</distribution>
                <saving>{{ $apz->apzHeat->saving }}</saving>
                <status>{{ $apz->apzHeat->status }}</status>
            </heat>

            <phone>
                <service_num>{{ $apz->apzPhone->service_num }}</service_num>
                <capacity>{{ $apz->apzPhone->capacity }}</capacity>
                <sewage>{{ $apz->apzPhone->sewage }}</sewage>
                <client_wishes>{{ $apz->apzPhone->client_wishes }}</client_wishes>
                <status>{{ $apz->apzPhone->status }}</status>
            </phone>

            <sewage>
                <amount>{{ $apz->apzSewage->amount }}</amount>
                <feksal>{{ $apz->apzSewage->feksal }}</feksal>
                <production>{{ $apz->apzSewage->production }}</production>
                <to_city>{{ $apz->apzSewage->to_city }}</to_city>
                <client_wishes>{{ $apz->apzSewage->client_wishes }}</client_wishes>
                <status>{{ $apz->apzSewage->status }}</status>
            </sewage>
        </apz>

        <apz_department_info id="{{ $user->id }}">
            <name>{{ $user->name }}</name>
            <email>{{ $user->email }}</email>

            @if ($user->iin)
                <iin>{{ $user->iin }}</iin>
            @endif

            @if ($user->bin)
                <bin>{{ $user->bin }}</bin>
            @endif

            <created_at>{{ $user->created_at }}</created_at>
        </apz_department_info>
    </content>
</root>