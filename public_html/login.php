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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
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
    <script src="../js/hamburger.js"></script>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>