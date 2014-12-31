function deletePost(rowId){
    var id=$("#t_posts .post_row"+rowId+" .id").html();
    $("#polandInspace").load("./php/DeletePost.php",{
        id: id
    }, function(){
        $("#post_table").load("./php/PostTable.php");
    });
}