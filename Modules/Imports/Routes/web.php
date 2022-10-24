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

// Route::prefix('imports')->group(function() {
//     Route::get('/', 'ImportsController@index');
// });
Route::resource('/import-students', 'StudentImportController');
Route::resource('/import-instructors', 'InstructorImportController');
Route::resource('/import-sessions', 'SessionImportController');
Route::resource('/import-enrollments', 'EnrollmentImportController');

