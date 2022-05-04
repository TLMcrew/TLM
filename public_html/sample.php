<?php
    $sql = "SELECT * FROM users ";
        //connect to db
        $link = mysqli_connect($DB_SERVER,$DB_USER,$DB_PASSWORD,$DB_NAME);
        if($link == false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        //run the query
        $result = $link->query($sql);
        if($result == false){
            echo "query failed";
        }
        $data = mysqli_fetch_assoc($result);
        echo $data;
?>