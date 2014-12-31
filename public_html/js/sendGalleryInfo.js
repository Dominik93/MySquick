function sendGallery(title){
    var gal_title=$("#"+title).val();
    if(gal_title!==''){
        $("#photos_layer").load("./php/AddGallery.php",{
           title: gal_title 
        }, function(){
            $("#galleries_table").load("./php/GalleriesTable.php");
        });
    }
    else alert("Galeria musi mieć nazwę");
}
function changePhotoInGallery(galleryId, photoId){
    var actual_checkbox_value=$("#photo"+photoId+" :checkbox").is(':checked');
    if(actual_checkbox_value){
        $.post("./php/AddPhotoToGallery.php",{
            galleryID: galleryId,
            photoID: photoId
        });
    }
    else{
        $.post("./php/RemovePhotoFromGallery.php",{
            galleryID: galleryId,
            photoID: photoId
        });
    };
}