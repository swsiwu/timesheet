<?php
   session_start();
   ini_set("display_errors",1);
   error_reporting(-1);
   $dsn = "mysql:host=**.**.**.**;dbname=timesheet";
   $charset='utf8mb4';
   $host = 'localhost';
   $dbuser = '***';
   $db = 'timesheet';
   $dbpass = '***';

try {
   $pdo = new PDO("mysql:host=**.**.**.**;dbname=timesheet", $dbuser, $dbpass);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   //echo "hello world!";
   //$var = createAccount($pdo) ;
   //print_r( gettype( $var ));
   //print_r( $var === false ? "false": "true" );
   //die();
   if ( createAccount($pdo) == false ) {
       http_response_code(403);
   
   }

   else {
       http_response_code(200);

   }
}

catch (PDOException $e){
   echo 'Connection failed: ' . $e->getMessage();
}

function createAccount( $pdo ) {
 /*  if (empty( $_POST('newUsername'))){
     return false;
   }

   if (empty( $_POST('newPassword'))){
     return false;
   }

   if (empty( $_POST('newEmail'))){
     return false;
   }
  */
   $username = trim($_POST['newUsername']);
   $password = trim($_POST['newPassword']);
   $email = trim($_POST['newEmail']);

   // if username exist already
   $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:username");
   $stmt->bindParam(':username', $username, PDO::PARAM_STR);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
     return false;
   }


   // if email exist already
   $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:newEmail");
   $stmt->bindParam(':newEmail', $email, PDO::PARAM_STR);
   $stmt->execute();
   if ($stmt->rowCount() >0){
      return false;
   }

   //TODO remind user that the email already exists

   // put the new user in the databse
   //$stmt = $pdo->prepare("INSERT INTO timesheet.users values( :username, :password, :email)");
   
   //$stmt = $pdo->prepare("INSERT INTO users where username=:username, password=:password, email=:email");
   $stmt = $pdo->prepare("insert into timesheet.users(username, password, email) VALUES(:username, :password, :email)");
   $stmt->execute(array('username' => $username, 'password' => sha1($password), 'email' => $email));

   //create a table for that user for storing login-logout stats
   $stmt = $pdo->prepare("CREATE TABLE :username (date_of_record DATE NOT NULL, come_time TIME(2), leave_time TIME(2), PRIMARY KEY(date_of_record))");
   $stmt->bindParam(':username', $username, PDO::PARAM_STR);
   $stmt->execute();

   /*
   $stmt->bindParam(':username', $username, PDO::PARAM_STR);
   $stmt->bindValue(':password', sha1($password), PDO::PARAM_STR);
   $stmt->bindParam(':email',    $email, PDO::PARAM_STR);
   $stmt->execute(); */
   return true;
}

?>
