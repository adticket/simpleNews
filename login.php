<?php

include "mysqlFunctions.php";

session_start();

$mysql = createMysqlConnection();



if(isset($_GET['login'])){
    $login = $_POST['email'];
    $password = $_POST['password'];

    if(filter_var($login, FILTER_VALIDATE_EMAIL)){
        $myquery = $mysql->prepare('SELECT * FROM users WHERE email = ?');
    } else {
        $myquery = $mysql->prepare('SELECT * FROM users WHERE username = ?');
    }

    $myquery->bind_param("s", $login);
    if($myquery->execute()) {
        $existinguser = $myquery->get_result();
        $user = $existinguser->fetch_assoc();
        $myquery->close();
    } else {
        $errorMessage = "Suche nach Nutzer fehlgeschlagen";
    }

    if($user != 0 && password_verify($password, $user["password"])) {
        $_SESSION['userid'] = $user['userID'];
        $_SESSION['username']=$user['username'];
        $errorMessage = "<p><div class='container d-flex justify-content-center'><h3>Herzlich Willkommen, " . $user['username'] . "!</h3></div></p>";
    } else {
        $errorMessage = "Nutzername oder Passwort inkorrekt!";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta charset="UTF-8">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Navigation</span>
        <div class="navbar-nav" id="navbarNav">
            <a class="nav-item nav-link" href="index.php">Startseite</a>
            <?php
            if(isset($_SESSION['username'])) {
                echo '<a class="nav-item nav-link" href="author.php">Eintrag verfassen</a>';
                echo '<a class="nav-item nav-link" href="editor.php">Eintrag bearbeiten</a>';
            }
            if(!isset($_SESSION['username'])){
                echo '<a class="nav-item nav-link active" href="login.php">Login</a>';
            } else {
                echo '<a class="nav-item nav-link active" href="logout.php">Logout</a>';
            }
            ?>
        </div>
    </nav>
</div>
<p></p>

<div class="container">
    <?php
    if(isset($errorMessage)){
        echo $errorMessage;
    }
    ?>
</div>

<?php
if(!isset($_SESSION['userid'])) {
    echo '
    <div class="container">
        <form action="?login=1" method="post">
            <div class="form-group">
                <label for="email">Benutzername oder E-Mail</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Login">
                <input type="button" class="btn btn-secondary" style="float: right" value="Registrieren" id="register">
            </div>
        </form>
    </div>';
}

/*
if(!isset($_SESSION['username'])){
    echo '
        <form class="container" action="register.php">
            <button type="submit" class="form-group btn btn-secondary">Registrieren</button>
        </form>';
} */
?>

<!-- registerform-Modal -->
<div class="modal" id="registermodal" role="diaglog" aria-hidden="true" tabindex="-1" style="overflow: auto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrieren</h5>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form action="register.php?register=1" method="post">
                    <div class="form-group">
                        <label for="firstname">Vorname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Nachname</label>
                        <input type="text" class="form-control" id="surname" name="surname" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Benutzername</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for='email'>E-Mail</label>
                        <input type="email" class="form-control validate" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="userpassword">Passwort</label>
                        <input type="password" class="form-control" id="userpassword" name="userpassword" size="20" required>
                    </div>
                    <div class="form-group">
                        <label for="userpasswordRepeat">Passwort</label>
                        <input type="password" class="form-control" id="userpasswordRepeat" name="userpasswordRepeat" size="20" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Registrieren">
                        <input type="button" class="close btn btn-danger" value="Abbruch" style="float: right">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>


<script>
    // Get the modal
    var modal = document.getElementById('registermodal');

    // Get the button that opens the modal
    var btn = document.getElementById("register");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var span1 = document.getElementsByClassName("close btn btn-danger")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    span1.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>