<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    if($connector->checkView($id, "Users")){
        $mysql_get_users=mysqli_query($connector->res, "SELECT * FROM Users_with_Ranks");
        echo "<table id='t_users' border='0' cellpading='0' cellspacing='0'>";
        echo "<tr><th>Login</th><th>Wyświetlana nazwa</th><th>Email</th><th>Ostatnie logowanie</th><th>Data rejestracji</th><th>Ranga</th></tr>";
        $i=0;
        while($record = mysqli_fetch_array($mysql_get_users)){
            $i++;
            echo "<tr class='user_row".$i."'>"
                    . "<td class='id'>".$record["User_ID"]."</td>"
                    . "<td class='login'>".$record["User_Login"]."</td>"
                    . "<td class='display'>".$record["User_DisplayName"]."</td>"
                    . "<td class='email'>".$record["User_Email"]."</td>"
                    . "<td class='logdate'>".$record["User_Lastlog"]."</td>"
                    . "<td class='regdate'>".$record["User_Registry"]."</td>"
                    . "<td class='rank'>".$record["User_Rank"]."</td>"
                    . "<td class='edit_user_button' onclick='editUser(".$i.")'></td>"
                    . "<td class='delete_user_button' onclick='deleteUser(".$i.")'></td>"
                    . "</tr>";
        }
        echo "</table>";
    }
    else echo "Nie masz praw do wyświetlania tego elementu";
?>