<!DOCTYPE html>
<html>

<head>
    <title> Total Life manager </title>
</head>

<body>
    <h1>
        placeholder php
    </h1>
    <?php
    require ("../systemData.php");
    
    $connection = mysql_connect($DB_SERVER,$DB_PASSWORD,$DB_USER,$DB_NAME);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT firstname FROM users";
    $result = $connection->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            echo "firstname: " . $row["firstname"];
        }
    }
    else {
        echo "no data";
    }
    $conn->close();
    
    ?>

</body>

</html>