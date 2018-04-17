<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditTask extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
      $task = new \App\Task;
      $task->task_name = 'edit task test';
      $task->priority = '5';
      $task->date = '4/11/18';
      $task->time = '08:00';
      $task->user_id = 0;
      $task->save();

      $task->priority = '2';
      $task->save();

      $task_id = $task->task_id;

      $check = \App\Task::find($task_id);
      $this -> assertTrue(false);

      //check if task priority is the newly edited 2
      if($check){
        if($check->name == $task->task_name && $check->priority == '2' && $check->date == $task->date && $check->time == $task->time){
          $this -> assertTrue(false);
          //add tags to test
          return true;
        }


    }
}
}
