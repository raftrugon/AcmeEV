<?php

use App\Subject;
use App\SubjectInstance;
use Faker\Factory;
use Illuminate\Database\Seeder;


class SubjectInstanceSeeder extends Seeder{

    public function run(){


        $faker = Factory::create();


        $initial_possible_year = 2011;
        $end_possible_year = 2013;
        $endFor = date('Y');                                                 //Año actual

        if(date('m') > 8)                                                    //Si ha pasado septiembre crea las de este año tambien
            $endFor++;

        $minimum_seeds = $endFor - $end_possible_year + 1;
        $maximum_seeds = $endFor - $initial_possible_year + 1;

        //////////////////////////////////////////////////////////////


        $subjects_id = Subject::all()->pluck('id')->toArray();
        $count = count($subjects_id);

        info('Seeding from '.$minimum_seeds.' to '.$maximum_seeds.' Subjects Instance for each Subject(From a year until actual year. '.$count.' Subjects).');

        foreach($subjects_id as $subject_id){

            $academic_year = $faker->numberBetween($initial_possible_year, $end_possible_year);                         //Año de comienzo de la asignatura



            for($j = $academic_year; $j <= $endFor; $j++){                               //Crea instancias desde el año de comienzo hasta el actual
                SubjectInstance::firstOrCreate([
                    'academic_year'=>$j,
                    'subject_id'=>$subject_id
                ]);

            }
        }
    }
}