@extends('layouts.app')

@section('content')
    @if (Route::has('login'))
        <div class="top-right links">
            
        </div>
    @endif

    <div class="content">
        <center>
            <h1>Too Many Tasks Manager</h1><br>
            @if (Auth::check())
                <button class="btn btn-default"><a href="{{ url('/home') }}" id="black">{{ Auth::user()->name }}'s Dashboard</a></button>
            @endif        
        </center>
    </div>
@endsection
