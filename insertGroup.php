<?php 
include 'db_connection.php';
$conn = OpenCon();
//fetch locations
$sql = "SELECT * FROM LOCATION";
$result = $conn->query($sql);
$locations = array();
while($row = mysqli_fetch_assoc($result))
   $locations[] = $row;

$count = 0;
foreach ($_POST as $key => $value) {
    $count++;
    echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
}
echo $count;
?>