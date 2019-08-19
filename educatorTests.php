<html>
	<?php 
	//send user to login if not logged in
	session_start(); 
	// if (!isset($_SESSION['userID'])) {
	// 	header('location: login.php');
	// }
	if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
	}
	include 'db_connection.php';
		$conn = OpenCon();
	?>
    <head>
        <title>Available Tests and Groups for Educator</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    </head>
    <body>
        <!--header-->
        <div class="row">
        <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
				<div class="row">
					<div class="col s10">
						<a href="educatorTests.php" class="brand-logo"><img src="images/logo1.png" height="200px"></a>
					</div>
					<div class="col s2 offset-s10">
						<a class="waves-effect waves-light btn blue darken-2" id="profileLink" href="adminProfile.php">Profile</a>
					</div>
				</div>
            </div>
        </nav>
        </div>
        <!--end header-->

        <!-- body content -->
        <div class="container">
			<ul class="tabs ">
				<li class="tab col s3"><a class="blue-text darken-2" href="#tests">Tests</a></li>
				<li class="tab col s3"><a class="blue-text darken-2" href="#groups">Groups</a></li>
				<div class="indicator blue darken-2" style="z-index:1"></div>
			</ul>
			<table id="tests" class="striped">
				<thead class="blue-text darken-2">
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Preview Test</th>
						<th>Start Testing</th>
					</tr>
				</thead>
				<tbody class="grey-text text-darken-1">
				<?php
				//get tests from database
				$sql1 = "SELECT testID FROM TESTASSIGNMENT WHERE userID=".$userID;
				$testIndexes = $conn->query($sql1);
				$tests = array();
				while($row = mysqli_fetch_assoc($testIndexes)){
					$sql2 = "SELECT * FROM TEST WHERE testID=".$row["testID"];
					$result = $conn->query($sql2);
					while($value = mysqli_fetch_assoc($result)){
						echo '<tr><td>' . $value['title'] . '</td><td>' . $value['description'];
						echo '</td><td><a href="instruction.php?testID=' . $value['testID'] .'&mode=preview'.'" class="waves-effect waves-light btn blue darken-4 ">Preview</a></td>';
						echo '</td><td><a href="selectGroupForTask.php?testID=' . $value['testID'] .'&mode=start'. '" class="waves-effect waves-light btn blue darken-2 ">Start</a></td></tr>';
					}
				}
				/*
				if(isset($_GET['mode'])){
					if($_GET['mode'] == "preview"){
						$_SESSION['mode'] = "preview";
					}
					else
						$_SESSION['mode'] = "start";
				}*/
				?>
				</tbody>
			</table>
			<div id="groups">
				<table>
					<thead class="blue-text darken-2">
						<tr>
							<th>Name</th>
							<th>Members</th>
							<th>Edit Group</th>
						</tr>
					</thead>
					<tbody class="grey-text text-darken-1">
					<?php
					//get groups from database
					$sql = "SELECT groupID FROM GROUPASSIGNMENT WHERE userID=".$userID." GROUP BY groupID"; 
					$result = $conn->query($sql);
					while($row = mysqli_fetch_assoc($result)){
						$sql2 = "SELECT name FROM GROUPTEST WHERE groupID=".$row["groupID"];
						$result2 = $conn->query($sql2);
						while($row2 = mysqli_fetch_assoc($result2)){
							echo '<tr><td>', $row2['name'], '</td>', '<td>'; //print out group name
						}
						$sql3 =  "SELECT name FROM PRESCHOOLER P JOIN GROUPASSIGNMENT GA ON P.preID = GA.preID WHERE GA.groupID=".$row["groupID"]." AND GA.userID=2";
						$result3 = $conn->query($sql3);
						$names = array();
						while($row3 = mysqli_fetch_assoc($result3)){
							$names[] = $row3;
						}
						$count = 0;
						foreach ($names as $value) {
							echo $value['name']; //print out preschooler's name
							$count++;
							if($count == sizeof($names)) break;
							echo ", ";
						}
						echo '</td><td><a href="educatorEditGroup.php?userID='.$userID.'&groupID=', $row["groupID"] ,'" class="waves-effect waves-light btn blue darken-4 ">Edit</a></td></tr>';
					}
					?>
					</tbody>
				</table>
				<a href="educatorAddGroup.php" class="waves-effect waves-light btn blue darken-4 right">Add New Group</a>
			</div>
        </div>
        <!--end body content-->
    </body>
    <style>
	.brand-logo{
		margin-top:-67px;
	}
	.logout{
		margin-top: 15px;
		margin-right:15px;
	}
	.tabs .tab .active {
	  background-color: rgba(38, 166, 154, 0.2);
	}
	#profileLink{
		margin-top: 15px;
	}
    </style>
</html>
