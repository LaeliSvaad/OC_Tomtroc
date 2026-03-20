-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 20 mars 2026 à 17:32
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
('Moi Même', 13),
('Jesais Pas', 14),
('Blagui Blaguou', 16),
('Pierre Jacques', 17),
('Auteur Auteur', 18);

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
('Mon 1er livre', 13, 14),
('Le petit chaperon rouge', 14, 15),
('Une histoire drôle', 16, 17),
('Le petit chaperon rouge', 17, 18),
('Livre', 18, 19);

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
(14, 'assets/images/books//69bd84823375f4.01483005.jpg', 'Une oeuvre surréaliste édifiante', 'available', 15),
(15, 'assets/images/books/default-book-picture.png', 'Un conte pour enfants', 'available', 16),
(17, 'assets/images/books/default-book-picture.png', 'Histoire drôle!', 'available', 17),
(18, 'assets/images/books/default-book-picture.png', 'Un commentaire', 'reserved', 18),
(19, 'assets/images/books/default-book-picture.png', 'Commentaire commentaire', 'reserved', 19);

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
(28, 27, 39),
(29, 27, 40),
(27, 30, 41);

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
(15, 27, 13),
(16, 27, 14),
(17, 28, 15),
(18, 29, 16),
(19, 30, 17);

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
('Bonjour!', '2026-03-20 13:34:56', 1, 28, 39, 73),
('Votre livre \"Mon 1er livre\" est-il toujours disponible?', '2026-03-20 13:35:33', 1, 28, 39, 74),
('Bonjour! Je voudrais lire le petit chaperon rouge!', '2026-03-20 13:38:18', 1, 29, 40, 75),
('ok', '2026-03-20 13:39:14', 1, 27, 39, 76),
('bah toi aussi tu l\'as', '2026-03-20 13:39:24', 1, 27, 40, 77),
('Il est bien ce livre?', '2026-03-20 13:58:24', 1, 27, 41, 78),
('oui!', '2026-03-20 13:59:05', 0, 30, 41, 79);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `nickname` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(180) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `registration_date` datetime NOT NULL,
  `id` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`nickname`, `email`, `password`, `picture`, `registration_date`, `id`) VALUES
('Lisa', 'lisa.valade@hotmail.fr', '$2y$10$zn3B5VCc3qTC6a/YCzko9e6G0pqw3S1YcPtcvqhR0j8rBK090I8yq', 'assets/images/profile//69bd8415142e02.28160173.jpg', '2026-03-20 13:26:59', 27),
('Chaton', 'chat@chat.fr', '$2y$10$cqRmIRmLBMDuIlKfQqTu.e3RO2QjhceITnVvDsbm05ke./lnt7Jp.', 'assets/images/profile/default-profile-picture.png', '2026-03-20 13:32:33', 28),
('Vrai Grand Tigre', 'tigrou@tigrou.fr', '$2y$10$bSxdR4/..VTZsGmacJmPB.MsimBh5NGdXSkd4OW3xPQfSrMP6Ymsa', 'assets/images/profile/default-profile-picture.png', '2026-03-20 13:36:27', 29),
('Jeanine Leblanc', 'j@j.fr', '$2y$10$Nj21F0a7/5eMaU9lSRErIeGr4XmCOGfo1I15P/cctmRwScEOszp8y', 'assets/images/profile/default-profile-picture.png', '2026-03-20 13:57:06', 30);

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
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `book_data`
--
ALTER TABLE `book_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
