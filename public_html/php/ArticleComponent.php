<?php
    include("mysqlConnector.php");
    
    $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
    $params=filter_input(INPUT_POST, 'params', FILTER_SANITIZE_MAGIC_QUOTES);
    if($params=="all"){
        $params=[];
        $mysql_get_articles=mysqli_query($connector->res, "SELECT * FROM Articles");
        $i=0;
        while($record=mysqli_fetch_array($mysql_get_articles)){
            $params[$i]=$record["ID"];
            $i++;
        }
    }
    echo '<span class="componentArticlesLink" id="'.$name.'">'.$name.'</span>';
    echo '<script> $("#'.$name.'").parent().click(function(){
            $("#content").load("./php/ArticleComponentFillContent.php", {
                params: "';
    if(is_array($params)) echo implode(";",$params);
    else echo $params;
    echo '"
            });
        });</script>'
?>