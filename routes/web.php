<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::group(['middleware'=>'auth','namespace' => 'App\Http\Controllers'], function(){

	
	Route::post('getSubjectsByBatch','Controller@getSubjectsByBatch')->name('getSubjectsByBatch');
	Route::post('getUsersByBatch','Controller@getUsersByBatch')->name('getUsersByBatch');
    Route::post('getUsersByBatchLabel','Controller@getUsersByBatchLabel')->name('getUsersByBatchLabel');
	
	Route::get('dashboard','DashboardController@index');

    Route::resource('batches', 'BatchController');
    Route::resource('student', 'StudentController');
    Route::resource('subject', 'SubjectController');
    Route::resource('result', 'ResultController');
    Route::resource('attendance', 'AttendanceController');
    Route::resource('notice', 'NoticeController');

    Route::post('getAttendance','AttendanceController@getAttendance')->name('getAttendance');
});

require __DIR__.'/auth.php';
