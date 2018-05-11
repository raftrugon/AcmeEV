<?php

namespace App\Repositories;

use App\SystemConfig;

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

}