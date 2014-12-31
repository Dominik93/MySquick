<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    if($connector->checkView($id, "Galleries")){
        $mysql_get_galleries=mysqli_query($connector->res, "SELECT * FROM Galleries");
        echo "<table id='t_galleries' border='0' cellpading='0' cellspacing='0'>";
        echo "<tr>";
        $i=1;
        $record = mysqli_fetch_array($mysql_get_galleries);
        while($i<4){
            echo "<th>".array_keys($record)[($i*2+1)]."</th>";
            $i++;
        }
        echo "</tr>";
        $i=1;
        do{
            $mysql_get_author=mysqli_fetch_array(mysqli_query($connector->res, "SELECT * FROM Users WHERE ID='".$record["ID_Author"]."'"));
            echo "<tr class='gall_row".$i."'>"
                    . "<td class='id'>".$record["ID"]."</td>"
                    . "<td class='title'>".$record["Title"]."</td>"
                    . "<td class='author'>".$mysql_get_author["Display_Name"]."</td>"
                    . "<td class='create_date'>".$record["Create_Date"]."</td>"
                    . "<td class='edit_gallery_button' onclick='editGallery(".$i.")'></td>"
                    . "<td class='delete_gallery_button' onclick='deleteGallery(".$i.")'></td>";
            $i++;
        }while($record=  mysqli_fetch_array($mysql_get_galleries));
    }
    else echo "Nie masz prawa do wyświetlania tego elementu";
?>