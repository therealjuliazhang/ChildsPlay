<!DOCTYPE html>
<html>
<head>
  <title>Child'sPlay</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <!-- CSS  -->
  <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!--  Scripts-->
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type = "text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js"></script>
</head>
<!--code for jquery-->

<!--the stuff in the head is all the linking things to Materialize-->
<!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
<body>
  <!--header-->
  <div id="InsertHeader"></div>
  <script>
  //Read header
  $(function(){
    $("#InsertHeader").load("header.html");
  });
  </script>
  <!--end header-->
  <!-- body content -->
  <div class="container">
    <h5 class="blue-text darken-2">Filter By:</h5>
    <h6 class="blue-text darken-2 header">Date Created</h6>
	<form action="" method="post">
		<table>
		  <tr>
			<td>
			  Start Date<br/>
			  <input type="text" class="datepicker" name="startDate" id="startDate">
			</td>
			<td>
			  End Date<br/>
			  <input type="text" class="datepicker" name="endDate" id="endDate">
			</td>
		  </tr>
		</table>

		<h6 class="blue-text darken-2 header">Activity Style</h6>
		<div class="row">
		  <div class="input-field col s6">
			<select class="" name="activityStyle">
			  <option value="" selected disabled>Select Activity Style:</option>
			  <option value="Identify Body Parts">Identify Body Parts</option>
			  <option value="Character Ranking">Character Ranking</option>
			  <option value="Likert Scale">Likert Scale</option>
			  <option value="Preferred Mechanic">Preferred Mechanics</option>
			</select>
		  </div>
		</div>
		<div class="row">
			<button class="btn waves-effect waves-light blue darken-4 sortButton" type="submit" name="submitFilter">Filter</button>
		</div>
	</form>
	<br/>
    <!--
    <ul id = "dropdown" class = "dropdown-content">
    <li><a href = "#">Identify Body Parts</a></li>
    <li><a href = "#">Character Ranking</a></li>
    <li><a href = "#">Likert Scale</a></li>
    <li><a href = "#">Preferred Mechanics</a></li>
    <a class = "btn dropdown-button blue darken-4" href = "#" data-activates = "dropdown">Task Type</a>
  </ul>
-->
<!--table for holding tasks-->
<table class="striped">
  <thead>
    <tr class="blue-text darken-2">
      <th>TaskID</th>
      <th>Instruction</th>
      <th>Activity Style</th>
	  <th>Date Created</th>
      <th>Preview</th>
      <th>Edit</th>
      <th>Add</th>
    </tr>
  </thead>
  <tbody>
    <?php
    include_once 'filterTasks.php';
    //CloseCon($conn);
    ?>
  </tbody>
</table>
<div class="row">
  <div class="col s1 offset-s11"><a class="waves-effect waves-light btn #2196f3 blue right" id="cancelButton">Cancel</a></div>
</div>
</div>
<!--end body content-->
</body>
<script>
//Initialize Selector
$(document).ready(function(){
  $('select').formSelect();
});
//Initialize Date Picker
$(document).ready(function(){
  $('.datepicker').datepicker();
});

$('.datepicker').on('mousedown',function(event){
  event.preventDefault();
});
$(function() {
  $("#startDate").datepicker();
  $("#endDate").datepicker();

    $("#endDate").on("change",function(){
      checkDate();
    });
    $("#startDate").on("change",function(){
      checkDate();
    });
});
function checkDate(){
  var startSelected = $('#startDate').val();
  var endSelected = $('#endDate').val();
  startDate = new Date(startSelected);
  endDate = new Date(endSelected);
  // alert("StartDate: " + startSelected + "EndDate: " + endSelected);

  if(startDate > endDate){
    alert('End date should be greater than Start date. Please select a valid range.');
  }
}
//Date validation
/*
$(function() {
  $("#startDate").datepicker();
  $("#startDate").on("change",function(){
    var startSelected = $(this).val();
    $("#endDate").datepicker();
    $("#endDate").on("change",function(){
      var endSelected = $(this).val();
      //alert(startSelected + endSelected);
      if(startSelected > endSelected){
        alert('End date should be greater than Start date. Please select a valid range.');
      }
    });
  });
});
*/
/*
$('.datepicker').pickadate({
selectMonths: true, // Enable Month Selection
selectYears: 10 // Creates a dropdown of 10 years to control year
});
*/
</script>
<style>
#body {
  padding-left: 330px;
}
@media only screen and (max-width : 992px) {
  #body{
    padding-left: 0;
  }
}
.brand-logo{
  margin-top:-67px;
}
.logout{
  margin-top: 15px;
  margin-right:15px;
}

.nav-wrapper > ul {
  margin-left: 220px;
}
.header{
  margin-top: 30px;
}
#cancelButton{
  margin-top: 15px;
}
.datepicker-date-display {
  background-color: #1976D2;
  color: #fff;
}
.datepicker-cancel, .datepicker-clear, .datepicker-today, .datepicker-done {
  color: #1976D2;
}
.datepicker-table td.is-selected {
  background-color: #1976D2;
}
</style>
</html>
