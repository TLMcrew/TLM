<?php
require ("../systemData.php");

$username = "";
$confirm_username = "";
$password = "";
$confirm_password = "";
$Uname_error = $pass_error = $confirm_pass_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $Uname_error = "Please enter a username in the box.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/',trim($_POST["username"]))){
        $Uname_error = "User name can only have letters, numbers, and underscores.";
    }else{
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_results($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $Uname_error = "User name already exists in the system.";
                } else{
                    $Username = trim($_POST["username"]);
                }
            }else{
                echo "There was an error, try entering it again.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if(empty(trim($_POST["password"]))){
        $pass_error = "Please enter a password in the form.";
    }elseif(strlen(trim($_POST["password"])) < 8){
        $pass_error = "Password must be atleast 8 characters long.";
    }else{
        $Password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_pass_error = "Please enter the password again.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($pass_error) && ($password != $confirm_password)){
            $confirm_pass_error = "The passwords entered do not match.";
        }
    }
    if(empty($Uname_error) && empty($pass_error) && empty($confirm_pass_error)){
        $sql = "INSERT INTO users (username, password) VALUES (?,?)";

        if($stmt = mysqli_prepare($connection, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Something went wrong, please try again.";
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
