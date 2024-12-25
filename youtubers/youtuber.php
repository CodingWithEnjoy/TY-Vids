<?php
session_start();
require_once '../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Streamer ID is missing.";
    exit;
}

$creator_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM creators WHERE id = ?");
    $stmt->execute([$creator_id]);
    $creator = $stmt->fetch();

    if (!$creator) {
        echo "Creator not found.";
        exit;
    }

    if (!in_array('2', explode(',', $creator['type']))) {
        echo "This creator is not a streamer.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
    <title><?= htmlspecialchars($creator['name']); ?> - Streamer Details</title>
</head>

<body>
    <?php include("../components/header.php"); ?>

    <div class="creator-page">
        <div class="creator-body">
            <img src="<?= htmlspecialchars($creator['profile']); ?>" alt="<?= htmlspecialchars($creator['name']); ?>'s Profile" class="creator-profile" />

            <h1><?= htmlspecialchars($creator['name']); ?></h1>

            <p><?= htmlspecialchars($creator['bio']); ?></p>

            <span>
                شروع از<p id="jalali-date"><?= htmlspecialchars($creator['record']) ?></p>
            </span>

            <div class="social-links">
                <?php if (!empty($creator['twitch_id'])) : ?>
                    <a href="https://www.twitch.tv/<?= htmlspecialchars($creator['twitch_id']); ?>" target="_blank"><img src="/assets/icons/twitch.svg" alt="" /></a>
                <?php endif; ?>

                <?php if (!empty($creator['instagram_id'])) : ?>
                    <a href="https://www.instagram.com/<?= htmlspecialchars($creator['instagram_id']); ?>" target="_blank"><img src="/assets/icons/instagram.svg" alt="" /></a>
                <?php endif; ?>

                <?php if (!empty($creator['twitter_id'])) : ?>
                    <a href="https://twitter.com/<?= htmlspecialchars($creator['twitter_id']); ?>" target="_blank"><img src="/assets/icons/x.svg" alt="" /></a>
                <?php endif; ?>

                <?php if (!empty($creator['telegram_link'])) : ?>
                    <a href="https://t.me/s/<?= htmlspecialchars($creator['telegram_link']); ?>" target="_blank"><img src="/assets/icons/telegram.svg" alt="" /></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="creator-others">
            <div class="creator-share">
                <h3>اشتراک گذاری :</h3>

                <div class="social-links">
                    <a href="https://twitter.com/intent/tweet?text=<?= htmlspecialchars($creator['name']) ?>&url=<?= urlencode($current_url); ?>"
                        target="_blank" class="share-twitter"><img src="/assets/icons/x.svg" alt="" /></a>

                    <a href="https://wa.me/?text=<?= urlencode(htmlspecialchars($creator['name']) . ' ' . $current_url); ?>"
                        target="_blank" class="share-whatsapp"><img src="/assets/icons/whatsapp.svg" alt="" /></a>

                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($current_url); ?>"
                        target="_blank" class="share-linkedin"><img src="/assets/icons/linkedin.svg" alt="" /></a>

                    <a href="https://t.me/share/url?url=<?= urlencode($current_url); ?>&text=<?= htmlspecialchars($creator['name']) ?>"
                        target="_blank" class="share-telegram"><img src="/assets/icons/telegram.svg" alt="" /></a>

                    <button class="copy-link" onclick="copyToClipboard('<?= htmlspecialchars($current_url); ?>')">
                        <img src="/assets/icons/link.svg" alt="" />
                    </button>

                    <div id="copy-popup">لینک کپی شد !</div>
                </div>
            </div>

            <div class="creator-qr">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($current_url); ?>&size=200x200&color=000000" alt="QR Code for <?= htmlspecialchars($creator['name']); ?>">
            </div>
        </div>
    </div>

    <?php include("../components/footer.php"); ?>

    <script>
        var dateStr = "<?= $creator['record']; ?>";
        var dateObj = new Date(dateStr);
        var jalaliDate = jalaali.toJalaali(dateObj);
        var formattedDate = jalaliDate.jd + " " + getPersianMonth(jalaliDate.jm) + " " + jalaliDate.jy;

        document.getElementById('jalali-date').innerText = formattedDate;

        function getPersianMonth(monthNumber) {
            var months = [
                'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
                'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
            ];
            return months[monthNumber - 1];
        }

        document.addEventListener("DOMContentLoaded", () => {
            const profileImage = "<?= htmlspecialchars($creator['profile']); ?>";

            const img = new Image();
            img.src = profileImage;
            img.crossOrigin = "anonymous";

            img.onload = () => {
                const vibrant = new Vibrant(img);
                const swatches = vibrant.swatches();
                const color1 = swatches["Vibrant"]?.getHex() || "#000";
                const color2 = swatches["DarkVibrant"]?.getHex() || "#000";

                document.body.style.background = `linear-gradient(135deg, ${color1}, ${color2})`;
            };
        });
    </script>
</body>

</html>