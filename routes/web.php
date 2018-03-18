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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Display main home
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Display All Tasks For Designated User
 */
Route::get('home/{user_id}', function($user_id){
    // $tasks = DB::table('tasks')->get();
    $tasks = DB::table('tasks')->where('user_id', '=', $user_id)->get();
    return view('home',compact('tasks'));
    // dd($tasks);
});

/**
 * Display Specific Task For Designated User
 */
Route::get('home/task/{id}', function($id){
    $tasks = DB::table('tasks')->find($id);
    // $task = Task::find('id');
    return view('tasks.show',compact('tasks'));
});