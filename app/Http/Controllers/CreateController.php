<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function index(){
        //create item in databasae
        $input = Input::only('priority','task_name','date_time'); 

        return view('home');
    }
}
