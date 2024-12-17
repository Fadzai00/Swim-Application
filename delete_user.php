<?php
// Include database functions and process delete
include 'functions.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    delete_user($user_id);
    header('Location: admin_dashboard.php');
    exit();
}
