<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'params', FILTER_SANITIZE_MAGIC_QUOTES);
    
    $query = "SELECT * FROM inGallery WHERE ID_Gallery='".$id."';";
    $mysql_get_photos_id = mysqli_query($connector->res, $query);
    while($record=mysqli_fetch_array($mysql_get_photos_id)){
        $mysql_get_photos = mysqli_query($connector->res, "SELECT * FROM Photos WHERE ID='".$record["ID_Photo"]."'");
        while($photo=mysqli_fetch_array($mysql_get_photos)){
            $path=$photo["Path"];
            echo "<img class='componentPhoto' id='g".$record["ID_Gallery"]."p".$photo['ID']."' src='".$path."'  alt='".$photo["Name"]."'/>";
        }
    }
?>