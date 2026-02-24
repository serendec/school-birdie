-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: o5044s2-90.kagoya.net
-- 生成日時: 2025 年 9 月 06 日 08:19
-- サーバのバージョン： 5.7.44
-- PHP のバージョン: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `lms_test`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci,
  `video_duration` int(11) DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `post_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `display_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `courses`
--

INSERT INTO `courses` (`id`, `title`, `video`, `video_duration`, `content`, `category_id`, `school_id`, `post_status`, `display_order`, `created_at`, `updated_at`) VALUES
(1, '講座3-1', NULL, NULL, '<p>テストテスト</p>\r\n<p>&nbsp;</p>\r\n<p>説明やで</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>講座作成のときにカテゴリ作成ページへのリンクあると便利</p>\r\n<p>&nbsp;</p>', 1, 1, 'publish', 1, '2023-11-28 11:15:06', '2024-11-11 05:56:06'),
(2, 'ゴルフの基本　初心者の方向け', NULL, NULL, NULL, 3, 2, 'publish', 1, '2024-01-10 09:15:16', '2024-01-10 09:15:16'),
(3, '20240216　ゴルフとの向き合い方', NULL, NULL, '<p>&nbsp;</p>\r\n<p>動画その１</p>\r\n<p><a title=\"動画１\" href=\"https://www.youtube.com/watch?v=ltlyHNQqccM&amp;feature=youtu.be\" target=\"_blank\" rel=\"noopener\">https://www.youtube.com/watch?v=ltlyHNQqccM&amp;feature=youtu.be</a></p>\r\n<p>&nbsp;</p>\r\n<p>動画その２</p>\r\n<p><a title=\"動画その２\" href=\"https://www.youtube.com/watch?v=apOIwnVL-wY&amp;feature=youtu.be\" target=\"_blank\" rel=\"noopener\">https://www.youtube.com/watch?v=apOIwnVL-wY&amp;feature=youtu.be</a></p>\r\n<p>&nbsp;</p>\r\n<p>動画その３</p>\r\n<p><a href=\"https://www.youtube.com/watch?v=opG35KWwW6Y&amp;feature=youtu.be\">https://www.youtube.com/watch?v=opG35KWwW6Y&amp;feature=youtu.be</a></p>\r\n<p>&nbsp;</p>\r\n<p>動画その４</p>\r\n<p><a href=\"https://www.youtube.com/watch?v=Iup3VvmPEv4&amp;feature=youtu.be\" target=\"_blank\" rel=\"noopener\">https://www.youtube.com/watch?v=Iup3VvmPEv4&amp;feature=youtu.be</a></p>', 4, 2, 'publish', 1, '2024-03-25 11:24:48', '2024-04-26 00:27:32'),
(4, 'ゴルフのマナー', NULL, NULL, '<p>あてた</p>', 4, 2, 'draft', 2, '2024-05-01 04:28:08', '2024-05-01 04:28:08'),
(5, '講座1-1', NULL, NULL, '<p>動画と説明文を掲載できます。</p>\r\n<p>生徒側で、視聴後に「完了」マークをつけることができます。</p>', 6, 1, 'publish', 2, '2024-07-12 02:22:56', '2024-12-06 09:03:17'),
(6, '１　BHO（出来ない理由を考えるよりも）　クリエイティブ脳は解決策を考える為に使おう！', NULL, NULL, '<p><a href=\"https://tldv.io/app/meetings/66f2116b2dec100013dde237/\">https://tldv.io/app/meetings/66f2116b2dec100013dde237/</a></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>出来ない理由を考えるより、ポジティブに前向きに、解決案を考えていこう！</p>\r\n<p>ミスを怖がらない、チャレンジしないこと自体が失敗でありリスク</p>', 7, 6, 'publish', 1, '2024-09-24 12:18:43', '2024-09-24 12:21:25'),
(7, 'AI活用に関して　　20240924', NULL, NULL, '<p><a href=\"https://tldv.io/app/meetings/66f21294bf46b60013ed61bc/\">https://tldv.io/app/meetings/66f21294bf46b60013ed61bc/</a></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>最新のAIで使えそうなツール、サービスの共有</p>\r\n<p>AIをドンドン取り入れていこう。　数年でトレンド変わります</p>', 9, 6, 'publish', 1, '2024-09-24 12:31:47', '2024-09-24 12:31:47'),
(8, '講座1-2', NULL, NULL, NULL, 6, 1, 'publish', 1, '2024-11-11 05:55:45', '2024-12-06 09:03:17'),
(9, '動画', 'TgiOUj1eofrR9lv92qIHZTswkdEQFjODaW9ln0Wm.mp4', NULL, NULL, 2, 1, 'publish', 1, '2024-12-09 03:58:55', '2024-12-09 03:59:01'),
(10, 'テスト', NULL, NULL, NULL, 6, 1, 'publish', 3, '2024-12-09 05:45:29', '2024-12-09 05:45:29'),
(12, 'スイングレッスン１', 'Lu9vkKGS457H4cICdL4RVdh1dDLTIE9kwGHXdJQy.mp4', NULL, NULL, 2, 1, 'publish', 2, '2024-12-23 03:45:35', '2024-12-23 03:45:54'),
(13, 'テスト　動画アップ', 'VEpnSq2luEFtm0EzmDnogYB0pwjDkxZmpQlUQdcL.mp4', NULL, NULL, 7, 6, 'publish', 2, '2025-03-13 08:08:30', '2025-03-13 08:36:19'),
(14, 'テスト', 'TdvQYFGbqVdpfimwdpszr8IOuUin3McaiWpi8Gyi.mp4', NULL, NULL, 7, 6, 'publish', 3, '2025-03-13 08:16:24', '2025-03-13 08:44:22'),
(15, 'テスト動画　20250322', 'AQAbqW8Vzedw0w7yck5QJJCxLJTKQHJC0wxzf9Bw.mp4', NULL, NULL, 7, 6, 'draft', 4, '2025-03-22 08:29:01', '2025-03-22 08:30:28'),
(16, 'test 20250322', 't4iH0yw3D515I07nfos2wJ2k5r7Qmu431QVeuJsm.mp4', NULL, NULL, 7, 6, 'publish', 5, '2025-03-22 08:30:52', '2025-03-22 08:32:20'),
(17, 'test 20250322', 'CKJ4qhLkxLoJJMv4gytHW9ujqeFsEtxTztBdWz2z.mp4', NULL, NULL, 7, 6, 'publish', 6, '2025-03-22 08:33:48', '2025-03-22 08:35:17'),
(18, 'テスト', 'GL8RT7zSJVIc5pzVTXF2Ecqoa9djQkKTUwFfmi7V.mp4', NULL, NULL, 6, 1, 'draft', 4, '2025-03-27 14:21:03', '2025-03-27 16:40:49'),
(19, 'テスト１－１', 'OxkklzFMMImd0fhn2IkISsvund4kVp6TRVhPuXo9.mp4', NULL, NULL, 2, 1, 'draft', 3, '2025-03-27 15:23:19', '2025-03-27 15:41:16'),
(20, 'test1-1', 'TmOpPxWOq6vkXyPCbkpM7kMSSKt0s242q4obilyp.mp4', NULL, NULL, 2, 1, 'draft', 4, '2025-03-27 15:34:08', '2025-03-27 17:04:43'),
(21, '動画2', 'Gm3iDMYpGYzXue9EvMmAbgloeqG43NXxM3Q1SM94.mp4', NULL, NULL, 6, 1, 'publish', 5, '2025-04-10 06:01:40', '2025-04-10 06:02:01'),
(22, '動画テスト', 'hK6Y6KFHaFuXTB87HOq0vEktkVIw4Zmu1U1VLRgN.mp4', NULL, NULL, 2, 1, 'publish', 5, '2025-04-14 08:08:07', '2025-04-14 08:08:30'),
(23, '動画4', 'yX3gY2FqbVT0dUgfK536Plc4kpgO4ZS5FXFrp23B.mp4', NULL, NULL, 2, 1, 'publish', 6, '2025-04-15 01:31:03', '2025-04-15 01:31:24'),
(24, 'テスト動画0421-01', '0jwh1j7kuXW2M0FUyZ038foEhXdETmj8ZN8rB6Ex.mp4', NULL, NULL, 2, 1, 'publish', 7, '2025-04-21 08:29:18', '2025-04-21 08:29:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `course_categories`
--

CREATE TABLE `course_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `display_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `course_categories`
--

INSERT INTO `course_categories` (`id`, `name`, `school_id`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'レッスン３', 1, 3, '2023-11-28 11:13:50', '2024-12-23 03:48:12'),
(2, 'レッスン２', 1, 2, '2023-11-28 11:14:02', '2024-12-23 03:48:07'),
(3, 'ゴルフの基礎知識', 2, 1, '2024-01-10 09:14:37', '2024-01-10 09:14:37'),
(4, 'レッスンセミナー　アーカイブ動画', 2, 2, '2024-03-25 11:21:36', '2024-03-25 11:22:20'),
(6, 'レッスン１', 1, 1, '2024-07-12 02:23:04', '2024-12-23 03:48:02'),
(7, 'セレンデック　社内動画', 6, 1, '2024-09-24 12:15:04', '2024-09-24 12:15:04'),
(8, '技術・手順の解説動画', 6, 2, '2024-09-24 12:19:58', '2024-09-24 12:19:58'),
(9, '情報共有', 6, 3, '2024-09-24 12:29:34', '2024-09-24 12:29:34'),
(10, '新人さん用', 6, 4, '2024-09-24 12:30:10', '2024-09-24 12:30:10'),
(11, 'グリップ', 3, 1, '2024-12-19 15:40:00', '2024-12-19 15:40:00'),
(12, 'アドレス', 3, 2, '2024-12-19 15:40:08', '2024-12-19 15:40:08'),
(13, 'ゴルフクラブ', 3, 3, '2024-12-19 15:40:15', '2024-12-19 15:40:15'),
(14, 'ドライバー', 2, 3, '2024-12-26 02:22:22', '2024-12-26 02:22:22');

-- --------------------------------------------------------

--
-- テーブルの構造 `course_comments`
--

CREATE TABLE `course_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `parent_comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mentioned_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `course_comments`
--

INSERT INTO `course_comments` (`id`, `course_id`, `parent_comment_id`, `mentioned_user_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 3, 'ゴルフの基本', '2024-01-10 09:15:46', '2024-01-10 09:15:46'),
(4, 3, NULL, NULL, 3, 'https://drive.google.com/file/d/1LHLieh1BiYmlzHrsPvxhiHOE4A5Cw60Q/view?usp=sharing\r\nここからも見れます', '2024-03-25 11:32:00', '2024-03-25 11:32:00'),
(6, 3, NULL, NULL, 3, 'https://drive.google.com/drive/folders/1CoU4Zu37le5kT13zMGKa9H8G3V_K1ntE?usp=drive_link\r\n\r\nこちらに全ての動画が閲覧可能です\r\n<a href=\"https://drive.google.com/drive/folders/1CoU4Zu37le5kT13zMGKa9H8G3V_K1ntE?usp=drive_link\">動画一覧</a>', '2024-03-25 11:36:07', '2024-03-25 11:36:07'),
(7, 5, NULL, NULL, 18, '講座1-1　生徒コメント', '2024-11-11 05:59:44', '2024-11-11 05:59:44'),
(8, 5, NULL, NULL, 13, '講師　管理者なし', '2024-12-09 02:48:11', '2024-12-09 02:48:11'),
(9, 8, NULL, NULL, 18, '生徒', '2024-12-09 02:56:51', '2024-12-09 02:56:51'),
(10, 5, NULL, NULL, 18, '生徒', '2024-12-09 02:59:11', '2024-12-09 02:59:11'),
(11, 5, NULL, NULL, 18, '@ テスト 管理者権限\r\n生徒', '2024-12-09 02:59:43', '2024-12-09 02:59:43'),
(12, 8, 9, 18, 1, '管理者あり', '2024-12-09 03:18:18', '2024-12-09 03:18:18'),
(13, 8, 9, 18, 13, '管理者なし', '2024-12-09 03:18:42', '2024-12-09 03:18:42'),
(14, 5, 11, 18, 13, '管理者なし', '2024-12-09 03:19:40', '2024-12-09 03:19:40'),
(15, 1, NULL, NULL, 18, '生徒', '2024-12-09 03:20:50', '2024-12-09 03:20:50'),
(16, 12, NULL, NULL, 25, '練習します！', '2024-12-23 03:46:27', '2024-12-23 03:46:27');

-- --------------------------------------------------------

--
-- テーブルの構造 `course_comment_likes`
--

CREATE TABLE `course_comment_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_comment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `course_comment_likes`
--

INSERT INTO `course_comment_likes` (`id`, `user_id`, `course_comment_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2024-01-11 16:53:41', '2024-01-11 16:53:41'),
(3, 1, 9, '2024-12-09 03:18:02', '2024-12-09 03:18:02');

-- --------------------------------------------------------

--
-- テーブルの構造 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `video_category` varchar(45) NOT NULL,
  `video_category_id` bigint(20) UNSIGNED NOT NULL,
  `video` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `video_category`, `video_category_id`, `video`, `created_at`, `updated_at`) VALUES
(3, 18, 'video_advice', 11, 'upYVBee63jyoDNAdg7iq4rxmiKGR0OFAfgWNetsm.mp4', '2024-12-09 03:57:16', '2024-12-09 03:57:16'),
(4, 18, 'lesson_record', 17, 'zuaVfqoeOWdjAQGrNgOKK1NtQ5PGm9dt3bOFmTMv.mp4', '2024-12-09 03:57:23', '2024-12-09 03:57:23'),
(5, 37, 'lesson_record', 26, 'QcWJv1Xg9rK9t8IQyW6FNNVfHVrFmId2asu04b8n.mov', '2025-02-04 14:10:16', '2025-02-04 14:10:16'),
(6, 37, 'lesson_record', 27, '0SW8nnfrDBj3JyvcNwsZVmwoK4aKdtgXHP8o1bFT.mov', '2025-02-05 05:59:33', '2025-02-05 05:59:33');

-- --------------------------------------------------------

--
-- テーブルの構造 `forums`
--

CREATE TABLE `forums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `images` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `forums`
--

INSERT INTO `forums` (`id`, `school_id`, `user_id`, `title`, `content`, `images`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '接待にお勧めのゴルフ場（関東）', 'ビジネスに使える！\r\n接待にお勧めのゴルフ場', NULL, '2024-01-10 11:52:22', '2024-01-10 11:52:22'),
(2, 2, 4, 'テスト　スレッド', 'テスト', NULL, '2024-01-11 16:52:55', '2024-01-11 16:52:55'),
(3, 1, 1, 'おすすめのゴルフクラブを教えてください！', '近々、カスタムしたクラブの購入を考えています。\r\n（自分への誕生日プレゼントに、思い切って笑）\r\n○○○○が候補なのですが、実際に使った方のご感想聞かせていただけませんか？', NULL, '2024-03-06 01:18:43', '2024-03-06 01:18:43'),
(4, 1, 1, '○○○○大会の感想板', '僕はTV中継を見ていたのですが、○○選手が■■■で見せたスイングがすごくて興奮してました。', NULL, '2024-03-21 06:55:55', '2024-03-21 06:55:55'),
(5, 1, 13, '講師　管理者なし', '内容', NULL, '2024-12-09 02:48:39', '2024-12-09 02:48:39'),
(6, 1, 18, '生徒', '内容', NULL, '2024-12-09 02:50:41', '2024-12-09 02:50:41'),
(7, 1, 18, '生徒', '内容', 'gvhfQHhLoMNr3r6vVIF0DAipQGilx64rX5yxO6yC.mp4', '2024-12-09 03:57:52', '2024-12-09 03:57:53'),
(8, 1, 18, '生徒', '内容', 'kdf68oPqtfBn9S1RBGMnKM2J4sfXg387wzWKh4OU.mp4', '2024-12-09 03:58:06', '2024-12-09 03:58:06'),
(9, 1, 18, '生徒', '内容', 'Uu778fG5i48tYJjPKnV7X4bnJgdLGRKeRNeZzKF1.mp4', '2024-12-09 03:58:11', '2024-12-09 03:58:11'),
(10, 1, 18, '生徒', '内容', 'fBrJL62hM3IWU9VZ7qN4dU8g7hJIHPYPjYFg0JPP.mp4', '2024-12-09 03:58:11', '2024-12-09 03:58:11'),
(11, 1, 18, '生徒', '内容', 'wD1SNIVC6Zg0uApSK1pkovA94sTTbfcLzmvjMLCB.mp4', '2024-12-09 03:58:12', '2024-12-09 03:58:12'),
(12, 1, 18, '生徒', '内容', 'Y79ayDnpLpBMvHioPXqN82ZZPPWIWe3snAnbl8gD.mp4', '2024-12-09 03:58:12', '2024-12-09 03:58:12'),
(13, 1, 18, '生徒', '内容', 'nxTjRGQfNDNBz6t8nsgki14jrq7KSjPVSewvGbos.png', '2024-12-09 03:58:12', '2024-12-09 03:58:12'),
(14, 1, 1, 'ゴルフの最新情報です', '最近公開された最新情報共有します', NULL, '2024-12-23 03:49:28', '2024-12-23 03:49:28');

-- --------------------------------------------------------

--
-- テーブルの構造 `forum_bookmarks`
--

CREATE TABLE `forum_bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `forum_comments`
--

CREATE TABLE `forum_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `parent_comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mentioned_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `forum_comments`
--

INSERT INTO `forum_comments` (`id`, `forum_id`, `parent_comment_id`, `mentioned_user_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 3, 4, 'インターから近くて、都心からも近くて、平坦でスコアが出やすいコースがいいですね。接待には。', '2024-01-11 16:52:09', '2024-01-11 16:52:09'),
(2, 2, NULL, NULL, 4, 'スライスするねん、なんでやねん', '2024-01-11 16:53:17', '2024-01-11 16:53:17'),
(3, 2, 2, 4, 3, 'そりゃそうや、フェイスが開いているからやねん！', '2024-01-11 16:56:04', '2024-01-11 16:56:04'),
(4, 3, NULL, NULL, 1, 'いいですね！\r\n（お誕生日おめでとうございます☆）\r\n\r\n○○○○ならちょうど使っています。\r\n昔から知っている人は知ってるお馴染みって感じですね。\r\n吸いつくような打感で、飛距離も伸びやすいです。', '2024-03-06 01:22:00', '2024-03-06 01:22:00'),
(5, 3, 4, NULL, 1, '私、絶賛愛用中です！', '2024-03-06 01:22:35', '2024-03-06 01:22:35'),
(6, 3, NULL, NULL, 1, 'どんなに評判良くても試し打ちすることオススメします。\r\n\r\nエポンではないんですけど、以前口コミ良くて即決したら自分にはめちゃめちゃ合わなく\r\nて、泣きました(T_T)\r\n候補とそれ以外とでしっかり比べて、素敵な誕生日プレゼント見つけてくださいませ！', '2024-03-06 01:22:42', '2024-03-06 01:22:42'),
(7, 5, NULL, 13, 18, '生徒', '2024-12-09 02:50:27', '2024-12-09 02:50:27'),
(8, 4, NULL, 1, 18, '生徒', '2024-12-09 02:57:24', '2024-12-09 02:57:24'),
(9, 4, NULL, 1, 18, '生徒', '2024-12-09 02:58:18', '2024-12-09 02:58:18'),
(10, 6, NULL, NULL, 18, '生徒', '2024-12-09 02:58:35', '2024-12-09 02:58:35'),
(11, 14, NULL, 1, 25, 'すごいですね〜', '2024-12-23 03:49:45', '2024-12-23 03:49:45');

-- --------------------------------------------------------

--
-- テーブルの構造 `forum_comment_likes`
--

CREATE TABLE `forum_comment_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `forum_comment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `forum_comment_likes`
--

INSERT INTO `forum_comment_likes` (`id`, `user_id`, `forum_comment_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2024-01-11 16:52:14', '2024-01-11 16:52:14'),
(2, 3, 2, '2024-01-11 16:55:39', '2024-01-11 16:55:39'),
(3, 1, 4, '2024-03-06 01:23:08', '2024-03-06 01:23:08');

-- --------------------------------------------------------

--
-- テーブルの構造 `forum_likes`
--

CREATE TABLE `forum_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `forum_tag`
--

CREATE TABLE `forum_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forum_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `forum_tag`
--

INSERT INTO `forum_tag` (`id`, `forum_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2024-01-11 16:52:55', '2024-01-11 16:52:55'),
(2, 3, 3, '2024-03-06 01:18:43', '2024-03-06 01:18:43'),
(3, 4, 2, '2024-03-21 06:55:55', '2024-03-21 06:55:55'),
(4, 6, 2, '2024-12-09 02:50:41', '2024-12-09 02:50:41'),
(5, 14, 2, '2024-12-23 03:49:28', '2024-12-23 03:49:28'),
(6, 14, 3, '2024-12-23 03:49:28', '2024-12-23 03:49:28');

-- --------------------------------------------------------

--
-- テーブルの構造 `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `lesson_plans`
--

CREATE TABLE `lesson_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_plan_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_advice_available` tinyint(4) DEFAULT NULL,
  `video_advice_num` int(11) DEFAULT NULL,
  `video_advice_automatically_close_period` int(11) DEFAULT NULL,
  `course_available` tinyint(4) DEFAULT NULL,
  `lesson_record_available` tinyint(4) DEFAULT NULL,
  `forum_available` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `lesson_plans`
--

INSERT INTO `lesson_plans` (`id`, `school_id`, `name`, `price`, `stripe_plan_id`, `video_advice_available`, `video_advice_num`, `video_advice_automatically_close_period`, `course_available`, `lesson_record_available`, `forum_available`, `created_at`, `updated_at`) VALUES
(1, 2, '通常会員', NULL, NULL, 1, 5, 2, 1, 1, 1, '2024-01-10 14:10:57', '2024-01-10 14:10:57'),
(2, 1, 'スタンダード', NULL, NULL, 1, 4, 7, 1, 1, 1, '2024-02-13 01:35:49', '2024-02-13 01:35:49'),
(3, 1, 'スクール通学プラン', NULL, NULL, 1, NULL, NULL, 1, 1, 1, '2024-03-21 06:57:45', '2024-03-21 06:57:45'),
(4, 1, 'オンラインプラン', NULL, NULL, 1, NULL, NULL, 1, 1, 1, '2024-03-21 06:57:57', '2024-03-21 06:57:57'),
(5, 1, '初心者プラン', '50000', NULL, 1, 5, 10, 1, 1, 1, '2024-12-23 03:24:19', '2024-12-23 03:24:19'),
(6, 6, '動画レッスン付きフルセット', '30000', NULL, 1, 5, 4, 1, 1, 1, '2024-12-26 02:17:58', '2024-12-26 02:17:58'),
(7, 6, 'ベーシックプラン', '150000', NULL, 1, 2, 2, 1, 1, 1, '2024-12-26 02:18:33', '2024-12-26 02:18:33'),
(8, 6, 'レッスン単体プラン', '9800', NULL, 0, NULL, NULL, 1, 1, 1, '2024-12-26 02:18:53', '2024-12-26 02:18:53'),
(9, 3, 'レッスンカルテ', '980', 'prod_RWtRZqaxh1IMaB', 0, NULL, NULL, 1, 1, 0, '2024-12-26 05:31:33', '2025-01-05 09:01:10');

-- --------------------------------------------------------

--
-- テーブルの構造 `lesson_records`
--

CREATE TABLE `lesson_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `teacher_comment` text COLLATE utf8mb4_unicode_ci,
  `school_memo` text COLLATE utf8mb4_unicode_ci,
  `student_memo` text COLLATE utf8mb4_unicode_ci,
  `video` text COLLATE utf8mb4_unicode_ci,
  `lesson_date` date NOT NULL,
  `post_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `lesson_records`
--

INSERT INTO `lesson_records` (`id`, `teacher_id`, `student_id`, `title`, `summary`, `teacher_comment`, `school_memo`, `student_memo`, `video`, `lesson_date`, `post_status`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 'ゴルフレッスン　プッシュスライス', 'プッシュスライスが起きる\r\n\r\n原因　　フェースが開いてスイングプレーンのインサイドがからインパクトに向かっている', 'インパクト時のフェースターンは現在のクラブにはそくさない\r\nトップからハーフくらいまででフェースのターンは完了させるか、シャットにして初めから開閉すくなく\r\n\r\nインパクト時でローテーションするとチーピンやかんでダフリのりすくあり', 'メモやで　　楠本記載', NULL, NULL, '2024-01-10', 'publish', '2024-01-10 09:19:31', '2024-01-10 09:19:53'),
(2, 3, 4, 'クラブの軌道　スウィングプレーンより内側にならない', 'ダウンスイングに入るときにスウィングプレーンより内側からくると、プッシュやスライスの原因に\r\n\r\nカットではいが、スウィングプレーンよりアウトよりでおろせるように\r\n\r\nクラブの通り道を意識', 'フェースのターン、ローテーションはしてもしなくても。したほうが調整はきくし、スピードもあがるけど\r\nコントロールがむずかしくなる', '楠本記載', NULL, NULL, '2024-01-11', 'publish', '2024-01-11 16:35:42', '2024-01-11 17:00:53'),
(3, 3, 4, 'アプローチ　クラブ　ハンドアップ目に', 'アプローチは少しハンドアップに', NULL, NULL, NULL, NULL, '2024-01-19', 'publish', '2024-01-19 13:49:20', '2024-01-19 13:49:20'),
(4, 3, 4, 'LINE出し', 'フェイスコントロールをする\r\n\r\n左手でフェイス面でフェイスメンを意識', '左腕も意識', 'テスト', NULL, '2OjcNqZgUKVURZcXL4boyPntiAtXkqDrUw4AhVTM.mov', '2024-01-24', 'publish', '2024-01-24 04:16:07', '2024-09-02 04:17:49'),
(5, 3, 4, 'アプローチ', '吊してハンドファースト', 'ああ', 'ああ', NULL, NULL, '2024-01-25', 'publish', '2024-01-25 04:16:02', '2024-02-22 04:17:23'),
(6, 1, 2, 'スイングフォームの確認', 'レッスン概要の文章が残せます。\r\nサンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル', '生徒へのコメントが残せます。\r\nサンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル', '講師だけで共有でき、生徒には表示されないコメントが残せます。\r\nサンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル サンプル', NULL, 'F0daWhw97SpoKcWQ0kRx2I7kfJBQP4WgbIf2uTIv.mp4', '2024-02-16', 'publish', '2024-02-13 01:46:06', '2024-02-13 01:46:10'),
(7, 1, 2, 'スイングフォームの確認', 'レッスン概要の文章が残せます。', '生徒へのコメントが残せます。', '講師だけで共有でき、生徒には表示されないコメントが残せます。', NULL, 'nkt4qD6jvWysdTWxKl6AcV7HwpMRUKi4f3VJ8MV3.mp4', '2024-02-26', 'publish', '2024-02-26 01:10:30', '2024-02-26 01:10:35'),
(8, 3, 4, 'ハンドファースト', 'ハンドファーストを自然にするために、右にボールを置いてルックアップ', '手でハンドファーストを作りすぎない', 'めも', NULL, NULL, '2024-03-02', 'publish', '2024-03-02 09:32:27', '2024-03-02 09:33:03'),
(9, 3, 4, 'ロブショット', 'フェイスを開いて、フェイスの右側に叩きつける感じ\r\n救い打ちをしない\r\n\r\n体の回転', NULL, NULL, NULL, NULL, '2024-03-03', 'publish', '2024-03-03 02:22:26', '2024-03-03 02:22:26'),
(10, 3, 4, '左に飛ぶ', 'ウェッジ、ショートアイン特に　左方向に。プル', 'ボール右に置け。右肩が突っ込んでいる', NULL, NULL, NULL, '2024-03-12', 'publish', '2024-03-12 14:22:26', '2024-03-21 14:11:15'),
(11, 3, 4, 'トップする', NULL, NULL, NULL, NULL, NULL, '2024-05-01', 'draft', '2024-05-01 04:17:44', '2024-05-01 04:17:44'),
(13, 3, 4, 'スライスする', '体が開いてスライスする', NULL, NULL, NULL, NULL, '2024-09-17', 'publish', '2024-09-17 07:05:20', '2024-09-17 07:05:31'),
(14, 3, 4, 'スライス', 'プッシュスライスします\r\n\r\n体が開いてフェイスが開いています', NULL, NULL, NULL, NULL, '2024-09-17', 'draft', '2024-09-17 11:53:02', '2024-09-17 11:53:02'),
(15, 1, 18, NULL, NULL, NULL, NULL, '生徒', NULL, '2024-11-11', 'publish', '2024-11-11 05:34:20', '2024-12-09 02:50:01'),
(16, 7, 22, 'ゴルフスイング', 'スイングの改善', 'これを続けてやってください', '次回アプローチ', NULL, 'mmaf6AhIZUHqn4I82JntXwLZj7ZnPugukpWDvjEg.mov', '2024-12-03', 'publish', '2024-12-03 02:32:47', '2024-12-03 02:33:44'),
(17, 13, 18, '講師アカウント　管理者なし　作成', 'レッスン概要', '生徒へのコメント', 'スクール内メモ', '生徒のメモ', 'zuaVfqoeOWdjAQGrNgOKK1NtQ5PGm9dt3bOFmTMv.mp4', '2024-12-09', 'publish', '2024-12-09 02:40:47', '2024-12-09 05:32:16'),
(18, 13, 18, 'テスト　管理者なし　下書き保存', 'レッスン概要', '生徒へのコメント', 'スクール内メモ', NULL, 'RCDykqmsUmX2vEJNQG7rdGia1DrXICIRwQlFGUS5.mp4', '2024-12-09', 'draft', '2024-12-09 02:46:31', '2024-12-09 02:46:37'),
(19, 1, 18, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-09', 'publish', '2024-12-09 05:27:35', '2024-12-09 05:27:47'),
(21, 5, 24, 'スライス　対策', 'ドライバーでスライスしてしまいます。　フェースが開いているので、右に出てそのままスライスする。対策として・・', 'クローズとスタンスで打ってみてください', '共有されないところですね', NULL, NULL, '2024-12-26', 'publish', '2024-12-26 02:12:41', '2024-12-26 02:12:55'),
(22, 3, 4, 'ティーショットの狙い方', '右ドッグのときに・・', NULL, NULL, NULL, NULL, '2024-12-26', 'publish', '2024-12-26 02:27:48', '2024-12-26 02:27:56'),
(24, 7, 33, '伸び上がり防止', '膝を曲げた状態で重心を下げてその姿勢をキープしたままスイングする練習', 'スイングが緩まない様に注意、ヘッドアップも気をつけよう！', 'ハーフスイングで姿勢キープの練習中', NULL, 'YYSLPgM1IRHwZMBJcDs126ehZUv2tHxLGyFv2cw5.mov', '2025-01-30', 'publish', '2025-01-30 01:53:54', '2025-01-30 01:54:08'),
(25, 7, 39, '手首を曲げすぎない', '手首の曲がりが強く手打ち感が強くなっている。\r\nテークバックの形を作る練習。', 'テークバックは腕は前、体は回転意識で振る様にしていきましょう！', 'シャフトクロスを治していってます', NULL, 'tDIOJuXVyTyVgqpNB3HrEmN4GxBoaBcjKP0P3N0m.mov', '2025-02-02', 'publish', '2025-02-02 03:36:49', '2025-02-02 03:37:04'),
(26, 7, 37, '手首、軌道、落とし所', 'ゆっくりのスイングで軌道をチェック！\r\nクラブの落とし所は右足前イメージ！', 'アウトサイドからくる動きは落ち着いてきます。油断するとまだ危ないので、ゆっくりクラブの軌道を意識した練習を取り組んでいきましょう！', '軌道修正中', '5日ぶりにクラブ握ったら、やっぱりちょっとアウトサイドインな感じだった。\r\nまだまだ体が覚えていない。\r\n右足前を落とし所としてシャっとマットを擦れるように素振りの反復かなぁ🤔', 'QcWJv1Xg9rK9t8IQyW6FNNVfHVrFmId2asu04b8n.mov', '2025-02-04', 'publish', '2025-02-04 13:08:56', '2025-02-04 14:10:13'),
(27, 7, 37, NULL, 'トップの位置が高くなりやすい\r\n番手ごとのトップの位置を確認しよう', 'ウェッジを打った後にアイアンやウッドを打つとトップが高くなってスイングプレーンから外れるので\r\n各番手トップの位置を確認しましょう', NULL, NULL, '0SW8nnfrDBj3JyvcNwsZVmwoK4aKdtgXHP8o1bFT.mov', '2025-02-05', 'publish', '2025-02-05 05:47:42', '2025-02-05 05:47:57'),
(28, 42, 40, NULL, 'テイクバックの軸ズレ、左足の浮き、右足の受け、腹筋で感じる。', NULL, NULL, NULL, NULL, '2025-02-05', 'draft', '2025-02-05 10:38:15', '2025-02-05 10:38:15'),
(29, 7, 37, '切り返しでの手首の角度', 'トップからの切り返しで手首の角度がつきすぎてしまい鋭角にクラブが入ってしまっている。手首を伸ばした状態でクラブを大きく入射角度を滑らかに入れる感覚を身につける練習！', 'まずはハーフスイングからでOKなので入射角度を意識した練習を取り組んでいきましょう！慣れて来てから手首の緩みを作っていきます！冬の間に悪魔のフォローを卒業しましょう！', 'ハーフスイングで軌道修正', NULL, 'gr4QD8MDUq5u0ET7wcpXLfXrwLvdptKwYnv7a4qu.mp4', '2025-02-06', 'publish', '2025-02-07 03:01:50', '2025-02-07 03:01:56'),
(30, 29, 37, 'コース前復習', '・バンカーでの打ち方\r\n・傾斜での打ち方\r\n・1Wの打ち方', '・バンカーでの打ち方\r\n→フェースを開けるだけ開き、左足体重のまま指一本分手前にクラブを落とす\r\n\r\n・傾斜での打ち方\r\n   1,左足下がり\r\n→ボールを右に置いて、体重移動しないように打つ。アドレス時にソール面を地面に合わせる\r\n   2,前下り\r\n→足を大きく開き、体重移動しないように打つ\r\n\r\n・1Wの打ち方\r\n→フォロースルーを外に出しすぎない、右手が上を向きすぎない。バックスイングを下ろす時は腰と腕は同時。フィニッシュで手の位置よりヘッドの位置の方が下になる。\r\n\r\n総評KPT（keep,problem,try）\r\nkeep\r\n・アイアンの振り抜きの方向がだいぶ良くなりましたね。このまま継続です！\r\n・ドライバーの後半の方、結構振れてきていたので、緩まないようにしっかり振れると︎👍🏻 ̖́-\r\n\r\nproblem\r\n・長いクラブになると身体が左に突っ込む癖が1/2くらいで出てきますね、、、\r\n・ダウンスイングに入る時に腰だけが先行してしまう時があります。（腰は7時、腕は1時）\r\n\r\ntry\r\n・トップの位置で2秒止まる練習はとてもいいと思います！思い出したら是非やってください！振り遅れとツッコミ癖の両方に効くと思います！\r\n\r\n明日のラウンドは寒いと思いますが、しっかり防寒して楽しんできてください！^^', NULL, NULL, 'EY1dX9Xm7UJs6zn0cGJpaLKB6CUQwUBiJ9VIpLjb.mov', '2025-02-08', 'publish', '2025-02-08 09:06:08', '2025-02-08 09:38:41'),
(31, 7, 39, 'フェース面の意識とフォローの出し方！', 'インパクトでまだフェースの向きが開きがち\r\nダウンスイングではクラブのフェースが下に向くイメージを持つ！\r\nフォロースルーでは左脇を締めすぎずに肘の向きを打ちに寄せとく事を意識！', '手首の意識は少しずつ良くなってはきてます！\r\nフォローでインに引く動きをなくす練習も取り組んでいきましょう！', 'フェースコントロールと軌道修正', NULL, 'whqmlR9JkcAJMcTZPsgQz2yExLzS2MpLm0QWejUa.mov', '2025-02-09', 'publish', '2025-02-09 03:04:54', '2025-02-09 03:05:09'),
(32, 7, 43, 'クラブの返し方！', 'クラブの返し方は手のひらで返すだけでなく回転をつける！\r\n右側でクラブを使う感覚をつける練習！', 'まだ気をつけないと手元が左に出て明日ライスは出ています！\r\n右側でクラブを扱う感覚が染み付くまで練習頑張りましょう！', 'インパクトの形の練習', '右側でクラブを返す感覚とスイングしてからフォロー', '5psgj9bTFikPZx32dvAeMULxTARlKmzhZChEbNpC.mov', '2025-02-09', 'publish', '2025-02-09 11:29:43', '2025-02-10 00:24:55'),
(33, 7, 39, '体の捻転をつけよう！', 'テークバックで手だけで上げない様に肩をしっかりと回す様にしましょう！\r\n方が回る事で右サイドの懐が広くなりインサイドからの軌道が作りやすくなります！\r\nダウンスイングの時もすぐに肩を回転して戻さず、右肩を少し下げるイメージで肩の角度を保ちましょう！', 'スイングのフォームは徐々に良くなっています👌\r\nフォローもしっかり右の方に振れているので引き続きフォームが染み付くまで練習頑張りましょう！', 'インサイドアウトでフォロー大きく出す練習中', NULL, 'FRl4ZzISluD8T6SAREFOJqFZNFhzkG2nz5udXQgp.mov', '2025-02-11', 'publish', '2025-02-11 03:03:42', '2025-02-11 03:03:56'),
(34, 7, 37, 'トップからの切り返しの動き方！', '・左腰のスウェーを治す練習', 'トップからの切り返しで左腰が横に流れてしまいクラブが振り遅れてしまう状態になっています！\r\n傾斜版を使って左足で壁を作る感覚を身につけスウェーを無くしていきましょう！\r\n\r\n手首の形練習器具はアプローチかハーフスイングのみで練習してください^_^', '体の動く順番を使ってます！', NULL, NULL, '2025-02-11', 'publish', '2025-02-11 13:55:50', '2025-02-11 13:55:50'),
(35, 7, 37, 'シャフトの角度を意識しよう！', '・切り返しでのクラブ軌道\r\n・腰のリード', 'インサイドからクラブは降りてきてますが、クラブの角度が立ってしまい鋭角気味にクラブが入ってます！トップの切り返しで右の手のひらにクラブの重みを感じてスイングする練習をしていきましょう！\r\nあとは切り返しの際に下半身が止まりすぎずに腰を回してリードする様にしましょう！', '軌道修正！', NULL, 'cBVLyWZVHclSfiV1M4GR9k8gsAO8E68v5l0wHNxA.mov', '2025-02-13', 'publish', '2025-02-13 07:05:31', '2025-02-13 07:05:43'),
(36, 7, 33, 'クラブの軌道を一から作りましょう', '始動からインパクトまでの動きを確認し反復練習', 'テイクバックかpの手とヘッドの位置関係、トップの形、ダウンスイングの下ろす場所、フェースターン\r\n1つずつ確認し反復して身につけましょう\r\n力入れて出来ないなら力入れるべきじゃないです\r\nスイングが悪くなります', NULL, NULL, 'kYdDJNAxVLXIQyymO8QLGxtKC6Cn35t2R1JT4Ioy.mov,363If6MExPPa7YwwN3nK5GTi39S5gKbiApaQEUba.mov', '2025-02-15', 'publish', '2025-02-15 05:02:43', '2025-02-15 05:03:40'),
(37, 7, 40, 'クラブに仕事をさせてあげよう！', '・体主導で動かずゆったりとしたスイングでクラブの動きを感じる\r\n・トップからの切り返しだけ一瞬力を加えてあとは惰性でスイング', '体の動きが強くクラブが置いてけぼりになっているので\r\nまずはクラブの動きに合わせたスイングができるまではゆったりとしたスイングで練習をしていきましょう！', '軸の安定とスイングの動く順番のチェック', NULL, 'SgPgBrQ2PGTSu9zdskx6ccMQy0lDdVfBdb8GpLjd.mov', '2025-02-16', 'publish', '2025-02-16 11:21:06', '2025-02-16 11:21:32'),
(38, 7, 40, '左壁を意識！', '・左腕がインパクトで左に流れないように\r\n・ロングアイアン、ボールの赤道を狙う', 'ドライバーでインパクト時に左腕が流れてしまうとヘッドが返らずスライスの原因となります。アドレスから左腕のポジションを意識しながらスイングしましょう！\r\nロングアイアンはダフらがちなのでボールの赤道部分にフェースの歯を充てるイメージで振り抜くようにしましょう！', NULL, NULL, 'FqCiDitDVpJ0bZD3MGLifuB7aPHP61gv9rXmZQ2Y.mov', '2025-02-18', 'publish', '2025-02-18 13:48:28', '2025-02-18 13:48:44'),
(39, 7, 43, 'ダウンスイングでのクラブの返し方！', '・フェイスの返し方は手のひらで返さずドアノブを閉めるように回転を使う！', '前回同様にまだ手のひら返しのクラブの返し方になっているので、クラブを回転させるようにフェイスをローテーションさせましょう！\r\nまた左腕が抜けてしまうのもアドレスからより意識して左腕の壁意識を強めましょう！', NULL, NULL, 'cuVUo8zI2dSFmk4e1MF1seBjwGHvtTj3zvnhbQwt.mov', '2025-02-18', 'publish', '2025-02-18 13:52:25', '2025-02-18 13:52:51'),
(40, 7, 37, 'クラブを立てない！', '・トップの切り返しでクラブが立って鋭角に入る\r\n・トップでクラブの角度を少し寝かせてからスイング練習', 'トップからの切り返しの反動でクラブが立ってしまい鋭角にクラブが入る癖が出てます！\r\n一度クラブを倒してからスイングをする練習で角度を作る意識をつけましょう！\r\nその時も反動を加えずに体の回転でスイングをする様に気をつけましょう！', '軌道修正', NULL, 'TG3ysYU34cApBEHt2C0XiemcUlyZg2UVZ55Hq68L.mov', '2025-02-20', 'publish', '2025-02-20 07:25:08', '2025-02-20 07:25:23'),
(41, 42, 35, NULL, 'アドレス、つま先に体重行きすぎて、体が回らなくなっていた。\r\nテイクバック、体が回らなかったので真っ直ぐ引いてしまっていた、ふとももおしり回して、体の近くにクラブを上げてこないといけない。\r\n両足閉じてスイングすることで、体が前に突っ込んでいたことを理解していただく、これもテイクバックで上半身が右にずれていたため、突っ込まざるを得なかった。', NULL, NULL, NULL, NULL, '2025-02-20', 'publish', '2025-02-20 10:23:08', '2025-02-20 10:23:08'),
(42, 42, 40, '背中のハリ', 'クラブを下ろす時に、体が前に行くと背中のハリを感じなくなる、この一瞬があることにより、軸の移動のイメージが少なくなる。', NULL, NULL, NULL, NULL, '2025-02-20', 'publish', '2025-02-20 10:35:40', '2025-02-20 10:35:40'),
(43, 7, 44, 'ゆっくりフォームを意識してスイング！', '・切り返しの際に手首の角度を作る\r\n・トップでインサイドに手元を引く\r\n・右足が出ない様に注意', '意識のポイントが多いと何かを忘れがちになります！\r\nゆっくりとスイングをして今意識しているポイントを身につけていきましょう！', NULL, NULL, 'VpWPkhQoIAT4wUQc6LEjhEhMNjoWsG03Y5Avs2xW.mov', '2025-02-23', 'publish', '2025-02-23 11:33:21', '2025-02-23 11:33:41'),
(44, 7, 37, '手首、軌道、左足！', '・切り返しで腰がスウェーしない様に\r\n・左足に力を入れて壁意識', '起動意識は常に持つ様にしておきましょう！\r\n手首も油断するとまだ角度がついてしまうので気をつけて！\r\n左足は右の方に力を加える感じで流れを防止しておきましょう！', NULL, NULL, 'b1KgGCH8BzR59HTEcgvsXiyboK9cmoHbScVJugDN.mov', '2025-02-23', 'publish', '2025-02-23 11:36:43', '2025-02-23 11:37:16'),
(45, 7, 33, 'スイングリズムを意識しよう！', '・往復スイングでスイングリズムを良くする\r\n・トップでのクラブ角度は斜めに', 'トップでクラブが立つ癖があるので腕の使い方を意識して斜めに保ちましょう！\r\nスイングの意識が増えるとスイングのテンポが悪くなるので、往復スイングでスイングのリズムを良くしていきましょう！', NULL, NULL, 'HDnA4lLtk7dSnD5ALsfW5iApvMwaHNjkh4UmbPyw.mov', '2025-02-23', 'publish', '2025-02-23 11:40:00', '2025-02-23 11:40:14'),
(46, 7, 40, '楽をしてスイングをしない！', '・体の動かすと所と止まるところを意識する\r\n・トップからは振ってから体回る意識', '油断するとまだ体がクラブについて行ってしまい左右に体が流れてしまうことがあります！\r\nトップでは下半身をしっかり止めて捻転を感じて、フォローでは背筋が引っ張られる様に腕を大きく出しましょう！', NULL, NULL, 'q46z5CdtAc952tBeISEq0ZxuQcGKXgZLmUlNtYpD.mov', '2025-02-25', 'publish', '2025-02-26 07:54:49', '2025-02-26 07:54:59'),
(47, 42, 41, '体重移動', 'テイクバックで体が捻れるようになり。クラブがインサイドを通るようになりました。ダウンスイングで左に体重移動することが早すぎるので、クラブが追い越せなくてボールがつかまらなかった。\r\nなので、体重移動を我慢するイメージで振りましょう。', NULL, NULL, NULL, NULL, '2025-02-27', 'publish', '2025-02-27 10:58:32', '2025-02-27 10:58:32'),
(48, 7, 33, '始動時のヘッドの位置を確認', 'テイクバックの修正', 'クラブをインサイドにひかない、フェースは地面向けて閉じいておきたいです\r\nダウンスイングは現状では悪くないです。', NULL, NULL, 'yUMSiIw9DwjV5lu0c5TyRmYbw05u839H7MF58l01.mov', '2025-02-28', 'publish', '2025-02-28 07:57:24', '2025-02-28 07:57:45'),
(49, 42, 33, '足の使い方', '右足の使い方が、前に蹴ってしまう癖があるのでそのせいで上半身が起き上がってしまう。\r\n右足の動く方向を左のふとももにくっつくように動かさないといけない。\r\nその過程で靴も内側が動いてくるとさらに良くなります。', NULL, NULL, NULL, NULL, '2025-03-01', 'publish', '2025-03-01 03:02:49', '2025-03-01 03:02:49'),
(50, 42, 37, 'ラウンド前', 'ショットは左サイドが突っ込んでしまったり、上クラブが届かなかったり、上半身が起き上がってクラブを落としてダフってしまう。\r\nバンカーは体重は球を上げるときに左に行くのは危険。目線も上がるので右に軽く体重はかかる。\r\nアプローチはイメージよりもクラブが上がりすぎたり、上半身が起き上がったりするので、気を付けましょう。\r\n\r\nボールを飛ばすには手元が体の近くにないとエネルギーが溜めれない。少しトップの時に手が遠すぎる。', NULL, NULL, NULL, NULL, '2025-03-01', 'publish', '2025-03-01 08:39:12', '2025-03-01 08:59:28'),
(51, 7, 37, '軸キープで手打ち練習！', '・当て感を作るために軸そのままで手打ち練習から', '体止めて手打ちでボールの当て感が出てきたら、腰を使って打つ、それも出来てきたら最後にフィニッシュ練習！', '体の動く順番練習', NULL, 'RjAnJ0A2e0V4T6b8HHQlF2L9rVyfucT9Y4h1JlAm.mov', '2025-02-27', 'publish', '2025-03-02 01:25:50', '2025-03-02 01:26:03'),
(52, 7, 33, 'アドレスと距離感！', '・アドレス時に手元が浮かない様に角度をつける！\r\n・ボールとの距離感は近めに！', 'トップでのクラブ角度は良くなってきました！\r\nインパクトで先に当たりがちになっているのでボールとの距離感は近めで構えましょう！', NULL, NULL, 'GE8N7cdnSQIrBe5zfMwm7wwxNHjouVXsaN1gyLk8.mov', '2025-03-02', 'publish', '2025-03-02 14:49:50', '2025-03-02 14:50:10'),
(53, 7, 37, '体を捻ってインサイドから振りやすく！', '・ラウンドのスイングバックスイングで体が止まりがち\r\n・右腰に体を乗せる感じでバックスイングそのままスイング', 'ラウンドでのスイングはてバックスイングで体が止まって手上げになっているので\r\n体を使ってバックスイングをしましょう！\r\n他と手首の角度が垂れない様に気をつけよう！', NULL, NULL, 'ZPgUnSpTmQXDjPW6rzRz1Lq2JNaM0R8H1zVLFlNd.mov', '2025-03-02', 'publish', '2025-03-02 14:53:20', '2025-03-02 14:53:42'),
(54, 7, 39, 'ドライバー体を開かない様に', '・右サイドに体を向けて開かない様にスイング\r\n・フェースターンはインパクトの手前で', 'アイアンはよくなっていますがドライバーが体が開いてスライスになってしまってます！\r\nアドレスから右サイドに体を向けて右サイドでスイングをするイメージをつけていきましょう！', NULL, NULL, 'mSpqgCVWYjb33OGjGrHpkKAUhPV6Uh8Wf4whmC48.mov', '2025-03-02', 'publish', '2025-03-02 14:56:55', '2025-03-02 14:57:18'),
(55, 7, 33, NULL, 'ダウンスイングの起き上がりと軌道を確認してから打つ', 'テイクバックの動きは良くなってきました\r\nダウンスイングで体が起き上がらないようにと右足が回り出すのが早いのでベタ足意識', NULL, NULL, '6iAA30H9ijL5PjcEYq4lmLVhIhLdSLvVtgQvweL0.mov', '2025-03-05', 'publish', '2025-03-05 02:51:03', '2025-03-05 02:51:39'),
(56, 7, 33, 'アドレスを丁寧に！', 'アドレスから前傾キープ', '膝が曲がって前傾ができていないので少し膝を伸ばしてその分前傾しましょう。\r\nアプローチでは手首の角度キープ緩まない様に気をつけましょう', NULL, NULL, NULL, '2025-03-07', 'publish', '2025-03-07 02:52:01', '2025-03-07 02:52:01'),
(57, 29, 37, '振り遅れと体重移動', '振り遅れと体重移動の修正', 'KPT（keep,problem,try）\r\nK\r\n・前回よりしっかり振れてきているのは︎︎👍🏻︎︎\r\n・以前より右側で振る意識が出来ている︎︎👍🏻︎︎\r\n\r\nP\r\n・バックスイングの時に右に流れすぎて、\r\n・フォローでインサイドアウトを意識しすぎて、9時の位置でフェース面が開く\r\n・振り遅れが目立つ\r\n\r\nT\r\n・スタンスを広くして身体が流れて軸がブレてアッパーになりすぎないようにする\r\n・9時の位置で右手が上も下も向かないように確認しながら練習する\r\n・クローズスタンスで腰にブレーキを感じながら練習する。', NULL, NULL, NULL, '2025-03-07', 'publish', '2025-03-07 12:30:56', '2025-03-07 15:35:41');

-- --------------------------------------------------------

--
-- テーブルの構造 `lesson_record_tag`
--

CREATE TABLE `lesson_record_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lesson_record_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `lesson_record_tag`
--

INSERT INTO `lesson_record_tag` (`id`, `lesson_record_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 6, 2, '2024-02-13 01:46:06', '2024-02-13 01:46:06'),
(2, 6, 3, '2024-02-13 01:46:06', '2024-02-13 01:46:06'),
(3, 7, 2, '2024-02-26 01:10:30', '2024-02-26 01:10:30'),
(4, 7, 3, '2024-02-26 01:10:30', '2024-02-26 01:10:30'),
(5, 8, 1, '2024-03-02 09:32:27', '2024-03-02 09:32:27'),
(7, 10, 4, '2024-03-21 14:11:15', '2024-03-21 14:11:15'),
(8, 10, 13, '2024-03-21 14:11:15', '2024-03-21 14:11:15'),
(9, 10, 12, '2024-03-21 14:11:15', '2024-03-21 14:11:15'),
(10, 11, 6, '2024-05-01 04:17:45', '2024-05-01 04:17:45'),
(11, 11, 4, '2024-05-01 04:22:34', '2024-05-01 04:22:34'),
(12, 11, 7, '2024-05-01 04:22:34', '2024-05-01 04:22:34'),
(14, 4, 1, '2024-09-02 04:17:21', '2024-09-02 04:17:21'),
(15, 13, 9, '2024-09-17 07:05:20', '2024-09-17 07:05:20'),
(16, 13, 1, '2024-09-17 07:05:51', '2024-09-17 07:05:51'),
(17, 13, 7, '2024-09-17 07:05:51', '2024-09-17 07:05:51'),
(18, 14, 1, '2024-09-17 11:53:02', '2024-09-17 11:53:02'),
(19, 15, 2, '2024-11-11 05:34:20', '2024-11-11 05:34:20'),
(20, 17, 2, '2024-12-09 02:40:47', '2024-12-09 02:40:47'),
(21, 18, 3, '2024-12-09 02:46:31', '2024-12-09 02:46:31'),
(22, 19, 2, '2024-12-09 05:27:35', '2024-12-09 05:27:35'),
(25, 21, 3, '2024-12-26 02:12:41', '2024-12-26 02:12:41'),
(26, 22, 15, '2024-12-26 02:27:48', '2024-12-26 02:27:48'),
(27, 22, 9, '2024-12-26 02:27:48', '2024-12-26 02:27:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(26, '2000_01_01_000001_create_schools_table', 1),
(27, '2014_10_12_000000_create_users_table', 1),
(28, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(29, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(30, '2019_08_19_000000_create_failed_jobs_table', 1),
(31, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(32, '2023_03_20_000003_create_student_teacher_relations_table', 1),
(33, '2023_03_20_000004_create_ student_profile_table', 1),
(34, '2023_03_20_000005_create_video_advice_table', 1),
(35, '2023_03_20_000006_create_video_advice_comments_table', 1),
(36, '2023_03_20_000007_create_lesson_records_table', 1),
(37, '2023_03_20_000008_create_course_categories_table', 1),
(38, '2023_03_20_000009_create_courses_table', 1),
(39, '2023_03_20_000010_create_user_course_progress_table', 1),
(40, '2023_03_20_000011_create_course_conversations_table', 1),
(41, '2023_03_20_000012_create_forums_table', 1),
(42, '2023_03_20_000013_create_forum_bookmarks_table', 1),
(43, '2023_03_20_000014_create_forum_comments_table', 1),
(44, '2023_03_20_000015_create_forum_likes_table', 1),
(45, '2023_03_20_000016_create_lesson_plans_table', 1),
(46, '2023_03_20_000017_create_tags_table', 1),
(47, '2023_04_05_224610_create_lesson_record_tag_table', 1),
(48, '2023_04_29_000000_create_forum_tag_table', 1),
(49, '2023_05_05_131239_create_comment_likes_tables', 1),
(50, '2023_07_31_103625_create_notifications_table', 1),
(51, '2025_02_25_005548_add_first_played_at_field_to_user_course_progress_table', 2),
(52, '2025_02_25_011022_add_last_played_at_and_played_count_fields_to_user_course_progress_table', 2),
(54, '2025_03_28_013804_create_jobs_table', 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0119b45a-db72-431f-87c4-bab002e915f8', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 39, '{\"category\":\"lesson_record\",\"lesson_record_id\":31}', '2025-02-09 08:52:46', '2025-02-09 03:04:54', '2025-02-09 08:52:46'),
('08f3c5c9-edfb-41c6-9687-14dd74f2e02a', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 40, '{\"category\":\"lesson_record\",\"lesson_record_id\":37}', NULL, '2025-02-16 11:21:06', '2025-02-16 11:21:06'),
('0928c370-0744-46cb-b673-6cf437332b40', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":35}', '2025-02-13 08:38:27', '2025-02-13 07:05:31', '2025-02-13 08:38:27'),
('098c818e-c459-4d20-afb8-665940862ef1', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice_comment\",\"video_advice_id\":1,\"comment_id\":16}', '2024-09-02 04:20:31', '2024-05-02 06:10:13', '2024-09-02 04:20:31'),
('098e0fd8-f4b5-4465-bbb2-a1c93512d1c9', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice\",\"video_advice_id\":1}', '2024-01-11 16:55:06', '2024-01-11 16:41:41', '2024-01-11 16:55:06'),
('0c541ca1-99c2-487f-a3bf-a200bc20e9c4', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"course_comment\",\"course_id\":12,\"comment_id\":16}', NULL, '2024-12-23 03:46:27', '2024-12-23 03:46:27'),
('0e0744a0-fd5e-4a49-8ada-b7faed95000f', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 4, '{\"category\":\"video_advice_comment\",\"video_advice_id\":6,\"comment_id\":19}', NULL, '2024-09-02 04:20:09', '2024-09-02 04:20:09'),
('0e0d6327-451d-44d6-a042-6d884c334ef5', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 39, '{\"category\":\"lesson_record\",\"lesson_record_id\":33}', '2025-02-11 08:04:32', '2025-02-11 03:03:42', '2025-02-11 08:04:32'),
('1aa9ce29-854f-46b1-b811-3bd61a47f302', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":8}', NULL, '2024-12-09 03:58:06', '2024-12-09 03:58:06'),
('1b61c40b-45e9-4522-a1a0-15da06603d24', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 25, '{\"category\":\"video_advice_comment\",\"video_advice_id\":12,\"comment_id\":24}', '2024-12-23 03:42:00', '2024-12-23 03:41:39', '2024-12-23 03:42:00'),
('261efc29-d651-4ab3-a68f-86a4a9807ee6', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":51}', '2025-03-02 12:03:03', '2025-03-02 01:25:50', '2025-03-02 12:03:03'),
('28c599f9-26e7-41be-982a-2c1d0959098f', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 39, '{\"category\":\"lesson_record\",\"lesson_record_id\":54}', '2025-03-02 20:09:56', '2025-03-02 14:56:55', '2025-03-02 20:09:56'),
('2a90e63e-0262-4f85-bfd9-a8c1234e1e5f', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"course_comment\",\"course_id\":5,\"comment_id\":10}', '2024-12-09 03:18:46', '2024-12-09 02:59:11', '2024-12-09 03:18:46'),
('2b764b57-6a2c-44f7-8a6b-a88345bc97ef', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":7}', NULL, '2024-12-09 03:57:53', '2024-12-09 03:57:53'),
('2d2d94e7-d786-4dc8-91cc-132208858b40', 'App\\Notifications\\ForumCommentNotification', 'App\\Models\\User', 1, '{\"category\":\"forum_comment\",\"forum_id\":14,\"comment_id\":11}', '2024-12-24 02:15:48', '2024-12-23 03:49:45', '2024-12-24 02:15:48'),
('2e460045-f0f1-4df0-9b1d-fc1cb460db2f', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":56}', NULL, '2025-03-07 02:52:01', '2025-03-07 02:52:01'),
('3062b2ce-a5b7-47f4-a55a-9ff1b1ea2b75', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 12, '{\"category\":\"lesson_record\",\"lesson_record_id\":12}', '2024-07-08 05:43:01', '2024-07-08 05:42:36', '2024-07-08 05:43:01'),
('3091fd7c-73f7-4dbf-837c-b4fe5041a5b8', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":50}', '2025-03-01 10:33:30', '2025-03-01 08:39:12', '2025-03-01 10:33:30'),
('31cb02d8-941f-489d-8d7e-d2b581e72282', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice\",\"video_advice_id\":2}', '2024-01-12 02:43:25', '2024-01-12 02:43:06', '2024-01-12 02:43:25'),
('3449cabe-3552-4d9b-b5df-0ca60ceb9915', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":3}', '2024-01-24 04:19:04', '2024-01-19 13:49:20', '2024-01-24 04:19:04'),
('36d57912-01d3-4ff1-8d21-a3ad60ab5010', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 27, '{\"category\":\"lesson_record\",\"lesson_record_id\":23}', '2024-12-26 05:33:10', '2024-12-26 05:29:30', '2024-12-26 05:33:10'),
('39a0a4e9-dae7-4686-be8a-a309fdca44da', 'App\\Notifications\\ForumCommentNotification', 'App\\Models\\User', 1, '{\"category\":\"forum_comment\",\"forum_id\":4,\"comment_id\":9}', '2024-12-09 03:21:11', '2024-12-09 02:58:18', '2024-12-09 03:21:11'),
('3c2e3df7-3216-42b7-bb42-7348289de38a', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":52}', '2025-03-04 04:03:04', '2025-03-02 14:49:50', '2025-03-04 04:03:04'),
('3cf89077-5f3c-402e-9e70-d691b6c9a8c1', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":44}', '2025-02-23 12:47:04', '2025-02-23 11:36:43', '2025-02-23 12:47:04'),
('3d48aabe-d0a2-4d79-9e8d-05e3f674a809', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 1, '{\"category\":\"course_comment\",\"course_id\":5,\"comment_id\":7}', '2024-11-11 06:02:55', '2024-11-11 05:59:44', '2024-11-11 06:02:55'),
('42577298-b559-4898-8efb-c46561b497a4', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice\",\"video_advice_id\":5}', '2024-04-26 05:47:59', '2024-04-26 05:26:06', '2024-04-26 05:47:59'),
('47e84d3b-b70b-4f99-b3f4-0a155b91d951', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":30}', '2025-02-08 21:40:35', '2025-02-08 09:38:12', '2025-02-08 21:40:35'),
('483c1687-2ce6-435b-8fb9-a272b82c9b19', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":55}', '2025-03-05 03:47:25', '2025-03-05 02:51:03', '2025-03-05 03:47:25'),
('4b98cbb8-b81e-4b9f-a6b0-81282c087b85', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice\",\"video_advice_id\":7}', '2024-05-01 03:51:44', '2024-05-01 03:50:09', '2024-05-01 03:51:44'),
('4ca7d62d-2b01-4f16-86d3-1440ab50e45d', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"video_advice\",\"video_advice_id\":12}', NULL, '2024-12-23 03:40:50', '2024-12-23 03:40:50'),
('4eec4e7b-408e-4335-adcd-8bbe65ab1932', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":11}', NULL, '2024-12-09 03:58:12', '2024-12-09 03:58:12'),
('4fb80da8-01f8-4d37-9bdc-70c9c23c40eb', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 39, '{\"category\":\"lesson_record\",\"lesson_record_id\":25}', '2025-02-02 07:11:02', '2025-02-02 03:36:49', '2025-02-02 07:11:02'),
('5962cc37-a236-48ac-b7fa-1782e2a27257', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 12, '{\"category\":\"video_advice_comment\",\"video_advice_id\":8,\"comment_id\":18}', '2024-07-08 05:19:57', '2024-07-08 03:57:58', '2024-07-08 05:19:57'),
('5ab301a1-fc1e-454c-ad0b-3a9df26e6544', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":5}', '2024-05-01 03:59:39', '2024-02-22 04:17:23', '2024-05-01 03:59:39'),
('5ae2f923-bed8-427e-bf2d-d6dfa125c6de', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"course_comment\",\"course_id\":1,\"comment_id\":15}', NULL, '2024-12-09 03:20:50', '2024-12-09 03:20:50'),
('5b4b9fd7-be99-4c93-acf2-f263c429240e', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 2, '{\"category\":\"lesson_record\",\"lesson_record_id\":7}', NULL, '2024-02-26 01:10:30', '2024-02-26 01:10:30'),
('5b8061af-be66-4419-9f81-e85130056404', 'App\\Notifications\\ForumCommentNotification', 'App\\Models\\User', 4, '{\"category\":\"forum_comment\",\"forum_id\":2,\"comment_id\":3}', '2024-05-02 06:17:47', '2024-01-11 16:56:04', '2024-05-02 06:17:47'),
('5cb6f3f5-e7f3-4b86-a1a8-775738ccfa9b', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 1, '{\"category\":\"course_comment\",\"course_id\":8,\"comment_id\":9}', '2024-12-09 03:17:59', '2024-12-09 02:56:51', '2024-12-09 03:17:59'),
('5d874b93-ebb4-49f5-a674-bfc8916eb223', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":10}', '2024-05-01 03:59:29', '2024-03-13 01:21:30', '2024-05-01 03:59:29'),
('61d08d72-ca0f-4431-bb03-e1e55c0bdf43', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"video_advice\",\"video_advice_id\":11}', '2024-12-09 03:15:40', '2024-12-09 03:14:53', '2024-12-09 03:15:40'),
('6385e70d-28f7-4213-b9bf-b389b55095a1', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":57}', NULL, '2025-03-07 15:35:41', '2025-03-07 15:35:41'),
('652fc3f0-0110-4da1-a70d-99ec8ab6e7a2', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":49}', '2025-03-01 03:04:57', '2025-03-01 03:02:49', '2025-03-01 03:04:57'),
('6bbfdf27-d1cf-438d-8158-afd5886c4a6b', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":1}', '2024-01-11 16:45:54', '2024-01-10 09:19:53', '2024-01-11 16:45:54'),
('6c38a204-af63-43fa-9309-a2b6196f5f4a', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 1, '{\"category\":\"forum\",\"forum_id\":6}', '2024-12-09 03:21:08', '2024-12-09 02:50:41', '2024-12-09 03:21:08'),
('71546a93-9927-4147-9280-a0425df288a6', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 18, '{\"category\":\"lesson_record\",\"lesson_record_id\":17}', '2024-12-09 03:57:22', '2024-12-09 02:40:47', '2024-12-09 03:57:22'),
('7178164c-a126-42fa-a1be-6a0f0db6d09e', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":27}', '2025-02-05 05:59:00', '2025-02-05 05:47:42', '2025-02-05 05:59:00'),
('75c18e2e-2b67-4751-bdb7-cd5e3c0ae9ca', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":45}', '2025-02-24 12:41:50', '2025-02-23 11:40:00', '2025-02-24 12:41:50'),
('781093f5-8402-41d5-a251-65e042e6b4d8', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 25, '{\"category\":\"lesson_record\",\"lesson_record_id\":20}', '2024-12-23 03:34:06', '2024-12-23 03:33:51', '2024-12-23 03:34:06'),
('788d31f2-4641-4db2-8922-5f4b38975271', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 41, '{\"category\":\"lesson_record\",\"lesson_record_id\":47}', NULL, '2025-02-27 10:58:32', '2025-02-27 10:58:32'),
('78b977c8-9fda-45de-99d8-d70085c5b3de', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":10}', NULL, '2024-12-09 03:58:11', '2024-12-09 03:58:11'),
('79fb788d-4bec-4cd4-838b-63f0beadc587', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":53}', '2025-03-03 06:49:56', '2025-03-02 14:53:20', '2025-03-03 06:49:56'),
('7a0d0fae-409d-4093-b6da-973845a7f37f', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 18, '{\"category\":\"course_comment\",\"course_id\":5,\"comment_id\":14}', '2024-12-09 03:19:44', '2024-12-09 03:19:40', '2024-12-09 03:19:44'),
('7aca6b8e-6dbf-4264-be4a-ad8c1de9c20c', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 43, '{\"category\":\"lesson_record\",\"lesson_record_id\":32}', '2025-02-10 00:23:13', '2025-02-09 11:29:43', '2025-02-10 00:23:13'),
('7b922f24-dc7c-4c2b-b34c-b926a07928f0', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"forum\",\"forum_id\":2}', '2024-01-11 16:55:35', '2024-01-11 16:52:55', '2024-01-11 16:55:35'),
('7bb4a0fb-5a60-4cfe-9265-f77201028fbf', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 2, '{\"category\":\"lesson_record\",\"lesson_record_id\":6}', NULL, '2024-02-13 01:46:06', '2024-02-13 01:46:06'),
('7bfcba26-4a39-42e9-b948-e028450d3cb4', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 44, '{\"category\":\"lesson_record\",\"lesson_record_id\":43}', NULL, '2025-02-23 11:33:21', '2025-02-23 11:33:21'),
('7db558a8-de18-4495-863b-76596327aef7', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":10}', '2024-05-01 03:59:29', '2024-03-13 01:20:42', '2024-05-01 03:59:29'),
('7f3349d4-85d6-493e-b878-afbd8d331e41', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 18, '{\"category\":\"video_advice_comment\",\"video_advice_id\":10,\"comment_id\":22}', '2024-12-09 05:51:50', '2024-12-09 03:17:07', '2024-12-09 05:51:50'),
('804d3e31-e755-4e38-a49d-14ff5f459ee6', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":2}', '2024-01-11 17:00:59', '2024-01-11 17:00:53', '2024-01-11 17:00:59'),
('81986575-b4cd-4629-ab51-66569ef8125a', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 4, '{\"category\":\"video_advice_comment\",\"video_advice_id\":7,\"comment_id\":3}', '2024-05-02 06:06:43', '2024-05-01 04:18:21', '2024-05-02 06:06:43'),
('866a0110-c616-45b9-b2dc-45f5fd5abc5a', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":10}', '2024-05-01 03:59:29', '2024-03-13 01:21:53', '2024-05-01 03:59:29'),
('88dc2325-3b53-4014-9677-2c43713ee3a8', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":34}', '2025-02-11 15:59:48', '2025-02-11 13:55:50', '2025-02-11 15:59:48'),
('9035f704-410f-4b12-89de-1e7d0f4747e5', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 1, '{\"category\":\"video_advice\",\"video_advice_id\":13}', NULL, '2025-01-31 01:41:22', '2025-01-31 01:41:22'),
('90a2d691-7b27-4ad3-845b-64e5419f1f19', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"course_comment\",\"course_id\":5,\"comment_id\":11}', '2024-12-09 03:18:46', '2024-12-09 02:59:43', '2024-12-09 03:18:46'),
('90ae7908-f158-4b4e-bf69-a38ee44f3772', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 22, '{\"category\":\"lesson_record\",\"lesson_record_id\":16}', NULL, '2024-12-03 02:32:47', '2024-12-03 02:32:47'),
('932cb9c7-273d-47b4-9534-e585be7b61b0', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":12}', NULL, '2024-12-09 03:58:12', '2024-12-09 03:58:12'),
('93cdd97d-79b5-47f6-baf8-498e445388f0', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":9}', '2024-05-01 03:59:36', '2024-03-03 02:22:26', '2024-05-01 03:59:36'),
('9512536e-0992-4e12-9f58-ee410c1b892e', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":24}', '2025-01-30 02:09:50', '2025-01-30 01:53:54', '2025-01-30 02:09:50'),
('9693444b-cd0a-4a7d-a73d-d43dfdf360ab', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":40}', '2025-02-20 10:00:22', '2025-02-20 07:25:08', '2025-02-20 10:00:22'),
('96fed30a-d81b-4f32-a2db-5ca8a944001f', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 18, '{\"category\":\"course_comment\",\"course_id\":8,\"comment_id\":13}', '2024-12-09 03:19:17', '2024-12-09 03:18:42', '2024-12-09 03:19:17'),
('9764c018-c49b-497d-92cb-106f81b4591e', 'App\\Notifications\\ForumCommentNotification', 'App\\Models\\User', 1, '{\"category\":\"forum_comment\",\"forum_id\":4,\"comment_id\":8}', '2024-12-09 03:21:11', '2024-12-09 02:57:24', '2024-12-09 03:21:11'),
('99ba27a1-ee6a-432f-9c0f-988f119dd465', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":4}', '2024-01-25 03:24:22', '2024-01-24 04:16:07', '2024-01-25 03:24:22'),
('9c08fb84-eea0-46c9-a66a-6af39409b40e', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice\",\"video_advice_id\":4}', '2024-04-26 05:47:39', '2024-04-26 05:26:05', '2024-04-26 05:47:39'),
('9db7443d-7759-4d8e-85cf-9709fe38054a', 'App\\Notifications\\ForumCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"forum_comment\",\"forum_id\":5,\"comment_id\":7}', '2024-12-09 06:03:02', '2024-12-09 02:50:27', '2024-12-09 06:03:02'),
('a1eaa688-4ca9-4545-95ff-3092aef0f627', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"video_advice_comment\",\"video_advice_id\":12,\"comment_id\":23}', NULL, '2024-12-23 03:41:08', '2024-12-23 03:41:08'),
('a484304a-b382-40c4-996f-021cdcfa8b29', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":13}', '2024-09-17 07:06:53', '2024-09-17 07:05:31', '2024-09-17 07:06:53'),
('a615bedd-b339-49a0-9e74-bdcfe00ce969', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice\",\"video_advice_id\":6}', '2024-05-01 03:51:58', '2024-05-01 03:50:01', '2024-05-01 03:51:58'),
('a758d2e3-060e-48b5-96f8-d109cad23bdf', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 40, '{\"category\":\"lesson_record\",\"lesson_record_id\":46}', NULL, '2025-02-26 07:54:49', '2025-02-26 07:54:49'),
('aa5efc7f-0fcc-41f6-9b64-df19614d6090', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 35, '{\"category\":\"lesson_record\",\"lesson_record_id\":41}', NULL, '2025-02-20 10:23:08', '2025-02-20 10:23:08'),
('b1b62957-475c-4142-8bfc-1d1a8a5925b6', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 13, '{\"category\":\"video_advice_comment\",\"video_advice_id\":10,\"comment_id\":21}', NULL, '2024-12-09 03:10:03', '2024-12-09 03:10:03'),
('b4f5714b-5f6a-4f92-bf0e-0e2e06f63b70', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 40, '{\"category\":\"lesson_record\",\"lesson_record_id\":38}', NULL, '2025-02-18 13:48:28', '2025-02-18 13:48:28'),
('b67c3a2f-1355-4f26-aabb-2c75e70dea72', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":4}', NULL, '2024-09-02 04:17:49', '2024-09-02 04:17:49'),
('ba12ce06-6e56-4169-8aba-619130682224', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":9}', NULL, '2024-12-09 03:58:11', '2024-12-09 03:58:11'),
('baa18d32-9fbf-4fd7-980e-58db81c2ee13', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 1, '{\"category\":\"video_advice\",\"video_advice_id\":9}', '2024-11-11 05:41:21', '2024-11-11 05:32:38', '2024-11-11 05:41:21'),
('bc1c69d2-cc75-4d13-a107-14994bfc2385', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 1, '{\"category\":\"video_advice\",\"video_advice_id\":3}', '2024-03-21 14:41:46', '2024-03-21 07:16:34', '2024-03-21 14:41:46'),
('bf59636a-9388-44b1-9c5e-82c16079c46c', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 4, '{\"category\":\"video_advice_comment\",\"video_advice_id\":2,\"comment_id\":2}', '2024-01-12 02:44:11', '2024-01-12 02:43:54', '2024-01-12 02:44:11'),
('c5e5f0c5-7b73-4ea5-a177-7aa5f47614a4', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":10}', '2024-05-01 03:59:29', '2024-03-13 01:21:13', '2024-05-01 03:59:29'),
('c77be576-4fe8-483f-a34c-58a69a4b1d36', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":4}', '2024-01-25 03:24:22', '2024-01-25 03:24:18', '2024-01-25 03:24:22'),
('c7d38417-bb01-4b1d-8e96-69daa414f157', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":8}', '2024-05-01 03:59:38', '2024-03-02 09:33:03', '2024-05-01 03:59:38'),
('c89453ec-636b-485d-857f-edaab80dbe16', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 3, '{\"category\":\"video_advice_comment\",\"video_advice_id\":5,\"comment_id\":14}', '2024-09-17 07:11:39', '2024-05-02 06:09:39', '2024-09-17 07:11:39'),
('cfd21f0a-4d81-407d-bc06-2b27eb2d90bb', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 1, '{\"category\":\"video_advice\",\"video_advice_id\":10}', '2024-12-09 03:16:55', '2024-12-06 08:00:52', '2024-12-09 03:16:55'),
('d7ebc7dd-ef1d-4b18-b118-49bcbc383cb4', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 18, '{\"category\":\"video_advice_comment\",\"video_advice_id\":11,\"comment_id\":25}', '2025-01-14 00:29:12', '2024-12-26 02:16:02', '2025-01-14 00:29:12'),
('d8475a17-4aba-45fb-870c-7ed2ea6c806a', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":29}', '2025-02-07 10:11:45', '2025-02-07 03:01:50', '2025-02-07 10:11:45'),
('d9e6767f-7897-41df-919a-f8a3f9007741', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 37, '{\"category\":\"lesson_record\",\"lesson_record_id\":26}', '2025-02-04 14:06:15', '2025-02-04 13:08:56', '2025-02-04 14:06:15'),
('da4ec427-950f-4c78-9628-bba99ea8ae52', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":48}', '2025-02-28 08:00:16', '2025-02-28 07:57:24', '2025-02-28 08:00:16'),
('dbbf9b60-9ac9-44a0-b8e8-a36d199fc1dc', 'App\\Notifications\\ForumCreatedNotification', 'App\\Models\\User', 13, '{\"category\":\"forum\",\"forum_id\":13}', NULL, '2024-12-09 03:58:12', '2024-12-09 03:58:12'),
('dc1cdf35-94d2-4fc9-87b4-204755c4ee9e', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 33, '{\"category\":\"lesson_record\",\"lesson_record_id\":36}', '2025-02-15 05:31:45', '2025-02-15 05:02:43', '2025-02-15 05:31:45'),
('dea3d189-f297-498f-96dd-f28486f352b8', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 24, '{\"category\":\"lesson_record\",\"lesson_record_id\":21}', NULL, '2024-12-26 02:12:55', '2024-12-26 02:12:55'),
('e21d1458-b3d5-47a0-bb42-ce21dd612ee0', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 18, '{\"category\":\"lesson_record\",\"lesson_record_id\":19}', '2024-12-09 05:29:12', '2024-12-09 05:27:47', '2024-12-09 05:29:12'),
('e48d947a-da30-45fd-b628-58e33209f2c6', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 4, '{\"category\":\"lesson_record\",\"lesson_record_id\":22}', NULL, '2024-12-26 02:27:56', '2024-12-26 02:27:56'),
('e5b929ee-4373-4e46-af3c-455ee6e567d9', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 43, '{\"category\":\"lesson_record\",\"lesson_record_id\":39}', '2025-02-19 04:54:04', '2025-02-18 13:52:25', '2025-02-19 04:54:04'),
('e7363816-ae55-4d18-8e48-2ef8bd1d3976', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 40, '{\"category\":\"lesson_record\",\"lesson_record_id\":42}', NULL, '2025-02-20 10:35:40', '2025-02-20 10:35:40'),
('e860ab87-c06e-4963-a4ef-180e09f63a44', 'App\\Notifications\\ForumCommentNotification', 'App\\Models\\User', 3, '{\"category\":\"forum_comment\",\"forum_id\":1,\"comment_id\":1}', '2024-01-11 16:55:32', '2024-01-11 16:52:09', '2024-01-11 16:55:32'),
('e9ba2adc-c16b-4c62-adf5-d7b1ce80ea34', 'App\\Notifications\\VideoAdviceCommentNotification', 'App\\Models\\User', 2, '{\"category\":\"video_advice_comment\",\"video_advice_id\":3,\"comment_id\":20}', NULL, '2024-12-05 04:05:57', '2024-12-05 04:05:57'),
('eaeb8bfd-2781-405d-a16c-ec401c9f233d', 'App\\Notifications\\LessonRecordCreatedNotification', 'App\\Models\\User', 18, '{\"category\":\"lesson_record\",\"lesson_record_id\":15}', '2024-11-11 05:35:17', '2024-11-11 05:34:35', '2024-11-11 05:35:17'),
('eea88a6f-478d-4e5d-83ae-bfe9764150d8', 'App\\Notifications\\CourseCommentNotification', 'App\\Models\\User', 18, '{\"category\":\"course_comment\",\"course_id\":8,\"comment_id\":12}', '2024-12-09 03:19:17', '2024-12-09 03:18:18', '2024-12-09 03:19:17'),
('f1d72c98-65e2-43db-9f9a-b78decc6f716', 'App\\Notifications\\VideoAdviceCreatedNotification', 'App\\Models\\User', 1, '{\"category\":\"video_advice\",\"video_advice_id\":8}', '2024-07-08 03:57:50', '2024-07-08 03:56:17', '2024-07-08 03:57:50');

-- --------------------------------------------------------

--
-- テーブルの構造 `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_available_time` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_teacher_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_usage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_restriction` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `schools`
--

INSERT INTO `schools` (`id`, `name`, `tel`, `tel_available_time`, `email`, `url`, `icon`, `top_img`, `register_teacher_token`, `storage_usage`, `payment_restriction`, `created_at`, `updated_at`) VALUES
(1, 'オンラインレッスンシステム「バーディーちゃん」', '03-6457-3264', NULL, 'info@serendec.com', 'https://www.serendec.co.jp', '3VcJ4hwXB69hTQTzByGr5HQ6bNAB2avDjrfex419.png', NULL, '$2y$10$HvhPgblvnBhMysin55fPJegedf.WZolzdFzrCX7HLe/FdiqvFXKhi', '0.20', 0, '2023-10-08 15:00:00', '2025-03-07 15:00:02'),
(2, 'H-1ゴルフアカデミー', '03-6457-8729', NULL, 'kusumoto@serendec.com', 'https://h-1golfacademy.com', NULL, NULL, '$2y$10$PKzms70dLKIDTRijUTm2fe6Fi77y37linPe3FNU8PTJaDDxUsXYwq', '0.03', 0, '2023-01-08 03:00:00', '2025-03-07 15:00:02'),
(3, 'GOLF STUDIO SHADOW', '06-6757-1630', NULL, 'golfstudio.shadow@gmail.com', 'https://golf-studio-shadow.com/', 'cwIIvg2CzWj1EapgpgEw0RolgQgWdTf5PHUZFbea.jpg', NULL, 'lM3drg9rIwby4pXz0YCNOKnjjlNniwVYBe16t4yxqO6rSusv7vTu', '0.33', 1, '2024-05-07 15:00:00', '2025-03-07 15:00:02'),
(4, '宮崎スクール', '090-7113-3736', NULL, 'bk11sadatomo@gmail.com', NULL, NULL, NULL, 'rJTyUdi8uTGxVEk8oYiEi1mzmnTA7IV5qqsFfk2GY1t3hsuGl4Tmc', '0.00', 0, '2024-05-07 15:00:00', '2025-03-07 15:00:02'),
(5, '心斎橋ゴルフスタジオ', '06-6786-8620', NULL, '196113@gmail.com', NULL, NULL, NULL, '96VfmJFVp7xtyihrPan9MJnxmaNIpJu57qh6E69KglY4OtauVzBeW', '0.00', 0, '2024-05-07 15:00:00', '2025-03-07 15:00:02'),
(6, 'SERENDEC', '03-1234-5678', NULL, 'kusumoto-regi@serendec.co.jp', NULL, NULL, NULL, 'mcUAapVPFA5NOhwDET5neZrTIHFPZFs12c557dMyQvZOsQ3JMRO', '0.00', 0, '2024-06-09 15:00:00', '2025-03-07 15:00:02'),
(7, 'AREA Golf Club', '090-1213-6000', NULL, 'yuji@area-golf.com', 'https://area-golf.com', NULL, NULL, 'ZCLlrGUwMejy3mFGDcvHkuAtnjALeLtHWQvkN4ZO7AfE8QYxtXbtW', '0.00', 0, '2024-10-03 15:00:00', '2025-03-07 15:00:02');

-- --------------------------------------------------------

--
-- テーブルの構造 `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `user_id`, `lesson_plan_id`, `memo`, `created_at`, `updated_at`) VALUES
(1, 2, 2, NULL, '2023-11-13 08:34:50', '2024-02-13 01:36:16'),
(2, 4, 1, NULL, '2024-01-10 09:09:31', '2024-01-11 16:32:08'),
(5, 15, 1, NULL, '2024-08-15 03:59:33', '2024-08-15 03:59:33'),
(6, 16, 6, NULL, '2024-09-25 01:22:33', '2024-12-26 02:19:27'),
(7, 18, 2, NULL, '2024-11-11 05:21:58', '2024-11-11 05:21:58'),
(8, 19, NULL, NULL, '2024-11-12 02:24:08', '2024-11-12 02:24:08'),
(9, 20, NULL, NULL, '2024-11-14 03:49:07', '2024-11-14 03:49:07'),
(10, 21, NULL, NULL, '2024-11-15 03:13:37', '2024-11-15 03:13:37'),
(11, 22, NULL, NULL, '2024-11-19 04:48:55', '2024-11-19 04:48:55'),
(12, 24, 2, NULL, '2024-12-23 03:01:28', '2024-12-23 03:01:28'),
(16, 33, 9, NULL, '2025-01-27 03:04:23', '2025-01-27 03:04:23'),
(18, 35, 9, NULL, '2025-01-28 06:34:21', '2025-01-28 06:34:21'),
(20, 37, 9, NULL, '2025-01-30 08:21:28', '2025-01-30 08:21:28'),
(21, 38, 2, NULL, '2025-01-31 01:38:02', '2025-01-31 01:38:02'),
(22, 39, 9, NULL, '2025-02-02 00:23:57', '2025-02-02 00:23:57'),
(23, 40, 9, NULL, '2025-02-02 11:24:06', '2025-02-02 11:24:06'),
(24, 41, 9, NULL, '2025-02-02 22:31:59', '2025-02-02 22:31:59'),
(25, 43, 9, NULL, '2025-02-09 03:24:29', '2025-02-09 03:24:29'),
(26, 44, 9, NULL, '2025-02-16 03:22:18', '2025-02-16 03:22:18'),
(27, 45, 9, NULL, '2025-02-20 14:21:30', '2025-02-20 14:21:30'),
(28, 46, 9, NULL, '2025-02-25 02:11:59', '2025-02-25 02:11:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `student_teacher_relations`
--

CREATE TABLE `student_teacher_relations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `student_teacher_relations`
--

INSERT INTO `student_teacher_relations` (`id`, `teacher_id`, `student_id`, `category`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'main', '2023-11-13 08:34:50', '2023-11-13 08:34:50'),
(2, 3, 4, 'main', '2024-01-10 09:09:31', '2024-01-10 09:09:31'),
(5, 3, 15, 'main', '2024-08-15 03:59:33', '2024-08-15 03:59:33'),
(6, 11, 16, 'main', '2024-09-25 01:22:33', '2024-09-25 01:22:33'),
(7, 13, 18, 'main', '2024-11-11 05:21:58', '2024-12-09 02:57:56'),
(8, 11, 19, 'main', '2024-11-12 02:24:08', '2024-11-12 02:24:08'),
(9, 11, 20, 'main', '2024-11-14 03:49:07', '2024-11-14 03:49:07'),
(10, 11, 21, 'main', '2024-11-15 03:13:37', '2024-11-15 03:13:37'),
(11, 7, 22, 'main', '2024-11-19 04:48:55', '2024-11-19 04:48:55'),
(15, 1, 18, 'sub', NULL, NULL),
(16, 1, 24, 'main', '2024-12-23 03:01:28', '2024-12-23 03:01:28'),
(21, 7, 33, 'main', '2025-01-27 03:04:23', '2025-01-27 03:04:23'),
(23, 7, 35, 'main', '2025-01-28 06:34:21', '2025-01-28 06:34:21'),
(25, 7, 37, 'main', '2025-01-30 08:21:28', '2025-01-30 08:21:28'),
(26, 1, 38, 'main', '2025-01-31 01:38:02', '2025-01-31 01:38:02'),
(27, 7, 39, 'main', '2025-02-02 00:23:57', '2025-02-02 00:23:57'),
(28, 7, 40, 'main', '2025-02-02 11:24:06', '2025-02-02 11:24:06'),
(29, 7, 41, 'main', '2025-02-02 22:31:59', '2025-02-02 22:31:59'),
(30, 7, 43, 'main', '2025-02-09 03:24:29', '2025-02-09 03:24:29'),
(31, 7, 44, 'main', '2025-02-16 03:22:18', '2025-02-16 03:22:18'),
(32, 7, 45, 'main', '2025-02-20 14:21:30', '2025-02-20 14:21:30'),
(33, 7, 46, 'main', '2025-02-25 02:11:59', '2025-02-25 02:11:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `tags`
--

INSERT INTO `tags` (`id`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 2, 'スライス', '2024-01-10 11:48:10', '2024-01-10 11:48:10'),
(2, 1, 'スイング', '2024-02-13 01:39:25', '2024-02-13 01:39:25'),
(3, 1, 'ドライバー', '2024-02-13 01:39:43', '2024-02-13 01:39:43'),
(4, 2, 'フック、引っ掛け', '2024-03-21 14:06:55', '2024-03-21 14:06:55'),
(5, 2, 'ダフリ', '2024-03-21 14:07:03', '2024-03-21 14:07:03'),
(6, 2, 'トップ', '2024-03-21 14:07:09', '2024-03-21 14:07:09'),
(7, 2, 'スイング軌道', '2024-03-21 14:07:31', '2024-03-21 14:07:31'),
(8, 2, 'アプローチ', '2024-03-21 14:07:40', '2024-03-21 14:07:40'),
(9, 2, 'ドライバー', '2024-03-21 14:07:47', '2024-03-21 14:07:47'),
(10, 2, 'フェアウェイウッド　FW', '2024-03-21 14:07:58', '2024-03-21 14:07:58'),
(11, 2, 'ユーティリティ　UT', '2024-03-21 14:08:06', '2024-03-21 14:08:06'),
(12, 2, 'アイアン', '2024-03-21 14:08:14', '2024-03-21 14:08:14'),
(13, 2, 'ウェッジ', '2024-03-21 14:08:27', '2024-03-21 14:08:27'),
(15, 2, 'マネージメント', '2024-12-26 02:27:07', '2024-12-26 02:27:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_name_kana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name_kana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `register_student_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `family_name`, `first_name`, `family_name_kana`, `first_name_kana`, `nickname`, `icon`, `tel`, `email`, `line_id`, `role`, `school_id`, `active`, `register_student_token`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `stripe_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'テスト', '管理者権限', 'うちた', 'かずのり', NULL, 'OeGGPMhnkPgUV9mzQL39CmLo9nUP07ksh412dsXv.jpg', '00011112222', 'birdie-regi@online-golf.jp', NULL, 'admin', 1, 1, 'NXTdXSWsllJcJi2nfSC13CrbeCQKjCcR', '2023-10-08 15:00:00', '$2y$10$jLTb3Y5.nqw3d/ufF.V8KeluUoPPRtA8nvPZMmXWpbD02lBuq6KT2', NULL, NULL, NULL, NULL, 'yvEaJEfnTavyAMk2jgeLv5mNQgmtDfQuYvJUEHl1otKEOIG0PGgEVAdXGPcC', '2023-10-08 15:00:00', '2024-12-06 06:02:26'),
(2, '飛田', '学', 'とびた', 'まなぶ', 'とび', NULL, '00011112222', 'null_01@serendec.com', NULL, 'student', 1, 1, NULL, '2024-02-26 01:26:10', '$2y$10$RZiGex88M1gWHRqX0D9ekekPjXrN9Q1Ytade8kWjWM5/0XSjDEJuG', NULL, NULL, NULL, NULL, 'rtCvXIaPJd2D3twfcAZpnC1UCIx7xD2sW6i94HCfF9AMm8n83rgzrhuJDg0E', '2023-11-13 08:34:50', '2024-11-12 02:27:02'),
(3, '関', '貴之', 'せき', 'たかゆき', NULL, NULL, '0364578729', 'info@h-1golfacademy.com', NULL, 'admin', 2, 1, 'C7Hc7whpG2GzJEOL8iHHU9nBdfMBqI6ElZ9GWvhy3vykIy45S2', '2023-01-08 03:00:00', '$2y$10$Ap4WCY2KBYXCiGgUrWbfZukhgpyChPlD22WTU8NOV4..jU8lWiepW', NULL, NULL, NULL, NULL, NULL, '2023-01-08 03:00:00', '2023-01-08 03:00:00'),
(4, '楠本', 'ゆうき', 'くすもと', 'ユウキ', NULL, NULL, '09057571380', 'kusumoto-regi@serendec.co.jp', 'kusuline7', 'student', 2, 1, NULL, '2024-01-10 09:12:38', '$2y$10$oSujDrCxe0P2fKUmxFno4..K0q.R0Oa35FfbEzRFt.6nFSUf8fA.6', NULL, NULL, NULL, NULL, 'VDXcF61d3IF8OkZVmhPrgFqAvugmPcS0rBhhVowW9D5s6VTis8x9p29KFz3P', '2024-01-10 09:09:31', '2024-07-12 03:24:51'),
(5, '楠本', '先生', 'クスモト', 'せんせい', NULL, NULL, '09057571380', 'kusumoto@serendec.com', NULL, 'teacher', 1, 1, 'u7nVZWZ5WBNIK38l39Rdg43OnCw1IazP', '2024-03-21 14:33:48', '$2y$10$C0Pw/Dv5on9szNNju2XqneoK.vIa/6l4nQMiN7r/wwYsBkug2E0/u', NULL, NULL, NULL, NULL, NULL, '2024-03-21 14:32:58', '2024-03-21 14:33:48'),
(7, '影山', '拓真', 'かげやま', 'たくま', NULL, 'cSs5oTHhPuejnXa8LEp6UJrNKtstN5By31Zr2Yx9.jpg', '06-6757-1630', 'golfstudio.shadow@gmail.com', NULL, 'admin', 3, 1, 'T3DO4rVvd3jfg2P0sqoVushGZ5Gi5h3cXqIjw5FNATjkb47TJQRS', '2024-05-07 15:00:00', '$2y$10$j2WWmt596/yczoY9kj0VR.oBvliyx6aZ08wtkKPjvslsKa2kzoA8C', NULL, NULL, NULL, NULL, NULL, '2024-05-07 15:00:00', '2025-02-07 03:07:09'),
(8, '宮崎', '定智', 'みやざき', 'さだとも', NULL, NULL, '090-7113-3736', 'all@serendec.co.jp', NULL, 'admin', 4, 1, 'F7aTmNE0HGbRlc5QCV5eG0WufYYYLJs53olqbqSg1lWJDORHLm', '2024-05-07 15:00:00', '$2y$10$YHCod3eXyEU/kDV6L/ARe.X1lz/B5YvjpXvjCw6SM2o0uM.2sahMW', NULL, NULL, NULL, NULL, NULL, '2024-05-07 15:00:00', '2024-08-16 09:10:59'),
(9, '星山', '浩鐘', 'ほしやま', 'こうしょう', NULL, NULL, '06-6786-8620', '196113@gmail.com', NULL, 'admin', 5, 1, '3cGRzg4gYAHsemPqMLqgPW6J8Qd2jKChVSmHE1HJZ67ozAdt8K', '2024-05-07 15:00:00', '$2y$10$b9fmy3jKzOQIqWNC8jvs.OuyVeSKjAcaXE9E0DDplEwaGIBVbrVUi', NULL, NULL, NULL, NULL, NULL, '2024-05-07 15:00:00', '2024-05-07 15:00:00'),
(11, '楠本', 'ゆうき', 'くすもと', 'ゆうき', NULL, NULL, '090-5757-1380', 'kusumoto-regi2@serendec.co.jp', NULL, 'admin', 6, 1, 'JOj9CXmSFuOKNDZpaSMuAkPDlleBDLzVCClFJIxoK5GvJxDb0ne', '2024-06-09 15:00:00', '$2y$10$jObEJWi8L3hA85N5OwfWie8SwlYEsuFTmZNrhT9Sw.T/R3jJwukd.', NULL, NULL, NULL, NULL, NULL, '2024-06-09 15:00:00', '2024-09-24 12:32:31'),
(13, 'テスト', '管理者なし', 'こうし', 'せんせい', NULL, NULL, '08012341234', 'checktest-02@serendec.co.jp', NULL, 'teacher', 1, 1, 'Z4KbYj5bbULYsA60ZlmEJtry3CkzvIaf', '2024-07-08 05:40:59', '$2y$10$uu5B9mld3EJnOTx3eq6wTOXWrIRUjADwxWC3rNoeCCuaLUsWcullO', NULL, NULL, NULL, NULL, 'wvjznwhXxSPtL0Gdp5KaMD8U21057W0Vfj5cltqusMxkU306kuXTEdc3mvmA', '2024-07-08 05:39:36', '2024-12-09 02:33:57'),
(14, 'スーパー', 'アドミン', 'スーパー', 'アドミン', NULL, NULL, '', 'super-admin@serendec.com', NULL, 'super_admin', 1, 1, NULL, '2024-07-29 15:00:00', '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm', NULL, NULL, NULL, NULL, NULL, '2024-07-29 15:00:00', '2024-07-29 15:00:00'),
(15, 'セレンデック', 'てすとくすもと', 'てすと', 'くすもと', NULL, NULL, '0364573264', 'info@serendec.co.jp', NULL, 'student', 2, 1, NULL, NULL, '$2y$10$Mx6cQNZMcNvkgJCM0jT6IOKr86wTzfjHF6gQ0eOlOpFtWN8bHPvSO', NULL, NULL, NULL, NULL, NULL, '2024-08-15 03:59:33', '2024-08-15 03:59:33'),
(16, '小野', '真奈', 'おの', 'まな', NULL, NULL, '0364573264', 'ono@serendec.com', 'ono@serendec', 'student', 6, 1, NULL, '2024-09-25 01:22:49', '$2y$10$hX0TCv7K8MoghQAmAN1mX.7F6uX1UrFLHa7.UK2xwkNrO.rGmVZfq', NULL, NULL, NULL, NULL, NULL, '2024-09-25 01:22:33', '2024-11-14 03:53:04'),
(17, '外﨑', '裕二', 'とざき', 'ゆうじ', NULL, NULL, '09012136000', 'yuji@area-golf.com', NULL, 'admin', 7, 1, '4gdt2gqg5zEESrl686FLe8QZybhl5Q4i3fbplH31aXx0HE4mtt3m', '2024-10-03 15:00:00', '$2y$10$ow1zmC97YDt8hUjeGf9I4.5XzqvfenDN.JEbmkjtKoEQt8f9VelFq', NULL, NULL, NULL, NULL, NULL, '2024-10-03 15:00:00', '2024-10-03 15:00:00'),
(18, 'テスト', '生徒', 'てすと', 'せいと', NULL, NULL, '00011112222', 'checktest-01@serendec.co.jp', NULL, 'student', 1, 1, NULL, '2024-11-11 05:23:36', '$2y$10$Tz5ZW.mUBo5SAYMUSUCARebyOUP0v0lQUdWwJDcuZW4n.4OfON4r6', NULL, NULL, NULL, NULL, 'CPSNzZwuTFmeN7mTbKW8cF7n53tQcL1qLpWJhCQbosagwzvoT8T0jyJMhAsE', '2024-11-11 05:21:58', '2024-12-06 07:58:07'),
(19, '澤', '郁美', 'さわ', 'いくみ', NULL, NULL, '00011112222', 'xxmin.38ch@gmail.com', NULL, 'student', 6, 1, NULL, '2024-11-12 02:24:31', '$2y$10$g4c1R8DKZ1JRsnXR7x5MM.tdbSkKB19y/XNAhmDEmXQV7RGf4FJaq', NULL, NULL, NULL, NULL, NULL, '2024-11-12 02:24:08', '2024-11-12 02:24:31'),
(20, '中込', '真由', 'なかごみ', 'まゆ', NULL, NULL, '08051718657', 'nakagomi@serendec.com', NULL, 'student', 6, 1, NULL, '2024-11-14 03:49:54', '$2y$10$Z/1ZE/z5K9dUekPDTJY38.hutTyN1e.u23nStzgm5WCkOnkBmpJlS', NULL, NULL, NULL, NULL, NULL, '2024-11-14 03:49:07', '2024-11-14 03:49:54'),
(21, '堀江', '玲奈', 'ほりえ', 'れいな', NULL, NULL, '08012345678', 'horie@serendec.com', NULL, 'student', 6, 1, NULL, '2024-11-15 03:13:45', '$2y$10$fRW5Dybo4MLU1ev732TkR.QtlibL1/Af5xDj5IhKv9IZbadND25Qe', NULL, NULL, NULL, NULL, NULL, '2024-11-15 03:13:37', '2024-11-15 03:13:45'),
(22, '影山', '拓真', 'かげやま', 'たくま', NULL, NULL, '08053134653', 'onefordream72@gmail.com', NULL, 'student', 3, 1, NULL, NULL, '$2y$10$j6LW2o78CDomNjonQf2pyOVafAtkXf4NZCfR/3K4xCgMhDd7lCrm6', NULL, NULL, NULL, NULL, NULL, '2024-11-19 04:48:55', '2024-11-19 04:48:55'),
(24, '山田', '花子', 'やまだ', 'はなこ', NULL, NULL, '0398760023', 'checktest@serendec.co.jp', NULL, 'student', 1, 1, NULL, NULL, '$2y$10$ALwjidbFyXFhwTNflgkV1uRSvjg10pr8Cumn.4V8AYlc34pu0RGkq', NULL, NULL, NULL, NULL, NULL, '2024-12-23 03:01:28', '2024-12-23 03:01:28'),
(26, '河野', '太郎', 'かわの', '太郎', NULL, NULL, '0398760023', 'checktest-03@serendec.co.jp', NULL, 'teacher', 1, 1, 'f0dfU2SBKmcLRA2njmiiAe0EjnkMUtQe', '2024-12-23 06:27:08', '$2y$10$wLOZWGfpbQOar8n8.F0v1OC11LaIAaJRH/6MZOpVUvoivbabg8ify', NULL, NULL, NULL, NULL, NULL, '2024-12-23 06:24:40', '2024-12-23 06:27:08'),
(29, '井上', '輝政', 'いのうえ', 'てるまさ', NULL, 'nPz2RdIqNs3IFK9EXPR3bNkLiH4vKdohJK2wd52w.jpg', '08085073305', 'inoteru0910@gmail.com', NULL, 'teacher', 3, 1, 'RpwWTWPdxDhjnyykn9DtXrUHeVoL1f8O', '2025-01-07 08:18:32', '$2y$10$RMO8J3WOfUKKbdlBmXt5oumOG0ZOnkLwXUa3xyr2rYGVJsgOZS9Vu', NULL, NULL, NULL, NULL, NULL, '2025-01-07 08:18:17', '2025-01-07 08:18:32'),
(30, '徳原', '悠也', 'とくはら', 'ゆうや', NULL, NULL, '08014875775', 'yuya.ynwa521@gmail.com', NULL, 'teacher', 3, 1, 'qWyw5V2i8FFbKOq3JfNbF0jtlU86mwnR', '2025-01-09 13:04:16', '$2y$10$xwatGCNVVF3KJXB81oKde.ZT0azwYiHKxBPQReLw15YXjIsWsWEqa', NULL, NULL, NULL, NULL, NULL, '2025-01-09 13:03:43', '2025-01-09 13:04:16'),
(31, '筒井', '雄大', 'つつい', 'ゆうだい', NULL, NULL, '08038310170', 'yudaikun1206@icloud.com', NULL, 'teacher', 3, 1, 'dGHDXxp1Zmkht7fWqJbmxDQnQAGuDiJf', '2025-01-22 02:49:20', '$2y$10$UH4wgKegPrAsSCYIjHwhO.G6lo/ga9wc50O9y3Af4x0r5SvuhjBTK', NULL, NULL, NULL, NULL, NULL, '2025-01-22 02:48:46', '2025-01-22 02:49:20'),
(32, 'テスト', '事業', 'てすと', 'じぎょう', NULL, NULL, '0312341234', 'checktest-04@serendec.co.jp', NULL, 'teacher', 1, 1, 'y0MAJhuatzViFwVQRnIvXC7QRoR9WdL3', '2025-01-24 03:03:30', '$2y$10$8lRDWtqLE6TBQbJkFbw6FO00Ign6POVW7Mx0W823c5Pv5fMxT4Cgm', NULL, NULL, NULL, NULL, NULL, '2025-01-24 02:50:06', '2025-01-24 03:03:30'),
(33, '井上', '雄介', 'いのうえ', 'ゆうすけ', NULL, NULL, '09020484957', 'lizhidora12@gmail.com', NULL, 'student', 3, 1, NULL, '2025-01-27 03:04:44', '$2y$10$Bk1IM77E2UH9NrhmFgzx5OBGXfCLkaYsPylzhuHUI283BhYRDmlhC', NULL, NULL, NULL, NULL, NULL, '2025-01-27 03:04:23', '2025-01-27 03:04:44'),
(35, '向井', '京子', 'むかい', 'きょうこ', NULL, NULL, '09050587654', 'tadapu-toshi-160708maho@docomo.ne.jp', 'kkkk8979', 'student', 3, 1, NULL, '2025-01-28 06:35:46', '$2y$10$hQGnTAIUqiUDSntVBbbdZetbycYGHWy6xj9vIucpVm80vHeVB549a', NULL, NULL, NULL, NULL, NULL, '2025-01-28 06:34:21', '2025-01-28 06:35:46'),
(37, '青木', '牧子', 'あおき', 'まきこ', 'まきちゃん', 'wpt1KRQl2FZSJPOCqNEIw3hxY9K2cSnHaCZu2ZDy.png', '09091106006', 'w000403w@icloud.com', 'djmaki', 'student', 3, 1, NULL, '2025-01-30 08:22:15', '$2y$10$H8zza/HKv282.TpC0x4B8uAMcciUjtH06WPS55Wd08O0u1r4jkxqK', NULL, NULL, NULL, NULL, NULL, '2025-01-30 08:21:28', '2025-02-20 13:44:16'),
(38, '田中', 'テスト', 'たなか', 'てすと', NULL, NULL, '0398760023', 'yoshii-a@serendec.com', NULL, 'student', 1, 1, NULL, '2025-01-31 01:38:13', '$2y$10$c7HrPCeK3v7WCCUNGvUXze7AWEPo6HutId1vNYI0AQeYngFm4BMxK', NULL, NULL, NULL, NULL, NULL, '2025-01-31 01:38:02', '2025-01-31 01:38:13'),
(39, '平敷', '誠', 'ひらしき', 'まこと', NULL, NULL, '09089354997', 'Kintwo@icloud.com', 'MakoMako4711', 'student', 3, 1, NULL, '2025-02-02 00:24:36', '$2y$10$D7S5WuIC/7prwXPFpS7HReGFm.UeJXWwRyx4UQ/KytjxPW.YIra1m', NULL, NULL, NULL, NULL, NULL, '2025-02-02 00:23:57', '2025-02-02 00:24:36'),
(40, '木下', '勝元', 'きのした', 'かつゆき', NULL, NULL, '09042956825', 't27b88927975a@gmail.com', NULL, 'student', 3, 1, NULL, '2025-02-02 11:24:29', '$2y$10$AXIp6.M4.teo94/XqgIceulKMmmfQcgD1KN3jvE.eQMg9/kR0F8S.', NULL, NULL, NULL, NULL, NULL, '2025-02-02 11:24:06', '2025-02-02 11:24:29'),
(41, '新城', '公生', 'しんじょう', 'きみお', NULL, NULL, '09037133780', 'mikio.smb@gmail.com', NULL, 'student', 3, 1, NULL, '2025-02-02 22:32:27', '$2y$10$FDx0J257KpJo.IzzM0eFneoePcddzp02gE3VNZLsutCK1VoYSHNX.', NULL, NULL, NULL, NULL, NULL, '2025-02-02 22:31:59', '2025-02-02 22:32:27'),
(42, '徳原', '悠也', 'とくはら', 'ゆうや', NULL, NULL, '08014875775', 'ynwa.22721@gmail.com', NULL, 'teacher', 3, 1, 'TXK8ohFKuGnNUivJPxSdSAeG9zUV6alE', '2025-02-04 05:37:27', '$2y$10$shf696jbH65psKLcMHUxAudiQpzb3eQt9g/8aglbMEjCS71S1WbSu', NULL, NULL, NULL, NULL, NULL, '2025-02-04 05:27:56', '2025-02-04 05:37:27'),
(43, '川口', '貴利', 'かわぐち', 'たかとし', NULL, 'h18SIBVQgFQBlrPB7C7me40hiREWEEqBLkPFGfCv.jpg', '09014470061', 'saemoe12020317@gmail.com', 'takatoshi.kawaguchi', 'student', 3, 1, NULL, '2025-02-09 03:25:23', '$2y$10$ca9rt3zMUHZXCO9X0LZ5KuKpDTItfD6BXpR9.LfkZcno5K5bUleOu', NULL, NULL, NULL, NULL, NULL, '2025-02-09 03:24:29', '2025-02-09 03:25:23'),
(44, '高山', '義雄', 'たかやま', 'よしお', NULL, NULL, '09016722891', 'takakk.yoshi@gmail.com', NULL, 'student', 3, 1, NULL, '2025-02-16 03:23:05', '$2y$10$TBNBdpcj2UFs2mNv3sREweKMgXoWS4cxsnPO3EVtWmOqyf0t4u5hi', NULL, NULL, NULL, NULL, NULL, '2025-02-16 03:22:18', '2025-02-16 03:23:05'),
(45, '猪又', '昌哉', 'いのまた', 'まさや', NULL, NULL, '08053218064', '1222massan@gmail.com', NULL, 'student', 3, 1, NULL, '2025-02-20 14:22:00', '$2y$10$vI77SJKeViAuq1FF9TeNXuC162OatSygOVWpabwmrDo.FAYJ4J1VC', NULL, NULL, NULL, NULL, NULL, '2025-02-20 14:21:30', '2025-02-20 14:22:00'),
(46, '小栗', '正夫', 'オグリ', 'マサオ', NULL, NULL, '09021198922', 'zhengfuxiaoli@gmail.com', NULL, 'student', 3, 1, NULL, '2025-02-25 02:12:24', '$2y$10$vadUztAsaI4R8wLaaTYbdu5Fb0RFifxQZ9L/UplsnGYgNDi2xPDL6', NULL, NULL, NULL, NULL, NULL, '2025-02-25 02:11:59', '2025-02-25 02:12:24');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_course_progress`
--

CREATE TABLE `user_course_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `first_played_at` datetime DEFAULT NULL,
  `is_watched` tinyint(1) NOT NULL DEFAULT '0',
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `last_played_at` datetime DEFAULT NULL,
  `played_count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `user_course_progress`
--

INSERT INTO `user_course_progress` (`id`, `user_id`, `course_id`, `first_played_at`, `is_watched`, `is_completed`, `last_played_at`, `played_count`, `created_at`, `updated_at`) VALUES
(3, 18, 5, NULL, 0, 0, NULL, 0, '2024-11-11 05:59:02', '2025-02-05 04:35:23'),
(4, 18, 10, NULL, 0, 1, NULL, 0, '2024-12-09 05:48:02', '2024-12-09 05:48:02'),
(6, 18, 9, NULL, 0, 0, NULL, 0, '2025-02-05 02:52:29', '2025-02-05 02:52:32'),
(7, 4, 3, NULL, 0, 1, NULL, 0, '2025-03-13 07:41:14', '2025-03-13 07:41:14'),
(8, 1, 18, '2025-03-27 23:27:07', 1, 0, '2025-03-27 23:27:54', 2, '2025-03-27 14:27:07', '2025-03-27 14:49:44'),
(9, 1, 9, '2025-03-27 23:50:40', 1, 0, NULL, 0, '2025-03-27 14:50:40', '2025-03-27 14:50:40'),
(10, 16, 16, '2025-04-01 15:49:42', 1, 1, '2025-04-17 11:20:59', 1, '2025-04-01 06:49:42', '2025-04-17 02:33:56'),
(11, 16, 14, '2025-04-01 15:50:22', 1, 0, NULL, 0, '2025-04-01 06:50:22', '2025-04-01 06:50:22'),
(12, 16, 13, '2025-04-01 15:50:41', 1, 0, NULL, 0, '2025-04-01 06:50:41', '2025-04-01 06:50:41'),
(13, 16, 17, NULL, 0, 1, NULL, 0, '2025-04-17 02:33:40', '2025-04-17 02:33:40');

-- --------------------------------------------------------

--
-- テーブルの構造 `video_advice`
--

CREATE TABLE `video_advice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci,
  `question` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `video_advice`
--

INSERT INTO `video_advice` (`id`, `student_id`, `title`, `video`, `question`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '動画みてください。テスト', 'Te0rLUfn81mHkDArTcmOhIqxu9ykrjA0HaS26b9U.mov', 'テスト', 'open', '2024-01-11 16:41:41', '2024-01-11 16:41:41'),
(2, 4, 'テスト', 'tHrpvaPe9RNoyrcB4hQQjhTZKXekdmV0QnPxzDve.mov', 'だふるよ', 'open', '2024-01-12 02:43:06', '2024-01-12 02:43:08'),
(3, 2, '7番アイアンのスイングフォーム', '1j1gKb2nWNFn2E2iiZzqvlFze1LdbJvvrsev3PmQ.mp4', '前回のレッスンでいただいたポイントを意識して振ってみました。\r\nただ、思ったより飛距離が伸びず...\r\n新たに、フォームが崩れている部分などはないでしょうか？', 'open', '2024-03-21 07:16:34', '2024-03-21 07:16:38'),
(4, 4, 'アイアン　８番', 'ZjpcsDTDrf4xAYtI7Bg56B9TfcshQTOO1tVdE4Ty.mov', 'こんな感じです', 'open', '2024-04-26 05:26:05', '2024-04-26 05:26:42'),
(5, 4, 'アイアン　８番', 'WkkSwGQvcGAhYGHLYzOEWXF3W8d0rZ5DDPYGXsPX.mov', 'こんな感じです', 'open', '2024-04-26 05:26:06', '2024-04-26 05:26:42'),
(6, 4, '動画てすと', 'H3mNFzB986sMEMA80uFUlnLDtt32LvdiEP0mTkLC.mov', 'アイアン', 'closed', '2024-05-01 03:50:01', '2024-09-02 04:20:18'),
(7, 4, '動画てすと', 'GnzKO17b0GBSDIm7c5JYq9088DmMAryGqsIlLj57.mov', 'アイアン', 'closed', '2024-05-01 03:50:09', '2024-05-01 04:18:53'),
(9, 18, 'テスト', 'LBhs2OvuLi5BgrZu5ZD0HgUDE5a7ZtEsQnpRa4bS.mp4', 'てすと', 'closed', '2024-11-11 05:32:38', '2024-11-11 05:44:18'),
(10, 18, 'テスト', 'yfngUel59bOXbAwuhD9Kf6hl9zkk8ITnD90ZLO69.mp4', 'テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト', 'open', '2024-12-06 08:00:52', '2024-12-06 08:01:02'),
(11, 18, '生徒', 'upYVBee63jyoDNAdg7iq4rxmiKGR0OFAfgWNetsm.mp4', '質問内容', 'open', '2024-12-09 03:14:53', '2024-12-09 03:14:59'),
(13, 38, 'テスト', 'PdOwaWDw7yEdutVOoA3tOrt1HHBakVS699iJfcqi.mp4', 'テスト', 'open', '2025-01-31 01:41:22', '2025-01-31 01:41:30');

-- --------------------------------------------------------

--
-- テーブルの構造 `video_advice_comments`
--

CREATE TABLE `video_advice_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `video_advice_id` bigint(20) UNSIGNED NOT NULL,
  `parent_comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mentioned_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `video_advice_comments`
--

INSERT INTO `video_advice_comments` (`id`, `video_advice_id`, `parent_comment_id`, `mentioned_user_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, 4, 3, 'だふってますね', '2024-01-12 02:43:54', '2024-01-12 02:43:54'),
(3, 7, NULL, 4, 3, 'アドバイスを入れる', '2024-05-01 04:18:21', '2024-05-01 04:18:21'),
(14, 5, NULL, 3, 4, 'aa', '2024-05-02 06:09:39', '2024-05-02 06:09:39'),
(15, 5, 14, NULL, 4, 'aa', '2024-05-02 06:09:45', '2024-05-02 06:09:45'),
(16, 1, NULL, 3, 4, 'aa', '2024-05-02 06:10:13', '2024-05-02 06:10:13'),
(19, 6, NULL, 4, 3, '：：：', '2024-09-02 04:20:09', '2024-09-02 04:20:09'),
(20, 3, NULL, 2, 1, 'テスト', '2024-12-05 04:05:57', '2024-12-05 04:05:57'),
(21, 10, NULL, 13, 18, '生徒', '2024-12-09 03:10:03', '2024-12-09 03:10:03'),
(22, 10, 21, 18, 1, '管理者あり', '2024-12-09 03:17:07', '2024-12-09 03:17:07'),
(25, 11, NULL, 18, 5, '体の回転を止めずに打つの意識してみてください。', '2024-12-26 02:16:02', '2024-12-26 02:16:02');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_school_id_foreign` (`school_id`);

--
-- テーブルのインデックス `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_categories_school_id_foreign` (`school_id`);

--
-- テーブルのインデックス `course_comments`
--
ALTER TABLE `course_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_comments_course_id_foreign` (`course_id`),
  ADD KEY `course_comments_parent_comment_id_foreign` (`parent_comment_id`);

--
-- テーブルのインデックス `course_comment_likes`
--
ALTER TABLE `course_comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_comment_likes_user_id_foreign` (`user_id`),
  ADD KEY `course_comment_likes_course_comment_id_foreign` (`course_comment_id`);

--
-- テーブルのインデックス `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- テーブルのインデックス `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forums_school_id_foreign` (`school_id`);

--
-- テーブルのインデックス `forum_bookmarks`
--
ALTER TABLE `forum_bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_bookmarks_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_comments_forum_id_foreign` (`forum_id`),
  ADD KEY `forum_comments_parent_comment_id_foreign` (`parent_comment_id`);

--
-- テーブルのインデックス `forum_comment_likes`
--
ALTER TABLE `forum_comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_comment_likes_user_id_foreign` (`user_id`),
  ADD KEY `forum_comment_likes_forum_comment_id_foreign` (`forum_comment_id`);

--
-- テーブルのインデックス `forum_likes`
--
ALTER TABLE `forum_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forum_likes_forum_id_user_id_unique` (`forum_id`,`user_id`),
  ADD KEY `forum_likes_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `forum_tag`
--
ALTER TABLE `forum_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_tag_forum_id_foreign` (`forum_id`),
  ADD KEY `forum_tag_tag_id_foreign` (`tag_id`);

--
-- テーブルのインデックス `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- テーブルのインデックス `lesson_plans`
--
ALTER TABLE `lesson_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_plans_school_id_foreign` (`school_id`);

--
-- テーブルのインデックス `lesson_records`
--
ALTER TABLE `lesson_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_records_student_id_foreign` (`student_id`);

--
-- テーブルのインデックス `lesson_record_tag`
--
ALTER TABLE `lesson_record_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_record_tag_lesson_record_id_foreign` (`lesson_record_id`),
  ADD KEY `lesson_record_tag_tag_id_foreign` (`tag_id`);

--
-- テーブルのインデックス `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- テーブルのインデックス `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- テーブルのインデックス `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- テーブルのインデックス `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_register_teacher_token_unique` (`register_teacher_token`);

--
-- テーブルのインデックス `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_profiles_user_id_foreign` (`user_id`);

--
-- テーブルのインデックス `student_teacher_relations`
--
ALTER TABLE `student_teacher_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_teacher_relations_teacher_id_foreign` (`teacher_id`),
  ADD KEY `student_teacher_relations_student_id_foreign` (`student_id`);

--
-- テーブルのインデックス `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_school_id_foreign` (`school_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_register_student_token_unique` (`register_student_token`),
  ADD KEY `users_school_id_foreign` (`school_id`);

--
-- テーブルのインデックス `user_course_progress`
--
ALTER TABLE `user_course_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_course_progress_user_id_course_id_unique` (`user_id`,`course_id`),
  ADD KEY `user_course_progress_course_id_foreign` (`course_id`);

--
-- テーブルのインデックス `video_advice`
--
ALTER TABLE `video_advice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_advice_student_id_foreign` (`student_id`);

--
-- テーブルのインデックス `video_advice_comments`
--
ALTER TABLE `video_advice_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_advice_comments_video_advice_id_foreign` (`video_advice_id`),
  ADD KEY `video_advice_comments_parent_comment_id_foreign` (`parent_comment_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- テーブルの AUTO_INCREMENT `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `course_comments`
--
ALTER TABLE `course_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- テーブルの AUTO_INCREMENT `course_comment_likes`
--
ALTER TABLE `course_comment_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `forums`
--
ALTER TABLE `forums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `forum_bookmarks`
--
ALTER TABLE `forum_bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルの AUTO_INCREMENT `forum_comment_likes`
--
ALTER TABLE `forum_comment_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `forum_likes`
--
ALTER TABLE `forum_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `forum_tag`
--
ALTER TABLE `forum_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `lesson_plans`
--
ALTER TABLE `lesson_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `lesson_records`
--
ALTER TABLE `lesson_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- テーブルの AUTO_INCREMENT `lesson_record_tag`
--
ALTER TABLE `lesson_record_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- テーブルの AUTO_INCREMENT `student_teacher_relations`
--
ALTER TABLE `student_teacher_relations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- テーブルの AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- テーブルの AUTO_INCREMENT `user_course_progress`
--
ALTER TABLE `user_course_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- テーブルの AUTO_INCREMENT `video_advice`
--
ALTER TABLE `video_advice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- テーブルの AUTO_INCREMENT `video_advice_comments`
--
ALTER TABLE `video_advice_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `course_categories`
--
ALTER TABLE `course_categories`
  ADD CONSTRAINT `course_categories_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `course_comments`
--
ALTER TABLE `course_comments`
  ADD CONSTRAINT `course_comments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_comments_parent_comment_id_foreign` FOREIGN KEY (`parent_comment_id`) REFERENCES `course_comments` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `course_comment_likes`
--
ALTER TABLE `course_comment_likes`
  ADD CONSTRAINT `course_comment_likes_course_comment_id_foreign` FOREIGN KEY (`course_comment_id`) REFERENCES `course_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_comment_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `forum_bookmarks`
--
ALTER TABLE `forum_bookmarks`
  ADD CONSTRAINT `forum_bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD CONSTRAINT `forum_comments_forum_id_foreign` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_comments_parent_comment_id_foreign` FOREIGN KEY (`parent_comment_id`) REFERENCES `forum_comments` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `forum_comment_likes`
--
ALTER TABLE `forum_comment_likes`
  ADD CONSTRAINT `forum_comment_likes_forum_comment_id_foreign` FOREIGN KEY (`forum_comment_id`) REFERENCES `forum_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_comment_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `forum_likes`
--
ALTER TABLE `forum_likes`
  ADD CONSTRAINT `forum_likes_forum_id_foreign` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `forum_tag`
--
ALTER TABLE `forum_tag`
  ADD CONSTRAINT `forum_tag_forum_id_foreign` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `lesson_plans`
--
ALTER TABLE `lesson_plans`
  ADD CONSTRAINT `lesson_plans_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `lesson_records`
--
ALTER TABLE `lesson_records`
  ADD CONSTRAINT `lesson_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `lesson_record_tag`
--
ALTER TABLE `lesson_record_tag`
  ADD CONSTRAINT `lesson_record_tag_lesson_record_id_foreign` FOREIGN KEY (`lesson_record_id`) REFERENCES `lesson_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_record_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `student_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `student_teacher_relations`
--
ALTER TABLE `student_teacher_relations`
  ADD CONSTRAINT `student_teacher_relations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_teacher_relations_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `user_course_progress`
--
ALTER TABLE `user_course_progress`
  ADD CONSTRAINT `user_course_progress_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_course_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `video_advice`
--
ALTER TABLE `video_advice`
  ADD CONSTRAINT `video_advice_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `video_advice_comments`
--
ALTER TABLE `video_advice_comments`
  ADD CONSTRAINT `video_advice_comments_parent_comment_id_foreign` FOREIGN KEY (`parent_comment_id`) REFERENCES `video_advice_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_advice_comments_video_advice_id_foreign` FOREIGN KEY (`video_advice_id`) REFERENCES `video_advice` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
