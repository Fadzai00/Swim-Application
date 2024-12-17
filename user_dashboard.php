<?php
// Include database connection
include('config_.php');

// Start session to get user information
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch logged-in user ID from session
$user_id = $_SESSION['user_id'];

// Query to fetch dashboard data for the user
$sql = "
SELECT 
    d.WelcomeMessage, 
    d.profilepic_url, 
    d.NewsTitle, 
    d.NewsContent, 
    d.NewsImage, 
    d.NewsLink, 
    d.LastUpdated, 
    u.username
FROM userdashboard d
INNER JOIN users u ON u.user_id = d.user_id 
WHERE d.user_id = ?
ORDER BY d.LastUpdated DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Default values if no data is available
$welcomeMessage = "Welcome to your Dashboard!";
$profilePicUrl = "default-profile.png";
$newsData = [];

// Fetch WelcomeMessage, profile picture, and news articles
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (empty($welcomeMessage)) {
            $welcomeMessage = $row['WelcomeMessage'];
        }
        if (empty($profilePicUrl)) {
            $profilePicUrl = $row['profilepic_url'];
        }
        $newsData[] = [
            'NewsTitle' => $row['NewsTitle'],
            'NewsContent' => $row['NewsContent'],
            'NewsImage' => $row['NewsImage'] ?? 'default-news.jpg', // Default image if none provided
            'NewsLink' => $row['NewsLink'] ?? '#'
        ];
    }
}

// Fetch the user's username
$username = $_SESSION['username']; // Ensure this is set during login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dash.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Top Welcome Section -->
        <header class="welcome-header">
            <!-- Display the logged-in user's name dynamically -->
            <h1>Welcome, <span class="username"><?php echo htmlspecialchars($username); ?></span>!</h1>
            <p><?php echo htmlspecialchars($welcomeMessage); ?></p>
        </header>

        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">aquaClub</div>
            <div class="user-profile">
                <img src="<?php echo htmlspecialchars($profilePicUrl); ?>" alt="User Profile Picture" class="profile-picture">
                <!-- Display username dynamically -->
                <p class="username"><?php echo htmlspecialchars($username); ?></p>
            </div>
            <ul class="menu">
                <li><a href="user_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="progress.php">Progress</a></li>
                <li><a href="programs.php">Programs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <section class="news-updates-section">
                <h2>Latest Swimming News</h2>
                <div class="news-container">
                    <?php if (!empty($newsData)) { ?>
                        <?php foreach ($newsData as $news) { ?>
                            <article class="news-item">
                                <img src="<?php echo htmlspecialchars($news['NewsImage']); ?>" alt="News Image" class="news-image">
                                <h3><?php echo htmlspecialchars($news['NewsTitle']); ?></h3>
                                <p><?php echo htmlspecialchars($news['NewsContent']); ?></p>
                                <a href="<?php echo htmlspecialchars($news['NewsLink']); ?>">Read more...</a>
                            </article>
                        <?php } ?>
                    <?php } else { ?>
                        <p>No news updates available.</p>
                    <?php } ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
