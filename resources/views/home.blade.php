@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- if task is set, display all tasks associated with user account -->
                    <ul>
                    @if (isset($tasks))
                        @foreach ($tasks as $task)
                            <li>{{$task->body}}</li>
                        @endforeach
                    @else
                        <p>There are no tasks to display.</p>
                    @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
