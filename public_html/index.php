<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <title> Total Life manager </title>
</head>

<body>
    <h1>
        placeholder php
    </h1>
    <?php
    require ("../systemData.php");
    
    $connection = mysqli_connect($DB_SERVER,$DB_USER,$DB_PASSWORD,$DB_NAME);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users;";
    $result = mysqli_query($connection, $sql);
    #$resultchecker = mysql_num_rows($result);
    $resultchecker = 1;

    if($resultchecker > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo $row['user_id'];
        }
    }

    
    else {
        echo "no data";
    }
    $connection->close();
    
    ?>

</body>

</html>