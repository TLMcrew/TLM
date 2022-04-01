<?php
require ("../systemData.php");
    
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> Total Life manager </title>
</head>

<body>
    <h1>
        welcome 
    </h1>
    <h2 class ="helloClass">
        Hi, <b><?php echo htmlspecialchars($_SESSION["username"]);
        ?></b>. 

    </h2>
    <p>
        <a href = "logout.php" class="btn btn-danger m1-3">Sign out. </a>
    </p>
</body>

</html>