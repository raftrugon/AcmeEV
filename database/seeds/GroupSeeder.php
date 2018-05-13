<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder{

    public function run(){
        Group::firstOrCreate(['id'=>1,'number'=>1,'subject_instance_id'=>1,'theory_lecturer_id'=>1,'practice_lecturer_id'=>2]);
        Group::firstOrCreate(['id'=>2,'number'=>2,'subject_instance_id'=>1,'theory_lecturer_id'=>1,'practice_lecturer_id'=>2]);
    }
}