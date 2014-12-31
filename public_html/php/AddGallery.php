<?php
    include("mysqlConnector.php");
    
    $title=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->addGallery($title)) echo "<script>alert('Udało się dodać galerię')</script>";
    else echo "<script>alert('Nie udało się dodać galerii')</script>";
?>