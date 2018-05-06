<?php

namespace App\Http\Controllers\Pas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasAppointmentsController extends Controller
{
    public function __construct(){

    }

    public function getCalendar(){
        return view('site.pas.calendar');
    }
}
