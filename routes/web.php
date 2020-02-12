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

/* Route::redirect('/', '/en');

Route::group(['prefix' => '{language}'], function () {

    
}); */

Route::resource('{locale}/school', 'SchoolController')->only([
    'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();


/* Route::group(['prefix' => 'school', 'middleware' => 'auth'], function(){
    Route::get('/', 'SchoolController@index');
    Route::get('/create', 'SchoolController@create');
    Route::post('/', 'SchoolController@store');
    Route::get('/{school}', 'SchoolController@show');
    Route::get('/{school}/edit', 'SchoolController@edit');
    Route::patch('/{school}', 'SchoolController@update');
    Route::post('/delete', 'SchoolController@destroy');
    
    Route::post('/export/data', 'SchoolController@exportData');
}); */

/* 
Route::resource('school', 'SchoolController')->only([
    'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
])->middleware('auth');
Route::post('school/export/data', 'SchoolController@exportData');
 */

/* 
Route::group(['prefix' => 'teacher', 'middleware' => 'auth'], function(){
    Route::get('/', 'TeacherController@index');
    Route::get('/create', 'TeacherController@create');
    Route::post('/', 'TeacherController@store');
    Route::get('/{teacher}', 'TeacherController@show');
    Route::get('/{teacher}/edit', 'TeacherController@edit');
    Route::patch('/{teacher}', 'TeacherController@update');
    Route::post('/delete', 'TeacherController@destroy');
    
    Route::post('/export/data', 'TeacherController@exportData');
});

 */
/* Route::group(['prefix' => 'student', 'middleware' => 'auth'], function(){
    Route::get('', 'StudentController@index');
    Route::get('add', 'StudentController@create');
    Route::post('add/new', 'StudentController@store');
    Route::get('detail/{id}', 'StudentController@show');
    Route::get('update/{id}', 'StudentController@edit');
    Route::post('update/info', 'StudentController@update');
    Route::post('/list/pagination', 'StudentController@pagination');
    Route::post('/remove/data', 'StudentController@destroy');
}); */

/* Route::group(['middleware' => 'auth'], function(){
    Route::get('send-mail', 'SendMailController@mail');
    Route::post('send-mail/send', 'SendMailController@send');
}); */


/*
Route::any('/student', 'HomeController@studentAdd')->name('student');
Route::any('/student/{id}', 'HomeController@studentAdd')->name('student');
Route::any('/student/detail/{id}', 'HomeController@studentView')->name('student');
 */


 /* Route::post('/get/teacher', 'HomeController@getTeacher');
Route::post('/remove/data', 'HomeController@removeData');
Route::post('/get/student', 'HomeController@getStudent');
Route::post('/get/student/page', 'HomeController@getStudentPage'); */


/* Route::group(['prefix' => 'employee', 'middleware' => 'auth'], function(){
    Route::get('/', 'EmployeeController@index');
    Route::get('/add', 'EmployeeController@create');
    Route::post('/add/save', 'EmployeeController@store');
}); */
