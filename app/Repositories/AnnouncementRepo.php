<?php

namespace App\Repositories;

use App\Announcement;

class AnnouncementRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Announcement;
    }

    public function getAnnouncementsBySubjectInstanceId($subjectInstance_id){
        return Announcement::all();
    }

}