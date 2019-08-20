<?php 
include 'db_connection.php';
$conn = OpenCon();
//get userID
if(isset($_GET["userID"]))
    $userID = (int)str_replace('"', '', $_GET["userID"]);
//get groupID
if(isset($_GET["groupID"]))
    $groupID = (int)str_replace('"', '', $_GET["groupID"]);
//get input groupname and location
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
//update groupName
$sql = "UPDATE GROUPTEST SET name = '" .$groupName. "' WHERE groupID = " .$groupID;
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
//update location if it has been changed ($location will be id instead of name)
if(is_numeric($location)){
    $sql = "UPDATE GROUPTEST SET locationID = " .$location. " WHERE groupID = " .$groupID;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
//update preschoolers
$preschooler = new stdClass();
$preschoolers = array();
$valueCount = 0;
deleteGroupAssignments($conn, $groupID);
$existingPreschooler = false;
foreach ($_POST as $key => $value) {
    $valueCount++;
    if($key != "groupName" && $key != "locationSelect"){
        if($valueCount%3==0) //is a preschooler name
            $preschooler->name = $value;
        else if($valueCount%3==1) //age
            $preschooler->age = $value;
        else if($valueCount%3==2){ //gender
            $preschooler->gender = $value;
            $preschooler->id = getID($conn, $preschooler);
            if($existingPreschooler)
                updatePreschooler($conn, $preschooler);
			insertGroupAssignment($conn, $groupID, $preschooler->id, $userID);
        }
    }
}
$conn->close();
header('Location: educatorTests.php#groups');
//insert preschooler if doesnt exist in database and get preschooler ID
function getID($conn, $preschooler){
    //check if preschooler exists
    $sql = "SELECT preID FROM PRESCHOOLER WHERE name = '" .$preschooler->name. "' AND age = '" .$preschooler->age. "' AND gender = '" .$preschooler->gender. "' limit 1";
    $result = $conn->query($sql);
    //if preschooler doesnt exist, insert into database, then get new preID
    if (mysqli_num_rows($result) == 0) { 
        $sql = "INSERT INTO PRESCHOOLER (name, age, gender) VALUES ('".$preschooler->name."', ".$preschooler->age.", '".$preschooler->gender."')";
        if ($conn->query($sql) === TRUE) 
            echo "New preschooler added successfully";
        else 
            echo "Error: " . $sql . "<br>" . $conn->error;
        $sql = "SELECT preID FROM PRESCHOOLER WHERE name = '" .$preschooler->name. "' AND age = '" .$preschooler->age. "' AND gender = '" .$preschooler->gender. "' limit 1";
        $result = $conn->query($sql);
        $row = mysqli_fetch_array($result);
        return $row['preID'];
    //if preschooler exists, return preID
    } else { 
        $existingPreschooler = true;
        $row = mysqli_fetch_array($result);
        return $row['preID'];
    }  
}   
//update preschooler into preschooler table
function updatePreschooler($conn, $preschooler){
    $sql = "UPDATE PRESCHOOLER SET name = '".$preschooler->name."', age = '".$preschooler->age."', gender = '".$preschooler->gender."' WHERE preID = " .$preschooler->id;
    if ($conn->query($sql) === TRUE) 
        echo "Record updated successfully";
    else 
        echo "Error: " . $sql . "<br>" . $conn->error;
}
//delete current group assignments
function deleteGroupAssignments($conn, $groupID){
    $sql = "DELETE FROM GROUPASSIGNMENT WHERE groupID = ".$groupID;
    if ($conn->query($sql) === TRUE)
        echo "Records deleted successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
}
//update preschooler to group assignment into groupAssignment table
function insertGroupAssignment($conn, $groupID, $preID, $userID){
    //insert new group assignment
    $sql = "INSERT INTO GROUPASSIGNMENT (groupID, preID, userID) VALUES (".$groupID.", ".$preID.", ".$userID.")";
    if ($conn->query($sql) === TRUE)
        echo "Record inserted successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
}
?>