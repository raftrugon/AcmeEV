<?php

namespace App\Repositories;

use App\Appointment;
use App\Enrollment;
use App\Inscription;
use App\SystemConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SystemConfigRepo extends BaseRepo
{

    protected $userRepo;
    protected $inscriptionRepo;
    protected $subjectInstanceRepo;
    protected $minuteRepo;

    public function __construct(UserRepo $userRepo, InscriptionRepo $inscriptionRepo, SubjectInstanceRepo $subjectInstanceRepo, MinuteRepo $minuteRepo)
    {
        $this->userRepo = $userRepo;
        $this->inscriptionRepo = $inscriptionRepo;
        $this->subjectInstanceRepo = $subjectInstanceRepo;
        $this->minuteRepo = $minuteRepo;
    }

    public function getModel()
    {
        return new SystemConfig;
    }

    public function getSystemConfig(){
        return SystemConfig::first();//DB::table('system_configs')->first();//
    }

    public function getActualState(){
        return SystemConfig::first()->getActualState();//DB::table('system_configs')->first();//
    }

    public function incrementStateMachine(){
        DB::beginTransaction();
        try {
            $DB_system_config = $this->getSystemConfig();
            $DB_actual_state = $DB_system_config->getActualState();

            $new_state = $DB_actual_state + 1;
            if($new_state > 8)
                $new_state = 0;

            $new_system_config = array(
                'actual_state' => $new_state,
            );

            $this->update($DB_system_config, $new_system_config);



            switch ($new_state)
            {
                case 1:
                    $this->inscriptionRepo->inscriptionBatch(1);        //Auto computación primera de inscripciones
                    break;

                case 2:
                    $this->inscriptionRepo->inscriptionBatch(2);        //Auto computación segunda de inscripciones
                    break;

                case 3:
                    $this->subjectInstanceRepo->subjectInstancesAndGroupsBatch();  //Auto generación de subject instances, groups y conversations
                    $this->userRepo->createBatchFromInscriptions();                //Generación de usuarios con las inscripciones aceptadas
                    break;

                case 5:
                    $this->minuteRepo->minutesFromControlsBatch(1);       //Auto computación de minutes primera convocatoria¿?
                    break;

                case 7:
                    $this->minuteRepo->minutesFromControlsBatch(2);       //Auto computación de minutes segunda convocatoria¿?
                    break;
            }

            DB::commit();
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        } catch(\Throwable $t){
            DB::rollBack();
            throw $t;
        }

    }


    public function getDashboard(){
        $accepted_inscriptions = Inscription::join('requests','inscriptions.id','=','requests.inscription_id')
            ->where('requests.accepted',1)->count();
        $total_inscriptions = Inscription::count('id');
        $inscription_donut_data = collect(array($accepted_inscriptions,$total_inscriptions-$accepted_inscriptions));
//        $appointments_per_hour = Appointment::all()->transform(function($appointment){
//                                    $appointment['start'] = Carbon::createFromFormat('Y-m-d H:i:s',$appointment['start'])->format('Hi');
//                                    return $appointment;
//                                })->sortBy('start')->transform(function($group){
//                                    $group = $group->count();
//                                    return $group;
//                                });

        $appointments_per_hour = array();

        $time = Carbon::createFromFormat('H:i:s',$this->getSystemConfig()->getBuildingOpenTime());
        $end = Carbon::createFromFormat('H:i:s',$this->getSystemConfig()->getBuildingCloseTime());
        while($time->lt($end)){
            $temp = array();
            $temp['x'] = $time->toIso8601String();
            $temp['y'] = Appointment::where('start','like','%'.$time->format('H:i').':00')->count();
            $appointments_per_hour[] = $temp;
            $time->addMinutes(5);
        }
        $appointments_per_hour=collect($appointments_per_hour);


        $subQuery = Enrollment::join('subject_instances','enrollments.subject_instance_id','=','subject_instances.id')
            ->join('subjects','subject_instances.subject_id','=','subjects.id')
            ->select(DB::raw('count(enrollments.id) as enrollment_count'),'subjects.school_year as school_year')
            ->groupBy('enrollments.user_id','subjects.id');
        $enrollment_tries_per_school_year = DB::table('enrollments')
            ->select(DB::raw('COUNT(*) as total_count'),'sub.enrollment_count','school_year')
            ->from(DB::raw('('.$subQuery->toSql().') sub'))
            ->groupBy('sub.enrollment_count','sub.school_year')
            ->get()->transform(function($item){
                $obj['year'] = $item->school_year;
                $obj['x'] = $item->enrollment_count;
                $obj['y'] = $item->total_count;
                return $obj;
            })->groupBy('year');

        return compact('inscription_donut_data','appointments_per_hour','enrollment_tries_per_school_year');

    }

}