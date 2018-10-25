<?php

include "mysqlFunctions.php";

session_start();

$mysql = createMysqlConnection();

if($_POST['action']=='Eintrag löschen'){
    deleteEntry($mysql, $_POST['entryID']);
} elseif ($_POST['action']=='Änderung speichern'){
    updateEntry($mysql, $_POST['entrytitle'], $_POST['blogcontent'], $_POST['entryID']);
}


$mysql->close();

header('Location: editor.php');
exit();
?>
