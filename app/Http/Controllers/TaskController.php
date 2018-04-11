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

    public function editCheck($task_id){
        session(['task_id' => $task_id]);
        return Redirect::back()->with('modal', 'edit_task_modal');
    }

    public function edit(Request $request){
        // Send for validation
        $attributes = $this->check($request);
        $task_id = $request->task_id;

        // Find and update task with attributes then save in database
        $task = \App\Task::find($task_id);
        $task->task_name = $attributes['task_name'];
        $task->priority = $attributes['priority'];
        $task->date = $attributes['date'];
        $task->time = $attributes['time'];
        $task->user_id = \Auth::id();
        $task->save();

        return redirect()->back();
    }

    ///////////////////////////////////
    ///////////EDIT PRIORITY///////////
    ///////////////////////////////////

    public function priority_up($task_id){// Increment Priority
        $task = \App\Task::find($task_id);
        if($task->priority < 5){
            $task->priority = $task->priority + 1;
            $task->save();
        }
        return redirect()->back();
    }

    public function priority_down($task_id){// Decrement Priority
        $task = \App\Task::find($task_id);
        if($task->priority > 0){
            $task->priority = $task->priority - 1;
            $task->save();
        }
        return redirect()->back();
    }

    ///////////////////////////////////
    /////////////EDIT DATE/////////////
    ///////////////////////////////////

    public function date_up($task_id){// Increment Date 
        $task = \App\Task::find($task_id);

        // Convert String to Carbon date, increment, convert back
        $before = $task->date;
        $carbondate =  Carbon::parse($before)->addDays(1);
        $after = $carbondate->toDateTimeString();

        $task->date = $after;
        $task->save();
        
        return redirect()->back();
    }

    public function date_down($task_id){// Decrement Date
        $task = \App\Task::find($task_id);
        
        // Convert String to Carbon date, decrement, convert back
        $before = $task->date;
        $carbondate =  Carbon::parse($before)->subDays(1);
        $after = $carbondate->toDateTimeString();

        $task->date = $after;
        $task->save();

        return redirect()->back();
    }

    ///////////////////////////////////
    ////////////CHECK TASK/////////////
    ///////////////////////////////////

    public function check(Request $request){
        // TASK NAME VALIDATION
        if(!$request->get('task_name')){
            return redirect()->back();
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
        // TASK ID
        $task_id = $request->get('task_id');

        // Set attributes to return
        $attributes = array(
            'task_name' => $task_name, 
            'priority' => $priority, 
            'date' => $date, 
            'time' => $time,
            'task_id' => $task_id
        );
        return $attributes;
    }
}
