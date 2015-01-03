function deleteComponent(rowId, tempId){
    var id=$("#t_components .component_row"+rowId+" .id").html();
    $("#polandInspace").load("./php/DeleteComponent.php",{
        id: id,
    }, function(){
        $("#component_table").load("./php/ComponentTable.php",{
                id: tempId
        });
        $('#template_areas').load('./php/GetTemplateAreas.php',{ 
                id: tempId
        });
    });
}