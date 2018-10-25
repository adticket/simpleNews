<?php

include "mysqlFunctions.php";

session_start();

$mysql = createMysqlConnection();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrieren</title>
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
                echo '<a class="nav-item nav-link" href="logout.php">Logout</a>';
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
        $inputerror = true;
    }

    if(strlen($userpassword) == 0){
        echo '<div class="container">Bitte Passwort eingeben!</div>';
        $inputerror = true;
    }

    if($userpassword != $userpasswordRepeat){
        echo '<div class="container">Passwörter stimmen nicht überein!</div>';
        $inputerror = true;
    }

    if(!$inputerror) {
        #echo '<div class="container">Alles richtig eingegeben</div>';
        $myquery = $mysql->prepare('SELECT * FROM users WHERE email = ?');
        $myquery->bind_param("s", $email);
        $result = $myquery->execute();
        $existinguser = $myquery->fetch();
        $myquery->close();


        if ($existinguser != 0) {
            echo '<div class="container">Zu dieser E-Mail-Adresse existiert bereits ein Account!</div>';
            $inputerror = true;
        }
    }

    if(!$inputerror) {
        #echo '<div class="container">Alles richtig eingegeben</div>';
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
        #echo '<div class="container">Yay, keine Fehler soweit.</div>';

        $userpasswordHash = password_hash($userpassword, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password, firstname, surname, username) VALUES ('$email', '$userpasswordHash', '$firstname', '$surname', '$username')";

        if(mysqli_query($mysql, $sql)) {
            echo "<div class=\"container\">Erfolgreich registriert!</div>";
        } else {
            echo "<div class=\"container\">Bei der Registrierung ist ein Fehler aufgetreten: <br>" . mysqli_error($mysql) . "</div>";
        }
    }
}
?>

<div class="container">
    <form action="?register=1" method="post">
        <div class="form-group">
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for='email'>E-Mail:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="userpassword">Passwort:</label>
            <input type="password" class="form-control" id="userpassword" name="userpassword" size="20" required>
        </div>
        <div class="form-group">
            <label for="userpasswordRepeat">Passwort:</label>
            <input type="password" class="form-control" id="userpasswordRepeat" name="userpasswordRepeat" size="20" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Registrieren">
        </div>
    </form>
</div>

</body>
</html>
