<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;//to get information on current user
use Illuminate\Support\Facades\DB;//to perform database queries
use Illuminate\Http\Request;//HTTP requests
use App\Http\Requests\ContactFormRequest;//used for creating tasks
use Illuminate\Support\Facades\Redirect;//easy redirects
use Illuminate\Support\Facades\URL;//easy url manipulation

class SettingsController extends Controller
{
    public function settingsCheck(){
        $user_id = Auth::id();//gets user id
        $s = \App\Setting::find($user_id);
        if($s === NULL){// Create settings
            $sorting = 'priority';
            $coloring = 'row';
            $p_col = 1;
            $n_col = 1;
            $d_col = 1;
            $settings = array(
                "sorting"=>$sorting, 
                "coloring"=>$coloring, 
                "p_col"=>$p_col, 
                "n_col"=>$n_col, 
                "d_col"=>$d_col
            );
            //go to form view with compacted associative array
            return view('settings')->with('settings', $settings);
        }
        else{
            //go to form view with compacted associative array
            $to_unserialize = $s->settings;
            $settings = unserialize($to_unserialize);
            $coloring = $settings['coloring'];
            $sorting = $settings['sorting'];
            $p_col = $settings['p_col'];
            $n_col = $settings['n_col'];
            $d_col = $settings['d_col'];
            $settings = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            //go to form view with compacted associative array
            return view('settings')->with('settings', $settings);
        }
    }
    public function settings(Request $request){
        $user_id = Auth::id();//gets user id
        $set = \App\Setting::find($user_id);
        if($set === NULL){
            // Create serialized array of settings for upload
            $coloring = $request->get('coloring');
            $sorting = $request->get('sorting');
            $p_col = $request->get('p_col');
            $n_col = $request->get('n_col');
            $d_col = $request->get('d_col');
            $settings = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            $serialized = serialize($settings);
            
            // Upload via setting model
            $s = new \App\Setting;
            $s->id = $user_id;
            $s->settings = $serialized;
            $s->save();
            
            return redirect()->route('home');
        }
        else{
            // Create serialized array of settings for upload
            $coloring = $request->get('coloring');
            $sorting = $request->get('sorting');
            $p_col = $request->get('p_col');
            $n_col = $request->get('n_col');
            $d_col = $request->get('d_col');
            $settings = array("sorting"=>$sorting, "coloring"=>$coloring, "p_col"=>$p_col, "n_col"=>$n_col, "d_col"=>$d_col);
            $serialized = serialize($settings);
            
            // Update setting model
            $s = \App\Setting::find($user_id);
            $s->id = $user_id;
            $s->settings = $serialized;
            $s->save();
            
            return redirect()->route('home');
        }
    }
}
