<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class deleteTask extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
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

      

      \App\Task::destroy($task->task_id);
        $check = \App\Task::find($task_id);
      if($check == NULL){
        

          $this->assertTrue(true);
        }


      }

      public function testExample2()
    {
        $task = new \App\Task;
      $task->task_name = 'Throw out trash';
      $task->priority = '4';
      $task->date = '4/11/18';
      $task->time = '5:00';
      $task->user_id = 0;
      $task->save();

      $task_id = $task->task_id;

      

      \App\Task::destroy($task->task_id);
        $check = \App\Task::find($task_id);
      if($check == NULL){
        

          $this->assertTrue(true);
        }


      }
      public function testExample3()
    {
        $task = new \App\Task;
      $task->task_name = 'Do homework';
      $task->priority = '2';
      $task->date = '4/11/18';
      $task->time = '3:00';
      $task->user_id = 0;
      $task->save();

      $task_id = $task->task_id;

      

      \App\Task::destroy($task->task_id);
        $check = \App\Task::find($task_id);
      if($check == NULL){
        

          $this->assertTrue(true);
        }


      }


      public function testExample4()
    {
        $task = new \App\Task;
      $task->task_name = 'Clean house';
      $task->priority = '1';
      $task->date = '4/11/16';
      $task->time = '3:00';
      $task->user_id = 0;
      $task->save();

      $task_id = $task->task_id;

      

      \App\Task::destroy($task->task_id);
        $check = \App\Task::find($task_id);
      if($check == NULL){
        

          $this->assertTrue(true);
        }


      }
    }

