<?php

namespace App\Repositories;

use App\ControlCheck;
use App\ControlCheckInstance;
use App\Enrollment;
use App\Minute;
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

    public function minutesFromControlsBatch($summon){


        //Control checks instances por cada usuario
        $control_checks_instances_ordered_by_user_id = ControlCheckInstance::join('users', 'control_check_instances.student_id', '=', 'users.id')
        ->join('control_checks', 'control_check_instances.control_check_id', '=', 'control_checks.id')
        ->join('enrollments', 'users.id', '=', 'enrollments.user_id')
        ->select('control_checks.*', 'control_check_instances.calification as qualification', 'users.id as user_id', 'enrollments.id as enrollment_id')
        ->get()->groupBy('user_id');

        try {

        DB::beginTransaction();

            //Por cada User
            foreach ($control_checks_instances_ordered_by_user_id as $control_checks_instances){

                $control_checks_instances_ordered_by_enrollment_id = $control_checks_instances->groupBy('enrollment_id');

                //Por cada enrollment
                foreach ($control_checks_instances_ordered_by_enrollment_id as $control_check_instance_2){

                    //Variables
                    $enrollment_id = $control_check_instance_2->enrollment_id;
                    $minute_qualification = 0;

                    //Por cada control_check_instance se crea la nota del minute
                    foreach ($control_check_instance_2 as $control_check_instance){

                        //Variables
                        $control_check_qualification = $control_check_instance->qualification;
                        $minimum_mark = $control_check_instance->minimum_mark;
                        $weight = $control_check_instance->weight;

                        if($control_check_qualification >= $minimum_mark)
                            $minute_qualification = $minute_qualification + ($control_check_instance->qualification * $weight);
                    }

                    //Creacion del minute
                    $minute_array = array(
                        'status'=>false,
                        'qualification'=>$minute_qualification,
                        'summon'=>$summon,
                        'enrollment_id'=>$enrollment_id,
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