<!--Bootstrap-->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- signup-modal -->
<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signup-modal-label" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      
      <h3 class="modal-title" id="black">Signup</h3>
    </div>
    <div class="modal-body">
      <!--Main form for signup-->
      <form action="/create" method="post">
      <div class="container-fluid">

        <!--Necessary Information to be filled out-->
        <left><label id="black"><b>Priority</b></label></left>
        <right><input type="number" placeholder="Priority" name="priority"></right><br>
        <left><label id="black"><b>Task Name</b></label></left>
        <right><input type="text" placeholder="Task Name" name="task_name" required></right><br>
        <left><label id="black"><b>Date and Time</b></label></left>
        <right><input id="datetime" type="datetime-local" name="date_time"></right><br>
        
      </div> 
    </div>
    <div class="modal-footer">
      <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      <div class="col-lg-6"><button type="submit" class="btn btn-default">Create Event</button></div>
      <div class="col-lg-6"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
      </form><!--END OF FORM, necessary to include buttons in this-->
    </div>
  </div>
</div>
</div>