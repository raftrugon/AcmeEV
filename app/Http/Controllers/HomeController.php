<?php

namespace App\Http\Controllers;

use App\Repositories\SystemConfigRepo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $systemConfigRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo)
    {
        $this->systemConfigRepo = $systemConfigRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actual_state = $this->systemConfigRepo->getSystemConfig()->getActualState();
        return view('home', compact('actual_state'));
    }
}
