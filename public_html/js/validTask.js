function validTask(title, text){
    task_title=$("#"+title).val();
    task_text=$("#"+text).val();
    if(task_title.length!==0 && task_text.length!==0){
        $("#added").load("./php/AddTask.php", {
            title: task_title,
            text: task_text
        }, function(){
            $("#task_table").load("./php/TaskTable.php");
        });
    }
    else alert("Oba pola musze być wypełnione");
}