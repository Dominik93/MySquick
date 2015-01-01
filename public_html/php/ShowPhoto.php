<?
    include("mysqlConnector.php");
    
    $parameters=filter_input(INPUT_POST, 'param', FILTER_SANITIZE_MAGIC_QUOTES);
    $param_table=explode(";", $parameters);
    $id=$param_table[0];
    
    $query = "SELECT * FROM inGallery WHERE ID_Gallery='".$id."';";
    $mysql_get_photos_id = mysqli_query($connector->res, $query);
    while($record=mysqli_fetch_array($mysql_get_photos_id)){
        $mysql_get_photos = mysqli_query("SELECT * FROM Photos WHERE ID='".$record["ID_Photo"]."'");
        while($photo=mysqli_fetch_array($mysql_get_photos)){
            echo "<img class='componentPhoto' id='g".$record["ID_Gallery"]."p".$photo['ID']."' src='".$photo['Path']."  alt='".$photo["Name"]."'/>";
        }
    }
?>