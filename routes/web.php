<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'DashboardController@index')->name('home');//display dashboard
Route::get('/home/priority', 'DashboardController@priority')->name('priority');//sort by priority
Route::get('/home/task_name', 'DashboardController@task_name')->name('task_name');//sort by task name
Route::get('/home/date_time', 'DashboardController@date_time')->name('date_time');//sort by date & time

Route::post('/create', 'DashboardController@create')->name('create');//create new task

Route::get('/delete_check/{delete_id}', 'DashboardController@deleteCheck');//check before deletion
Route::get('/delete/{task_id}', 'DashboardController@doDelete')->name('delete');//delete task 

Route::get('/minus/{task_id}', 'DashboardController@minus')->name('minus');//decrement priority
Route::get('/plus/{task_id}', 'DashboardController@plus')->name('plus');//increment priority

Route::get('/subtract/{task_id}', 'DashboardController@subtract')->name('minus');//decrement date
Route::get('/add/{task_id}', 'DashboardController@add')->name('plus');//increment date

Route::get('/edit_task/{task_id}', 'DashboardController@editTask')->name('edit_task');//edit task modal
Route::post('/edit_task', 'DashboardController@doEditTask')->name('do_edit_task');//edit task

Route::get('/preferences', 'DashboardController@editPreferences')->name('preferences');//preferences page
Route::post ('/preferences/post', 'DashboardController@doEditPreferences')->name('do_preferences');//preferences page