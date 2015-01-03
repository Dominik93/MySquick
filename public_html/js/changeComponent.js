function changeComponent(){
    var choosen=$('#choose_component').val();
    $('#select_parameters').load('./php/GetParameters.php', {
        type: choosen
    });
}