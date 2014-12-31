<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    $login=filter_input(INPUT_POST, 'login', FILTER_SANITIZE_MAGIC_QUOTES);
    $display=filter_input(INPUT_POST, 'display', FILTER_SANITIZE_MAGIC_QUOTES);
    $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_MAGIC_QUOTES);
    $rank=filter_input(INPUT_POST, 'rank', FILTER_SANITIZE_MAGIC_QUOTES);
    
    if($connector->editUser($id, $login, $display, $email, $rank)) echo "<script> alert('Zmieniono dane użytkownika') </script>";
    else echo "<script>alert('Nie można zmienić danych użytkownika')</script>";
?>