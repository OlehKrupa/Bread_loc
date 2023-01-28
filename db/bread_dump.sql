-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 25 2023 г., 20:43
-- Версия сервера: 8.0.31-0ubuntu0.20.04.1
-- Версия PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bread`
--

--
-- Дамп данных таблицы `Crop`
--

INSERT INTO `Crop` (`id`, `Warehouse_id`, `name`, `variety`, `amount`, `grade`, `moisture`, `temperature`) VALUES
(1, 2, 'Насіння соняшника', 'Джинн М', '8000', 'Добре', 5, 20),
(2, 2, 'Насіння соняшника', 'Лускунчик', '4000', 'Задовільно', 6, 20),
(3, 1, 'Пшениця', 'Краса Ланів', '10000', 'Добре', 5, 20);

--
-- Дамп данных таблицы `Standard`
--

INSERT INTO `Standard` (`id`, `Crop_id`, `min_moisture`, `max_moisture`, `minor_risk`, `middle_rist`, `major_risk`) VALUES
(1, 1, 2, 10, 3, 6, 12),
(2, 2, 2, 12, 3, 6, 10),
(3, 3, 2, 8, 6, 9, 12);

--
-- Дамп данных таблицы `Supplier`
--

INSERT INTO `Supplier` (`id`, `name`, `number`) VALUES
(1, 'Сушарка 1', '3809898989898'),
(2, 'Сушарка 2', '3809898989899'),
(3, 'УкрЗерноХолдинг', '3809898989000'),
(4, 'Королівський Смак', '3809812989000');

--
-- Дамп данных таблицы `Warehouse`
--

INSERT INTO `Warehouse` (`id`, `name`, `address`, `capacity`) VALUES
(1, 'Склад \"Сонечко\"', 'Власівка, Молодіжна66, 27552', '10000'),
(2, 'Елеватор \"Королівство\"', 'Світловодськ, Героїв України 100, 27500', '12000'),
(3, 'Науково-дослідне зберігання \"Остроградіус\"', 'Кременчук, Університетська 77, 39600', '400');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
