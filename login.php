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
        $errorMessage = "Login erfolgreich!";
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
    ?>
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
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    <?php
}

if(!isset($_SESSION['username'])){
?>

<form class="container" action="register.php">
    <button type="submit" class="form-group">Registrieren</button>
</form>

<?php } ?>

</body>
</html>
