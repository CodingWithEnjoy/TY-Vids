<?php
session_start();
require_once '../config/database.php';

$sort = $_GET['sort'] ?? 'default';

switch ($sort) {
    case 'newest':
        $orderClause = 'ORDER BY record DESC';
        break;
    case 'oldest':
        $orderClause = 'ORDER BY record ASC';
        break;
    default:
        $orderClause = '';
}

try {
    $stmt = $pdo->prepare("
    SELECT id, name, bio, profile AS profile, record, youtube_link, twitch_id, instagram_id, twitter_id, telegram_link, type 
    FROM creators
    WHERE FIND_IN_SET('2', type) $orderClause
    ");
    $stmt->execute();
    $youtubers = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">
    <title>YouTubers List</title>
</head>

<body>
    <?php include("../components/header.php"); ?>

    <div class="creators-history">
        <h2>تاریخچه <span>یوتیوب</span> فارسی</h2>

        <p>
            یوتیوب فارسی در ایران از اوایل دهه ۱۳۹۰ خورشیدی مورد توجه قرار گرفت، زمانی که اینترنت پرسرعت در دسترس بیشتری از مردم قرار گرفت. نخستین تولیدکنندگان محتوای فارسی در یوتیوب معمولاً ویدیوهای آموزشی، سرگرمی، و محتواهای شخصی تولید می‌کردند. چهره‌هایی مانند <strong>آریا کئوکسر ، میا پلیز ، علیرکسا و ...</strong> شروع به جذب مخاطب کردند. اما از اواسط دهه ۱۳۹۰، تولید محتوا در یوتیوب به‌صورت حرفه‌ای‌تر و با محوریت <strong>سرگرمی، گیمینگ، ولاگ، و نقد</strong> گسترش یافت.
            <br>
            با گذشت زمان و افزایش کاربران ایرانی یوتیوب، بسیاری از کانال‌ها به درآمدزایی از طریق تبلیغات و حمایت مالی رسیدند. با این حال، محدودیت‌های اینترنت در ایران، از جمله فیلتر بودن یوتیوب و سرعت پایین اینترنت، همچنان مانع بزرگی برای رشد بیشتر این فضا بوده است. از سوی دیگر، پلتفرم‌هایی مانند آپارات به‌عنوان جایگزین داخلی مطرح شدند، اما یوتیوب همچنان جایگاه خاص خود را نزد کاربران فارسی‌زبان حفظ کرده است.
        </p>
    </div>

    <div class="creators-sort">
        <h3>فیلتر (دسته بندی) : </h3>

        <a href="/youtubers" class="sort <?= $sort === 'default' ? 'active' : '' ?>">پیش فرض</a>
        <a href="?sort=newest" class="sort <?= $sort === 'newest' ? 'active' : '' ?>">جدید ترین</a>
        <a href="?sort=oldest" class="sort <?= $sort === 'oldest' ? 'active' : '' ?>">قدیمی ترین</a>
    </div>

    <div class="creators-list">
        <?php foreach ($youtubers as $index => $youtuber): ?>
            <div class="swiper-slide creator-card" id="youtuber-card-<?= $index; ?>">
                <img src="<?= htmlspecialchars($youtuber['profile']); ?>"
                    alt="<?= htmlspecialchars($youtuber['name']); ?>'s Profile Picture"
                    class="profile"
                    data-id="youtuber-card-<?= $index; ?>"
                    data-src="<?= htmlspecialchars($youtuber['profile']); ?>">

                <a href="/youtubers/<?= htmlspecialchars($youtuber['id']); ?>">
                    <?= htmlspecialchars($youtuber['name']); ?>
                </a>

                <p><?= htmlspecialchars($youtuber['bio']); ?></p>

                <div class="social-links">
                    <?php if (!empty($youtuber['twitch_id'])) : ?>
                        <a href="https://www.twitch.tv/<?= htmlspecialchars($youtuber['twitch_id']); ?>" target="_blank"><img src="/assets/icons/twitch.svg" alt="" /></a>
                    <?php endif; ?>

                    <?php if (!empty($youtuber['instagram_id'])) : ?>
                        <a href="https://www.instagram.com/<?= htmlspecialchars($youtuber['instagram_id']); ?>" target="_blank"><img src="/assets/icons/instagram.svg" alt="" /></a>
                    <?php endif; ?>

                    <?php if (!empty($youtuber['twitter_id'])) : ?>
                        <a href="https://twitter.com/<?= htmlspecialchars($youtuber['twitter_id']); ?>" target="_blank"><img src="/assets/icons/x.svg" alt="" /></a>
                    <?php endif; ?>

                    <?php if (!empty($youtuber['telegram_link'])) : ?>
                        <a href="https://t.me/s/<?= htmlspecialchars($youtuber['telegram_link']); ?>" target="_blank"><img src="/assets/icons/telegram.svg" alt="" /></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include("../components/footer.php"); ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const profileImages = document.querySelectorAll(".profile");

            profileImages.forEach((img) => {
                const cardId = img.dataset.id;
                const imageUrl = img.dataset.src;

                const tempImg = new Image();
                tempImg.src = imageUrl;
                tempImg.crossOrigin = "anonymous";

                tempImg.onload = () => {
                    const vibrant = new Vibrant(tempImg);
                    const swatches = vibrant.swatches();

                    const color1 = swatches["Vibrant"]?.getHex() || "#ff5722";
                    const color2 = swatches["DarkVibrant"]?.getHex() || "#3f51b5";

                    const card = document.getElementById(cardId);
                    card.style.background = `linear-gradient(135deg, ${color1}, ${color2})`;
                    card.style.color = "#fff";
                };
            });
        });
    </script>
</body>

</html>