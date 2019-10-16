<!--
Title:Create Test;
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527), Julia Aoqi Zhang (5797585);
-->

<?php
session_start();
if(isset($_SESSION['userID']))
$userID = $_SESSION['userID'];
else
header('login.php');

unset($_SESSION["createURL"]);
//get the url of the current page
$_SESSION["createURL"] = basename($_SERVER["REQUEST_URI"]);

$index = 0;
$taskIdList = array();
//get the list of parameters in the url
foreach($_GET as $key => $value){
  if($index == 0)
  array_push($taskIdList, $value);
  else
  array_push($taskIdList, $key);
  $index++;
}

include 'db_connection.php';
$conn = OpenCon();
$tasks = array();
if (count($taskIdList) > 0) {
  foreach ($taskIdList as $id) {
    $query = "SELECT * FROM TASK WHERE taskID=$id";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    $tasks[] = $row;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Test</title>
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>

</head>
<script>
//Read header
$(function() {
  document.addEventListener('DOMContentLoaded', function() {
    var elem = document.querySelectorAll('.tooltipped');
    var instance = M.Tooltip.init(elem);
  });

  //Places error element next to invalid inputs
  $.validator.setDefaults({
    errorElement: 'div',
    errorClass: 'invalid',
    errorPlacement: function(error, element) {
      if (element.attr('type') == "text" || element.attr('type') == "number") {
        $(element)
        .closest("form")
        .find("label[for='" + element.attr("id") + "']")
        .attr('data-error', error.text());
      }
    }
  })
  //validate test title
  $("#form").validate({
    rules: {
      testTitle: {
        required: true,
        remote: {
          url: "checkTestTitle.php",
          type: "post"
        }
      },
      description: "required"
    },
    messages: {
      testTitle: {
        required: "Enter a test title.",
        remote: jQuery.validator.format("{0} is already used by an existing test.")
      },
      description: "Enter a description for the test."
    }
  });
  //retrieve the stored input values
  var testTitle = localStorage.getItem('testTitle');
  var description = localStorage.getItem('description');
  $("#testTitle").val(testTitle);
  $("#description").val(description);
  //localStorage.removeItem( 'testTitle' );
  //localStorage.removeItem( 'description' );
});
function storeValues(){
  //store input values
  var testTitle = $("#testTitle").val();
  var description = $("#description").val();
  localStorage.setItem( "testTitle", testTitle );
  localStorage.setItem( "description", description );
}

var tasks = <?php echo json_encode($tasks); ?>;
$(document).ready(function(){
  displayTasks();
  /*var testTitle = sessionStorage.getItem("testTitle");
  var description = sessionStorage.getItem("description");
  $("#testTitle").val(testTitle);
  $("#description").val(description);

  console.log("testTitle: " + testTitle);*/
  //sessionStorage.clear();
});
//display all tasks
function displayTasks() {
  //create table row for each task
  tasks.forEach(function displaytask(task) {
    //get preview link for task
    var previewURL;
    previewURL = "instruction.php?from=edit&mode=preview&taskID=" + task.taskID;
    $('<tr/>').append([
      $('<td/>', {
        text: task.taskTitle
      }),
      $('<td/>', {
        text: task.activityStyle
      }),
      $('<td/>', {
        text: task.instruction
      }),
      $('<td/>').append(
        $('<a/>', {
          class: "waves-effect waves-light btn blue darken-2",
          text: "Preview",
          href: previewURL
        })
      ),
      $('<td/>').append(
        $('<a/>', {
          class: "waves-effect waves-light btn #0d47a1 red darken-1",
          text: "Remove",
          href: "removeTask.php?taskID=" + task.taskID,
          onclick: "javascript: return confirm('Are you sure you wish to remove this task from this test?');"
        })
      )
    ]).appendTo('#tableBody');
  });
}
</script>
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
    <h4 class="blue-text text-darken-4 header">Create Test</h4>
    <form id="form" action="insertTest.php" method="post" class="col s12">
      <h5 class="blue-text text-darken-4 header">
        <a class="tooltipped blue-text text-darken-4" data-position="left" data-tooltip="Title of Test">
          <i class="material-icons">help_outline</i>
        </a>Test Title
      </h5>
      <div class="row">
        <div class="input-field col s12">
          <input class="validate" placeholder="Enter a test title." id="testTitle" name="testTitle" type="text">
          <label for="testTitle"></label>
        </div>
      </div>
      <h5 class="blue-text text-darken-4 header">
        <a class="tooltipped blue-text text-darken-4" data-position="left" data-tooltip="Enter description for Task">
          <i class="material-icons">help_outline</i>
        </a>
        Description
      </h5>
      <div class="row">
        <div class="input-field col s12">
          <input class="validate" placeholder="Enter a description for test." id="description" name="description" type="text">
          <label for="description"></label>
        </div>
      </div>
      <h5 class="blue-text text-darken-4 header">
        <a class="tooltipped blue-text text-darken-4" data-position="left" data-tooltip="List of tasks in test">
          <i class="material-icons">help_outline</i>
        </a>
        Tasks
      </h5>
      <table class="striped" id="taskTable">
        <thead>
          <tr class="blueText">
            <td>TaskID&nbsp;&nbsp;</td>
            <td>Activity Style</td>
            <td>Instruction</td>
          </tr>
        </thead>
        <!--List of tasks--->
        <tbody id="tableBody">
        </tbody>
      </table>
      <br/>
      <div align="right">
        <ul id="dropdown" class = "dropdown-content">
          <li><a href="filterExistingTasks.php?from=create">Existing Tasks</a></li>
          <li><a href="createNewTaskInCreateTest.php?from=create">Create New Task</a></li>
        </ul>
        <a class="btn dropdown-button blue darken-4 addButton" onclick="storeValues();" data-activates="dropdown">
          <i class="large material-icons">add</i>
        </a>
      </div>
      <br/>
      <p align="right">
        <!-- <button type="submit" name="createTest" class="waves-effect waves-light btn blue darken-2">Create Test</button> -->
        <input style="width:120px" type="submit" name="createTest" class="submit waves-effect waves-light btn blue darken-4 right" value="Create Test">
        <a style="width:120px" class="waves-effect waves-light btn red darken-1 right" href="viewExistingTests.php">Cancel</a>
      </p>
    </form>
  </div>
  <!--end body content-->
</body>
<script>

</script>

<style>
#body {
  padding-left: 330px;
}
@media only screen and (max-width : 992px) {
  #body {
    padding-left: 0;
  }
}
.brand-logo {
  margin-top: -67px;
}
.logout {
  margin-top: 15px;
  margin-right: 15px;
}
.nav-wrapper>ul {
  margin-left: 220px;
}
.header {
  margin-top: 30px;
}
.blueText {
  color: #0d47a1;
}
/*for error label*/
label[data-error] {
  width: 100%;
  font-size: 12px;
}
.invalid {
  font-size: 12px;
  color: #EC453C;
}
.submit:hover, .addButton:hover {
  background-color: #FF8C18!important;
}
</style>

</html>
