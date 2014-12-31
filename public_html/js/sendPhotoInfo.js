function beforeSubmit(){
    if (window.File && window.FileReader && window.FileList && window.Blob){
        var fsize = $('#FileInput')[0].files[0].size;
        var ftype = $('#FileInput')[0].files[0].type;
        switch(ftype){
            case 'image/jpg':
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
            break;
            default:
                alert("Unsupported file type!");
            return false;
        }
        if(fsize>5242880){
           alert("Too big file! File is too big, it should be less than 5 MB.");
           return false
        }
    }
    else{
        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
        return false
    }
}

function OnProgress(event, position, total, percentComplete)
{
    $('progress').css("display", "block");
    $('progress').attr("value", percentComplete);
}
function afterSuccess(){
    alert('Wysłano');
    $('progress').attr("value", "0");
}
function stopSubmitPhoto(){
    var options = {
        target:   '#progress',   
        beforeSubmit:  beforeSubmit, 
        success:       afterSuccess, 
        uploadProgress: OnProgress, 
        resetForm: true        
    }; 
    $('#upload_photo_form').submit(function() {
        var name=$("#form_name").val();
        var author=$("#form_author").val();
        var imgVal = $('#FileInput').val();
        if(imgVal==='' || name==='' || author==='') 
        { 
            alert("Wszystkie pola muszą być wypełnione"); 
            return false;
        }
        $(this).ajaxSubmit(options);           
        return false;
    });
}
function showPhotos(galleryID){
    $("#photos_layer").css("display", "block");
    if(galleryID<1){
        $("#photos_layer").load("./php/AllPhotoTable.php");
    }
    else{
        $("#photos_layer").load("./php/GalleryPhotoTable.php", {
            galleryID: galleryID
        });
    }
}
function photos_close(){
    $("#photos_layer").css("display", "none");
    $("#photos_layer").html("");
}