-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 12 mars 2026 à 18:41
-- Version du serveur : 8.0.41
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `name` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`name`, `id`) VALUES
('Friedrich Nietzsche', 1),
('Donatien Alphonse François', 2);

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `title` varchar(180) NOT NULL,
  `author_id` smallint UNSIGNED NOT NULL,
  `id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`title`, `author_id`, `id`) VALUES
('Le gai savoir', 1, 1),
('Ainsi parlait Zarathoustra', 1, 2),
('La philosophie dans le boudoir', 2, 3),
('Généalogie de la morale', 1, 4),
('Justine ou les Malheurs de la vertu', 2, 5);

-- --------------------------------------------------------

--
-- Structure de la table `book_data`
--

CREATE TABLE `book_data` (
  `book_id` int UNSIGNED NOT NULL,
  `picture` varchar(180) NOT NULL,
  `description` text NOT NULL,
  `status` enum('not-available','reserved','available','') NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `book_data`
--

INSERT INTO `book_data` (`book_id`, `picture`, `description`, `status`, `id`) VALUES
(5, 'assets/images/books/default-book-picture.png', 'Justine, ou les Malheurs de la vertu est un roman français du marquis de Sade publié de façon anonyme en 1791 à Paris, un an après que son auteur a été rendu à la liberté par la Révolution et l’abolition des lettres de cachet. ', 'available', 1),
(2, 'assets/images/books/default-book-picture.png', 'Ainsi parlait Zarathoustra ou Ainsi parla Zarathoustra, sous-titré « Un livre pour tous et pour personne » (en allemand : Also sprach Zarathustra. Ein Buch für Alle und Keinen), est un poème philosophique de Friedrich Nietzsche, publié en plusieurs volumes entre 1883 et 1885. ', 'available', 2),
(2, 'assets/images/books/default-book-picture.png', 'Un super Livre!!!!', 'available', 3),
(4, 'assets/images/books/thumb_9030_magazineimage_desktop.jpeg', 'un livre cool !', 'available', 4),
(3, 'assets/images/books/default-book-picture.png', 'Encore un livre cool', 'available', 5);

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `user_1_id` smallint UNSIGNED NOT NULL,
  `user_2_id` smallint UNSIGNED NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`user_1_id`, `user_2_id`, `id`) VALUES
(3, 4, 38);

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

CREATE TABLE `library` (
  `book_data_id` smallint UNSIGNED NOT NULL,
  `user_id` smallint UNSIGNED NOT NULL,
  `id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`book_data_id`, `user_id`, `id`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 4, 3),
(4, 3, 4),
(5, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `seen_by_recipient` tinyint(1) NOT NULL DEFAULT '0',
  `sender_id` smallint UNSIGNED NOT NULL,
  `conversation_id` int UNSIGNED NOT NULL,
  `id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`text`, `date`, `seen_by_recipient`, `sender_id`, `conversation_id`, `id`) VALUES
('fgsdfsgf', '2025-10-21 12:48:51', 1, 3, 38, 58),
('test', '2025-10-21 12:49:07', 1, 4, 38, 59),
('test', '2025-10-21 12:49:15', 1, 4, 38, 60),
('tedfgdfg', '2025-10-21 12:49:49', 1, 3, 38, 61),
('tyry', '2025-10-21 12:50:02', 1, 4, 38, 62),
('hdfghdfghdfgh', '2025-10-21 12:52:51', 1, 4, 38, 63),
('fghdfgh', '2025-10-21 12:52:58', 1, 4, 38, 64),
('gfhdfgh', '2025-10-21 12:53:08', 0, 3, 38, 65),
('frereeererazdfsdf', '2026-03-12 13:04:59', 0, 3, 38, 66),
('traertae', '2026-03-12 13:05:09', 0, 3, 38, 67),
('fdsfsd', '2026-03-12 17:57:01', 0, 3, 38, 68),
('test', '2026-03-12 17:57:36', 0, 3, 38, 69);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `nickname` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(180) NOT NULL DEFAULT 'pictures/profile/default-profile-picture.png',
  `registration_date` datetime NOT NULL,
  `id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`nickname`, `email`, `password`, `picture`, `registration_date`, `id`) VALUES
('Lisa', 'lisa.valade@hotmail.fr', '$2y$10$NyHr4tBfASWy8FUwQB7l9O1ZxGobu8JnqekORp7wtW2tV1JxMjJV2', 'assets/images/profile/profil.jpg', '2025-07-09 07:15:06', 3),
('Lisa2', 'lisa.valade@orange.fr', '$2y$10$Qo/QVwFyrnBtuY.LQYScsuv5IGHZTEZ7UHpzbLl.m0GhT3Ez.orFe', 'assets/images/profile/img.jpg', '2025-06-04 00:00:00', 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `book_data`
--
ALTER TABLE `book_data`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `book_data`
--
ALTER TABLE `book_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
