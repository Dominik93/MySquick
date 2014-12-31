function passedTask(rowId){
    var passedId=$("#t_tasks .task_row"+rowId+" .id").html();
    
    if(passedId){
        $("#t_tasks .task_row"+rowId+" .passed_task_button").load("./php/PassTask.php",{
            id: passedId
        }, function(){
            $("#task_table").load("./php/TaskTable.php");
        });
    }
}