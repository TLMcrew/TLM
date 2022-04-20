<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require ("../systemData.php");

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, username, password FROM users WHERE username = '".$username."' AND password = '".$password."'";

        $link = mysqli_connect($DB_SERVER,$DB_USER,$DB_PASSWORD,$DB_NAME);
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $result = $link->query($sql);
        if($result === false){
            echo "query failed";
        }
        mysqli_close($link);
        
    }
}
?>