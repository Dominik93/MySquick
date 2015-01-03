function sendUserInfo(login, password, rpt_password, email, rank){
    var passwd=$("#"+password).val(), rpt=$("#"+rpt_password).val();
    if(passwd === rpt){
        var log=$("#"+login).val(), em=$("#"+email).val();
        if(passwd.length!==0 && em.length!==0 && log.length!==0){
            $("#added").load("./php/AddUser.php",{
                login: log,
                password: $.md5(passwd),
                email: em,
                rank: $("#"+rank).val()
            }, function(){
                $("#user_table").load("./php/UserTable.php");
            });
        }
        else alert("Nie wypełniłeś wymagaych pól");
    }
    else alert("Podane hasła nie są identyczne");
}
function sendEditInfo(rowId){
    var editID=$("#t_users .user_row"+rowId+" .id").html();
    var login=$("#t_users .user_row"+rowId+" .login input").val();
    var display=$("#t_users .user_row"+rowId+" .display input").val();
    var email=$("#t_users .user_row"+rowId+" .email input").val();
    var rank=$("#t_users .user_row"+rowId+" .rank #rank_selector").val();
    $("#added").load("./php/EditUser.php",{
                id: editID,
                login: login,
                display: display,
                email: email,
                rank: rank
    }, function(){
        $("#user_table").load("./php/UserTable.php");
    });
}