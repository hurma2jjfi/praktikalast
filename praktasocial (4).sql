-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 24 2025 г., 18:52
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

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
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(6, 'Музыка', '2025-02-21 14:01:49', '2025-02-21 14:01:49');

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
(2, 2, 1, '2025-02-21 09:39:59', '2025-02-21 09:39:59');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`, `updated_at`) VALUES
(7, 2, 12, 'ttr', '2025-02-22 15:02:09', '2025-02-22 15:02:09'),
(8, 2, 12, 'ты где', '2025-02-22 15:06:18', '2025-02-22 15:06:18'),
(9, 2, 12, 'ало', '2025-02-24 10:35:24', '2025-02-24 10:35:24');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `status` enum('В ожидании','Принято') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'В ожидании',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `status`, `created_at`, `updated_at`) VALUES
(10, 1, 5, 'В ожидании', '2025-02-24 10:11:35', '2025-02-24 10:11:35'),
(12, 2, 1, 'Принято', '2025-02-24 10:41:36', '2025-02-24 10:41:52');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `chat_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `user_id`, `content`, `read_at`, `created_at`, `updated_at`) VALUES
(6, 2, 2, 'привет родной', '2025-02-21 16:31:53', '2025-02-21 09:39:59', '2025-02-21 16:31:53'),
(8, 2, 2, 'как ты', '2025-02-21 16:31:53', '2025-02-21 09:42:50', '2025-02-21 16:31:53'),
(11, 2, 2, '1', '2025-02-21 16:31:53', '2025-02-21 10:07:02', '2025-02-21 16:31:53'),
(12, 2, 2, 're', '2025-02-21 16:31:53', '2025-02-21 10:17:55', '2025-02-21 16:31:53'),
(18, 2, 2, 'ку', '2025-02-22 12:05:41', '2025-02-22 07:46:38', '2025-02-22 12:05:41'),
(19, 2, 2, 'негро', '2025-02-22 12:05:41', '2025-02-22 08:48:36', '2025-02-22 12:05:41'),
(20, 2, 2, 'чотам', '2025-02-22 12:05:41', '2025-02-22 08:48:42', '2025-02-22 12:05:41'),
(21, 2, 2, '.', '2025-02-22 12:05:41', '2025-02-22 08:48:50', '2025-02-22 12:05:41'),
(22, 2, 2, 'а', '2025-02-22 12:05:41', '2025-02-22 08:49:01', '2025-02-22 12:05:41'),
(23, 2, 2, 'привет родной', '2025-02-22 12:05:41', '2025-02-22 08:49:13', '2025-02-22 12:05:41'),
(24, 2, 2, 'сосо плиз', '2025-02-22 12:05:41', '2025-02-22 08:49:24', '2025-02-22 12:05:41'),
(26, 2, 1, 're', '2025-02-22 14:36:11', '2025-02-22 12:35:43', '2025-02-22 14:36:11'),
(27, 2, 1, 'ку', '2025-02-22 14:36:11', '2025-02-22 12:41:44', '2025-02-22 14:36:11'),
(28, 2, 1, 'ку', '2025-02-22 14:36:11', '2025-02-22 12:41:54', '2025-02-22 14:36:11'),
(29, 2, 1, 'ку', '2025-02-22 14:36:11', '2025-02-22 12:44:17', '2025-02-22 14:36:11'),
(30, 2, 1, 'ув', '2025-02-22 14:36:11', '2025-02-22 12:45:16', '2025-02-22 14:36:11'),
(31, 2, 1, 're', '2025-02-22 14:36:11', '2025-02-22 12:48:42', '2025-02-22 14:36:11'),
(32, 2, 1, 're', '2025-02-22 14:36:11', '2025-02-22 12:48:43', '2025-02-22 14:36:11'),
(33, 2, 1, 're', '2025-02-22 14:36:11', '2025-02-22 13:42:10', '2025-02-22 14:36:11'),
(34, 2, 1, 're', '2025-02-22 14:36:11', '2025-02-22 13:42:43', '2025-02-22 14:36:11'),
(35, 2, 1, 'r', '2025-02-22 14:36:11', '2025-02-22 13:44:19', '2025-02-22 14:36:11'),
(36, 2, 1, 're', '2025-02-22 14:36:11', '2025-02-22 14:16:01', '2025-02-22 14:36:11'),
(38, 2, 1, 'фвывфыв', '2025-02-22 15:38:59', '2025-02-22 15:38:10', '2025-02-22 15:38:59'),
(39, 2, 2, 'sadasd', '2025-02-22 15:46:47', '2025-02-22 15:39:39', '2025-02-22 15:46:47'),
(40, 2, 2, 'dasdsa', '2025-02-22 15:46:47', '2025-02-22 15:39:43', '2025-02-22 15:46:47'),
(41, 2, 1, 'здарова негро', '2025-02-23 11:56:44', '2025-02-23 11:33:00', '2025-02-23 11:56:44'),
(42, 2, 1, 'здарова негро', '2025-02-23 11:56:44', '2025-02-23 11:33:03', '2025-02-23 11:56:44'),
(43, 2, 1, 'здарова негро', '2025-02-23 11:56:44', '2025-02-23 11:33:06', '2025-02-23 11:56:44'),
(44, 2, 1, 'здарова негро', '2025-02-23 11:56:44', '2025-02-23 11:33:15', '2025-02-23 11:56:44'),
(45, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:33:29', '2025-02-23 11:56:44'),
(46, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:36:09', '2025-02-23 11:56:44'),
(47, 2, 1, 'ек', '2025-02-23 11:56:44', '2025-02-23 11:36:39', '2025-02-23 11:56:44'),
(48, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:37:44', '2025-02-23 11:56:44'),
(49, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:37:51', '2025-02-23 11:56:44'),
(50, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:37:52', '2025-02-23 11:56:44'),
(51, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:37:52', '2025-02-23 11:56:44'),
(52, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:37:53', '2025-02-23 11:56:44'),
(53, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:37:53', '2025-02-23 11:56:44'),
(54, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:38:34', '2025-02-23 11:56:44'),
(55, 2, 1, 'rere', '2025-02-23 11:56:44', '2025-02-23 11:38:36', '2025-02-23 11:56:44'),
(56, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:41:25', '2025-02-23 11:56:44'),
(57, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:41:27', '2025-02-23 11:56:44'),
(58, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:41:58', '2025-02-23 11:56:44'),
(59, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:46:59', '2025-02-23 11:56:44'),
(60, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:47:01', '2025-02-23 11:56:44'),
(61, 2, 1, 're', '2025-02-23 11:56:44', '2025-02-23 11:47:07', '2025-02-23 11:56:44'),
(63, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:51:58', '2025-02-23 11:56:44'),
(64, 2, 1, 'ку', '2025-02-23 11:56:44', '2025-02-23 11:52:17', '2025-02-23 11:56:44'),
(68, 2, 1, 'где ты', '2025-02-23 11:56:44', '2025-02-23 11:55:52', '2025-02-23 11:56:44'),
(70, 2, 2, 'че', '2025-02-23 11:57:12', '2025-02-23 11:57:06', '2025-02-23 11:57:12'),
(72, 2, 1, 'сам', NULL, '2025-02-24 12:13:26', '2025-02-24 12:13:26');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(15, '2025_02_21_195354_add_last_activity_and_is_online_to_users_table', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(8, 1, 'dsdsa', 'asddsa', 'media/JZOI16ayb2bUahEnzfK8exFZR8o8fqWZkm4gQX8F.png', '2025-02-22 04:50:57', '2025-02-22 04:50:57');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
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
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `content`, `image`, `video`, `created_at`, `updated_at`) VALUES
(4, 1, 6, 'Люблю музыку!', 'uploads/posts/1740160668.jpeg', NULL, '2025-02-21 14:57:48', '2025-02-21 14:57:48'),
(12, 1, 5, 'https://www.youtube.com/watch?v=MR8HZJ57_jw', 'uploads/posts/1740217389.png', NULL, '2025-02-22 06:43:09', '2025-02-24 11:24:57');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `last_activity_at`, `is_online`) VALUES
(1, 'utipov36', 'utipov36@gmail.com', NULL, '$2y$10$.BbDQm7u/WeEvKwFWgFvBeL135yIjwkdvCqmzTZtKLYFbp7CjpNli', 0, NULL, '2025-02-21 07:11:13', '2025-02-24 12:14:44', '2025-02-24 12:14:44', 1),
(2, 'alex', 'alex@mail.ru', NULL, '$2y$10$76cngTzGdxb/kM3Yq2yAxesk63nVWDo3qIc2jHU1WoYpivWjdvFLu', 0, NULL, '2025-02-21 08:45:29', '2025-02-24 12:51:28', '2025-02-24 12:51:28', 1),
(5, 'babakapa', 'babakapa1964@mail.ru', NULL, '$2y$10$GERz21irs0p/QikNRbO4bOcDoEiKf0ukTx8eTLkN.JayG8mvfrMMa', 0, NULL, '2025-02-22 11:51:14', '2025-02-22 12:04:58', '2025-02-22 12:04:58', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_infos`
--

CREATE TABLE `user_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_infos`
--

INSERT INTO `user_infos` (`id`, `user_id`, `first_name`, `last_name`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Кирюха', 'Афанасьев', 'avatars/qEq2fHLb7OcU5W47JMYDos89SRVADEdxoMDkAeG4.gif', '2025-02-21 07:11:13', '2025-02-24 11:20:44'),
(2, 2, 'Александр', 'Нинаю', 'avatars/RTiQ5UCR76VnPwdjrwYnIAElghqhJl4VxM5Lzqg3.jpg', '2025-02-21 08:45:29', '2025-02-21 17:31:42'),
(5, 5, 'Катька', 'Негодова', 'avatars/MrfjJbkq23pLSV8YyLp7XSBzOrj3lwP8WvDqOwcT.png', '2025-02-22 11:51:14', '2025-02-22 12:03:45');

--
-- Индексы сохранённых таблиц
--

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
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user_infos`
--
ALTER TABLE `user_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
