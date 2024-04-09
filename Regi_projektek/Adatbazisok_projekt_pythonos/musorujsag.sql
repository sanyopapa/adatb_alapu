-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Nov 25. 19:25
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `musorujsag`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `admin`
--

CREATE TABLE `admin` (
  `Email` varchar(60) NOT NULL,
  `Nev` varchar(60) NOT NULL,
  `Jelszo` varchar(60) NOT NULL,
  `Utolso_belepes` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `admin`
--

INSERT INTO `admin` (`Email`, `Nev`, `Jelszo`, `Utolso_belepes`) VALUES
('igen@gmail.com', 'valami', '$2b$12$vaDo5M2b7s8URWFuj1FNteqjlx9N5q6SVZ5U65ml8QVELl7Lxw33y', NULL),
('mekkElek@gmail.com', 'mekk elek', '$2b$12$CHxDf4xHVZdFGuRqbpnp9uU5w6.Pp9xxEivMOQ7NSLsXeTSYJQp8i', '2023-11-25 10:08:58'),
('teszt', 'teszt', '$2b$12$WuNMbigdGVJ.hO0PZWnMXeM.jLxQjcjXECrmkz4lE5on7S732gWG2', '2023-11-25 19:21:38'),
('teszt1', 'teszt1', '$2b$12$vnv/xcBJW8VxbcG1p5VkuewWbbrr31BW9kcv1yNq2JOqvKcWp6Zza', '2023-11-23 21:24:38');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `csatorna`
--

CREATE TABLE `csatorna` (
  `Nev` varchar(60) NOT NULL,
  `Kategoria` varchar(60) NOT NULL,
  `Leiras` text NOT NULL,
  `Email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `csatorna`
--

INSERT INTO `csatorna` (`Nev`, `Kategoria`, `Leiras`, `Email`) VALUES
('Animal Planet', 'természet', 'Animal Planet csatorna leírása', 'igen@gmail.com'),
('AXN', 'film', 'AXN csatorna egy nagyon jó filmes csatorna', 'mekkElek@gmail.com'),
('cartoon network', 'mese', 'cartoon network csatorna leírása', 'mekkElek@gmail.com'),
('Cool', 'filmek', 'Cool leírása', 'igen@gmail.com'),
('Film+', 'filmek', 'Film+ leírása', 'igen@gmail.com'),
('HBO', 'film', 'HBO csatorna leírása', 'igen@gmail.com'),
('HírTV', 'hírek', 'HírTV csatorna leírása', 'igen@gmail.com'),
('M2', 'mese', 'M2 csatorna leírása', 'mekkElek@gmail.com'),
('M4 sport', 'sport', 'M4 sport csatorna leírása', 'mekkElek@gmail.com'),
('Minimax', 'mese', 'Minimax csatorna leírása', 'mekkElek@gmail.com'),
('NatGeoWild', 'természet', 'NatGeoWild csatorna leírása', 'igen@gmail.com'),
('National Geographic', 'természet', 'National Geographic csatorna leírása', 'mekkElek@gmail.com'),
('nickelodeon', 'ifjúsági', 'nickelodeon csatorna leírása', 'igen@gmail.com'),
('RTL', 'hírek', 'RTL leírása', 'igen@gmail.com'),
('RTLII', 'műsor', 'RTLII csatrorna leírása', 'mekkElek@gmail.com'),
('Spektrum', 'csillagászat', 'Spektrum csatora leírása', 'mekkElek@gmail.com'),
('Sport1', 'sport', 'Sport1 csatorna leírása', 'igen@gmail.com'),
('TV2', 'műsor', 'TV2 csatorna leírása', 'mekkElek@gmail.com'),
('Viasat3', 'filmek', 'Viasat3 leírás', 'mekkElek@gmail.com'),
('Viasat6', 'filmek', 'Viasat6 leírás', 'mekkElek@gmail.com');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `epizodok`
--

CREATE TABLE `epizodok` (
  `Cim` varchar(60) NOT NULL,
  `Epizod` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `epizodok`
--

INSERT INTO `epizodok` (`Cim`, `Epizod`) VALUES
('Dokumentumfilmek éjszakája', 4),
('Dokumentumfilmek éjszakája', 5),
('Dokumentumfilmek éjszakája', 6),
('Dokumentumfilmek éjszakája', 7),
('Dokumentumfilmek éjszakája', 8),
('Dokumentumfilmek éjszakája', 9),
('Esti híradó', 1),
('Esti híradó', 2),
('Esti híradó', 3),
('Esti híradó', 4),
('Esti híradó', 5),
('Esti híradó', 6),
('Esti híradó', 7),
('Esti híradó', 8),
('Esti híradó', 9),
('Esti híradó', 10),
('Film Premier', 1),
('Film Premier', 2),
('Film Premier', 3),
('Film Premier', 4),
('Film Premier', 5),
('Film Premier', 6),
('Film Premier', 7),
('Film Premier', 8),
('Film Premier', 9),
('Film Premier', 10),
('Gasztro világjárók', 4),
('Gasztro világjárók', 5),
('Gasztro világjárók', 6),
('Gasztro világjárók', 7),
('Gasztro világjárók', 8),
('Gasztro világjárók', 9),
('Gasztro világjárók', 10),
('Híradó', 2),
('Híradó', 3),
('Híradó', 4),
('Híradó', 5),
('Híradó', 6),
('Híradó', 7),
('Hupikék törpikék', 1),
('Hupikék törpikék', 2),
('Hupikék törpikék', 3),
('Hupikék törpikék', 4),
('Hupikék törpikék', 5),
('Hupikék törpikék', 6),
('Hupikék törpikék', 7),
('Hupikék törpikék', 8),
('Hupikék törpikék', 9),
('Kalandorok', 1),
('Kalandorok', 2),
('Kalandorok', 3),
('Kalandorok', 4),
('Kalandorok', 5),
('Kalandorok', 6),
('Kalandorok', 7),
('Kalandorok', 8),
('Kalandorok', 9),
('Kalandorok', 10),
('Kalandorok', 11),
('Kalandorok', 12),
('Mesék a gyerekeknek', 2),
('Mesék a gyerekeknek', 3),
('Mesék a gyerekeknek', 4),
('Mesék a gyerekeknek', 5),
('Mesék a gyerekeknek', 6),
('Mesék a gyerekeknek', 7),
('Mozizzunk együtt!', 1),
('Mozizzunk együtt!', 2),
('Mozizzunk együtt!', 3),
('Mozizzunk együtt!', 4),
('Mozizzunk együtt!', 5),
('Mozizzunk együtt!', 6),
('Mozizzunk együtt!', 7),
('Mozizzunk együtt!', 8),
('Művészeti percek', 5),
('Művészeti percek', 6),
('Művészeti percek', 7),
('Művészeti percek', 8),
('Művészeti percek', 9),
('Művészeti percek', 10),
('Reggeli műsor', 2),
('Reggeli műsor', 3),
('Reggeli műsor', 4),
('Reggeli műsor', 5),
('Reggeli műsor', 6),
('Reggeli műsor', 7),
('Sorozat Premier', 4),
('Sorozat Premier', 5),
('Sorozat Premier', 6),
('Sorozat Premier', 7),
('Sorozat Premier', 8),
('Sorozat Premier', 9);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `musor`
--

CREATE TABLE `musor` (
  `Cim` varchar(60) NOT NULL,
  `Mikor` time NOT NULL,
  `Hol` varchar(60) NOT NULL,
  `Ismerteto` text NOT NULL,
  `Email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `musor`
--

INSERT INTO `musor` (`Cim`, `Mikor`, `Hol`, `Ismerteto`, `Email`) VALUES
('Dokumentumfilmek éjszakája', '22:00:00', 'National Geographic', 'Izgalmas dokumentumfilmek', 'mekkElek@gmail.com'),
('Esti híradó', '19:00:00', 'RTL Klub', 'Esti hírek összefoglalása', 'mekkElek@gmail.com'),
('Film Premier', '20:00:00', 'HBO', 'Heti újdonságok a mozivásznon', 'mekkElek@gmail.com'),
('Gasztro világjárók', '20:30:00', 'TV2', 'Világ körüli gasztronómiai élmények', 'mekkElek@gmail.com'),
('Híradó', '18:00:00', 'RTL Klub', 'Aktuális hírek', 'mekkElek@gmail.com'),
('Hupikék törpikék', '10:47:16', 'MiniMax', 'mese a hupikék törpikékről', 'mekkElek@gmail.com'),
('Kalandorok', '19:30:00', 'National Geographic', 'Különböző kalandok dokumentálva', 'mekkElek@gmail.com'),
('kalandorok', '12:00:30', 'National Geographic', 'Különböző kalandok dokumentálva teszt', 'teszt'),
('Mesék a gyerekeknek', '10:30:00', 'Nickelodeon', 'Kedves mesék a legkisebbeknek', 'mekkElek@gmail.com'),
('Mozizzunk együtt!', '19:45:00', 'Film+', 'Közös mozizás élménye', 'mekkElek@gmail.com'),
('Művészeti percek', '14:15:00', 'M2', 'Művészeti hírek és érdekességek', 'mekkElek@gmail.com'),
('Reggeli műsor', '08:00:00', 'TV2', 'Reggeli műsor a TV2-n', 'mekkElek@gmail.com'),
('Sorozat Premier', '21:00:00', 'AXN', 'Új sorozat első része', 'mekkElek@gmail.com'),
('tesztcim1', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim10', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim11', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim2', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim3', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim4', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim5', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim6', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim7', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim8', '00:00:00', 'axn', 'teszt', 'teszt'),
('tesztcim9', '00:00:00', 'axn', 'teszt', 'teszt');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szereplok`
--

CREATE TABLE `szereplok` (
  `Cim` varchar(60) NOT NULL,
  `Szuletesi_datum` date NOT NULL,
  `Foglalkozas` varchar(60) NOT NULL,
  `Nemzetiseg` varchar(60) NOT NULL,
  `Nev` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `szereplok`
--

INSERT INTO `szereplok` (`Cim`, `Szuletesi_datum`, `Foglalkozas`, `Nemzetiseg`, `Nev`) VALUES
('Dokumentumfilmek éjszakája', '1985-02-15', 'riporter', 'angol', 'Emily Davis'),
('Dokumentumfilmek éjszakája', '1988-12-20', 'színész', 'francia', 'Pierre Martin'),
('Dokumentumfilmek éjszakája', '1989-04-15', 'riporter', 'magyar', 'Bálint Nagy'),
('Dokumentumfilmek éjszakája', '1990-01-01', 'színész', 'amerikai', 'John Smith'),
('Esti híradó', '1978-11-30', 'riporter', 'angol', 'Michael Johnson'),
('Esti híradó', '1982-07-25', 'színész', 'spanyol', 'Isabella Lopez'),
('Esti híradó', '1985-05-10', 'riporter', 'magyar', 'Anna Kovács'),
('Film Premier', '1983-07-15', 'színész', 'francia', 'Sophie Martin'),
('Film Premier', '1992-12-01', 'rendező', 'magyar', 'Gábor Kovács'),
('Gasztro világjárók', '1985-09-14', 'séf', 'francia', 'Sophie Dubois'),
('Gasztro világjárók', '1986-07-17', 'séf', 'magyar', 'Péter Molnár'),
('Gasztro világjárók', '1989-06-08', 'séf', 'olasz', 'Marco Rossi'),
('Gasztro világjárók', '1992-03-20', 'gasztroblogger', 'spanyol', 'Luisa Hernandez'),
('Hupikék törpikék', '1995-06-20', 'színész', 'magyar', 'Eszter Horváth'),
('Hupikék törpikék', '2003-11-18', 'színész', 'amerikai', 'Judy Miler'),
('Hupikék törpikék', '2023-11-25', 'tesztfoglalkozas', 'tesztnemzet', 'tesztnev'),
('Kalandorok', '1993-02-28', 'kutató', 'magyar', 'Tamás Szabó'),
('Kalandorok', '2003-11-18', 'színész', 'afrikai', 'Karina Smith'),
('Mozizzunk együtt!', '1994-11-12', 'filmkritikus', 'magyar', 'Anna Kertész'),
('Művészeti percek', '1991-03-10', 'festő', 'magyar', 'Zsófia Fekete'),
('Reggeli műsor', '1980-09-03', 'riporter', 'angol', 'Emma Turner'),
('Reggeli műsor', '1986-05-15', 'műsorvezető', 'magyar', 'Gergő Kovács'),
('Reggeli műsor', '1988-11-28', 'műsorvezető', 'német', 'Hans Müller'),
('Sorozat Premier', '1983-12-10', 'színész', 'kanadai', 'Emily Clark'),
('Sorozat Premier', '1987-05-03', 'színész', 'magyar', 'Gergő Tóth'),
('Sorozat Premier', '1990-08-05', 'színész', 'brit', 'William Turner'),
('Sorozat Premier', '1995-11-28', 'színész', 'amerikai', 'Jessica Anderson');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `vetit`
--

CREATE TABLE `vetit` (
  `Cim` varchar(60) NOT NULL,
  `Nev` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `vetit`
--

INSERT INTO `vetit` (`Cim`, `Nev`) VALUES
('Dokumentumfilmek éjszakája', 'National Geographic'),
('Esti híradó', 'RTL'),
('Film Premier', 'HBO'),
('Gasztro világjárók', 'TV2'),
('Híradó', 'RTL'),
('Hupikék törpikék', 'Minimax'),
('Kalandorok', 'National Geographic'),
('Mesék a gyerekeknek', 'nickelodeon'),
('Mozizzunk együtt!', 'Film+'),
('Művészeti percek', 'M2'),
('Reggeli műsor', 'TV2'),
('Sorozat Premier', 'AXN'),
('tesztcim1', 'axn'),
('tesztcim10', 'axn'),
('tesztcim11', 'axn'),
('tesztcim2', 'axn'),
('tesztcim3', 'axn'),
('tesztcim4', 'axn'),
('tesztcim5', 'axn'),
('tesztcim6', 'axn'),
('tesztcim7', 'axn'),
('tesztcim8', 'axn'),
('tesztcim9', 'axn');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Email`);

--
-- A tábla indexei `csatorna`
--
ALTER TABLE `csatorna`
  ADD PRIMARY KEY (`Nev`,`Email`),
  ADD KEY `csatorna_ibfk_1` (`Email`);

--
-- A tábla indexei `epizodok`
--
ALTER TABLE `epizodok`
  ADD PRIMARY KEY (`Cim`,`Epizod`);

--
-- A tábla indexei `musor`
--
ALTER TABLE `musor`
  ADD PRIMARY KEY (`Cim`,`Hol`,`Email`),
  ADD KEY `Email` (`Email`);

--
-- A tábla indexei `szereplok`
--
ALTER TABLE `szereplok`
  ADD PRIMARY KEY (`Cim`,`Szuletesi_datum`,`Nev`),
  ADD UNIQUE KEY `Szuletesi datum` (`Szuletesi_datum`,`Nev`);

--
-- A tábla indexei `vetit`
--
ALTER TABLE `vetit`
  ADD PRIMARY KEY (`Cim`,`Nev`),
  ADD KEY `Nev` (`Nev`);

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `csatorna`
--
ALTER TABLE `csatorna`
  ADD CONSTRAINT `csatorna_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `admin` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `epizodok`
--
ALTER TABLE `epizodok`
  ADD CONSTRAINT `epizodok_ibfk_1` FOREIGN KEY (`Cim`) REFERENCES `musor` (`Cim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `musor`
--
ALTER TABLE `musor`
  ADD CONSTRAINT `musor_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `admin` (`Email`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Megkötések a táblához `szereplok`
--
ALTER TABLE `szereplok`
  ADD CONSTRAINT `szereplok_ibfk_1` FOREIGN KEY (`Cim`) REFERENCES `musor` (`Cim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `vetit`
--
ALTER TABLE `vetit`
  ADD CONSTRAINT `Vetit` FOREIGN KEY (`Cim`) REFERENCES `musor` (`Cim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vetit_ibfk_1` FOREIGN KEY (`Nev`) REFERENCES `csatorna` (`Nev`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
