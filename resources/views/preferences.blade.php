@extends('layouts.app')

@section('content')

<?php 
    use Illuminate\Support\Facades\Route;
    $now = time();//sets current datetime  
    //autofill coloring scheme
        if($preferences['coloring'] == 'row'){ $color = true; }
        else{ $color = false; }
    //autofill columns to be colored
        $p_col = $preferences['p_col'];
        $n_col = $preferences['n_col'];
        $d_col = $preferences['d_col'];
    //autofill default sort
        if($preferences['sorting'] == 'priority'){ $sort = 1; }
        elseif($preferences['sorting'] == 'task_name'){ $sort = 2; }
        elseif($preferences['sorting'] == 'date_time'){ $sort = 3; }
        else{ $sort = 1; }//default catch
        $p = false;//temporary variable
?>

<div class="col-md-6 col-md-offset-3">

    <!-- PREFERENCES FORM -->
        {!! Form::open(['route' => 'do_preferences']) !!}
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
            <?php if($sort == 1){ $p = true; } ?>
            {{ Form::radio('sorting', 'priority', $p) }} By Priority
            <br>
            <?php $p = false; ?>
            <?php if($sort == 2){ $p = true; } ?>
            {{ Form::radio('sorting', 'task_name', $p) }} By Name
            <br>
            <?php $p = false; ?>
            <?php if($sort == 3){ $p = true; } ?>
            {{ Form::radio('sorting', 'date_time', $p) }} By Date
            <?php $p = false; ?>
        <br>

    {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

    {!! Form::close() !!}

</div>

@endsection
