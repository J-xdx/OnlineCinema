-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 23 2020 г., 14:36
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `p92105m2_site`
--

DELIMITER $$
--
-- Процедуры
--
DROP PROCEDURE IF EXISTS `buy_film`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `buy_film` (IN `v_nick` VARCHAR(50), IN `v_film_id` INT)  BEGIN
	DECLARE v_user_id INT(8);
    SET v_user_id = (SELECT user_id FROM users WHERE nickname = v_nick);
    
	IF(SELECT COUNT(*) FROM rent_info WHERE status = "Куплен" AND film_id = v_film_id AND user_id = v_user_id) = 0 
    	THEN INSERT INTO rent_info(film_id, user_id, rent_date, rent_end, status) VALUES(v_film_id, v_user_id, CURRENT_DATE, NULL, "Куплен");
        
        DELETE FROM rent_info WHERE film_id = v_film_id AND user_id = v_user_id AND rent_info.status = "Подписка";
        
        SELECT "Успешно";
    END IF;
    
END$$

DROP PROCEDURE IF EXISTS `film_list`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `film_list` ()  BEGIN
    SET lc_time_names = 'ru_RU';
	SELECT * FROM film_list;
END$$

DROP PROCEDURE IF EXISTS `new_rent`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `new_rent` (IN `v_film` INT, IN `v_user` INT, IN `v_end` DATE, IN `v_status` VARCHAR(30))  BEGIN
	INSERT INTO rent_info(film_id, user_id, rent_date, rent_end, status) VALUES(v_film, v_user, CURRENT_DATE, v_end, v_status);
END$$

DROP PROCEDURE IF EXISTS `registration`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `registration` (IN `v_nickname` VARCHAR(50), IN `v_password` VARCHAR(50), IN `v_name` VARCHAR(50), IN `v_surname` VARCHAR(50))  BEGIN
	INSERT INTO users(name, surname, nickname, password) VALUES (v_name, v_surname, v_nickname, v_password);
END$$

DROP PROCEDURE IF EXISTS `searchBYname`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `searchBYname` (IN `v_method` VARCHAR(20), IN `v_name` VARCHAR(50))  BEGIN
	CASE
    	WHEN v_method = 'name' THEN (SELECT * FROM film_list WHERE name LIKE CONCAT('%', LTRIM(RTRIM(v_name)), '%'));
    	WHEN v_method = 'director' THEN (SELECT * FROM film_list WHERE director LIKE CONCAT('%', LTRIM(RTRIM(v_name)), '%'));
        WHEN v_method = 'genre' THEN (SELECT * FROM film_list WHERE genres LIKE v_name);
    END CASE;
END$$

DROP PROCEDURE IF EXISTS `sub_film`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `sub_film` (IN `v_nick` VARCHAR(50), IN `v_film_id` INT, IN `days` INT)  BEGIN
	DECLARE v_user_id INT(8);
    SET v_user_id = (SELECT user_id FROM users WHERE nickname = v_nick);
    
    IF(SELECT COUNT(*) FROM rent_info WHERE (status = "Куплен" OR CURRENT_DATE < rent_end) AND film_id = v_film_id AND user_id = v_user_id) = 0 
    	THEN DELETE FROM rent_info WHERE film_id = v_film_id AND user_id = v_user_id AND rent_info.status = "Подписка";
        
        INSERT INTO rent_info(film_id, user_id, rent_date, rent_end, status) VALUES(v_film_id, v_user_id, CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL days DAY), "Подписка");
        
        SELECT "Успешно";
	END IF;
END$$

DROP PROCEDURE IF EXISTS `user_library`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `user_library` (IN `v_nick` VARCHAR(50))  BEGIN
	SET lc_time_names = 'ru_RU';
	SELECT rent_info.film_id, films.name, date_format(rent_info.rent_date,'%d %M %Y') FROM rent_info, users, films WHERE rent_info.status = "Куплен" AND rent_info.user_id = users.user_id AND users.nickname = v_nick AND films.film_id = rent_info.film_id;
END$$

DROP PROCEDURE IF EXISTS `user_subscription`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `user_subscription` (IN `v_nick` VARCHAR(50))  BEGIN
	SET lc_time_names = 'ru_RU';
    SELECT rent_info.film_id, films.name, date_format(rent_info.rent_end,'%d %M %Y') FROM rent_info, users, films WHERE rent_info.status = "Подписка" AND rent_info.user_id = users.user_id AND users.nickname = v_nick AND films.film_id = rent_info.film_id;
END$$

DROP PROCEDURE IF EXISTS `watching`$$
CREATE DEFINER=`p92105m2_site`@`localhost` PROCEDURE `watching` (IN `v_film` INT, IN `v_nick` VARCHAR(50))  BEGIN
	SELECT films.film_id, films.name, film_list.genres FROM films, film_list, rent_info, users WHERE films.film_id = v_film AND film_list.film_id = films.film_id AND rent_info.user_id = users.user_id AND users.nickname = v_nick AND films.film_id = rent_info.film_id AND (rent_info.rent_end IS NULL OR rent_info.rent_end >= CURRENT_DATE);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `films`
--
-- Создание: Май 12 2020 г., 14:52
--

DROP TABLE IF EXISTS `films`;
CREATE TABLE `films` (
  `film_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  `cost` int(11) NOT NULL,
  `director` varchar(50) NOT NULL,
  `pg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`film_id`, `name`, `release_date`, `cost`, `director`, `pg`) VALUES
(1, 'Аватар', '2009-12-17', 99, 'Джеймс Кэмерон', 12),
(2, 'Начало', '2010-07-22', 119, 'Кристофер Нолан', 12),
(3, 'Помни', '2001-06-27', 49, 'Кристофер Нолан', 16),
(4, 'Человек на Луне', '2018-10-11', 99, 'Дэмьен Шазелл', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `films_genre`
--
-- Создание: Май 15 2020 г., 18:26
--

DROP TABLE IF EXISTS `films_genre`;
CREATE TABLE `films_genre` (
  `films_genre_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `films_genre`
--

INSERT INTO `films_genre` (`films_genre_id`, `film_id`, `genre_id`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 1, 3),
(4, 1, 4),
(5, 2, 1),
(6, 2, 2),
(7, 2, 6),
(8, 3, 6),
(9, 3, 5),
(10, 3, 3),
(11, 4, 3),
(12, 4, 7);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `film_list`
-- (См. Ниже фактическое представление)
--
DROP VIEW IF EXISTS `film_list`;
CREATE TABLE `film_list` (
`film_id` int(11)
,`name` varchar(50)
,`director` varchar(50)
,`release_date` varchar(72)
,`pg` varchar(12)
,`cost` varchar(12)
,`genres` text
);

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--
-- Создание: Май 12 2020 г., 14:53
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`genre_id`, `name`) VALUES
(1, 'Фантастика'),
(2, 'Боевик'),
(3, 'Драма'),
(4, 'Приключение'),
(5, 'Детектив'),
(6, 'Триллер'),
(7, 'История');

-- --------------------------------------------------------

--
-- Структура таблицы `rent_info`
--
-- Создание: Май 15 2020 г., 18:28
--

DROP TABLE IF EXISTS `rent_info`;
CREATE TABLE `rent_info` (
  `rent_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rent_date` date NOT NULL,
  `rent_end` date DEFAULT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rent_info`
--

INSERT INTO `rent_info` (`rent_id`, `film_id`, `user_id`, `rent_date`, `rent_end`, `status`) VALUES
(1, 1, 1, '2020-06-03', NULL, 'Куплен'),
(2, 3, 1, '2020-06-03', '2020-06-20', 'Подписка'),
(22, 4, 1, '2020-06-03', '2020-06-04', 'Подписка'),
(24, 1, 3, '2020-06-06', '2020-06-14', 'Подписка'),
(25, 4, 2, '2020-06-22', '2020-06-27', 'Подписка'),
(26, 1, 2, '2020-06-22', NULL, 'Куплен'),
(27, 2, 1, '2020-09-12', '2020-09-15', 'Подписка');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Июн 04 2020 г., 14:47
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `nickname`, `password`, `name`, `surname`) VALUES
(1, 'Pav3l', '1234', 'Павел', 'Коптяев'),
(2, 'Testovy', '4321', 'Иван', 'Иванов'),
(3, 'хм', '221', 'а кто ', 'я?'),
(4, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Структура для представления `film_list`
--
DROP TABLE IF EXISTS `film_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`p92105m2_site`@`localhost` SQL SECURITY DEFINER VIEW `film_list`  AS  select `films`.`film_id` AS `film_id`,`films`.`name` AS `name`,`films`.`director` AS `director`,date_format(`films`.`release_date`,'%d %M %Y') AS `release_date`,concat(`films`.`pg`,'+') AS `pg`,concat(`films`.`cost`,'₽') AS `cost`,group_concat(`genre`.`name` separator ', ') AS `genres` from ((`films` join `films_genre`) join `genre`) where ((`films_genre`.`film_id` = `films`.`film_id`) and (`genre`.`genre_id` = `films_genre`.`genre_id`)) group by `films`.`film_id` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`film_id`);

--
-- Индексы таблицы `films_genre`
--
ALTER TABLE `films_genre`
  ADD PRIMARY KEY (`films_genre_id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Индексы таблицы `rent_info`
--
ALTER TABLE `rent_info`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `film_id` (`film_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nickname` (`nickname`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `film_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `films_genre`
--
ALTER TABLE `films_genre`
  MODIFY `films_genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `rent_info`
--
ALTER TABLE `rent_info`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `films_genre`
--
ALTER TABLE `films_genre`
  ADD CONSTRAINT `films_genre_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `films` (`film_id`),
  ADD CONSTRAINT `films_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);

--
-- Ограничения внешнего ключа таблицы `rent_info`
--
ALTER TABLE `rent_info`
  ADD CONSTRAINT `rent_info_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `films` (`film_id`),
  ADD CONSTRAINT `rent_info_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
