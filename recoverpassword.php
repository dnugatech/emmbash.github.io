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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1ad9b71575.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Recover Password</title>
    <style>
        *{
    font-family: 'Montserrat', sans-serif;
}
.register{
    background: white;
    height: 800px;
    width: 550px;
    box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.474);
    justify-content: center;
    align-items: center;
}
img{
    height: 35px;
    width: 161.43px;
    top: 65px;
    left: 100px;
    padding-left: 2rem;
    padding-top: 2rem;
}
input{
    width: 350px;
    height: 2rem;
    margin-bottom: 1rem;
    margin-left: 6.2rem;
    border-radius: 5px;
    outline: none;
    border: 1px solid #112378;
    background: white;
   
}
input::placeholder{
    padding-left: 1rem;
    font-size: 100%;
    color: black;
}
input::selection{
    padding-left: 1rem;
    font-size: 140%;
}
input:focus{
    border-bottom: 2px solid black;
    outline: none;
}
button{
    width: 350px;
    height: 2rem;
    margin-left: 6.3rem;
    background-color: white;
    color: black;
    border: 1px solid #112378;
    border-radius: 25px;
    margin-bottom: 1rem;
}
.signup{
    background: #112378;
    color: white;
}
body{
    display: flex;
    margin-top: 4rem;
    justify-content: center;
    height: 100vh;
    width: 100vw;
    background: whitesmoke;
    
}
h2{
    color: #000000;
    padding-top: 1rem;
    justify-content: center;
    text-align: center;
}
button:hover{
    color: #968E8E;
    background: azure;
}
    </style>
</head>
<body>
    <form action="">
        <div class="register">
            <img src="./Spendy Logo.png" alt="">
        <h2><b>Recover your password</b></h2>
        <input type="email" placeholder="Email Address or Phone Number"><br>
        <button class="signup">Send password link</button>
        <button>Cancel</button>
    </div>
    </form>
</body>
</html>