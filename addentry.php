<?php

include "sessionvalidation.php";
include "mysqlFunctions.php";

session_start();

sessionValidation();

$user= $_SESSION['username'];

$mysql =  createMysqlConnection();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $datetime = new \DateTime();
    $datetime = $datetime->format('Y-m-d H:i:s');
    insertEntry($mysql, $_POST['entrytitle'], $_POST['blogcontent'], $_SESSION['username']);
}

$mysql->close();

header('Location: editor.php');
exit();
?>