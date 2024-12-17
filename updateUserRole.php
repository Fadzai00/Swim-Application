<?php
// Include database functions and check for form submission
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs to prevent SQL injection (assuming you're using mysqli prepared statements elsewhere)
    $user_id = (int)$_POST['user_id']; // Sanitize user_id as an integer
    $new_role = $_POST['role']; // Assume role is either 'admin' or 'user'; consider adding further validation if there are more roles

    // Ensure a valid role is chosen
    if (in_array($new_role, ['admin', 'regular'])) {
        // Update the user role in the database
        if (update_role($conn, $user_id, $new_role)) {
            // Redirect back to the admin dashboard
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo "Failed to update the role! Please try again.";
        }
    } else {
        echo "Invalid role selected!";
    }
}

// Fetch user details based on user_id (usually passed as GET)
if (isset($_GET['user_id'])) {
    $user_id = (int)$_GET['user_id']; // Sanitize user_id as an integer
    $user = get_user_by_id($user_id); // Assuming this function fetches user data by user_id

    // If no user is found
    if (!$user) {
        echo "No user found with that ID.";
        exit();
    }
} else {
    echo "No user ID specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User Role</title>
</head>
<body>
    <h1>Update User Role</h1>

    <h2>Update Role for <?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname'], ENT_QUOTES, 'UTF-8'); ?></h2>

    <form method="POST" action="update_user_role.php">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8'); ?>">

        <label for="role">Select New Role:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            <option value="regular" <?php if ($user['role'] === 'regular') echo 'selected'; ?>>Regular</option>
            <!-- Add other roles here if needed -->
        </select><br>

        <button type="submit">Update Role</button>
    </form>

    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php
// Include footer or additional scripts if necessary.
include 'footer.php';  // Optional, for common footers or scripts.
?>
