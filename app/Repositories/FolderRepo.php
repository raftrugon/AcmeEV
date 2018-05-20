<?php

namespace App\Repositories;

use App\Folder;

class FolderRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Folder;
    }
}