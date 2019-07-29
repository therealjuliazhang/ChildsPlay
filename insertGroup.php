<?php 
include 'db_connection.php';
$conn = OpenCon();
//fetch locations
/*$sql = "SELECT * FROM LOCATION";
$result = $conn->query($sql);
$locations = array();
while($row = mysqli_fetch_assoc($result))
   $locations[] = $row;*/

//This should be gotten from some php file 
$userID = 2;

$valueCount = 0;
$groupName = $_POST["groupName"];
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
            //insert preschooler into database
            $sql = "INSERT INTO GROUPTEST VALUES (".$groupName.", ".$location.")";
        }   
    }
}
echo $valueCount;
?>