<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Auth::routes();

//Alternative get logout route
Route::get('/logout',function(){
   Auth::logout();
   return redirect()->route('home');
});
Route::post('/sidebar',function(Request $request){
    Session::put('sidebar',$request->input('show'));
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/lang/{locale}',function($locale){
    Session::put('locale',$locale);
    return redirect()->back();
});

Route::group(['prefix'=>'inscription'],function(){
    Route::get('new','InscriptionController@getNewInscription');
    Route::post('save','InscriptionController@postSaveInscription');
});

Route::group(['prefix'=>'degree'],function(){
    Route::get('/all-but-selected','DegreeController@getAllButSelected');
    Route::get('/all','DegreeController@getAll');
});

Route::group(['prefix'=>'management/degree','middleware'=>['permission:manage']],function(){
    Route::get('new','DegreeController@getNewDegree');
    Route::post('save','DegreeController@postSaveDegree');
    Route::get('{degree}/edit','DegreeController@getEditDegree');
});

Route::group(['prefix'=>'department'],function(){
    Route::get('/all','DepartmentController@getAll');
    Route::get('new','DepartmentController@getNewDepartment');
    Route::post('save','DepartmentController@postSaveDepartment');
});

Route::group(['prefix'=>'administration','middleware'=>['role:pas']],function(){
    Route::group(['prefix'=>'calendar','middleware'=>['permission:have_appointments']],function() {
        Route::get('/', 'Pas\PasAppointmentsController@getCalendar');
        Route::get('/data', 'Pas\PasAppointmentsController@getCalendarData');
        Route::post('/new', 'Pas\PasAppointmentsController@postNewCalendarDate');
        Route::post('/delete', 'Pas\PasAppointmentsController@postDeleteCalendarDate');
    });
});

Route::group(['prefix'=>'calendar'],function() {
    Route::get('', 'AppointmentsController@getCalendar');
    Route::get('/data', 'AppointmentsController@getCalendarData');
    Route::post('/update', 'AppointmentsController@postUpdateAppointment');
});

