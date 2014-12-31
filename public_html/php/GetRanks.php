<?php
    include("config.php");
    
    $con1=mysqli_connect(
                    $db_address,
                    $db_login,
                    $db_pass,
                    $db_name
        );
    mysqli_set_charset($con1, 'utf8');
    $session_number=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    if($_COOKIE['squick_cmsSession']){
        $mysql_get_users=mysqli_query($con1, "SELECT * FROM Ranks");
        echo "<select name='rank' id='rank_selector'>";
        while($record = mysqli_fetch_array($mysql_get_users)){
            echo "<option value=".$record["ID"].">".$record["Name"]."</option>";
        }
        echo "</select>";
    }
?>