SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `oneclass`
--

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `IMPORTANT` tinyint(1) NOT NULL,
  `AUTEUR` varchar(255) NOT NULL,
  `DATE` date NOT NULL,
  `TEXTE` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `news`
--

INSERT INTO `news` (`ID`, `IMPORTANT`, `AUTEUR`, `DATE`, `TEXTE`) VALUES
(2, 1, 'admin', '2018-01-08', 'Bonne annÃ©e !');

-- --------------------------------------------------------

--
-- Structure de la table `playlists`
--

CREATE TABLE `playlists` (
  `ID` int(11) NOT NULL,
  `AUTEUR` varchar(255) NOT NULL,
  `TITRE` text NOT NULL,
  `GENRE` text NOT NULL,
  `URL1` text NOT NULL,
  `URL2` text NOT NULL,
  `URL3` text NOT NULL,
  `URL4` text NOT NULL,
  `URL5` text NOT NULL,
  `URL6` text NOT NULL,
  `URL7` text NOT NULL,
  `URL8` text NOT NULL,
  `URL9` text NOT NULL,
  `URL10` text NOT NULL,
  `URL11` text NOT NULL,
  `URL12` text NOT NULL,
  `URL13` text NOT NULL,
  `URL14` text NOT NULL,
  `URL15` text NOT NULL,
  `DATE` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `playlists`
--

INSERT INTO `playlists` (`ID`, `AUTEUR`, `TITRE`, `GENRE`, `URL1`, `URL2`, `URL3`, `URL4`, `URL5`, `URL6`, `URL7`, `URL8`, `URL9`, `URL10`, `URL11`, `URL12`, `URL13`, `URL14`, `URL15`, `DATE`) VALUES
(1, 'eleve', 'Ma super playlist', 'Electro', 'D5drYkLiLI8', 'Cbvqv19Nf0E', 'g7foL-TjoFA', 'k_0a3Dsih3A', '', '', '', '', '', '', '', '', '', '', '', '2018-01-07');

-- --------------------------------------------------------

--
-- Structure de la table `signalements`
--

CREATE TABLE `signalements` (
  `ID` int(11) NOT NULL,
  `TYPE` varchar(255) NOT NULL,
  `AUTEUR` varchar(255) NOT NULL,
  `IDN` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `ID` int(11) NOT NULL,
  `LOGIN` varchar(255) NOT NULL,
  `AUTORISATIONS` varchar(255) NOT NULL,
  `PASSWORD` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID`, `LOGIN`, `AUTORISATIONS`, `PASSWORD`) VALUES
(1, 'admin', 'ADMIN', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(2, 'eleve', 'ELEVE', '0e9a7fdc4821370a252df21582a4a656e81e0687');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `signalements`
--
ALTER TABLE `signalements`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `signalements`
--
ALTER TABLE `signalements`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
