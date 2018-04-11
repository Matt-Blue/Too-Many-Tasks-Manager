@extends('layouts.app')

@section('content')

<?php 
    use Illuminate\Support\Facades\Route;

    $now = time();//sets current datetime 

    //autofill coloring scheme
    if($settings['coloring'] == 'row'){ $color = true; }
    else{ $color = false; }

    //autofill columns to be colored
    $p_col = $settings['p_col'];
    $n_col = $settings['n_col'];
    $d_col = $settings['d_col'];

    //autofill default sort
    if($settings['sorting'] == 'priority'){ $sort = 1; }
    elseif($settings['sorting'] == 'task_name'){ $sort = 2; }
    elseif($settings['sorting'] == 'date_time'){ $sort = 3; }
    else{ $sort = 1; }//default catch
    $t = false;//temporary variable
?>

<div class="col-md-6 col-md-offset-3">

    <!-- SETTINGS FORM -->
        {!! Form::open(['route' => 'settings']) !!}
    <!-- Color by either cell or row -->
        <br>
            {!! Form::label('coloring', 'How the Cells are Colored') !!}
            <br>
            {{ Form::radio('coloring', 'row', $color) }} By Row
            <br>
            {{ Form::radio('coloring', 'cell', !$color) }} By Cell
        <br>
    <!-- Which columns should be colored -->
        <br>
            {!! Form::label('columns', 'Which Columns Should be Color Coded') !!}
            <br>
            {{ Form::checkbox('p_col', 1, $p_col) }} Priority
            <br>
            {{ Form::checkbox('n_col', 1, $n_col) }} Task Name
            <br>
            {{ Form::checkbox('d_col', 1, $d_col) }} Date and Time
        <br>
    <!-- Default sorting -->
        <br>
            {!! Form::label('sorting', 'Default Sorting Scheme') !!}<br>
            <?php if($sort == 1){ $t = true; } ?>
            {{ Form::radio('sorting', 'priority', $t) }} By Priority
            <br>
            <?php $t = false; ?>
            <?php if($sort == 2){ $t = true; } ?>
            {{ Form::radio('sorting', 'task_name', $t) }} By Name
            <br>
            <?php $t = false; ?>
            <?php if($sort == 3){ $t = true; } ?>
            {{ Form::radio('sorting', 'date_time', $t) }} By Date
            <?php $t = false; ?>
        <br>

    {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

    {!! Form::close() !!}

</div>

@endsection
