-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2023. Ápr 14. 12:48
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `users_db`
--
CREATE DATABASE IF NOT EXISTS `users_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `users_db`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `sajatid` int(11) NOT NULL,
  `lok_name` varchar(30) NOT NULL,
  `lok_type` varchar(30) NOT NULL,
  `lok_reason` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `forms`
--

INSERT INTO `forms` (`id`, `sajatid`, `lok_name`, `lok_type`, `lok_reason`) VALUES
(3, 3, 'Gigant', 'Elektromos', 'Mert csodaszép'),
(4, 3, 'Szili', 'Elektromos', 'Mert csudajó'),
(5, 3, 'Csörgő', 'Dízel', 'Mert füstöl'),
(6, 3, '', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages_01`
--

CREATE TABLE `messages_01` (
  `id` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `from_user` varchar(60) NOT NULL,
  `to_user` varchar(60) NOT NULL,
  `message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- A tábla adatainak kiíratása `messages_01`
--

INSERT INTO `messages_01` (`id`, `timestamp`, `from_user`, `to_user`, `message`) VALUES
(3, '2023-03-26 11:51:01', 'Sample02', 'Sample01', 'Hi'),
(5, '2023-03-26 11:59:45', 'Sample02', 'Sample01', 'Hello.'),
(6, '2023-03-26 12:00:32', 'Sample02', 'Sample01', 'hooooo'),
(64, '2023-03-26 21:00:15', 'Sample01', 'Sample02', 'Hey'),
(71, '2023-03-26 21:02:59', 'Sample01', 'Sample02', 'hooohahoooo'),
(76, '2023-03-26 21:41:07', 'Sample02', 'Sample01', 'asdf'),
(77, '2023-03-26 22:07:55', 'Sample02', 'Sample01', 'hejjj'),
(78, '2023-03-29 08:46:31', 'gercso', 'root', 'Szia'),
(79, '2023-03-29 08:47:59', 'root', 'gercso', 'Szevasz'),
(80, '2023-03-29 09:11:55', 'Esztebán', 'gercso', 'Sziaaaaaaaaaaaaaaaaaa'),
(81, '2023-04-14 09:50:35', 'Esztebán', 'root', 'Sziaa');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birth` date DEFAULT NULL,
  `intro` varchar(300) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `moderator` tinyint(1) NOT NULL DEFAULT 0,
  `sudo` tinyint(1) NOT NULL DEFAULT 0,
  `email_vis` tinyint(1) NOT NULL DEFAULT 0,
  `birth_vis` tinyint(1) NOT NULL DEFAULT 0,
  `profpic_route` varchar(1000) NOT NULL DEFAULT 'img/welcome_01.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `user_name`, `pwd`, `email`, `birth`, `intro`, `admin`, `moderator`, `sudo`, `email_vis`, `birth_vis`, `profpic_route`) VALUES
(1, 'gercso', '$2y$10$QRRFq/uxchqyjI9L/xGZ/.M3Ye5c3vWrchRzK3YGRPQofbmIrea3G', 'gmark@inf.u-szeged.hu', '2002-02-02', 'Próba', 1, 0, 1, 1, 1, 'img/welcome_01.png'),
(2, 'root', '$2y$10$vSOEKTPmOrXnqacP62V76O3DJJI2iwIQ7RRKq0Bb1tIkiUf4/togK', 'info.railway150@gmail.com', '0000-00-00', '', 0, 0, 0, 0, 0, 'img/welcome_01.png'),
(3, 'Esztebán', '$2y$10$6VQsIzpAtNbl7A9ly5ky3udsf0aqPTuD1DmFL.HSsaAWu/LHmzvOS', 'bbx523@gmail.com', '2003-01-31', 'Vicci, ugye?', 0, 1, 1, 0, 0, 'img/welcome_01.png'),
(4, 'dummy', '$2y$10$ID1yc92fo3zcwc8X.PQFI.o58UH7eyx7uIC9odHwQzhd44NmzW0va', 'guverra73@gmail.com', NULL, '', 0, 0, 0, 0, 0, 'img/welcome_01.png'),
(8, 'DeeAyDan', '$2y$10$Ovomu3nkGnBVf73kbFQQXuW4AhV.7NtE1.11N2WFOl9YEnsf7x6ny', 'kromekdani@gmail.com', NULL, 'Sziaaa', 0, 0, 0, 0, 0, 'img/welcome_01.png');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `messages_01`
--
ALTER TABLE `messages_01`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `messages_01`
--
ALTER TABLE `messages_01`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
