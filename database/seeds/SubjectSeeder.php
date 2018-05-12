<?php

use App\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder{

    public function run(){
        Subject::firstOrCreate(['id'=>1,'name'=>'Física','code'=>'USSUB00001','subject_type'=>'OBLIGATORY','school_year'=>1,'semester'=>true,'department_id'=>2,'degree_id'=>1,'coordinator_id'=>1]);
        Subject::firstOrCreate(['id'=>2,'name'=>'Estadística','code'=>'USSUB00002','subject_type'=>'OBLIGATORY','school_year'=>2,'semester'=>false,'department_id'=>5,'degree_id'=>1,'coordinator_id'=>1]);
    }
}