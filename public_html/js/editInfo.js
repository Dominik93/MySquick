function sendEditInfo(rowId){
    var editID=$("#t_users .user_row"+rowId+" .id").html();
    var newLogin=$("#t_users .user_row"+rowId+" .login input").val();
    var newDisplay=$("#t_users .user_row"+rowId+" .display input").val();
    var newEmail=$("#t_users .user_row"+rowId+" .email input").val();
    var newRank=$("#t_users .user_row"+rowId+" .rank select").val();
    
    if(newLogin.length===0 || newDisplay.length===0 || newEmail.length===0 || newRank.length===0){
        alert("Uzupełnij wszystkie pola");
    }
    else{
        $("#t_users .user_row"+rowId+" .edit_user_button").load("./php/EditUser.php", {
            id: editID,
            login: newLogin,
            display: newDisplay,
            email: newEmail,
            rank: newRank
        }, function(){
            $("#t_users .user_row"+rowId+" .edit_user_button").css("background-image", "url('./img/icons/edit.png')");
            $("#t_users .user_row"+rowId+" .edit_user_button").attr('onclick','editUser('+rowId+')');
            $("#user_table").load("./php/UserTable.php");
            $("#user_name").load("./php/Panel.php");
        });
        
    }
}