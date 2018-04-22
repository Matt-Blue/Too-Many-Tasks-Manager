<?php
    namespace App;

    // Coloring Function
    if (!function_exists('color')) {
        function color($color){
            //set the color based on color value passed
            if($date_color == 5){ $c = 'bgcolor="#ff6698"'; }//red
            elseif($date_color == 4){ $c = 'bgcolor="#ffb366"'; }//orange
            elseif($date_color == 3){ $c = 'bgcolor="#ffff66"'; }//yellow
            elseif($date_color == 2){ $c = 'bgcolor="#98ff66"'; }//green 
            elseif($date_color == 1){ $c = 'bgcolor="#6698ff"'; }//blue 
            else $c = '';
            return $c;
        }
    }
    
    