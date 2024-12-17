<?php
// Include functions file
include 'functions.php';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from POST
    $program_id = $_POST['program_id'];
    $title = $_POST['Title'];
    $description = $_POST['Description'];
    $image_url = $_POST['imageURL'];

    // Sanitize inputs (you might want to do further sanitization)
    $title = htmlspecialchars($Title);
    $description = htmlspecialchars($Description);
    $image_url = htmlspecialchars($imageURL);

    // Call the function to update the program
    $update_result = update_program($program_id, $Title, $Description, $imageURL);

    if ($update_result) {
        // Redirect back to program listing after successful update
        header('Location: admin_programs.php');
        exit;
    } else {
        // Handle any errors
        echo "Failed to update program!";
    }
} else {
    // If not a POST request
    echo "Invalid request!";
}
?>
