<?php

use App\Degree;
use App\Department;
use App\Subject;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group('degrees',function(){
   Route::get('/',function(){
       return \App\Degree::all();
   });
   Route::get('{degree}/subjects',function(Degree $degree){
       return $degree->getSubjects;
   });
});

Route::group('departments',function(){
    Route::get('/',function(){
        return \App\Department::all();
    });
    Route::get('{department}/subjects',function(Department $department){
        return $department->getSubjects;
    });
    Route::get('{department}/pdis',function(Department $department){
        return $department->getPDIs;
    });
});



