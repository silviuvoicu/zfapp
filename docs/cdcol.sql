-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 14 Noi 2011 la 15:44
-- Versiune server: 5.5.16
-- Versiune PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza de date: `cdcol`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `cds`
--

CREATE TABLE IF NOT EXISTS `cds` (
  `titel` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `interpret` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `jahr` year(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=18 ;

--
-- Salvarea datelor din tabel `cds`
--

INSERT INTO `cds` (`titel`, `interpret`, `jahr`, `user_id`, `id`) VALUES
('Black Beauty', 'Ryuichi Sakamoto', 2011, 2, 1),
('Goodbye Country (Hello Nightclub)', 'Groove Armada', 2000, 3, 4),
('Glee', 'Bran Van 2000', 2000, 3, 5),
('Sunny Side Up', 'Paolo Nutine', 2000, 2, 7),
('Lungs', 'Florence + The Machine', 2000, 2, 8),
('Heligoland', 'Massive Attack', 2000, 4, 9),
('Forever Vienna', 'Andre Rieu', 2000, 3, 10),
('Soldier of Love', 'Sade', 2011, 2, 11),
('What Matters Most', 'Barbra Streisand', 2000, 2, 13),
('4', 'Beyonce', 2000, 4, 14),
('Love me tender', 'Elvis Presley', 2000, 4, 15),
('get rich or die trin''', '50 cents', 2000, 2, 16);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `cd_comments`
--

CREATE TABLE IF NOT EXISTS `cd_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `cd_id` (`cd_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=67 ;

--
-- Salvarea datelor din tabel `cd_comments`
--

INSERT INTO `cd_comments` (`comment_id`, `cd_id`, `user_id`, `comment`) VALUES
(2, 1, 3, 'This is the comment form user username2 for beauty'),
(3, 9, 4, 'this is the commmet made by username3 for the Heligoland by Massive Attack'),
(4, 9, 3, 'This is the comment made by username2 for the Heligoland by Massive Attack'),
(5, 9, 2, 'This is the comment by username1 for the  Heligoland by Massive Attack'),
(6, 14, 4, 'This is the comment made by username3 for 4 Beyonce'),
(7, 14, 3, 'This is the comment made by username2 for 4 Beyonce'),
(8, 14, 2, 'This is the comment made by username1 for 4 Beyonce'),
(9, 14, 4, 'this is the comment number 2 made by username3'),
(10, 14, 2, 'this is the comment number 2 made by username1'),
(11, 14, 3, 'this is the comment number 2 made by username2'),
(12, 14, 3, 'this is the comment number 3 made by username2'),
(14, 1, 3, 'this is the comment no4 made by username2 for the Beauty'),
(15, 4, 2, 'this is the comment no1 made by username1 for the Goodbye Country (Hello Nightclub)'),
(16, 4, 3, 'this is the comment no2 made by username2 for the Goodbye Country (Hello Nightclub)'),
(17, 4, 2, 'this is the comment no3 made by username1 for the Goodbye Country (Hello Nightclub)'),
(18, 4, 3, 'this is the comment no4 made by username2 for the Goodbye Country (Hello Nightclub)'),
(20, 1, 4, 'this is comment no6 made by username3 for the Beauty'),
(21, 1, 3, 'this is comment no7 made by username2 for the Beauty'),
(22, 1, 2, 'this is comment no8 made by username1 for the Beauty bLAK  edition'),
(23, 4, 2, 'this is comment no5 made by username2 for the Goodbye Country (Hello Nightclub)'),
(24, 4, 3, 'this is comment no6 made by username3 for the Goodbye Country (Hello Nightclub)'),
(25, 4, 4, 'this is comment no7 made by username3 for the Goodbye Country (Hello Nightclub)'),
(26, 4, 2, 'this is comment no8 made by username1 for the Goodbye Country (Hello Nightclub)'),
(27, 15, 2, 'this is the comment no1 made by username1 for Love me tender'),
(28, 15, 3, 'this is the comment no2 made by username2 for Love me tender'),
(29, 15, 4, 'this is the comment no3 made by username3 for Love me tender'),
(31, 15, 3, 'this is the comment no5 made by username2 for Love me tender'),
(32, 5, 2, 'This is the comment no1 made by username1 online, not database made'),
(36, 5, 3, 'This is the comment no2 made by username2 online, not database made'),
(38, 5, 4, 'this comment no4 made by username 3'),
(40, 1, 2, 'this is another comment for black beauty edit version'),
(41, 1, 2, 'another new comment for black beauty'),
(42, 1, 2, 'one more'),
(43, 1, 2, 'second one more'),
(59, 1, 2, 'add new comment for Black beauty no secondpage'),
(60, 1, 2, 'second version add a new comment for black beauty no secondpage'),
(61, 1, 2, 'add new comment for black Beauty secondpage 5'),
(62, 1, 2, 'comment from 1 secondpage = no secondpage'),
(64, 1, 2, 'comment from secondpage6 for bb'),
(65, 1, 2, 'ADD COMM FOR SP 4NDNFCDS');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `salt` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `role` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT 'users',
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `active`, `code`, `password`, `salt`, `role`, `date_created`) VALUES
(1, 'admin', 'admin@admin.com', 1, '', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'administrators', '2011-08-08 17:05:05'),
(2, 'username1', 'username1@username1.com', 1, '', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'users', '2011-08-10 19:03:06'),
(3, 'username2', 'username2@username2.com', 1, '', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'users', '2011-08-23 15:36:01'),
(4, 'username3', 'username3@username3.com', 1, '', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'users', '2011-09-09 15:23:06');

--
-- Restrictii pentru tabele sterse
--

--
-- Restrictii pentru tabele `cds`
--
ALTER TABLE `cds`
  ADD CONSTRAINT `cds_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrictii pentru tabele `cd_comments`
--
ALTER TABLE `cd_comments`
  ADD CONSTRAINT `cd_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cd_comments_ibfk_2` FOREIGN KEY (`cd_id`) REFERENCES `cds` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
