<?php

namespace App\Repositories;

use App\File;

class FileRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new File;
    }
}