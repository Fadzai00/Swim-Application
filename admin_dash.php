<?php
// Include database connection and functions
include 'functions.php';

// Query to fetch user analytics
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$activeUsersQuery = "SELECT COUNT(*) AS active_users FROM users WHERE status = 'active'";
$inactiveUsersQuery = "SELECT COUNT(*) AS inactive_users FROM users WHERE status = 'inactive'";

// Execute the queries
$totalUsersResult = $conn->query($totalUsersQuery);
$activeUsersResult = $conn->query($activeUsersQuery);
$inactiveUsersResult = $conn->query($inactiveUsersQuery);

// Fetch counts
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];
$activeUsers = $activeUsersResult->fetch_assoc()['active_users'];
$inactiveUsers = $inactiveUsersResult->fetch_assoc()['inactive_users'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dash.css"> <!-- Link to admin stylesheet -->
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dash.php" class="active">Admin Dashboard</a></li>
            <li><a href="admin_programs.php">User Programs</a></li>
            <li><a href="admin_dashboard.php">User Management</a></li>
            <li><a href="news_updates.php">News Updates</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Admin Dashboard</h1>
        <div class="analytics-cards">
            <!-- Total Users Card -->
            <div class="card">
                <h2>Total Users</h2>
                <p><?php echo $totalUsers; ?></p>
            </div>

            <!-- Active Users Card -->
            <div class="card">
                <h2>Active Users</h2>
                <p><?php echo $activeUsers; ?></p>
            </div>

            <!-- Inactive Users Card -->
            <div class="card">
                <h2>Inactive Users</h2>
                <p><?php echo $inactiveUsers; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
