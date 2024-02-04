<?php
// authentication.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect form data
    $fullnames = $_POST["fullnames"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate input (you should add more validation)
    if (empty ($fullnames) || empty ($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Hash the password (use password_hash() in a real-world scenario)
        $hashedPassword = md5($password);

        // Connect to your database (replace these values)
        $hostname = 'localhost';
        $username = 'root';
        $email = '';
        $password = '';
        $database = 'spendy';

        try {
            $connection = new PDO("mysql:hostname=$localhost;database=$spendy", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert user data into the database
            $stmt = $connection->prepare("INSERT INTO spendylogin (fullnames, username, email, password) VALUES (:fullnames, :username, :email, :password)");
            $stmt->bindParam(':fullnames', $fullnames);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            echo "Signup successful!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        // Close the database connection
        $connection = null;
    }
}
?>

