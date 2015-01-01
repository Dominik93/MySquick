<?php
    include('mysqlConnector.php');

    $query = "SELECT * FROM Templates WHERE At_Use='1'";
    $mysqli_get_template = mysqli_fetch_array(mysqli_query($connector->res, $query));
    
    echo "<script>";
    echo '$("#container").load("'.$mysqli_get_template["Path"].'index.php", function(){';
    echo '$("#footer").load("./php/GetComponentsInfo.php", {'
            . 'template: '.$mysqli_get_template['ID']
            . '});'
       . '});';
    echo "</script>";
?>