<?php

use App\SystemConfig;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemConfig::firstOrCreate([
            'max_summons_number'=>6,
            'max_annual_summons_number'=>3,


            'building_open_time'=>'09:00',
            'building_close_time'=>'20:00',

            'name_es'=>'Universidad de Sevilla',
            'name_en'=>'Seville University',

        ]);
    }
}
