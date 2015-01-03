function addComponent(name, component, parameters, tempId){
    var c_name=$("#"+name).val();
    var c_component=$("#"+component).val();
    var c_parameters=$("#"+parameters).val();
    if(c_name.length===0 || c_parameters!==""){
        $("#polandInspace").load("./php/AddComponent.php",{
            id: tempId,
            name: c_name,
            component: c_component,
            parameters: c_parameters
        },function(){
            $("#component_table").load("./php/ComponentTable.php",{
                id: tempId
            });
            $('#template_areas').load('./php/GetTemplateAreas.php',{ 
                id: tempId
            });
        });
    }
    else alert("Wszystkie pola muszą być wypełnione");
}
function template_close(){
    $("#templates_layer").css("display", "none");
    $("#templates_layer").html("");
}