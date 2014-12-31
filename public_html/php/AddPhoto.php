<?php
    include("mysqlConnector.php");
    
    $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
    $author=filter_input(INPUT_POST, 'author', FILTER_SANITIZE_MAGIC_QUOTES);
    $connector->addPhoto($name, $author);
?>