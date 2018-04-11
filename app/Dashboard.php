<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dashboard extends Model
{
    // Fillable attributes
    protected $fillable = ['task_name', 'priority', 'date', 'time', 'user_id'];

    ///////////////////////////////////
    ////////////CREATE TASK////////////
    ///////////////////////////////////

    public function __construct(array $attributes = array()){//create task
        \DB::table('dashboards')->insert([
            'task_name' => $attributes[0], 
            'priority' => $attributes[1],
            'date' => $attributes[2],
            'time' => $attributes[3],
            'user_id' => \Auth::id()
        ]);
        $this->task_name = $attributes[0];
        $this->priority = $attributes[1];
        $this->date = $attributes[2];
        $this->time = $attributes[3];
        $this->user_id = \Auth::id();
        return redirect()->back();
    }

    ///////////////////////////////////
    ////////////DELETE TASK////////////
    ///////////////////////////////////

    public function __destruct(){//delete task
        // \DB::table('dashboards')->where('id', $this->task_id)->delete();
        return $this->task_name;
        // return redirect()->back();
    }

    ///////////////////////////////////
    /////////////EDIT TASK/////////////
    ///////////////////////////////////

    ///////////////////////////////////
    ///////////EDIT PRIORITY///////////
    ///////////////////////////////////

}
