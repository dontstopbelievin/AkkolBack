<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInHeatResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->string('name', 255)->nullable()->after('resource')->comment('Наименование');
            $table->string('area', 255)->nullable()->after('connection_point')->comment('Отапливаемая площадь');
            $table->string('transporter', 255)->nullable()->after('area')->comment('Транспортировка тепловой энергии осуществляется по');

            $table->string('two_pipe_pressure_in_tc', 255)->nullable()->after('transporter')->comment('Давление теплоносителя в ТК (2-трубной схеме)');
            $table->string('two_pipe_pressure_in_sc', 255)->nullable()->after('two_pipe_pressure_in_tc')->comment('Давление в подающем водоводе (2-трубной схеме)');
            $table->string('two_pipe_pressure_in_rc', 255)->nullable()->after('two_pipe_pressure_in_sc')->comment('Давление в обратном водоводе (2-трубной схеме)');

            $table->string('heat_four_pipe_pressure_in_tc', 255)->nullable()->after('two_pipe_pressure_in_rc')->comment('Давление теплоносителя в ТК (4-трубной схеме, отопление)');
            $table->string('heat_four_pipe_pressure_in_sc', 255)->nullable()->after('heat_four_pipe_pressure_in_tc')->comment('Давление в подающем водоводе (4-трубной схеме, отопление)');
            $table->string('heat_four_pipe_pressure_in_rc', 255)->nullable()->after('heat_four_pipe_pressure_in_sc')->comment('Давление в обратном водоводе (4-трубной схеме, отопление)');

            $table->string('water_four_pipe_pressure_in_tc', 255)->nullable()->after('heat_four_pipe_pressure_in_rc')->comment('Давление теплоносителя в ТК (4-трубной схеме, ГВС)');
            $table->string('water_four_pipe_pressure_in_sc', 255)->nullable()->after('water_four_pipe_pressure_in_tc')->comment('Давление в подающем водоводе (4-трубной схеме, ГВС)');
            $table->string('water_four_pipe_pressure_in_rc', 255)->nullable()->after('water_four_pipe_pressure_in_sc')->comment('Давление в обратном водоводе (4-трубной схеме, ГВС)');

            $table->string('temperature_chart', 255)->nullable()->after('water_four_pipe_pressure_in_rc')->comment('Температурный график');
            $table->string('reconcile_connections_with', 255)->nullable()->after('temperature_chart')->comment('Дополнительные условия и место подключения согласовать с');
            $table->text('connection_terms')->nullable()->after('reconcile_connections_with')->comment('Условия подключения');
            $table->text('heating_networks_design')->nullable()->after('connection_terms')->comment('Проектирование тепловых сетей');
            $table->text('final_heat_loads')->nullable()->after('heating_networks_design')->comment('Окончательные тепловые нагрузки');
            $table->text('heat_networks_relaying')->nullable()->after('final_heat_loads')->comment('Перекладка тепловых сетей');
            $table->text('condensate_return')->nullable()->after('heat_networks_relaying')->comment('Возврат конденсата');
            $table->text('thermal_energy_meters')->nullable()->after('condensate_return')->comment('Приборы учета тепловой энергии');
            $table->string('heat_supply_system', 255)->nullable()->after('thermal_energy_meters')->comment('Система теплоснабжения');
            $table->text('heat_supply_system_note')->nullable()->after('heat_supply_system')->comment('Примечание к системе теплоснабжения');
            $table->string('connection_scheme', 255)->nullable()->after('heat_supply_system_note')->comment('Схема подключения');
            $table->text('connection_scheme_note')->nullable()->after('connection_scheme')->comment('Примечание к схеме подключения');
            $table->text('after_control_unit_installation')->nullable()->after('connection_scheme_note')->comment('По завершении монтажа узла управления');
            $table->text('negotiation')->nullable()->after('after_control_unit_installation')->comment('Согласование');
            $table->text('technical_conditions_terms')->nullable()->after('negotiation')->comment('Срок действия технических условий');
            $table->string('water_in_contract', 255)->nullable()->comment('Горячее водоснабжение (ср/ч)')->change();
            $table->string('water_in_contract_max', 255)->nullable()->after('water_in_contract')->comment('Горячее водоснабжение (макс/ч)');
        });

        Schema::table('apz_heats', function (Blueprint $table) {
            $table->float('water_max', 11,3)->nullable()->after('water')->comment('Горячее водоснабжение (макс/ч)');
            $table->float('water', 11,3)->nullable()->comment('Горячее водоснабжение (ср/ч)')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apz_provider_heat_responses', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('area');
            $table->dropColumn('transporter');
            $table->dropColumn('two_pipe_pressure_in_tc');
            $table->dropColumn('two_pipe_pressure_in_sc');
            $table->dropColumn('two_pipe_pressure_in_rc');
            $table->dropColumn('heat_four_pipe_pressure_in_tc');
            $table->dropColumn('heat_four_pipe_pressure_in_sc');
            $table->dropColumn('heat_four_pipe_pressure_in_rc');
            $table->dropColumn('water_four_pipe_pressure_in_tc');
            $table->dropColumn('water_four_pipe_pressure_in_sc');
            $table->dropColumn('water_four_pipe_pressure_in_rc');
            $table->dropColumn('temperature_chart');
            $table->dropColumn('reconcile_connections_with');
            $table->dropColumn('connection_terms');
            $table->dropColumn('heating_networks_design');
            $table->dropColumn('final_heat_loads');
            $table->dropColumn('heat_networks_relaying');
            $table->dropColumn('condensate_return');
            $table->dropColumn('thermal_energy_meters');
            $table->dropColumn('heat_supply_system');
            $table->dropColumn('heat_supply_system_note');
            $table->dropColumn('connection_scheme');
            $table->dropColumn('connection_scheme_note');
            $table->dropColumn('after_control_unit_installation');
            $table->dropColumn('negotiation');
            $table->dropColumn('technical_conditions_terms');
        });

        Schema::table('apz_heats', function (Blueprint $table) {
            $table->float('water', 11,3)->nullable()->comment('Горячее водоснабжение')->change();
            $table->dropColumn('water_max');
        });
    }
}
