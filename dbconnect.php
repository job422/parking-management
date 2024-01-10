<?php

function connectToDatabase() {
    // Replace these variables with your actual database credentials
    $host = 'localhost';
    $username = 'root';
    $password = 'marasigan';
    $database = 'parking_management';

    // Create connection
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

?>