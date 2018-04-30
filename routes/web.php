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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/lang/{locale}',function($locale){
    Session::put('locale',$locale);
    return redirect()->route('home');
});

Route::group(['prefix'=>'inscription'],function(){
    Route::get('new','InscriptionController@getNewInscription');
});

Route::group(['prefix'=>'degree'],function(){
    Route::get('/all-but-selected','DegreeController@getAllButSelected');
});


