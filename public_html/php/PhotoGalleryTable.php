<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $gallery_id=filter_input(INPUT_POST, 'id', FILTER_SANITIZE_MAGIC_QUOTES);
    if($connector->checkView($id, "Photos") && $connector->checkView($id, "Galleries")){
        $mysql_get_photos=mysqli_query($connector->res, "SELECT * FROM Photos");
        echo "<div id='close' onclick='photos_close()'>Zamknij</div>";
        echo "<div id='photos'>";
        while($record = mysqli_fetch_array($mysql_get_photos)){
            echo "<div class='photo_container' id='photo".$record['ID']."'>";
            echo "<p class='photo_name'>".$record["Name"]."</p>";
            echo "<img src='".$record["Path"]."' alt='".$record["Name"]."' width='200'/>";
            echo "<p class='photo_author'>Autor: ".$record["Photo_Author"]."<span>".$record["Storage_Date"]."</span></p>";
            $mysql_get_inGallery=  mysqli_query($connector->res, "SELECT * FROM inGallery WHERE ID_Photo='".$record['ID']."';");
            $i=0;
            while($photo=mysqli_fetch_array($mysql_get_inGallery)){
                if($gallery_id==$photo["ID_Gallery"]){
                    $i=1;
                    break;
                }
                $i=0;
            }
            if($connector->checkEdit($id, "Galleries")){
                if($i==1) echo "<input type='checkbox' onclick='changePhotoInGallery(".$gallery_id.", ".$record['ID'].")' checked/>Dodaj do galerii<br/>";
                else  echo "<input type='checkbox' onclick='changePhotoInGallery(".$gallery_id.", ".$record['ID'].")' />Dodaj do galerii<br/>";
            }
            else{
                if($i==1) echo "<input type='checkbox' disabled='disabled' checked/>Dodaj do galerii<br/>";
                else echo "<input type='checkbox' disabled='disabled'/>Dodaj do galerii<br/>";  
            }
            echo "</div>";
        }
        echo "</div>";
        echo "<span id='polandInspace'></span>";
    }
    else echo "Nie masz praw do wyświetlania tego elementu";
?>