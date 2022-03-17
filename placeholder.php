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
    ?>
    <?php
    echo "<ul>\n";
    for($i = 0; $i <= 10; $i++){
        echo "<li>$i</li>\n";
    }
    echo "</ul>\n";
    ?>

</body>

</html>