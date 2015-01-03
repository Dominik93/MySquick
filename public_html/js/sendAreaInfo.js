function editArea(areaID){
    var new_component_id=$("#choose_component_in_area"+areaID).val();
    $.post("./php/EditAreas.php",{
        areaID: areaID,
        componentID: new_component_id
    });
}