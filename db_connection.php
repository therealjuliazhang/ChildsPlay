<?php
/*
=======================================
Title: Database connection
Author: Phuong Linh Bui (5624095)
=======================================
 */
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $db = "test";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error); 
    return $conn;
}
function CloseCon($conn)
{
    $conn -> close();
}
?>