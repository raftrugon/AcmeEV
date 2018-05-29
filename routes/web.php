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


//////////////////////////////////////////////////////// Basic ////////////////////////////////////////////////////////
///
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

//////////////////////////////////////////////////////// Admin ////////////////////////////////////////////////////////

Route::group(['prefix'=>'admin'/*,'middleware'=>['role:admin']*/],function(){
    Route::group(['prefix'=>'systemconfig'],function() {
        Route::get('edit', 'Admin\SystemConfigController@getEditSystemConfig');
        Route::post('save', 'Admin\SystemConfigController@postSaveSystemConfig');
        Route::post('first_inscription_process','Admin\SystemConfigController@postInscriptionBatch')->name('process_inscriptions');
        Route::get('increment-state','Admin\SystemConfigController@getIncrementStateMachine');
    });
    Route::post('/degreeDelete','Admin\DegreeController@deleteDegree')->name('delete_degree');
});

//////////////////////////////////////////////////////// PAS ////////////////////////////////////////////////////////

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
    Route::group(['prefix'=>'minute'],function(){
        Route::get('{user}/all','Pas\MinuteController@getMinutesForStudent');
        Route::post('/update','Pas\MinuteController@updateMinutes')->name('update_minutes');
    });
});

//////////////////////////////////////////////////////// PDI ////////////////////////////////////////////////////////

Route::group(['prefix'=>'management','middleware'=>['permission:manage']],function(){
    Route::group(['prefix'=>'degree'],function() {
        Route::get('new','DegreeController@getNewDegree');
        Route::post('save','DegreeController@postSaveDegree');
        Route::get('{degree}/edit','DegreeController@getEditDegree');
        route::get('{degree}/add-next-year-subjects','Pdi\ManagementController@getDegreeEditAddNextYearSubjects');
        route::post('/create-subject-instances','Pdi\ManagementController@createNextYearDegree')->name('post_subject_instances');
    });
});


Route::group(['prefix'=>'pdi','middleware'=>['role:pdi']],function(){
    Route::group(['prefix'=>'announcement'],function() {
        Route::get('{subjectInstance}/create', 'Pdi\AnnouncementController@getCreateAnnouncement');
        Route::post('save', 'Pdi\AnnouncementController@postSaveAnnouncement');
    });
    Route::group(['prefix'=>'subject','middleware'=>['permission:teach']],function(){
        Route::get('list','Pdi\SubjectController@getMySubjectList');
        Route::post('folder/new','Pdi\SubjectController@postNewFolder')->name('new_folder');
        Route::post('folder/save','Pdi\SubjectController@postSaveFolder')->name('save_folder');
        Route::post('folder/delete','Pdi\SubjectController@postDeleteFolder')->name('delete_folder');
        Route::post('file/new','Pdi\SubjectController@postNewFile')->name('new_file');
        Route::post('file/delete','Pdi\SubjectController@postDeleteFile')->name('delete_file');
        Route::get('/coordinator/all','Pdi\SubjectController@getSubjectsForCoordinator');
        Route::get('{subject}/instances','Pdi\SubjectController@getSubjectInstances');
        Route::get('{subjectInstance}/groups','Pdi\GroupController@getGroupsForSubjectInstace');
    });
    Route::group(['prefix'=>'control_check'],function() {
        Route::get('{subjectInstance}/new','Pdi\ControlCheckController@createControlCheck');
        Route::post('/save','Pdi\ControlCheckController@postControlCheck');
        Route::get('{controlCheck}/correct','Pdi\ControlCheckController@correctControlCheck');
        Route::post('post_marks','Pdi\ControlCheckController@updateQualifications')->name('update_controlCheck_qualifications');
        Route::post('import_marks','Pdi\ControlCheckController@importGradesFromCsv')->name('import_controlCheck_qualifications');
    });
});


Route::group(['prefix'=>'group'],function(){
    Route::group(['middleware'=>['role:pdi']],function(){
        Route::get('{group}/edit','Pdi\GroupController@editGroupLecturers');
        Route::post('/group-save','Pdi\GroupController@saveGroup')->name('edit_group_lecturers');
    });
});

//////////////////////////////////////////////////////// Student ////////////////////////////////////////////////////////

Route::group(['prefix'=>'student'],function(){
    Route::group(['prefix'=>'enrollment'],function() {
        Route::get('my-enrollments', 'Student\EnrollmentController@getMyEnrollments');
    });
    Route::group(['prefix'=>'subject'],function() {
        Route::post('control-check/upload','Student\ControlCheckController@uploadControlCheck')->name('upload_control_check');
    });
    Route::get('my-subjects', 'Student\SubjectInstanceController@getMySubjectInstances');
    Route::group(['prefix'=>'minute'], function() {
        Route::get('my-minutes','Student\MinuteController@getMinutesForStudent');
    });
});

//////////////////////////////////////////////////////// Logged ////////////////////////////////////////////////////////

Route::group(['prefix'=>'logged'/*,'middleware'=>['role:???????']*/],function(){
    Route::group(['prefix'=>'announcement'],function() {
        Route::get('{subjectInstance}/list', 'Logged\AnnouncementController@getAllBySubjectInstance');//@getAllBySubjectInstance
    });
});

//////////////////////////////////////////////////////// Any ////////////////////////////////////////////////////////


Route::group(['prefix'=>'inscription'],function(){
    Route::get('new','InscriptionController@getNewInscription');
    Route::post('save','InscriptionController@postSaveInscription');
    Route::get('/results','InscriptionController@getResultsInscription');
    Route::post('/results/data','InscriptionController@getResultsInscriptionData');
});


Route::group(['prefix'=>'degree'],function(){
    Route::get('/all-but-selected','DegreeController@getAllButSelected');
    Route::get('/all','DegreeController@getAll');
    Route::get('{degree}/display','DegreeController@displayDegree');
});


Route::group(['prefix'=>'department'],function(){
    Route::get('/all','DepartmentController@getAll');
    Route::get('new','DepartmentController@getNewDepartment');
    Route::post('save','DepartmentController@postSaveDepartment');
    Route::get('{department}/display','DepartmentController@displayDepartment');
});


Route::group(['prefix'=>'calendar'],function() {
    Route::get('', 'AppointmentsController@getCalendar');
    Route::get('/data', 'AppointmentsController@getCalendarData');
    Route::post('/update', 'AppointmentsController@postUpdateAppointment');
});


Route::group(['prefix'=>'subject'],function(){
    Route::get('{subject}','SubjectController@getSubjectDisplay')->name('subject-display');
    Route::get('/filesystem/data','SubjectController@getFileSystemData')->name('filesystem.data');
    Route::get('file/download/{file}','SubjectController@getDownloadFile');
});

Route::group(['prefix'=>'chat','middleware','middleware'=>'auth'],function(){
    Route::post('new','ChatController@postNewChat');
    Route::get('load','ChatController@getLoadChats');
    Route::post('close','ChatController@postCloseChat');
    Route::post('open','ChatController@postOpenChat');
    Route::post('min','ChatController@postMinChat');
    Route::group(['prefix'=>'message'],function(){
       Route::post('new','ChatController@postNewMessage');
       Route::get('un-read','ChatController@getUnreadMessages');
    });
});




