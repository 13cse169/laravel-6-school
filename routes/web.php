<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('school', 'SchoolController')->only([
    'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
])->middleware('auth');
Route::post('school/export/data', 'SchoolController@exportData');


Route::resource('teacher', 'TeacherController')->only([
    'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
])->middleware('auth');
Route::post('teacher/export/data', 'TeacherController@exportData');


Route::group(['prefix' => 'student', 'middleware' => 'auth'], function(){
    Route::get('', 'StudentController@index');
    Route::get('add', 'StudentController@create');
    Route::post('add/new', 'StudentController@store');
    Route::get('detail/{id}', 'StudentController@show');
    Route::get('update/{id}', 'StudentController@edit');
    Route::post('update/info', 'StudentController@update');
    Route::post('/list/pagination', 'StudentController@pagination');
    Route::post('/remove/data', 'StudentController@destroy');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('send-mail', 'SendMailController@mail');
    Route::post('send-mail/send', 'SendMailController@send');
});


Route::group(['prefix' => 'employee', 'middleware' => 'auth'], function(){
    Route::get('/', 'EmployeeController@index');
    Route::get('/add', 'EmployeeController@create');
    Route::post('/add/save', 'EmployeeController@store');
});
