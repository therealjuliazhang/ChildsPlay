<?php
session_start();
include 'db_connection.php';
$conn = OpenCon();
//Get inputs
if(isset($_POST["fullName"]))
    $fullName = mysqli_real_escape_string($conn, $_POST["fullName"]);
if(isset($_POST["accountType"]))    
    $accountType = mysqli_real_escape_string($conn, $_POST["accountType"]);
if(isset($_POST["location"]))
    $location = mysqli_real_escape_string($conn, $_POST["location"]);
if(isset($_POST["username"]))
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
if(isset($_POST["email"]))
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
if(isset($_POST["password1"]))
    $password = mysqli_real_escape_string($conn, $_POST["password1"]);
//insert into database
$password = md5($password);//encrypt the password before saving in the database
$query = "INSERT INTO USERS (username, password, email, accountType, fullName) VALUES('$username', '$password', '$email', '$accountType', '$fullName')";
mysqli_query($conn, $query);
$_SESSION['username'] = $username;
$_SESSION['success'] = "You are now logged in";
header('location: educatorTests.php');