<?php


// All routes lie below for the web application
// API routes lie in the api.php file
use App\Mail\SendMail;

// Default View
Route::get('/', function () { return view('welcome'); })->name('welcome');


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

Route::get('/delete_check/{delete_id}', 'TaskController@deleteCheck')->name('deleteCheck');//check before deletion
Route::post('/delete_task', 'TaskController@delete')->name('delete');//delete task 

Route::get('/edit_task/{task_id}', 'TaskController@editCheck')->name('editCheck');//edit task modal
Route::post('/edit_task', 'TaskController@edit')->name('edit');//edit task

Route::get('/priority_up/{task_id}', 'TaskController@priority_up')->name('priority_up');//increment priority
Route::get('/priority_down/{task_id}', 'TaskController@priority_down')->name('priority_down');//decrement priority

Route::get('/date_up/{task_id}', 'TaskController@date_up')->name('date_up');//increment date
Route::get('/date_down/{task_id}', 'TaskController@date_down')->name('date_down');//decrement date

Route::get('/settings', 'SettingsController@settingsCheck')->name('settingsCheck');//settings page
Route::post ('/settings/post', 'SettingsController@settings')->name('settings');//edit settings


Route::get('mail/send', 'MailController@send');




