<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dashboard_id = $_POST['dashboard_id'];
    $title = $_POST['news_title'];
    $content = $_POST['news_content'];
    update_news($dashboard_id, $title, $content);
    header("Location: news_updates.php");
    exit();
} else if (isset($_GET['dashboard_id'])) {
    $dashboard_id = intval($_GET['dashboard_id']);
    $news = fetch_news_by_id($dashboard_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit News</title>
    <link rel="stylesheet" href="news_updates.css">
</head>
<body>
    <div class="content">
        <h1>Edit News</h1>
        <form action="edit_news.php" method="POST">
            <input type="hidden" name="dashboard_id" value="<?php echo $dashboard_id; ?>">
            <label for="news_title">News Title:</label>
            <input type="text" name="news_title" id="news_title" value="<?php echo htmlspecialchars($news['NewsTitle']); ?>" required><br>

            <label for="news_content">News Content:</label>
            <textarea name="news_content" id="news_content" required><?php echo htmlspecialchars($news['NewsContent']); ?></textarea><br>
            
            <button type="submit">Update News</button>
        </form>
    </div>
</body>
</html>
