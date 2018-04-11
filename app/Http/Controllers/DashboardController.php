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

    public function index(){// Default Index Page
        // Retrieve preferences with user ID
        $user_id = Auth::id();
        $p = DB::table('preferences')->get()->where('user_id', $user_id)->first();
        
        if($p === NULL){// If no preferences, set default
            $tasks = \App\Task::orderBy('priority', 'desc')->get()->where('user_id', $user_id);
            return view('dashboard', compact('tasks'));
        }
        else{// Else go to default route specified by user
            // Unserialize associative array containing preferences
            $to_unserialize = $p->preferences;
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
    public function priority(){//sort by priority (descending)
        $user_id = Auth::id();
        $tasks = \App\Task::orderBy('priority', 'desc')->get()->where('user_id', $user_id);
        return view('dashboard', compact('tasks'));
    }
    public function task_name(){//sort by task name (ascending)
        $user_id = Auth::id();
        $tasks = \App\Task::orderBy('task_name', 'asc')->get()->where('user_id', $user_id);//sort by ascending task name
        return view('dashboard', compact('tasks'));
    }
    public function date_time(){//sort by date & time (ascending)
        $user_id = Auth::id();
        $nonNull = \App\Task::orderBy('date', 'asc')->whereNotNull('date')->get()->where('user_id', $user_id);//sort by ascending date if NOT NULL
        $null = \App\Task::whereNull('date')->get()->where('user_id', $user_id);//get NULL date
        $tasks = $nonNull->merge($null);//merge two queries, null dates after non-null dates
        return view('dashboard', compact('tasks'));
    }
    public function create_form(){//create task form
        return view('task.create');
    }
}
