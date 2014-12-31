<?php
    include("mysqlConnector.php");
    
    $session_number=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $rankID=filter_input(INPUT_POST, 'rankID', FILTER_SANITIZE_MAGIC_QUOTES);
    $privilageName=filter_input(INPUT_POST, 'privilageName', FILTER_SANITIZE_MAGIC_QUOTES);
    $right=filter_input(INPUT_POST, 'right', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->editPrivilage($rankID, $privilageName, $right)) echo "";
    else echo "<script>alert('Nie zmieniono praw')</script>";
?>