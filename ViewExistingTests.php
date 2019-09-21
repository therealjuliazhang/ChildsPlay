<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Available Tests</title>
     <meta name = "viewport" content="width=device-width, initial-scale = 1">
     <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
    <link rel = "stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel = "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale = 1">
    <script type="text/javascript"src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js">
    </script>

    <!--end header-->
  </head>
  <body>

    <!--header-->
	<?php
	//$contents = file_get_contents('header.html');
	//echo $contents;
	?>
  <div id="InsertHeader"></div>
	<script>
    //Read header
	  $(document).ready(function(){
      //$(function(){
        $("#InsertHeader").load("header.html");
      });
  </script>

<!--body part-->
<div id="bodyPart">
  <h5 class="blue-text darken-2 header">Available Tests</h5>

  <table class="striped">
       <thead>
         <tr class="blue-text darken-2">
             <th>Name</th>
             <th>Description</th>
             <th>Created</th>
             <th>Last Edit</th>
             <th>Preview</th>
             <th>More</th>
         </tr>
       </thead>
       <tbody>
		<?php
			session_start();
            //session_destroy();
            //unset($_SESSION["tasks"]);
			include 'db_connection.php';
			$conn = OpenCon();
			//get tests from database
			$sql = "SELECT * FROM TEST";
			$result = $conn->query($sql);
			$tests = array();
			while($row = mysqli_fetch_assoc($result))
				$tests[] = $row;
			//for each group, get preschooler's names and display information
			$index = 0;
			foreach ($tests as $value) {
				$index++;
				$createDate = strtotime($value["dateCreated"]);
				$formattedCreateDate = date("d/m/Y", $createDate ); //j F Y for the following date format: 15 January 2019

				$editDate = strtotime($value["dateEdited"]);
				$formattedEditDate = date("d/m/Y", $editDate );
				echo "<tr><td>".$value["title"]."</td><td>".$value["description"];
				echo "</td><td>".$formattedCreateDate."</td><td>".$formattedEditDate;
				echo "</td><td><a href='#' class='btn dropdown-button blue darken-4' data-activates='dropdown".$index."'>Preview</a>";

				$taskQuery = "SELECT * FROM TASKASSIGNMENT WHERE testID=".$value["testID"];
				$result = $conn->query($taskQuery);
				echo "<ul id='dropdown".$index."' class='dropdown-content'>";
				while($row = mysqli_fetch_assoc($result)){
					echo "<li><a href='instruction.php?testID=".$value["testID"]."&taskID=".$row["taskID"]."&mode=preview&from=availableTests'>".$row["taskTitle"]."</a></li>";
				}

				echo "</ul></td>";
				echo "<td><a href='#?testID=".$value["testID"]."' class='btn dropdown-button blue darken-4' data-activates='dropdownTask2'>...</a>";
				echo "<ul id='dropdownTask2' class='dropdown-content'>";
				echo "<li><a href='#'>Edit</a></li>";
				echo "<li><a href='#'>Result</a></li>";
				echo "</ul></td></tr>";
			}
		?>
       </tbody>
     </table>
</div>
  </body>
</html>
