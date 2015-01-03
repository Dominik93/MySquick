<?php
    include("mysqlConnector.php");
    
    $areaID=filter_input(INPUT_POST, 'areaID', FILTER_SANITIZE_MAGIC_QUOTES);
    $componentID=filter_input(INPUT_POST, 'componentID', FILTER_SANITIZE_MAGIC_QUOTES);
    
    if($connector->AddComponentToArea($areaID, $componentID));
    else{
        $templateID=mysqli_fetch_array(mysqli_query("SELECT * FROM Predefined_Areas WHERE ID='".$areaID."'"));
        echo "<script>alert('Nie można dokonać tej zmiany'); $('#template_areas').load('./php/GetTemplateAreas.php',{ id: ".$templateID["ID_Template"]." });</script>";
    }
?>