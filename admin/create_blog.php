<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "Error: Admin user ID not found in session.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $caption = htmlspecialchars(trim($_POST['caption']));
    $author = $_SESSION['user_id'];
    $content = $_POST['content'];

    $cover_img = '';
    if (isset($_FILES['cover_img']) && $_FILES['cover_img']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../assets/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $cover_img = $upload_dir . basename($_FILES['cover_img']['name']);
        if (!move_uploaded_file($_FILES['cover_img']['tmp_name'], $cover_img)) {
            echo "Error uploading the cover image.";
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO blog (title, caption, created_at, author, cover_img, content) VALUES (?, ?, NOW(), ?, ?, ?)");
        $stmt->execute([$title, $caption, $author, $cover_img, $content]);
        echo "Blog post created successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <title>Create Blog</title>
</head>

<body>
    <h1>Create New Blog Post</h1>
    <form action="create_blog.php" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="caption">Caption:</label>
        <textarea name="caption" id="caption"></textarea><br><br>

        <label for="cover_img">Cover Image:</label>
        <input type="file" name="cover_img" id="cover_img"><br><br>

        <label for="content">Content:</label>
        <textarea name="content" id="content" required></textarea><br><br>

        <button type="submit">Create Blog Post</button>
    </form>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                document.querySelector('#content').removeAttribute('required');
            })
            .catch(error => {
                console.error('Error initializing CKEditor for content:', error);
            });

        ClassicEditor
            .create(document.querySelector('#caption'))
            .catch(error => {
                console.error('Error initializing CKEditor for caption:', error);
            });
    </script>
</body>

</html>
