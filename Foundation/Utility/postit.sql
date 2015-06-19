-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Giu 19, 2015 alle 23:45
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `AggiornaPosizioneCartelle`(IN `pos` INT, IN `email_delete` VARCHAR(40))
UPDATE raccoglitore_cartelle SET posizione=posizione-1
WHERE posizione>pos AND email_utente = email_delete$$

DROP PROCEDURE IF EXISTS `AggiornaPosizioneNote`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AggiornaPosizioneNote`(IN `pos` INT, IN `cartella` INT)
UPDATE nota SET posizione=posizione-1
WHERE posizione>pos AND id_cartella = cartella$$

DROP PROCEDURE IF EXISTS `inserimentoRaccoglitoreCartella`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserimentoRaccoglitoreCartella`(IN `nuovoid` INT(11), IN `email_inserita` VARCHAR(40))
    NO SQL
begin
declare finito int default 0;
declare maxpos int;
declare cur1 cursor for select max(`raccoglitore_cartelle`.`posizione`) from `postit`.`raccoglitore_cartelle` where `raccoglitore_cartelle`.`email_utente` = email_inserita;
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET finito = 1;
open cur1;
fetch cur1 into maxpos;
if maxpos is null then
set maxpos = 0;
else
set maxpos=maxpos+1;
end if;
insert into `postit`.`raccoglitore_cartelle` (`raccoglitore_cartelle`.`id_cartella`,`raccoglitore_cartelle`.`email_utente`,`raccoglitore_cartelle`.`posizione`) values (nuovoid,email_inserita,maxpos);
end$$

DELIMITER ;

-- --------------------------------------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `cartella`:
--   `amministratore`
--       `utente` -> `email`
--

--
-- Trigger `cartella`
--
DROP TRIGGER IF EXISTS `inserimentoCartella`;
DELIMITER //
CREATE TRIGGER `inserimentoCartella` AFTER INSERT ON `cartella`
 FOR EACH ROW call inserimentoRaccoglitoreCartella(NEW.id,NEW.amministratore)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine`
--

DROP TABLE IF EXISTS `immagine`;
CREATE TABLE IF NOT EXISTS `immagine` (
  `id_nota` int(11) DEFAULT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `immagine_piccola` mediumblob NOT NULL,
  `immagine_media` mediumblob NOT NULL,
  `immagine_grande` mediumblob NOT NULL,
  `immagine_originale` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `immagine`:
--   `id_nota`
--       `nota` -> `id`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `posizione` int(11) NOT NULL
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
  `posizione` int(11) NOT NULL
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
 ADD PRIMARY KEY (`nome`), ADD KEY `id_nota` (`id_nota`);

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
 ADD PRIMARY KEY (`email`), ADD KEY `id_immagine` (`id_immagine`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartella`
--
ALTER TABLE `cartella`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=209;
--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `cartella`
--
ALTER TABLE `cartella`
ADD CONSTRAINT `cartella_ibfk_1` FOREIGN KEY (`amministratore`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `immagine`
--
ALTER TABLE `immagine`
ADD CONSTRAINT `immagine_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `nota` (`id`) ON DELETE CASCADE;

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
