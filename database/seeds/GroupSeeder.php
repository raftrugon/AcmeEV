<?php

use App\Group;
use App\SubjectInstance;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder{

    public function run(){
        /*Group::firstOrCreate(['id'=>1,'number'=>1,'subject_instance_id'=>1,'theory_lecturer_id'=>1,'practice_lecturer_id'=>2]);
        Group::firstOrCreate(['id'=>2,'number'=>2,'subject_instance_id'=>1,'theory_lecturer_id'=>1,'practice_lecturer_id'=>2]);*/


        $faker = Factory::create();
        $id = 1;

        //////////////////////////////////////////////////////////////


        $actual_academic_year = date('Y');                                   //Año actual

        if(date('m') > 8)                                                    //Si ha pasado septiembre crea las de este año tambien
            $actual_academic_year++;


        $subject_instances = SubjectInstance::where('academic_year','>',$actual_academic_year-2)->get();

        info(count($subject_instances));


        foreach ($subject_instances as $subject_instance){

            $number_of_groups = $faker->numberBetween(3,4);
            $subject_id = $subject_instance->getSubject->getId();



            $theory_lecturer_id = $faker->randomElement(User::join('subjects', 'users.department_id', '=', 'subjects.department_id')->where('subjects.id', $subject_id)->select('users.id')->pluck('id')->toArray());
            $practice_lecturer_id = $faker->randomElement(User::join('subjects', 'users.department_id', '=', 'subjects.department_id')->where('subjects.id', $subject_id)->where('users.id','!=',$theory_lecturer_id)->select('users.id')->pluck('id')->toArray());


            for($i = 1; $i <= $number_of_groups; $i++){
                Group::firstOrCreate([
                    'id'=>$id,
                    'number'=>$i,
                    'subject_instance_id'=>$subject_instance->getId(),
                    'theory_lecturer_id'=>$theory_lecturer_id,
                    'practice_lecturer_id'=>$practice_lecturer_id
                ]);

                $id++;
            }

        }
    }
}