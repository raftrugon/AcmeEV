<?php

namespace App\Repositories;

use App\ControlCheck;
use App\Subject;
use App\SubjectInstance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectInstanceRepo extends BaseRepo {

    protected $groupRepo;
    protected $conversationRepo;

    public function __construct(GroupRepo $groupRepo, ConversationRepo $conversationRepo)
    {

        $this->groupRepo = $groupRepo;
        $this->conversationRepo = $conversationRepo;
    }


    public function getModel() {
        return new SubjectInstance;
    }


    public function isUserTeacherNOFUNCIONAL($subject_instance)
    {
        $res = false;
        $user = Auth::user();
        $groups = $subject_instance->getGroups()->get();

        foreach ($groups as $group) {
            if ($group->getTheoryLecturer->getId() == $user->getId()) {
                $res = true;
                break;
            } elseif ($group->getPracticeLecturer->getId() == $user->getId()) {
                $res = true;
                break;
            }
        }

        return $res;
    }

    public function getCurrentInstance($subject_id) {
        return SubjectInstance::where('subject_id',$subject_id)
            ->where('academic_year', $this->getAcademicYear())
            ->first();
    }

    public function canAddControlChecks($subjectInstanceId){
        return ControlCheck::where('subject_instance_id',$subjectInstanceId)
                ->sum('weight')<1 ? 1:0;
    }

    public function subjectInstancesBatch(){

        $subjects_ids = Subject::where('active', true)->get()->pluck('id');
        $academic_year = $this->getAcademicYear();                 //Año de las instancias

        DB::beginTransaction();


        try {
            //Por cada asignatura activa
            foreach($subjects_ids as $subject_id){


                //Creación de la instancia con el año actual
                $subject_instance_array = array(
                    'academic_year' => $academic_year,
                    'subject_id' => $subject_id,
                );

                $this->create($subject_instance_array);

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