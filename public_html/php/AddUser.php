<?php
    include("mysqlConnector.php");
    
    $login=filter_input(INPUT_POST, 'login', FILTER_SANITIZE_MAGIC_QUOTES);
    $password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
    $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_MAGIC_QUOTES);
    $rank=filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_MAGIC_QUOTES);
    
    if($connector->addUser($login, $password, $email, $rank)) echo "<script>alert('Dodano')</script>";
    else echo "<script>alert('Nie dodano')</script>";
?>