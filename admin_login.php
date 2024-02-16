<?php
session_start();

// Include database connection file (modify the connection details accordingly)
include('db_connection.php');

// Initialize variables
$email = $password = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Validation (add more validation as needed)
    if (empty($email) || empty($password)) {
        $errors[] = 'Email and password are required.';
    }

    // If no validation errors, proceed with login
    if (empty($errors)) {
        // Hash the password (use password_hash() in a real-world scenario)
        $hashedPassword = md5($password);

        // Check user credentials
        $sql = "SELECT * FROM spendylogin WHERE email = ? AND password = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ss', $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Check if the user is an administrator (you may have a separate column for admin role)
            $user = $result->fetch_assoc();
            if ($user['is_admin']) {
                // Admin login successful, store admin ID in session for future use
                $_SESSION['admin_id'] = $user['id'];
                header('Location: admin_dashboard.html'); // Redirect to admin dashboard
                exit;
            } else {
                $errors[] = 'You are not authorized to access the admin panel.';
            }
        } else {
            $errors[] = 'Invalid username or password.';
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
    <title>Admin Login</title>
    <style>
        *{
    font-family: 'Montserrat', sans-serif;
}
.register{
    background: #112378;
    height: 800px;
    width: 550px;
    box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.474);
    border-radius: 10px;
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
    border: 1px solid white;
    background: #112378;
   
}
input::placeholder{
    padding-left: 1rem;
    font-size: 100%;
    color: white;
}
input::selection{
    padding-left: 1rem;
    font-size: 140%;
}
input:focus{
    border-bottom: 2px solid white;
    outline: none;
}
button{
    width: 350px;
    height: 2rem;
    margin-left: 6.3rem;
    background-color: #112378;
    color: white;
    border: 1px solid white;
    border-radius: 25px;
    margin-bottom: 1rem;
}
.reg{
    padding-top: 5rem;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.signup{
    background: white;
    color: #112378;
}
body{
    display: flex;
    margin-top: 4rem;
    justify-content: center;
    height: 100vh;
    width: 100vw;
    background: whitesmoke;
    
}
h5{
    color: white;
    justify-content: center;
    text-align: center;
}
h2{
    color: white;
    padding-top: 1rem;
    justify-content: center;
    text-align: center;
}
h3{
    font-size: 110%;
    text-align: center;
    color: white;
}
h4{
    color: white;
}
.anchor{
    display: flex;
    justify-content: center;
}
a{
    margin-left: 0.5rem;
    margin-right: 0.5rem;
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
        <h2><b>Admin Login</b></h2>
        <input type="email" placeholder="Email Address or ID"><br>
        <input type="password" placeholder="Password"><br>
        <a href="dashboard.html"><button class="signup">Login</button></a>
        <a href="recoverpassword.php"><h5>Forgot your Password?</h5></a>
        <h3>OR</h3>
        <button><i class="fa-brands fa-google" style="color: white;"></i>  Sign Up with Google</button>
        <button><i class="fa-brands fa-facebook" style="color: white;"></i>  Sign Up with Facebook</button>
        <button><i class="fa-brands fa-apple" style="color: white;"></i>  Sign Up with Apple</button>
        <div class="anchor">
            
            <h4>Don't have an account?</h4>
            <a href="signup.php"><h4>Sign up</h4></a>
        </div>
    </div>
    </form>
</body>
</html>
