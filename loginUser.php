<?php
/*
=================================================================
Title:Login User; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
=================================================================
*/
    session_start();
    include 'db_connection.php';
    $conn = OpenCon();

    //Get inputs
    if(isset($_POST["username"]))
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
    if(isset($_POST["password"]))    
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
    //Get user from database if exists
    $password = md5($password);
    $query = $conn->prepare("SELECT userID, accountType, accepted FROM USERS WHERE username=? AND password=?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $results = $query->get_result();
    // $query = "SELECT userID, accountType, accepted FROM USERS WHERE username='$username' AND password='$password'";
  	// $results = mysqli_query($conn, $query);
  	if ($results->num_rows == 1) {
            $user = mysqli_fetch_assoc($results);
            //login fail if user not accepted by admin yet
            if($user['accepted']== 0)
                header('location: login.php?msg=pending');
            else if ($user['accepted'] == 1){
				//set user ID to session
				$userID = $user['userID'];
				$_SESSION['userID'] = $userID;
				//check if admin or educator and redirect to correct page
				if($user['accountType']== 1){
                    $_SESSION['accountType'] = 1;
                    header('location: viewExistingTests.php');
                }
				else{
                    $_SESSION['accountType'] = 0;
                    header('location: educatorTests.php');
                }
            }
            else if($user['accepted'] == -1)
                header('location: login.php?msg=declined');
        $query->close();
  	}else {
        header('location: login.php?msg=failed');
  	}
?>