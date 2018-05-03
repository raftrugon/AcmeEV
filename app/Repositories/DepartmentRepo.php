<?php

namespace App\Repositories;

use App\Department;

class DepartmentRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Department;
    }
}