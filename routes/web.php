<?php


// All routes lie below for the web application
// API routes lie in the api.php file


// Default View
Route::get('/', function () { return view('welcome'); });


// Authorization
Auth::routes();


// Dashboard Sorting Methods
// Dashboard Controller
Route::get('/home', 'DashboardController@index')->name('home');//display dashboard
Route::get('/home/priority', 'DashboardController@priority')->name('priority');//sort by priority
Route::get('/home/task_name', 'DashboardController@task_name')->name('task_name');//sort by task name
Route::get('/home/date_time', 'DashboardController@date_time')->name('date_time');//sort by date & time


// Task CRUD Operations
// Task Controller
Route::post('/create', 'TaskController@create')->name('create');//create new task

Route::get('/delete_check/{delete_id}', 'TaskController@deleteCheck');//check before deletion
Route::post('/delete_task', 'TaskController@delete')->name('delete');//delete task 

Route::get('/minus/{task_id}', 'TaskController@minus')->name('minus');//decrement priority
Route::get('/plus/{task_id}', 'TaskController@plus')->name('plus');//increment priority

Route::get('/subtract/{task_id}', 'TaskController@subtract')->name('minus');//decrement date
Route::get('/add/{task_id}', 'TaskController@add')->name('plus');//increment date

Route::get('/edit_task/{task_id}', 'TaskController@editTask')->name('edit_task');//edit task modal
Route::post('/edit_task', 'TaskController@doEditTask')->name('do_edit_task');//edit task

Route::get('/preferences', 'TaskController@editPreferences')->name('preferences');//preferences page
Route::post ('/preferences/post', 'TaskController@doEditPreferences')->name('do_preferences');//preferences page