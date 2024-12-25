-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2024 at 08:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tyvids.ir`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` int(11) NOT NULL,
  `cover_img` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `caption`, `created_at`, `author`, `cover_img`, `content`, `tags`) VALUES
(1, 'استریم چیست ؟', '&lt;p&gt;استریم (Streaming) یکی از مفاهیم پرکاربرد در دنیای دیجیتال امروز است که نقشی کلیدی در نحوه دسترسی و مصرف محتواهای آنلاین ایفا می‌کند. این فناوری به کاربران این امکان را می‌دهد که به صورت بلادرنگ (Real-Time) به محتواهایی مانند فیلم، موسیقی، بازی و', '2024-11-21 13:40:09', 1, '../assets/uploads/1.jpg', '<h3>مقدمه</h3><p>استریم (Streaming) یکی از مفاهیم پرکاربرد در دنیای دیجیتال امروز است که نقشی کلیدی در نحوه دسترسی و مصرف محتواهای آنلاین ایفا می‌کند. این فناوری به کاربران این امکان را می‌دهد که به صورت بلادرنگ (Real-Time) به محتواهایی مانند فیلم، موسیقی، بازی و حتی آموزش دسترسی پیدا کنند، بدون نیاز به دانلود فایل کامل آن. در این مقاله به بررسی کامل مفهوم استریم، انواع آن، نحوه کار، مزایا و کاربردهای آن می‌پردازیم.</p><h3>1. استریم چیست؟</h3><p>استریم یا پخش جریانی فرآیندی است که در آن داده‌های چندرسانه‌ای (مانند ویدئو، موسیقی یا بازی) به صورت مداوم و قطعه‌قطعه به دستگاه کاربر منتقل می‌شود. برخلاف روش‌های سنتی دانلود، استریم به شما اجازه می‌دهد بلافاصله پس از شروع دانلود قطعات اولیه، محتوای مورد نظر خود را مشاهده یا گوش کنید.</p><h4>ویژگی‌های اصلی استریم:</h4><ul><li><strong>انتقال داده در لحظه</strong>: محتوا همزمان با انتقال به دستگاه اجرا می‌شود.</li><li><strong>نیاز به اینترنت پایدار</strong>: کیفیت استریم به سرعت و ثبات اینترنت بستگی دارد.</li><li><strong>عدم نیاز به فضای ذخیره‌سازی بالا</strong>: فایل‌های کامل در دستگاه ذخیره نمی‌شوند.</li></ul><h3>2. انواع استریم</h3><p>استریم را می‌توان به انواع مختلفی تقسیم‌بندی کرد که هر کدام در موقعیت‌های خاصی کاربرد دارند:</p><h4>الف) استریم صوتی</h4><p>این نوع استریم شامل انتقال موسیقی، پادکست و فایل‌های صوتی دیگر است. خدماتی مانند <strong>Spotify</strong>، <strong>Apple Music</strong> و <strong>SoundCloud</strong> نمونه‌های رایج این نوع هستند.</p><h4>ب) استریم ویدئویی</h4><p>استریم ویدئو شامل پخش فیلم‌ها، سریال‌ها و ویدئوهای آموزشی است. پلتفرم‌هایی مانند <strong>YouTube</strong>، <strong>Netflix</strong> و <strong>Amazon Prime Video</strong> از این نوع استفاده می‌کنند.</p><h4>ج) استریم بازی</h4><p>با رشد صنعت گیمینگ، استریم بازی نیز محبوبیت زیادی پیدا کرده است. این نوع استریم شامل بازی به صورت زنده (مانند <strong>Twitch</strong>) یا انجام بازی‌های سنگین روی سرورهای ابری (مانند <strong>Google Stadia</strong>) است.</p><h4>د) استریم زنده (Live Streaming)</h4><p>استریم زنده شامل پخش همزمان وقایع، رویدادها و جلسات است. این فناوری در شبکه‌های اجتماعی مانند <strong>Instagram Live</strong> و <strong>Facebook Live</strong> و همچنین وبینارها مورد استفاده قرار می‌گیرد.</p><h3>3. استریم چگونه کار می‌کند؟</h3><p>استریم از فناوری‌های پیشرفته‌ای برای انتقال داده‌ها به صورت پیوسته استفاده می‌کند. روند کار به این شکل است:</p><ol><li><strong>تقسیم محتوا به قطعات کوچک</strong>: فایل‌های صوتی یا ویدئویی به قطعات داده (Packets) کوچک تقسیم می‌شوند.</li><li><strong>انتقال داده از سرور به کلاینت</strong>: این داده‌ها از طریق اینترنت به دستگاه کاربر منتقل می‌شوند.</li><li><strong>رمزگشایی و نمایش محتوا</strong>: دستگاه کاربر داده‌ها را دریافت و رمزگشایی کرده و بلافاصله نمایش می‌دهد.</li></ol><h4>پروتکل‌های اصلی استریم:</h4><ul><li><strong>HLS (HTTP Live Streaming)</strong>: توسط اپل برای پخش ویدئو استفاده می‌شود.</li><li><strong>MPEG-DASH</strong>: یک پروتکل رایج برای پخش ویدئو در کیفیت‌های مختلف.</li><li><strong>RTMP (Real-Time Messaging Protocol)</strong>: بیشتر در پخش زنده کاربرد دارد.</li></ul><h3>4. مزایای استریم</h3><p>استریم به دلیل مزایای منحصربه‌فردش، جایگزین روش‌های سنتی شده است:</p><ul><li><strong>دسترسی سریع به محتوا</strong>: نیاز به انتظار برای دانلود کامل فایل نیست.</li><li><strong>انعطاف‌پذیری در مصرف داده</strong>: محتوا بر اساس نیاز و در لحظه بارگذاری می‌شود.</li><li><strong>صرفه‌جویی در فضای ذخیره‌سازی</strong>: نیازی به ذخیره فایل‌های حجیم نیست.</li><li><strong>تنوع گسترده محتوا</strong>: کاربران به طیف گسترده‌ای از محتواهای متنوع دسترسی دارند.</li></ul><h3>5. چالش‌ها و محدودیت‌های استریم</h3><p>علی‌رغم مزایا، استریم با چالش‌هایی نیز همراه است:</p><ul><li><strong>وابستگی به اینترنت پرسرعت</strong>: کیفیت استریم به طور مستقیم به سرعت اینترنت وابسته است.</li><li><strong>هزینه‌های اشتراک</strong>: بسیاری از پلتفرم‌های استریم نیاز به پرداخت حق اشتراک دارند.</li><li><strong>مشکلات مربوط به پهنای باند</strong>: در صورتی که کاربران زیادی به اینترنت متصل باشند، کیفیت استریم ممکن است کاهش یابد.</li></ul><h3>6. کاربردهای استریم</h3><p>استریم در صنایع مختلف کاربرد دارد و روز به روز گسترده‌تر می‌شود:</p><ul><li><strong>سرگرمی</strong>: پخش فیلم، موسیقی و بازی‌های آنلاین.</li><li><strong>آموزش</strong>: ارائه دوره‌های آموزشی آنلاین و وبینارها.</li><li><strong>رویدادهای زنده</strong>: پخش زنده مسابقات ورزشی، کنسرت‌ها و مراسم‌ها.</li><li><strong>شبکه‌های اجتماعی</strong>: ارتباط زنده با مخاطبان در پلتفرم‌هایی مثل اینستاگرام و یوتیوب.</li></ul><h3>7. آینده استریم</h3><p>با پیشرفت تکنولوژی‌هایی مانند اینترنت 5G، واقعیت مجازی (VR) و هوش مصنوعی (AI)، انتظار می‌رود استریم به شکل‌های جدیدتری گسترش یابد. خدماتی مانند <strong>استریم تعاملی</strong> (Interactive Streaming) و <strong>استریم مبتنی بر هوش مصنوعی</strong> تجربه کاربری را به سطح بالاتری می‌برند.</p><h3>نتیجه‌گیری</h3><p>استریم به عنوان یک فناوری پیشرو در دنیای دیجیتال، نحوه مصرف محتوا را متحول کرده است. از پخش زنده رویدادها تا گوش دادن به موسیقی، این فناوری به ما امکان دسترسی بی‌وقفه و سریع به محتوا را می‌دهد. با رشد سریع این حوزه، استریم همچنان نقش کلیدی در زندگی روزمره ما ایفا خواهد کرد.</p>', '');

-- --------------------------------------------------------

--
-- Table structure for table `creators`
--

CREATE TABLE `creators` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `bio` text NOT NULL,
  `profile` text NOT NULL,
  `record` date NOT NULL,
  `tags` text NOT NULL,
  `youtube_link` text NOT NULL,
  `twitch_id` text NOT NULL,
  `instagram_id` text NOT NULL,
  `twitter_id` text NOT NULL,
  `telegram_link` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creators`
--

INSERT INTO `creators` (`id`, `name`, `bio`, `profile`, `record`, `tags`, `youtube_link`, `twitch_id`, `instagram_id`, `twitter_id`, `telegram_link`, `type`) VALUES
(1, 'Amir Eyzed', 'بابای پلو', '/assets/creators/amireyzed.jpg', '2017-01-20', 'amireyzed,امیر ایزد,amir eyzed, amir, eyzed,stream,streamer,youtube,youtuber,امیر,ایزد,استریمر,استریم,یوتیوب,یوتیوبر', 'UCUR2yKAhEOgxWUPSM0wEOPA', 'amireyzed', 'amireyzed', 'amireyzed_', 'AmirEyZed', '1'),
(2, 'Sam Saberi', 'Mad Sniper', '/assets/creators/samsaberi.jpg', '2020-06-26', 'samsaberi,سام صابری,sam saberi,sam,saberi,stream,streamer,youtube,youtuber,صابری,سام,استریمر,استریم,یوتیوب,یوتیوبر', 'UC2G0GDApB82moaUDE0BkG0w', 'samsaberi', 'samsaberi', 'samsaberii', '', '1'),
(3, 'Mia Plays', 'Kimia Ravangar', '/assets/creators/miaplays.jpg', '2017-06-08', 'miaplays,میا پلیز,mia plays,mia,plays,stream,streamer,youtube,youtuber,پلیز,میا,استریمر,استریم,یوتیوب,یوتیوبر', 'UC3Uv6kBh55Jx0Ou0C7-Gudg', 'miaplays', 'miakimioo', '', 'miaplays', '2'),
(4, 'Aria Keoxer', 'Video creator', '/assets/creators/ariakeoxer.jpg', '2016-12-21', 'ariakeoxer,آریا کئوسر,aria keoxer,aria,keoxer,stream,streamer,youtube,youtuber,کئوکسر,کوکسر,آریا,استریمر,استریم,یوتیوب,یوتیوبر', 'UCDvxToLVx545jFXCgThOtTw', 'keoxer', 'keoxer', 'ariakeoxer', 'Keoxer', '2'),
(5, 'Farhad Xray', 'Gaming video creator', '/assets/creators/farhadxray.jpg', '2018-12-12', 'farhadexray,فرهاد ایکسری,farhad xray,farhad,xray,stream,streamer,youtube,youtuber,ایکسری,توانا,فرهاد,استریمر,استریم,یوتیوب,یوتیوبر,فرهاد توانا', 'UCly_Nmr4z2j3Wugi9Ov4Zmg', 'farhadxray', 'farhadtavana', 'xrayfarhad', '', '1'),
(6, 'Farshad Silent', 'Persian Youtuber', '/assets/creators/farshadsilent.jpg', '2019-08-17', 'farshadsilent,فرشاد سایلنت,farshad silent,farshad,silent,stream,streamer,youtube,youtuber,سایلنت,ساکت,فرشاد,استریمر,استریم,یوتیوب,یوتیوبر', 'UCYnsnFMvYFhYaDNFNQbGGHQ', 'farshadsilent', 'farshadsilent', 'silentfarshad', 'farshadsilent', '2'),
(7, 'Putak', 'Brave Putak', '/assets/creators/pooriaputak.jpg', '2018-07-07', 'pooriaputak,پوریا پوتک,pooria putak,pooria,putak,rap,rapper,youtube,youtuber,پوتک,پوریا,رپر,رپ,یوتیوب,یوتیوبر', 'UCa20QQoV4gaLv9XRki-ynWQ', 'pooriaputak', 'braveputak', 'pooriaputak', 'putakk', '2'),
(8, 'Amir Phantom', 'Play DotA', '/assets/creators/amirphantom.jpg', '2017-07-25', 'amirphantom,امیر فانتوم,amir phantom,amir,phantom,stream,streamer,youtube,youtuber,فانتوم,امیر,استریمر,استریم,یوتیوب,یوتیوبر', 'UC0u82cEw9IRvJ5x8i_NBZWQ', 'amirphanthom', 'amirphanthom_', 'amirphanthom', 'phgod', '1'),
(9, 'Ali Zelzele', 'Football is God’s gift', '/assets/creators/alizelzele.jpg', '2018-11-10', 'alizelzele,علی زلزله,ali zelzele,ali,zelzele,stream,streamer,youtube,youtuber,زلزله,علی,استریمر,استریم,یوتیوب,یوتیوبر', 'UCEfLKEqAOL5Cx1RGsKgZFLQ', 'alizelzele', 'alikarimi76', 'ALIZELZELE76', 'alizelzelee', '1'),
(10, 'Sogang', 'Youtuber 🇦🇪', '/assets/creators/sogang.jpg', '2019-01-09', 'alirezasogang,علیرضا سوگنگ,alireza sogang,alireza,sogang,stream,streamer,youtube,youtuber,سوگنگ,علیرضا,استریمر,استریم,یوتیوب,یوتیوبر', 'UCxym7GWKXPXYISgy7U-AOYw', '', 'sogang', 'sogangyt', 'sogangyt', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'amirmasoudabedi', 'amirmasoudabedi1387@gmail.com', '$2y$10$t9XkZDzwZTnpm3KDyPcQ9uk0vmsZhQCH36YXsgdjgPD9qQRyD1aba', '2024-11-21 13:37:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `creators`
--
ALTER TABLE `creators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `creators`
--
ALTER TABLE `creators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
