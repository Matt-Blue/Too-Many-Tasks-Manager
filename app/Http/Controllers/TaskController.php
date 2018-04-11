<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;//to get information on current user
use Illuminate\Support\Facades\DB;//to perform database queries
use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;//used for creating tasks
use Illuminate\Support\Facades\Redirect;//easy redirects
use Illuminate\Support\Facades\URL;//easy url manipulation
use Carbon\Carbon;//datetime manipulation

class TaskController extends Controller
{

    ///////////////////////////////////
    ////////////CREATE TASK////////////
    ///////////////////////////////////

    public function create(Request $request){//create task
        
        // Send for validation
        $attributes = $this->check($request);

        // Create task with attributes and save in database
        $task = new \App\Task;
        $task->task_name = $attributes['task_name'];
        $task->priority = $attributes['priority'];
        $task->date = $attributes['date'];
        $task->time = $attributes['time'];
        $task->user_id = \Auth::id();
        $task->save();

        return redirect()->back();
    }

    ///////////////////////////////////
    ////////////DELETE TASK////////////
    ///////////////////////////////////

    public function deleteCheck($task_id){// Call Are You Sure? Modal
        session(['task_id' => $task_id]);
        return Redirect::back()->with('modal', 'delete_task_modal');
    }

    public function delete(Request $request){// Delete Task via ID
        \App\Task::destroy($request->get('task_id'));
        return redirect()->back();
    }

    ///////////////////////////////////
    /////////////EDIT TASK/////////////
    ///////////////////////////////////

    ///////////////////////////////////
    ///////////EDIT PRIORITY///////////
    ///////////////////////////////////

    public function priority_up($task_id){

    }

    ///////////////////////////////////
    /////////////EDIT DATE/////////////
    ///////////////////////////////////

    ///////////////////////////////////
    ////////////CHECK TASK/////////////
    ///////////////////////////////////

    public function check(Request $request){
        // TASK NAME VALIDATION
        if(!$request->get('task_name')){
            return view('dashboard', compact('tasks'));//returns home view and passes the dashboard variable to it
        }else{
            $task_name = $request->get('task_name');
        }
        // DATE AND TIME VALIDATION
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
        // PRIORITY VALIDATION
        if(!$request->get('priority')){
            $priority = 0;
        }else{
            $priority = $request->get('priority');
        }

        // Set attributes to return
        $attributes = array(
            "task_name" => $task_name, 
            "priority" => $priority, 
            "date" => $date, 
            "time" => $time
        );
        return $attributes;
    }
}
