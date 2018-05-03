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

use Illuminate\Support\Facades\Session;

Auth::routes();

//Alternative get logout route
Route::get('/logout',function(){
   Auth::logout();
   return redirect()->route('home');
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
    Route::get('new','DegreeController@getNewDegree');
    Route::post('save','DegreeController@postSaveDegree');
});

Route::group(['prefix'=>'administration'],function(){
   Route::get('/calendar','Pas\PasAppointmentsController@getCalendar');
});


