<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $templateID=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->checkEdit($id, "Templates")){
        $mysql_get_areas=mysqli_query($connector->res, "SELECT * FROM Predefined_Areas WHERE ID_Template='".$templateID."'");
        echo "<table id='t_areas' border='0' cellpading='0' cellspacing='0'>";
        $i=0;
        while($record=mysqli_fetch_array($mysql_get_areas)){
            $i++;
            if($record["Area_Name"]!="footer"){
                echo "<tr class='area_row".$i."'>"
                    . "<td class='id'>".$record["ID"]."</td>"
                    . "<td class='login'>".$record["Area_Name"]."</td>"
                    . "<td class='component_selector_to_area'><script>$('.area_row".$i." .component_selector_to_area').load('./php/GetComponents.php',{ areaID: '".$record['ID']."' });</script></td>"
                    . "</tr>";
            }
        }
        echo "</table>";
    }
?>