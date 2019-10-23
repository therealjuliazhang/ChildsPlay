<!--
=======================================
Title:Select Accessible Test;
Author:Zhixing Yang(5524726), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527);
=======================================
-->
<!DOCTYPE html>
<html>
<?php
/*
//get user ID
session_start();
if(isset($_SESSION['userID']))
  $userID = $_SESSION['userID'];
else
  header('login.php');
*/
include "adminAccess.php";
//open connection to database
include 'db_connection.php';
$conn = OpenCon();
//get selected Users ID
if(isset($_GET['userID']))
$selectedUserID = $_GET['userID'];
//get tests IDs of tests assigned to user
$assignedTests = array();
$sql = "SELECT testID FROM TESTASSIGNMENT WHERE userID=".$selectedUserID;
$testIDsResult = $conn->query($sql);
while($row = mysqli_fetch_assoc($testIDsResult))
$assignedTests[] = $row['testID'];
//get tests not assigned to user
$availableTests = array();
$assignedTestsForQuery = join("','",$assignedTests);
$sql = "SELECT * FROM TEST WHERE testID NOT IN ('$assignedTestsForQuery')";
$availableTestsResult = $conn->query($sql);
while($row = mysqli_fetch_assoc($availableTestsResult))
$availableTests[] = $row;
?>
<head>
  <title>Select Test</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>

</head>
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
    <h4 class="blue-text text-darken-4 header">Available Tests</h4>
    <div id="availableTest">
      <table class="striped centered">
        <thead class="blue-text text-darken-4">
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th>Last Edit</th>
            <th>Give Access</th>
          </tr>
        </thead>
        <tbody id="testsTableBody" class="">
        </tbody>
      </table>
      <div class="row">
        <div class="col s12">
          <a id="back" href="accessibleTest.php?userID=<?php echo $selectedUserID ?>" class="right waves-effect waves-light btn blue darken-4">Back</a>
        </div>
      </div>
    </div>
  </div>
  <!--end body content-->
</body>
<script>
$(document).ready(function() {
  var selectedUserID = <?php echo $selectedUserID; ?>;
  //display available tests in table
  var tests = <?php echo json_encode($availableTests); ?>;
  tests.forEach(function displayTest(test){
    $('<tr/>').append([
      $('<td/>', { text: test.title }),
      $('<td/>', { text: test.description }),
      $('<td/>', { text: test.dateCreated }),
      $('<td/>', { text: test.dateEdited }),
      $('<td/>').append(
        $('<a/>', {
          class: "waves-effect waves-light btn blue darken-4 assignButton",
          href: "assignTest.php?userID=" + selectedUserID + "&testID=" + test.testID,
          text: "Assign"
        })
      )
    ]).appendTo('#testsTableBody');
  });
});
</script>
<style>
#body {
  padding-left: 330px;
  padding-bottom: 50px;
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
#profileIcon{
  position: absolute;
  top: -14px;
  left: 15px;
}
#back{
  margin-top:20px;
  width: 95px;
}
.assignButton{
  width: 95px;
}
.assignButton:hover, #back:hover{
  background-color: #FF8C18!important;
}
</style>
</html>
