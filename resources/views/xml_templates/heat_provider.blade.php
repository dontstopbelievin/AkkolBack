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
                <water_max>{{ $apz->apzHeat->water_max }}</water_max>
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

        <provider provider_id="{{ $apz->commission->apzHeatResponse->user->id }}" type="heat">
            <name>{{ $apz->commission->apzHeatResponse->user->name }}</name>
            <email>{{ $apz->commission->apzHeatResponse->user->email }}</email>

            @if ($apz->commission->apzHeatResponse->user->iin)
                <iin>{{ $apz->commission->apzHeatResponse->user->iin }}</iin>
            @endif

            @if ($apz->commission->apzHeatResponse->user->bin)
                <bin>{{ $apz->commission->apzHeatResponse->user->bin }}</bin>
            @endif

            <created_at>{{ $apz->commission->apzHeatResponse->user->created_at }}</created_at>
        </provider>

        <provider_answer response_id="{{ $apz->commission->apzHeatResponse->id }}" type="heat">
            @if($apz->commission->apzHeatResponse->response)
                <trans_pressure>{{ $apz->commission->apzHeatResponse->trans_pressure }}</trans_pressure>
                <load_contract_num>{{ $apz->commission->apzHeatResponse->load_contract_num }}</load_contract_num>
                <main_in_contract>{{ $apz->commission->apzHeatResponse->main_in_contract }}</main_in_contract>
                <ven_in_contract>{{ $apz->commission->apzHeatResponse->ven_in_contract }}</ven_in_contract>
                <water_in_contract>{{ $apz->commission->apzHeatResponse->water_in_contract }}</water_in_contract>
                <water_in_contract_max>{{ $apz->commission->apzHeatResponse->water_in_contract_max }}</water_in_contract_max>
                <connection_point>{{ $apz->commission->apzHeatResponse->connection_point }}</connection_point>
                <addition>{{ $apz->commission->apzHeatResponse->addition }}</addition>
                <heat_name>{{ $apz->commission->apzHeatResponse->name }}</heat_name>
                <heat_area>{{ $apz->commission->apzHeatResponse->area }}</heat_area>
                <transporter>{{ $apz->commission->apzHeatResponse->transporter }}</transporter>
                <two_pipe_pressure_in_tc>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_tc }}</two_pipe_pressure_in_tc>
                <two_pipe_pressure_in_sc>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_sc }}</two_pipe_pressure_in_sc>
                <two_pipe_pressure_in_rc>{{ $apz->commission->apzHeatResponse->two_pipe_pressure_in_rc }}</two_pipe_pressure_in_rc>
                <heat_four_pipe_pressure_in_tc>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_tc }}</heat_four_pipe_pressure_in_tc>
                <heat_four_pipe_pressure_in_sc>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_sc }}</heat_four_pipe_pressure_in_sc>
                <heat_four_pipe_pressure_in_rc>{{ $apz->commission->apzHeatResponse->heat_four_pipe_pressure_in_rc }}</heat_four_pipe_pressure_in_rc>
                <water_four_pipe_pressure_in_tc>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_tc }}</water_four_pipe_pressure_in_tc>
                <water_four_pipe_pressure_in_sc>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_sc }}</water_four_pipe_pressure_in_sc>
                <water_four_pipe_pressure_in_rc>{{ $apz->commission->apzHeatResponse->water_four_pipe_pressure_in_rc }}</water_four_pipe_pressure_in_rc>
                <temperature_chart>{{ $apz->commission->apzHeatResponse->temperature_chart }}</temperature_chart>
                <reconcile_connections_with>{{ $apz->commission->apzHeatResponse->reconcile_connections_with }}</reconcile_connections_with>
                <connection_terms>{{ $apz->commission->apzHeatResponse->connection_terms }}</connection_terms>
                <heating_networks_design>{{ $apz->commission->apzHeatResponse->heating_networks_design }}</heating_networks_design>
                <final_heat_loads>{{ $apz->commission->apzHeatResponse->final_heat_loads }}</final_heat_loads>
                <heat_networks_relaying>{{ $apz->commission->apzHeatResponse->heat_networks_relaying }}</heat_networks_relaying>
                <condensate_return>{{ $apz->commission->apzHeatResponse->condensate_return }}</condensate_return>
                <thermal_energy_meters>{{ $apz->commission->apzHeatResponse->thermal_energy_meters }}</thermal_energy_meters>
                <heat_supply_system>{{ $apz->commission->apzHeatResponse->heat_supply_system }}</heat_supply_system>
                <heat_supply_system_note>{{ $apz->commission->apzHeatResponse->heat_supply_system_note }}</heat_supply_system_note>
                <connection_scheme>{{ $apz->commission->apzHeatResponse->connection_scheme }}</connection_scheme>
                <connection_scheme_note>{{ $apz->commission->apzHeatResponse->connection_scheme_note }}</connection_scheme_note>
                <after_control_unit_installation>{{ $apz->commission->apzHeatResponse->after_control_unit_installation }}</after_control_unit_installation>
                <negotiation>{{ $apz->commission->apzHeatResponse->negotiation }}</negotiation>
                <technical_conditions_terms>{{ $apz->commission->apzHeatResponse->technical_conditions_terms }}</technical_conditions_terms>
            @else
                <response_text>{{ $apz->commission->apzHeatResponse->response_text }}</response_text>
                <comments>{{ $apz->commission->apzHeatResponse->comments }}</comments>
            @endif

            <doc_number>{{ $apz->commission->apzHeatResponse->doc_number }}</doc_number>
            <response>{{ $apz->commission->apzHeatResponse->response }}</response>
            <created_at>{{ $apz->commission->apzHeatResponse->created_at }}</created_at>
        </provider_answer>
    </content>
</root>