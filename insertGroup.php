<!--
Title:Insert Group; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
-->
<?php 
//if(isset($_POST["submit"])){
	$check = false;
	
include 'db_connection.php';
$conn = OpenCon();
include "educatorAccess.php";
/*
session_start();
if(isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];
else
    header("Location: login.php");
*/
//used to determine what information $value holds
$valueCount = 0;
//get groupname and location
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
//insert group into grouptest table
//$sql = "INSERT INTO GROUPTEST (name, locationID)VALUES ('".$groupName."', '".$location."')";
$sql = "INSERT INTO GROUPTEST (name, locationID, userID) VALUES ('".$groupName."', '".$location."', '".$userID."')";  
if ($conn->query($sql) === TRUE){ 
	echo "New record created successfully";
    $check = true;
    //get groupID of inserted group
    $sql = "SELECT groupID FROM GROUPTEST WHERE name = '" . $groupName. "' limit 1"; //groupname is unique
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $groupID;
    $groupID = $row['groupID'];
    //get preschoolers data and insert into database
    $preschooler = new stdClass();
    // $preschoolers = array();
    foreach ($_POST as $key => $value) {
        $valueCount++;
        if($valueCount>2){
            if($valueCount%3==0) //is a preschooler name
                $preschooler->name = $value;
            else if($valueCount%3==1) //age
                $preschooler->age = $value;
            else if($valueCount%3==2){ //gender
                $preschooler->gender = $value;
                insertPreschooler($conn, $preschooler, $check);
                $preID = getPreID($conn, $preschooler);
                insertGroupAssignment($conn, $groupID, $preID, $check);
            }
        }
    }
    $conn->close();
        //if($check == true)
            header('Location: educatorTests.php#groups');
    
}
else{
    echo "Error: " . $sql . "<br>" . $conn->error;
	$check = false;
}	
//}
//insert preschooler into preschooler table
function insertPreschooler($conn, $preschooler, $check){
    $sql = "INSERT INTO PRESCHOOLER (name, age, gender) VALUES ('".$preschooler->name."', '".$preschooler->age."', '".$preschooler->gender."')";
    if ($conn->query($sql) === TRUE){ 
        echo "New record created successfully";
		$check = true;
	}	
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
		$check = false;
	}
}
//get preschooler ID of the preschooler just inserted into database
function getPreID($conn, $preschooler){
    $sql = "SELECT preID FROM PRESCHOOLER WHERE name = '" .$preschooler->name. "' AND age = '" .$preschooler->age. "' AND gender = '" .$preschooler->gender. "' limit 1";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['preID'];
}
//insert preschooler to group assignment into groupAssignment table
function insertGroupAssignment($conn, $groupID, $preID, $check){
    //$sql = "INSERT INTO GROUPASSIGNMENT (groupID, preID, userID) VALUES ('".$groupID."', '".$preID."', '".$userID."')";
	$sql = "INSERT INTO GROUPASSIGNMENT (groupID, preID) VALUES ('".$groupID."', '".$preID."')";
    if ($conn->query($sql) === TRUE){
        echo "New record created successfully";
		$check = true;
	}
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
		$check = false;
	}
}
?>