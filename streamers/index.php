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
    WHERE FIND_IN_SET('1', type) $orderClause
    ");
    $stmt->execute();
    $streamers = $stmt->fetchAll();
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
    <title>Streamers List</title>
</head>

<body>
    <?php include("../components/header.php"); ?>

    <div class="creators-history">
        <h2>تاریخچه <span>استریم</span> فارسی</h2>

        <p>
            استریم فارسی در توییچ از اواسط دهه ۱۳۹۰ خورشیدی شروع به رشد کرد، زمانی که بازی‌های ویدیویی و پلتفرم‌های استریم به‌تدریج در میان جوانان ایرانی محبوب شدند. نخستین استریمرهای فارسی مانند <strong>امیر فانتوم ، امیر ایزد ، تاکسیک گرل و ...</strong> در توییچ معمولاً روی بازی‌های محبوبی مانند <strong>Dota 2، Rainbox Six Siege</strong>، و بعدها <strong>Fortnite و Valorant</strong> تمرکز داشتند. این افراد با استفاده از محتوای زنده و ارتباط مستقیم با مخاطبان، توانستند جامعه‌ای از گیمرهای ایرانی ایجاد کنند.
            <br>
            با گسترش اینترنت و افزایش آگاهی از پلتفرم توییچ، استریم‌های غیرگیمینگ مانند برنامه‌های گفتگو، هنر، و موسیقی نیز به‌تدریج جایگاه خود را پیدا کردند. با این حال، مشکلاتی مانند محدودیت‌های اینترنت در ایران، دشواری دریافت درآمد از توییچ به دلیل تحریم‌ها، و نیاز به عبور از فیلترها، چالش‌های اصلی استریمرهای فارسی بوده‌اند. با وجود این موانع، توییچ همچنان به‌عنوان یکی از محبوب‌ترین پلتفرم‌های استریم برای جامعه فارسی‌زبان فعال باقی مانده است.
        </p>
    </div>

    <div class="creators-sort">
        <h3>فیلتر (دسته بندی) : </h3>
        <a href="/streamers" class="sort <?= $sort === 'default' ? 'active' : '' ?>">پیش فرض</a>
        <a href="?sort=newest" class="sort <?= $sort === 'newest' ? 'active' : '' ?>">جدید ترین</a>
        <a href="?sort=oldest" class="sort <?= $sort === 'oldest' ? 'active' : '' ?>">قدیمی ترین</a>
    </div>

    <div class="creators-list">
        <?php foreach ($streamers as $index => $streamer): ?>
            <div class="swiper-slide creator-card" id="streamer-card-<?= $index; ?>">
                <img src="<?= htmlspecialchars($streamer['profile']); ?>?v=<?php echo time(); ?>"
                    alt="<?= htmlspecialchars($streamer['name']); ?>'s Profile Picture"
                    class="profile"
                    data-id="streamer-card-<?= $index; ?>"
                    data-src="<?= htmlspecialchars($streamer['profile']); ?>">

                <a href="/streamers/<?= htmlspecialchars($streamer['id']); ?>">
                    <?= htmlspecialchars($streamer['name']); ?>
                </a>

                <p><?= htmlspecialchars($streamer['bio']); ?></p>

                <div class="social-links">
                    <?php if (!empty($streamer['twitch_id'])) : ?>
                        <a href="https://www.twitch.tv/<?= htmlspecialchars($streamer['twitch_id']); ?>" target="_blank"><img src="/assets/icons/twitch.svg" alt="" /></a>
                    <?php endif; ?>

                    <?php if (!empty($streamer['instagram_id'])) : ?>
                        <a href="https://www.instagram.com/<?= htmlspecialchars($streamer['instagram_id']); ?>" target="_blank"><img src="/assets/icons/instagram.svg" alt="" /></a>
                    <?php endif; ?>

                    <?php if (!empty($streamer['twitter_id'])) : ?>
                        <a href="https://twitter.com/<?= htmlspecialchars($streamer['twitter_id']); ?>" target="_blank"><img src="/assets/icons/x.svg" alt="" /></a>
                    <?php endif; ?>

                    <?php if (!empty($streamer['telegram_link'])) : ?>
                        <a href="https://t.me/s/<?= htmlspecialchars($streamer['telegram_link']); ?>" target="_blank"><img src="/assets/icons/telegram.svg" alt="" /></a>
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