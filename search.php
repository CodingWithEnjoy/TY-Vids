<?php
require_once 'config/database.php';

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search_query === '') {
    echo "لطفاً یک عبارت برای جستجو وارد کنید.";
    exit;
}

try {
    $creator_query = "
        SELECT id, name, bio, profile, tags, youtube_link, twitch_id, instagram_id, twitter_id, telegram_link, type 
        FROM creators 
        WHERE 
            name LIKE :search 
            OR bio LIKE :search 
            OR tags LIKE :search
    ";
    $creator_stmt = $pdo->prepare($creator_query);
    $creator_stmt->execute([':search' => "%$search_query%"]);
    $creators = $creator_stmt->fetchAll();

    $content_query = "
        SELECT 
            contents.*, 
            creators.name AS creator_name 
        FROM 
            contents 
        LEFT JOIN 
            creators 
        ON 
            contents.creator = creators.id
        WHERE 
            contents.name LIKE :search 
            OR contents.caption LIKE :search 
            OR contents.info LIKE :search 
            OR contents.category LIKE :search
    ";
    $content_stmt = $pdo->prepare($content_query);
    $content_stmt->execute([':search' => "%$search_query%"]);
    $contents = $content_stmt->fetchAll();
} catch (PDOException $e) {
    echo "خطا در اجرای جستجو: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <title>نتایج جستجو</title>
</head>

<body>
    <?php include("components/header.php"); ?>

    <div class="search-results">
        <h1>نتایج <span><?php echo htmlspecialchars($search_query); ?></span></h1>

        <div class="wrapper"></div>

        <div class="creators-results">
            <?php if (empty($creators)): ?>
                <p>هیچ سازنده‌ای یافت نشد.</p>
            <?php else: ?>
                <?php foreach ($creators as $creator): ?>
                    <div class="swiper-slide creator-card">
                        <img src="<?php echo htmlspecialchars($creator['profile']); ?>" alt="<?php echo htmlspecialchars($creator['name']); ?>" class="profile">

                        <?php if ($creator['type'] == 1): ?>
                            <a href="/streamers/<?= htmlspecialchars($creator['id']); ?>">
                                <?= htmlspecialchars($creator['name']); ?>
                            </a>
                        <?php elseif ($creator['type'] == 2): ?>
                            <a href="/youtubers/<?= htmlspecialchars($creator['id']); ?>">
                                <?= htmlspecialchars($creator['name']); ?>
                            </a>
                        <?php else: ?>
                            <p><?= htmlspecialchars($creator['name']); ?></p>
                        <?php endif; ?>

                        <p><?php echo htmlspecialchars($creator['bio']); ?></p>

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
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="wrapper"></div>

        <div class="contents-results">
            <h2>محتوا</h2>
            <?php if (empty($contents)): ?>
                <p>هیچ محتوایی یافت نشد.</p>
            <?php else: ?>
                <?php foreach ($contents as $content): ?>
                    <div class="content-card">
                        <img src="<?php echo htmlspecialchars($content['cover']); ?>" alt="<?php echo htmlspecialchars($content['name']); ?>" style="width: 150px; height: 100px;">
                        <h3>
                            <a href="/content/<?php echo $content['id']; ?>">
                                <?php echo htmlspecialchars($content['name']); ?>
                            </a>
                        </h3>
                        <p><?php echo htmlspecialchars($content['caption']); ?></p>
                        <p><?php echo htmlspecialchars($content['info']); ?></p>
                        <p>دسته‌بندی: <?php echo htmlspecialchars($content['category']); ?></p>
                        <p>توسط: <a href="/creators/<?php echo $content['creator']; ?>">
                                <?php echo htmlspecialchars($content['creator_name']); ?>
                            </a></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include("components/footer.php"); ?>
</body>

</html>