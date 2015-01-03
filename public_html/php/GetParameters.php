<?php
    include("mysqlConnector.php");
    
    $component=filter_input(INPUT_POST, 'type', FILTER_SANITIZE_MAGIC_QUOTES);
    if($component=='ArticleComponent.php'){
        $mysql_get_params=mysqli_query($connector->res, "SELECT * FROM Articles");
        echo "<select multiple class='multi' name='choose_parameters' id='choose_parameters'>";
        echo "<option value='all' selected>WYŚWIETLAJ WSZYSTKIE</option>";
    }
    else if($component=='ShowArticle.php'){
        $mysql_get_params=mysqli_query($connector->res, "SELECT * FROM Articles");
        echo "<select name='choose_parameters' id='choose_parameters'>";
    }
    else{
        $mysql_get_params=mysqli_query($connector->res, "SELECT * FROM Galleries");
        echo "<select name='choose_parameters' id='choose_parameters'>";
    }
    while($record = mysqli_fetch_array($mysql_get_params)){
        echo "<option value=".$record["ID"].">".$record["Title"]."</option>";
    }
    echo "</select>";
?>