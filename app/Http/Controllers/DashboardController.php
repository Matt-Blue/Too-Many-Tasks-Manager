<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;//to get information on current user
use Illuminate\Support\Facades\DB;//to perform database queries
use Illuminate\Http\Request;//HTTP requests
use App\Http\Requests\ContactFormRequest;//used for creating tasks
use Illuminate\Support\Facades\Redirect;//easy redirects
use Illuminate\Support\Facades\URL;//easy url manipulation
use Carbon\Carbon;//datetime manipulation

class DashboardController extends Controller
{

    ///////////////////////////////////
    //////////////SORTING//////////////
    ///////////////////////////////////

    // Default Index Page
    public function index(){
        // Retrieve settings with user ID
        $user_id = Auth::id();
        $s = \App\Setting::find($user_id);
        
        if($s === NULL){// If no preferences, set default
            $tasks = \App\Task::orderBy('priority', 'desc')->get()->where('user_id', $user_id);
            return view('dashboard', compact('tasks'));
        }
        else{// Else go to default route specified by user
            // Unserialize associative array containing preferences
            $to_unserialize = $s->settings;
            $preference = unserialize($to_unserialize);
            // Sort accordingly
            $sorting = $preference['sorting'];
            if($sorting == 'priority'){ return redirect()->route('priority'); }
            elseif($sorting == 'task_name'){ return redirect()->route('task_name'); }
            elseif($sorting == 'date_time'){ return redirect()->route('date_time'); }
        }
        
        $tasks = \App\Task::all();
        return $tasks;
    }

    //sort by priority (descending)
    public function priority(){
        $user_id = Auth::id();
        $tasks = \App\Task::orderBy('priority', 'desc')->get()->where('user_id', $user_id);
        return view('dashboard', compact('tasks'));
    }

    //sort by task name (ascending)
    public function task_name(){
        $user_id = Auth::id();
        $tasks = \App\Task::orderBy('task_name', 'asc')->get()->where('user_id', $user_id);//sort by ascending task name
        return view('dashboard', compact('tasks'));
    }

    //sort by date & time (ascending)
    public function date_time(){
        $user_id = Auth::id();
        $nonNull = \App\Task::orderBy('date', 'asc')->whereNotNull('date')->get()->where('user_id', $user_id);//sort by ascending date if NOT NULL
        $null = \App\Task::whereNull('date')->get()->where('user_id', $user_id);//get NULL date
        $tasks = $nonNull->merge($null);//merge two queries, null dates after non-null dates
        return view('dashboard', compact('tasks'));
    }
}
