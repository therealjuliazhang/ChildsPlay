<!--=============================================================
Title:Register Account; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
==============================================================-->
<?php
session_start();
include 'db_connection.php';
$conn = OpenCon();
//Get inputs
if(isset($_POST["fullname"]))
    $fullName = mysqli_real_escape_string($conn, $_POST["fullname"]);
if(isset($_POST["accountType"]))    
    $accountType = mysqli_real_escape_string($conn, $_POST["accountType"]);
if($accountType == "admin")
    $accountType = 1;
else
    $accountType = 0;
if(isset($_POST["location"]))
    $locations = $_POST["location"];
//$location = mysqli_real_escape_string($conn, $_POST["location"]);
if(isset($_POST["username"]))
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
if(isset($_POST["email"]))
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
if(isset($_POST["password1"]))
    $password = mysqli_real_escape_string($conn, $_POST["password1"]);
//insert user into database
$password = md5($password);//encrypt the password before saving in the database
$query = "INSERT INTO USERS (username, password, email, accountType, fullName, accepted) VALUES('$username', '$password', '$email', '$accountType', '$fullName', 0)";
if ($conn->query($query) === TRUE){
	echo "New record created successfully";
	$_SESSION["uEmail"] = $email;
	include 'sendEmail.php';
}
else 
    echo "Error: " . $query . "<br>" . $conn->error;
//get user ID and set it to session 
$query = "SELECT userID FROM USERS WHERE username = '".$username."'";
$result = mysqli_query($conn, $query);
$userID = mysqli_fetch_array($result)['userID'];
//if educator, enter location assignments
if($accountType == 0){
    foreach ($locations as $location){
        $query = "INSERT INTO LOCATIONASSIGNMENT (locationID, userID) VALUES('$location', '$userID')";
        if ($conn->query($query) === TRUE)
            echo "New record created successfully";
        else 
            echo "Error: " . $query . "<br>" . $conn->error;
    }
}
$_SESSION['userID'] = $userID;
header('location: thankyouForRegister.html');