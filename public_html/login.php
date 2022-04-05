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
        $Uname_error = "Please enter a username in the form.";#works
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $pass_error = "Please enter a password in the form."; #works
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
  <body>
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
                <span class="invalid-feedback"><?php echo $Uname_error; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $pass_error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>