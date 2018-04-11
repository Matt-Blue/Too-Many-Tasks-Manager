<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;//to get information on current user
use Illuminate\Support\Facades\DB;//to perform database queries
use Illuminate\Http\Request;
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
        // If no preferences, set default
        if($p === NULL){
            $tasks = \App\Task::orderBy('priority', 'desc')->get()->where('user_id', $user_id);
            return view('dashboard', compact('tasks'));
        }
        // Else go to default route specified by user
        else{
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

// CREATION AND DELETION

    public function create(Request $request){//create task
        //todo make errors array and do form validation
        if(!$request->get('task_name')){
            return view('dashboard', compact('tasks'));//returns home view and passes the dashboard variable to it
        }else{
            $task_name = $request->get('task_name');
        }

        if(!$request->get('date')){
            $date = NULL;
        }else{
            $date = $request->get('date');
        }
        if(!$request->get('time')){
            $time = NULL;
        }else{
            $time = $request->get('time');
        }

        if(!$request->get('priority')){
            $priority = 0;
        }else{
            $priority = $request->get('priority');
        }

        DB::table('dashboards')->insert([
            'task_name' => $task_name, 
            'priority' => $priority,
            'date' => $date,
            'time' => $time,
            'user_id' => Auth::id()
        ]);

        return redirect()->back();
    }

    public function deleteCheck($task_id){//call are you sure? modal
        session(['task_id' => $task_id]);
        return Redirect::back()->with('modal', 'delete_modal');

        // change delete button (old functionality)
        // session(['delete_id' => $task_id]);
        // return redirect()->back();
    }
    public function doDeleteTask(Request $request){//delete task
        $task_id = $request->get('task_id');
        DB::table('dashboards')->where('id', $task_id)->delete();
        return redirect()->back();
    }

// PRIORITY SPECIFIC

    public function minus($task_id){
        DB::table('dashboards')->where('id', $task_id)->decrement('priority');
        return redirect()->back();
    }
    public function plus($task_id){
        DB::table('dashboards')->where('id', $task_id)->increment('priority');
        return redirect()->back();
    }

// DATE SPECIFIC

    public function subtract($task_id){
        $dates = DB::table('dashboards')->where('id', $task_id)->get();
        foreach($dates as $date){
            $datestring = $date->date;
        }
        $carbondate =  Carbon::parse($datestring)->subDays(1);
        $date = $carbondate->toDateTimeString();
        DB::table('dashboards')->where('id', $task_id)->update(['date' => $date]);
        return redirect()->back();
    }
    public function add($task_id){
        $dates = DB::table('dashboards')->where('id', $task_id)->get();
        foreach($dates as $date){
            $datestring = $date->date;
        }
        $carbondate =  Carbon::parse($datestring)->addDays(1);
        $date = $carbondate->toDateTimeString();
        DB::table('dashboards')->where('id', $task_id)->update(['date' => $date]);
        return redirect()->back();
    }

// EDIT TASK

    public function editTask($task_id){
        session(['task_id' => $task_id]);
        return Redirect::back()->with('modal', 'edit_modal');
    }
    public function doEditTask(Request $request){//edit task
        //todo make errors array and do form validation
        $task_id = $request->get('task_id');
        if(!$request->get('task_name')){
            return redirect()->back();
        }else{
            $task_name = $request->get('task_name');
        }

        if(!$request->get('date')){
            $date = NULL;
        }else{
            $date = $request->get('date');
        }
        if(!$request->get('time')){
            $time = NULL;
        }else{
            $time = $request->get('time');
        }

        if(!$request->get('priority')){
            $priority = 0;
        }else{
            $priority = $request->get('priority');
        }

        DB::table('dashboards')->where('id', $task_id)->update([
            'task_name' => $task_name, 
            'priority' => $priority,
            'date' => $date,
            'time' => $time,
            'user_id' => Auth::id()
        ]);
        return redirect()->back();
    }

//PREFERENCES
    public function editPreferences(Request $request){
        $user_id = Auth::id();//gets user id
        $p = DB::table('preferences')->get()->where('user_id', $user_id)->first();//query to get all tasks associated with current user
        if($p === NULL){
            //create default preferences array
            $sorting = 'priority';
            $coloring = 'row';
            $p_col = 1;
            $n_col = 1;
            $d_col = 1;
            $preferences = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            //go to form view with compacted associative array
            return view('preferences')->with('preferences', $preferences);
        }
        else{
            //go to form view with compacted associative array
            $to_unserialize = $p->preferences;
            $preferences = unserialize($to_unserialize);
            $coloring = $preferences['coloring'];
            $sorting = $preferences['sorting'];
            $p_col = $preferences['p_col'];
            $n_col = $preferences['n_col'];
            $d_col = $preferences['d_col'];
            $preferences = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            //go to form view with compacted associative array
            return view('preferences')->with('preferences', $preferences);
        }
    }

    public function doEditPreferences(Request $request){
        $user_id = Auth::id();//gets user id
        $preferences = DB::table('preferences')->get()->where('user_id', $user_id)->first();//query to get all tasks associated with current user
        if($preferences === NULL){
            //create new preferences row
            $coloring = $request->get('coloring');
            $sorting = $request->get('sorting');
            $p_col = $request->get('p_col');
            $n_col = $request->get('n_col');
            $d_col = $request->get('d_col');
            $preferences = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            $pstring = serialize($preferences);//convert to serialized associative array for upload
            DB::table('preferences')->insert([
                'user_id' => $user_id, 
                'preferences' => $pstring
            ]);
            return redirect()->route('home');
        }
        else{
            //update existing preferences row
            $coloring = $request->get('coloring');
            $sorting = $request->get('sorting');
            $p_col = $request->get('p_col');
            $n_col = $request->get('n_col');
            $d_col = $request->get('d_col');
            $preferences = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            $pstring = serialize($preferences);//convert to serialized associative array for upload
            DB::table('preferences')->where('user_id', $user_id)->update([ 'preferences' => $pstring ]);
            return redirect()->route('home');
        }
    }
}
