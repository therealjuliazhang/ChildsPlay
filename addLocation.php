<!--============================
Title:Add Location; 
Author:Andre Knell (5741622);
=============================-->
<?php
include 'db_connection.php';
$conn = OpenCon();
include "adminAccess.php";

//insert new rows into database
if (isset($_POST["locRow"])) {
    //array holding all new locations to be added to database
    $newLocationList = $_POST["locRow"];
    //get current locations
    $sql = "SELECT name FROM LOCATION";
    $result = $conn->query($sql);
    $currentLocations = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $currentLocations[] = $row;
    }
    //loop to add each new location to database
    for ($i = count($currentLocations); $i < count($newLocationList); $i++) {
        $sql = "INSERT INTO LOCATION (name) VALUES ('" . $newLocationList[$i] . "')";
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
//updating all rows into database(for when user edits existing location)
//hold all loaded locations
$locationArray = $_POST["locRow"];
//update each location
for ($i = 0; $i < count($locationArray); $i++) {
    //variable that holds value for location ID
    $locationID = $i + 1;
    //inserting values
    $sql = "UPDATE LOCATION SET name = '" . $locationArray[$i] . "' WHERE locationID = " . $locationID;
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        //refresh page 
        header("Location: aProfile.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
