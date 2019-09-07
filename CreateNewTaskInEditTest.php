<html>
	<?php 
		//check if user logged in
		session_start();
		if(isset($_SESSION['userID']))
			$userID = $_SESSION['userID'];
		else
			header('login.php');
		//get test ID
		if(isset($_GET['testID']))
			$testID = (int)$_GET['testID'];
	?>
    <head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script>             
		document.addEventListener('DOMContentLoaded', function() {
			var elems = document.querySelectorAll('select');
			var instances = M.FormSelect.init(elems);
		});
		$(document).ready(function() {
			//get input values
			var taskTitle = $("#taskTitle").val();
			var activityStyle = $("#taskType").val();
			var instruction = $("#instruction").val();
			var imageAddress = $("#imageAddress").val();
		});
		</script>
	</head>
    <body>
        <!--header-->
        <div class="row">
            <div class="navbar-fixed">
                <nav class="nav-extended blue darken-4">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                        <ul id="nav-mobile" class="left hide-on-med-and-down">
                            <li><a href="">Tests</a></li>
                            <li><a href="">Create</a></li>
							<li class="active"><a href="">Edit</a></li>
                            <li><a href="">Users</a></li>
                        </ul>
                        <ul id="logoutButton" class="right hide-on-med-and-down logout">
                            <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="">Profile</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--end header-->
        <!-- body content -->
        <div id="body" class="container">
			<!--start form-->
            <form action="insertTask.php?from=edit&testID=<?php echo json_encode($testID);?>" method="post">
				<h5 class="blue-text darken-2 header">
					Task Title:
				</h5>
				<div class="row">
					<div class="input-field col s12">
						<input id="taskTitle" type="text">
					</div>
				</div>
				<h5 class="blue-text darken-2 header">
					Activity Style:
				</h5>
				<div class="row">
					<div class="input-field col s12">
						<select name="activityStyle" id="taskType">
							<option value="Identify Body Parts" selected>Identify Body Part</option>
							<option value="Likert Scale">Likert Scale</option>
							<option value="Character Ranking">Character Ranking</option>
							<option value="Preferred Mechanic">Preferred Mechanics</option>
						</select>
					</div>
				</div>
				<h5 class="blue-text darken-2 header">
					Instruction
				</h5>
				<div class="row">
					<div class="input-field col s12">
						<input name="activity"id="instruction" type="text">
					</div>
				</div>
				<h5 class="blue-text darken-2 header">
					Image
				</h5>
				<div class="row">
					<div class="col s12">
					<!--start upload button + path display-->
						<div class="file-field input-field">
							<div class="waves-effect waves-light btn blue darken-4">
								<span>Upload</span>
								<input type="file">
							</div>
							<div class="file-path-wrapper">
								<input name="imageFileName" id="imageAddress" class="file-path" type="text">
							</div>
						</div>
					<!--end upload button + path-->
					</div>
				</div>
				<img id="OriginalImage" class="image" src="images/Orbi.png" style="width:15%;">
				<div class="row">
					<div class="col s12">
						<p align="right">
							<button type="submit" class="waves-effect waves-light btn blue darken-2">Create Task</button>
							<a class="waves-effect waves-light btn blue darken-4">Cancel</a>
						</p>
					</div>
				</div>
			</form>
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
		.nav-wrapper > ul {
			margin-left: 220px;
		}
		.header{
			margin-top: 30px;
		}
		.image{
			margin-top: 10px;
		}
    </style>
</html>
