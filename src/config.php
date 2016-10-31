<?php

function getDbConnection() {
    $host = "localhost";
    $username = "twitter";
    $password = "W94HjNDKh7kbMgDY";
    $database = "twitter_db";

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error){
        echo "Wystąpił błąd przy połączeniu. $connection->connect_error";
        die;
    } 
    return $connection;
}