<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    header("Location: welcome.php");
    exit;
}
require ("../systemData.php");
$username = "";
$password = "";
$Uname_error = $pass_error = $login_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $Uname_error = "Please enter a username in the form.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $pass_error = "Please enter a password in the form.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty($Uname_error) && empty($pass_error)){
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($connection, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_results($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_results($stmt,$id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: welcome.php");
                        } else{
                            $login_error = "Invalid User name or Password.";
                        }
                    }
                } else{
                    $login_error = "Invalid User name or Password.";
                }
            } else{
                echo "An error has been encountered, please try again.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="../styles/site.css" />
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
    <div class="loginRegister">
      <div class="login">
        <h1>Login</h1>
        <form method="post">
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