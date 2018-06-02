<?php

namespace App\Http\Controllers;

use App\Repositories\SystemConfigRepo;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $systemConfigRepo;
    protected $userRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo, UserRepo $userRepo)
    {
        $this->systemConfigRepo = $systemConfigRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actual_state = $this->systemConfigRepo->getActualState();
        $can_student_enroll = false;

        if($actual_state == 3 && Auth::check() && Auth::user()->hasRole('student'))
            $can_student_enroll = $this->userRepo->canUserEnroll();

        return view('home', compact('can_student_enroll'));
    }
}
