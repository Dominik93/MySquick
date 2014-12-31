function sendArticleTitle(title){
    var title_val=$("#"+title).val();
    if(title_val.length!==0){
        $("#editor_layer").load("./php/checkPost.php",{
            title: title_val
        });
    }
    else alert("Podaj tytuł artykułu!");
}
function sendArticle(title, text){
    var text_val=CKEDITOR.instances[text].getData();
    var title_val=$("#"+title).val();
    if(title_val.length!==0 && text_val.length!==0){
        $("#polandInspace").load("./php/AddArticle.php",{
            text: text_val,
            title: title_val
        }, function(){
            $("#editor_layer").css("display", "none");
            $("#post_table").load("./php/PostTable.php");
            CKEDITOR.instances[text].setData('');
        });
    }
    else{
        alert("Artykuł musi mieć tekst i treść!");
        $("#editor_layer").css("display", "none");
    }
}