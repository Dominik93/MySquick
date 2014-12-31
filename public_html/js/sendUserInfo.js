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