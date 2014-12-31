function editUser(rowId){
    $("#user_table").load("./php/UserTable.php", function(){
    
    var actualLogin=$("#t_users .user_row"+rowId+" .login").html();
    var actualDisplay=$("#t_users .user_row"+rowId+" .display").html();
    var actualEmail=$("#t_users .user_row"+rowId+" .email").html();
    var actualRank=$("#t_users .user_row"+rowId+" .rank").html();
    
    $("#t_users .user_row"+rowId+" .login").html("<input type='text' value='"+actualLogin+"' size='"+(actualLogin.length)+"'/>");
    $("#t_users .user_row"+rowId+" .display").html("<input type='text' value='"+actualDisplay+"' size='"+(actualDisplay.length)+"'/>");
    $("#t_users .user_row"+rowId+" .email").html("<input type='text' value='"+actualEmail+"' size='"+(actualEmail.length)+"'/>");
    $("#t_users .user_row"+rowId+" .rank").load("./php/GetRanks.php");
    $("#t_users .user_row"+rowId).css("background-color","LightBlue");
    $("#t_users .user_row"+rowId+" .edit_user_button").css("background-image", "url('./img/icons/passed.png')");
    $("#t_users .user_row"+rowId+" .edit_user_button").attr('onclick','sendEditInfo('+rowId+')');
});
}