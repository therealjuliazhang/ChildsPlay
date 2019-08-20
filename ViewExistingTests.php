<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>ViewExistingTests</title>
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
  </head>
  <body>
    <!--header-->
    <div class="row">
        <div class="navbar-fixed">
            <nav class="nav-extended blue darken-4">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li  class="active"><a href="">Tests</a></li>
                        <li><a href="">Create</a></li>
                        <li><a href="" >Results</a></li>
                        <li><a href="">Users</a></li>
                    </ul>
                    <ul id="logoutButton" class="right hide-on-med-and-down logout">
                        <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="logout()">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--end header-->
<!--body part-->
<div id="bodyPart">
  <h3 class="blue-text darken-2 header">Available Tests</h3>

  <table>
       <thead>
         <tr class="blue-text darken-2">
             <th>Name</th>
             <th>Description</th>
             <th>Created</th>
             <th>Last Edit</th>
             <th>Preview</th>
             <th>Edit</th>
             <th>Results</th>
         </tr>
       </thead>

       <tbody>
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
				$createDate = strtotime($value['dateCreated']);
				$formattedCreateDate = date( 'd/m/Y', $createDate ); //j F Y for the following date format: 15 January 2019
				
				$editDate = strtotime($value['dateEdited']);
				$formattedEditDate = date( 'd/m/Y', $editDate );
				echo '<tr><td>' . $value['title'] . '</td><td>' . $value['description'];
				echo '</td><td>'.$formattedCreateDate.'</td><td>'.$formattedEditDate;
				echo '</td><td><a href="instruction.php?testID=' . $value['testID'] . '" class="waves-effect waves-light btn blue darken-2 preview">Preview</a></td>';
				echo '</td><td><a href="#?testID=' . $value['testID'] . '" class="waves-effect waves-light btn blue darken-4 edit">Edit</a></td>';
				echo '</td><td><a href="#?testID=' . $value['testID'] . '" class="waves-effect waves-light btn blue darken-4 results">Results</a></td></tr>';
			}
		?>
         <!--<tr>
           <td>Test 1</td>
           <td>Testing of the new set of monsters with updated eye colours.</td>
           <td>09/04/19</td>
           <td>11/04/19</td>
           <td><button class="waves-effect waves-light btn blue darken-2 preview" onclick="">Preview</button></td>
           <td><button class="waves-effect waves-light btn blue darken-4 edit" onclick="">Edit</button></td>
           <td><button class="waves-effect waves-light btn blue darken-4 redults" onclick="">Results</button></td>
         </tr>
         <tr>
           <td>Test 2</td>
           <td>Test for the updated monsters for the early start day care center</td>
           <td>09/04/19</td>
           <td>12/04/19</td>
           <td><button class="waves-effect waves-light btn blue darken-2 preview" onclick="">Preview</button></td>
           <td><button class="waves-effect waves-light btn blue darken-4 edit" onclick="">Edit</button></td>
           <td><button class="waves-effect waves-light btn blue darken-4 redults" onclick="">Results</button></td>
         </tr>
         <tr>
           <td>Test 3</td>
           <td>Ranking test of the old monsters with the updated monsters</td>
           <td>09/04/19</td>
           <td>11/04/19</td>
           <td><button class="waves-effect waves-light btn blue darken-2 preview" onclick="">Preview</button></td>
           <td><button class="waves-effect waves-light btn blue darken-4 edit" onclick="">Edit</button></td>
           <td><button class="waves-effect waves-light btn blue darken-4 redults" onclick="">Results</button></td>
         </tr>-->
       </tbody>
     </table>

</div>


  </body>

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
  #sidebar{
      margin-top: 64px;
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
  #tableDiv{
      width: 400px;
  }
.sortButton{
  margin-bottom: 80px;
  }

  #bodyPart{
    margin-left: 10%;
    margin-right: 10%;
  }
  </style>
</html>
