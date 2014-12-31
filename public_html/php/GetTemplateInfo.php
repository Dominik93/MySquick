<?php
    include('mysqlConnector.php');

    $query = "SELECT * FROM Templates WHERE At_Use='1'";
    $mysqli_get_template = mysqli_fetch_array(mysqli_query($connector->res, $query));
    
    $query = "SELECT * FROM Predefined_Areas JOIN Components ON Predefined_Areas.ID_Component=Components.ID;";
    $mysqli_get_components = mysqli_fetch_array(mysqli_query($connector->res, $query));
    echo "<script>";
    echo '$("#container").load("'.$mysqli_get_template["Path"].'index.php");';
    if(1){
        echo "alert('a')";
    }
    echo "</script>";
?>