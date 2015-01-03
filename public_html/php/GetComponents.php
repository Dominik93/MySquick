<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $areaID=filter_input(INPUT_POST, 'areaID', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->checkEdit($id, "Templates")){
        $mysql_get_area=mysqli_fetch_array(mysqli_query($connector->res, "SELECT * FROM Predefined_Areas WHERE ID='".$areaID."'"));
        $mysql_get_all_components=mysqli_query($connector->res, "SELECT * FROM Components");
        echo "<select onchange='editArea(".$areaID.")' name='choose_component_in_area' id='choose_component_in_area".$areaID."'>";
        while($record=mysqli_fetch_array($mysql_get_all_components)){
            if($mysql_get_area["ID_Component"]==$record["ID"]) echo "<option value=".$record["ID"]." selected>".$record["Name"]."</option>"; 
            else echo "<option value=".$record["ID"].">".$record["Name"]."</option>"; 
        }
        echo "</select>";
    }
?>