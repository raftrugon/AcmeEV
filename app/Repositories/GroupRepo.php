<?php

namespace App\Repositories;

use App\Enrollment;
use App\Group;
use App\SubjectInstance;
use App\SystemConfig;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupRepo extends BaseRepo {

    private $conversationRepo;

    public function __construct(ConversationRepo $conversationRepo)
    {
        $this->conversationRepo = $conversationRepo;
    }

    public function getModel() {
        return new Group;
    }



    public function getMySchedule($start){
        $start = substr($start,0,10);
        $monday = Carbon::createFromFormat('Y-m-d',$start);
        $groups = $this->conversationRepo->getMyGroupsForThisYear();
        return $groups->map(function($group) use($monday) {
            $subject = $group->getSubjectInstance->getSubject;
            $periods = $group->getPeriodTimes->map(function($period) use ($monday,$subject,$group){
                $day = $monday->copy()->addDays(intval($period['day']) - 1);
                $period['start'] = $day->copy()->setTimeFromTimeString($period['start'])->format('Y-m-d H:i:s');
                $period['end'] = $day->copy()->setTimeFromTimeString($period['end'])->format('Y-m-d H:i:s');
                $room = $period->getRoom;
                $period['room'] = $room->getModule() . "-" . $room->getFloor() . "." . $room->getNumber();
                if($room->getIsLaboratory()){
                    $period['room'] .= " (LAB)";
                    $period['borderColor'] = '#ffc107';
                    $period['textColor'] = '#ffc107';
                    $period['teacher'] = $group->getPracticeLecturer->getFullName();
                }else{
                    $period['teacher'] = $group->getTheoryLecturer->getFullName();
                }
                $period['title'] = $subject->getName() . ' [' . $period['room'] . ']';
                $period['group'] =  __('group.number') . ': ' . $group->getNumber();
                $period['resourceId'] = $subject->getSchoolYear();
                $period['group_id'] = $group->getId();
                return $period;
            });
           return $periods;
        })->flatten();
    }

    public function subjectInstancesBatch(){


        $academic_year = $this->getAcademicYear();                 //Año de las instancias
        $maximum_number_students_group = SystemConfig::first()->getMaxStudentsPerGroup();

        $actual_year_subject_instances = SubjectInstance::where('academic_year', $academic_year)->get();

        DB::beginTransaction();


        try {
            //Por cada instancia de asignatura
            foreach($actual_year_subject_instances as $subject_instance){


                //Se piden los enrollments de la asignatura
                $enrollments = Enrollment::where('subject_instance_id', $subject_instance->id)->get();

                //Se cuentan los enrollments en la asignatura
                $number_enrollments = $enrollments->count();

                //Si hay enrollments se hace la división redondeada por arriba para calcular el número de grupos necesario
                if($number_enrollments > 0)
                    $number_of_groups = ceil($number_enrollments / $maximum_number_students_group);
                else
                    continue;

                //Se calcula el número de estudiantes por grupo a usar dividiendo el número de enrollments entre el número de grupos y rendondeando superiormente
                $number_of_students_group = ceil($number_enrollments / $number_of_groups);

                //Se dividen los enrollments en el número de grupos indicado para generarlos y asignar los alumnos
                $enrollments_by_group = $enrollments->chunk($number_of_students_group);



                $i = 1;
                //Generación de grupos y conversaciones
                foreach ($enrollments_by_group as $enrollments){

                    //Creación de el grupo
                    $group_array = array(
                        'number'=>$i,
                        'subject_instance_id'=>$subject_instance->getId(),
                        'theory_lecturer_id'=>null,
                        'practice_lecturer_id'=>null,
                    );

                    $group = $this->create($group_array);


                    //Creación de la conversación
                    $conversation_array = array(
                        'group_id'=>$group->getId(),
                    );

                    $this->conversationRepo->create($conversation_array);

                    //Asignación de los grupos a los usuarios por los enrollments
                    foreach ($enrollments as $enrollment){
                        $student = User::findOrFail($enrollment->user_id);
                        $student->getGroups()->attach($group->getId());

                    }

                    //Incremento número de grupo
                    $i++;
                }
            }


            DB::commit();

            return true;

        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        } catch(\Throwable $t){
            DB::rollBack();
            throw $t;
        }


    }

}