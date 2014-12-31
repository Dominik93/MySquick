function editPost(rowId){
    var editID=$("#t_posts .post_row"+rowId+" .id").html();
    $("#editor_layer").load("./php/GetArticleText.php",{
        id: editID
    });
}