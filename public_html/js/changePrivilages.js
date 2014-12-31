function changePrivilages(rankID, privilageName, right){
    $.post("./php/ChangePrivilages.php",{"rankID": rankID, "privilageName": privilageName, "right": right});
}


