<?php

include "mysqlFunctions.php";

echo "Hallo Welt <br>";

$servername='127.0.0.1';
$serverusername='root';
$serverpassword='root';
$db='mydb';

$mysql = new mysqli($servername, $serverusername, $serverpassword, $db);

if($mysql->connect_error){
    die('Connection failed: ' . $mysql->connect_error);
} else {
    echo "Connected successfully to " . $db . "<br>";
}




$sql = "SELECT * FROM users";
$result = $mysql->query($sql);



if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "id: " . $row["userID"] . " - Username: " . $row["username"] . "<br>";
    }
} else {
    echo "0 results";
}

insertEntry($mysql, "Hallo", "Whats up?", "ME");


$mysql->close();

?>
