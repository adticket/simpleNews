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
    insertEntry($mysql, e($_POST['entrytitle']), e($_POST['blogcontent']), $_SESSION['username']);
}

$mysql->close();

header('Location: author.php');
exit();
?>