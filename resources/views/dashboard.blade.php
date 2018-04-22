@extends('layouts.app')

@section('content')



<?php
    use Illuminate\Support\Facades\Route;
    use App\Helpers;

    $now = time();
    ///////////////////////////////////
    /////////GENERAL SETTINGS//////////
    ///////////////////////////////////

    $user_id = Auth::id();
    $s = \App\Setting::find($user_id);
    if($s === NULL){// Default settings
        $sorting = 'priority';
        $coloring = 'cell';
        $p_col = 1;
        $n_col = 1;
        $d_col = 1;
    }
    else{// Custom settings
        $to_unserialize = $s->settings;
        $settings = unserialize($to_unserialize);// unserialize associative array
        $coloring = $settings['coloring'];// by row or by column
        $p_col = $settings['p_col'];// color code priority
        $n_col = $settings['n_col'];// color code name
        $d_col = $settings['d_col'];// color code date and time
    }

    ////////////////////////////////
    ////////////HEADINGS////////////
    ////////////////////////////////
?>


<div class="container" >
    
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <!-- Display Tasks based on user_id -->
            <table style="width:100%">
              <thead>
                <tr class="headr">
                    <div clas="col-xs-1">
                        <th id="pad"><center><a data-toggle="modal" href="#create_task_modal"><span class="glyphicon glyphicon-plus" style="color:black; font-size: 0.75em;"></span></a></center></th>
                    </div>
                    <div class="col-xs-1">
                        <th>
                            <a href="{{ route('priority') }}" class="pull-left">
                                <span class="glyphicon glyphicon-arrow-down" style="color:black; font-size: 0.75em;" id="pad"></span>
                            </a>
                            <div class="dbpad">Priority</div>
                        </th>
                    </div>
                    <div class="col-xs-5">
                        <th>
                            <a href="{{ route('task_name') }}" class="pull-left">
                                <span class="glyphicon glyphicon-arrow-down" style="color:black; font-size: 0.75em;" id="pad"></span>
                            </a>
                            <div class="dbpad">Task Name</div>
                        </th>
                    </div>
                    <div class="col-xs-3">
                        <th>
                            <a href="{{ route('date_time') }}" class="pull-left">
                                <span class="glyphicon glyphicon-arrow-down" style="color:black; font-size: 0.75em;" id="pad"></span>
                            </a>
                            <div class="dbpad">Due Date</div>
                        </th>
                    </div>
                    <div class="col-md-2">
                        <th id="dbpad">
                            Time
                        </th>
                    </div>
                </tr>
              </thead>

                <!-- //////////////////////////////
                ///////PREFERENCES PER TASK////////
                /////////////////////////////// -->

                @foreach ($tasks as $task)
                    <?php
                        // Priority Color
                        $priority_color = $task->priority;

                        // Date Color (Based on difference from current date)
                        $target = strtotime($task->date);
                        $diff = $target - $now;
                        if( $task->date == NULL ){ $date_color = 0; }//no color
                        elseif ( $diff < 0 ) { $date_color = 5; }//red (under 12 hours or 43200 seconds)
                        elseif ( $diff < 43200 ) { $date_color = 4; }//orange (under a day and half or 129600 seconds)
                        elseif ( $diff < 129600 ) { $date_color = 3; }//yellow (under 3 days or 259200 seconds)
                        elseif ( $diff < 259200 ) { $date_color = 2; }//green (under 5 days or 432000 seconds)
                        elseif ( $diff < 432000 ) { $date_color = 1; }//blue (under 1 week or 604800 seconds)
                        else{ $date_color = 0; }//no color

                        // Name Color (average of date and priority color)
                        $name_color = ceil(($date_color + $priority_color) / 2);
                        // Special Casese where Name Color is max priority
                        if($date_color == 5){
                            if($priority_color != 0){ $name_color = 5; }
                        }
                        if($priority_color == 5){
                            if($date_color != 0){ $name_color = 5; }
                        }

                        //Format Date
                        $raw_date = $task->date;
                        $to_date = strtotime($raw_date);
                        $date = date('n/d/Y', $to_date);

                        //Format Time
                        $raw_time = $task->time;
                        $to_time = strtotime($raw_time);
                        $time = date("g:i A", $to_time);
                    ?>

                    <!-- //////////////////////////////
                    ////////////DASHBOARD//////////////
                    /////////////////////////////// -->

                    <tr>
                        <!-- (-) DELETE BUTTON -->
                        <div class="col-xs-1">
                            <td>
                                <?php if(session('delete_id') == $task->id){ ?>
                                    <center><a href="{{ url('/delete/'.$task->id) }}"><span class="glyphicon glyphicon-remove-circle " style="color:black; font-size: 0.75em;" id="pad"></span></a></center>
                                <?php }else{ ?>
                                    <center><a href="{{ url('/delete_check/'.$task->id) }}"><span class="glyphicon glyphicon-remove" style="color:black; font-size: 0.75em;" id="pad"></span></a></center>
                                <?php } ?>
                            </td>
                        </div>

                        <!-- (-) PRIORITY (+) -->
                        <div class="col-xs-1">
                            <td
                                <?php
                                    if($p_col){
                                        if($coloring == 'row'){
                                            //set the color of the priority cell based on name color value
                                            if($name_color == 5){ echo('bgcolor="#F87171"'); }//red
                                            if($name_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                            if($name_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                            if($name_color == 2){ echo('bgcolor="#59D588"'); }//green
                                            if($name_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                            //else no color
                                        }elseif($coloring == 'cell'){
                                            //set the color of the priority cell based on priority color value
                                            if($priority_color == 5){ echo('bgcolor="#F87171"'); }//red
                                            if($priority_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                            if($priority_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                            if($priority_color == 2){ echo('bgcolor="#59D588"'); }//green
                                            if($priority_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                            //else no color
                                        }
                                    }
                                ?>
                            >
                                <center>

                                    <!-- DECREMENT -->
                                    <div class="pull-left" id="pad">
                                        <?php if ($priority_color > 0){ ?>
                                            <a href="{{ url('/priority_down/'.$task->id) }}"><span class="glyphicon glyphicon-minus" style="color:black; font-size: 0.75em;"></span></a>
                                        <?php }else{ ?>
                                            <span class="glyphicon glyphicon-asterisk" style="color:black; font-size: 0.75em;"></span>
                                        <?php } ?>
                                    </div>

                                    {{ $task->priority }}

                                    <!-- INCREMENT -->
                                    <div class="pull-right" id="pad">
                                        <?php if ($priority_color < 5){ ?>
                                            <a href="{{ url('/priority_up/'.$task->id) }}"> <span class="glyphicon glyphicon-plus" style="color:black; font-size: 0.75em;"></span></a>
                                        <?php }else{ ?>
                                            <span class="glyphicon glyphicon-asterisk" style="color:black; font-size: 0.75em;"></span>
                                        <?php } ?>
                                    </div>

                                </center>
                            </td>
                        </div>

                        <!-- (-) TASK NAME -->
                        <div class="col-xs-5">
                            <td
                                <?php
                                    // COLORING //
                                    if($n_col){
                                        if($name_color == 5){ echo('bgcolor="#F87171"'); }//red
                                        if($name_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                        if($name_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                        if($name_color == 2){ echo('bgcolor="#59D588"'); }//green
                                        if($name_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                        //else no color
                                    }
                                ?>
                            >
                            <!-- EDIT TASK BUTTON -->
                            <a href="{{ url('/edit_task/'.$task->id) }}"><span class="glyphicon glyphicon-pencil" style="color:black; font-size: 0.75em;" id="pad"></span></a>
                            {{ $task->task_name }}
                            </td>
                        </div>

                        <!-- (-) DATE (+) -->
                        <div class="col-xs-3">
                            <td
                                <?php
                                    // COLORING //
                                    if($d_col){
                                        if($coloring == 'row'){
                                            if($name_color == 5){ echo('bgcolor="#F87171"'); }//red
                                            if($name_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                            if($name_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                            if($name_color == 2){ echo('bgcolor="#59D588"'); }//green
                                            if($name_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                            //else no color
                                        }elseif($coloring == 'cell'){
                                            if($date_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                            if($date_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                            if($date_color == 2){ echo('bgcolor="#59D588"'); }//green
                                            if($date_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                            //else no color
                                        }
                                    }
                                ?>
                            >
                                <center>
                                    <!-- DECREMENT DATE -->
                                    <?php if ($task->date != NULL){ ?>
                                        <div class="pull-left" id="pad">
                                            <a href="{{ url('/date_down/'.$task->id) }}"><span class="glyphicon glyphicon-minus" style="color:black; font-size: 0.75em;"></span></a>
                                        </div>
                                    <?php } ?>

                                    @if($task->date != NULL)
                                        {{ $date }}
                                    @endif

                                    <!-- INCREMENT DATE -->
                                    <?php if ($task->date != NULL){ ?>
                                        <div class="pull-right" id="pad">
                                            <a href="{{ url('/date_up/'.$task->id) }}"> <span class="glyphicon glyphicon-plus" style="color:black; font-size: 0.75em;"></span></a>
                                        </div>
                                    <?php } ?>

                                </center>
                            </td>
                        </div>
                        <div class="col-xs-2">
                            <td
                                <?php
                                    // COLORING //
                                    if($d_col){
                                        if($coloring == 'row'){
                                            if($name_color == 5){ echo('bgcolor="#F87171"'); }//red
                                            if($name_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                            if($name_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                            if($name_color == 2){ echo('bgcolor="#59D588"'); }//green
                                            if($name_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                            //else no color
                                        }elseif($coloring == 'cell'){
                                            if($date_color == 5){ echo('bgcolor="#F87171"'); }//red
                                            if($date_color == 4){ echo('bgcolor="#FCA350"'); }//orange
                                            if($date_color == 3){ echo('bgcolor="#F6EA59"'); }//yellow
                                            if($date_color == 2){ echo('bgcolor="#59D588"'); }//green
                                            if($date_color == 1){ echo('bgcolor="#69C1F3"'); }//blue
                                            //else no color
                                        }
                                    }
                                ?>
                            >
                                <div id="dbpad">
                                    @if($task->time != NULL)
                                        {{ $time }}
                                    @endif
                                </div>
                            </td>
                        </div>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<!-- //////////////////////////////
/////////////LEGEND////////////////
/////////////////////////////// -->
<br>
<!--<div class="row">-->
    <div class="col-md-11 text-right">
    <span class="glyphicon glyphicon-info-sign" data-toggle="popover" data-trigger="hover" ></span>
        <div id="pop" >
            <div class="popuptext">
                <div style="color: #F87171;">Most Important</div>
                <div style="color: #FCA350;">Very Important</div>
                <div style="color: #F6EA59;">Moderately Important</div>
                <div style="color: #59D588;">Less Important</div>
                <div style="color: #69C1F3;">Least Important</div>
                <div style="color: white;">Not Important</div>
            </div>
        </div>

<!-- CLOSING TAGS FOR CONTAINER -->
    </div>
<!--</div>-->

<!-- //////////////////////////////
//////////////MODAL////////////////
/////////////////////////////// -->

@include('modal');

<!-- MODAL SCRIPT -->
@if(!empty(Session::get('modal')))
<script>
$(function() {
    $('#modal').modal('show');
});
</script>
@endif

<!-- POPUP SCRIPT FOR LEGEND -->



<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        'content'   : $('#pop').html(),
        'html'      : true,});
});
</script>
<!--
<script>
    function Popup() {
//        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
    }
</script>
-->

@endsection
