<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $templateID=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
    $component=filter_input(INPUT_POST, 'component', FILTER_SANITIZE_MAGIC_QUOTES);
    if(is_array($_POST['parameters'])){
        $parameters=implode(";",$_POST['parameters']);
    }
    else{
        $parameters=filter_input(INPUT_POST, 'parameters', FILTER_SANITIZE_MAGIC_QUOTES);
    }
    
    if($connector->addComponent($templateID, $name, $component, $parameters)) echo "<script>alert('Dodano')</script>";
    else echo "<script>alert('Nie dodano')</script>";
?>