-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 12. lis 2020, 10:48
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `students` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_czech_ci NOT NULL,
) ENGINE= DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `student` (`id`, `name`, `surname`,  `password`) VALUES
(1, 'Karel', 'Novák',''),
(2, 'Vilém', 'Trojan','' ),
(3, 'Pavla', 'Malá','' ),
(4, 'Karolína', 'Nováková','' ),
(5, 'Pavel', 'Nový','' ),
(6, 'Monika', 'Javorová',''),
(7, 'Marek', 'Hardt' ,''),
(8, 'Irena', 'Trojanová','' ),
(9, 'Hynek', 'Gregor',''),
(10, 'Hana', 'Fredonová',''),
(11, 'Administrátor', 'Systému', '$2y$10$iYA/YqqSKzFRW.UQBfj0N.QnVoeQi7oC95cnSe9boi7xoCc3AoTda');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `students`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
