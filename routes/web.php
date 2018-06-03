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

Route::post('/cookies/accept',function(){
   Session::put('cookies',true);
   return 'true';
});

//////////////////////////////////////////////////////// Admin ////////////////////////////////////////////////////////

Route::group(['prefix'=>'admin'/*,'middleware'=>['role:admin']*/],function(){                               //middleware administrador
    Route::group(['prefix'=>'systemconfig'],function() {
        Route::get('edit', 'Admin\SystemConfigController@getEditSystemConfig');                         //Correct - Modificable
        Route::post('save', 'Admin\SystemConfigController@postSaveSystemConfig');                       //Correct
        Route::get('increment-state','Admin\SystemConfigController@getIncrementStateMachine');          //Correct
    });

    Route::post('/degreeDelete','Admin\DegreeController@deleteDegree')->name('delete_degree')->middleware('can:stateEditDegreesDepartmentsSubjects,App\SystemConfig');  //Correct
});

/////////////////////////////////////////// Admin & Management ////////////////////////////////////////////////////////

Route::group(['prefix'=>'users','middleware'=>['role:admin']],function(){
    Route::get('/','UserController@getList');
    Route::get('/data','UserController@getData');
    Route::post('/delete','UserController@postDelete');
    Route::get('/edit','UserController@getEdit');
    Route::get('/create','UserController@getCreate');
    Route::post('/save','UserController@postSave');
});

//////////////////////////////////////////////////////// PAS ////////////////////////////////////////////////////////

Route::group(['prefix'=>'administration','middleware'=>['role:pas']],function(){                                //middleware Pas

    Route::group(['prefix'=>'calendar','middleware'=>['permission:have_appointments']],function() {             //middleware have_appointments
        Route::get('/', 'Pas\PasAppointmentsController@getCalendar');                                       //Correct
        Route::get('/data', 'Pas\PasAppointmentsController@getCalendarData');                               //Correct
        Route::post('/new', 'Pas\PasAppointmentsController@postNewCalendarDate');                           //Correct
        Route::post('/delete', 'Pas\PasAppointmentsController@postDeleteCalendarDate');                     //Correct
    });


    Route::group(['middleware'=>['can:stateListInscriptions,App\SystemConfig']],function() {                    //middleware estado 1 o 2
        Route::get('/inscription-list', 'Pas\PasController@getPrintAllLists');                              //Verificar
        Route::get('/', 'Pas\PasController@getDashboard');                                                  //Integrada en principal, verificar y eliminar original
    });

    Route::get('/appointment-info','Pas\PasAppointmentsController@getAppointmentsInfo');                    //Correct
});

//////////////////////////////////////////////////////// PDI ////////////////////////////////////////////////////////

Route::group(['prefix'=>'management','middleware'=>['permission:manage']],function(){

    Route::group(['middleware'=>['can:stateEditDegreesDepartmentsSubjects,App\SystemConfig']],function() {  //middleware por estado 8 o 0-2

        Route::group(['prefix'=>'degree'],function() {
            Route::get('new','DegreeController@getNewDegree');                                                  //Correct
            Route::post('save','DegreeController@postSaveDegree');                                              //Correct
            Route::get('{degree}/edit','DegreeController@getEditDegree');                                       //Correct

        });

        Route::group(['prefix'=>'subject'],function() {
            Route::get('{degree}/edit/{subject?}','Pdi\SubjectController@createOrEdit');                        //Correct
            Route::post('save','Pdi\SubjectController@saveSubject');                                            //Correct
        });

        Route::group(['prefix'=>'department'],function() {
            Route::get('edit/{department?}','Pdi\DepartmentController@createOrEdit');                       //Correct
            Route::post('/save','Pdi\DepartmentController@saveDepartment');                                 //Correct
        });

    });

    Route::group(['prefix'=>'minute', 'middleware'=>['can:stateEditMinutes,App\SystemConfig']],function(){              //middleware por estado 5 o 7
        //Ruta para ver todos los usuarios para poder acceder a la edición
        Route::get('{user}/all','Pas\MinuteController@getMinutesForStudent');                               //Falla la vista y tienen que aparecer los no definitivos
        Route::post('/update','Pas\MinuteController@updateMinutes')->name('update_minutes');          //Verificar
    });


});


//TO-DO EN CONTROLADOR CHECKEAR QUE SEA PROFESOR DE LA ASIGNATURA
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
        Route::get('{subjectInstance}/edit/{controlCheck?}','Pdi\ControlCheckController@createOrEdit');
        Route::post('/save','Pdi\ControlCheckController@postControlCheck');
        Route::get('{controlCheck}/correct','Pdi\ControlCheckController@correctControlCheck');
        Route::post('post_marks','Pdi\ControlCheckController@updateQualifications')->name('update_controlCheck_qualifications');
        Route::post('import_marks','Pdi\ControlCheckController@importGradesFromCsv')->name('import_controlCheck_qualifications');
        Route::post('/delete','Pdi\ControlCheckController@deleteControlCheck')->name('delete_control_check');
    });


});



//////////////////////////////////////////////////////// Student ////////////////////////////////////////////////////////

Route::group(['prefix'=>'student','middleware'=>['role:student']],function(){
    Route::group(['prefix'=>'enrollment'],function() {
        Route::get('my-enrollments', 'Student\EnrollmentController@getMyEnrollments')->middleware('permission:current||old');
        Route::get('enroll', 'Student\EnrollmentController@getEnroll')->middleware('can:enroll,App\Enrollment');
        Route::post('post-enroll', 'Student\EnrollmentController@postPostEnroll')->middleware('can:enroll,App\Enrollment');
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

Route::group(['prefix'=>'logged'/*,'middleware'=>'auth'*/],function(){
    Route::group(['prefix'=>'announcement'],function() {
        Route::get('{subjectInstance}/list', 'Logged\AnnouncementController@getAllBySubjectInstance');
    });
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

//////////////////////////////////////////////////////// GRUPOS ////////////////////////////////////////////////////////

Route::group(['prefix'=>'group', 'middleware'=>['can:stateAccessTimeTable,App\SystemConfig']],function(){   //middleware estado 3 - 7

    Route::group(['middleware'=>['role:pdi']],function(){                                       //middleware pdi
        Route::group(['prefix'=>'manage','middleware'=>['permission:manage']],function(){       //middleware management
            Route::group(['prefix'=>'timetable'],function(){
                Route::get('/','Pdi\GroupController@getSchedulingView');                                    //verificar
                Route::get('data','Pdi\GroupController@getAvailableSubjectsAndRooms');                      //verificar
                Route::get('resources','Pdi\GroupController@getGroupsForYearAndDegree');                    //verificar
                Route::get('events','Pdi\GroupController@getScheduledForDegreeAndYear');                    //verificar
                Route::post('new','Pdi\GroupController@postNewTimetableTime');                              //verificar
            });
        });

        Route::get('{group}/edit','Pdi\GroupController@editGroupLecturers');                                //verificar
        Route::post('/group-save','Pdi\GroupController@saveGroup')->name('edit_group_lecturers');     //verificar
    });


    Route::group(['prefix'=>'student','middleware'=>['permission:current']],function(){         //middleware current

        Route::group(['prefix'=>'schedule'],function() {
            Route::get('/', 'Student\ScheduleController@getSchedule');                                      //Verificar
            Route::get('events', 'Student\ScheduleController@getScheduleEvents');                           //verificar
            Route::get('resources', 'Student\ScheduleController@getScheduleResources');                     //verificar
//            Route::get('print', 'Student\ScheduleController@getPrint');
        });

        Route::group(['prefix'=>'exchange', 'middleware'=>['can:stateExchangeGroups,App\SystemConfig']],function() {
            Route::get('/create', 'Student\ExchangeController@getCreate');                                  //verificar
            Route::get('/data-and-availability', 'Student\ExchangeController@getTargetDataAndAvailability');//verificar
            Route::post('/save', 'Student\ExchangeController@postSave');                                    //verificar
        });
    });
});

//////////////////////////////////////////////////////// Any ////////////////////////////////////////////////////////


Route::group(['prefix'=>'inscription'],function(){
    Route::get('new','InscriptionController@getNewInscription');
    Route::post('save','InscriptionController@postSaveInscription');
    Route::get('/results','InscriptionController@getResultsInscription');
    Route::post('/results/data','InscriptionController@getResultsInscriptionData');
    Route::post('/results/agree','InscriptionController@postAgreeToInscription');
});


Route::group(['prefix'=>'degree'],function(){
    Route::get('/all-but-selected','DegreeController@getAllButSelected');
    Route::get('/all','DegreeController@getAll');
    Route::get('{degree}/display','DegreeController@displayDegree');
});


Route::group(['prefix'=>'department'],function(){
    Route::get('/all','DepartmentController@getAll');
    Route::get('{department}/display','DepartmentController@displayDepartment');
    Route::get('get-pdis','DepartmentController@getPdis');
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

Route::group(['prefix'=>'error'],function(){
    Route::get('forbidden','ErrorController@forbidden');
});


Route::get('terms','HomeController@terms');
