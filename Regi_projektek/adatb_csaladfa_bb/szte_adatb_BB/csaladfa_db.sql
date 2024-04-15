-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Nov 19. 20:02
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `csaladfa_db`
--
CREATE DATABASE IF NOT EXISTS `csaladfa_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `csaladfa_db`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `csaladfa_sum`
--

CREATE TABLE `csaladfa_sum` (
  `letrehozo_id` int(11) NOT NULL COMMENT 'Az adatbázist létrehozó azonosítója',
  `letrehozo` varchar(60) NOT NULL COMMENT 'Az adatbázis létrehozójának felhasználóneve',
  `nev` varchar(60) NOT NULL COMMENT 'Adatbázis neve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Adatbázisokat számontartó tábla';

--
-- A tábla adatainak kiíratása `csaladfa_sum`
--

INSERT INTO `csaladfa_sum` (`letrehozo_id`, `letrehozo`, `nev`) VALUES
(1, 'Eszti', 'Szabó'),
(1, 'Eszti', 'Uj'),
(1, 'Eszti', 'Vörös');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `fiokok`
--

CREATE TABLE `fiokok` (
  `id` int(11) NOT NULL COMMENT 'Felhasználó azonosítója',
  `user_name` varchar(60) NOT NULL COMMENT 'Felhasználónév',
  `pwd` varchar(200) NOT NULL COMMENT 'Kódolt jelszó'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Felhasználókat kezelő tábla';

--
-- A tábla adatainak kiíratása `fiokok`
--

INSERT INTO `fiokok` (`id`, `user_name`, `pwd`) VALUES
(1, 'Eszti', '$2y$10$q55W7R0/FQqr88oedY68POXSeJB6AxmOAuqZPSsaWFwULFkZQbrnW');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szabó_eszti_esemenyek`
--

CREATE TABLE `szabó_eszti_esemenyek` (
  `id` int(11) NOT NULL COMMENT 'Elsődleges kulcs, az esemény azonosítója',
  `szemelyid` int(11) NOT NULL COMMENT 'Az eseményhez köthető személy azonosítója',
  `hazassag_datum` date NOT NULL COMMENT 'A házasság dátuma',
  `valas_datum` date DEFAULT NULL COMMENT 'A válás dátuma (üres is lehet)',
  `erintett_id` int(11) NOT NULL COMMENT 'A másik érintett személy azonosítója'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='A Szabó család eseményeit kezelő tábla';

--
-- A tábla adatainak kiíratása `szabó_eszti_esemenyek`
--

INSERT INTO `szabó_eszti_esemenyek` (`id`, `szemelyid`, `hazassag_datum`, `valas_datum`, `erintett_id`) VALUES
(5, 5, '2020-03-16', '0000-00-00', 8);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szabó_eszti_szemelyek`
--

CREATE TABLE `szabó_eszti_szemelyek` (
  `id` int(11) NOT NULL COMMENT 'A személy azonosítója',
  `nev` varchar(60) NOT NULL COMMENT 'A személy neve',
  `nem` varchar(10) NOT NULL COMMENT 'A személy biológiai neme',
  `szuletes` date NOT NULL COMMENT 'A személy születési dátuma',
  `halalozas` date NOT NULL COMMENT 'A személy halálozási dátuma',
  `anya` varchar(60) NOT NULL COMMENT 'A személy anyjának neve',
  `apa` varchar(60) NOT NULL COMMENT 'A személy apjának neve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='A Szabó család személyeit kezelő tábla';

--
-- A tábla adatainak kiíratása `szabó_eszti_szemelyek`
--

INSERT INTO `szabó_eszti_szemelyek` (`id`, `nev`, `nem`, `szuletes`, `halalozas`, `anya`, `apa`) VALUES
(5, 'Tank Aranka', 'no', '1969-05-02', '0000-00-00', 'Édes Anna', 'Tank János'),
(6, 'Ujhelyi Zsolt', 'ferfi', '2023-10-01', '0000-00-00', 'Kandisz Nóra', 'Ujhelyi Ábel'),
(8, 'Ujhelyi István', 'ferfi', '1967-06-20', '0000-00-00', 'Kandisz Nóra', 'Ujhelyi Ábel'),
(9, 'Ujhelyi Szimonetta', 'no', '1965-03-11', '0000-00-00', 'Kandisz Nóra', 'Ujhelyi Ábel'),
(10, 'Szabó Elemér', 'ferfi', '1970-05-20', '0000-00-00', 'Szabó Sándorné', 'Szabó Sándor');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szabó_eszti_testverek`
--

CREATE TABLE `szabó_eszti_testverek` (
  `szemelyid` int(11) NOT NULL COMMENT 'A személy azonosítója',
  `nev` varchar(60) NOT NULL COMMENT 'A személy testvére'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Testvéreket számontartó tábla egy családnál';

--
-- A tábla adatainak kiíratása `szabó_eszti_testverek`
--

INSERT INTO `szabó_eszti_testverek` (`szemelyid`, `nev`) VALUES
(6, 'Ujhelyi István'),
(6, ' Ujhelyi Szimonetta'),
(8, 'Ujhelyi Zsolt'),
(8, ' Ujhelyi Szimonetta'),
(9, 'Ujhelyi Zsolt'),
(9, 'Ujhelyi Szimonetta'),
(10, 'Szabó József'),
(10, 'Szabó Kálmán'),
(10, 'Szabó Imre');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uj_eszti_esemenyek`
--

CREATE TABLE `uj_eszti_esemenyek` (
  `id` int(11) NOT NULL COMMENT 'Elsődleges kulcs, az esemény azonosítója',
  `szemelyid` int(11) NOT NULL COMMENT 'Eseményben érintett egyik személy azonosítója',
  `hazassag_datum` date NOT NULL COMMENT 'A házasság dátuma',
  `valas_datum` date NOT NULL COMMENT 'A válás dátuma (üres is lehet)',
  `erintett_id` int(11) NOT NULL COMMENT 'A másik érintett személy azonosítója'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='A Uj család eseményeit kezelő tábla';

--
-- A tábla adatainak kiíratása `uj_eszti_esemenyek`
--

INSERT INTO `uj_eszti_esemenyek` (`id`, `szemelyid`, `hazassag_datum`, `valas_datum`, `erintett_id`) VALUES
(3, 1, '2023-11-03', '0000-00-00', 3),
(8, 2, '2023-07-01', '0000-00-00', 6),
(9, 4, '2023-11-03', '2023-11-05', 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uj_eszti_szemelyek`
--

CREATE TABLE `uj_eszti_szemelyek` (
  `id` int(11) NOT NULL COMMENT 'A személy azonosítója',
  `nev` varchar(60) NOT NULL COMMENT 'A személy neve',
  `nem` varchar(10) NOT NULL COMMENT 'A személy biológiai neme',
  `szuletes` date NOT NULL COMMENT 'A személy születési dátuma',
  `halalozas` date NOT NULL COMMENT 'A személy halálozási dátuma',
  `anya` varchar(60) NOT NULL COMMENT 'A személy anyjának neve',
  `apa` varchar(60) NOT NULL COMMENT 'A személy apjának neve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='A Uj család személyeit kezelő tábla';

--
-- A tábla adatainak kiíratása `uj_eszti_szemelyek`
--

INSERT INTO `uj_eszti_szemelyek` (`id`, `nev`, `nem`, `szuletes`, `halalozas`, `anya`, `apa`) VALUES
(1, 'Uj Péter', 'ferfi', '2023-11-01', '0000-00-00', 'Ujné Régi Otília', 'Uj Ferenc'),
(2, 'Uj József', 'ferfi', '2023-11-01', '0000-00-00', 'Ujné Régi Otília', 'Uj Ferenc'),
(3, 'Szabó Klaudia', 'no', '2023-06-26', '0000-00-00', 'Ujné Régi Otília', 'Koaxk Ábel'),
(4, 'Uj Sándor', 'ferfi', '2003-01-30', '0000-00-00', 'Ujné Régi Otília', 'Ferenc József'),
(5, 'Faragó Hajnalka', 'no', '2003-03-28', '0000-00-00', 'Kandisz Nóra', 'Faragó János'),
(6, 'Boross Vanessza', 'no', '1999-12-31', '0000-00-00', 'Bakos Szilvia', 'Boross Péter');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uj_eszti_testverek`
--

CREATE TABLE `uj_eszti_testverek` (
  `szemelyid` int(11) NOT NULL COMMENT 'A személy azonosítója',
  `nev` varchar(60) NOT NULL COMMENT 'A személy testvére'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Testvéreket számontartó tábla egy családnál';

--
-- A tábla adatainak kiíratása `uj_eszti_testverek`
--

INSERT INTO `uj_eszti_testverek` (`szemelyid`, `nev`) VALUES
(1, 'Uj Sándor'),
(1, 'Uj József\r\n'),
(2, 'Uj Sándor'),
(2, 'Uj Péter\r\n'),
(4, 'Uj Péter'),
(4, 'Uj József');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vörös_eszti_esemenyek`
--

CREATE TABLE `vörös_eszti_esemenyek` (
  `id` int(11) NOT NULL COMMENT 'Elsődleges kulcs, az esemény azonosítója',
  `szemelyid` int(11) NOT NULL COMMENT 'Eseményben érintett egyik személy azonosítója',
  `hazassag_datum` date NOT NULL COMMENT 'A házasság dátuma',
  `valas_datum` date NOT NULL COMMENT 'A válás dátuma (üres is lehet)',
  `erintett_id` int(11) NOT NULL COMMENT 'A másik érintett személy azonosítója'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='A Vörös család eseményeit kezelő tábla';

--
-- A tábla adatainak kiíratása `vörös_eszti_esemenyek`
--

INSERT INTO `vörös_eszti_esemenyek` (`id`, `szemelyid`, `hazassag_datum`, `valas_datum`, `erintett_id`) VALUES
(1, 1, '2000-01-01', '2023-11-08', 2),
(2, 3, '2023-10-01', '2023-12-11', 7);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vörös_eszti_szemelyek`
--

CREATE TABLE `vörös_eszti_szemelyek` (
  `id` int(11) NOT NULL COMMENT 'A személy azonosítója',
  `nev` varchar(60) NOT NULL COMMENT 'A személy neve',
  `nem` varchar(10) NOT NULL COMMENT 'A személy biológiai neme',
  `szuletes` date NOT NULL COMMENT 'A személy születési dátuma',
  `halalozas` date NOT NULL COMMENT 'A személy halálozási dátuma',
  `anya` varchar(60) NOT NULL COMMENT 'A személy anyjának neve',
  `apa` varchar(60) NOT NULL COMMENT 'A személy apjának neve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='A Vörös család személyeit kezelő tábla';

--
-- A tábla adatainak kiíratása `vörös_eszti_szemelyek`
--

INSERT INTO `vörös_eszti_szemelyek` (`id`, `nev`, `nem`, `szuletes`, `halalozas`, `anya`, `apa`) VALUES
(1, 'Vörös Szabolcs', 'ferfi', '1970-04-20', '0000-00-00', 'Vörös Amália', 'Vörös István'),
(2, 'Mezei Virág', 'no', '1970-11-11', '0000-00-00', 'Öntöző K. Anna', 'Mezei Imre'),
(3, 'Vörös Márk', 'ferfi', '1999-12-30', '0000-00-00', 'Mezei Virág', 'Vörös Szabolcs'),
(4, 'Vörös Martin', 'ferfi', '2001-09-11', '0000-00-00', 'Mezei Virág', 'Vörös Szabolcs'),
(5, 'Vörös László', 'ferfi', '2004-01-31', '0000-00-00', 'Mezei Virág', 'Vörös Szabolcs'),
(6, 'Juhász Júlia', 'no', '2000-12-23', '0000-00-00', 'Juhász Emese', 'Juhász Tamás'),
(7, 'Szép Judit', 'no', '1998-01-23', '0000-00-00', 'Sándor Márta', 'Szép Endre');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vörös_eszti_testverek`
--

CREATE TABLE `vörös_eszti_testverek` (
  `szemelyid` int(11) NOT NULL COMMENT 'A személy azonosítója',
  `nev` varchar(60) NOT NULL COMMENT 'A személy testvére'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Testvéreket számontartó tábla egy családnál';

--
-- A tábla adatainak kiíratása `vörös_eszti_testverek`
--

INSERT INTO `vörös_eszti_testverek` (`szemelyid`, `nev`) VALUES
(3, 'Vörös László'),
(3, 'Vörös Martin'),
(4, 'Vörös László'),
(4, 'Vörös Márk'),
(5, 'Vörös Márk'),
(5, 'Vörös Martin'),
(6, 'Juhász Emília'),
(7, 'Szép Ica');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `csaladfa_sum`
--
ALTER TABLE `csaladfa_sum`
  ADD PRIMARY KEY (`nev`),
  ADD KEY `has_id` (`letrehozo_id`);

--
-- A tábla indexei `fiokok`
--
ALTER TABLE `fiokok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `szabó_eszti_esemenyek`
--
ALTER TABLE `szabó_eszti_esemenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `has_esemeny` (`szemelyid`);

--
-- A tábla indexei `szabó_eszti_szemelyek`
--
ALTER TABLE `szabó_eszti_szemelyek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `szabó_eszti_testverek`
--
ALTER TABLE `szabó_eszti_testverek`
  ADD KEY `has_testver` (`szemelyid`);

--
-- A tábla indexei `uj_eszti_esemenyek`
--
ALTER TABLE `uj_eszti_esemenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szemelyid` (`szemelyid`),
  ADD KEY `erintett_id` (`erintett_id`);

--
-- A tábla indexei `uj_eszti_szemelyek`
--
ALTER TABLE `uj_eszti_szemelyek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `uj_eszti_testverek`
--
ALTER TABLE `uj_eszti_testverek`
  ADD KEY `szemelyid` (`szemelyid`);

--
-- A tábla indexei `vörös_eszti_esemenyek`
--
ALTER TABLE `vörös_eszti_esemenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `szemelyid` (`szemelyid`);

--
-- A tábla indexei `vörös_eszti_szemelyek`
--
ALTER TABLE `vörös_eszti_szemelyek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `vörös_eszti_testverek`
--
ALTER TABLE `vörös_eszti_testverek`
  ADD KEY `szemelyid` (`szemelyid`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `fiokok`
--
ALTER TABLE `fiokok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Felhasználó azonosítója', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `szabó_eszti_esemenyek`
--
ALTER TABLE `szabó_eszti_esemenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Elsődleges kulcs, az esemény azonosítója', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `szabó_eszti_szemelyek`
--
ALTER TABLE `szabó_eszti_szemelyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A személy azonosítója', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `uj_eszti_esemenyek`
--
ALTER TABLE `uj_eszti_esemenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Elsődleges kulcs, az esemény azonosítója', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `uj_eszti_szemelyek`
--
ALTER TABLE `uj_eszti_szemelyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A személy azonosítója', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `vörös_eszti_esemenyek`
--
ALTER TABLE `vörös_eszti_esemenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Elsődleges kulcs, az esemény azonosítója', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `vörös_eszti_szemelyek`
--
ALTER TABLE `vörös_eszti_szemelyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A személy azonosítója', AUTO_INCREMENT=8;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `csaladfa_sum`
--
ALTER TABLE `csaladfa_sum`
  ADD CONSTRAINT `has_id` FOREIGN KEY (`letrehozo_id`) REFERENCES `fiokok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `szabó_eszti_esemenyek`
--
ALTER TABLE `szabó_eszti_esemenyek`
  ADD CONSTRAINT `has_esemeny` FOREIGN KEY (`szemelyid`) REFERENCES `szabó_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `szabó_eszti_testverek`
--
ALTER TABLE `szabó_eszti_testverek`
  ADD CONSTRAINT `has_testver` FOREIGN KEY (`szemelyid`) REFERENCES `szabó_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `uj_eszti_esemenyek`
--
ALTER TABLE `uj_eszti_esemenyek`
  ADD CONSTRAINT `uj_eszti_esemenyek_ibfk_1` FOREIGN KEY (`szemelyid`) REFERENCES `uj_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uj_eszti_esemenyek_ibfk_2` FOREIGN KEY (`erintett_id`) REFERENCES `uj_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `uj_eszti_testverek`
--
ALTER TABLE `uj_eszti_testverek`
  ADD CONSTRAINT `uj_eszti_testverek_ibfk_1` FOREIGN KEY (`szemelyid`) REFERENCES `uj_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `vörös_eszti_esemenyek`
--
ALTER TABLE `vörös_eszti_esemenyek`
  ADD CONSTRAINT `vörös_eszti_esemenyek_ibfk_1` FOREIGN KEY (`szemelyid`) REFERENCES `vörös_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `vörös_eszti_testverek`
--
ALTER TABLE `vörös_eszti_testverek`
  ADD CONSTRAINT `vörös_eszti_testverek_ibfk_1` FOREIGN KEY (`szemelyid`) REFERENCES `vörös_eszti_szemelyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
