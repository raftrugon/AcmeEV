<?php

use App\Subject;
use App\SubjectInstance;
use Faker\Factory;
use Illuminate\Database\Seeder;


class SubjectInstanceSeeder extends Seeder{

    public function run(){


        $faker = Factory::create();
        $id = 1;

        //////////////////////////////////////////////////////////////


        $subjects_id = Subject::all()->pluck('id')->toArray();

        foreach($subjects_id as $subject_id){

            $academic_year = $faker->numberBetween(2010, 2014);                         //Año de comienzo de la asignatura
            $endFor = date('Y');                                                 //Año actual


            for($j = $academic_year; $j < $endFor; $j++){                               //Crea instancias desde el año de comienzo hasta el actual
                SubjectInstance::firstOrCreate([
                    'id'=>$id,
                    'academic_year'=>$j,
                    'subject_id'=>$subject_id
                ]);

                $id++;
            }
        }
    }
}