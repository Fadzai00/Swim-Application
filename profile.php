<?php
include("config_.php");
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Fetch logged-in user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "
    SELECT 
        u.user_id,
        u.username,
        u.fname AS first_name,
        u.lname AS last_name,
        u.profilepic_url,
        p.CreationDate,
        p.LastUpdated
    FROM users u
    INNER JOIN profiles p ON u.user_id = p.user_id
    WHERE u.user_id = '$user_id'
";

$result = mysqli_query($conn, $sql);
if ($result) {
    $user = mysqli_fetch_assoc($result);

    // Assign fetched details to variables
    $username = $user['username'];
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $profilepic_url = $user['profilepic_url'];
    $creation_date = $user['CreationDate'];
    $last_updated = $user['LastUpdated'];
} else {
    echo "Error fetching user details.";
    exit();
}

// Process form submission if any
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new values from the form
    $new_username = $_POST['username'];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];

    // Update the user's profile in the database
    $update_sql = "
        UPDATE users 
        SET username = '$new_username', fname = '$new_first_name', lname = '$new_last_name' 
        WHERE user_id = '$user_id'
    ";

    // Update the last updated date in the profile table
    $update_profile_sql = "
        UPDATE profiles 
        SET LastUpdated = NOW() 
        WHERE user_id = '$user_id'
    ";

    // Run the update queries
    mysqli_query($conn, $update_sql);
    mysqli_query($conn, $update_profile_sql);

    // Redirect back to the profile page after updating
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">aquaClub</div>
            <div class="user-profile">
                <img src="<?php echo htmlspecialchars($profilepic_url); ?>" alt="User Profile Picture" class="profile-picture">
                <p class="username"><?php echo htmlspecialchars($username); ?></p>
            </div>
            <ul class="menu">
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="schedules.php">Schedules</a></li>
                <li><a href="progress.php">Progress</a></li>
                <li><a href="programs.php">Programs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Profile Content -->
        <div class="main-profile-content">
            <div class="header">
                <h1>Hello, <span class="username"><?php echo htmlspecialchars($first_name); ?></span>!</h1>
                <p>This is your profile page. You can see the progress you've made with your work and manage your projects or assigned tasks.</p>
                <button class="edit-profile-btn" onclick="toggleEdit()">Edit Profile</button>
            </div>

            <!-- User Information Section -->
            <div class="user-info">
                <h2>My Account</h2>
                <form method="POST" id="edit-form">
                    <div class="info-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="creation-date">Account Created</label>
                            <input type="text" id="creation-date" value="<?php echo htmlspecialchars($creation_date); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="last-updated">Last Updated</label>
                            <input type="text" id="last-updated" value="<?php echo htmlspecialchars($last_updated); ?>" disabled>
                        </div>
                    </div>
                    <button type="submit" id="save-btn" style="display:none;">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle the form fields between read-only and editable
        function toggleEdit() {
            const inputs = document.querySelectorAll('input');
            const saveBtn = document.getElementById('save-btn');
            let isDisabled = inputs[0].disabled;

            inputs.forEach(input => {
                input.disabled = !isDisabled;
            });
            saveBtn.style.display = isDisabled ? 'inline-block' : 'none';
        }
    </script>
</body>
</html>
