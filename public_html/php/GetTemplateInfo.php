<?php
    include('mysqlConnector.php');

    $query = "SELECT * FROM Templates WHERE At_Use='1'";
    $mysqli_get_template = mysqli_fetch_array(mysqli_query($connector->res, $query));
    
    $query = "SELECT Components.Name AS C_Name, Component_File, Parameters,"
            . "Predefined_Areas.Name AS A_Name "
            . "FROM Predefined_Areas JOIN Components ON Predefined_Areas.ID_Component=Components.ID"
            . "AND ID_Template='".$mysqli_get_template['ID']."' ;";
    $mysqli_get_components = mysqli_query($connector->res, $query);
    echo "<script>";
    echo '$("#container").load("'.$mysqli_get_template["Path"].'index.php");';
    while($record = mysqli_fetch_array($mysqli_get_components)){
        $param_arr=explode(";", $record['Parameters']);
        echo '$("#'.$record['A_Name'].'").load("./php/'.$record['Component_File'].'", {'
                . 'params: '.$param_arr
                . '});';
    }
    echo "</script>";
?>