<?php
// Include database connection file (modify the connection details accordingly)
include('db_connection.php');

// Initialize variables
$email = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $email = $_POST['email'];

    // Validation (add more validation as needed)
    if (empty($email)) {
        $errors[] = 'Email is required.';
    }

    // If no validation errors, proceed with password reset
    if (empty($errors)) {
        // Check if the email exists in the database
        $sql = "SELECT * FROM spendylogin WHERE email = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Generate a unique token for the reset link
            $token = bin2hex(random_bytes(32)); // Generate a random 32-byte hexadecimal string

            // Store the token in the database
            $sql = "UPDATE spendylogin SET reset_token = ? WHERE email = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('ss', $token, $email);
            $stmt->execute();

            // Send email with the reset link (implementation of email sending not included)
            // Example: mail($email, 'Password Reset', 'Reset link: http://example.com/reset.php?token=' . $token);

            echo "Password reset instructions sent to your email.";
        } else {
            $errors[] = 'Email not found.';
        }

        $stmt->close();
    }
}

// Close the database connection
$connection->close();
?>

