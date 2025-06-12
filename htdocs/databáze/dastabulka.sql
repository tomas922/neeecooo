-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Út 03.Jún 2025, 20:40
-- Verzia serveru: 10.4.32-MariaDB
-- Verzia PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `dastabulka`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `gamba_statistiky`
--

CREATE TABLE `gamba_statistiky` (
  `id` int(11) NOT NULL,
  `uzivatel_id` int(11) NOT NULL,
  `pocet_otoceni` int(11) DEFAULT 0,
  `posledni_otoceni` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `uzivatele`
--

CREATE TABLE `uzivatele` (
  `id` int(11) NOT NULL,
  `uzivatelske_jmeno` varchar(50) NOT NULL,
  `heslo` varchar(255) NOT NULL,
  `datum_registrace` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Sťahujem dáta pre tabuľku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `uzivatelske_jmeno`, `heslo`, `datum_registrace`) VALUES
(1, 'test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-06-03 20:28:10'),
(2, 'tomastomas', '$2y$10$7BVTzIYco3HSxU5W0u4l1uFofJtwcJirkLJWdTO1xBX5ARAAKHLGG', '2025-06-03 20:28:21');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `uzivatel_pokemon`
--

CREATE TABLE `uzivatel_pokemon` (
  `id` int(11) NOT NULL,
  `uzivatel_id` int(11) NOT NULL,
  `pokemon_id` int(11) NOT NULL,
  `pokemon_jmeno` varchar(100) NOT NULL,
  `datum_ziskani` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `gamba_statistiky`
--
ALTER TABLE `gamba_statistiky`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzivatel_id` (`uzivatel_id`);

--
-- Indexy pre tabuľku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uzivatelske_jmeno` (`uzivatelske_jmeno`);

--
-- Indexy pre tabuľku `uzivatel_pokemon`
--
ALTER TABLE `uzivatel_pokemon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uzivatel_pokemon` (`uzivatel_id`,`pokemon_id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `gamba_statistiky`
--
ALTER TABLE `gamba_statistiky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pre tabuľku `uzivatel_pokemon`
--
ALTER TABLE `uzivatel_pokemon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `gamba_statistiky`
--
ALTER TABLE `gamba_statistiky`
  ADD CONSTRAINT `gamba_statistiky_ibfk_1` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE;

--
-- Obmedzenie pre tabuľku `uzivatel_pokemon`
--
ALTER TABLE `uzivatel_pokemon`
  ADD CONSTRAINT `uzivatel_pokemon_ibfk_1` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
