-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 13 2025 г., 14:06
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `praktasocial`
--

-- --------------------------------------------------------

--
-- Структура таблицы `audios`
--

CREATE TABLE `audios` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `artist` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `audios`
--

INSERT INTO `audios` (`id`, `title`, `artist`, `file_path`, `cover_path`, `duration`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Somebody once told me', 'Shrek', 'audios/lWxUwMaf9xqbvcYFMqFkCvSrZP3k6oFYcgI4Gnuf.mp3', 'covers/1847250713_0_29_985_583_1920x0_80_0_0_04a77c404da7c88b0b297dc9db88da02.jpg', 214, 'So cool...', '2025-03-05 05:04:26', '2025-03-05 05:04:26'),
(9, 'G-class', 'Buster', 'audios/t0eYmDl6rqBJklPt8ocJp0CUMatnR0NxcWdLzKxf.mp3', 'covers/QFmU15l0V8PILW22YDIPNnLna5aWIGhEWXorEBHk.jpg', 120, 'dsdds', '2025-03-05 05:56:44', '2025-03-05 05:56:44'),
(10, 'Трезво', 'Aarne, Дора', 'audios/RjAvl9rk03hIaTuPEyQVys2gReCeFc7mi6OtmQlm.mp3', 'covers/jmKbo6P9iO8ybl2Xv79xTQiwB6wytrmobM3MlBr1.png', 146, 'в', '2025-03-05 09:10:33', '2025-03-05 09:10:33'),
(11, 'Million', 'Big Baby Tape, Kizaru', 'audios/isaxwMEkTTwCVHR9GV6U8okUHBxuBwzlKIOJRihq.mp3', 'covers/oG5YRHXMXqPCAu2jGQkbtqC14V0CDFBqKXoNepvo.jpg', 135, 'kiz', '2025-03-05 09:14:45', '2025-03-05 09:14:45'),
(12, 'Люби Меня Долго (Remix)', 'Ирина Дубцова feat. EXNLXDE', 'audios/s1VrEIZ7PBo5SiFcF6WDOHxo4F9uWni1qauI27Vx.mp3', 'covers/aIcCu8dOjy2Ucj0M3XB5iBDjkYMeEtlKWkk9loqz.jpg', 122, NULL, '2025-03-05 09:44:26', '2025-03-05 09:44:26'),
(13, 'Supersonic', 'Big Baby Tape, Aarne', 'audios/HZ7w9gPk7csEl3bj1OJqutoUfi7wCXOi9XUiHSdj.mp3', 'covers/lJEYbFcM9gvHYm24PFCUWR9gjH8SqDO7N5GkScv1.jpg', 164, NULL, '2025-03-05 09:46:16', '2025-03-05 09:46:16'),
(14, 'Bandana', 'Big Baby Tape, Kizaru', 'audios/v2azZOSShRXbfP2pfJKkAkZisAbTucPRaQQL8Wlb.mp3', 'covers/DXzvV4KSPmhXyeBHHDohWjPVS5vhPL3iCjcSvC1Q.jpg', 151, NULL, '2025-03-05 12:06:29', '2025-03-05 12:06:29'),
(15, 'Зависима', 'Дора', 'audios/Ixq8uvFWMBvGiKcMR4vSUG005HgijawTSt1Yw4Cj.mp3', 'covers/fzJJLvEvR35bqB22GbNwLnrOuYpohYFaBAHmffbz.jpg', 153, NULL, '2025-03-05 12:07:54', '2025-03-05 12:07:54'),
(16, 'Грязный тип (Бомжи)', 'Платина', 'audios/3nu1Gm0kAHUFr033W6EoRZX5fIUOOiqcwJh8gSNJ.mp3', 'covers/wupDDzIfoN3UxG02LknU70T3tt33it0aGF08L08A.jpg', 137, NULL, '2025-03-05 12:13:25', '2025-03-05 12:13:25'),
(17, 'Занесло', 'Rocket', 'audios/RiRhYu8EvMLmSrXg0FskZkkPU7rzE26sDo4yTnp5.mp3', 'covers/WEn5GGRvUYM5i6iViC92HATfgNaX4jXypWOAaFZl.jpg', 128, NULL, '2025-03-05 12:15:56', '2025-03-05 12:15:56'),
(18, 'dasdsa', 'dasdas', 'audios/fVFO80PaRdpxagNbDXQVtI0oOnuFmZ6Bv34uIGxI.mp3', 'covers/tzErUbW13e9MCFOHeABtAz0jckxbDAOVrIGt7v37.png', 180, 'dadas', '2025-03-11 07:44:37', '2025-03-11 07:44:37');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Технологии', '2025-02-21 14:01:49', '2025-02-21 14:01:49'),
(2, 'Спорт', '2025-02-21 14:01:49', '2025-02-21 14:01:49'),
(3, 'Здоровье', '2025-02-21 14:01:49', '2025-02-21 14:01:49'),
(4, 'Наука', '2025-02-21 14:01:49', '2025-02-21 14:01:49'),
(5, 'Искусство', '2025-02-21 14:01:49', '2025-02-21 14:01:49'),
(6, 'Музыка', '2025-02-21 14:01:49', '2025-02-21 14:01:49'),
(11, 'Политика', '2025-03-11 07:26:55', '2025-03-11 07:26:55');

-- --------------------------------------------------------

--
-- Структура таблицы `category_user`
--

CREATE TABLE `category_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `user1_id` bigint UNSIGNED NOT NULL,
  `user2_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chats`
--

INSERT INTO `chats` (`id`, `user1_id`, `user2_id`, `created_at`, `updated_at`) VALUES
(2, 2, 1, '2025-02-21 09:39:59', '2025-02-21 09:39:59'),
(3, 1, 6, '2025-02-26 07:39:29', '2025-02-26 07:39:29'),
(4, 1, 7, '2025-02-27 05:47:04', '2025-02-27 05:47:04');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`, `updated_at`) VALUES
(7, 2, 12, 'ttr', '2025-02-22 15:02:09', '2025-02-22 15:02:09'),
(10, 1, 20, 'ok', '2025-02-26 13:34:34', '2025-02-26 13:34:34'),
(11, 1, 20, 'как поставить лайк', '2025-02-26 13:34:45', '2025-02-26 13:34:45'),
(13, 1, 20, 'ладно', '2025-03-04 08:24:07', '2025-03-04 08:24:07'),
(15, 2, 26, 'да я тут был', '2025-03-04 13:04:42', '2025-03-04 13:04:42'),
(17, 2, 26, 'але', '2025-03-04 13:24:19', '2025-03-04 13:24:19'),
(18, 2, 20, 'хаххвахвыахавххавыхвахыхавыхваыхавыххвыа', '2025-03-04 14:24:45', '2025-03-04 14:24:45'),
(19, 2, 12, 'f', '2025-03-04 14:43:20', '2025-03-04 14:43:20'),
(20, 2, 26, 're', '2025-03-04 14:45:43', '2025-03-04 14:45:43'),
(21, 2, 26, 'вфвфы', '2025-03-04 15:00:14', '2025-03-04 15:00:14'),
(22, 2, 26, 'ку', '2025-03-04 15:03:08', '2025-03-04 15:03:08'),
(23, 1, 27, 'ку', '2025-03-06 07:54:29', '2025-03-06 07:54:29'),
(24, 1, 12, 'ку', '2025-03-06 08:35:06', '2025-03-06 08:35:06');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `friend_id` bigint UNSIGNED NOT NULL,
  `status` enum('В ожидании','Принято') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'В ожидании',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `status`, `created_at`, `updated_at`) VALUES
(10, 1, 5, 'В ожидании', '2025-02-24 10:11:35', '2025-02-24 10:11:35'),
(12, 2, 1, 'Принято', '2025-02-24 10:41:36', '2025-02-24 10:41:52'),
(14, 2, 5, 'В ожидании', '2025-02-26 05:33:27', '2025-02-26 05:33:27'),
(16, 1, 6, 'Принято', '2025-02-26 06:59:01', '2025-02-26 06:59:19'),
(17, 7, 1, 'Принято', '2025-02-27 05:46:34', '2025-02-27 05:46:53'),
(18, 7, 2, 'Принято', '2025-03-04 08:57:48', '2025-03-04 08:58:11');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(4, 2, 20, '2025-02-26 14:13:56', '2025-02-26 14:13:56'),
(5, 2, 19, '2025-02-26 14:13:59', '2025-02-26 14:13:59'),
(138, 6, 17, '2025-02-26 14:59:41', '2025-02-26 14:59:41'),
(161, 6, 4, '2025-02-26 15:10:31', '2025-02-26 15:10:31'),
(182, 1, 17, '2025-02-27 04:59:16', '2025-02-27 04:59:16'),
(224, 6, 12, '2025-03-01 04:18:03', '2025-03-01 04:18:03'),
(233, 1, 19, '2025-03-01 10:12:20', '2025-03-01 10:12:20'),
(240, 2, 4, '2025-03-01 14:43:17', '2025-03-01 14:43:17'),
(243, 6, 20, '2025-03-02 13:00:28', '2025-03-02 13:00:28'),
(244, 6, 19, '2025-03-02 13:00:33', '2025-03-02 13:00:33'),
(252, 1, 20, '2025-03-04 08:30:38', '2025-03-04 08:30:38'),
(258, 2, 23, '2025-03-04 12:56:44', '2025-03-04 12:56:44'),
(262, 2, 27, '2025-03-04 13:10:21', '2025-03-04 13:10:21'),
(264, 2, 25, '2025-03-04 13:24:38', '2025-03-04 13:24:38'),
(265, 2, 24, '2025-03-04 13:24:39', '2025-03-04 13:24:39'),
(269, 2, 26, '2025-03-04 13:53:43', '2025-03-04 13:53:43'),
(270, 2, 22, '2025-03-04 13:58:12', '2025-03-04 13:58:12'),
(272, 2, 21, '2025-03-04 14:26:18', '2025-03-04 14:26:18'),
(277, 1, 27, '2025-03-04 15:08:23', '2025-03-04 15:08:23'),
(281, 2, 12, '2025-03-05 06:09:37', '2025-03-05 06:09:37'),
(282, 2, 28, '2025-03-05 06:10:05', '2025-03-05 06:10:05'),
(285, 1, 4, '2025-03-06 07:53:56', '2025-03-06 07:53:56'),
(288, 1, 28, '2025-03-06 07:54:24', '2025-03-06 07:54:24'),
(291, 1, 12, '2025-03-06 08:35:18', '2025-03-06 08:35:18'),
(292, 1, 29, '2025-03-13 05:52:35', '2025-03-13 05:52:35');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `chat_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `user_id`, `content`, `read_at`, `created_at`, `updated_at`) VALUES
(264, 2, 2, 'ку', '2025-03-04 12:43:35', '2025-03-04 11:43:38', '2025-03-04 12:43:35'),
(265, 2, 2, 'ку', '2025-03-04 12:43:35', '2025-03-04 11:44:04', '2025-03-04 12:43:35'),
(266, 2, 2, 'dsadsadsadsadasdasdsaads', '2025-03-04 12:43:35', '2025-03-04 12:33:55', '2025-03-04 12:43:35'),
(267, 2, 1, 'ыфвыффы', '2025-03-04 13:40:10', '2025-03-04 12:45:57', '2025-03-04 13:40:10'),
(268, 2, 1, 'ку', '2025-03-04 13:40:10', '2025-03-04 12:46:56', '2025-03-04 13:40:10'),
(269, 2, 1, 'ку', '2025-03-04 13:40:10', '2025-03-04 12:47:00', '2025-03-04 13:40:10'),
(271, 2, 2, 'привет родной', '2025-03-04 15:08:00', '2025-03-04 13:40:16', '2025-03-04 15:08:00'),
(272, 2, 2, 'чем дышишь вообще', '2025-03-04 15:08:00', '2025-03-04 13:40:22', '2025-03-04 15:08:00'),
(273, 2, 2, 'родной', '2025-03-06 06:33:39', '2025-03-04 15:18:31', '2025-03-06 06:33:39'),
(274, 2, 1, 're', NULL, '2025-03-06 06:33:43', '2025-03-06 06:33:43'),
(275, 2, 1, 'кку', NULL, '2025-03-06 07:52:53', '2025-03-06 07:52:53'),
(276, 2, 1, 'ку', NULL, '2025-03-06 07:52:57', '2025-03-06 07:52:57'),
(277, 3, 1, 're', '2025-03-11 07:39:30', '2025-03-11 07:36:50', '2025-03-11 07:39:30'),
(278, 3, 1, 'ку', '2025-03-11 07:39:30', '2025-03-11 07:36:53', '2025-03-11 07:39:30'),
(279, 3, 6, 'дку', '2025-03-11 07:37:45', '2025-03-11 07:36:59', '2025-03-11 07:37:45'),
(280, 3, 6, 'вв', '2025-03-11 07:37:45', '2025-03-11 07:37:02', '2025-03-11 07:37:45'),
(281, 3, 6, 'ку', '2025-03-11 07:37:45', '2025-03-11 07:37:07', '2025-03-11 07:37:45'),
(282, 3, 6, 'да', '2025-03-11 07:39:28', '2025-03-11 07:37:53', '2025-03-11 07:39:28'),
(283, 3, 6, 'тольковыфв', '2025-03-11 07:39:28', '2025-03-11 07:38:05', '2025-03-11 07:39:28'),
(284, 3, 6, 'ывфффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффффф', '2025-03-11 07:39:28', '2025-03-11 07:38:09', '2025-03-11 07:39:28'),
(285, 3, 1, 'ку', '2025-03-11 07:53:46', '2025-03-11 07:48:25', '2025-03-11 07:53:46'),
(286, 3, 1, 'ку', '2025-03-11 07:56:06', '2025-03-11 07:54:00', '2025-03-11 07:56:06'),
(287, 3, 6, 'ку', '2025-03-13 05:31:25', '2025-03-13 05:30:54', '2025-03-13 05:31:25'),
(288, 3, 1, 'ок', '2025-03-13 05:31:13', '2025-03-13 05:31:09', '2025-03-13 05:31:13'),
(289, 3, 1, 'ку', NULL, '2025-03-13 05:33:34', '2025-03-13 05:33:34'),
(290, 3, 1, 'ку', NULL, '2025-03-13 05:33:36', '2025-03-13 05:33:36');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_21_091404_create_user_infos_table', 1),
(6, '2025_02_21_091412_create_categories_table', 1),
(7, '2025_02_21_091421_create_category_user_table', 1),
(8, '2025_02_21_091430_create_posts_table', 1),
(9, '2025_02_21_091439_create_friends_table', 1),
(10, '2025_02_21_091448_create_chats_table', 1),
(11, '2025_02_21_091457_create_messages_table', 1),
(12, '2025_02_21_093409_create_comments_table', 2),
(13, '2025_02_21_182414_create_news_table', 3),
(14, '2025_02_21_185314_add_media_path_to_news_table', 4),
(15, '2025_02_21_195354_add_last_activity_and_is_online_to_users_table', 5),
(16, '2025_02_26_164859_create_likes_table', 6),
(17, '2025_03_05_074758_create_audios_table', 7),
(18, '2025_03_05_083203_add_cover_path_to_audios_table', 8),
(19, '2025_03_05_084948_add_cover_path_to_audios_table', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `user_id`, `title`, `content`, `media_path`, `created_at`, `updated_at`) VALUES
(1, 1, 'хуета', 'хз', NULL, '2025-02-21 15:35:10', '2025-02-21 15:35:10'),
(2, 1, 'Заголовок', 'содержимоее', NULL, '2025-02-21 15:38:51', '2025-02-21 15:38:51'),
(3, 1, 'чо там', 'ывффвывыы', NULL, '2025-02-21 15:56:44', '2025-02-21 15:56:44'),
(4, 1, 'мда', 'топ', NULL, '2025-02-21 15:57:38', '2025-02-21 15:57:38'),
(5, 1, 'йцуцййцу', 'уцйцвй', NULL, '2025-02-21 15:58:16', '2025-02-21 15:58:16'),
(6, 1, 'adsdsa', 'asddsa', NULL, '2025-02-21 16:00:23', '2025-02-21 16:00:23'),
(7, 1, 'dassad', 'dsaads', 'media/YTNPirBBmPPs481dQ1NrNFBotpCYoQvQFofBCay5.jpg', '2025-02-21 16:05:09', '2025-02-21 16:05:09'),
(8, 1, 'dsdsa', 'asddsa', 'media/JZOI16ayb2bUahEnzfK8exFZR8o8fqWZkm4gQX8F.png', '2025-02-22 04:50:57', '2025-02-22 04:50:57'),
(9, 1, 'да', 'ничего', NULL, '2025-03-02 14:29:29', '2025-03-02 14:29:29'),
(10, 1, 'ничо', 'ничо', NULL, '2025-03-02 14:29:48', '2025-03-02 14:29:48'),
(11, 1, 'ыыфв', 'выфвыф', 'media/lJgQXhz2doF96r8UgtpqU4ym0YkNU87GA912Ui9V.png', '2025-03-02 14:30:35', '2025-03-02 14:30:35'),
(12, 1, 'вв', 'вв', NULL, '2025-03-02 14:32:24', '2025-03-02 14:32:24'),
(13, 1, 'выфвфы', 'выфвыф', 'media/cFIoIDoxvqZbPREwLiuQLSnwHBwnSFv0Z1zMEcgq.png', '2025-03-02 14:34:00', '2025-03-02 14:34:00'),
(14, 1, 'вфывыф', 'выфы', 'media/Rv0BYFcrm4kCMImnwcrPTitVrymqV4WOH3fAJQpJ.png', '2025-03-02 14:34:55', '2025-03-02 14:34:55'),
(15, 1, 'вы', 'вы', 'media/4rSVorGxOEA21a0Lmd2xVFQFjDWRdIMnu5nqcZpT.mp4', '2025-03-02 14:37:00', '2025-03-02 14:37:00'),
(16, 1, 'да я красава', 'выфвывыф', 'media/RMszlYhBVDc60Y7bdhuiCGwHonccs05iN4PSyzlq.png', '2025-03-02 14:58:40', '2025-03-02 14:58:40'),
(17, 1, 'вывы', 'выыв', 'media/uXwOhwbtn5mJNeJtckyNC7omiyvGj4Plb0JGuxbX.mp4', '2025-03-02 15:55:10', '2025-03-02 15:55:10'),
(18, 2, 'xz', 'ddsadsaas', 'media/aRUdv2cJZtryQoYj27w6M3gTQNxYqggznPjZ5PFl.jpg', '2025-03-04 11:35:24', '2025-03-04 11:35:24'),
(21, 1, 'dasdas', 'adsds', 'media/zLjxmF4WdIXfr0Io1rQ5owGQWwN3uyr3uYWB0kn6.png', '2025-03-13 05:53:39', '2025-03-13 05:53:39'),
(23, 1, 'dasasd', 'asasddas', 'media/d8xLS4LgUHlyBXsMjAaZNLsOXSHNLE7lE9rdsS8G.png', '2025-03-13 06:25:11', '2025-03-13 06:25:11');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `content`, `image`, `video`, `created_at`, `updated_at`) VALUES
(4, 1, 6, 'Люблю музыку!', 'uploads/posts/1740160668.jpeg', NULL, '2025-02-21 14:57:48', '2025-02-21 14:57:48'),
(12, 1, 5, 'https://www.youtube.com/watch?v=MR8HZJ57_jw', 'uploads/posts/1740217389.png', NULL, '2025-02-22 06:43:09', '2025-02-24 11:24:57'),
(17, 6, 1, 'видос', 'uploads/posts/1740559365.png', NULL, '2025-02-26 05:42:45', '2025-02-26 05:42:45'),
(19, 6, 1, 'видос', NULL, 'uploads/posts/videos/1740559789.mp4', '2025-02-26 05:49:49', '2025-02-26 05:49:49'),
(20, 6, 1, 'вв', NULL, 'uploads/posts/videos/1740560143.mp4', '2025-02-26 05:55:43', '2025-02-26 05:55:43'),
(21, 2, 2, 'видос', NULL, 'uploads/posts/videos/1741096946.mp4', '2025-03-04 11:02:26', '2025-03-04 11:02:26'),
(22, 2, 2, 'выфвыфвыф', 'uploads/posts/1741097207.png', NULL, '2025-03-04 11:06:47', '2025-03-04 11:06:47'),
(23, 2, 5, 'спб лучшйи город', 'uploads/posts/1741097262.jpg', NULL, '2025-03-04 11:07:42', '2025-03-04 11:07:42'),
(24, 2, 4, 'спб', NULL, NULL, '2025-03-04 11:12:59', '2025-03-04 11:12:59'),
(25, 2, 4, 'вывы', NULL, NULL, '2025-03-04 11:13:28', '2025-03-04 11:13:28'),
(26, 2, 4, 'выфввыф', 'uploads/posts/1741097642.jpg', NULL, '2025-03-04 11:14:02', '2025-03-04 11:14:02'),
(27, 2, 2, 'вывыф', 'uploads/posts/1741097735.jpg', NULL, '2025-03-04 11:15:35', '2025-03-04 11:15:35'),
(28, 2, 4, 'наука', 'uploads/posts/1741098554.jpg', NULL, '2025-03-04 11:29:14', '2025-03-04 11:29:14'),
(29, 1, 4, 'dasdasdas', 'uploads/posts/1741854966.jpg', NULL, '2025-03-13 05:36:06', '2025-03-13 05:36:06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `last_activity_at`, `is_online`, `is_banned`) VALUES
(1, 'utipov36', 'utipov36@gmail.com', NULL, '$2y$10$.BbDQm7u/WeEvKwFWgFvBeL135yIjwkdvCqmzTZtKLYFbp7CjpNli', 0, NULL, '2025-02-21 07:11:13', '2025-03-13 06:25:31', '2025-03-13 06:25:31', 1, 0),
(2, 'alex', 'alex@mail.ru', NULL, '$2y$10$76cngTzGdxb/kM3Yq2yAxesk63nVWDo3qIc2jHU1WoYpivWjdvFLu', 0, NULL, '2025-02-21 08:45:29', '2025-03-11 07:26:09', '2025-03-05 10:02:58', 1, 1),
(5, 'babakapa', 'babakapa1964@mail.ru', NULL, '$2y$10$GERz21irs0p/QikNRbO4bOcDoEiKf0ukTx8eTLkN.JayG8mvfrMMa', 0, NULL, '2025-02-22 11:51:14', '2025-03-01 04:32:22', '2025-03-01 04:32:22', 1, 0),
(6, 'sanek', 'kirik34564@mail.ru', NULL, '$2y$10$hXI3kT0DrYogDov8K52h0e2o740ShIevCFUqLsjvAFRBAZGfLnsbu', 0, NULL, '2025-02-26 05:22:47', '2025-03-13 05:51:51', '2025-03-13 05:51:51', 1, 0),
(7, 'car', 'masha123@mail.ru', NULL, '$2y$10$q3hvMRrRKN78zE84TlyN2eJgmBW5uB2GFHqCeOfD2XKXDeidZJbpq', 0, NULL, '2025-02-27 05:46:19', '2025-03-04 08:57:57', '2025-03-04 08:57:57', 1, 0),
(9, 'admin', 'admin@gmail.com', NULL, '$2y$10$IKJAqxR45cg6TWnzqCNFKuCzRD7CxoPNkeqjuz8QvVbhhg8x3rcp6', 1, NULL, '2025-03-06 07:59:49', '2025-03-13 05:28:28', '2025-03-13 05:28:28', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_infos`
--

CREATE TABLE `user_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_infos`
--

INSERT INTO `user_infos` (`id`, `user_id`, `first_name`, `last_name`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Кирюха', 'Афанасьев', 'avatars/qEq2fHLb7OcU5W47JMYDos89SRVADEdxoMDkAeG4.gif', '2025-02-21 07:11:13', '2025-02-24 11:20:44'),
(2, 2, 'Шурик', 'Негп', 'avatars/QHwPVm1DgGgAlpkApyR3stjyC6iNRENbOw8wh7aL.gif', '2025-02-21 08:45:29', '2025-03-04 12:52:03'),
(5, 5, 'Катька', 'Негодова', 'avatars/MrfjJbkq23pLSV8YyLp7XSBzOrj3lwP8WvDqOwcT.png', '2025-02-22 11:51:14', '2025-02-22 12:03:45'),
(6, 6, 'Сергей', 'Утипов', 'avatars/wSpcPNIwzXwluz7Bw7EJvHx2S0041pM29X5rVtm5.png', '2025-02-26 05:22:47', '2025-02-26 05:23:00'),
(7, 7, 'Сергей', 'Утипов', 'avatars/tKZsX4gH2YQvjs2xlOXwlFFIBsKuSm7huRSorIl4.png', '2025-02-27 05:46:20', '2025-02-27 05:46:20'),
(9, 9, 'Админ', 'Админ', NULL, '2025-03-06 07:59:49', '2025-03-06 07:59:49');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `audios`
--
ALTER TABLE `audios`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category_user`
--
ALTER TABLE `category_user`
  ADD PRIMARY KEY (`user_id`,`category_id`),
  ADD KEY `category_user_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_user1_id_foreign` (`user1_id`),
  ADD KEY `chats_user2_id_foreign` (`user2_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friends_user_id_foreign` (`user_id`),
  ADD KEY `friends_friend_id_foreign` (`friend_id`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `likes_user_id_post_id_unique` (`user_id`,`post_id`),
  ADD KEY `likes_post_id_foreign` (`post_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_chat_id_foreign` (`chat_id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_infos`
--
ALTER TABLE `user_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_infos_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `audios`
--
ALTER TABLE `audios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `user_infos`
--
ALTER TABLE `user_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category_user`
--
ALTER TABLE `category_user`
  ADD CONSTRAINT `category_user_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `category_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_user1_id_foreign` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_user2_id_foreign` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friends_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_infos`
--
ALTER TABLE `user_infos`
  ADD CONSTRAINT `user_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
