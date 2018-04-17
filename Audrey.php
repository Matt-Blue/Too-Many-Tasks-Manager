<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Audrey extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
      $task = new \App\Task;
      $task->task_name = 'master test';
      $task->priority = '3';
      $task->date = '5/5/18';
      $task->time = '12:00';
      $task->user_id = 0;
      $task->save();


      $task->time = '05:00';
      $task->save();

      $task_id = $task->task_id;

      $check = \App\Task::find($task_id);

      if($check){
        if($check->name == $task->task_name && $check->priority == $task->priority && $check->date == $task->date && $check->time == '05:00'){
          \App\Task::destroy($task_id);
          $check = \App\Task::find($task_id);
          if($check==null){
          return true;
        }}
      }}
}
