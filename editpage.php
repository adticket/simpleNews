<?php

include "mysqlFunctions.php";
include "sessionvalidation.php";

session_start();

$mysql = createMysqlConnection();

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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav" id="navbarNav">
            <ul class="navbar-nav">
                <a class="nav-item nav-link" href="index.php">Startseite</a>
                <?php
                if(isset($_SESSION['username'])) {
                    echo '<a class="nav-item nav-link" href="author.php">Eintrag verfassen</a>';
                    echo '<a class="nav-item nav-link active" href="editor.php">Eintrag bearbeiten</a>';
                }
                if(!isset($_SESSION['username'])){
                    echo '<a class="nav-item nav-link" href="login.php">Login</a>';
                } else {
                    echo '<a class="nav-item nav-link" href="logout.php">Logout</a>';
                }
                ?>
            </ul>
    </nav>
</div>

<p></p>

<?php
sessionValidation();

$id = $_POST['entryID'];
$result = $mysql->query("SELECT * FROM BlogEntries WHERE entryID = '$id'");
$entry = $result->fetch_assoc();

echo '
    <div class="container">
        <h3>Eintrag bearbeiten</h3>
    </div>
    <div class="container">
        <form method="post" action="editentry.php">
            <div class="form-group">
                <input type="text" class="form-control" id="entrytitle" name="entrytitle" size="50" value="'. $entry['blogtitle'] . '" required>
            </div>
            <div class="form-group">
                <textarea type="comment" name="blogcontent" class="form-control" id="content" cols="50" rows="7" required>' . $entry["blogcontent"] . '</textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="action" value="Änderung speichern">
                <input type="submit" name="action" value="Änderung verwerfen">
                <input type="submit" name="action" value="Eintrag löschen">
            </div>
            <input type="hidden" name="entryID" value="' . $entry["entryID"] .'">
        </form>
    </div>';


?>

</body>
</html>
