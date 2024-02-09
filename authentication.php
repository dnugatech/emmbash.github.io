<?php
// authentication.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect form data
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $phonenumber = $_POST["phonenumber"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate input (you should add more validation)
    if (empty ($firstname) || empty ($lastname) || empty($phonenumber) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Hash the password (use password_hash() in a real-world scenario)
        $hashedPassword = md5($password);

        // Connect to your database (replace these values)
        include('config.php');

        try {
            $connection = new PDO("mysql:hostname=$localhost;database=$spendy", $email, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert user data into the database
            $stmt = $connection->prepare("INSERT INTO spendylogin (firstname, lastname, email, phonenumber, password) VALUES (:firstname, :lastname, :phonenumber, :email, :password)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phonenumber', $phonenumber);
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

