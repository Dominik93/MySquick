<?php
    include('mysqlConnector.php');
    
    $id=filter_input(INPUT_POST, 'template', FILTER_SANITIZE_MAGIC_QUOTES);
    $query = "SELECT *"
            . "FROM Predefined_Areas JOIN Components ON Predefined_Areas.ID_Component=Components.ID";
    $mysqli_get_components = mysqli_query($connector->res, $query);
    echo "<script>";
    while($record = mysqli_fetch_array($mysqli_get_components)){
        if($record["ID_Template"]==$id){
            echo '$("#'.$record['Area_Name'].'").load("./php/'.$record['Component_File'].'", {'
                . 'params: "'.$record['Parameters'].'"'
                . '});';
        }
    }
    echo "</script>";
    echo "<a href='index.html#admin'>Przejdź do panelu admina</a>"
?>