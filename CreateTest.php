<?php
session_start();	
?>

<html>
    <head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
		<link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
			<script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js">
        document.addEventListener('DOMContentLoaded', function() {
            var elem = document.querySelectorAll('.tooltipped');
            var instance = M.Tooltip.init(elem);
        });
        </script>
    </head>
    <!--code for jquery-->
    
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
    <body>
        <!--header-->
		<div id="InsertHeader"></div>
		<script>
		//Read header
		  $(function(){
			$("#InsertHeader").load("header.html");
		  });
		</script>
		<!--
        <div class="row">
            <div class="navbar-fixed">
                <nav class="nav-extended blue darken-4">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                        <ul id="nav-mobile" class="left hide-on-med-and-down">
                            <li><a href="">Tests</a></li>
                            <li><a href="">Create</a></li>
                            <li class="active"><a href="" >Edit</a></li>
                            <li><a href="">Users</a></li>
                        </ul>
                        <ul id="logoutButton" class="right hide-on-med-and-down logout">
                            <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="">Profile</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
		--->
        <!--end header-->
        <!-- body content -->
        <div class="container">
        <form action="insertTest.php" method="post" class="col s12">
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="Title of Test">
                    <i class="material-icons">help_outline</i>
                </a>Test Title
            </h5>
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Test 1" id="testTitle" name="testTitle" type="text">
                </div>
            </div>
            </br>
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="Enter description for Task">
                    <i class="material-icons">help_outline</i>
                </a>
                Description
            </h5>
            <div class="row">
                <div class="input-field col s12">
                    <input placeholder="Testing the new set of monsters with updated eye colours" id="description" name="description" type="text">
                </div>
            </div></br>
			<h5 class="blue-text darken-2 header">
				<a class="tooltipped" data-position="left" data-tooltip="List of tasks in test">
					<i class="material-icons">help_outline</i>
				</a>
				Tasks
			</h5>
            <table class="striped" id="taskTable">
                <thead>
                    <tr class="blueText">
                        <td>TaskID&nbsp;&nbsp;</td>
						<td>Activity Style</td>
                        <td>Instruction</td>
                        <td>Preview</td>
						<td>Remove</td>
                    </tr>
                </thead>
				<!--List of tasks--->
                <tbody>
				<?php
				/*
				author: Phuong Linh Bui (5624095)
				*/
				include 'db_connection.php';
				$conn = OpenCon();
				$taskList = array();
				$idList = array();
                                
                //session_destroy();
                //unset($_GET["list"]);
                                
				//get a list of newly created tasks and store it in SESSION
				if(isset($_GET["taskID"])){
					$taskID = $_GET["taskID"];
					if(!isset($_SESSION["list"])){
						$_SESSION["list"] = $taskID;
						array_push($idList, $taskID);
					} 
					else{
						$taskList = explode(",", $_SESSION["list"]);
						if(!in_array($taskID, $taskList)){
							$_SESSION["list"] .= ",".$taskID;
						}
						$idList = explode(",", $_SESSION["list"]);
					}
					if(isset($_GET["remove"])){
						$taskID = $_GET["taskID"];
						if (($key = array_search($taskID, $idList)) !== false) {
							unset($idList[$key]);
                            if(count($idList) > 0)
                                $_SESSION["list"] = join(",", $idList);
                            else{
                                session_destroy();
                                unset($_SESSION["list"]);
                            }
						}
					}
				}
				//display the newly created task(s) into the list of tasks
				if(count($idList) > 0){
					foreach($idList as $id){
						$query = "SELECT * FROM TASK WHERE taskID=$id";
						$result = $conn->query($query);
						$row = mysqli_fetch_assoc($result);
							echo "<tr><td>".$row["taskID"]."</td>".
								"<td>".$row["activityStyle"]."</td>".
								"<td>".$row["instruction"]."</td>".
								"<td><a class='waves-effect waves-light btn blue darken-2'>Preview</a></td>".
								"<td><a class='waves-effect waves-light btn blue darken-4' href='?taskID=".$row["taskID"]."&remove=true'>Remove</a></td></tr>";
					}
				}
				?>
                </tbody>
            </table>
            
            <br/>
            
            <div align="right">
                <ul id = "dropdown" class = "dropdown-content">
                    <li><a href="filterExistingQuestions.php">Existing Tasks</a></li>
                    <li><a href="CreateNewTaskInCreateTest.php?from=create">Create New Task</a></li>
                </ul>
                <a class = "btn dropdown-button blue darken-4" href="" data-activates = "dropdown">
                    <i class="large material-icons">add</i>
                </a>
            </div>

            <br/><br/><br/>
            <p align="right">
                <button type="submit" name="createTest" class="waves-effect waves-light btn blue darken-2">Create Test</button>
                <a class="waves-effect waves-light btn blue darken-4">Cancel</a>
            </p>
		</form>
        </div>
        <!--end body content-->
    </body>
    <script>
        
    </script>
    
    <style>
        #body {
            padding-left: 330px;
        }
    @media only screen and (max-width : 992px) {
        #body{
            padding-left: 0;
        }
    }
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
    .blueText
    {
        color:#1976D2;
    }
    </style>
</html>
