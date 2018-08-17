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
             //echo "'" . $row[0] . "'' - ''" . $username."'<br>";

             //echo "'" . $row[1] . "'' - ''" . $password."'<br>";

             if ( $row[1] == sha1($password) )  {
                 //echo json_encode( (string)trim($row[0]) == (string)trim($username) );
               //  print_r( $row[0]);
                 // print_r( $username);
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



     /*
//Query Database
if( $result = mysqli_query("SELECT * FROM timesheet.user WHERE username = '" . mysqli_real_escape( $_POST['username'] )  . "'") ) {
    //Render Database Result
    $user = mysqli_assoc( $result );
    
    //The User Exists, Check the Password
    if( $user['password'] == sha1( $_POST['password'] ) ) {
        
        //Valid User Authentication, Do Something
        return true;
    }
}

     echo json_encode("User name $username doesn't exist or password is inccorect <br>");
     return false;

}     
 function HandleError( $message ) {
     echo json_encode($message);
 }*/
?>
