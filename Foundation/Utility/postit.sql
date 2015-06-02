-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Giu 02, 2015 alle 17:54
-- Versione del server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `postit`
--
DROP DATABASE IF EXISTS `postit`;
CREATE DATABASE IF NOT EXISTS `postit` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `postit`;

DELIMITER $$
--
-- Procedure
--
DROP PROCEDURE IF EXISTS `AggiornaPosizioneCartelle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AggiornaPosizioneCartelle`(pos INT)
UPDATE cartella SET posizione=posizione-1
WHERE posizione>pos$$

DROP PROCEDURE IF EXISTS `AggiornaPosizioneNote`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AggiornaPosizioneNote`(IN `pos` INT)
UPDATE nota SET posizione=posizione-1
WHERE posizione>pos$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `cartella`
--

DROP TABLE IF EXISTS `cartella`;
CREATE TABLE IF NOT EXISTS `cartella` (
`id` int(11) NOT NULL,
  `email_utente` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` enum('gruppo','privata') COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `posizione` int(11) NOT NULL,
  `colore` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `cartella`:
--   `email_utente`
--       `utente` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `condividono`
--

DROP TABLE IF EXISTS `condividono`;
CREATE TABLE IF NOT EXISTS `condividono` (
  `id_nota` int(11) NOT NULL,
  `email_partecipante` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `condividono`:
--   `id_nota`
--       `nota` -> `id`
--   `email_partecipante`
--       `partecipante` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `nota`
--

DROP TABLE IF EXISTS `nota`;
CREATE TABLE IF NOT EXISTS `nota` (
`id` int(11) NOT NULL,
  `id_cartella` int(11) NOT NULL,
  `titolo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `testo` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `immagine` text COLLATE utf8_unicode_ci NOT NULL,
  `posizione` int(11) NOT NULL,
  `colore` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('nota','promemoria') COLLATE utf8_unicode_ci NOT NULL,
  `condiviso` tinyint(1) NOT NULL,
  `ultimo_a_modificare` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ora_data_avviso` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3823 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `nota`:
--   `id_cartella`
--       `cartella` -> `id`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipano`
--

DROP TABLE IF EXISTS `partecipano`;
CREATE TABLE IF NOT EXISTS `partecipano` (
  `id_cartella` int(11) NOT NULL,
  `email_partecipante` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `partecipano`:
--   `id_cartella`
--       `cartella` -> `id`
--   `email_partecipante`
--       `partecipante` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipante`
--

DROP TABLE IF EXISTS `partecipante`;
CREATE TABLE IF NOT EXISTS `partecipante` (
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `immagine` text COLLATE utf8_unicode_ci NOT NULL,
  `tipologia` enum('admin','partecipante') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

DROP TABLE IF EXISTS `utente`;
CREATE TABLE IF NOT EXISTS `utente` (
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `immagine` text COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cognome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `codice_attivazione` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `stato_attivazione` enum('attivato','nonattivato') COLLATE utf8_unicode_ci NOT NULL,
  `tipo_utente` enum('admin','normale') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartella`
--
ALTER TABLE `cartella`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `posizione` (`posizione`), ADD UNIQUE KEY `email_utente` (`email_utente`);

--
-- Indexes for table `condividono`
--
ALTER TABLE `condividono`
 ADD PRIMARY KEY (`id_nota`,`email_partecipante`), ADD KEY `email_partecipante` (`email_partecipante`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
 ADD PRIMARY KEY (`id`), ADD KEY `id_cartella` (`id_cartella`);

--
-- Indexes for table `partecipano`
--
ALTER TABLE `partecipano`
 ADD PRIMARY KEY (`id_cartella`,`email_partecipante`), ADD KEY `email_partecipante` (`email_partecipante`);

--
-- Indexes for table `partecipante`
--
ALTER TABLE `partecipante`
 ADD PRIMARY KEY (`email`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
 ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartella`
--
ALTER TABLE `cartella`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3823;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `cartella`
--
ALTER TABLE `cartella`
ADD CONSTRAINT `cartella_ibfk_1` FOREIGN KEY (`email_utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `condividono`
--
ALTER TABLE `condividono`
ADD CONSTRAINT `condividono_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `nota` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `condividono_ibfk_2` FOREIGN KEY (`email_partecipante`) REFERENCES `partecipante` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `nota`
--
ALTER TABLE `nota`
ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_cartella`) REFERENCES `cartella` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `partecipano`
--
ALTER TABLE `partecipano`
ADD CONSTRAINT `partecipano_ibfk_1` FOREIGN KEY (`id_cartella`) REFERENCES `cartella` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `partecipano_ibfk_2` FOREIGN KEY (`email_partecipante`) REFERENCES `partecipante` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
