<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;



class Tasks extends Model
{

    protected $table = 'tasks';

    // Mass assignable variables for tasks
    protected $fillable = [
        'id', 'body',
    ];

    protected $hidden = [
        'user_id'
    ];

    


    public funtion getTaskVariables('id') {
        return $tasks->body;
        return $tasks->id;
    }

    echo getTaskVariables($tasks->id);
}
