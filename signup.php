<?php
// Include database connection file (modify the connection details accordingly)
include('db_connection.php');

// Initialize variables
$email = $password = $firstname = $lastname = $phonenumber = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phonenumber = $_POST['phonenumber'];

    // Validation (add more validation as needed)
    if (empty($firstname) || empty($email) || empty($password) || empty($lastname) || empty($phonenumber)) {
        $errors[] = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Password and confirm password do not match.';
    }

    // If no validation errors, proceed with signup
    if (empty($errors)) {
        // Hash the password (use password_hash() in a real-world scenario)
        $hashedPassword = md5($password);

        // Insert user data into the database
        $sql = "INSERT INTO spendylogin (email, firstname, lastname, phonenumber, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssssi', $email, $firstname, $lastname, $hashedPassword, $phonenumber);
        
        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            $errors[] = 'Error during signup.';
        }
        
        $stmt->close();
    }
}
// Close the database connection
$connection->close();
?>

