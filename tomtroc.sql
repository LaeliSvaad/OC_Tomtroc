-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 10 oct. 2025 à 09:48
-- Version du serveur : 5.7.44
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
                          `firstname` varchar(40) NOT NULL,
                          `lastname` varchar(40) NOT NULL,
                          `pseudo` varchar(40) DEFAULT NULL,
                          `id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`firstname`, `lastname`, `pseudo`, `id`) VALUES
                                                                   ('Friedrich', 'Nietzsche', NULL, 1),
                                                                   ('Donatien Alphonse François', 'de Sade', 'Marquis de Sade', 2);

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
                        `title` varchar(180) NOT NULL,
                        `author_id` smallint(5) UNSIGNED NOT NULL,
                        `id` smallint(5) UNSIGNED NOT NULL
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
                             `book_id` int(10) UNSIGNED NOT NULL,
                             `picture` varchar(180) NOT NULL,
                             `description` text NOT NULL,
                             `status` enum('not-available','reserved','available','') NOT NULL,
                             `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `book_data`
--

INSERT INTO `book_data` (`book_id`, `picture`, `description`, `status`, `id`) VALUES
                                                                                  (5, 'pictures/books/default-book-picture.png', 'Justine, ou les Malheurs de la vertu est un roman français du marquis de Sade publié de façon anonyme en 1791 à Paris, un an après que son auteur a été rendu à la liberté par la Révolution et l’abolition des lettres de cachet. ', 'available', 1),
                                                                                  (2, 'pictures/books/default-book-picture.png', 'Ainsi parlait Zarathoustra ou Ainsi parla Zarathoustra, sous-titré « Un livre pour tous et pour personne » (en allemand : Also sprach Zarathustra. Ein Buch für Alle und Keinen), est un poème philosophique de Friedrich Nietzsche, publié en plusieurs volumes entre 1883 et 1885. ', 'available', 2),
                                                                                  (2, 'pictures/books/default-book-picture.png', 'Un super Livre!!!!', 'available', 3),
                                                                                  (4, 'pictures/books/default-book-picture.png', 'un livre cool', 'available', 4),
                                                                                  (3, 'pictures/books/default-book-picture.png', 'Encore un livre cool', 'available', 5);

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
                                `user_1_id` smallint(5) UNSIGNED NOT NULL,
                                `user_2_id` smallint(5) UNSIGNED NOT NULL,
                                `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`user_1_id`, `user_2_id`, `id`) VALUES
                                                                (3, 4, 1),
                                                                (21, 3, 2),
                                                                (21, 22, 3),
                                                                (21, 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

CREATE TABLE `library` (
                           `book_data_id` smallint(5) UNSIGNED NOT NULL,
                           `user_id` smallint(5) UNSIGNED NOT NULL,
                           `id` smallint(5) UNSIGNED NOT NULL
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
                           `sender_id` smallint(5) UNSIGNED NOT NULL,
                           `conversation_id` int(10) UNSIGNED NOT NULL,
                           `id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`text`, `date`, `seen_by_recipient`, `sender_id`, `conversation_id`, `id`) VALUES
                                                                                                      ('Coucou', '2025-07-07 16:34:25', 1, 3, 1, 1),
                                                                                                      ('Coucou également!!', '2025-07-07 16:34:26', 1, 4, 1, 3),
                                                                                                      ('Hello hello', '2025-07-07 16:34:07', 1, 21, 2, 4),
                                                                                                      ('Hey hey', '2025-07-07 16:34:15', 1, 3, 2, 5),
                                                                                                      ('re', '2025-07-07 16:34:18', 1, 21, 2, 6),
                                                                                                      ('test hello', '2025-07-08 09:04:48', 1, 21, 3, 7),
                                                                                                      ('hé', '2025-07-08 09:05:02', 1, 22, 3, 8),
                                                                                                      ('Que veux-tu?', '2025-07-24 17:22:41', 1, 3, 1, 14),
                                                                                                      ('Je cherche des livres', '2025-07-24 17:23:29', 1, 4, 1, 15),
                                                                                                      ('ça tombe bien, j\'en ai plein', '2025-07-24 17:35:50', 1, 3, 1, 17),
('Ah c\'est cool!!!', '2025-07-24 17:38:58', 0, 4, 1, 18),
                                                                                                      ('Salut!', '2025-07-24 17:39:27', 1, 4, 5, 19),
                                                                                                      ('Salut!', '2025-07-24 17:40:02', 1, 21, 5, 20),
                                                                                                      ('ça va?', '2025-07-24 17:42:03', 0, 4, 5, 21);

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
                        `id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`nickname`, `email`, `password`, `picture`, `registration_date`, `id`) VALUES
                                                                                               ('Lisa', 'lisa.valade@hotmail.fr', '$2y$10$yPsMR0JaVuyZyhiP/aYTxeAEm2HwluGcZUGww2SHQUucwH6Ezn74u', 'pictures/profile/12189165_102066100420jhgjgfghfjhgjrutiuhj   68123_7059307546526205589  _n.jpg', '2025-07-09 07:15:06', 3),
                                                                                               ('Lisa2', 'lisa.valade@orange.fr', '$2y$10$Qo/QVwFyrnBtuY.LQYScsuv5IGHZTEZ7UHpzbLl.m0GhT3Ez.orFe', 'pictures/profile/img.jpg', '2025-06-04 00:00:00', 4),
                                                                                               ('LV', 'sdf@sdf.fr', '$2y$10$Qz1kZSQL95KyOsd3hfmOquYwwWwDzZKJQg7aMh2EjIzbaheLVJWFa', 'pictures/profile/default-profile-picture-2.png', '2025-06-20 00:00:00', 21),
                                                                                               ('testtest', 'test@sdf.fr', '$2y$10$Qz1kZSQL95KyOsd3hfmOquYwwWwDzZKJQg7aMh2EjIzbaheLVJWFa', 'pictures/profile/default-profile-picture.png', '2025-07-08 00:00:00', 22),
                                                                                               ('autre utilisateur', 'miaou@miaou.fr', '$2y$10$Qz1kZSQL95KyOsd3hfmOquYwwWwDzZKJQg7aMh2EjIzbaheLVJWFa', 'pictures/profile/default-profile-picture.png', '2025-07-11 08:23:41', 23);

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
    MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
    MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `book_data`
--
ALTER TABLE `book_data`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
    MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
    MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
