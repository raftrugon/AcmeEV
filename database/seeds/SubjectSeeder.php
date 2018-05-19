<?php

use App\Degree;
use App\Department;
use App\Subject;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder{

    public function run(){


        $faker = Factory::create();
        $id = 1;


        //////////////////////////////////////////////////////////////////////////////////////////////////////

        $degrees_id = Degree::all()->pluck('id')->toArray();

        foreach($degrees_id as $degree_id){                         //Por cada grado

            $edp = true;

            for($i = 1; $i < 5; $i++) {                             //Por cada curso

                $subjects_per_year = $faker->numberBetween(4, 6);   //Numero aleatorio de asignaturas por año

                for($j = 0; $j < $subjects_per_year; $j++) {        //Crea $subjects_per_year asignaturas


                    $department_id = $faker->randomElement(Department::all()->pluck('id')->toArray());
                    $subject_type = 'OBLIGATORY';

                    //Tipo de asignatura
                    switch($i){
                        case 1:
                            $subject_type = 'BASIC';
                            break;
                        case 4:
                            if($edp){
                                $edp = false;
                                $subject_type = 'EDP';
                                break;
                            }
                            $subject_type = $faker->randomElement(['OBLIGATORY', 'OPTATIVE']);
                    };

                    Subject::firstOrCreate([
                        'id' => $id,
                        'name' => $faker->words(4, true),
                        'code' => $faker->unique()->regexify('[A-Z]{3}[0-9]{6}'),
                        'school_year' => $i,
                        'semester' => $faker->boolean(70) ? $faker->boolean() : null,
                        'department_id' => $department_id,
                        'degree_id' => $degree_id,
                        'coordinator_id' => $faker->randomElement(User::where('department_id', $department_id)->get()->toArray()),
                        'subject_type' => $subject_type
                    ]);

                    $id++;  //Incremento de id
                }
            }
        }
    }
}