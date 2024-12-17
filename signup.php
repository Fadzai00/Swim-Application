<?php
// Include the configuration to establish a database connection
include 'config_.php';

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Check if the request method is POST (to handle form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data (no need for JSON when using POST)
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check that no fields are empty
    if (empty($username) || empty($fname) || empty($lname) || empty($email) || empty($password)) {
        echo "<script>alert('Empty field detected! Complete Signup Form.');</script>";
        exit();
    }

    // Check if email already exists
    $query = 'SELECT user_id FROM users WHERE email = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result1 = $stmt->get_result();
    if ($result1->num_rows > 0) {
        echo "<script>alert('Email already in use!');</script>";
        exit();
    }

    // Check if username already exists
    $query = 'SELECT user_id FROM users WHERE username = ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result2 = $stmt->get_result();
    if ($result2->num_rows > 0) {
        echo "<script>alert('Username already in use!');</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Set the default role to '1' (normal user)
    $role = '1';

    // Insert the user data into the database
    $qr = 'INSERT INTO users (username, fname, lname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($qr);
    $stmt->bind_param('ssssss', $username, $fname, $lname, $email, $hashed_password, $role);

    // Check if registration was successful
    if ($stmt->execute()) {
        // Redirect to the dashboard page after successful registration
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Could not register!');</script>";
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Your Application</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2>Register</h2>
            <!-- Form to send data to signup.php -->
            <form action="signup.php" method="POST">
                <div class="input-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" required>
                </div>
                <div class="input-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <button type="submit" class="btn">Register</button>
                </div>            
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
