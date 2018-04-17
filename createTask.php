<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;//to get information on current user
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class createTask extends TestCase
{

      // @return void

    public function testExample()
    {
      $task = new \App\Task;
      $task->task_name = 'make tests';
      $task->priority = '5';
      $task->date = '4/11/18';
      $task->time = '12:00';
      $task->user_id = 0;
      $task->save();

      $task_id = $task->task_id;

      $check = \App\Task::find($task_id);

      $this->assertEquals($task->task_name, $check->name);

      if($check){
        if($check->name == $task->task_name && $check->priority == $task->priority && $check->date == $task->date && $check->time == $task->time){






          // return true;
        }


      }
    }
//     public function testBasicExample()
// {
//     $this->visit('/')
//          ->click('Learn More')
//          ->seePageIs('/about-us');
// }
}
