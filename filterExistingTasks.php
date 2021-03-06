<!--
===========================================================================================
Title:Filter Existing Tasks;
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527);
===========================================================================================
-->
<?php
include "adminAccess.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Filter Existing Tasks</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <!-- CSS  -->
  <!-- <link rel="stylesheet" type="text/css" href="childsPlayStyle.css"> -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!--  Scripts-->
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type = "text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js"></script>
</head>
<!--code for jquery-->
<script>
//save filtering values when reload the page
$(document).ready(function(){
  var start = sessionStorage.getItem("start");
  var end = sessionStorage.getItem("end");
  var activityStyle = sessionStorage.getItem("activityStyle");
  $("#startDate").val(start);
  $("#endDate").val(end);
  $("#activityStyle").val(activityStyle);
  sessionStorage.clear();
});

function filter(){
  var start = $("#startDate").val();
  var end = $("#endDate").val();
  var activityStyle = $("#activityStyle option:selected").val();
  sessionStorage.setItem("start", start);
  sessionStorage.setItem("end", end);
  sessionStorage.setItem("activityStyle", activityStyle);
}
</script>

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
    <h3 class="blue-text text-darken-4">Filter By:</h3>

    <div class="card-panel z-depth-3">
      <div class="row">
        <div class="col s4">
          <h5 class="blue-text text-darken-4 header">Date Created</h5>
        </div>
        <div class="col s4 offset-s4">
          <h5 class="blue-text text-darken-4 header">Activity Style</h5>
        </div>
        <form action="" method="post">
          <div class="col s4">Start date</div>
          <div class="col s4">End date</div>
          <div class="col s4"><br/></div>
          <div class="col s4"><input type="text" class="datepicker" id="startDate" name="startDate"></div>
          <div class="col s4"><input type="text" class="datepicker" id="endDate" name="endDate"></div>
          <div class="input-field col s4">
            <select class="" name="activityStyle" id="activityStyle">
              <option value="" selected disabled>Select Activity Style:</option>
              <option value="Identify Body Parts">Identify Body Parts</option>
              <option value="Character Ranking">Character Ranking</option>
              <option value="Likert Scale">Likert Scale</option>
              <option value="Preferred Mechanics">Preferred Mechanics</option>
            </select>
          </div>
          <div class="col s12">
            <br>
            <button class="btn waves-effect waves-light blue darken-4 sortButton" type="submit" name="submitFilter" onclick="filter()">Filter</button>
          </div>
        </form>
      </div>
    </div>
<br/>
<!--table for holding tasks-->
<div style="overflow:auto">
  <table class="striped">
    <thead>
      <tr class="blue-text text-darken-4">
        <th class='taskIdCol'>Title</th>
        <th class='instructionCol'>Instruction</th>
        <th class='activityStyleCol'>Activity Style</th>
        <th class='dateCreatedCol'>Date Created</th>
      </tr>
    </thead>
    <tbody>
      <?php
      //unset the sessions for preview tasks in filter existing tasks from comments.php
      if(isset($_SESSION["create"]))
      unset($_SESSION["create"]);
      if(isset($_SESSION["edit"]))
      unset($_SESSION["edit"]);

      if(isset($_GET["from"])){
        $from = $_GET["from"];
        $_SESSION["from"] = $from;
      }
      if(isset($_GET["testID"])){
        $testID = $_GET["testID"];
        $_SESSION["testID"] = $testID;
      }
      $from = "filterExistingTasks";
      include_once 'filterTasks.php';
      ?>
    </tbody>
  </div>
</table>
</div>
<div class="row">
  <div class="col s12">
    <!--<a class="waves-effect waves-light btn #2196f3 blue right" id="cancelButton">Cancel</a>-->
    <!--<a class="waves-effect waves-light btn blue darken-4 cancelButton right" onClick="javascript:history.go(-1)">Cancel</a>--->
    <a class="waves-effect waves-light btn blue darken-4 cancelButton right" href="<?php echo isset($_SESSION["createURL"]) ? $_SESSION["createURL"]:"" ; ?>" >Cancel</a>
    
  </div>
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
.cancelButton{
  margin-top: 15px;
  width: 100px;
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
.sortButton{
  width: 100px;
}
td .btn{
  width: 100px;
}
.input-field {
  margin-top: 0rem;
}
.sortButton:hover, .editButton:hover, .addButton:hover, .previewButton:hover, .cancelButton:hover{
  background-color: #FF8C18!important;
}
.card-panel {
    padding: 10px 24px;
    margin: .5rem 0 1rem 0;
}
.row {
    margin-bottom: 0px;
}
</style>
</html>
