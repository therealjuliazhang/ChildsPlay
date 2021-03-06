<!--
=======================================
Title:Edit Test;
Author:Phuong Linh Bui (5624095);
=======================================
-->
<!DOCTYPE html>
<html>
<?php
include "adminAccess.php";
//get test ID
if(isset($_SESSION["testID"]))
$testID = $_SESSION["testID"];
if(isset($_GET["testID"])){
  $testID = $_GET["testID"];
  $_SESSION["testID"] = $testID;
}
//connect to database
include 'db_connection.php';
$conn = OpenCon();
//add an existing task to the test
if(isset($_GET["taskID"])){
  $taskID = $_GET["taskID"];
  $sql = $conn->prepare("SELECT MAX(orderInTest) AS max FROM TASKASSIGNMENT WHERE testID=?");
  $sql->bind_param("i", $testID);
  $sql->execute();
  $taskResult = $sql->get_result();
  
  //$sql = "SELECT MAX(orderInTest) AS max FROM TASKASSIGNMENT WHERE testID=$testID".$testID;
  //$taskResult = $conn->query($sql);
  while ($row = $taskResult->fetch_assoc()) {
    $index = $row["max"] + 1;
    $query = $conn->prepare("INSERT INTO TASKASSIGNMENT(testID, taskID, orderInTest) VALUES (?, ?, ?)");
    $query->bind_param("iii", $testID, $taskID, $index);
    
    if(!$query->execute())
      echo "<span style='color:red'>Failed to add record!".mysqli_error($conn)."</span><br/>";
    $query->close();
  }
  $_SESSION["orderInTest"] = $index;
  $sql->close();
}
//get test name and description from database
$sql = $conn->prepare("SELECT title, description FROM TEST WHERE testID=?");
$sql->bind_param("i", $testID);
$sql->execute();
$result = $sql->get_result();
$test = $result->fetch_assoc();
$sql->close();
//get tasks
$tasks = array();
$query = $conn->prepare("SELECT taskID FROM TASKASSIGNMENT WHERE testID=?");
$query->bind_param("i", $testID);
$query->execute();
$taskIDsResult = $query->get_result();
$query->close();
while ($row = $taskIDsResult->fetch_assoc()) {
  $sql = "SELECT * FROM TASK WHERE taskID=".$row["taskID"];
  $result = $conn->query($sql);
  while ($value = mysqli_fetch_assoc($result))
  $tasks[] = $value;
}
CloseCon($conn);
?>

<head>
  <title>Edit Test</title>
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  
  <script>
//Initialize tooltip
document.addEventListener('DOMContentLoaded', function() {
	var elem = document.querySelectorAll('.tooltipped');
	var instance = M.Tooltip.init(elem);
});

  var test = <?php echo json_encode($test); ?>;
  var tasks = <?php echo json_encode($tasks); ?>;
  var testID = <?php echo json_encode($testID); ?>;
  
  $(document).ready(function() {
    //initialise drop down selector
    $('.dropdown-trigger').dropdown();
    //load header
    $("#InsertHeader").load("header.html");
    //display test name and description
    $("#testTitle").val(test.title);
    $("#description").val(test.description);
    //display tasks
    displayTasks();
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
            type: "post",
            data: {
              currentTitle: test.title
            }
          }
        },
        description: {
          required: true
        },
        remote: {
          url: "checkTestTitle.php",
          type: "post",
          data: {
            currentTitle: test.title
          }
        }
      },
      messages: {
        testTitle: {
          required: "Enter a test title.",
          remote: jQuery.validator.format("{0} is already used by an existing test.")
        },
        description:{
          required: "Enter a description."
        }
      }
    });
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
      href: "removeTask.php?testID=" + testID + "&taskID=" + task.taskID,
      onclick: "javascript: return confirm('Are you sure you wish to remove this task from this test?');"
    })
  )
]).appendTo('#tableBody');
});
}
</script>
</head>
<body>
  <!--header-->
  <div id="InsertHeader"></div>
  <!-- body content -->
  <div class="container">
    <h4 class="blue-text text-darken-4 header">Edit Test</h4>
    <form id="form" action="updateTest.php?testID=<?php echo $testID;?>" method="post" class="col s12">
      <h5 class="blue-text text-darken-4 header">
        <a class="tooltipped blue-text text-darken-4" data-position="left" data-tooltip="Title of Test">
          <i class="material-icons">help_outline</i>
        </a>Test Title
      </h5>
      <div class="row">
        <div class="input-field col s12">
          <input class="validate" id="testTitle" name="testTitle" type="text">
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
          <input class="validate" id="description" name="description" type="text">
          <label for="description"></label>
        </div>
      </div>
      <h5 class="blue-text text-darken-4 header">
        <a class="tooltipped blue-text text-darken-4" data-position="left" data-tooltip="List of tasks in test">
          <i class="material-icons">help_outline</i>
        </a>
        Tasks
      </h5>
      <table class="striped">
        <thead>
          <tr class="blueText">
            <td>TaskID&nbsp;&nbsp;</td>
            <td width="20%">Activity Style</td>
            <td>Instruction</td>
          </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
      </table>
      <!--
      <div id="addTaskButton" align="right">
        <a class="dropdown-trigger btn blue darken-4" href='#' data-target="dropdown">
          <i class="large material-icons">add</i>
        </a>
        <ul id="dropdown" class="dropdown-content">
          <li><a href='filterExistingTasks.php?from=edit&testID=<?php echo $testID;?>'>Existing Tasks</a></li>
          <li><a href='createNewTaskInCreateTest.php?from=edit&testID=<?php echo $testID;?>'>Create New Task</a></li>
        </ul>
      </div>
      --->
      <div id="addTaskButton" align="right">
        <ul id="dropdown" class="dropdown-content">
          <li><a href="filterExistingTasks.php?from=edit&testID=<?php echo $testID;?>">Existing Tasks</a></li>
          <li><a href="createNewTaskInCreateTest.php?from=edit&testID=<?php echo $testID;?>">Create New Task</a></li>
        </ul>
        <a class="btn dropdown-button blue darken-4 addButton" data-activates="dropdown">
          <i class="large material-icons">add</i>
        </a>
      </div>

    <br/><br/>
    <div align="right">
      <button style="width:95px" name="submit" type="submit" class="submit waves-effect waves-light btn blue darken-2">Save</button>
      <a style="width:95px" class="waves-effect waves-light btn blue darken-4 cancelButton" href="viewExistingTests.php">Cancel</a>
    </div>
  </form>
</div>
<br/><br/>
<!--end body content-->
</body>
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
/* for error label */
label[data-error] {
  width: 100%;
  font-size: 12px;
}
.invalid {
  font-size: 12px;
  color: #EC453C;
}
#comfirmButton {
  padding-top: 50px;
  margin-bottom: 100px;
}
#addTaskButton {
  padding-top: 10px;
}
a.blue:hover, .submit:hover {
  background-color: #FF8C18!important;
}
</style>
</html>
