<?php

function sessionValidation()
{
    if (!isset($_SESSION['username'])) {
        echo "<br /><div class='container'><p>Zugriff verweigert!</p>";
        echo "Bitte zuerst <a href=\"login.php\">einloggen</a></div>";
        exit();
    }
}

?>