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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="signup.css">
    <script src="https://kit.fontawesome.com/1ad9b71575.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
    <form action="">
        <div class="register">
            <img src="./Spendy Logo.png" alt="">
        <h2><b>Sign Up to start Shopping</b></h2>
        <h3>Create an account</h3>
    
        <input type="text" placeholder="First Name"><br>
        <input type="text" placeholder="Last Name"><br>
        <input type="email" placeholder="Email Address"><br>
        <input type="tel" placeholder="Phone Number"><br>
        <input type="password" placeholder="Password"><br>
        <button class="signup">Sign Up</button>
        <h3>OR</h3>
        <button><i class="fa-brands fa-google" style="color: #112378;"></i>  Sign Up with Google</button>
        <button><i class="fa-brands fa-facebook" style="color: #112378;"></i>  Sign Up with Facebook</button>
        <button><i class="fa-brands fa-apple" style="color: #112378;"></i>  Sign Up with Apple</button>
        <div class="anchor">
            
            <h4>Do you Already have an account?</h4>
            <a href="login.html"><h4>Sign in</h4></a>
        </div>
    </div>
    </form>
    


   
</body>
</html>
