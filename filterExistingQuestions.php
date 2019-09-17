<html>
    <head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
            <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
                    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
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
            $("#InsertHeader").load("educatorHeader.html");
          });
        </script>
        <!--end header-->
        <!-- body content -->
        <div class="container">
            <h4>Filter By:</h4>
            <h5>Date Created</h5>
            <table>
                <tr>
                    <td>
                        Start<br/>
                        <input type="text" class="datepicker">
                    </td>
                    <td>
                        End<br/>
                        <input type="text" class="datepicker">
                    </td>
                </tr>
            </table>

            <h5>Task Type</h5><br/>

            <ul id = "dropdown" class = "dropdown-content">
                <li><a href = "#">Identify Body Parts</a></li>
                <li><a href = "#">Character Ranking</a></li>
                <li><a href = "#">Likert Scale</a></li>
                <li><a href = "#">Preferred Mechanics</a></li>
            </ul>

            <a class = "btn dropdown-button blue darken-4" href = "#" data-activates = "dropdown">Task Type</a>

            <br/><br/><br/><br/>
            <!--table for holding tasks-->
            <table class="striped">
                <thead>
                    <tr>
                        <th>TaskID</th>
                        <th>Instruction</th>
						<th>Activity Style</th>
                        <th>Preview</th>
                        <th>Edit</th>
                        <th>Add</th>
                    </tr>
                </thead>
                <tbody>
<?php
include 'db_connection.php';
$conn = OpenCon();
$query = "SELECT * FROM TASK";
$result = $conn->query($query);
while($row = mysqli_fetch_assoc($result)){
	echo "<tr><td>".$row["taskID"]."</td>".
		"<td>".$row["instruction"]."</td>".
		"<td>".$row["activityStyle"]."</td>".
		"<td><a class='waves-effect waves-light btn blue darken-2' href='instruction.php?taskID=".$row["taskID"]."&mode=preview&from=existingTasks'>Preview</a></td>".
		"<td><a class='waves-effect waves-light btn blue darken-4' href='CreateNewTaskInCreateTest.php?exist=true&taskID=".$row["taskID"]."'>Edit</a></td>".
		"<td><a class='waves-effect waves-light btn blue darken-4' href='createTest.php?taskID=".$row["taskID"]."'>Add</a></td>";
}
//CloseCon($conn);
?>
                </tbody>
            </table>
        </div>
        <!--end body content-->
    </body>
    <script>
        $('.datepicker').on('mousedown',function(event){
                            event.preventDefault();
                            });
        $('.datepicker').pickadate({
                                   selectMonths: true, // Enable Month Selection
                                   selectYears: 10 // Creates a dropdown of 10 years to control year
                                   });

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
    </style>
</html>
