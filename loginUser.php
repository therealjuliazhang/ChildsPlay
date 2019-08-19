<?php
    session_start();
    include 'db_connection.php';
    $conn = OpenCon();
    //Get inputs
    if(isset($_POST["username"]))
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
    if(isset($_POST["password"]))    
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
    //Get user
    $password = md5($password);
    $query = "SELECT * FROM USERS WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($conn, $query);
  	if (mysqli_num_rows($results) == 1) {
      //get userID
      $sql = "SELECT userID FROM USERS WHERE username = '".$username."'";
      $result = mysqli_query($conn, $query);
      $userID = mysqli_fetch_assoc($result)['userID'];
  	  $_SESSION['userID'] = $userID;
  	  header('location: educatorTests.php');
  	}else {
        header('location: login.php?msg=failed');
  	}
?>