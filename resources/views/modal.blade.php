<!--                   -->
<!-- CREATE TASK MODAL -->
<!--                   -->
<div class="modal fade" id="create_task_modal"  tabindex="-1" role="dialog" aria-labelledby="edit_tasks_name_modal_label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="create_task_label">Create Task</h4>
      </div>

      <div class="modal-body">

        <!-- CREATE FORM -->
        {!! Form::open(['route' => 'create']) !!}

        <div class="form-group">
            {!! Form::label('task_name', 'Task Name') !!}
            {!! Form::text('task_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('priority', 'Priority') !!}
            {!! Form::select('priority', [0, 1, 2, 3, 4, 5], 0) !!}
        </div>

        <div class="form-group">
            {!! Form::label('date', 'Due Date') !!}
            {!! Form::date('date', NULL, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('time', 'Time') !!}
            {!! Form::time('time', NULL, ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit('Create', ['class' => 'btn btn-primary pull-right']) !!}

        {!! Form::close() !!}

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> Close </button>
        <div class="modal-footer"></div><!--necessary for the back of the modal to not be cut off at the bottom-->
      </div>
    </div>
  </div>
</div>

<!--                 -->
<!-- EDIT TASK MODAL -->
<!--                 -->
@if(!empty(Session::get('modal')))
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal_label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="create_task_label">
          @if(Session::get('modal') == 'edit_task_modal')
            Edit Task
          @elseif(Session::get('modal') == 'delete_task_modal')
            Delete Task
          @endif
        </h4>
      </div>

      <div class="modal-body">
        <?php
          // Get task with session variable
          $task_id = session()->get('task_id');
          session()->forget('task_id');
          $task = \App\Task::find($task_id);
          $task_name = $task->task_name;
          $priority = $task->priority;
          $date = $task->date;
          $time = $task->time;
        ?>
        
        @if(Session::get('modal') == 'edit_task_modal')
          
          <!-- EDIT TASK FORM -->
          {!! Form::open(['route' => 'edit']) !!}
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
        
        @elseif(Session::get('modal') == 'delete_task_modal')
          
          <!-- PHP date and time conversions -->
          <?php
            if($date){
              $to_date = strtotime($date);
              $display_date = date('n/d/Y', $to_date);
            }else{
              $display_date = '';
            }

            if($time){
              $to_time = strtotime($time);
              $display_time = date("g:i A", $to_time);
            }else{
              $display_time = '';
            }
          ?>

          <!-- Delete Task Modal Info -->
          <div class="form-group">
            Are you sure you would like to delete this task?<br><br>
            Name: {{ $task_name }}<br>
            Priority: {{ $priority }}<br>
            Date: {{ $display_date }}<br>
            Time: {{ $display_time }}<br>
          </div>
          <!-- Delete Task Form -->
          {!! Form::open(['route' => 'delete']) !!}
          {!! Form::hidden('task_id', $task_id) !!}
          {!! Form::submit('Delete', ['class' => 'btn btn-primary pull-right']) !!}
          {!! Form::close() !!}

        @endif

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> Close </button>
        <div class="modal-footer"></div><!--necessary for the back of the modal to not be cut off at the bottom-->
      </div>
    </div>
  </div>
</div>
@endif