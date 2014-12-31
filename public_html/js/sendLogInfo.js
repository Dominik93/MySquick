function sendLogInfo(login, password){
    $("#annotation").load("./php/LogIn.php",{
        login: $("#"+login).val(),
        password: $.md5($("#"+password).val())
    }, function(response, status, xhr) {
        if (status == "error") {
    var msg = "Sorry but there was an error: ";
    alert(msg + xhr.status + " " + xhr.statusText);}
  })
}