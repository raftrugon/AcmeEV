<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function forbidden(Request $request){
        return view('site.error.forbidden');
    }
}
