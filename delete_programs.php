<?php
// Include functions file
include 'functions.php';

// Check if 'program_id' is passed via URL
if (isset($_GET['program_id'])) {
    $program_id = $_GET['program_id'];

    // Call the function to delete the program
    $delete_result = delete_program($program_id);

    if ($delete_result) {
        // Redirect to the programs page after deletion
        header('Location: admin_programs.php');
        exit;
    } else {
        // Handle deletion error
        echo "Failed to delete program!";
    }
} else {
    // If no program ID is passed
    header('Location: admin_programs.php');
    exit;
}
?>

