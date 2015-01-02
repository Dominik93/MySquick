<?php
    include("mysqlConnector.php");
    
    $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_MAGIC_QUOTES);
    $params=filter_input(INPUT_POST, 'params', FILTER_SANITIZE_MAGIC_QUOTES);
    echo '<span class="componentArticlesLink" id="'.$name.'">'.$name.'</span>';
    echo '<script> $("#'.$name.'").parent().click(function(){
            $("#content").load("./php/ArticleComponentFillContent.php", {
                params: "'.$params.'"
            });
        });</script>'
?>