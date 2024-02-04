<?php

//Connection to database
include('config.php');  // Include a file with your database credentials

$connection = new mysqli($hostname, $username, $password, $database);

if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}
echo 'Connected successfully';

$columnValue = 'some_value';  // Replace with the actual value you're searching for

$stmt = $connection->prepare("SELECT * FROM spendylogin WHERE 'fullnames' = ?");
$stmt->bind_param("s", $columnValue);  // Use "s" for string, "i" for integer, etc.
$stmt->execute();
$result = $stmt->get_result();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your POST request handling code here
}






// ?>

