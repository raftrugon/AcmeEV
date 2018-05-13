<?php

use App\SubjectInstance;
use Illuminate\Database\Seeder;

class SubjectInstanceSeeder extends Seeder{

    public function run(){
        SubjectInstance::firstOrCreate(['id'=>1,'academic_year'=>2019,'subject_id'=>1]);
        SubjectInstance::firstOrCreate(['id'=>2,'academic_year'=>2019,'subject_id'=>2]);
    }
}