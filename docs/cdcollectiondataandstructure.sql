-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 09 Sep 2011 la 16:12
-- Versiune server: 5.5.8
-- Versiune PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Baza de date: `cdcol`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `cds`
--

CREATE TABLE IF NOT EXISTS `cds` (
  `titel` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `interpret` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `jahr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

--
-- Salvarea datelor din tabel `cds`
--

INSERT INTO `cds` (`titel`, `interpret`, `jahr`, `user_id`, `id`) VALUES
('Beauty', 'Ryuichi Sakamoto', 1990, 2, 1),
('Goodbye Country (Hello Nightclub)', 'Groove Armada', 2001, 3, 4),
('Glee', 'Bran Van 3000', 1997, 3, 5),
('Sunny Side Up', 'Paolo Nutine', 1976, 2, 7),
('Lungs', 'Florence + The Machine', 1980, 2, 8),
('Heligoland', 'Massive Attack', 1987, 4, 9),
('Forever Vienna', 'Andre Rieu', 2011, 3, 10),
('Soldier of Love', 'Sade', 2011, 2, 11),
('What Matters Most', 'Barbra Streisand', 2000, 2, 13),
('4', 'Beyonce', 2010, 4, 14),
('Love me tender', 'Elvis Presley', 1966, 4, 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Salvarea datelor din tabel `cd_comments`
--

INSERT INTO `cd_comments` (`comment_id`, `cd_id`, `user_id`, `comment`) VALUES
(1, 1, 2, 'This is the comment form user username1 for beauty'),
(2, 1, 3, 'This is the comment form user username2 for beauty'),
(3, 9, 4, 'this is the commmet made by username3 for the Heligoland by Massive Attack'),
(4, 9, 3, 'This is the comment made by username2 for the Heligoland by Massive Attack'),
(5, 9, 2, 'This is the comment by username1 for the  Heligoland by Massive Attack'),
(6, 14, 4, 'This is the comment made by username3 for 4 Beyonce'),
(7, 14, 3, 'This is the comment made by username2 for 4 Beyonce'),
(8, 14, 2, 'This is the comment made by username1 for 4 Beyonce');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `salt` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `role` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `date_created`) VALUES
(1, 'admin', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'administrators', '2011-08-08 17:05:05'),
(2, 'username1', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'users', '2011-08-10 19:03:06'),
(3, 'username2', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'users', '2011-08-23 15:36:01'),
(4, 'username3', 'cb3aefbdffbc81588f3d43c394428b16d4346b44', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'users', '2011-09-09 15:23:06');

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
  ADD CONSTRAINT `cd_comments_ibfk_2` FOREIGN KEY (`cd_id`) REFERENCES `cds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cd_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
