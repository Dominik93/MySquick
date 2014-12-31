<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    if($connector->checkView($id, "Posts")){
        $mysql_get_posts=mysqli_query($connector->res, "SELECT * FROM Articles");
        echo "<table id='t_posts' border='0' cellpading='0' cellspacing='0'>";
        echo "<tr><th>Tytuł</th><th>Autor</th><th>Data utworzenia</th></tr>";
        $i=0;
        while($record = mysqli_fetch_array($mysql_get_posts)){
            $i++;
            $mysql_get_author=mysqli_fetch_array(mysqli_query($connector->res, "SELECT * FROM Users WHERE ID='".$record["ID_Author"]."'"));
            if(count($mysql_get_author) == 0) {
                $mysql_get_author["Display_Name"] = "Użytkownik usunięty";
            }
            echo "<tr class='post_row".$i."'>"
                    . "<td class='id'>".$record["ID"]."</td>"
                    . "<td class='title'>".$record["Title"]."</td>"
                    . "<td class='author'>".$mysql_get_author["Display_Name"]."</td>"
                    . "<td class='create_date'>".$record["Create_Date"]."</td>"
                    . "<td class='edit_post_button' onclick='editPost(".$i.")'></td>"
                    . "<td class='delete_post_button' onclick='deletePost(".$i.")'></td>"
                    . "</tr>";
            
        }
        echo "</table>";
    }
    else echo "Nie masz praw do wyświetlania tego elementu";
?>