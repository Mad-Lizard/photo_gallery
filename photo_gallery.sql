-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 11 2016 г., 13:07
-- Версия сервера: 5.6.31
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `photo_gallery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `photograph_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `author` varchar(255) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `photograph_id`, `created`, `author`, `body`) VALUES
(7, 41, '2016-09-08 22:17:06', 'Аня', 'Клёво!'),
(9, 2, '2016-09-13 17:14:47', 'Аня', 'Как это делается??!!'),
(10, 41, '2016-09-14 11:41:41', 'I', 'It''s me!'),
(11, 41, '2016-09-14 11:58:50', 'Аноним', 'Oho'),
(12, 41, '2016-09-14 12:19:37', 'Аноним', 'Ohoho'),
(13, 44, '2016-09-14 12:44:37', 'Игорь', 'Это история!'),
(14, 44, '2016-09-14 12:46:08', 'Аноним', 'Who is this men?'),
(15, 48, '2016-09-14 12:47:11', 'Аноним', 'Cool!'),
(16, 48, '2016-09-14 13:01:18', 'Mary', 'Very nice place!');

-- --------------------------------------------------------

--
-- Структура таблицы `photographs`
--

CREATE TABLE IF NOT EXISTS `photographs` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photographs`
--

INSERT INTO `photographs` (`id`, `filename`, `type`, `size`, `caption`) VALUES
(1, 'maxresdefault.jpg', '', 13025863, ''),
(2, 'Onearmlever.jpg', '', 511, ''),
(41, 'female_pullup.jpg', 'image/jpeg', 26078, 'Cool'),
(44, 'OneArm&Wts.JPG', 'image/jpeg', 49775, ''),
(46, 'Patxi usobiaga entrenando bloqueos en campus.jpg', 'image/jpeg', 83787, ''),
(47, 'Ramon julian traccion 1 brazo.jpg', 'image/jpeg', 63587, ''),
(48, 'Reme Arenas - Proximo Bambino, 7b - Cuenca - Foto por Luis Alfonso Felix - Fuente_facebook.jpg', 'image/jpeg', 239734, ''),
(49, '20151025_fredriksson_font_8616-768x511.jpg', 'image/jpeg', 215657, ''),
(50, 'Capture-768x337.jpg', 'image/jpeg', 115510, ''),
(51, '282490-768x511.jpg', 'image/jpeg', 74498, ''),
(52, '9oTqsvnioPY.jpg', 'image/jpeg', 47021, ''),
(53, '20151026_fredriksson_font_1028-768x511.jpg', 'image/jpeg', 224928, '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`) VALUES
(1, 'annamavka', '1', 'Anna', 'Mavka'),
(2, 'Haizenberg', '5', 'Wolter', 'White'),
(5, 'username', 'password', 'first_name', 'last_name'),
(6, 'username', 'password', 'first_name', 'last_name'),
(7, 'username', 'password', 'first_name', 'last_name'),
(8, 'username', 'password', 'first_name', 'last_name'),
(9, 'username', 'password', 'first_name', 'last_name'),
(10, 'username', 'password', 'first_name', 'last_name'),
(11, 'Ghost252', '8', 'X', 'Y'),
(12, 'Ghost252', '8', 'X', 'Y'),
(13, 'test', '0', 'test', ''),
(14, 'test', '0', 'test', 'test'),
(15, 'test', '0', 'test', 'test'),
(16, 'test', '0', 'test', 'test'),
(17, 'test', '0', 'test', 'test'),
(18, 'test', '0', 'test', 'test');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photograph_id` (`photograph_id`);

--
-- Индексы таблицы `photographs`
--
ALTER TABLE `photographs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `photographs`
--
ALTER TABLE `photographs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
