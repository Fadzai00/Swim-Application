<?php
session_start();
include 'config_.php';  // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        $query = 'SELECT user_id, password, username, role, fname FROM users WHERE email = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['fname'] = $row['fname'];  // Store first name for the dashboard greeting
                
                // Debug: Uncomment below line to print session variables for verification (remove in production)
                // echo '<pre>'; print_r($_SESSION); echo '</pre>';

                if ($row['role'] === 'admin') {
                    header('Location: admin_dash.php');  // Redirect to admin dashboard
                    exit();
                } else {
                    header('Location: user_dashboard.php');  // Redirect to user dashboard
                    exit();
                }
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "No user found with that email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Your Application</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <!-- Add 'action' to direct form submission to this same PHP file -->
            <form action="login.php" method="POST" id="loginForm">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <button type="submit" id="submit" class="btn">Login</button>
                </div>
                
                <!-- Display error messages if there is any -->
                <?php if (isset($error_message)): ?>
                    <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
