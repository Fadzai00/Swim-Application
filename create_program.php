<?php
// Include functions file
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Program</title>
    <link rel="stylesheet" href="create_program.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dash.php">Admin Dashboard</a></li>
            <li><a href="admin_programs.php">User Programs</a></li>
            <li><a href="admin_dashboard.php">User Management</a></li>
            <li><a href="news_updates.php">News Updates</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Add Program</h1>
        <form action="create_program.php" method="POST">
            <label for="title">Program Title:</label>
            <input type="text" name="Title" id="Title" required /><br>
            <label for="description">Description:</label>
            <textarea name="Description" id="Description" required></textarea><br>
            <label for="image_url">Image URL:</label>
            <input type="text" name="imageURL" id="imageURL" required /><br>
            <button type="submit">Add Program</button>
        </form>
    </div>
</body>
</html>
