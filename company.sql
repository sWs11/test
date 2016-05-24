-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Трв 25 2016 р., 00:21
-- Версія сервера: 10.1.10-MariaDB
-- Версія PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `company`
--

-- --------------------------------------------------------

--
-- Структура таблиці `table_company`
--

CREATE TABLE `table_company` (
  `id` int(11) NOT NULL,
  `name_company` varchar(100) NOT NULL,
  `Capital` int(11) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп даних таблиці `table_company`
--

INSERT INTO `table_company` (`id`, `name_company`, `Capital`, `parent`, `level`) VALUES
(1, 'Company 1', 1000, '', 0),
(2, 'Company 1.1', 1100, 'Company 1', 1),
(7, 'Company 3', 3000, '', 0),
(4, 'Company 2', 2000, '', 0),
(5, 'Company 2.1', 2100, 'Company 2', 1),
(6, 'Company 1.1.1', 1110, 'Company 1.1', 2);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `table_company`
--
ALTER TABLE `table_company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_company` (`name_company`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `table_company`
--
ALTER TABLE `table_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
