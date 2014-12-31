<?php
    include("mysqlConnector.php");
    $login=filter_input(INPUT_POST, 'login', FILTER_SANITIZE_MAGIC_QUOTES);
    $password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
    if($login=="" || $password=="") echo "Nie podano wymaganych danych";
    else{
        $mysql_data_by_login=mysqli_fetch_array(mysqli_query($connector->res,"SELECT * FROM Users WHERE Login='".$login."'"));
        if(count($mysql_data_by_login)<1) echo "Nie ma użytkownika o podanym loginie";
        else{
            if(password_verify($password, $mysql_data_by_login['Password'])){
                $insert=$connector->createSession($mysql_data_by_login['ID']);
                    if($insert){
                        echo $insert;
                    }
            }
        }
    }
?>