-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.4:3306
-- Время создания: Фев 24 2026 г., 11:57
-- Версия сервера: 8.4.6
-- Версия PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tulaGer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `family_members`
--

CREATE TABLE `family_members` (
  `id` int NOT NULL,
  `participant_id` int NOT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` enum('муж.','жен.') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `master-classes`
--

CREATE TABLE `master-classes` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `9-10` int NOT NULL DEFAULT '50' COMMENT 'Свободные места для записи',
  `10-11` int NOT NULL DEFAULT '50',
  `11-12` int NOT NULL DEFAULT '50',
  `12-13` int NOT NULL DEFAULT '50',
  `13-14` int NOT NULL DEFAULT '50',
  `14-15` int NOT NULL DEFAULT '50',
  `15-16` int NOT NULL DEFAULT '50',
  `16-17` int NOT NULL DEFAULT '50',
  `17-18` int NOT NULL DEFAULT '50',
  `18-19` int NOT NULL DEFAULT '50',
  `19-20` int NOT NULL DEFAULT '50',
  `20-21` int NOT NULL DEFAULT '50',
  `descr` text NOT NULL,
  `fullDescr` text NOT NULL,
  `header` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `img` varchar(300) NOT NULL,
  `rate` int NOT NULL,
  `allEntries` int NOT NULL,
  `accessedTime` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `master-classes`
--

INSERT INTO `master-classes` (`id`, `title`, `9-10`, `10-11`, `11-12`, `12-13`, `13-14`, `14-15`, `15-16`, `16-17`, `17-18`, `18-19`, `19-20`, `20-21`, `descr`, `fullDescr`, `header`, `date`, `img`, `rate`, `allEntries`, `accessedTime`) VALUES
(1, 'Прохоровская сласть', 48, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, '<p class=\"desc smal\">Интерактивная программа входит в цикл программ «Пляшем от печки» и знакомит с укладом и бытом ремесленников-кустарей, занятых на производстве знаменитой белевской пастилы; в интересной форме погружает во все этапы истории создания «Прохоровской сласти».</p>', '<p class=\"desc smal\">Интерактивная программа входит в цикл программ «Пляшем от печки» и знакомит с укладом и бытом ремесленников-кустарей, занятых на производстве знаменитой белевской пастилы; в интересной форме погружает во все этапы истории создания «Прохоровской сласти». Добавит впечатлений участие в сборе урожая яблок, аромат спелой антоновки и пышущая жаром печка! Думаете, что на этом всё? А как же без состязания и духа победы? Участники смогут проявить себя и в физических, и в интеллектуальных заданиях, а также проявить смекалку.</p>\n\n <p class=\"desc smal\">стоимость программы: 660 рублей;<br>\n возрастная категория: 12+;<br>\n для организованных групп от 10 до 20 человек;<br>\n продолжительность программы: 1 час 20 мин.</p>', 'Интерактивная программа «Прохоровская сласть»', '2025-07-12', 'img/plyashem-ot-pechki.jpg', 4, 548, '[\"10-11\", \"11-12\", \"12-13\", \"13-14\", \"14-15\", \"15-16\", \"16-17\", \"17-18\", \"18-19\", \"19-20\", \"20-21\"]'),
(2, 'Театр Петрушки', 50, 44, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, '<p class=\"desc smal\">Театр Петрушки – старейшее развлечение, популярное в России с XVII века. Уникальный персонаж русского народного кукольного театра и его комические представления дошли до наших дней и не потеряли своей актуальности.', '<p class=\"desc smal\">Театр Петрушки – старейшее развлечение, популярное в России с XVII века. Уникальный персонаж русского народного кукольного театра и его комические представления дошли до наших дней и не потеряли своей актуальности.\n\nВо время программы зрители вместе с непобедимым героем кукольных баталий Петрушкой встретятся с хитрым Цыганом Мора, что поёт басом, запивает квасом, купят чудо-лошадёнку, что без гривы, без хвоста, познакомятся с прекрасной невестой Матрёной-красой, длинной косой и даже вступят в схватку с псом Мухтаркой.\n\nЗрители всех возрастов, вовлечённые в круговерть этого традиционного ярмарочного представления, станут участниками старинных народных игр и забав с уникальными традиционными русскими игрушками – шаркунками, закидушками, хотьковскими мячиками, кулачниками и плясунами.</p>\n\n<p class=\"desc smal\">Количество участников: группы от 10 до 15 человек.<br>\n\nСтоимость: 420 рублей с человека.<br>\n\nВозрастная категория: 6+.<br>\n\nДля организованных групп (от 10 человек) - один сопровождающий на группу учащихся средних и средне-специальных заведений - бесплатно.</p>', 'Программа «Театр Петрушки» приглашает всех на представления', '2025-07-12', 'img/petrushka.png', 3, 544, '[\"9-10\", \"10-11\", \"11-12\", \"12-13\", \"13-14\", \"14-15\", \"15-16\", \"16-17\", \"17-18\", \"18-19\", \"19-20\", \"20-21\"]'),
(3, 'Чаепитие у Левши', 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 35, 50, '<p class=\"desc smal\">Что значит «довести до белого каления»? Из чего сделан самовар? Чем отличается столярное дело от плотницкого? Ответы на эти и многие другие вопросы можно узнать в ремесленном дворе «Добродей».', '<p class=\"desc smal\">Что значит «довести до белого каления»? Из чего сделан самовар? Чем отличается столярное дело от плотницкого? Ответы на эти и многие другие вопросы можно узнать в ремесленном дворе «Добродей». В ходе увлекательной программы участники в Кузнечной слободе познакомятся с настоящими кузнецами. На мастер-шоу по ковке увидят, как горит металл, а также отчеканят монетку на удачу. Старинные плотницкие инструменты и ажурные наличники деревянной Тулы откроют свои секреты в выставочном комплексе «Тульский резной наличник». В завершение программы Левша растопит самовар и покажет, чем отличаются традиции чаепития тульских ремесленников, купцов и знати ХVIII- ХIХ веков.</p>\n\n <p class=\"desc smal\">стоимость программы: 470 рублей;<br>\n возрастная категория: 6+;<br>\n для организованных групп от 10 до 50 человек;<br>\n продолжительность программы: 1 час -1 час 15 мин.</p>', 'Интерактивная программа «Чаепитие у Левши»', '2025-07-12', 'img/chai.jpg', 5, 550, '[\"9-10\", \"10-11\", \"11-12\", \"12-13\", \"13-14\", \"14-15\", \"15-16\", \"16-17\", \"17-18\", \"18-19\", \"19-20\", \"20-21\"]');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Новая',
  `userId` int NOT NULL,
  `title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `status`, `userId`, `title`, `time`, `count`) VALUES
(2, 'Подтверждена', 12, 'Прохоровская сласть', '9:00-10:00', 1),
(5, 'Подтверждена', 12, 'Театр Петрушки', '10:00-11:00', 2),
(6, 'Подтверждена', 8, 'Чаепитие у Левши', '19:00-20:00', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `age` int NOT NULL,
  `gender` enum('муж.','жен.') NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `banned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`id`, `email`, `name`, `surname`, `age`, `gender`, `password`, `photo_path`, `created_at`, `banned`) VALUES
(9, 'w@w.ww', 'w', 'w', 18, 'муж.', '$2y$12$DXOVYCUfbw0B3n2.0knhP.Df6XNP.ZaYKsEPXv.e.0huv.cdi9DdS', 'static/pfp.jpg', '2026-02-22 14:31:12', 0),
(10, 'w@w.www', 'w', 'w', 18, 'муж.', '$2y$12$L3fLEv5hCM0eVuN4QNdNKubMhiGyvTe5RJhc6UjfHGHeRmejAWjxC', 'static/pfp.jpg', '2026-02-22 14:32:37', 0),
(11, 'w@w.wwww', 'w', 'w', 18, 'муж.', '$2y$12$0WbnseEpQyehpjchp2qJDOnk9BorgJy3wYrCBhp/gnDygtuvQaP96', 'static/pfp.jpg', '2026-02-22 14:33:04', 0),
(12, 'w@w.wwwwwwww', 'w', 'w', 18, 'муж.', '$2y$12$5I7xhEU37x.8G8bgFRkVp.EKm19p2wwan100pN5m9igQThwZ/Kvam', 'static/pfp.jpg', '2026-02-22 14:33:21', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `family_members`
--
ALTER TABLE `family_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_id` (`participant_id`);

--
-- Индексы таблицы `master-classes`
--
ALTER TABLE `master-classes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `family_members`
--
ALTER TABLE `family_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `master-classes`
--
ALTER TABLE `master-classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `family_members`
--
ALTER TABLE `family_members`
  ADD CONSTRAINT `family_members_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
