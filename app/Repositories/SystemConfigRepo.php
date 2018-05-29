<?php

namespace App\Repositories;

use App\SystemConfig;
use Illuminate\Support\Facades\DB;

class SystemConfigRepo extends BaseRepo
{

    public function __construct()
    {

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
            if($new_state > 7)
                $new_state = 0;

            $new_system_config = array(
                'actual_state' => $new_state,
            );

            $this->update($DB_system_config, $new_system_config);

            DB::commit();

            switch ($new_state)
            {
                case 1: break;  //Indicar aquí auto computación primera de inscripciones
                case 2: break;  //Indicar aquí auto computación segunda de inscripciones //Indicar aquí la auto generación de usuarios con las inscripciones aceptadas //Indicar aquí auto generación de subject instances
                case 4: break;  //Indicar aquí auto computación de minutes con control checks del primer cuatrimestre
                case 6: break;  //Indicar aquí auto computación de minutes con control checks del segundo cuatrimestre y anuales
            }
        } catch(\Exception $e){
            DB::rollBack();
            throw $e;
        } catch(\Throwable $t){
            DB::rollBack();
            throw $t;
        }

    }

}