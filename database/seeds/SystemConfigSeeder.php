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

            'secretariat_open_time'=>'09:00',
            'secretariat_close_time'=>'20:00',

            'inscriptions_start_date'=>Carbon::create('2018', '07', '01'),
            'first_provisional_inscr_list_date'=>Carbon::create('2018', '07', '18'),
            'second_provisional_inscr_list_date'=>Carbon::create('2018', '08', '15'),
            'final_inscr_list_date'=>Carbon::create('2018', '09', '01'),
            'enrolment_start_date'=>Carbon::create('2018', '09', '01'),
            'enrolment_end_date'=>Carbon::create('2018', '09', '31'),
            'provisional_minutes_date'=>Carbon::create('2018', '12', '24'),
            'final_minutes_date'=>Carbon::create('2018', '12', '31'),
            'academic_year_end_date'=>Carbon::create('2018', '12', '31'),


        ]);
    }
}
