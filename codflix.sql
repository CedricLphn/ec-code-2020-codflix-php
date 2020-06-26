-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Listage de la structure de la table codflix. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table codflix.genre : ~3 rows (environ)
DELETE FROM `genre`;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` (`id`, `name`) VALUES
	(1, 'Action'),
	(2, 'Horreur'),
	(3, 'Science-Fiction'),
	(4, 'Thriller'),
	(5, 'Comédie');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;

-- Listage de la structure de la table codflix. history
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `serie_id` int(11) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `finish_date` datetime DEFAULT NULL,
  `watch_duration` int(11) NOT NULL DEFAULT '0' COMMENT 'in seconds',
  PRIMARY KEY (`id`),
  KEY `history_user_id_fk_media_id` (`user_id`),
  KEY `history_media_id_fk_media_id` (`media_id`),
  KEY `history_serie_id_fk_serie_id` (`serie_id`),
  CONSTRAINT `history_media_id_fk_media_id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `history_serie_id_fk_serie_id` FOREIGN KEY (`serie_id`) REFERENCES `serie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `history_user_id_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

-- Listage des données de la table codflix.history : ~1 rows (environ)
DELETE FROM `history`;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` (`id`, `user_id`, `media_id`, `serie_id`, `start_date`, `finish_date`, `watch_duration`) VALUES
	(70, 1, 1, NULL, '2020-06-26 11:08:11', '2020-06-26 11:41:44', 0);
/*!40000 ALTER TABLE `history` ENABLE KEYS */;

-- Listage de la structure de la table codflix. media
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'Film' COMMENT 'Film or Serie',
  `status` varchar(20) NOT NULL,
  `release_date` date NOT NULL,
  `summary` longtext NOT NULL,
  `trailer_url` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `media_genre_id_fk_genre_id` (`genre_id`) USING BTREE,
  CONSTRAINT `media_genre_id_b1257088_fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table codflix.media : ~4 rows (environ)
DELETE FROM `media`;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` (`id`, `genre_id`, `title`, `type`, `status`, `release_date`, `summary`, `trailer_url`, `duration`) VALUES
	(1, 2, 'Alien', 'Film', 'published', '1970-06-23', 'Durant le voyage de retour d\'un immense cargo spatial en mission commerciale de routine, ses passagers, cinq hommes et deux femmes plongés en hibernation, sont tirés de leur léthargie dix mois plus tôt que prévu par Mother, l\'ordinateur de bord. Ce dernier a en effet capté dans le silence interplanétaire des signaux sonores, et suivant une certaine clause du contrat de navigation, les astronautes sont chargés de prospecter tout indice de vie dans l\'espace.', 'https://www.youtube.com/embed/zQFuUeXyACw', 7020),
	(2, 4, 'Legion', 'Serie', 'published', '2017-02-08', 'David est un homme sujet depuis l\'adolescence à une maladie mentale. Au cours d\'un séjour en hôpital psychiatrique, une rencontre lui fait réaliser que les voix qu\'il entend et les visions auxquelles il est confronté pourraient se révéler vraies.', 'https://www.youtube.com/embed/4SZ3rMMYBLY', 0),
	(3, 4, 'La Ligne verte', 'Film', 'published', '1999-06-25', 'Paul Edgecomb, pensionnaire centenaire d\'une maison de retraite, est hanté par ses souvenirs. Gardien-chef du pénitencier de Cold Mountain, en 1935, en Louisiane, il était chargé de veiller au bon déroulement des exécutions capitales au bloc E (la ligne verte) en s\'efforçant d\'adoucir les derniers moments des condamnés. Parmi eux se trouvait un colosse du nom de John Coffey, accusé du viol et du meurtre de deux fillettes.', 'https://www.youtube.com/embed/VV9n9gINmnY', 11340),
	(4, 5, 'God Bless America', 'Film', 'published', '2011-06-25', 'Divorcé et fraîchement licencié, Frank apprend, en plus, qu\'il est condamné par la maladie. Il décide d\'en finir... mais avec les autres. Il prend une arme et se lance dans une équipée meurtrière à travers les États-Unis. En chemin, il croise la route de Roxy, une adolescente paumée, qu\'il embarque dans sa folie meurtrière.', 'https://www.youtube.com/embed/VsgwrZTsBHA', 6300),
	(5, 1, 'Better Call Saul', 'Serie', 'published', '2015-06-25', 'Ce spin-off de la série `Breaking Bad\' suit la vie de Jimmy McGill avant qu\'il ne prenne le pseudonyme de Saul Goodman et devienne l\'avocat véreux de Walter White.', 'https://www.youtube.com/embed/7ykFY6UPe98', 0);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;

-- Listage de la structure de la table codflix. serie
CREATE TABLE IF NOT EXISTS `serie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `episode` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `duration` int(11) NOT NULL,
  `media_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__media` (`media_id`),
  CONSTRAINT `FK__media` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Listage des données de la table codflix.serie : ~5 rows (environ)
DELETE FROM `serie`;
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` (`id`, `media_id`, `season`, `episode`, `title`, `summary`, `duration`, `media_url`) VALUES
	(1, 2, 1, 1, 'Chapitre 1', 'David Haller est interné dans un hôpital psychiatrique où il suit une thérapie pour contrôler sa schizophrénie paranoïaque. L\'arrivée de Syd Barrett, jeune femme qui refuse tout contact physique, perturbe la routine du malade. Mais à l\'extérieur, une unité paramilitaire, la Division 3, essaie de retrouver David, qui pourrait bien être un mutant aux pouvoirs psychiques sans égal.', 2640, 'https://www.youtube.com/embed/gQqr_PTEXeM'),
	(2, 2, 1, 2, 'Chapitre 2', 'David a été amené à Summerland, un refuge secret pour mutants, où Mme Bird veut lui apprendre à maîtriser ses pouvoirs psychiques. Pour cela, David commence une série d\'IRM pour mieux comprendre le fonctionnement de son cerveau et plusieurs exercices avec Ptonomy, dont le pouvoir de manipulation de la mémoire lui permet de faire revivre les traumatismes passés.', 4200, 'https://www.youtube.com/embed/m1UP9ZK4ybw'),
	(3, 2, 2, 1, 'Chapitre 9', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.', 1800, 'https://www.youtube.com/embed/tQ0loBjDZDw'),
	(4, 5, 1, 1, 'Uno', 'Saul Goodman a changé d\'identité après son implication dans l\'affaire Heisenberg, il se cache comme employé dans une cafétéria. Il se remémore comment, en 2001, alors qu\'il portait son nom de naissance, James McGill, il essayait de vivre comme avocat indépendant, gagnant un maigre salaire quand il défendait des dossiers comme avocat commis d\'office. Sous-payé et lassé d\'être déconsidéré par les avocats associés de son frère Chuck, qui lui volent les quelques clients qu\'il essaie d\'avoir, James a l\'idée de monter une arnaque grâce à deux jeunes skateurs qui ont tenté de l\'arnaquer : ils vont simuler un accident avec la femme de Craig Kettleman que McGill espère obtenir comme cliente. Mais l\'incident se déroule mal puisque la voiture s\'enfuit. McGill y voit une manne financière grâce aux circonstances aggravantes mais il ignore que les jeunes se sont trompés de voiture : l\'un des deux frères a été renversé par la grand-mère de Tuco Salamanca — un criminel dangereux — et celui-ci n\'apprécie pas qu\'on lui réclame de l\'argent.', 2700, 'https://www.youtube.com/embed/2va22TpxylM'),
	(5, 5, 1, 2, 'Mijo', 'Tuco Salamanca enferme Jimmy McGill et les deux skaters chez lui. Malgré les explications de Jimmy, qui cherche à lui montrer qu\'il y a eu erreur, Tuco les emmène dans le désert pour les exécuter. Le bras droit de Tuco, Nacho, convainc alors Tuco de laisser la vie sauve à Jimmy. Ce dernier use ensuite de ses talents d\'avocat pour négocier la « peine » des skateurs : Tuco se contentera de leur briser les jambes. Voulant oublier ce triste épisode, Jimmy reprend sa vie d\'avocat commis d\'office. Mais un jour, Nacho vient frapper à sa porte : il lui demande de l\'aider à voler le million de dollars que Craig Kettleman aurait volé à la ville.', 2700, 'https://www.youtube.com/embed/Y9He9Gpt1iQ'),
	(6, 5, 2, 1, 'Un nouveau chapitre', 'Dans le présent, Jimmy travaille dans une cafétéria et se retrouve coincé pendant quelques heures dans le local poubelle du centre commercial. En attendant d\'être libéré, il grave un message dans le mur : « SG was here. »\r\nEn 2002, encore troublé par son expérience avec les mafieux, Jimmy décide de refuser l\'offre du cabinet Davis & Main et ferme son cabinet. Kim essaie de comprendre et pour cela, Jimmy l\'enrôle dans une de ses arnaques où il dupe un trader en lui faisant payer une énorme addition. Amusée et ivre, Kim passe la nuit avec Jimmy. Pendant ce temps, Pryce devient flambeur et décide de se passer des services de Mike. Nacho en profite pour voler ses informations personnelles. Le lendemain, Pryce est cambriolé et les policiers repèrent aussitôt Pryce comme suspect. Pris de remords, Jimmy revient à son poste d\'avocat et accepte d\'intégrer Davis & Main.', 3000, 'https://www.youtube.com/embed/dzaLn4RVH8k'),
	(7, 5, 2, 2, 'Le Gâteau à la crème', 'Howard rend visite à Chuck et lui fait part du poste que Jimmy a obtenu chez Davis & Main. Mike trouve Pryce alors qu\'il allait peut-être être interrogé par la police et comprend vite qu\'il est suspecté. Il retrouve Nacho et trouve un arrangement : en échange des cartes de baseball et de 10 000 $, il obtient le Hummer de Pryce et toute l\'histoire reste secrète. Jimmy découvre que son frère garde un œil sur son activité d\'avocat, et sous le coup de la colère, il accepte d\'aider Mike à vendre une histoire pour dissiper les doutes de la police en affirmant que la cache de drogue renfermait des vidéos fétichistes. Quand Kim apprend que pour vendre l\'histoire, Jimmy a réalisé une vidéo avec Pryce, elle voit cela comme une fabrication de fausse preuve et craint que cela ne se retourne contre lui.', 2700, 'https://www.youtube.com/embed/FiJpL-My4Vo'),
	(8, 5, 3, 1, 'Mabel', 'Dans le présent, Jimmy continue de travailler dans une pâtisserie et surprend un voleur à la tire pendant sa pause déjeuner. Il le dénonce au policier qui le recherche mais craque et implore le voleur de prendre un avocat. Alors qu\'il reprend son service, il perd soudain connaissance. En 2002, Jimmy croit avoir une chance de se réconcilier avec son frère, ignorant que celui-ci a enregistré ses aveux de contrefaçon dans le dossier Mesa Verde. Hamlin considère que l’enregistrement n’a aucune valeur mais Chuck sait comment l\'utiliser. Selon les plans de Chuck et prétendument par inadvertance, Ernesto découvre également l’enregistrement et Chuck le force à garder le secret tout en espérant en réalité qu\'il en parle à Jimmy. Kim a du mal à garder le secret de la fraude. Jimmy reçoit dans son cabinet la visite du militaire qu\'il a dupé pour tourner son spot publicitaire, ce dernier l’a retrouvé et exige réparation.\r\n', 2000, 'https://www.youtube.com/embed/2Bf6NHYs894');
/*!40000 ALTER TABLE `serie` ENABLE KEYS */;

-- Listage de la structure de la table codflix. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `password` varchar(254) NOT NULL,
  `activation` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Listage des données de la table codflix.user : ~1 rows (environ)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `password`, `activation`) VALUES
	(1, 'coding@gmail.com', '91ffdb7bf20347f15e47039da3969b317c703d3085772493ec53dc06ca2b6af8', NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Listage de la structure de la table codflix. watchlist
CREATE TABLE IF NOT EXISTS `watchlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `media_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id fk user.id` (`user_id`),
  KEY `media_id fk media.id` (`media_id`),
  CONSTRAINT `media_id fk media.id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_id fk user.id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- Listage des données de la table codflix.watchlist : ~0 rows (environ)
DELETE FROM `watchlist`;
/*!40000 ALTER TABLE `watchlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `watchlist` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
