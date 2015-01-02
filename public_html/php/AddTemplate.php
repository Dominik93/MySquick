<?php
    include("mysqlConnector.php");
    
    $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
    echo $connector->addTemplate($name);
?>