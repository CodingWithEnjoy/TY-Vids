<?php
session_start();
require_once 'config/database.php';

$type_streamers = '1';
$type_youtubers = '2';
$type_stream = '1';
$type_youtube = '2';

try {
    $stmt_streamers = $pdo->prepare("
        SELECT id, name, bio, profile, youtube_link, twitch_id, instagram_id, twitter_id, telegram_link, type
        FROM creators
        WHERE FIND_IN_SET(:type, type)
        LIMIT 5
    ");
    $stmt_streamers->bindParam(':type', $type_streamers, PDO::PARAM_STR);
    $stmt_streamers->execute();
    $streamers = $stmt_streamers->fetchAll(PDO::FETCH_ASSOC);

    $stmt_youtubers = $pdo->prepare("
        SELECT id, name, bio, profile, youtube_link, twitch_id, instagram_id, twitter_id, telegram_link, type
        FROM creators
        WHERE FIND_IN_SET(:type, type)
        LIMIT 5
    ");
    $stmt_youtubers->bindParam(':type', $type_youtubers, PDO::PARAM_STR);
    $stmt_youtubers->execute();
    $youtubers = $stmt_youtubers->fetchAll(PDO::FETCH_ASSOC);


    $stmt_stream = $pdo->prepare("
        SELECT id, name, caption, cover, link, type
        FROM contents
        WHERE FIND_IN_SET(:type, type)
        LIMIT 5
    ");
    $stmt_stream->bindParam(':type', $type_stream, PDO::PARAM_STR);
    $stmt_stream->execute();
    $streams = $stmt_stream->fetchAll(PDO::FETCH_ASSOC);


    $stmt_youtube = $pdo->prepare("
        SELECT id, name, caption, cover, link, type
        FROM contents
        WHERE FIND_IN_SET(:type, type)
        LIMIT 5
    ");
    $stmt_youtube->bindParam(':type', $type_youtube, PDO::PARAM_STR);
    $stmt_youtube->execute();
    $youtubes = $stmt_youtube->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="/assets/css/swiper.min.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <title>TY Vids - یوتیوبر ها و استریمر های ایرانی</title>
</head>

<body>
    <?php include("components/header.php"); ?>

    <div class="hero">
        <img src="assets/img/hero.png" alt="TY Vids Logo">

        <div class="hero-info">
            <h2>تی وای ویدز - TY Vids</h2>
            <p>رسانه استریمر ها و یوتیوبر های ایرانی</p>

            <div class="hero-btns">
                <a href="streamers">استریمر ها</a>
                <a href="youtubers">یوتیوبر ها</a>
            </div>
        </div>
    </div>

    <form action="/search" method="GET" class="search">
        <input
            type="text"
            name="q"
            placeholder="هرچی دلت میخواد سرچ کن :)"
            value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>"
            required />

        <button type="submit">
            <img src="/assets/icons/search.svg" alt="Search icon" />
        </button>
    </form>

    <div class="creators-swiper">
        <h2>برترین استریمر ها</h2>

        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($streamers as $index => $streamer): ?>
                    <div class="swiper-slide creator-card" id="streamer-card-<?= $index; ?>">
                        <img src="<?= htmlspecialchars($streamer['profile']); ?>"
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
        </div>
    </div>

    <div class="creators-swiper">
        <h2>برترین یوتیوبر ها</h2>

        <div class="swiper">
            <div class="swiper-wrapper">
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
        </div>
    </div>

    <div class="creators-swiper">
        <h2>برترین محتوای استریمینگ</h2>

        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($streams as $index => $stream): ?>
                    <div class="swiper-slide creator-card" id="stream-card-<?= $index; ?>">
                        <img src="<?= htmlspecialchars($stream['cover']); ?>"
                            alt="<?= htmlspecialchars($stream['name']); ?>'s Profile Picture"
                            class="profile"
                            data-id="stream-card-<?= $index; ?>"
                            data-src="<?= htmlspecialchars($stream['cover']); ?>">

                        <a href="/content/stream/<?= htmlspecialchars($stream['id']); ?>">
                            <?= htmlspecialchars($stream['name']); ?>
                        </a>

                        <p><?= htmlspecialchars($stream['caption']); ?></p>

                        <div class="social-links">
                            <?php if (!empty($stream['link'])) : ?>
                                <a href="<?= htmlspecialchars($stream['link']); ?>" target="_blank"><img src="/assets/icons/twitch.svg" alt="" /></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="creators-swiper">
        <h2>برترین محتوای یوتیوبی</h2>

        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($youtubes as $index => $youtube): ?>
                    <div class="swiper-slide creator-card" id="youtube-card-<?= $index; ?>">
                        <img src="<?= htmlspecialchars($youtube['cover']); ?>"
                            alt="<?= htmlspecialchars($youtube['name']); ?>'s Profile Picture"
                            class="profile"
                            data-id="youtube-card-<?= $index; ?>"
                            data-src="<?= htmlspecialchars($youtube['cover']); ?>">

                        <a href="/content/youtube/<?= htmlspecialchars($youtube['id']); ?>">
                            <?= htmlspecialchars($youtube['name']); ?>
                        </a>

                        <p><?= htmlspecialchars($youtube['caption']); ?></p>

                        <div class="social-links">
                            <?php if (!empty($youtube['link'])) : ?>
                                <a href="<?= htmlspecialchars($youtube['link']); ?>" target="_blank"><img src="/assets/icons/youtube.svg" alt="" /></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="social-media">
        <img src="assets/img/social.png" class="social-media-img" alt="TY Vids Logo">

        <div class="social-media-info">
            <p>ما رو در اینستاگرام دنبال کنید !</p>

            <div class="social-links">
                <a href="https://www.instagram.com/tyvids.ir" target="_blank"><img src="/assets/icons/instagram.svg" alt="" /></a>
                <a href="https://twitter.com/tyvids" target="_blank"><img src="/assets/icons/x.svg" alt="" /></a>
                <a href="https://t.me/s/tyvids" target="_blank"><img src="/assets/icons/telegram.svg" alt="" /></a>
            </div>
        </div>
    </div>

    <?php include("components/footer.php"); ?>

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