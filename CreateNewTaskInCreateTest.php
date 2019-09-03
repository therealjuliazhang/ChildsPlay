<html>
    <head>
		<?php
			//get user ID
			// session_start();
			// if(isset($_SESSION['userID']))
			// 	$userID = $_SESSION['userID'];
			// else
			// 	header('login.php');
			$userID = 1; //remove after admin pages are linked up
			//get test ID
			// if(isset($_GET['testID']))
			// 	$testID = $_GET['testID'];
			$testID = 2; //remove after admin pages are linked up
			//get user image directory
			$imageDirectory = "C:\xampp\htdocs\images";
		?>
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
			document.addEventListener('DOMContentLoaded', function() {
				var elem = document.querySelectorAll('.tooltipped');
				var instance = M.Tooltip.init(elem);
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
                            <li class="active"><a href="">Create</a></li>
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
            <form action="createTest.php" method="post">
				<h5 class="blue-text darken-2 header">
					<a class="tooltipped" data-position="left" data-tooltip="Choose activity style from list">
						<i class="material-icons">help_outline</i>
					</a>
					Activity Style:
				</h5>
				<div class="row">
					<div class="input-field col s12">
						<select name="activityStyle">
							<option value="Identify Body Part" selected>Identify Body Part</option>
							<option value="Likert Scale">Likert Scale</option>
							<option value="Character Ranking">Character Ranking</option>
							<option value="Preferred Mechanics">Preferred Mechanics</option>
						</select>
					</div>
				</div>
				<h5 class="blue-text darken-2 header">
					<a class="tooltipped" data-position="left" data-tooltip="Activity for Task">
					<i class="material-icons">help_outline</i>
					</a>
					Activity
				</h5>
				<div class="row">
					<div class="input-field col s12">
						<input name="activity" placeholder="Identifying the [body part]" id="Activity" type="text">
					</div>
				</div>
				<h5 class="blue-text darken-2 header">
					<a class="tooltipped" data-position="left" data-tooltip="Click to upload image">
						<i class="material-icons">help_outline</i>
					</a>
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
								<input name="imageFileName" class="file-path" type="text" webkitdirectory directory multiple>
							</div>
						</div>
						<!--end upload button + path-->
					</div>
				</div>
            	<img id="OriginalImage" class="image" style="width:15%;">
				<div class="row">
					<div class="col s12">
						<p align="right">
							<button type="submit" class="submit waves-effect waves-light btn blue darken-2">Create Task</button>
							<a class="waves-effect waves-light btn blue darken-4">Cancel</a>
						</p>
					</div>
				</div>
			</form>
			<!--end form-->
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
