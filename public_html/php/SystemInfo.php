<?php
    include("config.php");
    
    $con1=mysqli_connect(
                    $db_address,
                    $db_login,
                    $db_pass,
                    $db_name
        );
    mysqli_set_charset($con1, 'utf8');
    if($_COOKIE['squick_cmsSession']){
        $mysql_session_data=mysqli_query($con1, "SELECT * "
                . "FROM Sessions JOIN Users ON Sessions.ID_User=Users.ID");
        echo "<div id='active_users'><p>Zalogowani w ciągu ostatniej godziny: </p>";
        while($record=mysqli_fetch_array($mysql_session_data)){
            echo "<span>".$record['Display_Name']."</span>";
        }
        echo "</div>";
    }
?>