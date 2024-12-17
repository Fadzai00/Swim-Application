<?php
// Include database functions and check for form submission
include 'functions.php';

// Assuming you're receiving the data from the form via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Make sure password is taken securely
    $role = $_POST['role'];

    // Call create_user function to insert into the database
    create_user($fname, $lname, $email, $password, $role);

    // Redirect to another page or show success
    header('Location: admin_dashboard.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New User</title>
</head>
<body>
    <h1>Create New User</h1>
    <form method="POST" action="create_user.php">
    <input type="text" name="fname" placeholder="First Name" required><br>
    <input type="text" name="lname" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select><br>
    <button type="submit">Create User</button>
</form>

</body>
</html>
