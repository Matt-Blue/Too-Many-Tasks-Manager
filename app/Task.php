<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Set which attributes can be filled by mass assignment (in a single go)
    protected $fillable = ['task_name', 'priority', 'date', 'time'];
    // Specify the associated table
    protected $table = 'tasks';
    // Disable default timestamps requirement
    public $timestamps = false;

}
