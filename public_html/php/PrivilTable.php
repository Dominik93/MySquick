<?php
    include("mysqlConnector.php");
    
    $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
    $id=$connector->selectUserIDBySession($sessionNumber);
    if($connector->checkView($id, "Privilages")){
        $mysql_get_rank=mysqli_query($connector->res, "SELECT * FROM Ranks");
        echo "<table id='t_ranks' border='0' cellpading='0' cellspacing='0'><tr><th>Ranga</th>";
        $i=2;
        $record = mysqli_fetch_array($mysql_get_rank);
        while($i<8){
            echo "<th>".array_keys($record)[($i*2+1)]."</th>";
            $i++;
        }
        echo "</tr>";
        echo "<tr class='privilage_row1'><td class='rank'>".$record["Name"]."</td></td><td colspan='".($i-2)."' align='center' class='admin_messange'><b>".$record['Name']." have full access always!</b></td></tr>";
        while($record = mysqli_fetch_array($mysql_get_rank)){
            $i=2;
            echo "<tr class='privilage_row".$i."'><td class='rank'>".$record["Name"]."</td>";
            while($i<8){
                if($connector->checkEdit($id, "Privilages")){
                    echo "<td class=".array_keys($record)[($i*2+1)].">";
                    if($record[$i][0]==1) echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 0)' checked/>Widok<br/>";
                    else echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 0)' />Widok<br/>";
                    if($record[$i][1]==1) echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 1)' checked/>Dodawanie<br/>";
                    else echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 1)' />Dodawanie<br/>";
                    if($record[$i][2]==1) echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 2)' checked/>Edycja<br/>";
                    else  echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 2)' />Edycja<br/>";
                    if($record[$i][3]==1) echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 3)' checked/>Usuwanie<br/>";
                    else  echo "<input type='checkbox' onclick='changePrivilages(".$record['ID'].", \"".array_keys($record)[($i*2+1)]."\", 3)' />Usuwanie<br/>";
                    echo "</td>";  
                }
                else{
                    echo "<td class=".array_keys($record)[($i*2+1)].">";
                    if($record[$i][0]==1) echo "<input type='checkbox' disabled='disabled' checked/>Widok<br/>";
                    else echo "<input type='checkbox' disabled='disabled'/>Widok<br/>";
                    if($record[$i][1]==1) echo "<input type='checkbox' disabled='disabled' checked/>Dodawanie<br/>";
                    else echo "<input type='checkbox' disabled='disabled' />Dodawanie<br/>";
                    if($record[$i][2]==1) echo "<input type='checkbox' disabled='disabled' checked/>Edycja<br/>";
                    else  echo "<input type='checkbox' disabled='disabled' />Edycja<br/>";
                    if($record[$i][3]==1) echo "<input type='checkbox' disabled='disabled' checked/>Usuwanie<br/>";
                    else  echo "<input type='checkbox' disabled='disabled' />Usuwanie<br/>";
                    echo "</td>";  
                    
                }
                $i++;
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    else echo "Nie masz praw do wyświetlania tego elementu";
?>