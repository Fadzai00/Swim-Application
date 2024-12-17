<?php
// Check for authentication and include functions file
include 'functions.php';

// Fetch users list
$users_result = fetch_all_users();

// Display the dashboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dash.php">Admin Dashboard</a></li>
            <li><a href="admin_dashboard.php"  class="active">User Management</a></li>
            <li><a href="admin_programs.php">User Programs</a></li>
            <li><a href="news_updates.php">News Updates</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h1>User Management</h1>
        <a href="create_user.php">Create New User</a>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['fname'] . ' ' . $user['lname']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a> | 
                        <a href="delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
