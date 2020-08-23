-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

DROP TABLE IF EXISTS `repas`;
CREATE TABLE IF NOT EXISTS `repas`
(
    `idRepas`           int(11)     NOT NULL AUTO_INCREMENT,
    `libelle`           varchar(50) NOT NULL,
    `heureDebutSemaine` time        NOT NULL,
    `heureFinSemaine`   time        NOT NULL,
    `heureDebutWeekend` time        NOT NULL,
    `heureFinWeekend`   time        NOT NULL,
    `supprime`          boolean     NOT NULL DEFAULT 0,
    PRIMARY KEY (`idRepas`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Structure de la table `facturation`
--

DROP TABLE IF EXISTS `facturation`;
CREATE TABLE IF NOT EXISTS `facturation`
(
    `idFacturation` int(11)     NOT NULL AUTO_INCREMENT,
    `libelle`       varchar(50) NOT NULL,
    `supprime`      boolean     NOT NULL DEFAULT 0,
    PRIMARY KEY (`idFacturation`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;


-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

DROP TABLE IF EXISTS `prix`;
CREATE TABLE IF NOT EXISTS `prix`
(
    `idPrix`      int(11) NOT NULL AUTO_INCREMENT,
    `facturation` int(11) NOT NULL,
    `repas`       int(11) NOT NULL,
    `montant`     int(4)  NOT NULL,
    `actif`       boolean NOT NULL DEFAULT 1,
    `supprime`    boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (`idPrix`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Structure de la table `compteresto`
--

DROP TABLE IF EXISTS `compteresto`;
CREATE TABLE IF NOT EXISTS `compteresto`
(
    `idCompte`    int(11) NOT NULL AUTO_INCREMENT,
    `facturation` int(11) NOT NULL,
    `numeroCompte` varchar(12) UNIQUE NOT NULL,
    `etudiant`    int(11) NOT NULL,
    `version`     int(11) NOT NULL DEFAULT 1,
    `solde`       int(6)  NOT NULL DEFAULT 0,
    `actif`       boolean NOT NULL DEFAULT 1,
    `codeDeFacturation`   varchar(255) UNIQUE NOT NULL,
    `supprime`    boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (`idCompte`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Structure de la table `trimestre`
--

DROP TABLE IF EXISTS `trimestre`;
CREATE TABLE IF NOT EXISTS `trimestre`
(
    `idTrimestre`     int(11) NOT NULL AUTO_INCREMENT,
    `libelle`         varchar(50) NOT NULL, 
    `supprime`        boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (`idTrimestre`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Structure de la table `trimestre`
--

DROP TABLE IF EXISTS `trimestreannee`;
CREATE TABLE IF NOT EXISTS `trimestreannee`
(
    `idTrimestreAnnee`     int(11) NOT NULL AUTO_INCREMENT,
    `anneeacademique`      int(11) NOT NULL,
    `trimestre`            int(11) NOT NULL,
    `dateDebut`            date    NOT NULL,
    `dateFin`              date    NOT NULL,
    `supprime`             boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (`idTrimestreAnnee`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Structure de la table `consommation`
--

DROP TABLE IF EXISTS `consommation`;
CREATE TABLE IF NOT EXISTS `consommation`
(
    `idConsommation`    int(11)  NOT NULL AUTO_INCREMENT,
    `compteresto`       int(11)  NOT NULL,
    `cleinstallation`   int(11)  NOT NULL,
    `prix`              int(11)  NOT NULL,
    `trimestre`         int(11)  NOT NULL,
    `dateEtHeure`       datetime NOT NULL,
    `supprime`          boolean  NOT NULL DEFAULT 0,
    PRIMARY KEY (`idConsommation`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cleinstallation`
--

DROP TABLE IF EXISTS `cleinstallation`;
CREATE TABLE IF NOT EXISTS `cleinstallation`
(
    `idCleinstallation` int(11)     NOT NULL AUTO_INCREMENT,
    `operateur`         int(11)     NOT NULL,
    `cle`               varchar(10) NOT NULL,
    `actif`             boolean     NOT NULL DEFAULT 1,
    `supprime`          boolean     NOT NULL DEFAULT 0,
    PRIMARY KEY (`idCleinstallation`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;


-- --------------------------------------------------------

--
-- Structure de la table `recharge`
--

DROP TABLE IF EXISTS `recharge`;
CREATE TABLE IF NOT EXISTS `recharge`
(
    `idRecharge`      int(11)  NOT NULL AUTO_INCREMENT,
    `cleinstallation` int(11)  NOT NULL,
    `compteresto`     int(11)  NOT NULL,
    `montant`         int(6)   NOT NULL DEFAULT 0,
     -- -1 => annulé, 1 => validé, 0 => en cours
    `statut`          int(2)   NOT NULL DEFAULT 0, 
    `commentaireAnnulation`    varchar(255),
    `dateRequete`     datetime NOT NULL DEFAULT NOW(),
    `dateValidation`  datetime NOT NULL,
    `supprime`        boolean  NOT NULL DEFAULT 0,
    PRIMARY KEY (`idRecharge`)
) ENGINE = MyISAM
  AUTO_INCREMENT = 1
  DEFAULT CHARSET = latin1;


-- -- --------------------------------------------------------

-- --
-- -- Structure de la table `suivijournalier`
-- --

-- DROP TABLE IF EXISTS `suivijournalier`;
-- CREATE TABLE IF NOT EXISTS suivijournalier (
--     `idSuivi` int(11) NOT NULL AUTO_INCREMENT,
--      jourSuivi datetime NOT NULL DEFAULT NOW(),
--      temperatutre INT(11) NOT NULL DEFAULT 36,
--      fievre BOOLEAN NOT NULL DEFAULT FALSE,
--      toux BOOLEAN NOT NULL DEFAULT FALSE,
--      mauxGorge BOOLEAN NOT NULL DEFAULT FALSE,
--      difficulteAvaler BOOLEAN NOT NULL DEFAULT FALSE,
--      difficulteRespirer BOOLEAN NOT NULL DEFAULT FALSE,
--      mauxTete BOOLEAN NOT NULL DEFAULT FALSE,
--      yeuxRouges BOOLEAN NOT NULL DEFAULT FALSE,
--      perteAppetit BOOLEAN NOT NULL DEFAULT FALSE,
--      douleurAbdominales BOOLEAN NOT NULL DEFAULT FALSE,
--      vomissements BOOLEAN NOT NULL DEFAULT FALSE,
--      diarrhees BOOLEAN NOT NULL DEFAULT FALSE,
--      fatigueIntense BOOLEAN NOT NULL DEFAULT FALSE,
--      autres VARCHAR(255) DEFAULT NULL,
--      etudiant int(11) NOT NULL,
--      PRIMARY KEY (`idSuivi`)
--     ) ENGINE = MyISAM
--   AUTO_INCREMENT = 1
--   DEFAULT CHARSET = latin1;