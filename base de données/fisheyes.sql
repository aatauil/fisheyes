-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 06 nov. 2019 à 11:50
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fisheyes`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL,
  `date_order` datetime NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `id_users` varchar(255) NOT NULL,
  `id_movies` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date_commentaire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `id_users`, `id_movies`, `comment`, `date_commentaire`) VALUES
(119, '222', '290859', 'aaaaa', '2019-11-02 15:29:02'),
(120, '222', '475557', 'jkgggggg', '2019-11-02 15:29:50'),
(121, '222', '290859', 'ok', '2019-11-02 15:30:09'),
(122, '222', '568012', 'eeet', '2019-11-02 15:30:41'),
(123, '222', '920', 'nil', '2019-11-02 15:33:21'),
(124, '222', '559969', 'd', '2019-11-02 15:44:29'),
(125, '222', '475557', 'jkgggggg', '2019-11-02 15:53:12'),
(126, '222', '475557', 'jkgggggg', '2019-11-02 15:53:52');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `username` tinytext NOT NULL,
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `password` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `id`, `email`, `password`) VALUES
('123', 1, '123@gmail.com', '$2y$10$2vKiLO3C2fL.d9PWnwEIA.9XqVDpFzxSOoOaT79rkX7kF2EqtN4wG'),
('aaa', 2, 'aaa@gmail.com', '$2y$10$xX9aKzLXUgoeelQ2l6CGueKt0Xav4xF9c9WzIxYH4/.T7dUAxgKsm'),
('ccc', 3, 'ccc@gmail.com', '$2y$10$SxrFCFPhpj2SPz25u88YqOrGsl4AiY8tPfjgDv.n2ZPgTX29gdvPC'),
('ddd', 4, 'ddd@gmail.com', '$2y$10$klgJ8nMhUmUZH41zLYD3muq684D6cwJthvunKznEMuwuljlcAl9AO'),
('www', 5, 'www@gmail.com', '$2y$10$pv3zXTWNrqcvlPxTX4QwvOUwJUzmEN9KZDJmS9ZdUI55Fkq5GZSJy'),
('222', 6, '222@gmail.com', '$2y$10$LayZBkEbAsSSCoI7EnZplOFuwyclZbKnGVv5nI9jr3nULZA24uKNu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `iduser` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
