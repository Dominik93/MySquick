function setAtUse(id){
    $.post("./php/SetUsedTemplate.php",{
       id: id 
    }, function(){
        $("#templates_table").load("./php/TemplateTable.php");  
    });
}