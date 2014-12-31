<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'photoID', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->delPhoto($id));
    else echo "<script>alert('Nie można usunąć tego artykułu')</script>";
?>