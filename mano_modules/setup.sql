-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3307
-- Erstellungszeit: 06. Januar 2011 um 21:58
-- Server Version: 5.1.44
-- PHP-Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `mano_modules`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `namespace` varchar(100) NOT NULL,
  `fc_action` varchar(100) NOT NULL,
  `menu_template` varchar(100) NOT NULL,
  `content_template` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `modules`
--

INSERT INTO `modules` (`id`, `key`, `namespace`, `fc_action`, `menu_template`, `content_template`) VALUES
(1, 'news', 'mano::modules::news', 'NewsAction', 'navi', 'content');
