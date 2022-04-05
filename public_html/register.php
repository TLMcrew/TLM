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
    <link rel="stylesheet" href="~logan/styles/site.css" />
  </head>

  <body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
