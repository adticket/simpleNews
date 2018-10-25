<?php

include "sessionvalidation.php";

session_start();

$user = $_SESSION['username'];

?>

<html>
<head>
    <title>Einträge bearbeiten</title>
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
                echo '<a class="nav-item nav-link active" href="author.php">Eintrag verfassen</a>';
                echo '<a class="nav-item nav-link" href="editor.php">Eintrag bearbeiten</a>';
            }
            if(!isset($_SESSION['username'])){
                echo '<a class="nav-item nav-link" href="login.php">Login</a>';
            } else {
                echo '<a class="nav-item nav-link" href="logout.php">Logout</a>';
            }
            ?>
        </div>
    </nav>
</div>

<?php
sessionValidation();
?>

<div class="container">
    <p><h1>Hallo <?php echo $user ?>!</h1></p>
</div>

<div class="container">
    <form method="post" action="addentry.php">
        <div class="form-group">
            <label for="entrytitle">Schlagzeile</label>
            <input type="text" class="form-control" id="entrytitle" name="entrytitle" size="50" required>
        </div>
        <div class="form-group">
            <label for="content">Artikel</label>
            <textarea type="comment" name="blogcontent" class="form-control" id="content" cols="50" rows="7" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Eintrag erstellen">
        </div>
    </form>
</div>

</body>
</html>
