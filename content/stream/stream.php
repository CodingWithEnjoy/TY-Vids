<?php
// content/stream/stream.php
require_once '../../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Stream ID is missing.";
    exit;
}

$stream_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM contents WHERE id = ? AND type = 1");
    $stmt->execute([$stream_id]);
    $stream = $stmt->fetch();

    if (!$stream) {
        echo "Stream not found.";
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
    <title><?= htmlspecialchars($stream['name']); ?> - Stream Details</title>
</head>

<body>
    <?php include("../../components/header.php"); ?>

    <div class="content-details">
        <h1><?= htmlspecialchars($stream['name']); ?></h1>
        <img src="<?= htmlspecialchars($stream['cover']); ?>" alt="<?= htmlspecialchars($stream['name']); ?>">
        <p><?= htmlspecialchars($stream['caption']); ?></p>
        <a href="<?= htmlspecialchars($stream['link']); ?>" target="_blank">Watch Stream</a>
    </div>

    <?php include("../../components/footer.php"); ?>
</body>

</html>