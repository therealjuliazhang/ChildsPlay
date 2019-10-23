<!-- 
=======================================
Title:User Page;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren Sugie(5679527);
Last Edited: 22/10/2019;
=======================================
-->
<?php
include "adminAccess.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Page</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
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
  <!-- body content -->
    <div class="container">
      <ul class="tabs">
        <li class="tab col s4"><a class="blue-text text-darken-4" href="#pendingUsers"><h5>Pending Users</h5></a></li>
        <li class="tab col s4"><a class="blue-text text-darken-4" href="#educators"><h5>Educators</h5></a></li>
        <li class="tab col s4"><a class="blue-text text-darken-4" href="#admin"><h5>Admin</h5></a></li>
        <div class="indicator blue darken-2" style="z-index:1" id="tabIndicator"></div>
      </ul>
      <!-- pending users tab-->
      <table id="pendingUsers" class="striped tablesorter">
        <thead class="blue-text text-darken-4">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Organization</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody class="">
          <?php
          //session_start();
          include 'db_connection.php';
          $conn = OpenCon();
          //get pending users from database
          $sql = "SELECT * FROM USERS WHERE accepted = 0";
          $result = $conn->query($sql);
          $users = array();
          while($row = mysqli_fetch_assoc($result))
          {
            $users[] = $row;
          }
          //print out the pending user table
          foreach($users as $user)
          {
            echo "<tr><td>".$user["fullName"]."</td><td>".$user["email"]."</td>";
            //get information about location
            $newQuery = "SELECT L.name FROM LOCATION L JOIN LOCATIONASSIGNMENT LA ON L.locationID = LA.locationID WHERE LA.userID=".$user["userID"];
            $newResult = $conn->query($newQuery);
            $rowcount = mysqli_num_rows($newResult);
            $newLoc = "<td>";
            $count=0;
            while($row = mysqli_fetch_assoc($newResult))
            {
              $newLoc .= $row["name"];
              if($count < $rowcount - 1)
              {
                $newLoc .= ", ";
              }
              $count++;
            }
            echo $newLoc."</td>";
            if($user["accountType"]==0)
            {
              echo "<td>Educator</td>";
            }else
            {
              echo "<td>Admin</td>";
            }
            //print buttons
            echo "<td><a href='loading.php?uid=".$user["userID"]."&accepted=1' class='waves-effect waves-light btn  blue darken-4 acceptButton'>Accept</a></td>";
            echo "<td><a href='loading.php?uid=".$user["userID"]."&accepted=-1' class='waves-effect waves-light btn red  declineButton'>Decline</a></td></tr>";
          }
          ?>
        </tbody>
      </table>
      <!-- educators tab-->
      <div id="educators">
        <table class="striped tablesorter">
          <thead class="blue-text text-darken-4">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Organisation</th>
            </tr>
          </thead>
          <tbody class="">
            <?php
            /*
            $sql = "SELECT fullName, email, LOCATION.name FROM LOCATIONASSIGNMENT LA JOIN USERS U ON U.userID = LA.userID ".
            "JOIN LOCATION L ON LA.locationID = L.locationID WHERE accountType = 0";*/
            $sql = "SELECT * FROM USERS WHERE accountType = 0 AND accepted = 1";//accepted educators
            $sqlResult = $conn->query($sql);
            $educators = array();
            while($row = mysqli_fetch_assoc($sqlResult)){
              $educators[] = $row;
            }

            foreach ($educators as $educator){
              echo "<tr><td>".$educator["fullName"]."</td>".
              "<td>".$educator["email"]."</td>";
              $query = "SELECT L.name FROM LOCATION L JOIN LOCATIONASSIGNMENT LA ON L.locationID = LA.locationID WHERE LA.userID=".$educator["userID"];
              $result = $conn->query($query);
              $rowcount = mysqli_num_rows($result);
              $location = "<td>";
              $i = 0;
              while($row = mysqli_fetch_assoc($result)){
                $location .= $row["name"];
                if($i < $rowcount - 1){
                  $location .= ", ";
                }
                $i++;
              }
              echo $location."</td>";
              echo '<td><a class="waves-effect waves-light btn blue darken-4 testButton" href="accessibleTest.php?userID='.$educator["userID"].'">Tests</a></td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--Admin Tab-->
      <div id="admin">
        <table class="striped tablesorter">
          <thead class="blue-text text-darken-4">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Organisation</th>
            </tr>
          </thead>
          <tbody class="">
            <?php
            $conn = OpenCon();
            $sql = "SELECT * FROM USERS WHERE accountType = 1 AND accepted = 1"; //accepted admin
            $sqlResult = $conn->query($sql);
            while($row = mysqli_fetch_assoc($sqlResult)){
              $query = "SELECT L.name FROM LOCATION L JOIN LOCATIONASSIGNMENT LA ON L.locationID = LA.locationID WHERE userID=".$row["userID"];
              $result = $conn->query($query);
              $location = mysqli_fetch_array($result);
              echo "<tr><td>".$row["fullName"]."</td>".
              "<td>".$row["email"]."</td>".
              "<td>".$location["name"]."</td></tr>";
            }
            CloseCon($conn);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
  <script>
  //Sorting The table contents
  $(document).ready(function() {
  $("table").tablesorter();
  });
  //Initialise tabs
  $(document).ready(function(){
    $('.tabs').tabs();
  });
  //remove a declined row
  $('.declineButton').click(function() {
    $(this).closest('tr').remove();
  });
  //remove an accepted row
  $('.acceptButton').click(function() {
    $(this).closest('tr').remove();
  });
</script>

<style media="screen">
.container{
  margin-top: 25px;
  width: 900px;
}
.tabs .tab a:focus, .tabs .tab a:focus.active {
  background-color: rgba(38, 166, 154, 0.2);
  outline: none;
}
.tabs .tab a:hover, .tabs .tab a.active {
  background-color: rgba(38, 166, 154, 0.2);
  color: #ee6e73;
}
#profileLinkButton {
  padding-left: 16px;
  padding-right: 16px;
}
#profileLinkIcon{
  font-size: 24px;
}
ul.tabs {
  float: center;
  max-width: 99%;
  overflow-x: hidden;
}
.tabs{
  margin-bottom: 10px;
}
.tabs .tab {
  text-transform: none;
}
.tablesorter-header {
  cursor: pointer;
  outline: none;
}
.tablesorter-header-inner::after {
  content: '▼';
  font-size: 12px;
  margin-left: 5px;
}
td .btn{
  width: 120px;
}
.acceptButton:hover, .testButton:hover{
  background-color: #FF8C18!important;
}
</style>
</html>
