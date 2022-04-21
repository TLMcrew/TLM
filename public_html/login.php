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
        #$sql = "SELECT user_id, username, password FROM users WHERE username = '".$username."' AND password = '".$password."'";
        $sql = "SELECT COUNT(*) AS TOTAL FROM users WHERE username = '" . $username . "' AND 
        password = '" . $password . "'";
        $link = mysqli_connect($DB_SERVER,$DB_USER,$DB_PASSWORD,$DB_NAME);
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $result = $link->query($sql);
        if($result === false){
            echo "query failed";
        }
        $data = mysqli_fetch_assoc($result);
        $count = $data['TOTAL'];
        if($count == 1){
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username; 
            header("Location: dashboard.html");
        } else{
            // Username doesn't exist, display a generic error message
            $login_err = "Invalid username or password.";
        }
        mysqli_close($link);
        
    }else
    echo "get absolutely smacked lad";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="site.css">
    
</head>
<body>
    <header>
      <nav class="navbar">
        <a href="../public_html/dashboard.html" class="navBrand">TLM</a>
        <ul class="navMenu">
          <li class="navItem">
            <a href="../public_html/dashboard.html" class="navLink"
              >Dashboard</a
            >
          </li>
          <li class="navItem">
            <a href="../public_html/graphs.html" class="navLink">Graphs</a>
          </li>
          <li class="navItem">
            <a href="../public_html/meals.html" class="navLink">Meals</a>
          </li>
          <li class="navItem">
            <a href="../public_html/calendar.html" class="navLink">Calendar</a>
          </li>
          <li class="navItem">
            <a href="../public_html/faq.html" class="navLink">FAQ</a>
          </li>
          <li class="navItem">
            <a href="../public_html/landing.html" class="navLink">Logout</a>
          </li>
        </ul>
        <div class="hamburger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </header>
    <script src="hamburger.js"></script>
    <div class="loginRegister">
      <div class="login">
        <h1>Login</h1>
        <form action="login.php" method="post">
          <div class="txt_field">
            <input type="text" required />
            <span></span>
            <label>Username</label>
          </div>
          <div class="txt_field">
            <input type="password" required />
            <span></span>
            <label>Password</label>
          </div>
          <div class="pass">Forgot Password?</div>
          <input type="submit" value="Login" />
          <!-- <div class="signup_link">Not a member? <a href="#">Signup</a></div> -->
        </form>
      </div>
    <div class="register">
        <h1>Register</h1>
        <form method="post">
          <div class = "username">
          <div class="txt_field">
            <input type="text" required />
            <span></span>
            <label>Username</label>
          </div>
          <div class="txt_field">
            <input type="text" required />
            <span></span>
            <label>Email</label>
          </div>
        </div>

        <div class = "password">
          <form method="post">
            <div class = "username">
            <div class="txt_field">
              <input type="password" name="password" required />
              <span></span>
              <label>Password</label>
            </div>
            <div class="txt_field">
              <input type="password" name="confirmPassword" required />
              <span></span>
              <label>Confirm Password</label>
            </div>
        </div>
          <input type="submit" value="Register" />
        </form>
      </div>
    </div>

</body>
</html>