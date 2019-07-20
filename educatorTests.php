<html>
    <head>
        <title>Available Tests and Groups for Educator</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<script type="text/javascript" src="javascript/scripts.js"></script>
    </head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
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
			<ul class="tabs ">
				<li class="tab col s3"><a class="active blue-text darken-2" href="#tests">Tests</a></li>
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
				session_start();
				include 'db_connection.php';
				$conn = OpenCon();
				//get tests from database
				$sql = "SELECT * FROM TEST";
				$result = $conn->query($sql); 
				$tests = array();
				while($row = mysqli_fetch_assoc($result))
					$tests[] = $row;
				//for each group, get preschooler's names and display information
				foreach ($tests as $value) {
					echo '<tr><td>', $value['title'], '</td><td>', $value['description'];
					echo '</td><td><a class="waves-effect waves-light btn blue darken-4 " onclick="">Preview</a></td>';
					echo '</td><td><a href="selectGroupForTask.php?testID=', $value['testID'], '" class="waves-effect waves-light btn blue darken-2 ">Start</a></td></tr>';
				}
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
					$sql = "SELECT * FROM GROUPTEST";
					$result = $conn->query($sql); 
					$groups = array();
					while($row = mysqli_fetch_assoc($result))
						$groups[] = $row;
					//for each group, get preschooler's names and display information
					foreach ($groups as $value) {
						$groupID = $value['groupID'];
						$sql2 = "SELECT * FROM PRESCHOOLER WHERE GROUPID = '$groupID'";
						$result2 = $conn->query($sql2); 
						$preschoolers = array();
						while($row = mysqli_fetch_assoc($result2))
							$preschoolers[] = $row;
						echo '<tr><td>', $value['name'], '</td>', '<td>';
						foreach ($preschoolers as $value) 
							echo $value['name'], ' ';
						echo '</td><td><a class="waves-effect waves-light btn blue darken-4 " onclick="">Edit</a></td></tr>';
					}
					?>
					</tbody>
				</table>
				<a class="waves-effect waves-light btn blue darken-4 right" onclick="">Add New Group</a>
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
    </style>
</html>