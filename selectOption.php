<!--
Title:Select Option; 
Author:Phuong Linh Bui (5624095); 
-->
<?php
/*session_start();
if(isset($_SESSION["userID"]))
    $userID = $_SESSION["userID"];
else
    header("Location: login.php");*/
include "adminAccess.php";
$selectedOption = $_POST['option_value'];
echo $selectedOption; 
?>