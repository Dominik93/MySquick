function deletePhoto(photoID){
    $("#polandInspace").load("./php/DeletePhoto.php",{
        photoID: photoID
    }, function(){
        $("#photos_layer").load("./php/AllPhotoTable.php");
    });
}