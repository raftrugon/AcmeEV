<?php

use App\Enrollment;
use App\Minute;
use App\Subject;
use App\SubjectInstance;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EnrollmentsAndMinutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        //Variables modificables
        $min_academic_year = 2013;
        $max_academic_year = 2017;

        $min_number_enrollments_per_year = 3;
        $max_number_enrollments_per_year = 6;

        $max_summons_number = 3;


        //Año académico actual
        $actual_academic_year = date('Y');
        if(date('m') > 8)
            $actual_academic_year++;

        $students = User::join('model_has_permissions','users.id','=','model_has_permissions.model_id')->where('model_has_permissions.permission_id', 2)->whereNotNull('users.degree_id')->select('users.*')->get();

        info('Seeding Enrollments for students since '.$min_academic_year.'/'.$max_academic_year.' to '.$actual_academic_year.' and assigning groups of the subjects and creating their corresponding minutes.('.count($students->toArray()).' Students).');

        foreach ($students as $student){

            //Variables

            $degree = $student->getDegree;
            $number_of_subjects_on_degree = count($degree->getSubjects->toArray());


            $starting_academic_year = $faker->numberBetween($min_academic_year, $max_academic_year);

            for($i = $starting_academic_year; $i <= $actual_academic_year; $i++){

                //Variables
                $number_of_enrollments_this_year = $faker->numberBetween($min_number_enrollments_per_year,$max_number_enrollments_per_year);


                $passed_subjects_ids = Subject::join('subject_instances', 'subjects.id', '=', 'subject_instances.subject_id')   //Une a subjects la tabla subject_instances
                    ->join('enrollments', 'subject_instances.id', '=', 'enrollments.subject_instance_id')               //Une con la tabla enrollments
                    ->where('enrollments.user_id', $student->getId())                                                   //Filtra a las asignaturas con enrollments del estudiante
                    ->join('minutes', 'enrollments.id', '=', 'minutes.enrollment_id')                                   //Une con la tabla minutes
                    ->where('minutes.qualification', '>=', 5)                                                           //Filtra a las asignaturas con enrollments con minutes aprobados
                    ->select('subjects.*')->distinct()->get()->pluck('id')->toArray();                                              //Extrae los IDs de esas asignaturas

                $not_passed_subjects_ids = SubjectInstance::where('academic_year', $i)                                  //Busca las subject_instances con año académico actual
                    ->join('subjects', 'subject_instances.subject_id', '=', 'subjects.id')                              //Une con la tabla subjects
                    ->where('subjects.degree_id', $degree->getId())                                                     //Filtra a los subject_instances de asignaturas de la carrera del estudiante
                    ->whereNotIn('subjects.id', $passed_subjects_ids)                                                   //Retiene las asignaturas que no ha pasado aun
                    ->orderBy('subjects.id', 'asc')                                                                     //Ordena ascendentemente por el id de la asignatura que estan creadas por curso
                    ->select('subject_instances.*')->distinct()->get()->pluck('id')->toArray();                                     //Extrae los IDs de esas instancias de asignaturas

                $passed_subjects_ids_count = count($passed_subjects_ids);


                //Generación de enrollments, minutes y asignación de grupos
                for($j = 0; $j < $number_of_enrollments_this_year; $j++){

                    //Checks if the student has still subjects to enrol
                    if($number_of_subjects_on_degree - $passed_subjects_ids_count <= $j) {
                        info('Student '.$student->getId().'already enrolled all subjects for this year.');
                        break;
                    }

                    //Gets the first subject on the list which is ordered by course
                    $subject_instance_id = $not_passed_subjects_ids[$j];


                    //Generación de enrollments
                    $enrollment = Enrollment::firstOrCreate([
                        'subject_instance_id'=>$subject_instance_id,
                        'user_id'=>$student->getId()
                    ]);

                    //Asignación a grupos
                    $group_id = $faker->randomElement(SubjectInstance::where('id',$subject_instance_id)->first()->getGroups->pluck('id')->toArray());
                    $student->getGroups()->attach($group_id);

                    //Generación de minutes

                    for ($k = 1; $k <= $max_summons_number; $k++) {

                        //Random number to see if the student goes to the exam
                        $student_goes = $faker->numberBetween(1, 5);

                        if ($student_goes > 2) {

                            //Random qualification of the minute with more possibilities to pass
                            $random_qualification = $faker->numberBetween(1, 10);

                            //Creates the minute based on the enrollment created
                            Minute::firstOrCreate([
                                'status' => true,
                                'qualification' => $random_qualification,
                                'summon' => $k,
                                'enrollment_id' => $enrollment->getId(),
                            ]);

                            //If he passed the for is broken
                            if ($random_qualification >= 5) {
                                break;
                            }
                        }
                    }
                }
            }
        }














    }
}
