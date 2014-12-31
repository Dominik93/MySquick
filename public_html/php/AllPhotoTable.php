<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    if($connector->checkView($id, "Photos")){
        $mysql_get_photos=mysqli_query($connector->res, "SELECT * FROM Photos");
        echo "<div id='close' onclick='photos_close()'>Zamknij</div>";
        echo "<div id='photos'>";
        while($record = mysqli_fetch_array($mysql_get_photos)){
            echo "<div class='photo_container' id='photo".$record['ID']."'>";
            echo "<p class='photo_name'>".$record["Name"]."</p>";
            echo "<img src='".$record["Path"]."' alt='".$record["Name"]."' width='200'/>";
            echo "<p class='photo_author'>Autor: ".$record["Photo_Author"]."<span>".$record["Storage_Date"]."</span></p>";
            echo "<button class='delete_photo_button' onclick='deletePhoto(".$record['ID'].")'>Usuń zdjęcie</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "<span id='polandInspace'></span>";
    }
    else echo "Nie masz praw do wyświetlania tego elementu";
?>