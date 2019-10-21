<?php
    session_start();
    if(!isset($_SESSION['accountType']))
        header('Location: login.php');
    else{
        $accountType = $_SESSION['accountType'];
        if($accountType != 0){
            header('Location: login.php');
        }
        $userID = $_SESSION["userID"];
    }
?>
<?php
/*
    session_start();
    include 'db_connection.php';
    $conn = OpenCon();
    $educatorAccess = false;
    if(!isset($_SESSION['userID']))
        header('Location: login.php');
    else{
        $userID = $_SESSION['userID'];
        $sql = "SELECT * FROM USERS WHERE userID=$userID";
        $result = $conn->query($sql);
        $row=mysqli_fetch_assoc($result);
        $accountType = $row["accountType"];
        if($accountType == 0){
            $educatorAccess = true;
            $_SESSION["educatorAccess"] = $educatorAccess;
        }
    }
    if(!isset($_SESSION['educatorAccess']))
        if($_SESSION['educatorAccess'] == false)
            header('Location: login.php');
*/       
?>