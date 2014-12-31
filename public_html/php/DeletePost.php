<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->delPost($id)) echo "<script>alert('Usunięto')</script>";
    else echo "<script>alert('Nie można usunąć tego artykułu')</script>";
?>