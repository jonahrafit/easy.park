-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 20 juil. 2022 à 08:15
-- Version du serveur : 8.0.25
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eval_easy_park`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `view_etat_place` (IN `daty` DATETIME)  BEGIN
select p.id as idplacee , tt.* , v.immatriculation ,
    timediff(tt.deadline , daty) as rebours, 
    HOUR(timediff(tt.deadline , daty)) as heure_rebours, 
    MINUTE(timediff(tt.deadline , daty)) as minute_rebours, 
    case when (timediff(tt.deadline , daty) < 0 ) then '100000' end as amende, 
    case 
        when (tt.idplace is not null and (timediff(tt.deadline , daty) >= 0 ) ) then 'OCCUPE' 
	    when (tt.idplace is not null and  (timediff(tt.deadline , daty) < 0 ) )  then 'INFRACT'
        when (select statut from place where id = p.id) = 'KO' then 'INDISP'
	    else 'LIBRE' end as statut 
from 
(
SELECT pv.id as idplace_voiture, pv.idplace  ,pv.idvoiture , pv.datetimedebut , pv.cout , pv.heure_tarif , pv.minute_tarif,
    case 
        when (TIME(pv.datetimedebut) >= time('6:00:00') and TIME(pv.datetimedebut) < time('8:00:00')) then (pv.cout - (pv.cout * 15 /100))
        when (TIME(pv.datetimedebut) >= time('12:00:00') and TIME(pv.datetimedebut) < time('14:00:00')) then (pv.cout + (pv.cout * 10 /100))
        when (TIME(pv.datetimedebut) >= time('18:00:00') and TIME(pv.datetimedebut) <= time('23:59:00')) 
            or (TIME(pv.datetimedebut) >= time('00:00:00') and TIME(pv.datetimedebut) < time('6:00:00')) 
            then 
            (  select tar.cout from tarif tar 
                where time_to_sec(time(concat(tar.heure,':',tar.minute,':00'))) >= abs(time_to_sec(timediff(time(concat(pv.heure_tarif,':',pv.minute_tarif,':00')) ,'01:00:00')))
                order by time(concat(tar.heure,':',tar.minute,':00')) limit 1 )
        else pv.cout
        end as cout_final,
    case 
        when (TIME(pv.datetimedebut) >= time('6:00:00') and TIME(pv.datetimedebut) < time('8:00:00')) then '15'
        end as remise,
    case 
        when (TIME(pv.datetimedebut) >= time('18:00:00') and TIME(pv.datetimedebut) <= time('23:59:00')) 
            or (TIME(pv.datetimedebut) >= time('00:00:00') and TIME(pv.datetimedebut) < time('6:00:00')) 
            then addtime(addtime(pv.datetimedebut, concat(pv.heure_tarif,':',pv.minute_tarif,':',00)) , time('1:00:00'))
        else addtime(pv.datetimedebut, concat(pv.heure_tarif,':',pv.minute_tarif,':',00)) 
        end as deadline
    FROM place_voiture pv WHERE (datetimedebut <= daty and datetimesortie >= daty) 
    OR (datetimedebut <= daty and datetimesortie IS NULL)
) as tt join voiture v on tt.idvoiture = v.id
    right join place p on tt.idplace = p.id ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_situation_praking` (IN `daty` DATETIME)  BEGIN
select tt.* , v.immatriculation , case when (timediff(tt.deadline , daty) < 0 ) then '100000' end as amende 
from stat_de_parking as tt 
	join voiture v on tt.idvoiture = v.id
    where (datetimesortie is null) or (datetimesortie > date_sub(daty,interval 1 day));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `idcompte` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `idcompte`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `amende`
--

CREATE TABLE `amende` (
  `id` int NOT NULL,
  `immatriculation` varchar(15) DEFAULT NULL,
  `amende` decimal(10,2) DEFAULT NULL,
  `statut_payer` varchar(3) DEFAULT 'NON',
  `daty` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id` int NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `mdp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id`, `nom`, `prenom`, `login`, `mdp`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(7, 'Client1', 'Test1', 'client1@test.com', 'd642fef420c5baa4c72f53de9426f1ed699899e2'),
(8, 'Client2', 'test2', 'client2@test.com', '0cf3a452af4baf920c5e381be5f542007639a275');

-- --------------------------------------------------------

--
-- Structure de la table `datenow`
--

CREATE TABLE `datenow` (
  `daty` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `datenow`
--

INSERT INTO `datenow` (`daty`) VALUES
('2022-07-20 09:14:00');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `mouvement_parking`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `mouvement_parking` (
`idplace_voiture` int
,`idplace` int
,`idvoiture` int
,`immatriculation` varchar(15)
,`datetimedebut` datetime
,`cout` decimal(10,2)
,`duree` varchar(26)
,`deadline` datetime(6)
);

-- --------------------------------------------------------

--
-- Structure de la table `parking`
--

CREATE TABLE `parking` (
  `id` int NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `parking`
--

INSERT INTO `parking` (`id`, `nom`) VALUES
(1, 'EASY PARK');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `id` int NOT NULL,
  `idcompte` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `immatriculation` varchar(15) DEFAULT NULL,
  `daty` datetime DEFAULT NULL,
  `provenance` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `payement`
--

INSERT INTO `payement` (`id`, `idcompte`, `montant`, `immatriculation`, `daty`, `provenance`) VALUES
(17, 7, '15000.00', '1234 TAB', '2022-07-20 08:00:00', ''),
(18, 7, '3000.00', '3456 TBB', '2022-07-20 08:47:00', ''),
(19, 8, '15000.00', '3678 TAD', '2022-07-20 09:13:00', ''),
(20, 8, '22500.00', '1498 TAF', '2022-07-20 10:10:00', ''),
(21, 7, '22500.00', '4444 TAA', '2022-07-20 07:15:00', ''),
(22, 7, '15000.00', '5555 TAA', '2022-07-20 12:15:00', ''),
(23, 7, '22500.00', '6666 TAA', '2022-07-20 23:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

CREATE TABLE `place` (
  `id` int NOT NULL,
  `idparking` int DEFAULT NULL,
  `statut` varchar(2) NOT NULL DEFAULT 'OK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `place`
--

INSERT INTO `place` (`id`, `idparking`, `statut`) VALUES
(1, 1, 'OK'),
(2, 1, 'OK'),
(3, 1, 'OK'),
(4, 1, 'OK'),
(5, 1, 'OK'),
(6, 1, 'OK'),
(7, 1, 'OK'),
(8, 1, 'OK'),
(9, 1, 'OK'),
(10, 1, 'OK'),
(11, 1, 'OK'),
(12, 1, 'OK'),
(13, 1, 'OK'),
(14, 1, 'OK'),
(15, 1, 'OK'),
(16, 1, 'KO'),
(17, 1, 'OK'),
(18, 1, 'OK'),
(19, 1, 'OK'),
(20, 1, 'OK');

-- --------------------------------------------------------

--
-- Structure de la table `place_voiture`
--

CREATE TABLE `place_voiture` (
  `id` int NOT NULL,
  `idplace` int DEFAULT NULL,
  `idvoiture` int DEFAULT NULL,
  `datetimedebut` datetime DEFAULT NULL,
  `cout` decimal(10,2) DEFAULT NULL,
  `statut` varchar(3) DEFAULT NULL,
  `heure_tarif` int DEFAULT NULL,
  `minute_tarif` int DEFAULT NULL,
  `datetimesortie` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `place_voiture`
--

INSERT INTO `place_voiture` (`id`, `idplace`, `idvoiture`, `datetimedebut`, `cout`, `statut`, `heure_tarif`, `minute_tarif`, `datetimesortie`) VALUES
(87, 1, 25, '2022-07-20 08:15:00', '15000.00', 'OUT', 1, 0, '2022-07-20 09:10:00'),
(88, 2, 26, '2022-07-20 08:47:00', '3000.00', 'IN', 0, 15, NULL),
(89, 3, 27, '2022-07-20 09:13:00', '15000.00', 'IN', 1, 0, NULL),
(90, 7, 28, '2022-07-20 10:10:00', '22500.00', 'IN', 2, 0, NULL),
(91, 5, 29, '2022-07-20 07:15:00', '22500.00', 'IN', 2, 0, NULL),
(92, 6, 30, '2022-07-20 12:15:00', '15000.00', 'IN', 1, 0, NULL),
(93, 8, 31, '2022-07-20 23:00:00', '22500.00', 'IN', 2, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `portefeuille`
--

CREATE TABLE `portefeuille` (
  `id` int NOT NULL,
  `idcompte` int DEFAULT NULL,
  `isvalider` varchar(10) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_recharge` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `portefeuille`
--

INSERT INTO `portefeuille` (`id`, `idcompte`, `isvalider`, `montant`, `date_recharge`) VALUES
(28, 7, 'OUI', '20000.00', '2022-07-20 08:00:00'),
(29, 8, 'OUI', '40000.00', '2022-07-20 08:00:00'),
(30, 7, 'OUI', '100000.00', '2022-07-20 09:14:00'),
(31, 8, 'OUI', '15000.00', '2022-07-20 09:14:00'),
(32, 8, 'OUI', '50000.00', '2022-07-20 09:14:00');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `stat_de_parking`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `stat_de_parking` (
`idplace_voiture` int
,`idplace` int
,`idvoiture` int
,`datetimedebut` datetime
,`cout` decimal(10,2)
,`heure_tarif` int
,`minute_tarif` int
,`datetimesortie` datetime
,`cout_final` decimal(17,6)
,`remise` varchar(2)
,`deadline` datetime(6)
);

-- --------------------------------------------------------

--
-- Structure de la table `tarif`
--

CREATE TABLE `tarif` (
  `id` int NOT NULL,
  `heure` int DEFAULT NULL,
  `minute` int DEFAULT NULL,
  `cout` decimal(10,2) DEFAULT NULL,
  `idparking` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tarif`
--

INSERT INTO `tarif` (`id`, `heure`, `minute`, `cout`, `idparking`) VALUES
(13, 0, 15, '3000.00', NULL),
(14, 0, 30, '7000.00', NULL),
(15, 1, 0, '15000.00', NULL),
(16, 2, 0, '22500.00', NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_solde`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `view_solde` (
`id` int
,`nom` varchar(50)
,`prenom` varchar(50)
,`recharge` decimal(32,2)
,`payement` decimal(32,2)
,`solde` decimal(33,2)
);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int NOT NULL,
  `immatriculation` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id`, `immatriculation`) VALUES
(25, '1234 TAB'),
(26, '3456 TBB'),
(27, '3678 TAD'),
(28, '1498 TAF'),
(29, '4444 TAA'),
(30, '5555 TAA'),
(31, '6666 TAA');

-- --------------------------------------------------------

--
-- Structure de la vue `mouvement_parking`
--
DROP TABLE IF EXISTS `mouvement_parking`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mouvement_parking`  AS SELECT `pv`.`id` AS `idplace_voiture`, `pv`.`idplace` AS `idplace`, `pv`.`idvoiture` AS `idvoiture`, `v`.`immatriculation` AS `immatriculation`, `pv`.`datetimedebut` AS `datetimedebut`, `pv`.`cout` AS `cout`, concat(`pv`.`heure_tarif`,':',`pv`.`minute_tarif`,':',0) AS `duree`, addtime(`pv`.`datetimedebut`,concat(`pv`.`heure_tarif`,':',`pv`.`minute_tarif`,':',0)) AS `deadline` FROM (`place_voiture` `pv` join `voiture` `v` on((`pv`.`idvoiture` = `v`.`id`))) ORDER BY `pv`.`id` DESC ;

-- --------------------------------------------------------

--
-- Structure de la vue `stat_de_parking`
--
DROP TABLE IF EXISTS `stat_de_parking`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stat_de_parking`  AS SELECT `pv`.`id` AS `idplace_voiture`, `pv`.`idplace` AS `idplace`, `pv`.`idvoiture` AS `idvoiture`, `pv`.`datetimedebut` AS `datetimedebut`, `pv`.`cout` AS `cout`, `pv`.`heure_tarif` AS `heure_tarif`, `pv`.`minute_tarif` AS `minute_tarif`, `pv`.`datetimesortie` AS `datetimesortie`, (case when ((cast(`pv`.`datetimedebut` as time) >= cast('6:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) < cast('8:00:00' as time))) then (`pv`.`cout` - ((`pv`.`cout` * 15) / 100)) when ((cast(`pv`.`datetimedebut` as time) >= cast('12:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) < cast('14:00:00' as time))) then (`pv`.`cout` + ((`pv`.`cout` * 10) / 100)) when (((cast(`pv`.`datetimedebut` as time) >= cast('18:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) <= cast('23:59:00' as time))) or ((cast(`pv`.`datetimedebut` as time) >= cast('00:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) < cast('6:00:00' as time)))) then (select `tar`.`cout` from `tarif` `tar` where (time_to_sec(cast(concat(`tar`.`heure`,':',`tar`.`minute`,':00') as time(6))) >= abs(time_to_sec(timediff(cast(concat(`pv`.`heure_tarif`,':',`pv`.`minute_tarif`,':00') as time(6)),'01:00:00')))) order by cast(concat(`tar`.`heure`,':',`tar`.`minute`,':00') as time(6)) limit 1) else `pv`.`cout` end) AS `cout_final`, (case when ((cast(`pv`.`datetimedebut` as time) >= cast('6:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) < cast('8:00:00' as time))) then '15' end) AS `remise`, (case when (((cast(`pv`.`datetimedebut` as time) >= cast('18:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) <= cast('23:59:00' as time))) or ((cast(`pv`.`datetimedebut` as time) >= cast('00:00:00' as time)) and (cast(`pv`.`datetimedebut` as time) < cast('6:00:00' as time)))) then addtime(addtime(`pv`.`datetimedebut`,concat(`pv`.`heure_tarif`,':',`pv`.`minute_tarif`,':',0)),cast('1:00:00' as time)) else addtime(`pv`.`datetimedebut`,concat(`pv`.`heure_tarif`,':',`pv`.`minute_tarif`,':',0)) end) AS `deadline` FROM `place_voiture` AS `pv` ORDER BY `pv`.`id` DESC ;

-- --------------------------------------------------------

--
-- Structure de la vue `view_solde`
--
DROP TABLE IF EXISTS `view_solde`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_solde`  AS SELECT `c`.`id` AS `id`, `c`.`nom` AS `nom`, `c`.`prenom` AS `prenom`, coalesce(`tt`.`recharge`,0) AS `recharge`, coalesce(`tt`.`payement`,0) AS `payement`, (coalesce(`tt`.`recharge`,0) - coalesce(`tt`.`payement`,0)) AS `solde` FROM (`compte` `c` left join (select `c`.`id` AS `id`,(select coalesce(sum(`p`.`montant`),0) from `portefeuille` `p` where ((`p`.`idcompte` = `c`.`id`) and `p`.`idcompte` in (select `admin`.`idcompte` from `admin`) is false and (`p`.`isvalider` = 'OUI'))) AS `recharge`,(select coalesce(sum(`pa`.`montant`),0) from `payement` `pa` where (`pa`.`idcompte` = `c`.`id`)) AS `payement` from `compte` `c`) `tt` on((`tt`.`id` = `c`.`id`))) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_admin_idcompte` (`idcompte`);

--
-- Index pour la table `amende`
--
ALTER TABLE `amende`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payement_compte` (`idcompte`);

--
-- Index pour la table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_place_parking` (`idparking`);

--
-- Index pour la table `place_voiture`
--
ALTER TABLE `place_voiture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_place_voiture_voiture` (`idvoiture`),
  ADD KEY `fk_place_voiture_place` (`idplace`);

--
-- Index pour la table `portefeuille`
--
ALTER TABLE `portefeuille`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_portefeuille_compte` (`idcompte`);

--
-- Index pour la table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tarif_parking` (`idparking`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `amende`
--
ALTER TABLE `amende`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `payement`
--
ALTER TABLE `payement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `place`
--
ALTER TABLE `place`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `place_voiture`
--
ALTER TABLE `place_voiture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT pour la table `portefeuille`
--
ALTER TABLE `portefeuille`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_compte` FOREIGN KEY (`idcompte`) REFERENCES `compte` (`id`);

--
-- Contraintes pour la table `payement`
--
ALTER TABLE `payement`
  ADD CONSTRAINT `fk_payement_compte` FOREIGN KEY (`idcompte`) REFERENCES `compte` (`id`);

--
-- Contraintes pour la table `place`
--
ALTER TABLE `place`
  ADD CONSTRAINT `fk_place_parking` FOREIGN KEY (`idparking`) REFERENCES `parking` (`id`);

--
-- Contraintes pour la table `place_voiture`
--
ALTER TABLE `place_voiture`
  ADD CONSTRAINT `fk_place_voiture_place` FOREIGN KEY (`idplace`) REFERENCES `place` (`id`),
  ADD CONSTRAINT `fk_place_voiture_voiture` FOREIGN KEY (`idvoiture`) REFERENCES `voiture` (`id`);

--
-- Contraintes pour la table `portefeuille`
--
ALTER TABLE `portefeuille`
  ADD CONSTRAINT `fk_portefeuille_compte` FOREIGN KEY (`idcompte`) REFERENCES `compte` (`id`);

--
-- Contraintes pour la table `tarif`
--
ALTER TABLE `tarif`
  ADD CONSTRAINT `fk_tarif_parking` FOREIGN KEY (`idparking`) REFERENCES `parking` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
