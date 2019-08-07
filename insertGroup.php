<?php 
include 'db_connection.php';
$conn = OpenCon();
//This should be received from another page  
$userID = 2;
//used to determine what information $value holds
$valueCount = 0;
//get groupname and location
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
//insert group into grouptest table
$sql = "INSERT INTO GROUPTEST (name, locationID)VALUES ('".$groupName."', '".$location."')";
if ($conn->query($sql) === TRUE) 
    echo "New record created successfully";
else
    echo "Error: " . $sql . "<br>" . $conn->error;
//get groupID of inserted group
$sql = "SELECT groupID FROM GROUPTEST WHERE name = '" . $groupName. "' limit 1";
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
            insertPreschooler($conn, $preschooler, $groupID);
            $preID = getPreID($conn, $preschooler);
            insertGroupAssignment($conn, $groupID, $preID);
        }
    }
}
$conn->close();
//insert preschooler into preschooler table
function insertPreschooler($conn, $preschooler, $groupID){
    $sql = "INSERT INTO PRESCHOOLER (name, age, gender, groupID) VALUES ('".$preschooler->name."', '".$preschooler->age."', '".$preschooler->gender."', '".$groupID."')";
    if ($conn->query($sql) === TRUE) 
        echo "New record created successfully";
    else 
        echo "Error: " . $sql . "<br>" . $conn->error;
}
//get preschooler ID of the preschooler just inserted into database
function getPreID($conn, $preschooler){
    $sql = "SELECT preID FROM PRESCHOOLER WHERE name = '" .$preschooler->name. "' AND age = '" .$preschooler->age. "' AND gender = '" .$preschooler->gender. "' limit 1";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['preID'];
}
//insert preschooler to group assignment into groupAssignment table
function insertGroupAssignment($conn, $groupID, $preID){
    $sql = "INSERT INTO GROUPASSIGNMENT (groupID, preID)VALUES ('".$groupID."', '".$preID."')";
    if ($conn->query($sql) === TRUE)
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
}
?>