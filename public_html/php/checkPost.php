<?php
    include("mysqlConnector.php");
    
    $title=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->postAmount($title)>0) echo "<script>alert('Istnieje artykuł o takim tytule')</script>";
    else{
        echo '<script>'
        . '$("#editor_layer").css("display", "block");'
        . '$("#editor_layer").load("./editor.html", function(){'
                . '$("#form_title_in_editor").val("'.$title.'");'
                . '});'
        . '</script>';
    }
?>
        