<?php

use App\Conversation;
use App\Group;
use App\SubjectInstance;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder{

    public function run(){

        $faker = Factory::create();


        $minimum_number_groups = 3;
        $maximum_number_groups = 4;

        //////////////////////////////////////////////////////////////


        //Año actual academico
        $actual_academic_year = date('Y');                                   //Año actual

        if(date('m') > 8)                                                    //Si ha pasado septiembre crea las de este año tambien
            $actual_academic_year++;


        //Busca las subject instances desde 2 años atras
        $subject_instances = SubjectInstance::where('academic_year','>',$actual_academic_year-2)->get();
        $count = count($subject_instances);

        info('Seeding from '.$minimum_number_groups.' to '.$maximum_number_groups.' Groups for each Subject Instance not older than 2 years('.$count.' Subject Instances found).');


        //Por cada subject instance
        foreach ($subject_instances as $subject_instance){

            //Numero de grupos a crear aleatorio
            $number_of_groups = $faker->numberBetween($minimum_number_groups,$maximum_number_groups);
            $subject_id = $subject_instance->getSubject->getId();


            //Itera por el número de grupos
            for($i = 1; $i <= $number_of_groups; $i++){

                //Busqueda de profesores distintos aleatorios para la asignatura pertenecientes al departamento de esta
                $theory_lecturer_id = $faker->randomElement(User::join('subjects', 'users.department_id', '=', 'subjects.department_id')->where('subjects.id', $subject_id)->select('users.id')->pluck('id')->toArray());
                $practice_lecturer_id = $faker->randomElement(User::join('subjects', 'users.department_id', '=', 'subjects.department_id')->where('subjects.id', $subject_id)->where('users.id','!=',$theory_lecturer_id)->select('users.id')->pluck('id')->toArray());

                //Creacion del objeto
                $group = Group::firstOrCreate([
                    'number'=>$i,
                    'subject_instance_id'=>$subject_instance->getId(),
                    'theory_lecturer_id'=>$theory_lecturer_id,
                    'practice_lecturer_id'=>$practice_lecturer_id
                ]);

                Conversation::firstOrCreate([
                    'group_id'=>$group->getId()
                ]);
            }

        }
    }
}