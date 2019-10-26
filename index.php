<!--
======================================================================================
Title:Index; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527); 
======================================================================================
-->
<html>
<head>
        <title>Child'sPlay</title>
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
                <div class="nav-content">
                    <ul class="tabs tabs-transparent blue darken-4">
                        <li class="tab"><a target="_self" href="#TestList"><span class="white-text">Test List</span></a></li>
                        <li class="tab"><a target="_self "href="#GroupList"><span class="white-text">Manage Groups</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <br/><br/>
        <!--end header-->

        <!-- body content -->

        <div class="container">
            <div class="row">
                <!--start test list page-->
                <div id="TestList" class="col s12">
                    <div class="row">
                        <div class="col s2"><h5 class="blue-text darken-2">Name</h5></div>
                        <div class="col s4"><h5 class="blue-text darken-2">Description</h5></div>
                        <div class="col s3"><h5 class="blue-text darken-2">Preview Test</h5></div>
                        <div class="col s3"><h5 class="blue-text darken-2">Start Testing</h5></div>
                    </div>

					<div class="divider"></div><div class="divider"></div>

<?php
session_start();

include 'db_connection.php';
$conn = OpenCon();

$sql = "SELECT * FROM TEST";
$result = $conn->query($sql);

if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()){
		echo '<div class="row">
                <div class="col s2 tableData" class="testID">'.$row["testID"].'</div>
                <div class="col s4 tableData">'.$row["description"].'</div>
                <div class="col s3 tableData"><button class="waves-effect waves-light btn blue darken-4 right preview" onclick="check()">Preview</button></div>
                <div class="col s3 tableData"><a class="waves-effect waves-light btn blue darken-2 right startB" onclick="startTest('.$row["testID"].')">Start</a></div>
              </div>

              <div class="divider"></div>';
	}
} else {
	echo "0 results";
}
?>

                </div>


                <!--end test list page-->

                <!--start group list page-->
                <div id="GroupList" class="col s12">
                    <div class="row">
                        <div class="col s2"><h5 class="blue-text darken-2">Name</h5></div>
                        <div class="col s7"><h5 class="blue-text darken-2">Members</h5></div>
                        <div class="col s3"><h5 class="blue-text darken-2">Edit Group</h5></div>
                    </div>
                    <div class="divider"></div><div class="divider"></div>
                    <!--start of one row-->
<?php
$groupQuery = "SELECT * FROM GROUPTEST";
$groups = $conn->query($groupQuery);

if($groups->num_rows > 0) {
	$array = array();
	while($group = $groups->fetch_assoc()){
		$groupID = $group["groupID"];
		$childQuery = "SELECT * FROM PRESCHOOLER WHERE groupID=$groupID";
		$children = $conn->query($childQuery);
		echo '<div class="row">
                        <div class="col s2 tableData">'.$group["name"].'</div>
						<div class="col s7 tableData">';
						$count = 0;
				while($child = $children->fetch_assoc()){
					array_push($array, $child["name"]);

                    echo $child["name"];

					$count++;
					if($count < $children->num_rows){
						echo ", ";
					}
					else{
						echo "";
					}
				}
                echo '</div>
				<div class="col s3"><a class="waves-effect waves-light btn blue darken-4 right edit" onclick="editGroup();">Edit</a></div>
				</div>

              <div class="divider"></div>';
	}
	$_SESSION['names'] = $array;
} else {
	echo "0 results";
}
CloseCon($conn);
?>
					<!--end of one row-->

                </div>
                <!--end group list page-->
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
    .edit{
        margin-top: 15px;
        margin-right:15px;
    }
    .tableData
    {
        margin-top: 15px;
        font-size: 16px;
    }
    .preview
    {
        margin-top: 15px;
        margin-right:15px;
    }
    .startB
    {
        margin-top: 15px;
        margin-right:15px;
    }
    </style>
</html>
