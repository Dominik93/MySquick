<?php
    include("mysqlConnector.php");
    
    $title=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_MAGIC_QUOTES);
    $text=filter_input(INPUT_POST, 'text', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->addTask($title, $text)) echo "<script>alert('Udało się dodać zadanie')</script>";
    else echo "<script>alert('Nie udało się dodać zadania')</script>";
?>