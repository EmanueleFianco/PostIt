-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 27, 2015 alle 12:57
-- Versione del server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `postit`
--
CREATE DATABASE IF NOT EXISTS `postit` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `postit`;

-- --------------------------------------------------------

--
-- Struttura della tabella `cartella`
--

CREATE TABLE IF NOT EXISTS `cartella` (
`id` int(11) NOT NULL,
  `email_utente` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('gruppo','privata') COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `posizione` int(11) NOT NULL,
  `colore` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `cartella`:
--   `email_utente`
--       `utente` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `condividono`
--

CREATE TABLE IF NOT EXISTS `condividono` (
  `id_nota` int(11) NOT NULL,
  `email_utente` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `condividono`:
--   `id_nota`
--       `nota` -> `id`
--   `email_utente`
--       `partecipante` -> `email`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `nota`
--

CREATE TABLE IF NOT EXISTS `nota` (
`id` int(11) NOT NULL,
  `id_cartella` int(11) NOT NULL,
  `titolo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `testo` varchar(600) COLLATE utf8_unicode_ci NOT NULL,
  `immagine` text COLLATE utf8_unicode_ci NOT NULL,
  `posizione` int(11) NOT NULL,
  `colore` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('nota','promemoria') COLLATE utf8_unicode_ci NOT NULL,
  `condiviso` tinyint(1) NOT NULL,
  `ultimo_a_modificare` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ora_data_avviso` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELATIONS FOR TABLE `nota`:
--   `id_cartella`
--       `cartella` -> `id`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipano`
--

CREATE TABLE IF NOT EXISTS `partecipano` (
  `id_cartella` int(11) NOT NULL,
  `email_utente` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipante`
--

CREATE TABLE IF NOT EXISTS `partecipante` (
  `id_nota` int(11) NOT NULL,
  `id_cartella` int(11) NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `immagine` text COLLATE utf8_unicode_ci NOT NULL,
  `tipologia` enum('admin','partecipante','','') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE IF NOT EXISTS `utente` (
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `immagine` text COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cognome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `codice_attivazione` int(13) NOT NULL,
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
 ADD PRIMARY KEY (`id_nota`,`email_utente`), ADD KEY `email_utente` (`email_utente`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
 ADD PRIMARY KEY (`id`), ADD KEY `id_cartella` (`id_cartella`);

--
-- Indexes for table `partecipano`
--
ALTER TABLE `partecipano`
 ADD PRIMARY KEY (`id_cartella`,`email_utente`);

--
-- Indexes for table `partecipante`
--
ALTER TABLE `partecipante`
 ADD PRIMARY KEY (`email`), ADD KEY `id_nota` (`id_nota`,`id_cartella`), ADD KEY `id_nota_2` (`id_nota`), ADD KEY `id_cartella` (`id_cartella`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
ADD CONSTRAINT `condividono_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `nota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `condividono_ibfk_2` FOREIGN KEY (`email_utente`) REFERENCES `partecipante` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `nota`
--
ALTER TABLE `nota`
ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_cartella`) REFERENCES `cartella` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
