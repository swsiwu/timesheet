<?php
  session_start();
  if (isset( $_SESSION['success'])){
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

    <header>
        <p>Timesheet</p>
    </header>

    <body>
        <div class="login" id='loginWindow'>

            <form id="login" method="POST">
                <fieldset>
                    <legend>Login</legend>
                    <!--<input type='hidden' name='submitted' id='submitted' value='1' />-->
                    <label for='username'>UserName *: </label>
                    <input type='text' name='username' id='username' maxlength="50" /><br>

                    <label for='password'>Password *: </label>
                    <input type='password' name='password' id='password' maxlength="50" />
                    <br>
                    <input type="submit" value="Login" id="submit"></input>
            </form>
            <!--<p id='loginMessage'>Login Status</p>-->
        </div>
        <br>
        <button id='createAccountButton'>Create Account</button>
        <button id='forgetPasswordButton'> Forget password</button>



        <div class='createAccount' id='createAccount'>
            <div class='createAccountContent'>
                <span class="close" id='close_ca'>&times;</span>
                <form id='createAccountForm'>
                    <label for='newUsername'>Username *:</label>
                    <input type='text' name='newUsername' id='newUsername' placeholder="username" required maxlength="50"></input><br>

                    <label for='newPassword'>Password *:</label>
                    <input type='password' name='newPassword' id='newPassword' placeholder="password" required maxlength="50" /><br>

                    <label for='comfirmPassword'>Confirm Password *:</label>
                    <input type='password' name='confirmPassword' id='confirmPassword' required placeholder="password" maxlength="50" /><br>

                    <label for='newEmail'>Email *:</label>
                    <input type='email' name='newEmail' id='newEmail' required placeholder="JohnSmith@wdc.com" maxlength="50" /><br>

                    <input type="submit" value="create account now" id="createAccountButton2"></input>
                    <input type="button" id='backToLogin' value="back" />

                </form>
            </div>
        </div>


        <div class='forgetPassword' id='forgetPassword'>
            <div class='forgetPasswordContent'>
                <span class="close" id='close_fp'>&times;</span>
                <form id="forgetPasswordForm">
                    <label for='getUsername'>Username *:</label>
                    <input type='text' name='username_fp' id='username_fp' placeholder='username' required maxlength="50" /><br>

                    <label for='getEmail'>Recovery email *:</label>
                    <input type='email' name='recoveryEmail' id='recoveryEmail' placeholder='johnsmith@wdc.com' required maxlength='50' /><br>

                    <input type='submit' value='get my account back' id='recovery_fp'>
            </div>
        </div>





    </body>

    <footer>

    </footer>

    </html>
