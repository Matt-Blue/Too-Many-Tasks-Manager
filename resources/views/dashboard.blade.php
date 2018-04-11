@extends('layouts.app')

@section('content')

<?php 
    use Illuminate\Support\Facades\Route;
    $now = time();//sets current datetime  
    //determine preference as to whether the cells should be colored by row or by cell
    $user_id = Auth::id();//gets user id
    $p = DB::table('preferences')->get()->where('user_id', $user_id)->first();//query to get all tasks associated with current user
    if($p === NULL){
        $coloring = 'cell';
        $p_col = 1;
        $n_col = 1;
        $d_col = 1;
    }
    else{
        //update existing preferences row
        $to_unserialize = $p->preferences;
        $preference = unserialize($to_unserialize);
        $coloring = $preference['coloring'];//by row or by column
        $p_col = $preference['p_col'];//color code priority
        $n_col = $preference['n_col'];//color code name
        $d_col = $preference['d_col'];//color code date and time
    }
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <!-- Display Tasks based on user_id -->
            <table style="width:100%">
                <tr>
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
                @foreach ($tasks as $task)
                    <?php 
                        //set priority color to priority
                        $priority_color = $task->priority;
                        //set the values that determine the color of the date and time cells below based on the time relative to the current time (declared at top)
                        $target = strtotime($task->date);
                        $diff = $target - $now;
                        //time done in seconds
                        //within one day = 24hours/day x 60 minutes/hour x 60 seconds/minute = 86400
                        //5: within 12 hours = 86400 / 2 = 43200
                        //4: within a day and a half = 86400 x 3 / 2 = 129600
                        //3: within three days = 86400 x 3 = 259200
                        //2: within five days = 86400 x 5 = 432000
                        //1: within one week = 86400 x 7 = 604800
                        if( $task->date == NULL ){ $date_color = 0; }//no color
                        elseif ( $diff < 0 ) { $date_color = 5; }//red
                        elseif ( $diff < 43200 ) { $date_color = 4; }//orange
                        elseif ( $diff < 129600 ) { $date_color = 3; }//yellow
                        elseif ( $diff < 259200 ) { $date_color = 2; }//green
                        elseif ( $diff < 432000 ) { $date_color = 1; }//blue
                        else{ $date_color = 0; }//no color

                        //set the color of the name cell based on the average of the priority and the date value calculated above
                        $name_color = ceil(($date_color + $priority_color) / 2);
                        //additional logic so if the date or time is particularly important it highlights it in red
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
                    <tr>
                        <div class="col-xs-1">
                            <td>
                                <!-- Delete button -->
                                <?php if(session('delete_id') == $task->id){ ?>
                                    <center><a href="{{ url('/delete/'.$task->id) }}"><span class="glyphicon glyphicon-remove-circle " style="color:black; font-size: 0.75em;" id="pad"></span></a></center>
                                <?php }else{ ?>
                                    <center><a href="{{ url('/delete_check/'.$task->id) }}"><span class="glyphicon glyphicon-remove" style="color:black; font-size: 0.75em;" id="pad"></span></a></center>
                                <?php } ?>
                            </td>
                        </div>
                        <div class="col-xs-1">
                            <td
                                <?php
                                    if($p_col){
                                        if($coloring == 'row'){
                                            //set the color of the priority cell based on name color value
                                            if($name_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                            if($name_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                            if($name_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                            if($name_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                            if($name_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
                                            //else no color
                                        }elseif($coloring == 'cell'){
                                            //set the color of the priority cell based on priority color value
                                            if($priority_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                            if($priority_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                            if($priority_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                            if($priority_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                            if($priority_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
                                            //else no color
                                        }
                                    }
                                ?>
                            >
                            <center>
                                <div class="pull-left" id="pad">
                                <?php if ($priority_color > 0){ ?>
                                    <a href="{{ url('/priority_down/'.$task->id) }}"><span class="glyphicon glyphicon-minus" style="color:black; font-size: 0.75em;"></span></a>
                                <?php }else{ ?>
                                    <span class="glyphicon glyphicon-asterisk" style="color:black; font-size: 0.75em;"></span>
                                <?php } ?>
                                </div>

                                {{ $task->priority }}

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
                        <div class="col-xs-5">
                            <td
                                <?php //set the color of the task name cell based on value calculated above
                                    if($n_col){
                                        if($name_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                        if($name_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                        if($name_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                        if($name_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                        if($name_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
                                        //else no color
                                    }
                                ?>
                            >
                            <a href="{{ url('/edit_task/'.$task->id) }}"><span class="glyphicon glyphicon-pencil" style="color:black; font-size: 0.75em;" id="pad"></span></a>
                            {{ $task->task_name }}
                            </td>
                        </div>
                        <div class="col-xs-3">
                            <td
                                <?php //set the color of the date time cell based on value calculated above
                                    if($d_col){
                                        if($coloring == 'row'){
                                            //set the color of the priority cell based on name color value
                                            if($name_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                            if($name_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                            if($name_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                            if($name_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                            if($name_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
                                            //else no color
                                        }elseif($coloring == 'cell'){
                                            //set the color of the priority cell based on priority color value
                                            if($date_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                            if($date_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                            if($date_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                            if($date_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                            if($date_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
                                            //else no color
                                        }
                                    }
                                ?>
                            >
                                <center>
                                    <?php if ($task->date != NULL){ ?>
                                        <div class="pull-left" id="pad">
                                            <a href="{{ url('/date_down/'.$task->id) }}"><span class="glyphicon glyphicon-minus" style="color:black; font-size: 0.75em;"></span></a>
                                        </div>
                                    <?php } ?>

                                    @if($task->date != NULL)
                                        {{ $date }}
                                    @endif
                                    
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
                                <?php //set the color of the date time cell based on value calculated above
                                    if($d_col){
                                        if($coloring == 'row'){
                                            //set the color of the priority cell based on name color value
                                            if($name_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                            if($name_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                            if($name_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                            if($name_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                            if($name_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
                                            //else no color
                                        }elseif($coloring == 'cell'){
                                            //set the color of the priority cell based on priority color value
                                            if($date_color == 5){ echo('bgcolor="#ff6698"'); }//red
                                            if($date_color == 4){ echo('bgcolor="#ffb366"'); }//orange
                                            if($date_color == 3){ echo('bgcolor="#ffff66"'); }//yellow
                                            if($date_color == 2){ echo('bgcolor="#98ff66"'); }//green 
                                            if($date_color == 1){ echo('bgcolor="#6698ff"'); }//blue 
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

<br><div class="row">
    <div class="col-md-11 text-right">
    <div class="popup" onclick="Popup()">Legend
  <span class="popuptext" id="myPopup">
    <div style="color: #ff6698;">Most Important</div>
    <div style="color: #ffb366;">Very Important</div>
    <div style="color: #ffff66;">Moderately Important</div>
    <div style="color: #98ff66;">Less Important</div>
    <div style="color: #6698ff;">Least Important</div>
    <div style="color: white;">Not Important</div>
  </span>
</div>


    </div>
</div>

@include('modal');

@if(!empty(Session::get('modal')))
<!-- Modal Script -->
<script>
$(function() {
    $('#modal').modal('show');
});
</script>
@endif

<!-- Popup Script -->
<script>
    function Popup() {
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
    }
</script>

@endsection
