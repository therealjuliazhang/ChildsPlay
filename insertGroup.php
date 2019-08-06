<?php 
include 'db_connection.php';
$conn = OpenCon();
//This should be received from another page  
$userID = 2;
//used to determine what information $value holds
$valueCount = 0;
if(isset($_POST["groupName"]))
    $groupName = $_POST["groupName"];
if(isset($_POST["locationSelect"]))
    $location = $_POST["locationSelect"];
foreach ($_POST as $key => $value) {
    $valueCount++;
    if($valueCount>2){
        $preschoolerName;
        $age;
        $gender;
        //echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        if($valueCount%3==0) //is a preschooler name
            $preschoolerName = $value;
        else if($valueCount%3==1) //age
            $age = $value;
        else if($valueCount%3==2){ //gender
            $gender = $value;
            //insert group into grouptest table
            $sql = "INSERT INTO GROUPTEST (name, locationID)VALUES ('".$groupName."', '".$location."')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            //get groupID of new inserted group
            $sql = "SELECT groupID FROM GROUPTEST WHERE name = '" . $groupName. "' limit 1";
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);
            $groupID = $row['groupID'];
            
            //insert preschoolers into preschooler table
            $sql = "INSERT INTO PRESCHOOLER (name, age, gender, groupID) 
            VALUES ('".$preschoolerName."', '".$age."', '".$gender."', '".$groupID."')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            //insert preschooler to group assignment into groupAssignment table
            // $sql = "INSERT INTO GROUPTEST (name, locationID)VALUES ('".$groupName."', '".$location."')";
            // if ($conn->query($sql) === TRUE) {
            //     echo "New record created successfully";
            // } else {
            //     echo "Error: " . $sql . "<br>" . $conn->error;
            // }
        }   
    }
}
$conn->close();
?>