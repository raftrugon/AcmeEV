<?php

namespace App\Http\Controllers\Logged;

use App\Announcement;
use App\Http\Controllers\Controller;
use App\Repositories\AnnouncementRepo;
use App\SubjectInstance;

class AnnouncementController extends Controller
{

    protected $announcementRepo;

    public function __construct(AnnouncementRepo $announcementRepo)
    {
        $this->announcementRepo = $announcementRepo;
    }

    public function getAllBySubjectInstance(SubjectInstance $subjectInstance)
    {
        try {
            $announcements = $this->announcementRepo->getAnnouncementsBySubjectInstanceId($subjectInstance->getId())->get();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
        return view('site.logged.announcement.all-for-subject-instance', compact('announcements'));
    }

}
