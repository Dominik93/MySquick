<?php
    include("mysqlConnector.php");
    
    $params=filter_input(INPUT_POST, 'params', FILTER_SANITIZE_MAGIC_QUOTES);
    $params_table=explode(";", $params);
    
    echo "<div id='PlaceForArticle'>"
            . "<script>$('#PlaceForArticle').load('./php/ShowArticle.php', {"
                . 'params: "'.$params_table[0].'"'
                . "});</script>"
        . "</div>";
    echo "<div id='PlaceForLinks'>";
    if(count($params_table)>1){
    for($i=0; $i<count($params_table); $i++){
        echo "<span class='navLinkToArticle' id='".$params_table[$i]."'> ".($i+1)." </span>";
    }
    echo "</div>";
    }
?>
<script>
    $(".navLinkToArticle").click(function(event){
       var id= event.target.id;
       $('#PlaceForArticle').load('./php/ShowArticle.php', {
           params: id
       })
    });
</script>