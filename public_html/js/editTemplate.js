function editTemplate(rowId){
    var id=$("#t_templates .template_row"+rowId+" .id").html();
    $("#templates_layer").css("display", "block");
    $("#templates_layer").load("./php/TemplateComponentTable.php", {
        id: id
    });
}