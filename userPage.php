<!DOCTYPE html>

<html>
    <head>
        <title>User Page</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
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
			<ul class="tabs">
				<li class="tab col s3"><a class="blue-text darken-2" href="#pendingUsers"><h5>Pending Users</h5></a></li>
				<li class="tab col s3"><a class="blue-text darken-2" href="#educators"><h5>Educators</h5></a></li>
        <li class="tab col s3"><a class="blue-text darken-2" href="#admin"><h5>Admin</h5></a></li>
				<div class="indicator blue darken-2" style="z-index:1"></div>
			</ul>
      <!-- pending users tab-->
			<table id="pendingUsers" class="striped">
				<thead class="blue-text darken-2">
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Organization</th>
						<th>Role</th>
            <th width="10%">Accept</th>
            <th width="10%">Decline</th>
					</tr>
				</thead>
				<tbody class="grey-text text-darken-1">
          <tr>
            <td>Jenny Carter</td>
            <td>jenny75@gmail.com</td>
            <td>Mulberry hill preschool</td>
            <td>Educator</td>
            <td><a href="#?accepted=1" class="waves-effect waves-light btn acceptButton">Accept</a></td>
            <td><a href="#?accepted=-1" class="waves-effect waves-light btn #ff5252 red accent-2 declineButton">Decline</a></td>
          </tr>
          <tr>
            <td>Kerry Price</td>
            <td>kezz1@hotmail.com</td>
            <td>Smith preschool</td>
            <td>Educator</td>
            <td><a class="waves-effect waves-light btn acceptButton">Accept</a></td>
            <td><a class="waves-effect waves-light btn #ff5252 red accent-2 declineButton">Decline</a></td>
          </tr>
          <tr>
            <td>Geff Smith</td>
            <td>gf356</td>
            <td>University of Wollongong</td>
            <td>Admin</td>
            <td><a class="waves-effect waves-light btn acceptButton">Accept</a></td>
            <td><a class="waves-effect waves-light btn #ff5252 red accent-2 declineButton">Decline</a></td>
          </tr>
				</tbody>
			</table>

      <!-- educators tab-->
			<div id="educators">
				<table class="striped">
					<thead class="blue-text darken-2">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Organisation</th>
							<th>Accessible Tests</th>
						</tr>
					</thead>
					<tbody class="grey-text text-darken-1">
<?php
include 'db_connection.php';
$conn = OpenCon();
/*
$sql = "SELECT fullName, email, LOCATION.name FROM LOCATIONASSIGNMENT LA JOIN USERS U ON U.userID = LA.userID ".
		"JOIN LOCATION L ON LA.locationID = L.locationID WHERE accountType = 0";*/
$sql = "SELECT * FROM USERS WHERE accountType = 0";
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
	echo '<td><a class="waves-effect waves-light btn #0d47a1 blue darken-4" href="accessibleTest.php?userID='.$educator["userID"].'">Tests</a></td></tr>';
}
?>
					</tbody>
				</table>
			</div>
      <!--Admin Tab-->
      <div id="admin">
        <table class="striped">
					<thead class="blue-text darken-2">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Organisation</th>
						</tr>
					</thead>
          <tbody class="grey-text text-darken-1">
<?php
$sql = "SELECT * FROM USERS WHERE accountType = 1";
$sqlResult = $conn->query($sql);
while($row = mysqli_fetch_assoc($sqlResult)){
	$query = "SELECT L.name FROM LOCATION L JOIN LOCATIONASSIGNMENT LA ON L.locationID = LA.locationID WHERE userID=".$row["userID"];
	$result = $conn->query($query);
	$location = mysqli_fetch_array($result);
	echo "<tr><td>".$row["fullName"]."</td>".
		"<td>".$row["email"]."</td>".
		"<td>".$location["name"]."</td></tr>";
	CloseCon($conn);
}
?>
          </tbody>

        </table>
      </div>
        </div>
        <!--end body content-->
    </body>
<script>
//remove a declined row
$('.declineButton').click(function() {
  $(this).closest('tr').remove();
});
//remove an accepted row
$('.acceptButton').click(function() {
  $(this).closest('tr').remove();
});

</script>

</html>
