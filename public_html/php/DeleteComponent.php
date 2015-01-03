<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    
    if($connector->delComponent($id)) echo "<script>alert('Usunięto')</script>";
    else echo "<script>alert('Nie można usunąć tego użytkownika')</script>";
?>