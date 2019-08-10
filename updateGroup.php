<?php 
include 'db_connection.php';
$conn = OpenCon();
//get groupID
if(isset($_GET["groupID"]))
    $groupID = $_GET["groupID"];
//get input groupname and location
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
// get location ID

//update groupName
$sql = "UPDATE grouptest SET name = '" .$groupName. "' WHERE groupID = " .$groupID;
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
//update location name
$sql = "UPDATE name SET name = '" .$groupName. "' WHERE groupID = " .$groupID;
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// //This should be received from another page  
// $userID = 2;
// //used to determine what information $value holds
// $valueCount = 0;

// //insert group into grouptest table
// $sql = "INSERT INTO grouptest (name, locationID)VALUES ('".$groupName."', '".$location."')";
// if ($conn->query($sql) === TRUE) 
//     echo "New record created successfully";
// else
//     echo "Error: " . $sql . "<br>" . $conn->error;
// //get groupID of inserted group
// $sql = "SELECT groupID FROM grouptest WHERE name = '" . $groupName. "' limit 1";
// $result = $conn->query($sql);
// $row = mysqli_fetch_array($result);
// $groupID;
// $groupID = $row['groupID'];
// //get preschoolers data and insert into database
// $preschooler = new stdClass();
// // $preschoolers = array();
// foreach ($_POST as $key => $value) {
//     $valueCount++;
//     if($valueCount>2){
//         if($valueCount%3==0) //is a preschooler name
//             $preschooler->name = $value;
//         else if($valueCount%3==1) //age
//             $preschooler->age = $value;
//         else if($valueCount%3==2){ //gender
//             $preschooler->gender = $value;
//             insertPreschooler($conn, $preschooler, $groupID);
//             $preID = getPreID($conn, $preschooler);
//             insertGroupAssignment($conn, $groupID, $preID);
//         }
//     }
// }
// $conn->close();
// //insert preschooler into preschooler table
// function insertPreschooler($conn, $preschooler, $groupID){
//     $sql = "INSERT INTO preschooler (name, age, gender, groupID) VALUES ('".$preschooler->name."', '".$preschooler->age."', '".$preschooler->gender."', '".$groupID."')";
//     if ($conn->query($sql) === TRUE) 
//         echo "New record created successfully";
//     else 
//         echo "Error: " . $sql . "<br>" . $conn->error;
// }
// //get preschooler ID of the preschooler just inserted into database
// function getPreID($conn, $preschooler){
//     $sql = "SELECT preID FROM preschooler WHERE name = '" .$preschooler->name. "' AND age = '" .$preschooler->age. "' AND gender = '" .$preschooler->gender. "' limit 1";
//     $result = $conn->query($sql);
//     $row = mysqli_fetch_array($result);
//     return $row['preID'];
// }
// //insert preschooler to group assignment into groupAssignment table
// function insertGroupAssignment($conn, $groupID, $preID){
//     $sql = "INSERT INTO groupassignment (groupID, preID)VALUES ('".$groupID."', '".$preID."')";
//     if ($conn->query($sql) === TRUE)
//         echo "New record created successfully";
//     else
//         echo "Error: " . $sql . "<br>" . $conn->error;
// }
?>