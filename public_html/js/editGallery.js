function editGallery(rowId){
    var id=$("#t_galleries .gall_row"+rowId+" .id").html();
    $("#photos_layer").css("display", "block");
    $("#photos_layer").load("./php/PhotoGalleryTable.php", {
        id: id
    });
}