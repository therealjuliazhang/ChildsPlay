<!--
Title:Add Location; 
Author:Andre Knell (5741622);
-->
<?php 
include 'db_connection.php';
$conn = OpenCon();
//insert new rows into database
if(isset($_POST["rowNum"])){
    //array holding all new locations to be added to database
    $newLocationList = $_POST["rowNum"];
    //loop to add each new location to database
    for ($i = 0; $i < count($newLocationList); $i++)
    {
        $sql = "INSERT INTO LOCATION (name) VALUES ('" .$newLocationList[$i]."')";
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
    for ($i = 0; $i < count($locationArray); $i++)
    {
        //variable that holds value for location ID
        $locationID = $i + 1;
        //inserting values
        $sql = "UPDATE LOCATION SET name = '" .$locationArray[$i]."' WHERE locationID = " .$locationID;
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
            //refresh page 
            header("Location: adminProfile.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }