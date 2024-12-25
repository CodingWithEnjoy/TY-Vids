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

    <div class="api-hero">
        <h1>اولین API یوتیوبر ها و استریمر های ایرانی !</h1>

        <div class="wrapper"></div>

        <p>برای استفاده از API تولید کنندگان محتوا به لینک زیر <span>Request</span> بفرستید :</p>

        <a href="/api/creators">/api/creators</a>

        <p>دقت کنید که کوئری <span>type</span> ، اجباری است :</p>

        <a>
            /api/creators?type=1 => Streamers
            <br>
            /api/creators?type=2 => Youtubers
        </a>

        <p>همچنین برای گرفتن یک یوتیوبر یا استریمر خاص میتوانید از کوئری <span>id</span> استفاده کنید :</p>

        <a>/api/creators?type={q}&id={q}</a>

        <p>برای <span>عکس پروفایل</span> تولید کنندگان محتوا هم از لینک زیر استفاده کنید :</p>

        <a>
            /assets/creators/{creator_name}.jpg
            <br>
            example => /assets/creators/amireyzed.jpg
        </a>

        <div class="wrapper"></div>

        <p>برای استفاده از API محتوا های استریمی و یوتیوبی به لینک زیر <span>Request</span> بفرستید :</p>

        <a href="/api/contents">/api/contents</a>

        <p>دقت کنید که کوئری <span>type</span> ، اجباری است :</p>

        <a>
            /api/contents?type=1 => Stream
            <br>
            /api/contents?type=2 => Youtube
        </a>

        <p>همچنین برای گرفتن یک محتوای یوتیوبی یا استریمی خاص میتوانید از کوئری <span>id</span> استفاده کنید :</p>

        <a>/api/contents?type={q}&id={q}</a>

        <p>برای <span>عکس پروفایل</span> محتوا ها هم از لینک زیر استفاده کنید :</p>

        <a>
            /assets/contents/{content_name}.jpg
            <br>
            example => /assets/contents/midnight1.jpg
        </a>
    </div>

    <?php include("../components/footer.php"); ?>
</body>

</html>