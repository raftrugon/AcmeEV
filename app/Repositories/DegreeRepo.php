<?php

namespace App\Repositories;

use App\Degree;

class DegreeRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Degree;
    }

    public function getAllButSelected($ids){
        return Degree::whereNotIn('id',$ids);
    }

}