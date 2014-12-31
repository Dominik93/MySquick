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
        $mysql_get_session=mysqli_query($con1, "DELETE FROM Sessions WHERE Sessions.Session='".$session_number."'");
        ?>
        <script>$.removeCookie('squick_cmsSession');
        $('#container').load('./login.html');</script>
        <?php
    }
?>
