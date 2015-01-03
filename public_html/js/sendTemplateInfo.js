function beforeTemplateSubmit(){
    if (window.File && window.FileReader && window.FileList && window.Blob){
        var fsize = $('#FileInput')[0].files[0].size;
        var ftype = $('#FileInput')[0].files[0].type;
        switch(ftype){
            case 'application/zip':
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

function OnTemplateProgress(event, position, total, percentComplete)
{
    $('progress').css("display", "block");
    $('progress').attr("value", percentComplete);
}
function afterTemplateSuccess(){
    alert('Wysłano');
}
function stopSubmitTemplate(){
    var options = {
        target:   '#progress',   
        beforeSubmit:  beforeTemplateSubmit, 
        success:       afterTemplateSuccess, 
        uploadProgress: OnTemplateProgress, 
        resetForm: true        
    }; 
    $('#upload_template_form').submit(function() {
        var name=$("#form_name").val();
        var imgVal = $('#FileInput').val();
        if(imgVal==='' || name==='') 
        { 
            alert("Wszystkie pola muszą być wypełnione"); 
            return false;
        }
        $.when($(this).ajaxSubmit(options)).then(function(){
            $('progress').attr("value", "0");
            $("#templates_table").load("./php/TemplateTable.php");   
        });        
        return false;
    });
}
function showTemplate(templateID){
}
function template_close(){
    $("#photos_layer").css("display", "none");
    $("#photos_layer").html("");
}