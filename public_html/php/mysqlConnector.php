<?php
    class mysqlConnector{
        public $db_address = 'localhost';
        public $db_name = 'virt101443_cms';
        public $db_login = 'virt101443_cms';
        public $db_pass = 'regor3600';
        public $res;
        
        public function __construct(){
            $this->res=mysqli_connect(
                    $this->db_address,
                    $this->db_login,
                    $this->db_pass,
                    $this->db_name
            );
        }
        public function charset(){
            mysqli_set_charset($this->res, 'utf8');
        }
        public function __destruct(){
            mysqli_close($this->res);
        }
        
        //Obsługa transakcji
        public function begin(){
            mysqli_query($this->res,"BEGIN");
        }
        public function commit(){
            mysqli_query($this->res,"COMMIT");
        }
        public function rollback(){
            mysqli_query($this->res,"ROLLBACK");
        }
        
        //Sprawdzanie sesji
        public function checkCookie(){
            $session_number=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            if($session_number){
                $ip=$_SERVER['REMOTE_ADDR'];
                $query="SELECT * FROM Sessions WHERE Session='".$session_number."' AND Session_IP='".$ip."';";
                $get_session_by_cookie=mysqli_fetch_array(mysqli_query($this->res, $query));
                if(count($get_session_by_cookie["ID"])!=0){
                    return 1;
                }
                else{
                    return 0;
                }
            }
        }
        
        //Sesje
        public function createSession($userID){
            $session_number="";
            do{
                for($i = 0; $i < 12; $i++) {
                    $session_number .= rand(0, 9);
                }
            }while(count(mysqli_fetch_array(mysqli_query($this->res,"SELECT * FROM Sessions WHERE Session='".$session_number."';"))["ID"])!=0);
            $query="DELETE FROM Sessions WHERE ID_User='".$userID."'";
            $this->begin();
            $del_actual_user_session=mysqli_query($this->res, $query);
            if(!$del_actual_user_session){
                $this->rollback();
            }
            else{
                $this->commit();
                $ip=$_SERVER['REMOTE_ADDR'];
                $now=date('Y-m-d G:i:s');;
                $query="INSERT INTO Sessions (Session, ID_User, Session_IP) VALUES ('".$session_number."', '".$userID."', '".$ip."');";
                $query2="UPDATE Users SET Lastlog_Date='".$now."' WHERE ID='".$userID."' ;";
                $this->begin();
                $add_session=mysqli_query($this->res, $query);
                $set_lastlog=mysqli_query($this->res, $query2);
                if(!$add_session && !$set_lastlog){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return "<script>$.when($.cookie('squick_cmsSession', $session_number)).then($('#container').load('./cms_mainscreen.html'));</script>";
                }
            }
        }
        public function updateSession(){
            if($this->checkCookie()){
                $session_number=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
                $now=date('Y-m-d G:i:s');
                $query="UPDATE Sessions SET LastAction_Date='".$now."' WHERE Session='".$session_number."';";
                $this->begin();
                $set_new_date=mysqli_query($this->res, $query);
                if(!$set_new_date){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        
        //Prawa
        public function parseRight($privilage, $right){
            $this->updateSession();
            return $privilage[$right];
        }
        public function checkView($userID, $privilageName){
            if($this->checkCookie()){
                $query="SELECT * FROM Users_with_Privilages WHERE UserID='".$userID."';";
                $get_privilages = mysqli_fetch_array(mysqli_query($this->res, $query));
                if($this->parseRight($get_privilages[$privilageName], 0)==1){
                    return 1;
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        public function checkAdd($userID, $privilageName){
            if($this->checkCookie()){
                $query="SELECT * FROM Users_with_Privilages WHERE UserID='".$userID."';";
                $get_privilages = mysqli_fetch_array(mysqli_query($this->res, $query));
                if($this->parseRight($get_privilages[$privilageName], 1)==1){
                    return 1;
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        public function checkEdit($userID, $privilageName){
            if($this->checkCookie()){
                $query="SELECT * FROM Users_with_Privilages WHERE UserID='".$userID."';";
                $get_privilages = mysqli_fetch_array(mysqli_query($this->res, $query));
                if($this->parseRight($get_privilages[$privilageName], 2)==1){
                    return 1;
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        public function checkDelete($userID, $privilageName){
            if($this->checkCookie()){
                $query="SELECT * FROM Users_with_Privilages WHERE UserID='".$userID."';";
                $get_privilages = mysqli_fetch_array(mysqli_query($this->res, $query));
                if($this->parseRight($get_privilages[$privilageName], 3)==1){
                    return 1;
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        
        //Zapytania
        public function selectUserIDBySession($sessionNumber){
            if($this->checkCookie()){
                $query="SELECT * FROM Sessions WHERE Session='".$sessionNumber."';";
                $get_userID=  mysqli_fetch_array(mysqli_query($this->res, $query));
                return $get_userID["ID_User"];
            }
            else return 0;
        }
        
        //Zapytania - TASKS
        public function addTask($title, $text){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkAdd($id, "Tasks")){
                $now=date('Y-m-d G:i:s');
                $query="INSERT INTO Tasks SET Title='".$title."', Text='".$text."', Create_Date='".$now."', ID_Author='".$id."';";
                $this->begin();
                $add_task=mysqli_query($this->res, $query);
                if(!$add_task){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        public function delTask($taskID){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkDelete($id, "Tasks")){
                $query="DELETE FROM Tasks WHERE ID='".$taskID."';";
                $this->begin();
                $del_task=mysqli_query($this->res, $query);
                if(!$del_task){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        
        //Zapytania - USERS
        public function adminAmount(){ //count() nie chciało działać, nie wiem czemu
            $i=0;
            $query="SELECT * FROM Users_with_Ranks";
            $get_admins=mysqli_query($this->res, $query);
            while($record=mysqli_fetch_array($get_admins)){
                if($record['User_Rank']=="Admin") $i++;
            }
            return $i;
        }
        public function isLastAdmin($id){
            if($this->adminAmount()==1){
                $query="SELECT * FROM Users_with_Ranks WHERE User_ID='".$id."';";
                if(mysqli_fetch_array(mysqli_query($this->res, $query))["User_Rank"]=="Admin"){
                    return 1;
                }
                else{
                    return 0;
                }
            }
        }
        public function addUser($login, $password, $email, $rank){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkAdd($id, "Users")){
                $query="SELECT * FROM Users WHERE Login='".$login."';";
                if(count(mysqli_fetch_array(mysqli_query($this->res, $query))["ID"])!=0){
                    return 0;
                }
                else{
                    $now=date('Y-m-d G:i:s');
                    $options = [
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                    ];
                    $password=password_hash($password, PASSWORD_BCRYPT);
                    $query="INSERT INTO Users SET ID_Rank='".$rank."', Login='".$login."', Password='".$password."', Email='".$email."', Display_Name='".$login."', Registry_Date='".$now."';";
                    $this->begin();
                    $add_user=mysqli_query($this->res, $query);
                    if(!$add_user){
                        $this->rollback();
                        return 0;
                    }
                    else{
                        $this->commit();
                        return 1;
                    }
                }
            }
            else{
                return 0;
            }
        }
        public function editUser($idToEdit, $login, $display, $email, $rank){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkEdit($id, "Users")){
                if(!$this->isLastAdmin($idToEdit)){
                    $query="UPDATE Users SET Login='".$login.
                        "', Display_Name='".$display.
                        "', Email='".$email.
                        "', ID_Rank='".$rank."'"
                        ."WHERE ID='".$idToEdit."';";
                }
                else{
                    $query="UPDATE Users SET Login='".$login.
                        "', Display_Name='".$display.
                        "', Email='".$email."'"
                        ."WHERE ID='".$idToEdit."';";
                }
                $this->begin();
                $edit_user=mysqli_query($this->res, $query);
                if(!$edit_user){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        public function delUser($idToDelete){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkDelete($id, "Users")){
                if(!($this->isLastAdmin($idToDelete))){
                    $query="DELETE FROM Users WHERE ID='".$idToDelete."';";
                    $this->begin();
                    $del_user=mysqli_query($this->res, $query);
                    if(!$del_user){
                        $this->rollback();
                        return 0;
                    }
                    else{
                        $this->commit();
                        return 1;
                    }
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        
        //Zapytania - PRIVILAGES
        public function editPrivilage($rankID, $privilageName, $right){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkEdit($id, "Privilages")){
                $query="SELECT ".$privilageName." FROM Ranks WHERE ID='".$rankID."';";
                $get_rights=  mysqli_fetch_array(mysqli_query($this->res, $query));
                if($get_rights[$privilageName][$right]==1)$get_rights[$privilageName][$right]=0;
                else $get_rights[$privilageName][$right]=1;
                $query="UPDATE Ranks SET ".$privilageName."='".$get_rights[$privilageName]."' WHERE ID='".$rankID."';";
                $this->begin();
                $set_privilages=mysqli_query($this->res, $query);
                if(!$set_privilages){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        
        //Zapytania - POSTS
        public function postAmount($title){ //count() nie chciało działać, nie wiem czemu
            $i=0;
            $query="SELECT * FROM Articles";
            $get_admins=mysqli_query($this->res, $query);
            while($record=mysqli_fetch_array($get_admins)){
                if($record['Title']==$title) $i++;
            }
            return $i;
        }
        public function getPostbyID($id){
            $query="SELECT * FROM Articles WHERE ID='".$id."';";
            $get_post=  mysqli_fetch_array(mysqli_query($this->res, $query));
            return $get_post;
        }
        public function getPostIDbyTitle($title){
            $query="SELECT * FROM Articles WHERE Title='".$title."';";
            $get_post=  mysqli_fetch_array(mysqli_query($this->res, $query));
            return $get_post['ID'];
        }
        public function editPost($title, $text){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkEdit($id, "Posts")){
                $query="UPDATE Articles SET Title='".$title."', Text='".$text."' WHERE ID='".$this->getPostIDbyTitle($title)."';";
                $this->begin();
                $edit_post=mysqli_query($this->res, $query);
                if(!$edit_post){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        public function addPost($title, $text){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->postAmount($title)>0){
                return $this->editPost($title, $text);
            }
            else{
                if($this->checkAdd($id, "Posts")){
                    $now=date('Y-m-d G:i:s');
                    $query="INSERT INTO Articles SET Title='".$title."', Text='".$text."', Create_Date='".$now."', ID_Author='".$id."';";
                    $this->begin();
                    $add_post=mysqli_query($this->res, $query);
                    if(!$add_post){
                        $this->rollback();
                        return 0;
                    }
                    else{
                        $this->commit();
                        return 1;
                    }
                }
                else{
                    return 0;
                }
            }
        }
        public function delPost($idToDelete){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkDelete($id, "Posts")){
                $query="DELETE FROM Articles WHERE ID='".$idToDelete."';";
                $this->begin();
                $del_post=mysqli_query($this->res, $query);
                if(!$del_post){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        //Zapytania - PHOTO
        public function uploadPhotoOnServer($File_Name){
            if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK){
                $UploadDirectory    = substr(getcwd(),0, strlen(getcwd())-3).'/uploaded/';
                if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die();
                if ($_FILES["FileInput"]["size"] > 5242880) die("File size is too big!");
                switch(strtolower($_FILES['FileInput']['type'])){
                    case 'image/gif':
                    case 'image/jpeg':
                    case 'image/jpg':
                    case 'image/pjpeg':
                        break;
                    default:
                        die('Unsupported File!'); 
                }
                $File_Ext           = substr($_FILES['FileInput']['type'], strrpos($_FILES['FileInput']['type'], '/')+1); //get file extention
                $Random_Number      = rand(0, 9999999999); //Random number to be added to name.
                $NewFileName        = $File_Name.$Random_Number.".".$File_Ext; //new file name
                if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName )) return $NewFileName;
                else die('error uploading File!');
            }
            else die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
        }
        public function getPhotoPathByID($id){
            $query="SELECT * FROM Photos WHERE ID='".$id."';";
            $get_photo=  mysqli_fetch_array(mysqli_query($this->res, $query));
            return $get_photo['Path'];
        }
        public function addPhoto($name, $photo_author){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkAdd($id, "Photos")){
                $path="./uploaded/".$this->uploadPhotoOnServer($name);
                $now=date('Y-m-d G:i:s');
                $query="INSERT INTO Photos SET Path='".$path."', Storage_Date='".$now."', Name='".$name."', Photo_Author='".$photo_author."';";
                $this->begin();
                $add_photo=mysqli_query($this->res, $query);
                if(!$add_photo){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        public function delPhoto($idToDelete){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkDelete($id, "Photos")){
                $path=$this->getPhotoPathByID($idToDelete);
                $query="DELETE FROM Photos WHERE ID='".$idToDelete."';";
                $this->begin();
                $del_post=mysqli_query($this->res, $query);
                if(!$del_post){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    unlink(realpath('.'.$path));
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        
        //Zapytania - GALLERY
        public function galleryAmount($title){ //count() nie chciało działać, nie wiem czemu
            $i=0;
            $query="SELECT * FROM Galleries";
            $get_gall=mysqli_query($this->res, $query);
            while($record=mysqli_fetch_array($get_gall)){
                if($record['Title']==$title) $i++;
            }
            return $i;
        }
        public function addGallery($title){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->galleryAmount($title)>0){
                return 0;
            }
            else{
                if($this->checkAdd($id, "Galleries")){
                    $now=date('Y-m-d G:i:s');
                    $query="INSERT INTO Galleries SET Title='".$title."', Create_Date='".$now."', ID_Author='".$id."';";
                    $this->begin();
                    $add_gall=mysqli_query($this->res, $query);
                    if(!$add_gall){
                        $this->rollback();
                        return 0;
                    }
                    else{
                        $this->commit();
                        return 1;
                    }
                }
                else{
                    return 0;
                }
            }
        }
        public function delGallery($idToDelete){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkDelete($id, "Galleries")){
                $query="DELETE FROM Galleries WHERE ID='".$idToDelete."';";
                $this->begin();
                $del_gall=mysqli_query($this->res, $query);
                if(!$del_gall){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        public function addPhotoToGallery($gallery_id, $photo_id){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkAdd($id, "Galleries")){
                $query="INSERT INTO inGallery SET ID_Photo='".$photo_id."', ID_Gallery='".$gallery_id."';";
                $this->begin();
                $add_photo=mysqli_query($this->res, $query);
                if(!$add_photo){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        public function removePhotoFromGallery($gallery_id, $photo_id){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkEdit($id, "Galleries")){
                $query="DELETE FROM inGallery WHERE ID_Photo='".$photo_id."' AND ID_Gallery='".$gallery_id."';";
                $this->begin();
                $del_photo=mysqli_query($this->res, $query);
                if(!$del_photo){
                    $this->rollback();
                    return 0;
                }
                else{
                    $this->commit();
                    return 1;
                }
            }
            else{
                return 0;
            }
        }
        
        //Zapytania - TEMPLATES
        public function zipExtractor($path, $name){
            $zip=new ZipArchive();
            $destinationFolder=substr(getcwd(),0, strlen(getcwd())-3).'/templates/'.substr($name, 0, strlen($name)-4);
            $zipPath=substr(getcwd(),0, strlen(getcwd())-3).'/templates/temp/'.$name;
            if($zip->open($zipPath)){
                if(is_dir($destinationFolder)){
                    mkdir($destinationFolder);
                }
                $zip->extractTo($destinationFolder);
                unlink($zipPath);
                $zip->close();
                return $destinationFolder;
            }
            else return 0;
        }
        public function checkZipContent($UploadDirectory, $File_Name){
                $zip=zip_open($UploadDirectory.$File_Name);
                if($zip){
                    while($zip_entry = zip_read($zip)){
                        if(zip_entry_name($zip_entry)=="areas_table.cnf"){
                            if(zip_entry_open($zip, $zip_entry)){
                                $content = zip_entry_read($zip_entry);
                                if(strpos($content, "#content") && strpos($content, "#footer")){
                                    return $this->zipExtractor($UploadDirectory, $File_Name);
                                }
                                else{
                                    return 0;
                                }
                            }
                            else{
                                return 0;
                            }
                        }
                        else{
                            return 0;
                        }
                    }
                }
                else{
                    return 0;
                }
        }
        public function uploadTemplateOnServer($File_Name){
            if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK){
                if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die();
                if ($_FILES["FileInput"]["size"] > 5242880) die("File size is too big!");
                switch(strtolower($_FILES['FileInput']['type'])){
                    case 'application/zip':
                        break;
                    default:
                        die('Unsupported File!'); 
                }
            }
            $UploadDirectory    = substr(getcwd(),0, strlen(getcwd())-3).'/templates/temp/';
            $File_Ext           = substr($_FILES['FileInput']['type'], strrpos($_FILES['FileInput']['type'], '/')+1); //get file extention
            $Random_Number      = rand(0, 9999999999); //Random number to be added to name.
            $NewFileName        = $File_Name.$Random_Number.".".$File_Ext; //new file name
            if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName )){
                return $this->checkZipContent($UploadDirectory, $NewFileName);
                
            }
            else die('error uploading File!');
        }
        public function getAreasTable($path){
            $table_file=fopen($path."/areas_table.cnf", "r");
            $i=0;
            $areas_table=[];
            while($line=trim(fgets($table_file))){
                $areas_table[$i]=substr($line, 1);
                $i++;
            }
            return $areas_table;
        }
        public function addTemplateAreas($templateId, $path){
            $areas=$this->getAreasTable($path);
            $this->begin();
            for($i=0; $i<count($areas); $i++){
                $query="INSERT INTO Predefined_Areas SET Area_Name='".$areas[$i]."', ID_Template='".$templateId."';";
                $add_area=mysqli_query($this->res, $query);
            }
            if(!$add_area){
                $this->rollback();
                return 0;
            }
            else{
                $this->commit();
                return 1;
            }
        }
        public function addTemplate($name){
            $sessionNumber=filter_input(INPUT_COOKIE, 'squick_cmsSession', FILTER_SANITIZE_MAGIC_QUOTES);
            $id=$this->selectUserIDBySession($sessionNumber);
            if($this->checkAdd($id, "Templates")){
                $pathToTemplate=$this->uploadTemplateOnServer($name);
                if($pathToTemplate!="0"){
                    $now=date('Y-m-d G:i:s');
                    $query="INSERT INTO Templates SET Name='".$name."', Add_Date='".$now."', ID_Creator='".$id."', Path='".$pathToTemplate."', At_Use='0';";
                    $this->begin();
                    $add_tem=mysqli_query($this->res, $query);
                    if(!$add_tem){
                        $this->rollback();
                        return 0;
                    }
                    else{
                        $this->commit();
                        $select="SELECT * FROM Templates WHERE Path='".$pathToTemplate."';";
                        $get_template_id=mysqli_fetch_array(mysqli_query($this->res, $select))["ID"];
                        return $this->addTemplateAreas($get_template_id, $pathToTemplate);
                    }
                }
                else return 0;
            }
            else return 0;
        }
    }
    $connector=new mysqlConnector();
    $connector->charset();
?>