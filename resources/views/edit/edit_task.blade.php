@extends('layouts.app')

@section('content')

<?php 
    foreach($tasks as $task){
        $task_id = $task->id;
        $task_name = $task->task_name;
        $priority = $task->priority;
        $date = $task->date;
        $time = $task->time;
    }
?>
<div class="col-xs-6 col-xs-offset-3">
    <!-- EDIT TASK FORM -->
    {!! Form::open(['route' => 'edit_task']) !!}

    <div class="form-group">
        {!! Form::label('task_name', 'Task Name') !!}
        {!! Form::text('task_name', $task_name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('priority', 'Priority') !!}
        {!! Form::select('priority', [0, 1, 2, 3, 4, 5], $priority) !!}
    </div>

    <div class="form-group">
        {!! Form::label('date', 'Due Date') !!}
        {!! Form::date('date', $date, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('time', 'Time') !!}
        {!! Form::time('time', $time, ['class' => 'form-control']) !!}
    </div>

    {!! Form::hidden('task_id', $task_id) !!}

    {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

    {!! Form::close() !!}
</div>

@endsection