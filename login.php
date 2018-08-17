<?php

   session_start();

   ini_set("display_errors",1);
   error_reporting(-1);
   $dsn = "mysql:host=**.**.**.**;dbname=timesheet";
   $charset= 'utf8mb4';
   $host = 'localhost';
   $dbuser = '***';
   $db = 'timesheet';
   $dbpass = '***';

 try {
   $pdo = new PDO("mysql:host=**.**.**.**;dbname=timesheet", $dbuser,$dbpass);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   if ( !CheckLogin($pdo) ) {
     http_response_code(403);
   }
   else {
     http_response_code(200);
   }

   }
 

 catch (PDOException $e)
 {
   echo 'Connection failed: ' . $e->getMessage();
 }


 function CheckLogin( $pdo ) {


     if ( empty($_POST['username']) )
     {
         HandleError("UserName is empty!<br>");
         return false;
     }

     if( empty($_POST['password']))
     {
         HandleError("Password is empty!<br>");
         return false;
     }
     
     $username = trim($_POST['username']);
     $password = trim($_POST['password']);
    // echo "<pre>";
    // print_r( $_POST);
     //die();

     $query="SELECT * from timesheet.users";

     
     foreach($pdo->query($query) as $row) {
         if ( $row[0] == $username ){
        

             if ( $row[1] == sha1($password) )  {
              
                 $_SESSION['user'] = $username;
                
                 $_SESSION['success'] = "ok!";
                 return true;
             }
       }

     }
     return false;

 
 }

 function HandleError( $message ) {
     echo json_encode($message);
 }


?>
