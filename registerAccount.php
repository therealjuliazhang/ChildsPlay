<?php
session_start();
include 'db_connection.php';
$conn = OpenCon();
if(isset($_POST["accountType"]))
    $accountType = $_POST["accountType"];
if(isset($_POST["location"]))
    $location = $_POST["location"];
if(isset($_POST["username"]))
    $username = $_POST["username"];
if(isset($_POST["email"]))
    $email = $_POST["email"];
if(isset($_POST["password"]))
    $password = $_POST["password"];
