window.onload = function () {
    document.getElementById("submit").addEventListener("click", regularLogin);
    document.getElementById("createAccountButton").addEventListener("click", createAccount);
    document.getElementById("forgetPasswordButton").addEventListener("click", forgetPassword);
    document.getElementById("backToLogin").addEventListener("click", backToLogin);
    document.getElementById('close_ca').addEventListener("click", backToLogin);
    document.getElementById('close_fp').addEventListener("click", backToLogin);
    document.getElementById("createAccountButton2").addEventListener("click", createAccountAction);
}



function regularLogin(e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    var username = document.getElementById('username').value;
    var pass = document.getElementById('password').value;
    var vars = "username=" + username + "&password=" + pass;

    if (username == '') {
        alert('Please enter username!');
        return false;
    }
    if (pass == '') {
        alert('Please enter password!');
        return false;
    }
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.status == 200 && this.readyState == 4) {

            window.location = "http://**.**.**.**/data.php";
        } else if (this.status == 403) {
            alert('Username does not exist, or wrong password');
        }
    }

    xhr.send(vars);

}


function createAccount(e) {
    e.preventDefault();
    //removeLoginPage();
    document.getElementById('createAccount').style.display = 'block';
}

function createAccountAction(e) {
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    var newUsername = document.getElementById('newUsername').value;

    var newPassword = document.getElementById('newPassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (confirmPassword != newPassword) {
        alert("Password entries don't match!");
        return false;
    }

    var newEmail = document.getElementById('newEmail').value;
    var vars = "newUsername=" + newUsername + "&newPassword=" + newPassword + "&newEmail=" + newEmail;

    xhr.open('POST', 'createAccount.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.status == 200 && this.readyState == 4) {
            alert('create account successfully');
        } else if (this.status == 403) {
            alert('something is wrong');
        }
    }
    xhr.send(vars);





}
