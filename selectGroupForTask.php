<html>
    <head>
        <title>Select Group For Task</title>
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
			<div class="row">
				<div class="col s12">				
					<div class="right-align">
						<a class="waves-effect waves-light btn blue darken-2" onclick="">Cancel</a>
					</div>
				</div>
			</div>
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
		session_start();
		include 'db_connection.php';
		$conn = OpenCon();
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
			echo '<tr><td>', $value['groupName'], '</td>', '<td>';
			foreach ($preschoolers as $value) 
				echo $value['name'], ' ';
			echo '</td><td><a class="waves-effect waves-light btn blue darken-2 " onclick="">Select</a></td></tr>';
		}
		?>
				</tbody>
			</table>
			<a class="waves-effect waves-light btn right blue darken-4 " onclick="">Add New Group</a>
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