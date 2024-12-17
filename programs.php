<?php
include("config_.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch programs data
$sql = "SELECT program_id, Title, Description, ImageURL, AltText FROM programs";
$result = $conn->query($sql);

// Sidebar details (Replace with actual user session data or dummy data for testing)
session_start();
$profilepic_url = 'default-profile.png'; // Default profile picture
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs Feed</title>
    <link rel="stylesheet" href="programs.css">
    </head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">aquaClub</div>
            <div class="user-profile">
                <img src="<?php echo htmlspecialchars($profilepic_url); ?>" alt="User Profile Picture" class="profile-picture">
                <p class="username"><?php echo htmlspecialchars($username); ?></p>
            </div>
            <ul class="menu">
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="progress.php">Progress</a></li>
                <li><a href="programs.php" class="active">Programs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="programs-feed-container">
            <h1 class="page-title">Our Programs</h1>
            <div class="feed">
                <?php
                // Check if data exists
                if ($result->num_rows > 0) {
                    // Loop through the results and display them
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="feed-card">
                            <img src="' . htmlspecialchars($row['ImageURL']) . '" alt="' . htmlspecialchars($row['AltText']) . '" class="feed-image">
                            <div class="feed-content">
                                <h3 class="feed-title">' . htmlspecialchars($row['Title']) . '</h3>
                                <p class="feed-description">' . htmlspecialchars($row['Description']) . '</p>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo '<p>No programs available at the moment.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>
