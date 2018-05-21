<?php

namespace App\Http\Controllers;

use App\Degree;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(){

    }

    public function getDegrees(){
        return Degree::all();
    }
}
