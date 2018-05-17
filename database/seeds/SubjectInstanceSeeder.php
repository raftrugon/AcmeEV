<?php

use App\Subject;
use App\SubjectInstance;
use Faker\Factory;
use Illuminate\Database\Seeder;


class SubjectInstanceSeeder extends Seeder{

    public function run(){
        //SubjectInstance::firstOrCreate(['id'=>1,'academic_year'=>2019,'subject_id'=>1]);
        //SubjectInstance::firstOrCreate(['id'=>2,'academic_year'=>2019,'subject_id'=>2]);

        $faker = Factory::create();
        $id = 1;
        $subjects_id = Subject::all()->pluck('id')->toArray();

        //for($i = 0; $i < 10; $i++){
        foreach($subjects_id as $subject_id){
            $academic_year = $faker->numberBetween(2008, 2013);                                    //Año de comienzo de la asignatura
            $endFor = date('Y');                                                            //Año actual


            for($j = $academic_year; $j < $endFor; $j++){                                          //Crea instancias desde el año de comienzo hasta el actual
                SubjectInstance::firstOrCreate(['id'=>$id,'academic_year'=>$j,'subject_id'=>$subject_id]);
                $id++;
            }
        }
    }
}