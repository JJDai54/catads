#
# Structure de la table `catads_ads`
# ajout fonction CPascalWeb - 17 septembre 2010 posibilité de suspendre ou de réactivé une annonce par l admin(suspendadmin)
# ajout fonction CPascalWeb - 5 novembre 2010 posibilité de signaler une annonce frauduleuse (signalementannonce)
# et remplacer: ENGINE=MyISAM;  par: ENGINE=MyISAM;
# ajout CPascalWeb - 12 novembre 2010 - option tel portable

CREATE TABLE `catads_ads` (
  `ads_id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL default '0',
  `ads_title` varchar(100) NOT NULL default '',
  `ads_type` varchar(40) NOT NULL default '',
  `ads_desc` text NOT NULL,
  `ads_tags` varchar(255) NOT NULL,
  `ads_video` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL default '0.00',
  `monnaie` varchar(20) NOT NULL default '',
  `price_option` varchar(40) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `uid` int(6) NOT NULL default '0',
  `phone` varchar(20) NOT NULL default '',
  `phoneportable` varchar(20) NOT NULL default '', 
  `pays` varchar(50) NOT NULL default 'FRANCE',
  `region` varchar(5) NOT NULL default '0',
  `departement` varchar(5) NOT NULL default '0',
  `town` varchar(200) NOT NULL default '0',
  `codpost` varchar(25) NOT NULL default '0',
  `created` int(10) NOT NULL default '0',
  `published` int(10) NOT NULL default '0',
  `expired` int(10) NOT NULL default '0',
 /* `expired_mail_send` int(1) NOT NULL default '0',*/
 /*modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
 `expired_mail_send` tinyint(1) NOT NULL default '0',*/
 
  `view` int(3) NOT NULL default '0',
  `notify_pub` tinyint(1) NOT NULL default '0',
  `poster_ip` varchar(20) NOT NULL default '',
  `contact_mode` tinyint(1) NOT NULL default '0',
  `countpub` tinyint(1) NOT NULL default '0',
  `suspend` tinyint(1) NOT NULL default '0',
  `suspendadmin` tinyint(1) NOT NULL default '0',
  `signalementannonce` tinyint(1) NOT NULL default '0',
  `waiting` tinyint(1) NOT NULL default '0',
  `photo0` varchar(255) NOT NULL default '',
  `photo1` varchar(255) NOT NULL default '',
  `photo2` varchar(255) NOT NULL default '',
  `photo3` varchar(255) NOT NULL default '',
  `photo4` varchar(255) NOT NULL default '',
  `photo5` varchar(255) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ads_id`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Structure de la table `catads_cat`
#

CREATE TABLE `catads_cat` (
  `topic_id` int(11) unsigned NOT NULL auto_increment,
  `topic_pid` int(5) unsigned NOT NULL default '0',
  `topic_title` varchar(50) NOT NULL default '',
  `topic_desc` varchar(255) NOT NULL default '',  
  `img` varchar(150) NOT NULL default '',
  `display_cat` tinyint(1) NOT NULL,
  `weight` int(5) NOT NULL default '0',
  `display_price` int(5) NOT NULL default '0',
  `nb_photo` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`topic_id`)
) ENGINE=MyISAM;

#
# ajout CPascalWeb - tables catégories et sous catégories de base
# rappel mémoire: (active ou pas, ordre, appartient a la cat, titre de la cat, description, nom image, 0,0,0,nombre d'images pour l'annonce)
#


INSERT INTO `catads_cat` VALUES 
(1,0,'Véhicules','annonces concernant les véhicules d\'occasions, voitures, motos, scooters, camping car, remorques, caravanes, utilitaires, accessoires et piÃ¨ces détachées','vehicules.png',1,1,1,6),
(2,0,'Numériques','lecteurs DVD et CD, lecteurs mp3 - mp4 - mp5 - mp6, appareils photos, caméra numériques, autoradio, navigation gps et autres accessoires numériques ','numeriques.png',1,7,1,6),
(3,0,'Intérieurs','tout pour la maison, cuisines, salles Ã  manger, salons, chambres, meubles divers, linges de maison et toutes la décorations de maison ','interieurs.png',1,6,1,6),
(4,1,'voitures','','',1,1,1,6),
(5,1,'utilitaires','','',1,2,1,6),
(6,1,'deux roues','','',1,3,1,6),
(7,1,'camping car','','',1,4,1,6),
(8,1,'accéssoires','','',1,7,1,6),
(9,2,'caméra','','',1,6,1,6),
(10,2,'appareils photos','','',1,5,1,6),
(11,2,'lecteurs CD','','',1,3,1,6),
(12,2,'lecteurs DVD','','',1,2,1,6),
(13,2,'mp3 - mp4 - mp5 - mp6','','',1,4,1,6),
(46,2,'autoradio','','',1,7,1,6),
(14,3,'linges de maisons','','',1,6,1,6),
(15,3,'meubles divers','','',1,5,1,6),
(16,0,'Informatiques','toutes les petites annonces informatiques, ordinateurs de bureau, ordinateurs portable, logiciels, jeux,  piÃ¨ces détachées et accessoires','informatiques.png',1,3,1,6),
(17,0,'Téléphonie','Tout les moyens de communication actuelle, téléphones fixe, téléphones sans fil, téléphones portables, télécopies, répondeurs et autres accessoires téléphonique ','telephonie.png',1,4,1,6),
(18,0,'Sports et loisirs','annonces concernant les sports mécanique, nautique, animaliers, corporel et les loisirs divers, musique, camping et autres','sports.png',1,10,1,6),
(19,0,'Animaux','tout les animaux de compagnies et de ferme, chiens, chats, poissons, chevaux, rongeurs, reptiles, oiseaux et accessoires pour animaux','animaux.png',1,9,1,6),
(20,19,'chiens','','',1,1,1,6),
(21,19,'chats','','',1,2,1,6),
(22,19,'chevaux','','',1,3,1,6),
(66,19,'animaux de ferme','','',1,8,1,6),
(23,16,'ordinateurs portables','','',1,2,1,6),
(24,16,'ordinateurs de bureau','','',1,1,1,6),
(25,16,'jeux','','',1,5,1,6),
(26,16,'logiciels','','',1,4,1,6),
(27,3,'décorations','','',1,7,1,6),
(28,0,'électroménagers','tout ce qui concerne l\'électroménager plaques chauffantes, machines Ã  laver, Laves vaisselle, réfrigérateurs, gaziniÃ¨res, fours, aspirateurs, robots et divers électroménagers ','electromenagers.png',1,8,1,6),
(29,28,'aspirateurs','','',1,7,1,6),
(30,28,'robots','','',1,8,1,6),
(31,28,'machines Ã  laver','','',1,2,1,6),
(32,28,'fours','','',1,6,1,6),
(33,18,'loisirs divers','','',1,7,1,6),
(34,18,'sports divers','','',1,8,1,6),
(105,88,'fêtes','','',1,7,1,6),
(37,18,'sports animaliers','','',1,3,1,6),
(73,72,'jeux playstation','','',1,1,1,6),
(47,2,'accessoires numériques','','',1,9,1,6),
(39,1,'remorques','','',1,6,1,6),
(72,0,'Jeux et consoles de jeux','annonces de consoles de jeux et de jeux playstation, wii,  nintendo, xbox, psp et tout accessoires','jeux.png',1,2,1,6),
(41,16,'accessoires informatiques','','',1,7,1,6),
(42,16,'imprimantes','','',1,3,1,6),
(44,1,'piÃ¨ces détachées','','',1,8,1,6),
(45,1,'caravanes','','',1,5,1,6),
(48,3,'cuisines','','',1,1,1,6),
(49,3,'salles Ã  manger','','',1,2,1,6),
(50,3,'salons','','',1,3,1,6),
(51,3,'chambres','','',1,4,1,6),
(52,17,'téléphones fixe','','',1,1,1,6),
(53,17,'téléphones portables','','',1,3,1,6),
(54,17,'téléphones sans fil','','',1,2,1,6),
(55,17,'télécopies','','',1,4,1,6),
(56,17,'répondeurs','','',1,5,1,6),
(57,17,'accessoires téléphonique','','',1,6,1,6),
(58,2,'navigation GPS','','',1,8,1,6),
(59,28,'laves vaisselle','','',1,3,1,6),
(60,2,'téléviseurs','','',1,1,1,6),
(61,28,'électroménagers divers','','',1,8,1,6),
(62,28,'gaziniÃ¨res','','',1,5,1,6),
(63,28,'plaques chauffantes','','',1,1,1,6),
(64,28,'réfrigérateurs','','',1,4,1,6),
(65,18,'musiques','','',1,5,1,6),
(67,19,'rongeurs','','',1,5,1,6),
(68,19,'reptiles','','',1,5,1,6),
(69,19,'oiseaux','','',1,6,1,6),
(70,19,'poissons','','',1,7,1,6),
(71,19,'accessoires pour animaux','','',1,9,1,6),
(74,72,'jeux wii','','',1,2,1,6),
(75,72,'jeux nintendo','','',1,3,1,6),
(76,72,'jeux xbox','','',1,4,1,6),
(77,72,'jeux psp','','',1,5,1,6),
(78,72,'accessoires divers','','',1,7,1,6),
(79,72,'consoles de jeux','','',1,6,1,6),
(80,0,'Bricolages et travaux','jardinages, outils divers, outils motorisés, outils Ã  mains, matériaux pour gros oeuvre, matériaux pour second oeuvre et autres outillages','bricolages.png',1,5,1,6),
(81,80,'jardinages','','',1,6,1,6),
(82,80,'outils divers','','',1,5,1,6),
(83,80,'outils motorisés','','',1,3,1,6),
(84,80,'outils Ã  mains','','',1,4,1,6),
(85,80,'matériaux gros oeuvre','','',1,2,1,6),
(86,80,'matériaux second oeuvre','','',1,1,1,6),
(87,80,'bric et broc','','',1,7,1,6),
(88,0,'Vêtements et accessoires','annonces de vêtements pour hommes, femmes, enfants, bébé, mariages, fêtes et accessoires de mode et bijoux','vetements.png',1,11,1,6),
(89,88,'mariages','','',1,6,1,6),
(90,18,'sports nautique','','',1,2,1,6),
(91,18,'sports mécanique','','',1,1,1,6),
(92,18,'camping','','',1,6,1,6),
(93,18,'sports corporel','','',1,4,1,6),
(98,0,'Immobiliers','','immobiliers.png',1,12,1,6),
(99,88,'bijoux','','',1,8,1,6),
(100,88,'vêtements hommes','','',1,1,1,6),
(101,88,'vêtements femmes','','',1,2,1,6),
(102,88,'vêtements enfants','','',1,3,1,6),
(103,88,'vêtements bébé','','',1,4,1,6),
(104,88,'accessoires de mode','','',1,5,1,6),
(106,16,'écrans','','',1,6,1,6),
(107,98,'locations appartements','','',1,1,1,6),
(108,98,'locations maisons','','',1,2,1,6),
(110,98,'locations terrains','','',1,3,1,6),
(111,98,'ventes appartements','','',1,4,1,6),
(112,98,'ventes maisons','','',1,5,1,6),
(114,98,'ventes terrains','','',1,6,1,6),
(115,98,'locations divers','','',1,7,1,6),
(116,98,'ventes divers','','',1,8,1,6),
(117,72,'jeux de société','','',1,8,1,6),
(118,16,'piÃ¨ces détachées','','',1,8,1,6),
(119,17,'montres téléphone','','',1,7,1,6);

# ajout CPascalWeb - 24 septembre 2010 - tables option_champs et option_img
# Structure de la table `catads_options`
#

CREATE TABLE `catads_options` (
  `option_id` tinyint(3) NOT NULL auto_increment,
  `option_champs` tinyint(3) NOT NULL default '0', 
  `option_type` tinyint(3) NOT NULL default '0',
  `option_desc` varchar(40) NOT NULL default '',
  `option_order` tinyint(3) NOT NULL default '0',
  `option_img` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`option_id`)
) ENGINE=MyISAM;

INSERT INTO `catads_options` (`option_id`, `option_type`, `option_desc`, `option_order`) VALUES 
(1,1,'Euros',0),
(2,1,'Pounds',0),
(3,1,'Dollars',0),
(4,2,'Minimum',0),
(5,2,'Maximum',0),
(6,2,'Paiement comptant',0),
(7,2,'Paiement en 3 fois',0),
(8,2,'Paiement en plusieurs fois',0),
(9,2,'Négociable',0),
(10,2,'Ferme',0),
(11,3,'À vendre',3),
(12,3,'Recherche',0),
(13,3,'À louer',2),
(14,3,'Échange',0),
(15,3,'Donne',1),
(16,4,'7',0),
(17,4,'15',0),
(18,4,'30',0);

#
# Structure de la table `catads_regions`
#

CREATE TABLE `catads_regions` (
  `region_numero` smallint(3) NOT NULL default '0',
  `region_nom` varchar(64),
  PRIMARY KEY  (`region_numero`)
) ENGINE=MyISAM;

-- 
-- Contenu de la table `catads_regions`
-- 
INSERT INTO `catads_regions` VALUES ('1', 'Alsace');
INSERT INTO `catads_regions` VALUES ('2', 'Aquitaine');
INSERT INTO `catads_regions` VALUES ('3', 'Auvergne');
INSERT INTO `catads_regions` VALUES ('4', 'Basse Normandie');
INSERT INTO `catads_regions` VALUES ('5', 'Bourgogne');
INSERT INTO `catads_regions` VALUES ('6', 'Bretagne');
INSERT INTO `catads_regions` VALUES ('7', 'Centre');
INSERT INTO `catads_regions` VALUES ('8', 'Champagne Ardenne');
INSERT INTO `catads_regions` VALUES ('9', 'Corse');
INSERT INTO `catads_regions` VALUES ('10', 'Franche Comte');
INSERT INTO `catads_regions` VALUES ('11', 'Haute Normandie');
INSERT INTO `catads_regions` VALUES ('12', 'Ile de France');
INSERT INTO `catads_regions` VALUES ('13', 'Languedoc Roussillon');
INSERT INTO `catads_regions` VALUES ('14', 'Limousin');
INSERT INTO `catads_regions` VALUES ('15', 'Lorraine');
INSERT INTO `catads_regions` VALUES ('16', 'Midi-Pyrenees');
INSERT INTO `catads_regions` VALUES ('17', 'Nord Pas de Calais');
INSERT INTO `catads_regions` VALUES ('18', 'P.A.C.A');
INSERT INTO `catads_regions` VALUES ('19', 'Pays de la Loire');
INSERT INTO `catads_regions` VALUES ('20', 'Picardie');
INSERT INTO `catads_regions` VALUES ('21', 'Poitou Charente');
INSERT INTO `catads_regions` VALUES ('22', 'Rhone Alpes');


#
# Structure de la table `catads_departements`
#

CREATE TABLE `catads_departements` (
  `departement_numero` varchar(3) NOT NULL default '0',
  `departement_numero_region` smallint(3) NOT NULL default '0',
  `departement_nom` char(32) default NULL,
  PRIMARY KEY  (`departement_numero`),
  KEY `FK_DEPARTEMENT_REGION` (`departement_numero_region`)
) ENGINE=MyISAM;


-- 
-- Contenu de la table `catads_departements`
-- 

INSERT INTO `catads_departements` VALUES ('1', '22', 'Ain');
INSERT INTO `catads_departements` VALUES ('2', '20', 'Aisne');
INSERT INTO `catads_departements` VALUES ('3', '3', 'Allier');
INSERT INTO `catads_departements` VALUES ('4', '18', 'Alpes de haute provence');
INSERT INTO `catads_departements` VALUES ('5', '18', 'Hautes alpes');
INSERT INTO `catads_departements` VALUES ('6', '18', 'Alpes maritimes');
INSERT INTO `catads_departements` VALUES ('7', '22', 'Ardeche');
INSERT INTO `catads_departements` VALUES ('8', '8', 'Ardennes');
INSERT INTO `catads_departements` VALUES ('9', '16', 'Ariege');
INSERT INTO `catads_departements` VALUES ('10', '8', 'Aube');
INSERT INTO `catads_departements` VALUES ('11', '13', 'Aude');
INSERT INTO `catads_departements` VALUES ('12', '16', 'Aveyron');
INSERT INTO `catads_departements` VALUES ('13', '18', 'Bouches du rh&ocirc;ne');
INSERT INTO `catads_departements` VALUES ('14', '4', 'Calvados');
INSERT INTO `catads_departements` VALUES ('15', '3', 'Cantal');
INSERT INTO `catads_departements` VALUES ('16', '21', 'Charente');
INSERT INTO `catads_departements` VALUES ('17', '21', 'Charente maritime');
INSERT INTO `catads_departements` VALUES ('18', '7', 'Cher');
INSERT INTO `catads_departements` VALUES ('19', '14', 'Correze');
INSERT INTO `catads_departements` VALUES ('21', '5', 'C&ocirc;te d\'or');
INSERT INTO `catads_departements` VALUES ('22', '6', 'C&ocirc;tes d\'Armor');
INSERT INTO `catads_departements` VALUES ('23', '14', 'Creuse');
INSERT INTO `catads_departements` VALUES ('24', '2', 'Dordogne');
INSERT INTO `catads_departements` VALUES ('25', '10', 'Doubs');
INSERT INTO `catads_departements` VALUES ('26', '22', 'Dr&ocirc;me');
INSERT INTO `catads_departements` VALUES ('27', '11', 'Eure');
INSERT INTO `catads_departements` VALUES ('28', '7', 'Eure et Loir');
INSERT INTO `catads_departements` VALUES ('29', '6', 'Finistere');
INSERT INTO `catads_departements` VALUES ('30', '13', 'Gard');
INSERT INTO `catads_departements` VALUES ('31', '16', 'Haute garonne');
INSERT INTO `catads_departements` VALUES ('32', '16', 'Gers');
INSERT INTO `catads_departements` VALUES ('33', '2', 'Gironde');
INSERT INTO `catads_departements` VALUES ('34', '13', 'Herault');
INSERT INTO `catads_departements` VALUES ('35', '6', 'Ile et Vilaine');
INSERT INTO `catads_departements` VALUES ('36', '7', 'Indre');
INSERT INTO `catads_departements` VALUES ('37', '7', 'Indre et Loire');
INSERT INTO `catads_departements` VALUES ('38', '22', 'Isere');
INSERT INTO `catads_departements` VALUES ('39', '10', 'Jura');
INSERT INTO `catads_departements` VALUES ('40', '2', 'Landes');
INSERT INTO `catads_departements` VALUES ('41', '7', 'Loir et Cher');
INSERT INTO `catads_departements` VALUES ('42', '22', 'Loire');
INSERT INTO `catads_departements` VALUES ('43', '3', 'Haute loire');
INSERT INTO `catads_departements` VALUES ('44', '19', 'Loire Atlantique');
INSERT INTO `catads_departements` VALUES ('45', '7', 'Loiret');
INSERT INTO `catads_departements` VALUES ('46', '16', 'Lot');
INSERT INTO `catads_departements` VALUES ('47', '2', 'Lot et Garonne');
INSERT INTO `catads_departements` VALUES ('48', '13', 'Lozere');
INSERT INTO `catads_departements` VALUES ('49', '19', 'Maine et Loire');
INSERT INTO `catads_departements` VALUES ('50', '4', 'Manche');
INSERT INTO `catads_departements` VALUES ('51', '8', 'Marne');
INSERT INTO `catads_departements` VALUES ('52', '8', 'Haute Marne');
INSERT INTO `catads_departements` VALUES ('53', '19', 'Mayenne');
INSERT INTO `catads_departements` VALUES ('54', '15', 'Meurthe et Moselle');
INSERT INTO `catads_departements` VALUES ('55', '15', 'Meuse');
INSERT INTO `catads_departements` VALUES ('56', '6', 'Morbihan');
INSERT INTO `catads_departements` VALUES ('57', '15', 'Moselle');
INSERT INTO `catads_departements` VALUES ('58', '5', 'Nievre');
INSERT INTO `catads_departements` VALUES ('59', '17', 'Nord');
INSERT INTO `catads_departements` VALUES ('60', '20', 'Oise');
INSERT INTO `catads_departements` VALUES ('61', '4', 'Orne');
INSERT INTO `catads_departements` VALUES ('62', '17', 'Pas de Calais');
INSERT INTO `catads_departements` VALUES ('63', '3', 'Puy de D&ocirc;me');
INSERT INTO `catads_departements` VALUES ('64', '2', 'Pyrenees Atlantiques');
INSERT INTO `catads_departements` VALUES ('65', '16', 'Hautes Pyrenees');
INSERT INTO `catads_departements` VALUES ('66', '13', 'Pyrenees Orientales');
INSERT INTO `catads_departements` VALUES ('67', '1', 'Bas Rhin');
INSERT INTO `catads_departements` VALUES ('68', '1', 'Haut Rhin');
INSERT INTO `catads_departements` VALUES ('69', '22', 'Rh&ocirc;ne');
INSERT INTO `catads_departements` VALUES ('70', '10', 'Haute Sa&ocirc;ne');
INSERT INTO `catads_departements` VALUES ('71', '5', 'Sa&ocirc;ne et Loire');
INSERT INTO `catads_departements` VALUES ('72', '19', 'Sarthe');
INSERT INTO `catads_departements` VALUES ('73', '22', 'Savoie');
INSERT INTO `catads_departements` VALUES ('74', '22', 'Haute Savoie');
INSERT INTO `catads_departements` VALUES ('75', '12', 'Paris');
INSERT INTO `catads_departements` VALUES ('76', '11', 'Seine Maritime');
INSERT INTO `catads_departements` VALUES ('77', '12', 'Seine et Marne');
INSERT INTO `catads_departements` VALUES ('78', '12', 'Yvelines');
INSERT INTO `catads_departements` VALUES ('79', '21', 'Deux Sevres');
INSERT INTO `catads_departements` VALUES ('80', '20', 'Somme');
INSERT INTO `catads_departements` VALUES ('81', '16', 'Tarn');
INSERT INTO `catads_departements` VALUES ('82', '16', 'Tarn et Garonne');
INSERT INTO `catads_departements` VALUES ('83', '18', 'Var');
INSERT INTO `catads_departements` VALUES ('84', '18', 'Vaucluse');
INSERT INTO `catads_departements` VALUES ('85', '19', 'Vendee');
INSERT INTO `catads_departements` VALUES ('86', '21', 'Vienne');
INSERT INTO `catads_departements` VALUES ('87', '14', 'Haute Vienne');
INSERT INTO `catads_departements` VALUES ('88', '15', 'Vosge');
INSERT INTO `catads_departements` VALUES ('89', '5', 'Yonne');
INSERT INTO `catads_departements` VALUES ('90', '10', 'Territoire de Belfort');
INSERT INTO `catads_departements` VALUES ('91', '12', 'Essonne');
INSERT INTO `catads_departements` VALUES ('92', '12', 'Haut de seine');
INSERT INTO `catads_departements` VALUES ('93', '12', 'Seine Saint Denis');
INSERT INTO `catads_departements` VALUES ('94', '12', 'Val de Marne');
INSERT INTO `catads_departements` VALUES ('95', '12', 'Val d\'Oise');
INSERT INTO `catads_departements` VALUES ('2a', '9', 'Corse du Sud');
INSERT INTO `catads_departements` VALUES ('2b', '9', 'Haute Corse');


