<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $templateID=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->checkEdit($id, "Templates")){
        echo "<div id='close' onclick='template_close()'>Zamknij</div>";
        echo "<div class='template_edition_column' id='components'>"
            . "<div id='add_component_form'>"
                . "<input type='text' id='component_name' name='component_name' placeholder='Nazwa komponentu'/>"
                . "<select id='choose_component' onchange='changeComponent()'>"
                    . "<option value='ShowArticle.php'>Wyświetl pojedynczy artykuł</option>"
                    . "<option value='ArticleComponent.php'>Wyświetl link do artykułów</option>"
                    . "<option value='ShowPhoto.php'>Wyświetl zdjęcia z galerii</option>"
                . "</select>"
                . "<span id='select_parameters'><script>changeComponent();</script></span>"
                . "<button class='add_component_button' onclick=".'"'."addComponent('component_name', 'choose_component', 'choose_parameters', '".$templateID."')".'"'.">Dodaj komponent</button>"
            . "</div>"
            . "<div id='component_table'>"
            . "<script>$('#component_table').load('./php/ComponentTable.php',{ id: ".$templateID." });</script>"
            . "</div>"
        . "</div>";
        echo "<div class='template_edition_column' id='areas'>"
            . "<div id='template_areas'>"
            . "<script>"
                . "$('#template_areas').load('./php/GetTemplateAreas.php',{ id: ".$templateID." });"
            . "</script>"
            . "</div>";
        echo "</div>";
        echo "<span id='polandInspace'></span>";
    }
    else echo "Nie masz praw do edytowania formularzy."
?>