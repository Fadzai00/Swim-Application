<?php
// Include your functions file
include 'functions.php';

// Fetch all programs
$programs_result = fetch_all_programs();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Programs</title>
    <link rel="stylesheet" href="admin_programs.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dash.php">Admin Dashboard</a></li>
            <li><a href="admin_programs.php" class = "active">User Programs</a></li>
            <li><a href="admin_dashboard.php">User Management</a></li>
            <li><a href="news_updates.php">News Updates</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>User Programs</h1>
        <a href="create_program.php">Create New Program</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($program = $programs_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($program['Title']); ?></td>
                    <td><?php echo htmlspecialchars($program['Description']); ?></td>
                    <td><?php echo htmlspecialchars($program['imageURL']); ?></td>
                    <td>
                        <a href="edit_programs.php?program_id=<?php echo $program['program_id']; ?>">Edit</a> |
                        <a href="delete_program.php?program_id=<?php echo $program['program_id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
