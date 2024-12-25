<?php
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT id, title, caption, cover_img, created_at FROM blog ORDER BY created_at DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching blogs: " . $e->getMessage();
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
    <title>Blog List</title>
</head>

<body>
    <?php include("../components/header.php"); ?>

    <div class="blogs-list">
        <?php foreach ($blogs as $blog): ?>
            <div class="blog-card">
                <img src="<?= htmlspecialchars($blog['cover_img']) ?>?v=<?php echo time(); ?>" alt="">

                <a href="<?= htmlspecialchars($blog['id']) ?>">
                    <?= htmlspecialchars($blog['title']) ?>
                </a>

                <p><?= htmlspecialchars_decode(mb_strimwidth($blog['caption'], 0, 200, ' ...')) ?></p>

                <p class="jalali-date" data-date="<?= htmlspecialchars($blog['created_at']) ?>"></p>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include("../components/footer.php"); ?>

    <script>
        document.querySelectorAll('.jalali-date').forEach(function(dateElement) {
            var dateStr = dateElement.getAttribute('data-date');
            var dateObj = new Date(dateStr);
            var jalaliDate = jalaali.toJalaali(dateObj);
            var formattedDate = jalaliDate.jd + " " + getPersianMonth(jalaliDate.jm) + " " + jalaliDate.jy;

            dateElement.innerText = formattedDate;
        });

        function getPersianMonth(monthNumber) {
            var months = [
                'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
                'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
            ];
            return months[monthNumber - 1];
        }
    </script>
</body>

</html>