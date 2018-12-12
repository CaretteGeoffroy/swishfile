-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 11 Décembre 2018 à 20:50
-- Version du serveur :  10.3.11-MariaDB-1:10.3.11+maria~bionic
-- Version de PHP :  7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `TRANSFER_DB`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_ext` varchar(255) NOT NULL,
  `file_key` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `files_downloaded`
--

CREATE TABLE `files_downloaded` (
  `files_id` int(4) NOT NULL,
  `user_download_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `files_uploaded`
--

CREATE TABLE `files_uploaded` (
  `files_id` int(4) NOT NULL,
  `user_upload_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_download`
--

CREATE TABLE `user_download` (
  `id` int(11) NOT NULL,
  `mail_receiver` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `download_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_download`
--

INSERT INTO `user_download` (`id`, `mail_receiver`, `download_date`) VALUES
(1, 'abdelkrim.n@codeur.online', '2018-12-11 08:29:00'),
(2, 'valerie.h@codeur.online', '2018-12-11 15:23:35');

-- --------------------------------------------------------

--
-- Structure de la table `user_upload`
--

CREATE TABLE `user_upload` (
  `id` int(11) NOT NULL,
  `mail_sender` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `message` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_upload`
--

INSERT INTO `user_upload` (`id`, `mail_sender`, `upload_date`, `message`) VALUES
(1, 'valerie.h@codeur.online', '2018-12-10 12:40:00', ''),
(2, 'abdelkrim.n@codeur.online', '2018-12-10 21:44:12', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_download`
--
ALTER TABLE `user_download`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_upload`
--
ALTER TABLE `user_upload`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user_download`
--
ALTER TABLE `user_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user_upload`
--
ALTER TABLE `user_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
