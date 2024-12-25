<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM blog WHERE id = ?");
        $stmt->execute([$id]);
        echo "Blog post deleted successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT * FROM blog");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
</head>

<body>
    <h1>Manage Blogs</h1>
    <a href="index.php">Dashboard</a> |
    <a href="login.php">Logout</a><br><br>

    <h2>Blog Posts</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Caption</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($blogs as $blog): ?>
            <tr>
                <td><?php echo htmlspecialchars($blog['title']); ?></td>
                <td><?php echo htmlspecialchars($blog['caption']); ?></td>
                <td>
                    <form action="blogs.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>