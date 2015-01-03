function deleteTemplate(rowId){
    var id=$("#t_templates .template_row"+rowId+" .id").html();
    $("#polandInspace").load("./php/DeleteTemplate.php",{
        id: id
    }, function(){
        $("#templates_table").load("./php/TemplateTable.php");
    });
}