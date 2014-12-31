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
        $mysql_get_session=mysqli_fetch_array(mysqli_query($con1, "SELECT *"
                . "FROM Sessions JOIN Users ON Sessions.ID_User=Users.ID "
                . "AND Sessions.Session='".$session_number."'"
        ));
        if($mysql_get_session)echo $mysql_get_session["Display_Name"];
        else{
            ?>
            <script>$('#container').load('./login.html');
            $.removeCookie('squick_cmsSession');</script>
            <?php    
        }
    }
    else{ 
        ?>
        <script>$('#container').load('./login.html');
        $.removeCookie('squick_cmsSession');</script>
        <?php
    }
    mysqli_close($con1);
?>