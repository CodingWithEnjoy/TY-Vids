<?php
require_once '../../config/database.php';

$selected_category = isset($_GET['category']) ? $_GET['category'] : null;

try {
    $query = "
        SELECT 
            contents.*, 
            creators.name AS creator_name, 
            creators.type AS creator_type, 
            creators.id AS creator_id
        FROM 
            contents 
        LEFT JOIN 
            creators 
        ON 
            contents.creator = creators.id
        WHERE 
            contents.type = 2
    ";

    if ($selected_category) {
        $query .= " AND contents.category = :category";
    }

    $stmt = $pdo->prepare($query);

    if ($selected_category) {
        $stmt->bindParam(':category', $selected_category, PDO::PARAM_STR);
    }

    $stmt->execute();
    $contents = $stmt->fetchAll();
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
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">
    <title>Filtered Content</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vibrant.js/1.0.1/Vibrant.min.js"></script>
</head>

<body>
    <?php include("../../components/header.php"); ?>

    <div class="content-sort">
        <h3>فیلتر (دسته بندی) : </h3>

        <a href="/content/youtube/" class="sort <?= $selected_category === null ? 'active' : '' ?>">همه</a>
        <a href="?category=game" class="sort <?= $selected_category === 'game' ? 'active' : '' ?>">بازی</a>
        <a href="?category=vlog" class="sort <?= $selected_category === 'vlog' ? 'active' : '' ?>">ولاگ</a>
        <a href="?category=reaction" class="sort <?= $selected_category === 'reaction' ? 'active' : '' ?>">ری‌اکشن</a>
        <a href="?category=challenge" class="sort <?= $selected_category === 'challenge' ? 'active' : '' ?>">چالش</a>
        <a href="?category=podcast" class="sort <?= $selected_category === 'podcast' ? 'active' : '' ?>">پادکست</a>
    </div>

    <div class="content-list">
        <h1>برترین محتوا های یوتیوبی</h1>

        <div class="content-cards">
            <?php if (empty($contents)): ?>
                <p>هیچ محتوایی در این دسته‌بندی وجود ندارد.</p>
            <?php else: ?>
                <?php foreach ($contents as $content): ?>
                    <div class="content-card" id="card-<?= htmlspecialchars($content['id']); ?>">
                        <img
                            class="profile"
                            data-id="card-<?= htmlspecialchars($content['id']); ?>"
                            data-src="<?= htmlspecialchars($content['cover']); ?>"
                            src="<?= htmlspecialchars($content['cover']); ?>"
                            alt="<?= htmlspecialchars($content['name']); ?>">

                        <h2><a href="<?= $content['id']; ?>"><?= htmlspecialchars($content['name']); ?></a></h2>

                        <p><?= htmlspecialchars($content['caption']); ?></p>

                        <?php if ($content['creator_type'] == 1): ?>
                            <a href="/streamers/<?= htmlspecialchars($content['creator_id']); ?>">
                                توسط: <?= htmlspecialchars($content['creator_name']); ?>
                            </a>
                        <?php elseif ($content['creator_type'] == 2): ?>
                            <a href="/youtubers/<?= htmlspecialchars($content['creator_id']); ?>">
                                توسط: <?= htmlspecialchars($content['creator_name']); ?>
                            </a>
                        <?php else: ?>
                            <p>توسط: <?= htmlspecialchars($content['creator_name']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include("../../components/footer.php"); ?>

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