<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">
    <title>Content Types</title>
</head>

<body>
    <?php include("../components/header.php"); ?>

    <div class="gallery">
        <?php
        $directory = 'img/';
        $images = glob($directory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        foreach ($images as $image) {
            $filename = basename($image);
            echo "
            <div class='gallery-item'>
                <img src='$image' alt='$filename'>
                <div class='hover-overlay'>
                    <a href='$image' download='$filename' class='download-btn'>دانلود عکس</a>
                </div>
            </div>
            ";
        }
        ?>
    </div>

    <?php include("../components/footer.php"); ?>
</body>

</html>