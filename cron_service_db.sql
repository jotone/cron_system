-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 29 2017 г., 12:04
-- Версия сервера: 10.1.16-MariaDB
-- Версия PHP: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cron_service_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_table`
--

CREATE TABLE `admin_table` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refer_to` int(11) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `admin_table`
--

INSERT INTO `admin_table` (`id`, `title`, `slug`, `refer_to`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Главная', '/admin', 0, 0, '2017-05-23 21:00:00', '2017-05-23 21:00:00'),
(2, 'Пользователи', '/admin/users', 0, 120, '2017-05-23 21:00:00', '2017-05-23 21:00:00'),
(3, 'Роли пользователей', '/admin/users/roles', 2, 0, '2017-05-23 21:00:00', '2017-05-23 21:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `refer_to` int(10) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `etc_data`
--

CREATE TABLE `etc_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `footer_menu`
--

CREATE TABLE `footer_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `is_outer` tinyint(1) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `inner_galery`
--

CREATE TABLE `inner_galery` (
  `id` int(10) UNSIGNED NOT NULL,
  `img_url` text COLLATE utf8_unicode_ci NOT NULL,
  `alt` text COLLATE utf8_unicode_ci NOT NULL,
  `refer_to` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2017_05_23_075415_create_user_roles', 1),
('2017_05_23_075830_create_news', 1),
('2017_05_23_080649_create_vacancy', 1),
('2017_05_23_080958_create_product', 1),
('2017_05_23_081456_create_top_menu', 1),
('2017_05_23_081650_create_footer_menu', 1),
('2017_05_23_081804_create_social_menu', 1),
('2017_05_23_082251_create_user_vacancy', 1),
('2017_05_23_082451_create_etc_data', 1),
('2017_05_23_083049_create_inner_galery', 1),
('2017_05_23_095801_create_brands', 1),
('2017_05_24_155531_create-admin_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `img_url` text COLLATE utf8_unicode_ci NOT NULL,
  `also_reads` tinyint(1) UNSIGNED NOT NULL,
  `views` int(10) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `img_url` text COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `refer_to_category` int(10) UNSIGNED NOT NULL,
  `refer_to_brand` int(10) UNSIGNED NOT NULL,
  `refer_to_promo` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `is_hot` tinyint(1) UNSIGNED NOT NULL,
  `views` int(10) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `social_menu`
--

CREATE TABLE `social_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_url` text COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `top_menu`
--

CREATE TABLE `top_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img` text COLLATE utf8_unicode_ci NOT NULL,
  `addr` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `org_tid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `correspondence` text COLLATE utf8_unicode_ci NOT NULL,
  `history` text COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) UNSIGNED NOT NULL,
  `activation_code` text COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `img`, `addr`, `phone`, `org_caption`, `org_tid`, `address`, `correspondence`, `history`, `role`, `activated`, `activation_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Кирилл Нижников', 'hereyouare@mail.ru', 'beb2b390baf90baa7f9150a72ced9e07', '', '', '068-202-19-88', 'my org', '', '', '', '', 'ADM_ROLE', 1, 'eyJpdiI6Im1nREVRZDBcL1JSKzhDb1Q2MHFSclh3PT0iLCJ2YWx1ZSI6InhmRGVra1lMY21yeXFER3BTakx0anErMlFHVnJsbHZyOHBlWFJzUmJoXC91OXpDczJ1RkllbXRuY3NXXC9jK3JWWlVjZHpMZGg3cytsSTZqNUgwYjdpazJFemdVNzdBY0RDNjlxM0ZqUllZdTg9IiwibWFjIjoiMTA5MzNkOTBhNTQ1MjdjNGRjYjIxYzY1NjM0ODI2OWRlMzI4NzU3ZjVhNmMwMTllN2RkMTYyYjcwZmRjY2Q1YSJ9', 'uVeoe9DEGlw3gybYMUeW3D7gYpOzmfZXpTHzmOpbXDQspwIP23EQ9cS7ZdUq', '2017-05-24 06:13:56', '2017-05-29 06:48:43'),
(2, '', 'deadm0p0@mail.tu', 'c0d4a5b96313affc0a229afa22fb872e', '', '', '', '', '', '', '', '', '', 1, 'eyJpdiI6IndVK1V4N0VCZUZMWXJ4a1IzalREenc9PSIsInZhbHVlIjoidVlzVFNlTmFlSkt6dDNzR3lkYkk5bDRwMVRibHk3VXlxVStUWDRFYmlQTEhkcVhRSGU5TG56N05BdEt3Z1hWbzU2TmpZYVFGXC9HOEZJNHdCT05CVEE4eENjTnBNM0o2Q1pCNVQ3WE0yOHhZPSIsIm1hYyI6ImY0MmY5YTc3MTI4ZWI5NjYxZjIwYjcyOTcwZTY2MDYwOGRkYjgxNmFkOGEyNjc4YjNlNjA2NDg5NjJmYTY4Y2MifQ==', NULL, '2017-05-25 10:37:36', '2017-05-25 10:37:36');

-- --------------------------------------------------------

--
-- Структура таблицы `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pseudonim` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `access_pages` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_roles`
--

INSERT INTO `user_roles` (`id`, `title`, `pseudonim`, `editable`, `access_pages`, `created_at`, `updated_at`) VALUES
(1, 'Главный администратор', 'ADM_ROLE', 0, 'allow_all', '2017-05-23 21:00:00', '2017-05-23 21:00:00'),
(2, 'Администратор', 'ADM', 1, '["3"]', '2017-05-25 09:40:19', '2017-05-25 09:45:49');

-- --------------------------------------------------------

--
-- Структура таблицы `user_vacancy`
--

CREATE TABLE `user_vacancy` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refer_to_vacancy` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancies`
--

CREATE TABLE `vacancies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `img_url` text COLLATE utf8_unicode_ci NOT NULL,
  `views` int(10) UNSIGNED NOT NULL,
  `enabled` tinyint(1) UNSIGNED NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `etc_data`
--
ALTER TABLE `etc_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `inner_galery`
--
ALTER TABLE `inner_galery`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `social_menu`
--
ALTER TABLE `social_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `top_menu`
--
ALTER TABLE `top_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_vacancy`
--
ALTER TABLE `user_vacancy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `etc_data`
--
ALTER TABLE `etc_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `footer_menu`
--
ALTER TABLE `footer_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `inner_galery`
--
ALTER TABLE `inner_galery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `social_menu`
--
ALTER TABLE `social_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `top_menu`
--
ALTER TABLE `top_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `user_vacancy`
--
ALTER TABLE `user_vacancy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
