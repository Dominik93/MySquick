<?php
    include('mysqlConnector.php');

    $query = "SELECT * FROM Templates WHERE At_Use='1'";
    $mysqli_get_template = mysqli_fetch_array(mysqli_query($connector->res, $query));
    $path=preg_replace('/\s+/', '_', $mysqli_get_template["Path"]);
    $path=substr($path,strrpos($path,"/"),strlen($path));
    $path="./templates".str_replace("_", "%20", $path);
    echo "<script>";
    echo '$("#container").load("'.$path.'/index.php", { path: "'.$path.'" } ,function(){';
    echo '$("#footer").load("./php/GetComponentsInfo.php", {'
            . 'template: '.$mysqli_get_template['ID']
            . '});'
       . '});';
    echo "</script>";
?>