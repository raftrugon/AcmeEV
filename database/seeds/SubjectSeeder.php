<?php

use App\Degree;
use App\Department;
use App\Repositories\UserRepo;
use App\Subject;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder{

    public function run(){


        $faker = Factory::create();

        $minimum_number_subjects_course = 4;
        $maximum_number_subjects_course = 6;

        $subject_part_1 = ['Ingeniería de ', 'Teoría de ', 'Investigación de ', 'Prácticas con ', 'Investigación experimental de ', 'Teorización con '];
        $subject_part_2 = ['Materiales ', 'Software ', 'Hardware ', 'la Salud ', 'Aviones ', 'Coches ', 'Locomotoras ', 'Periféricos '];
        $subject_part_3 = ['Nivel Básico', 'Nivel Avanzado', 'Nivel Elemental', 'Nivel Superior', ''];


        //////////////////////////////////////////////////////////////////////////////////////////////////////

        $degrees_id = Degree::all()->pluck('id')->toArray();
        $count = count($degrees_id);

        info('Seeding from '.$minimum_number_subjects_course.' to '.$maximum_number_subjects_course.' Subjects for each course of a Degree and setting one to EDP('.$count.' Degree).');


        foreach($degrees_id as $degree_id){                         //Por cada grado



            for($i = 1; $i < 5; $i++) {                             //Por cada curso

                $subjects_per_course = $faker->numberBetween($minimum_number_subjects_course, $maximum_number_subjects_course);   //Numero aleatorio de asignaturas por año

                for($j = 0; $j < $subjects_per_course; $j++) {        //Crea $subjects_per_course asignaturas


                    $department_id = $faker->randomElement(Department::all()->pluck('id')->toArray());
                    $subject_type = 'OBLIGATORY';

                    //Tipo de asignatura
                    switch($i){
                        case 1:
                            $subject_type = 'BASIC';
                            break;
                        case 4:
                            $subject_type = $faker->randomElement(['OBLIGATORY', 'OPTATIVE']);
                    };

                    Subject::firstOrCreate([
                        'name' => $faker->randomElement($subject_part_1).$faker->randomElement($subject_part_2).$faker->randomElement($subject_part_3),//'name' => 'Subject '.$counter,
                        'code' => $faker->unique()->regexify('[A-Z]{3}[0-9]{6}'),
                        'school_year' => $i,
                        'semester' => $faker->boolean(70) ? $faker->boolean() : null,
                        'department_id' => $department_id,
                        'degree_id' => $degree_id,
                        'coordinator_id' => User::join('model_has_permissions','users.id','=','model_has_permissions.model_id')->where('model_has_permissions.permission_id', 6)->where('department_id', $department_id)->get()->pluck('id')->first(),
                        'subject_type' => $subject_type
                    ]);

                }

                $department_id = $faker->randomElement(Department::all()->pluck('id')->toArray());

                if($i == 4){ //EDP
                    Subject::firstOrCreate([
                        'name' => Degree::where('id', $degree_id)->first()->getName().' End Degree Project',
                        'code' => $faker->unique()->regexify('[A-Z]{3}[0-9]{6}'),
                        'school_year' => $i,
                        'semester' => $faker->boolean(70) ? $faker->boolean() : null,
                        'department_id' => $department_id,
                        'degree_id' => $degree_id,
                        'coordinator_id' => User::join('model_has_permissions','users.id','=','model_has_permissions.model_id')->where('model_has_permissions.permission_id', 6)->where('department_id', $department_id)->get()->pluck('id')->first(),
                        'subject_type' => 'EDP'
                    ]);
                }
            }
        }
    }
}