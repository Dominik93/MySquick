<?php
    include("mysqlConnector.php");
    
    $id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);

    $article=$connector->getPostByID($id);
    $title=$article["Title"];
    $text=  addslashes($article["Text"]);
    echo preg_replace('/[\r\n]+/', "", "<script>"
    . "$('#editor_layer').css('display', 'block');"
    . "$('#editor_layer').load('./editor.html', function(){"
            . "$('#form_title_in_editor').val('".$title."');"
            . "$('#form_title_in_editor').attr('readonly', true);"
            . "$('#editor').html('".$text."');"
            . "});"
    . "</script>");
?>