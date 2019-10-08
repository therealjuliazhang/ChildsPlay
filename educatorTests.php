<!--
Title:Educator Tests; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527); 
-->
<!DOCTYPE html>
<html>
	<?php
	//send user to login if not logged in
	session_start();
	include 'db_connection.php';
	$conn = OpenCon();
	if (isset($_SESSION['userID']))
		$userID = $_SESSION['userID'];
	else
		header('location: login.php');
	?>
    <head>
        <title>Available Tests and Groups for Educator</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    </head>
	<script>
	function showError(title){
		//var error = document.getElementById("error");
		//error.innerText = "There is no task in " + title;
		alert("There is no task in " + title);
	}
	</script>
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
        <div class="container" id="tabs">
			<ul class="tabs ">
				<li class="tab col s3"><a class="blue-text darken-2" href="#tests"><h5>Tests</h5></a></li>
				<li class="tab col s3"><a class="blue-text darken-2" href="#groups"><h5>Groups</h5></a></li>
				<div class="indicator blue darken-2" style="z-index:1" id="tabIndicator"></div>
			</ul>
			<div id="tests" >
			<table class="striped">
				<thead class="blue-text darken-2">
					<tr>
						<th>Name</th>
						<th>Description</th>
						<!-- <th>Preview Test</th>
						<th>Start Testing</th> -->
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
						$previewURL = "";
						$startURL = "";
						$query = "SELECT * FROM TASKASSIGNMENT WHERE testID=".$value['testID'];
						$resultQuery = $conn->query($query);
						if(mysqli_num_rows($resultQuery) != 0){
							$previewURL = "instruction.php?testID=".$value['testID']."&mode=preview&from=educatorTests";
							$startURL = "selectGroupForTask.php?testID=".$value['testID']."&mode=start";
							echo '</td><td><a href="'.$previewURL.'" class="waves-effect waves-light btn blue darken-4">Preview</a></td>';
							echo '</td><td><a href="'.$startURL.'" class="waves-effect waves-light btn blue darken-2 ">Start</a></td></tr>';
						}
						//show error if there is no task in the test
						else{
							$parameter = "'".$value['title']."'";
							echo '</td><td><a class="waves-effect waves-light btn blue darken-4" onclick="showError('.$parameter.');">Preview</a></td>';
							echo '</td><td><a class="waves-effect waves-light btn blue darken-2" onclick="showError('.$parameter.');">Start</a></td></tr>';
						}
					}
				}
				?>
				</tbody>
			</table>
			<span id="error" style="color:red;font-style:italic"></span>
			</div>
			<div id="groups">
				<table>
					<thead class="blue-text darken-2">
						<tr>
							<th>Name</th>
							<th>Members</th>
							<!-- <th>Edit Group</th> -->
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
						echo '</td><td><a href="educatorEditGroup.php?userID='.$userID.'&groupID=', $row["groupID"] ,'" class="waves-effect waves-light btn blue darken-4 ">Edit</a></td></tr>';
					}
					CloseCon($conn);
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
	#profileIcon{
		position: absolute;
		top: -14px;
		left: 15px;
	}
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
	.tabs{
		margin-bottom: 10px;

	}
	.tabs .tab {
	    text-transform: none;
	}


    </style>
</html>
