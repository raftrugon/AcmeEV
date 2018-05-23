<?php

use App\Enrollment;
use App\Subject;
use App\SubjectInstance;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Enrollment::class,30)->create();


        $faker = Factory::create();


        //Variables modificables
        $min_academic_year = 2012;
        $max_academic_year = 2014;

        $min_number_enrollments_per_year = 3;
        $max_number_enrollments_per_year = 6;


        //Año académico actual
        $actual_academic_year = date('Y');
        if(date('m') > 8)
            $actual_academic_year++;


        $students = User::join('model_has_permissions','users.id','=','model_has_permissions.model_id')->where('model_has_permissions.permission_id', 2)->whereNotNull('users.degree_id')->select('users.*')->get();

        foreach ($students as $student){

            //Varibales

            $degree = $student->getDegree;
            //$subjects = $degree->getSubjects();


            $starting_academic_year = $faker->numberBetween($min_academic_year, $max_academic_year);

            for($i = $starting_academic_year; $i <= $actual_academic_year; $i++){

                //Variables
                $number_of_enrollments_this_year = $faker->numberBetween($min_number_enrollments_per_year,$max_number_enrollments_per_year);


                $passed_subjects_ids = Subject::join('subject_instances', 'subjects.id', '=', 'subject_instances.id')   //Une a subjects la tabla subject_instances
                    ->join('enrollments', 'subject_instances.id', '=', 'enrollments.subject_instance_id')               //Une con la tabla enrollments
                    ->where('enrollments.user_id', $student->getId())                                                   //Filtra a las asignaturas con enrollments del estudiante
                    ->join('minutes', 'enrollments.id', '=', 'minutes.enrollment_id')                                   //Une con la tabla minutes
                    ->where('minutes.qualification', '>=', 5)                                                           //Filtra a las asignaturas con enrollments con minutes aprobados
                    ->select('subjects.*')->get()->pluck('id')->toArray();                                              //Extrae los IDs de esas asignaturas

                $not_passed_subjects_ids = SubjectInstance::where('academic_year', $i)                                      //Busca las subject_instances con año académico actual
                    ->join('subjects', 'subject_instances.subject_id', '=', 'subjects.id')                              //Une con la tabla subjects
                    ->where('subjects.degree_id', $degree->getId())                                                     //Filtra a los subject_instances de asignaturas de la carrera del estudiante
                    ->whereNotIn('subjects.id', $passed_subjects_ids)                                                   //Retiene las asignaturas que no ha pasado aun
                    ->select('subject_instances.*')->get()->pluck('id')->toArray();                                                                    //Extrae los IDs de esas instancias de asignaturas



                //Generación de enrollments

                for($i = 0; $i <= $number_of_enrollments_this_year; $i++){
                    $subject_instance_id = $faker->randomElement($not_passed_subjects_ids);

                    //Generación de enrollments

                    Enrollment::firstOrCreate([
                        'subject_instance_id'=>$subject_instance_id,
                        'user_id'=>$student->getId()
                    ]);
                    //Asignación a grupos
                    $group_id = $faker->randomElement(SubjectInstance::where('id',$subject_instance_id)->first()->getGroups->pluck('id')->toArray());
                    info($group_id);
                    $student->getGroups()->attach($group_id);

                    //Generación de minutes
                    if($i != $actual_academic_year){

                    }

                }

                $created_enrollments = Enrollment::where('academic_year', $i);

                //Asignación a grupos


                //Generación de minutes

            }




        }















    }
}
