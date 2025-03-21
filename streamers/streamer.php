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

    if (!in_array('1', explode(',', $creator['type']))) {
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
            <img src="<?= htmlspecialchars($creator['profile']); ?>?v=<?php echo time(); ?>" alt="<?= htmlspecialchars($creator['name']); ?>'s Profile" class="creator-profile" />

            <h1><?= htmlspecialchars($creator['name']); ?></h1>

            <p><?= htmlspecialchars($creator['bio']); ?></p>

            <span>
                شروع از<p id="jalali-date"><?= htmlspecialchars($creator['record']) ?></p>
            </span>

            <p>تعداد مشترکین: <span id="subscribers-count">درحال بارگذاری...</span></p>

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

                    <button class="share-button" id="generate-share-image">
                        <img src="/assets/icons/download.svg" alt="Share" />
                    </button>

                    <canvas id="shareCanvas" style="display: none;"></canvas>

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

        document.getElementById('generate-share-image').addEventListener('click', () => {
            const canvas = document.getElementById('shareCanvas');
            const ctx = canvas.getContext('2d');
            const profileImage = "<?= htmlspecialchars($creator['profile']); ?>";

            // Set canvas size
            canvas.width = 1080;
            canvas.height = 1920;

            // Background gradient
            const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
            gradient.addColorStop(0, '#ff7e5f'); // Replace with vibrant color
            gradient.addColorStop(1, '#feb47b'); // Replace with dark vibrant color
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Load profile image
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.src = profileImage;

            img.onload = () => {
                ctx.save(); // Save the current state

                // Draw profile image as a circle
                const centerX = canvas.width / 2;
                const centerY = 500;
                const radius = 150;

                ctx.beginPath();
                ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
                ctx.closePath();
                ctx.clip();

                ctx.drawImage(img, centerX - radius, centerY - radius, radius * 2, radius * 2);

                ctx.restore(); // Restore the canvas state to remove the clipping region

                // Draw text (creator name and bio)
                ctx.font = 'bold 60px Estedad';
                ctx.fillStyle = '#fff';
                ctx.textAlign = 'center';
                ctx.fillText('<?= htmlspecialchars($creator['name']); ?>', canvas.width / 2, 800);

                ctx.font = '40px Estedad'; //
                ctx.fillText('<?= htmlspecialchars($creator['bio']); ?>', canvas.width / 2, 900);

                // Load QR code image
                const qrCodeImg = new Image();
                qrCodeImg.crossOrigin = "anonymous";
                qrCodeImg.src = "https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($current_url); ?>&size=200x200";

                qrCodeImg.onload = () => {
                    ctx.drawImage(qrCodeImg, canvas.width / 2 - 75, 1000, 150, 150);

                    canvas.toBlob((blob) => {
                        const file = new File([blob], 'share.png', {
                            type: 'image/png'
                        });

                        if (navigator.share) {
                            navigator
                                .share({
                                    title: '<?= htmlspecialchars($creator['name']); ?>',
                                    text: 'Check out this amazing streamer!',
                                    files: [file],
                                })
                                .catch((err) => console.error('Error sharing:', err));
                        } else {
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.download = 'share.png';
                            link.click();
                        }
                    }, 'image/png');
                };
            };
        });

        document.addEventListener("DOMContentLoaded", () => {
            const youtubeId = "<?= htmlspecialchars($creator['youtube_link']); ?>";

            if (youtubeId) {
                const apiUrl = `https://mixerno.space/api/youtube-channel-counter/user/${youtubeId}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        const subscribers = data.counts.find(item => item.value === "subscribers")?.count || "نامشخص";
                        document.getElementById("subscribers-count").innerText = subscribers.toLocaleString();
                    })
                    .catch(error => {
                        console.error("Error fetching YouTube subscribers:", error);
                        document.getElementById("subscribers-count").innerText = "نامشخص";
                    });
            } else {
                document.getElementById("subscribers-count").innerText = "در دسترس نیست";
            }
        });
    </script>
</body>

</html>