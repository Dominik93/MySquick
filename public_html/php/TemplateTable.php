<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    if($connector->checkView($id, "Templates")){
        $mysql_get_temp=mysqli_query($connector->res, "SELECT * FROM Templates");
        echo "<table id='t_templates' border='0' cellpading='0' cellspacing='0'>";
        echo "<tr><th>Nazwa</th><th>Autor</th><th>Data utworzenia</th></tr>";
        $i=0;
        while($record = mysqli_fetch_array($mysql_get_temp)){
            $i++;
            $mysql_get_author=mysqli_fetch_array(mysqli_query($connector->res, "SELECT * FROM Users WHERE ID='".$record["ID_Creator"]."'"));
            if(count($mysql_get_author) == 0) {
                $mysql_get_author["Display_Name"] = "Użytkownik usunięty";
            }
            echo "<tr class='template_row".$i."'>"
                    . "<td class='id'>".$record["ID"]."</td>"
                    . "<td class='name'>".$record["Name"]."</td>"
                    . "<td class='author'>".$mysql_get_author["Display_Name"]."</td>"
                    . "<td class='create_date'>".$record["Add_Date"]."</td>"
                    . "<td class='edit_templates_button' onclick='editTemplate(".$i.")'></td>"
                    . "<td class='delete_templates_button' onclick='deleteTemplate(".$i.")'></td>";
            if($connector->checkEdit($id, "Templates")){
                if($record["At_Use"]) echo "<td class='set_templates_button'><input type='checkbox' onclick='return false' checked/></td>";
                else echo "<td class='set_templates_button'><input type='checkbox' onclick='setAtUse(".$record['ID'].")'/></td>";
            }
            else{
                if($record["At_Use"]) echo "<td class='set_templates_button'><input type='checkbox' disabled='disabled' checked/></td>";
                else echo "<td class='set_templates_button'><input type='checkbox' disabled='disabled'/></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    else echo "Nie masz prawa do wyświetlania tego elementu";
?>