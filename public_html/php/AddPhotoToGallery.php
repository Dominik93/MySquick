<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    $gallery_id=filter_input(INPUT_POST, 'galleryID', FILTER_SANITIZE_MAGIC_QUOTES);
    $photo_id=filter_input(INPUT_POST, 'photoID', FILTER_SANITIZE_MAGIC_QUOTES);
    echo $connector->addPhotoToGallery($gallery_id, $photo_id);
?>