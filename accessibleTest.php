<!--
Title:Accessible Test;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren Sugie(5679527);
Last Edited: 22/10/2019;
-->
<!DOCTYPE html>

<html>
<?php
$baseURL = "localhost";
include 'db_connection.php';
$conn = OpenCon();
session_start();
if(isset($_SESSION['userID']))
$userID = $_SESSION['userID'];
else
header('login.php');
//get select users ID
if(isset($_GET['userID']))
$selectedUserID = $_GET['userID'];
//get user's fullname from database
$sql = "SELECT fullName FROM USERS WHERE userID=".$selectedUserID;
$result = $conn->query($sql);
$fullName = mysqli_fetch_assoc($result)['fullName'];
//get user's tests
$tests = array();
$sql = "SELECT testID, dateConducted FROM TESTASSIGNMENT WHERE userID=".$selectedUserID;
$testIDsResult = $conn->query($sql);
while($row = mysqli_fetch_assoc($testIDsResult)){
  $sql = "SELECT * FROM TEST WHERE testID=".$row['testID'];
  $testsResult = $conn->query($sql);
  while($value = mysqli_fetch_assoc($testsResult)){
    $dateConducted = $row['dateConducted'];
    array_push($value, $dateConducted);
    $tests[] = $value;
  }
}
?>
<head>
  <title>Accessible Test</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
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
    <h4 class="blue-text text-darken-4 header">Tests accessible to <span id="fullName"></span></h4>
    <div id="testsAccessible">
      <table class="striped centered">
        <thead class="blue-text darken-2">
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Conducted</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="testsTableBody" class="">
        </tbody>
      </table>
      <div class="row">
        <div class="s12">
          <a id="back" class="right waves-effect waves-light btn blue darken-4" href="userPage.php#educators">Back</a>
          <a id="addTest" class="right waves-effect waves-light btn blue darken-2" href="selectAccessibleTest.php?userID=<?php echo $selectedUserID?>">Add Test</a>
        </div>
      </div>

    </div>
  </div>
  <!--end body content-->
</body>
<script>
$(document).ready(function() {
  //get selected user Id
  var selectedUserID = <?php echo $selectedUserID; ?>;
  //display users name
  var fullName = <?php echo json_encode($fullName); ?>;
  $("#fullName").html(fullName);
  //display users accessible tests in table
  var tests = <?php echo json_encode($tests); ?>;
  tests.forEach(function displayTest(test){
    var collected;
    //get date collected
    if(test['0'] == null)
    collected = "Not yet conducted."
    else
    collected = test['0'];
    $('<tr/>').append([
      $('<td/>', { text: test.title }),
      $('<td/>', { text: test.description }),
      $('<td/>', { text: collected }),
      $('<td/>').append(
        $('<a/>', {
          class: "waves-effect waves-light btn red remove",
          text: "Remove",
          href: "removeAccessibleTest.php?userID=" + selectedUserID + "&testID=" + test.testID,
          onclick: "javascript: return confirm('Are you sure you wish to make the test inaccessible to this user?');"
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
#addTest{
  margin-top:20px;
  margin-right:10px;
  width: 100px;
}
#back{
  margin-top:20px;
  margin-right: 20px;
  width: 100px;
}
td .btn{
  width: 100px;
}
#addTest:hover, #back:hover{
  background-color: #FF8C18!important;
}

</style>
</html>
