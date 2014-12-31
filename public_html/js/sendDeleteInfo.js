function deleteUser(rowId){
    $("#user_table").load("./php/UserTable.php", function(){
        var deleteID=$("#t_users .user_row"+rowId+" .id").html();
        var login=$("#t_users .user_row"+rowId+" .login").html();
        var ask=confirm("Czy na pewno chcesz usunąć użytkownika "+login+"?");
        if(ask){
            $("#t_users .user_row"+rowId+" .delete_user_button").load("./php/DeleteUser.php",{
              id: deleteID  
            }, function(){
                $("#user_table").load("./php/UserTable.php");
            });
        }
    });
}