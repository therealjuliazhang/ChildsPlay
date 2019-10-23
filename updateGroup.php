<?php
/*
=======================================
Title:Update Group; 
Author:Alex Satoru Hanrahan (4836789);
=======================================
*/ 
include "educatorAccess.php";
include 'db_connection.php';
$conn = OpenCon();
//session_start();
//get userID
// if(isset($_SESSION["userID"]))
//     $userID = (int)str_replace('"', '', $_SESSION["userID"]);
/*
if(isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];
else
    header("Location: login.php");
*/
//get groupID
if(isset($_GET["groupID"]))
    $groupID = (int)str_replace('"', '', $_GET["groupID"]);
//get input groupname and location
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
//update groupName
$sql = $conn->prepare("UPDATE GROUPTEST SET name = ? WHERE groupID = ?");
$sql->bind_param("si", $groupName, $groupID);
if ($sql->execute())
    echo "Record updated successfully";
else
    echo "Error updating record: " . $conn->error;
$sql->close();
//update location if it has been changed ($location will be id instead of name)
if(is_numeric($location)){
    $query = $conn->prepare("UPDATE GROUPTEST SET locationID = ? WHERE groupID = ?");
    $query->bind_param("ii", $location, $groupID);
    if ($query->execute())
        echo "Record updated successfully";
    else
        echo "Error updating record: " . $conn->error;
    $query->close();
}
//update preschoolers
$preschooler = new stdClass();
$preschoolers = array();
$valueCount = 0;
deleteGroupAssignments($conn, $groupID);
foreach ($_POST as $key => $value) {
    $valueCount++;
    if($key != "groupName" && $key != "locationSelect"){
        if($valueCount%3==0) //is a preschooler name
            $preschooler->name = $value;
        else if($valueCount%3==1) //age
            $preschooler->age = $value;
        else if($valueCount%3==2){ //gender
            $preschooler->gender = $value;
            insertPreschooler($conn, $preschooler);
            $preschooler->id = getID($conn, $preschooler);
            insertGroupAssignment($conn, $groupID, $preschooler->id, $userID);
        }
    }
}
$conn->close();
header('Location: educatorTests.php#groups');
//insert preschooler if doesnt exist in database and get preschooler ID
function getID($conn, $preschooler){
    $sql = $conn->prepare("SELECT preID FROM PRESCHOOLER WHERE name = ? AND age = ? AND gender = ? limit 1");
    $sql->bind_param("sis", $preschooler->name, $preschooler->age, $preschooler->gender);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $sql->close();
    return $row['preID'];
}   
//delete current group assignments
function deleteGroupAssignments($conn, $groupID){
    $sql = $conn->prepare("DELETE FROM GROUPASSIGNMENT WHERE groupID = ?");
    $sql->bind_param("i", $groupID);
    //displaySqlError($conn, $sql);
    if ($sql->execute())
        echo "Records deleted successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $sql->close();
}
//update preschooler to group assignment into groupAssignment table
function insertGroupAssignment($conn, $groupID, $preID, $userID){
    //insert new group assignment
    $sql = $conn->prepare("INSERT INTO GROUPASSIGNMENT (groupID, preID) VALUES (?, ?)");
    $sql->bind_param("ii", $groupID, $preID);
	//$sql = "INSERT INTO GROUPASSIGNMENT (groupID, preID) VALUES (".$groupID.", ".$preID.")";
    if ($sql->execute())
        echo "Record inserted successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $sql->close();
}
//insert preschooler
function insertPreschooler($conn, $preschooler){
    $sql = $conn->prepare("INSERT INTO PRESCHOOLER (name, age, gender) VALUES (?, ?, ?)");
    $sql->bind_param("sis", $preschooler->name, $preschooler->age, $preschooler->gender);
    //$sql = "INSERT INTO PRESCHOOLER (name, age, gender) VALUES ('".$preschooler->name."', ".$preschooler->age.", '".$preschooler->gender."')";
    if ($sql->execute()) 
        echo "New preschooler added successfully";
    else 
        echo "Error: " . $sql . "<br>" . $conn->error;
    $sql->close();
}
function displaySqlError($conn, $query){
    $query = mysqli_query($conn, $query);
    if (! $query) exit(mysqli_error($conn));
    return $query;
}
?>