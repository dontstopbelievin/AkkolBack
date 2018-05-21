<root>
    <content>
        <user user_id="{{ $apz->user->id }}">
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

        <apz apz_id="{{ $apz->id }}">
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

            @if ($apz->apzWater)
                <water>
                    <requirement>{{ $apz->apzWater->requirement }}</requirement>
                    <drinking>{{ $apz->apzWater->drinking }}</drinking>
                    <production>{{ $apz->apzWater->production }}</production>
                    <fire_fighting>{{ $apz->apzWater->fire_fighting }}</fire_fighting>
                    <sewage>{{ $apz->apzWater->sewage }}</sewage>
                    <status>{{ $apz->apzWater->status }}</status>
                </water>
            @endif

            @if ($apz->apzElectricity)
                <electricity>
                    <required_power>{{ $apz->apzElectricity->required_power }}</required_power>
                    <phase>{{ $apz->apzElectricity->phase }}</phase>
                    <safety_category>{{ $apz->apzElectricity->safety_category }}</safety_category>
                    <max_load_device>{{ $apz->apzElectricity->max_load_device }}</max_load_device>
                    <max_load>{{ $apz->apzElectricity->max_load }}</max_load>
                    <allowed_power>{{ $apz->apzElectricity->allowed_power }}</allowed_power>
                    <status>{{ $apz->apzElectricity->status }}</status>
                </electricity>
            @endif

            @if ($apz->apzGas)
                <gas>
                    <general>{{ $apz->apzGas->general }}</general>
                    <cooking>{{ $apz->apzGas->cooking }}</cooking>
                    <heat>{{ $apz->apzGas->heat }}</heat>
                    <ventilation>{{ $apz->apzGas->ventilation }}</ventilation>
                    <conditioner>{{ $apz->apzGas->conditioner }}</conditioner>
                    <water>{{ $apz->apzGas->water }}</water>
                    <status>{{ $apz->apzGas->status }}</status>
                </gas>
            @endif

            @if ($apz->apzHeat)
                <heat>
                    <general>{{ $apz->apzHeat->general }}</general>
                    <main>{{ $apz->apzHeat->main }}</main>
                    <ventilation>{{ $apz->apzHeat->ventilation }}</ventilation>
                    <water>{{ $apz->apzHeat->water }}</water>
                    <water_max>{{ $apz->apzHeat->water_max }}</water_max>
                    <tech>{{ $apz->apzHeat->tech }}</tech>
                    <distribution>{{ $apz->apzHeat->distribution }}</distribution>
                    <saving>{{ $apz->apzHeat->saving }}</saving>
                    <status>{{ $apz->apzHeat->status }}</status>
                </heat>
            @endif

            @if ($apz->apzPhone)
                <phone>
                    <service_num>{{ $apz->apzPhone->service_num }}</service_num>
                    <capacity>{{ $apz->apzPhone->capacity }}</capacity>
                    <sewage>{{ $apz->apzPhone->sewage }}</sewage>
                    <client_wishes>{{ $apz->apzPhone->client_wishes }}</client_wishes>
                    <status>{{ $apz->apzPhone->status }}</status>
                </phone>
            @endif

            @if ($apz->apzSewage)
                <sewage>
                    <amount>{{ $apz->apzSewage->amount }}</amount>
                    <feksal>{{ $apz->apzSewage->feksal }}</feksal>
                    <production>{{ $apz->apzSewage->production }}</production>
                    <to_city>{{ $apz->apzSewage->to_city }}</to_city>
                    <client_wishes>{{ $apz->apzSewage->client_wishes }}</client_wishes>
                    <status>{{ $apz->apzSewage->status }}</status>
                </sewage>
            @endif
        </apz>

        <provider provider_id="{{ $apz->commission->apzWaterResponse->user->id }}" type="water">
            <name>{{ $apz->commission->apzWaterResponse->user->name }}</name>
            <email>{{ $apz->commission->apzWaterResponse->user->email }}</email>

            @if ($apz->commission->apzWaterResponse->user->iin)
                <iin>{{ $apz->commission->apzWaterResponse->user->iin }}</iin>
            @endif

            @if ($apz->commission->apzWaterResponse->user->bin)
                <bin>{{ $apz->commission->apzWaterResponse->user->bin }}</bin>
            @endif

            <created_at>{{ $apz->commission->apzWaterResponse->user->created_at }}</created_at>
        </provider>

        <provider_answer response_id="{{ $apz->commission->apzWaterResponse->id }}" type="water">
            @if($apz->commission->apzWaterResponse->response)
                <gen_water_req>{{ $apz->commission->apzWaterResponse->gen_water_req }}</gen_water_req>
                <drinking_water>{{ $apz->commission->apzWaterResponse->drinking_water }}</drinking_water>
                <prod_water>{{ $apz->commission->apzWaterResponse->prod_water }}</prod_water>
                <fire_fighting_water_in>{{ $apz->commission->apzWaterResponse->fire_fighting_water_in }}</fire_fighting_water_in>
                <fire_fighting_water_out>{{ $apz->commission->apzWaterResponse->fire_fighting_water_out }}</fire_fighting_water_out>
                <connection_point>{{ $apz->commission->apzWaterResponse->connection_point }}</connection_point>
                <recommendation>{{ $apz->commission->apzWaterResponse->recommendation }}</recommendation>
            @else
                <response_text>{{ $apz->commission->apzWaterResponse->response_text }}</response_text>
                <comments>{{ $apz->commission->apzWaterResponse->comments }}</comments>
            @endif

            <doc_number>{{ $apz->commission->apzWaterResponse->doc_number }}</doc_number>
            <response>{{ $apz->commission->apzWaterResponse->response }}</response>
            <created_at>{{ $apz->commission->apzWaterResponse->created_at }}</created_at>
        </provider_answer>
    </content>
</root>