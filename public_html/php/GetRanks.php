<?php
    include("mysqlConnector.php");
    
    $mysql_get_users=mysqli_query($connector->res, "SELECT * FROM Ranks");
    echo "<select name='rank' id='rank_selector'>";
    while($record = mysqli_fetch_array($mysql_get_users)){
        echo "<option value=".$record["ID"].">".$record["Name"]."</option>";
    }
    echo "</select>";
?>