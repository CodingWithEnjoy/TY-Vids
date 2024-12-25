<?php
// content/youtube/youtube.php
require_once '../../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "YouTube ID is missing.";
    exit;
}

$youtube_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM contents WHERE id = ? AND type = 2");
    $stmt->execute([$youtube_id]);
    $youtube = $stmt->fetch();

    if (!$youtube) {
        echo "YouTube content not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title><?= htmlspecialchars($youtube['name']); ?> - YouTube Details</title>
</head>

<body>
    <?php include("../../components/header.php"); ?>

    <div class="content-details">
        <h1><?= htmlspecialchars($youtube['name']); ?></h1>
        <img src="<?= htmlspecialchars($youtube['cover']); ?>" alt="<?= htmlspecialchars($youtube['name']); ?>">
        <p><?= htmlspecialchars($youtube['caption']); ?></p>
        <a href="<?= htmlspecialchars($youtube['link']); ?>" target="_blank">Watch on YouTube</a>
    </div>

    <?php include("../../components/footer.php"); ?>
</body>

</html>