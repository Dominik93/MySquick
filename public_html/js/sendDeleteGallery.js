function deleteGallery(rowId){
    var id=$("#t_galleries .gall_row"+rowId+" .id").html();
    $("#photos_layer").load("./php/DeleteGallery.php",{
        id: id
    }, function(){
        $("#galleries_table").load("./php/GalleriesTable.php");
    });
}