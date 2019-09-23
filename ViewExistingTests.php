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
</head>
<body>

  <!--header-->
  <div id="InsertHeader"></div>
  <script>
  //Read header
  $(document).ready(function(){
    $("#InsertHeader").load("header.html");
  });
  function showError(title){
    var error = document.getElementById("error");
    error.innerText = "There is no task in " + title;
  }
  </script>

  <!--body part-->
  <div class="container">
    <h5 class="blue-text darken-2 header">Available Tests</h5>

    <table class="striped">
      <thead>
        <tr class="blue-text darken-2">
          <th class='nameCol'>Name</th>
          <th class='descriptionCol'>Description</th>
          <th class='createdCol'>Created</th>
          <th class='lastEditCol'>Last Edit</th>
          <th class='previewCol'>Preview</th>
          <th class='moreCol'>More</th>
        </tr>
      </thead>
      <tbody>
        <?php
        session_start();
        if(isset($_SESSION["userID"]))
        $userID = $_SESSION["userID"];
        else
        header("Location: login.php");
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
          echo "<tr><td class='nameCol'>".$value["title"]."</td><td class='descriptionCol'>".$value["description"];

          $title = "'".$value["title"]."'";

          echo "</td><td class='createdCol'>".$formattedCreateDate."</td><td class='lastEditCol'>".$formattedEditDate;

          $taskQuery = "SELECT * FROM TASKASSIGNMENT WHERE testID=".$value["testID"];
          $result = $conn->query($taskQuery);
          if(mysqli_num_rows($result) == 0){
            echo '</td><td class="previewCol"><a class="btn dropdown-button blue darken-4" onclick="showError('.$title.')"; >Preview</a>';
          }
          else{
            echo '</td><td class="previewCol"><a class="btn dropdown-button blue darken-4" data-activates="dropdown'.$index.'">Preview</a>';
            echo "<ul id='dropdown".$index."' class='dropdown-content'>";
            //display the list of tasks in the test
            while($row = mysqli_fetch_assoc($result)){
              echo "<li><a href='instruction.php?testID=".$value["testID"]."&taskID=".$row["taskID"]."&mode=preview&from=availableTests'>".$row["taskTitle"]."</a></li>";
            }
            echo "</ul></td>";
          }

				$taskQuery = "SELECT TA.*, T.taskTitle FROM TASKASSIGNMENT TA INNER JOIN TASK T WHERE TA.taskID = T.taskID AND testID=".$value["testID"];
				$result = $conn->query($taskQuery);
				if(mysqli_num_rows($result) == 0){
					echo '</td><td><a class="btn dropdown-button blue darken-4" onclick="showError('.$title.')"; >Preview</a>';
				}
				else{
					echo '</td><td><a class="btn dropdown-button blue darken-4" data-activates="dropdown'.$index.'">Preview</a>';
					echo "<ul id='dropdown".$index."' class='dropdown-content'>";
					//display the list of tasks in the test
					while($row = mysqli_fetch_assoc($result)){
						echo "<li><a href='instruction.php?testID=".$value["testID"]."&taskID=".$row["taskID"]."&mode=preview&from=availableTests'>".$row["taskTitle"]."</a></li>";
					}
					echo "</ul></td>";
				}
				
				echo "<td><a href='#?testID=".$value["testID"]."' class='btn dropdown-button blue darken-4' data-activates='dropdownTask".$index."'>...</a>";
				echo "<ul id='dropdownTask".$index."' class='dropdown-content'>";
				echo "<li><a href='editTest.php?testID=".$value["testID"]."'>Edit</a></li>";
				echo "<li><a href='results.php?testID=".$value["testID"]."'>Result</a></li>";
				echo "</ul></td></tr>";
			}
		?>
       </tbody>
     </table>
	 <span id="error" style="color:red;font-style:italic;"></span>
		<?php
			if(isset($_GET["empty"]))
				echo "<span id='error' style='color:red;font-style=italic;'>There is no task in this test!</span>";
		?>
</div>
  </body>
</html>
<style media="screen">
.container{
  width: 900px;
}
tbody {
  display:block;
  height:500px;
  overflow:auto;
}
thead, tbody tr {
  display:table;
  width:100%;
  table-layout:fixed;
}
thead {
  width: calc( 100% - 1em )
}
table {
  width: 100%;
}
.nameCol{
  width: 5%;
}
.descriptionCol{
  width: 25%;
}
.createdCol{
  width: 10%;
  text-align: center;
}
.lastEditCol{
  width: 10%;
  text-align: center;
}
.previewCol{
  width: 10%;
  text-align: center;
}
.moreCol{
  width: 10%;
  text-align: center;
}
</style>
