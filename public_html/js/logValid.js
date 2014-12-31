function notEmpty(login, password){
    if($("#"+login).val() && $("#"+password).val()) return 1;
    else return 0;
}
function logValid(login, password, log_bt){
    if(notEmpty(login, password)){
         $("#"+log_bt).attr('title' , "");
         $("#"+log_bt).animate({
             backgroundColor: "#6495ED"
         });
       }
    else{
         $("#"+log_bt).attr('title' ,"Jeżeli chcesz się zalogować podaj swój login oraz hasło.");
         $("#"+log_bt).animate({
             backgroundColor: "#A9A9A9"
         });
    }
}

