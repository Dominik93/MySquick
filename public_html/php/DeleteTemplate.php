<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->delTemplate($id));
    else echo "<script>alert('Nie można usunąć tego szablonu')</script>";
?>