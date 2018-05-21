<?php

use App\ControlCheck;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ControlCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ControlCheck::firstOrCreate(['name'=>'First','description'=>'First control check',
            'date'=>'2017-06-19 16:00:00','is_submittable'=>false,
            'weight'=>0.4,'minimum_mark'=>4.0,'room_id'=>1,'subject_instance_id'=>5]);
        ControlCheck::firstOrCreate(['name'=>'Second','description'=>'Second control check',
            'date'=>'2017-07-19 16:00:00','is_submittable'=>false,
            'weight'=>0.4,'minimum_mark'=>4.0,'room_id'=>1,'subject_instance_id'=>5]);
        ControlCheck::firstOrCreate(['name'=>'Practice','description'=>'Laboratory control check',
            'date'=>'2017-07-21 16:00:00','is_submittable'=>true,
            'weight'=>0.2,'minimum_mark'=>5.0,'room_id'=>3,'subject_instance_id'=>5]);
        ControlCheck::firstOrCreate(['name'=>'Theory control','description'=>'Theory control for alternative evaluation',
            'date'=>'2017-07-10 16:00:00','is_submittable'=>false,
            'weight'=>0.8,'minimum_mark'=>5.0,'room_id'=>2,'subject_instance_id'=>11]);
        ControlCheck::firstOrCreate(['name'=>'Practice project','description'=>'Practice project for alternative evaluation',
            'date'=>'2017-07-14 16:00:00','is_submittable'=>false,
            'weight'=>0.2,'minimum_mark'=>4.0,'room_id'=>3,'subject_instance_id'=>11]);
    }
}