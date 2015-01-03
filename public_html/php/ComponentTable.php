<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $templateID=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->checkView($id, "Templates")){
        $mysql_get_users=mysqli_query($connector->res, "SELECT * FROM Components WHERE ID_Template='".$templateID."'");
        echo "<table id='t_components' border='0' cellpading='0' cellspacing='0'>";
        $i=0;
        while($record = mysqli_fetch_array($mysql_get_users)){
            $i++;
            echo "<tr class='component_row".$i."'>"
                    . "<td class='id'>".$record["ID"]."</td>"
                    . "<td class='name'>".$record["Name"]."</td>"
                    . "<td class='delete_component_button' onclick='deleteComponent(".$i.", ".$templateID.")'></td>"
                    . "</tr>";
        }
        echo "</table>";
        if($i==0) echo "Nie ma komponentów dla tego szablonu";
    }
    else{
        echo "Nie masz prawa do wyświetlania tych elementów";
    }
?>