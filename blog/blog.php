<?php
require_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid blog ID.";
    exit;
}

$blog_id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT title, caption, cover_img, content, created_at FROM blog WHERE id = ?");
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        echo "Blog post not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching blog: " . $e->getMessage();
    exit;
}

$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">
    <title><?= htmlspecialchars($blog['title']) ?></title>
</head>

<body>
    <?php include("../components/header.php"); ?>
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>

    <div class="blog-page">
        <div class="blog-body">
            <img src="<?= htmlspecialchars($blog['cover_img']) ?>?v=<?php echo time(); ?>" alt="">

            <h1><?= htmlspecialchars($blog['title']) ?></h1>

            <p><?= nl2br(strip_tags($blog['content'], '<strong><i><li><h1><h2><h3><h4><h5><h6><ul><ol><p>')) ?></p>
        </div>

        <div class="blog-others">
            <div class="blog-share">
                <h3>اشتراک گذاری :</h3>

                <div class="social-links">
                    <a href="https://twitter.com/intent/tweet?text=<?= htmlspecialchars($blog['title']) ?>&url=<?= urlencode($current_url); ?>"
                        target="_blank" class="share-twitter"><img src="/assets/icons/x.svg" alt="" /></a>

                    <a href="https://wa.me/?text=<?= urlencode(htmlspecialchars($blog['title']) . ' ' . $current_url); ?>"
                        target="_blank" class="share-whatsapp"><img src="/assets/icons/whatsapp.svg" alt="" /></a>

                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($current_url); ?>"
                        target="_blank" class="share-linkedin"><img src="/assets/icons/linkedin.svg" alt="" /></a>

                    <a href="https://t.me/share/url?url=<?= urlencode($current_url); ?>&text=<?= htmlspecialchars($blog['title']) ?>"
                        target="_blank" class="share-telegram"><img src="/assets/icons/telegram.svg" alt="" /></a>

                    <button class="copy-link" onclick="copyToClipboard('<?= htmlspecialchars($current_url); ?>')">
                        <img src="/assets/icons/link.svg" alt="" />
                    </button>

                    <div id="copy-popup">لینک کپی شد !</div>
                </div>
            </div>

            <div class="blog-qr">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($current_url); ?>&size=200x200&color=000000" alt="QR Code for <?= htmlspecialchars($blog['title']); ?>">
            </div>
        </div>

    </div>

    <?php include("../components/footer.php"); ?>
</body>

</html>