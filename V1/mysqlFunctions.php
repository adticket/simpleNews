<?php

# Establish connection to database
function createMysqlConnection(){
    $servername = "127.0.0.1";
    $serverusername = "root";
    $serveruserpassword = "root";
    $serverdb = "mydb";

    $connection = new mysqli($servername, $serverusername, $serveruserpassword, $serverdb);

    if($connection->connect_error){
        die('Verbindung fehlgeschlagen: ' . $connection->connect_error);
    } else {
        return $connection;
    }
}

# Add new entry to database
function insertEntry($connection, $title, $content, $author){
    $date = new DateTime();
    $datetime = $date->format("Y-m-d H:i:s");

    if(!$connection->query("INSERT INTO BlogEntries (blogtitle, blogcontent, dateofentry, author) VALUES ('$title', '$content', '$datetime', '$author')")){
        die('Error occurred inserting entry');
    }
}

# Update/Change entry in database
function updateEntry($connection, $title, $content, $id){
    if(!$connection->query("UPDATE BlogEntries SET blogtitle = '$title', blogcontent= '$content' WHERE entryID = '$id'")){
        die('Error occurred updating entry');
    }
}

# Delete entry from database
function deleteEntry($connection, $id){
    if(!$connection->query("DELETE FROM BlogEntries WHERE entryID = '$id'")){
        die('Error occurred deleting entry');
    }
}

function getEntries($connection){
    return $connection->query("SELECT * FROM BlogEntries");
}

function getEntriesByAuthor($connection, $author){
    return $connection->query("SELECT * FROM BlogEntries WHERE author='$author'");
}
?>