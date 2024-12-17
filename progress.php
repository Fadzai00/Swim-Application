<?php
// Including the database connection and starting the session
include("config_.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'] ?? 'Guest';

// Fetch activities progress for the user securely
$sql = "SELECT activity_name, progress_level, category, description 
        FROM user_progress 
        INNER JOIN users ON user_progress.user_id=users.user_id
        WHERE user_progress.user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database preparation failed: " . $conn->error);  // Error handling for SQL preparation failure
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die("Error fetching data: " . $stmt->error);  // Error handling for execution failure
}
$activities = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Progress</title>
    <link rel="stylesheet" href="progress.css">
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo">aquaClub</div>
        <div class="user-profile">
            <img src="default-profile.png" alt="User Profile Picture" class="profile-picture">
            <p class="username"><?php echo htmlspecialchars($user_name); ?></p>
        </div>
        <ul class="menu">
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="schedules.php">Schedules</a></li>
            <li><a href="progress.php" class="active">Progress</a></li>
            <li><a href="programs.php">Programs</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Progress Container -->
    <div class="progress-container">
        <h1>Your Progress so far...</h1>

        <div class="progress-card-container">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $activity): ?>
                    <a href="activity_details.php?activity=<?php echo urlencode($activity['activity_name']); ?>">
                        <div class="progress-card">
                            <div class="circle" data-progress="<?php echo htmlspecialchars($activity['progress_level']); ?>"></div>
                            <h2><?php echo htmlspecialchars($activity['activity_name']); ?></h2>
                            <p><?php echo htmlspecialchars($activity['category']); ?></p>
                            <small><?php echo htmlspecialchars($activity['description']); ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No progress data available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Circle Progress Bar Logic
        document.addEventListener("DOMContentLoaded", function() {
            const circles = document.querySelectorAll('.circle');
            circles.forEach(circle => {
                const progress = circle.getAttribute('data-progress');
                circle.style.background = `conic-gradient(#007bff ${progress}%, #eee ${progress}% 100%)`;
                circle.innerText = progress + '%';
            });
        });
    </script>
</body>
</html>

<?php
// Close the database connection securely
$stmt->close();
$conn->close();
?>
