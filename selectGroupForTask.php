<!--
Title:Select Group For Task;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527);
-->
<!DOCTYPE html>
<html>
	<?php
	session_start();
	if(isset($_SESSION['userID']))
		$userID = $_SESSION['userID'];
	else
		header('location: login.php');
	if(isset($_GET['testID'])){
		$testID = $_GET['testID'];
		$_SESSION['testID'] = $testID;
	}
	if(isset($_GET['mode'])){
		if($_GET['mode'] == "start")
			$_SESSION['mode'] = "start";
		else if($_GET['mode'] == "preview")
			$_SESSION['mode'] = "preview";
	}
	include 'db_connection.php';
	$conn = OpenCon();
	?>
    <head>
        <title>Select Group For Task</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
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
			      $("#InsertHeader").load("educatorHeader.html");
			    });
			  </script>
        <!--end header-->
        <!-- body content -->
        <div class="container">
			<div class="row">
				<h5 class="blue-text darken-2">Groups</h5>
			</div>
			<table class="striped">
				<thead class="blue-text darken-2">
					<tr>
						<th>Name</th>
						<th>Members</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="">
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
			$sql3 =  "SELECT name FROM PRESCHOOLER P JOIN GROUPASSIGNMENT GA ON P.preID = GA.preID WHERE GA.groupID=".$row["groupID"]." AND GA.userID=".$userID;
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
			echo '</td><td><a href="instruction.php?groupID='.$row["groupID"].'" class="waves-effect waves-light btn blue darken-4 right">Select</a></td></tr>';
		}
		CloseCon($conn);
		?>
				</tbody>
			</table>
			<div class="row">
				<div class="col s12">
						<a class="waves-effect waves-light btn red cancelButton right" href="educatorTests.php#tests">Cancel</a>
				</div>
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
	.cancelButton{
		margin-top: 20px;
		width: 80px;
	}
    </style>
</html>
