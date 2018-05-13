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
use Illuminate\Support\Facades\Route;
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
    Route::get('/results','InscriptionController@getResultsInscription');
    Route::post('/results/data','InscriptionController@getResultsInscriptionData');
});

Route::group(['prefix'=>'degree'],function(){
    Route::get('/all-but-selected','DegreeController@getAllButSelected');
    Route::get('/all','DegreeController@getAll');
});

Route::group(['prefix'=>'management/degree'/*,'middleware'=>['permission:manage']*/],function(){
    Route::get('new','DegreeController@getNewDegree');
    Route::post('save','DegreeController@postSaveDegree');
    Route::get('{degree}/edit','DegreeController@getEditDegree');
    route::get('{degree}/add-next-year-subjects','Pdi\ManagementController@getDegreeEditAddNextYearSubjects');
    route::post('/create-subject-instances','Pdi\ManagementController@createNextYearDegree')->name('post_subject_instances');
});

Route::group(['prefix'=>'department'],function(){
    Route::get('/all','DepartmentController@getAll');
    Route::get('new','DepartmentController@getNewDepartment');
    Route::post('save','DepartmentController@postSaveDepartment');
});

Route::group(['prefix'=>'administration','middleware'=>['role:pas']],function(){
    Route::get('/','Pas\PasController@getDashboard');
    Route::group(['prefix'=>'calendar','middleware'=>['permission:have_appointments']],function() {
        Route::get('/', 'Pas\PasAppointmentsController@getCalendar');
        Route::get('/data', 'Pas\PasAppointmentsController@getCalendarData');
        Route::post('/new', 'Pas\PasAppointmentsController@postNewCalendarDate');
        Route::post('/delete', 'Pas\PasAppointmentsController@postDeleteCalendarDate');
    });
    Route::get('/appointment-info','Pas\PasAppointmentsController@getAppointmentsInfo');
    Route::get('/inscription-list','Pas\PasController@getPrintAllLists');
});

Route::group(['prefix'=>'admin'/*,'middleware'=>['role:admin']*/],function(){
    Route::group(['prefix'=>'systemconfig'],function() {
        Route::get('edit', 'Admin\SystemConfigController@getEditSystemConfig');
        Route::post('save', 'Admin\SystemConfigController@postSaveSystemConfig');
        Route::post('first_inscription_process','Admin\SystemConfigController@postInscriptionBatch')->name('process_inscriptions');
    });
});

Route::group(['prefix'=>'calendar'],function() {
    Route::get('', 'AppointmentsController@getCalendar');
    Route::get('/data', 'AppointmentsController@getCalendarData');
    Route::post('/update', 'AppointmentsController@postUpdateAppointment');
});

Route::group(['prefix'=>'subject'],function(){
    Route::get('/coordinator/all','Pdi\SubjectController@getSubjectsForCoordinator');
    Route::get('{subject}/instances','Pdi\SubjectController@getSubjectInstances');
    Route::get('{subjectInstance}/groups','Pdi\GroupController@getGroupsForSubjectInstace');
});

Route::group(['prefix'=>'group'],function(){
    Route::get('{group}/edit','Pdi\GroupController@editGroupLecturers');
    Route::post('/group-save','Pdi\GroupController@saveGroup')->name('edit_group_lecturers');
});
