<?php

// Database connection
include 'config_.php';

// Fetch all users for display
function fetch_all_users() {
    global $conn;
    $query = "SELECT user_id, fname, lname, role FROM users";
    return $conn->query($query);
}

// Fetch a single user by ID
function fetch_user_by_id($user_id) {
    global $conn;
    $query = "SELECT user_id, fname, lname, role FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Create a new user
// Modified function to accept email and password
function create_user($fname, $lname, $email, $password, $role) {
    global $conn;

    // Hash the password before inserting into the database for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database with sanitized inputs
    $query = "INSERT INTO users (fname, lname, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Error preparing query: ' . $conn->error);
    }

    $stmt->bind_param('sssss', $fname, $lname, $email, $hashed_password, $role); // Binds the values to the placeholders

    if ($stmt->execute()) {
        echo "User created successfully!";
        return true;
    } else {
        echo "Error during user creation: " . $stmt->error;
        return false;
    }
}


// Update user details
function update_user($user_id, $fname, $lname, $role) {
    global $conn;
    $query = "UPDATE users SET fname = ?, lname = ?, role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $fname, $lname, $role, $user_id);
    $stmt->execute();
}

// Delete a user by ID
function delete_user($user_id) {
    global $conn;
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
}

//Edit role
// Function to update the user role in the database
function update_role($conn, $user_id, $new_role) {
    // Make sure role is valid
    if (!in_array($new_role, ['admin', 'user'])) {
        echo "Invalid role.";
        return false;
    }

    // Create SQL query to update the user's role
    $query = "UPDATE users SET role = ? WHERE user_id = ?";
    
    // Prepare statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters: s for string, i for integer
        $stmt->bind_param("si", $new_role, $user_id);

        // Execute statement
        if ($stmt->execute()) {
            // Success: Role updated
            $stmt->close();
            return true;
        } else {
            // Error: Could not update the role
            echo "Error during role update: " . $stmt->error;
            $stmt->close();
            return false;
        }
    } else {
        echo "Error preparing the statement: " . $conn->error;
        return false;
    }
}


// Get User by ID Function (to fetch details like current role, etc.)
function get_user_by_id($user_id) {
    global $conn;
    $query = "SELECT fname, lname, email, role FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id); // Bind as integer (user_id is likely an int)

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Return user data as an associative array
        return $result->fetch_assoc();
    } else {
        // Return false if no user is found
        return false;
    }
}

// Function to fetch all programs
function fetch_all_programs() {
    global $conn;
    $query = "SELECT program_id, Title, Description, imageURL FROM programs";
    return $conn->query($query);
}

// Function to fetch a specific program by its ID
function fetch_program_by_id($program_id) {
    global $conn;
    $query = "SELECT program_id, Title, Description, imageURL FROM programs WHERE program_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $program_id); // Bind the program_id as integer
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // Return the program data
}

// Function to update a program
function update_program($program_id, $Title, $Description, $imageURL) {
    global $conn;
    $query = "UPDATE programs SET Title = ?, Description = ?, imageURL = ? WHERE program_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $Title, $Description, $imageURL, $program_id);
    $stmt->execute();
    return $stmt->affected_rows > 0; // Returns true if at least one row was updated
}

// Function to delete a program
function delete_program($program_id) {
    global $conn;
    $query = "DELETE FROM programs WHERE program_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    return $stmt->affected_rows > 0; // Returns true if a row was deleted
}

// Function to insert a new program into the database
function insert_program($Title, $Description, $imageURL) {
    global $conn;  // Assume you have a connection to the DB

    // SQL query to insert new program
    $stmt = $conn->prepare("INSERT INTO programs (Title, Description, imageURL) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Title, $Description, $imageURL);

    // Execute and check if the insertion was successful
    return $stmt->execute();
}
// Fetch all news
function fetch_all_news() {
    global $conn;
    $stmt = $conn->prepare("SELECT dashboard_id, NewsTitle, NewsContent FROM userdashboard");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}

// Add news
function add_news($title, $content) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO userdashboard (NewsTitle, NewsContent) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Delete news
function delete_news($dashboard_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM userdashboard WHERE dashboard_id = ?");
    $stmt->bind_param("i", $dashboard_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Fetch specific news for editing
function fetch_news_by_id($dashboard_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT NewsTitle, NewsContent FROM userdashboard WHERE dashboard_id = ?");
    $stmt->bind_param("i", $dashboard_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $result;
}

// Update news
function update_news($dashboard_id, $title, $content) {
        global $conn;
    $stmt = $conn->prepare("UPDATE userdashboard SET NewsTitle = ?, NewsContent = ? WHERE dashboard_id = ?");
    $stmt->bind_param("ssi", $title, $content, $dashboard_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

?>
