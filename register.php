<?php

include "mysqlFunctions.php";

session_start();

$mysql = createMysqlConnection();
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


<?php
if(isset($_GET['register'])) {
    $inputerror = false;
    $email = $_POST['email'];
    $userpassword = $_POST['userpassword'];
    $userpasswordRepeat = $_POST['userpasswordRepeat'];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo '<div class="container">Ungültige E-Mail-Adresse!</div>';
        echo "<div class='container'>Bitte versuchen Sie es erneut!</div><div class='container'>Zurück zum <a href='login.php'>Login</a></div>";
        $inputerror = true;
    }

    if(strlen($userpassword) == 0){
        echo '<div class="container">Bitte Passwort eingeben!</div>';
        echo "<div class='container'>Bitte versuchen Sie es erneut!</div><div class='container'>Zurück zum <a href='login.php'>Login</a></div>";
        $inputerror = true;
    }

    if($userpassword != $userpasswordRepeat){
        echo '<div class="container">Passwörter stimmen nicht überein!</div>';
        echo "<div class='container'>Bitte versuchen Sie es erneut!</div><div class='container'>Zurück zum <a href='login.php'>Login</a></div>";
        $inputerror = true;
    }

    if(!$inputerror) {
        $myquery = $mysql->prepare('SELECT * FROM users WHERE email = ?');
        $myquery->bind_param("s", $email);
        $result = $myquery->execute();
        $existinguser = $myquery->fetch();
        $myquery->close();


        if ($existinguser != 0) {
            echo '<div class="container">Zu dieser E-Mail-Adresse existiert bereits ein Account!</div>';
            echo "<div class='container'>Bitte versuchen Sie es erneut!</div><div class='container'>Zurück zum <a href='login.php'>Login</a></div>";
            $inputerror = true;
        }
    }

    if(!$inputerror) {
        $myquery = $mysql->prepare('SELECT * FROM users WHERE username = ?');
        $myquery->bind_param("s", $username);
        $result = $myquery->execute();
        $existinguser = $myquery->fetch();
        $myquery->close();

        if ($existinguser != 0) {
            echo '<div class="container">Der Username existiert bereits!</div>' . $existinguser['userID'];
            $inputerror = true;
        }
    }

    if(!$inputerror){
        $userpasswordHash = password_hash($userpassword, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password, firstname, surname, username) VALUES ('$email', '$userpasswordHash', '$firstname', '$surname', '$username')";

        if(mysqli_query($mysql, $sql)) {
            echo "<div class='container'>Erfolgreich registriert!</div><div class='container'>Weiter zum <a href='login.php'>Login</a></div>";
        } else {
            echo "<div class=\"container\">Bei der Registrierung ist ein Fehler aufgetreten: <br>" . mysqli_error($mysql) . "</div>";
        }
    }
}

?>

</body>
</html>