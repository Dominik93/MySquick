<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->delGallery($id)) echo "<script>alert('Usunięto')</script>";
    else echo "<script>alert('Nie można usunąć tej galerii')</script>";
?>