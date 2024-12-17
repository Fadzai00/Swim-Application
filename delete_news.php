<?php
include 'functions.php';

if (isset($_GET['dashboard_id'])) {
    $dashboard_id = intval($_GET['dashboard_id']);
    delete_news($dashboard_id);
    header("Location: news_updates.php");
    exit();
}
?>
