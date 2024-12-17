<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['news_title'];
    $content = $_POST['news_content'];
    add_news($title, $content);
    header("Location: news_updates.php");
    exit();
}
?>
