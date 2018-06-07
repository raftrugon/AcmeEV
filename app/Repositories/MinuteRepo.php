<?php

namespace App\Repositories;

use App\ControlCheck;
use App\ControlCheckInstance;
use App\Enrollment;
use App\Minute;
use App\SubjectInstance;
use App\SystemConfig;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MinuteRepo extends BaseRepo
{

    protected $controlCheckRepo;
    protected $controlCheckInstanceRepo;

    public function __construct(ControlCheckRepo $controlCheckRepo, ControlCheckInstanceRepo $controlCheckInstanceRepo)
    {
        $this->controlCheckInstanceRepo = $controlCheckInstanceRepo;
        $this->controlCheckRepo = $controlCheckRepo;
    }

    public function getModel()
    {
        return new Minute;
    }

    public function getMinutesForStudent( User $user=null) {
        $user = isset($user)?$user:Auth::user();
        return $minutes = Minute::join('enrollments','minutes.enrollment_id','=','enrollments.id')
            ->join('subject_instances','enrollments.subject_instance_id','=','subject_instances.id')
            ->join('subjects', 'subject_instances.subject_id', '=', 'subjects.id')
            ->orderBy('subject_instances.academic_year', 'DESC')
            ->orderBy('subjects.name', 'ASC')
            ->select('minutes.*', 'subject_instances.academic_year')
            ->where('enrollments.user_id',$user->getId())
            ->where('minutes.status','0');
    }

    public function minutesFromControlsBatch(){
        try {

        DB::beginTransaction();
            $subject_instances = SystemConfig::first()->getActualState() == 7 ?
                SubjectInstance::where('academic_year',$this->getAcademicYear())
                    ->join('subjects','subject_instances.subject_id','=','subjects.id')
                    ->where('subjects.semester',0)
                    ->select('subject_instances.*')->get()
            :
                SubjectInstance::where('academic_year',$this->getAcademicYear())
                    ->join('subjects','subject_instances.subject_id','=','subjects.id')
                    ->where(function($sub) {
                        $sub->where('subjects.semester', 1)
                            ->orWhereNull('subjects.semester');
                    })
                    ->select('subject_instances.*')->get();

            foreach($subject_instances as $subject_instance) {
                //Control checks instances por cada usuario y subject instance de este cuatri
                $control_checks_instances_ordered_by_user_id =
                    ControlCheckInstance::join('users', 'control_check_instances.student_id', '=', 'users.id')
                        ->join('control_checks', 'control_check_instances.control_check_id', '=', 'control_checks.id')
                        ->join('enrollments', 'users.id', '=', 'enrollments.user_id')
                        ->select('control_checks.*', 'control_check_instances.qualification as qualification', 'users.id as user_id', 'enrollments.id as enrollment_id')
                        ->where('enrollments.subject_instance_id', $subject_instance->getId())
                        ->where('control_checks.subject_instance_id', $subject_instance->getId())
                        ->groupBy('control_check_instances.id')
                        ->get()->groupBy('user_id');

                //Por cada User
                foreach ($control_checks_instances_ordered_by_user_id as $user_id => $control_checks_instances) {
                        //Variables
                        $minute_qualification = 0;

                        //Por cada control_check_instance se crea la nota del minute
                        foreach ($control_checks_instances as $control_check_instance) {

                            //Variables
                            $control_check_qualification = $control_check_instance->qualification;
                            $minimum_mark = $control_check_instance->minimum_mark;
                            $weight = $control_check_instance->weight;

                            if ($control_check_qualification >= $minimum_mark)
                                $minute_qualification = $minute_qualification + ($control_check_instance->qualification * $weight);
                            else{
                                $minute_qualification = 0;
                                break;
                            }
                        }
                        //Calculamos cuantos summons a esta asignatura y le sumamos uno
                        $summon = Minute::join('enrollments','minutes.enrollment_id','=','enrollments.id')
                            ->join('subject_instances','enrollments.subject_instance_id','subject_instances.id')
                            ->where('subject_instances.subject_id',$subject_instance->getId())
                            ->where('enrollments.user_id',$user_id)
                            ->get()->count() + 1;

                        //Creacion del minute
                        $minute_array = array(
                            'status' => false,
                            'qualification' => $minute_qualification,
                            'summon' => $summon,
                            'enrollment_id' => $subject_instance->getEnrolments()->where('user_id',$user_id)->first()->getId(),
                        );

                        $this->create($minute_array);


                }
            }

            //Control check instances soft deleting
            $control_check_instances = ControlCheckInstance::all();
            foreach ($control_check_instances as $control_check_instance){
                $this->controlCheckInstanceRepo->delete($control_check_instance);
            }

            //Control checks soft deleting
            $control_checks = ControlCheck::all();
            foreach ($control_checks as $control_check){
                $this->controlCheckRepo->delete($control_check);
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

    public function setAllStatusTrue(){
        try {

            DB::beginTransaction();
            Minute::where('status', 0)->update(['status'=>1]);
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