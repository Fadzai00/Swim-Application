<?php
// Include functions file for database connections and functions
include 'functions.php';

// Fetch all news from the database
$news_result = fetch_all_news();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News Updates</title>
    <link rel="stylesheet" href="news_updates.css"> <!-- Use the same CSS styling for consistency -->
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
            <li><a href="admin_programs.php">User Programs</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="news_update.php" class="active">News Updates</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>News Updates</h1>
        
        <!-- Form for Adding News -->
        <form action="add_news.php" method="POST">
            <label for="news_title">News Title:</label>
            <input type="text" name="news_title" id="news_title" required><br>
            
            <label for="news_content">News Content:</label>
            <textarea name="news_content" id="news_content" required></textarea><br>
            
            <button type="submit">Add News</button>
        </form>
        
        <!-- Table to Display All News -->
        <table>
            <thead>
                <tr>
                    <th>News Title</th>
                    <th>News Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($news = $news_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($news['NewsTitle']); ?></td>
                    <td><?php echo htmlspecialchars($news['NewsContent']); ?></td>
                    <td>
                        <a href="edit_news.php?dashboard_id=<?php echo $news['dashboard_id']; ?>">Edit</a> |
                        <a href="delete_news.php?dashboard_id=<?php echo $news['dashboard_id']; ?>" onclick="return confirm('Are you sure you want to delete this news?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
