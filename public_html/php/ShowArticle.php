<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'params', FILTER_SANITIZE_MAGIC_QUOTES);
    $query = "SELECT * FROM Articles WHERE ID='".$id."';";
    $mysql_get_article = mysqli_fetch_array(mysqli_query($connector->res, $query));
    echo "<div class='componentArticle'>"
        . "<div class='componentArticle_title'  id='atitle".$mysql_get_article["ID"]."'>"
        . $mysql_get_article["Title"]   
        . "</div>"
        . "<div class='componentArticle_text' id='atxt".$mysql_get_article["ID"]."'>"
        . $mysql_get_article["Text"]
        . "</div>"
    . "</div>";
?>