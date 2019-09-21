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
    <h4 class="blue-text darken-2">Filter By:</h4>
    <h5>Date Created</h5>
    <div class="row">
      <div class="col s6">Start</div>
      <div class="col s6">End</div>
      <div class="col s6"><input type="text" class="datepicker" id="startDate"></div>
      <div class="col s6"><input type="text" class="datepicker" id="endDate"></div>
    </div>

    <h5>Task Type</h5>
    <div class="row">
      <div class="input-field col s6">
        <select class="">
          <option value="" selected disabled>Select Task Type:</option>
          <option value="1">Identify Body Parts</option>
          <option value="2">Character Ranking</option>
          <option value="3">Likert Scale</option>
          <option value="3">Preferred Mechanics</option>
        </select>
      </div>
    </div>

    <!--table for holding tasks-->
    <table class="striped">
      <thead>
        <tr class="blue-text darken-2">
          <th class='taskIdCol'>TaskID</th>
          <th class='indtructionCol'>Instruction</th>
          <th class='activityStyleCol'>Activity Style</th>
          <th class='previewCol'>Preview</th>
          <th class='editCol'>Edit</th>
          <th class='addCol'>Add</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'db_connection.php';
        $conn = OpenCon();
        $query = "SELECT * FROM TASK";
        $result = $conn->query($query);
        while($row = mysqli_fetch_assoc($result)){
          echo "<tr><td class='taskIdCol'>".$row["taskID"]."</td>".
          "<td class='indtructionCol'>".$row["instruction"]."</td>".
          "<td class='activityStyleCol'>".$row["activityStyle"]."</td>".
          "<td class='previewCol'><a class='waves-effect waves-light btn blue darken-2' href='instruction.php?taskID=".$row["taskID"]."&mode=preview&from=existingTasks'>Preview</a></td>".
          "<td class='editCol'><a class='waves-effect waves-light btn blue darken-4' href='CreateNewTaskInCreateTest.php?exist=true&taskID=".$row["taskID"]."'>Edit</a></td>".
          "<td class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='createTest.php?taskID=".$row["taskID"]."'>Add</a></td>";
        }
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
tbody {
  display:block;
  height:300px;
  overflow:auto;
}
thead, tbody tr {
  display:table;
  width:100%;
  table-layout:fixed;
}
thead {
  width: calc( 100% - 1em )
}
table {
  width:100%;
}
th{
  text-align: center;
}
.taskIdCol, .activityStyleCol, .previewCol, .editCol, .addCol{
  text-align: center;
}
.taskIdCol{
  width: 5%;
}
.instructionCol{
  width: 40%;
}
.activityStyleCol{
  width: 10%;
}
.previewCol{
  width: 13%;
}
.editCol{
  width: 13%;
}
.addCol{
  width: 13%;
}


</style>
</html>
