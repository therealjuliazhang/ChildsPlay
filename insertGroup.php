<?php 
/*
========================================================================
Title:Insert Group; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
========================================================================
*/
//if(isset($_POST["submit"])){
	$check = false;
	
include 'db_connection.php';
$conn = OpenCon();
include "educatorAccess.php";
//used to determine what information $value holds
$valueCount = 0;
//get groupname and location
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
//insert group into grouptest table
$sql = $conn->prepare("INSERT INTO GROUPTEST (name, locationID, userID) VALUES (?, ?, ?)");
$sql->bind_param("sii", $groupName, $location, $userID);
if ($sql->execute()){ 
	echo "New record created successfully";
    $check = true;
    //get groupID of inserted group
    $stmt = $conn->prepare("SELECT groupID FROM GROUPTEST WHERE name = ? limit 1"); //groupname is unique
    $stmt->bind_param("s", $groupName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $groupID;
    $groupID = $row['groupID'];
    $stmt->close();
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
    $sql->close();
    CloseCon($conn);
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
    $sql = $conn->prepare("INSERT INTO PRESCHOOLER (name, age, gender) VALUES (?, ?, ?)");
    $sql->bind_param("sis", $preschooler->name, $preschooler->age, $preschooler->gender);
    if ($sql->execute()){ 
        echo "New record created successfully";
		$check = true;
	}	
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
		$check = false;
    }
    $sql->close();
}
//get preschooler ID of the preschooler just inserted into database
function getPreID($conn, $preschooler){
    $sql = $conn->prepare("SELECT preID FROM PRESCHOOLER WHERE name = ? AND age = ? AND gender = ? limit 1");
    $sql->bind_param("sis", $preschooler->name, $preschooler->age, $preschooler->gender);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $sql->close();
    return $row['preID'];
}
//insert preschooler to group assignment into groupAssignment table
function insertGroupAssignment($conn, $groupID, $preID, $check){
    $sql = $conn->prepare("INSERT INTO GROUPASSIGNMENT (groupID, preID) VALUES (?, ?)");
    $sql->bind_param("ii", $groupID, $preID);
    if ($sql->execute()){
        echo "New record created successfully";
		$check = true;
	}
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
		$check = false;
    }
    $sql->close();
}
?>