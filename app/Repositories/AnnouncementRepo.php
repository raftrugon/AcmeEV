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

    public function getAnnouncementsBySubjectInstanceId($subject_instance_id){
        return Announcement::where('subject_instance_id', $subject_instance_id);
    }

}