<?php
// Start the session to access user-specific data
session_start();

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit;
}

// Include the database configuration file
include('config_.php');

// Fetch the logged-in user's details
$user_query = "SELECT username, profilepic_url FROM users WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_row = mysqli_fetch_assoc($user_result)) {
    $username = $user_row['username'] ?? 'User';
    $profilepic_url = $user_row['profilepic_url'] ?? 'default_profile.jpg';
} else {
    // Fallback values in case user is not found
    $username = 'User';
    $profilepic_url = 'default_profile.jpg';
}

// Fetch weekly schedules
$weekly_schedule = [];
$selected_day = $_GET['day'] ?? null;

// Fetch schedules for specific or all days
if ($selected_day) {
    $query = "SELECT * FROM schedules WHERE day = '$selected_day' AND user_id = '$user_id' ORDER BY schedule_id";
} else {
    $query = "SELECT * FROM schedules WHERE user_id = '$user_id' ORDER BY day, schedule_id";
}

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $weekly_schedule[$row['day']][] = $row;
}

// Handle actions (Create, Update, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $schedule_id = $_POST['schedule_id'] ?? null;
    $day = $_POST['day'] ?? null;
    $activity = $_POST['activity'] ?? null;
    $new_activity = $_POST['new_activity'] ?? null;

    if ($action === 'create' && $day && $activity) {
        $insert_query = "INSERT INTO schedules (user_id, day, activity, created_at, updated_at) VALUES ('$user_id', '$day', '$activity', NOW(), NOW())";
        mysqli_query($conn, $insert_query);
    }

    if ($action === 'delete' && $schedule_id) {
        $delete_query = "DELETE FROM schedules WHERE schedule_id = '$schedule_id'";
        mysqli_query($conn, $delete_query);
    }

    if ($action === 'update' && $schedule_id && $new_activity) {
        $update_query = "UPDATE schedules SET activity = '$new_activity', updated_at = NOW() WHERE schedule_id = '$schedule_id'";
        mysqli_query($conn, $update_query);
    }

    header("Location: schedules.php?day=$day");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
    <link rel="stylesheet" href="schedules.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">aquaClub</div>
            <div class="user-profile">
                <!-- Dynamically display profile picture and username -->
                <img src="<?= htmlspecialchars($profilepic_url) ?>" alt="User Profile Picture" class="profile-picture">
                <p class="username"><?= htmlspecialchars($username) ?></p>
            </div>
            <ul class="menu">
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="schedules.php" class="active">Schedules</a></li>
                <li><a href="progress.php">Progress</a></li>
                <li><a href="programs.php">Programs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Your Weekly Schedule</h1>
                <p>Edit, add, or delete your activities for the week.</p>
            </div>

            <!-- Day Selection Form -->
            <form method="GET">
                <label for="day-select">Choose a day:</label>
                <select name="day" id="day-select" onchange="this.form.submit()">
                    <option value="">-- Select a Day --</option>
                    <?php 
                    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    foreach ($days as $day) {
                        $selected = $selected_day == $day ? 'selected' : '';
                        echo "<option value='$day' $selected>$day</option>";
                    }
                    ?>
                </select>
            </form>

            <!-- Weekly Schedule Display -->
            <div class="schedule">
                <?php if (!empty($weekly_schedule)): ?>
                    <?php foreach ($weekly_schedule as $day => $activities): ?>
                        <div class="day">
                            <h3><?= htmlspecialchars($day) ?></h3>
                            <ul>
                                <?php foreach ($activities as $activity): ?>
                                    <li>
                                        <?= htmlspecialchars($activity['activity']) ?>
                                        <div class="activity-buttons">
                                            <!-- Delete Form -->
                                            <form method="POST">
                                                <input type="hidden" name="schedule_id" value="<?= $activity['schedule_id'] ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button class="delete-button" type="submit">Delete</button>
                                            </form>

                                            <!-- Update Form -->
                                            <form method="POST">
                                                <input type="hidden" name="schedule_id" value="<?= $activity['schedule_id'] ?>">
                                                <input type="hidden" name="action" value="update">
                                                <input type="text" name="new_activity" placeholder="Edit activity" required>
                                                <button class="update-button" type="submit">Update</button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Add Activity Form -->
                            <form method="POST">
                                <input type="hidden" name="day" value="<?= htmlspecialchars($day) ?>">
                                <input type="hidden" name="action" value="create">
                                <input type="text" name="activity" placeholder="Add activity" required>
                                <button class="add-button" type="submit">Add</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No activities scheduled yet. Add one now!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
