<html>
	<?php
	$testID = htmlspecialchars($_GET["testID"]);
	session_start();
	$_SESSION['testID'] = $testID;
	$userID = $_SESSION['userID'];
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
        <div class="row">
        <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
				<div class="row">
					<div class="col s10">
						<a href="#" class="brand-logo"><img src="images/logo1.png" height="200px"></a>
					</div>
					<div class="col s2 offset-s10">
						<a class="waves-effect waves-light btn blue darken-2 right logout" onclick="logout()">Logout</a>
					</div>
				</div>
            </div>
        </nav>
        </div>
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
						<th>Select Group</th>
					</tr>
				</thead>
				<tbody class="grey-text text-darken-1">
		<?php
		include 'db_connection.php';
		$conn = OpenCon();
		//get groups from database
		$sql = "SELECT groupID FROM GROUPASSIGNMENT WHERE userID=".$userID." GROUP BY groupID"; 
		$result = $conn->query($sql); 
		while($row = mysqli_fetch_assoc($result)){
			$sql2 = "SELECT name FROM GROUPTEST WHERE groupID=".$row["groupID"];
			$result2 = $conn->query($sql2);
			while($row2 = mysqli_fetch_assoc($result2))
				echo '<tr><td>', $row2['name'], '</td>', '<td>'; //print out group name
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
			echo '</td><td><a href="instruction.php?groupID=', $row["groupID"], '" class="waves-effect waves-light btn blue darken-2">Select</a></td></tr>';			
		}
		if($_GET['mode'] == "start")
			$_SESSION['mode'] = "start";
		?>
				</tbody>
			</table>

			<a class="waves-effect waves-light btn right blue darken-4 " onclick="">Add New Group</a>
			<br/><br/><br/>
			<div class="row">
				<div class="col s12">				
					<div class="right-align">
						<a class="waves-effect waves-light btn blue darken-4" onclick="">Cancel</a>
					</div>
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
    </style>
</html>