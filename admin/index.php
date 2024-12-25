<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Welcome to Tyvids Admin Panel</h1>
    <nav>
        <a href="streamers.php">Manage Streamers</a> |
        <a href="youtubers.php">Manage YouTubers</a> |
        <a href="blogs.php">Manage Blogs</a> |
        <a href="logout.php">Logout</a>
    </nav>
</body>

</html>