<?php
// Include database functions and fetch existing user data for editing
include 'functions.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = fetch_user_by_id($user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update user information
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $role = $_POST['role'];

        update_user($user_id, $fname, $lname, $role);
        header('Location: admin_dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="edit_user.php?id=<?php echo $user['user_id']; ?>">
        <input type="text" name="fname" value="<?php echo $user['fname']; ?>" required><br>
        <input type="text" name="lname" value="<?php echo $user['lname']; ?>" required><br>
        <select name="role" required>
            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
        </select><br>
        <button type="submit">Update User</button>
    </form>
</body>
</html>
