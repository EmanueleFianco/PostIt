-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Giu 26, 2015 alle 00:35
-- Versione del server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u837991451_posti`
--


USE `u837991451_posti`;


--


--
-- Struttura della tabella `cartella`
--

DROP TABLE IF EXISTS `cartella`;
CREATE TABLE IF NOT EXISTS `cartella` (
`id` int(11) NOT NULL,
  `amministratore` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('gruppo','privata') COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `colore` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `cartella`:
--   `amministratore`
--       `utente` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine`
--

DROP TABLE IF EXISTS `immagine`;
CREATE TABLE IF NOT EXISTS `immagine` (
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `immagine_piccola` mediumblob NOT NULL,
  `immagine_media` mediumblob NOT NULL,
  `immagine_grande` mediumblob NOT NULL,
  `immagine_originale` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `nota`
--

DROP TABLE IF EXISTS `nota`;
CREATE TABLE IF NOT EXISTS `nota` (
`id` int(11) NOT NULL,
  `titolo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `testo` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `colore` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('nota','promemoria') COLLATE utf8_unicode_ci NOT NULL,
  `condiviso` tinyint(1) NOT NULL,
  `creata_da` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ultimo_a_modificare` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ora_data_avviso` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `nota`:
--   `creata_da`
--       `utente` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `raccoglitore_cartelle`
--

DROP TABLE IF EXISTS `raccoglitore_cartelle`;
CREATE TABLE IF NOT EXISTS `raccoglitore_cartelle` (
  `id_cartella` int(11) NOT NULL,
  `email_utente` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `posizione` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `raccoglitore_cartelle`:
--   `id_cartella`
--       `cartella` -> `id`
--   `email_utente`
--       `utente` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `raccoglitore_note`
--

DROP TABLE IF EXISTS `raccoglitore_note`;
CREATE TABLE IF NOT EXISTS `raccoglitore_note` (
  `id_nota` int(11) NOT NULL,
  `email_utente` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `id_cartella` int(11) NOT NULL,
  `posizione` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `raccoglitore_note`:
--   `id_nota`
--       `nota` -> `id`
--   `email_utente`
--       `utente` -> `email`
--   `id_cartella`
--       `cartella` -> `id`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

DROP TABLE IF EXISTS `utente`;
CREATE TABLE IF NOT EXISTS `utente` (
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `id_immagine` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cognome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `codice_attivazione` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `stato_attivazione` enum('attivato','nonattivato') COLLATE utf8_unicode_ci NOT NULL,
  `tipo_utente` enum('admin','normale') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `utente`:
--   `id_immagine`
--       `immagine` -> `nome`
--

--
-- Trigger `utente`
--
DROP TRIGGER IF EXISTS `DeleteImmagine`;
DELIMITER //
CREATE TRIGGER `DeleteImmagine` AFTER DELETE ON `utente`
 FOR EACH ROW DELETE FROM immagine where OLD.id_immagine = nome
//
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartella`
--
ALTER TABLE `cartella`
 ADD PRIMARY KEY (`id`), ADD KEY `amministratore` (`amministratore`);

--
-- Indexes for table `immagine`
--
ALTER TABLE `immagine`
 ADD PRIMARY KEY (`nome`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
 ADD PRIMARY KEY (`id`), ADD KEY `creata_da` (`creata_da`);

--
-- Indexes for table `raccoglitore_cartelle`
--
ALTER TABLE `raccoglitore_cartelle`
 ADD PRIMARY KEY (`id_cartella`,`email_utente`), ADD KEY `email_partecipante` (`email_utente`);

--
-- Indexes for table `raccoglitore_note`
--
ALTER TABLE `raccoglitore_note`
 ADD PRIMARY KEY (`id_nota`,`email_utente`), ADD KEY `email_partecipante` (`email_utente`), ADD KEY `id_cartella` (`id_cartella`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
 ADD PRIMARY KEY (`email`), ADD UNIQUE KEY `id_immagine` (`id_immagine`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartella`
--
ALTER TABLE `cartella`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=108;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `cartella`
--
ALTER TABLE `cartella`
ADD CONSTRAINT `cartella_ibfk_1` FOREIGN KEY (`amministratore`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `nota`
--
ALTER TABLE `nota`
ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`creata_da`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `raccoglitore_cartelle`
--
ALTER TABLE `raccoglitore_cartelle`
ADD CONSTRAINT `raccoglitore_cartelle_ibfk_1` FOREIGN KEY (`id_cartella`) REFERENCES `cartella` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `raccoglitore_cartelle_ibfk_2` FOREIGN KEY (`email_utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `raccoglitore_note`
--
ALTER TABLE `raccoglitore_note`
ADD CONSTRAINT `raccoglitore_note_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `nota` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `raccoglitore_note_ibfk_4` FOREIGN KEY (`email_utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `raccoglitore_note_ibfk_5` FOREIGN KEY (`id_cartella`) REFERENCES `cartella` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`id_immagine`) REFERENCES `immagine` (`nome`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
