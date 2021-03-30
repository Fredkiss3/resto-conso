
-- --------------------------------------------------------

--
-- Structure de la table `operateur`
--

DROP TABLE IF EXISTS `operateur`;
CREATE TABLE IF NOT EXISTS `operateur` (
	`idOperateur` INT(11) NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(40) NOT NULL,
	`motDePasse` VARCHAR(40) NOT NULL,
	`photo` VARCHAR(100) NOT NULL DEFAULT 'Photos/photoAdmin/default.png',
	`personel` INT(11) NOT NULL,
	`profil` INT(11) NOT NULL DEFAULT '1',
	`site` INT(11) NOT NULL DEFAULT '1',
	`changePasse` TINYINT(4) NOT NULL DEFAULT '0',
	`bloquer` TINYINT(4) NOT NULL DEFAULT '0',
	`supprimer` TINYINT(4) NOT NULL DEFAULT '0',
	`dateCreation` INT(11) NOT NULL DEFAULT '2004',
	`dateSuppression` INT(11) NOT NULL DEFAULT '3000',
	PRIMARY KEY (`idOperateur`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=20
;


-- --------------------------------------------------------

--
-- Structure de la table `personel`
--
DROP TABLE IF EXISTS `personel`;
CREATE TABLE IF NOT EXISTS `personel` (
	`idPersonel` INT(11) NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(50) NOT NULL DEFAULT 'indefini',
	`prenoms` VARCHAR(100) NOT NULL DEFAULT 'indefini',
	`interventions` INT(11) NOT NULL DEFAULT '0',
	`civilite` INT(11) NOT NULL DEFAULT '1',
	`specialisation` INT(11) NOT NULL DEFAULT '1',
	`dateNaissance` VARCHAR(20) NOT NULL DEFAULT '01/01/2017',
	`lieuNaissance` VARCHAR(20) NOT NULL DEFAULT 'indefini',
	`genre` VARCHAR(10) NOT NULL DEFAULT 'indefini',
	`email` VARCHAR(50) NOT NULL DEFAULT 'indefini',
	`numeroTelephone` VARCHAR(25) NOT NULL,
	`numeroTelephoneDunProche` VARCHAR(25) NOT NULL DEFAULT 'indefini',
	`nationalite` INT(11) NOT NULL DEFAULT '1',
	`matricule` VARCHAR(25) NOT NULL DEFAULT 'indefini',
	`anneeAjout` VARCHAR(25) NOT NULL DEFAULT 'indefini',
	`dateAjout` VARCHAR(20) NOT NULL DEFAULT 'indefini',
	`anneDepart` VARCHAR(20) NOT NULL DEFAULT '3000',
	`dateDepart` VARCHAR(20) NOT NULL DEFAULT 'indefini',
	`photo` VARCHAR(100) NOT NULL DEFAULT 'Photos/photoAdmin/default.png',
	`services` INT(11) NOT NULL DEFAULT '1',
	PRIMARY KEY (`idPersonel`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=26
;


-- --------------------------------------------------------

--
-- Structure de la table `profil`
--
DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
	`idProfil` INT(11) NOT NULL AUTO_INCREMENT,
	`profil` VARCHAR(32) NOT NULL,
	`menu` VARCHAR(32) NOT NULL,
	`discriminant` TINYINT(4) NOT NULL DEFAULT '0',
	`hebergement` INT(11) NOT NULL DEFAULT '0',
	`supprimer` TINYINT(4) NOT NULL DEFAULT '0',
	`scolarite` INT(11) NOT NULL DEFAULT '0',
	`generale` INT(11) NOT NULL DEFAULT '0',
	`servicesocial` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`idProfil`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=11
;





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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
) ENGINE = InnoDB
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
--     ) ENGINE = InnoDB
--   AUTO_INCREMENT = 1
--   DEFAULT CHARSET = latin1;