<?php
  session_start();
  if (!isset($_SESSION['success'])) {
    header('Location: signin.php');
  }
  else {
   header('Location: data.php'); 
  }

?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
       <title>Timesheet Journal</title>
       <link rel="stylesheet" href="style.css">

       <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
       <script src="main.js"></script>
 
</head>
   
    
    
    <footer>
        
    </footer>
</html>


