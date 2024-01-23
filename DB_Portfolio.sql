
-- Listage de la structure de la base pour portfolio
CREATE DATABASE IF NOT EXISTS `portfolio` ;
USE `portfolio`;

-- Listage de la structure de table portfolio. Admin
CREATE TABLE IF NOT EXISTS `Admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Admin : ~2 rows (environ)
INSERT INTO `Admin` (`id_admin`, `email`, `password`) VALUES
	(1, 'test@test.fr', '$2y$14$aSQgmvQDxPqzq2qyp/xlNemS5rIRv92tDf3fZiZalG6Fe8hybBAhe');

-- Listage de la structure de table portfolio. Article
CREATE TABLE IF NOT EXISTS `Article` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL DEFAULT '',
  `main_img` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `publi_date` date NOT NULL,
  `content` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Article : ~2 rows (environ)
INSERT INTO `Article` (`id_article`, `titre`, `main_img`, `description`, `publi_date`, `content`) VALUES
	(1, 'test article', '/assets/github.svg', 'github for life', '2024-01-15', '<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>\r\n<h6>test</h6>\r\n<div class="text_wrapper">\r\n    <p>\r\n        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.\r\n    </p>\r\n</div>'),
	(2, 'test article', '/assets/github.svg', 'github for life', '2024-01-15', '<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>');

-- Listage de la structure de table portfolio. Article_categorie
CREATE TABLE IF NOT EXISTS `Article_categorie` (
  `id_art_cat` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL DEFAULT 1,
  `id_article` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_art_cat`),
  KEY `FK_Article_categorie_Categorie` (`id_categorie`),
  KEY `FK_Article_categorie_Article` (`id_article`),
  CONSTRAINT `FK_Article_categorie_Article` FOREIGN KEY (`id_article`) REFERENCES `Article` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Article_categorie_Categorie` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Article_categorie : ~5 rows (environ)
INSERT INTO `Article_categorie` (`id_art_cat`, `id_categorie`, `id_article`) VALUES
	(1, 3, 1),
	(2, 4, 1),
	(3, 6, 2),
	(4, 11, 1),
	(6, 7, 2);

-- Listage de la structure de table portfolio. Categorie
CREATE TABLE IF NOT EXISTS `Categorie` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Categorie : ~11 rows (environ)
INSERT INTO `Categorie` (`id_categorie`, `nom`, `logo`) VALUES
	(1, 'Web Frontend', '/assets/categorie/dev_frontend.svg'),
	(2, 'Web Backend', '/assets/categorie/dev_backend.svg'),
	(3, 'Database', '/assets/categorie/database.svg'),
	(4, 'PHP', '/assets/categorie/php.svg'),
	(6, 'Golang', '/assets/categorie/go.svg'),
	(7, 'C', '/assets/categorie/c.svg'),
	(8, 'C++', '/assets/categorie/c++.svg'),
	(9, 'C#', '/assets/categorie/c_sharp.svg'),
	(10, 'Java', '/assets/categorie/java.svg'),
	(11, 'Javascript', '/assets/categorie/javascript.svg'),
	(12, 'Domotique', '/assets/house.svg');

-- Listage de la structure de table portfolio. Comment
CREATE TABLE IF NOT EXISTS `Comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL DEFAULT '',
  `id_article` int(11) NOT NULL DEFAULT 1,
  `publi_date` datetime NOT NULL,
  `content` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id_comment`),
  KEY `FK_Comment_Article` (`id_article`),
  CONSTRAINT `FK_Comment_Article` FOREIGN KEY (`id_article`) REFERENCES `Article` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Comment : ~0 rows (environ)

-- Listage de la structure de table portfolio. Competence
CREATE TABLE IF NOT EXISTS `Competence` (
  `id_competence` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '',
  `logo` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_competence`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Competence : ~6 rows (environ)
INSERT INTO `Competence` (`id_competence`, `titre`, `description`, `logo`) VALUES
	(1, 'Unreal Engine 5', 'Capacité à développer les fonctionnalités  d\'un jeux vidéo UE5 et des outils pour le moteur du jeux ', '/assets/competence/unreal_engine_5.svg'),
	(2, 'Développement Web', 'Création de site web avec html, css, javascript, php en natif', '/assets/competence/web_dev.svg'),
	(3, 'Développement Logiciel', 'Création logiciel java, c++, c#', '/assets/competence/software_dev.svg'),
	(4, 'Base de Données', 'Gestion et création de base de données et d\'exécution de requête en mysql', '/assets/competence/database.svg'),
	(5, 'Gestion de Projet', 'Capacité à gérer un projet des premières maquettes jusqu\'à la présentation du projet terminé en passant par l\'organisation de la team', '/assets/competence/gestion_projet.svg'),
	(16, 'Développement Logiciel', 'Création logiciel java, c++, c#', '/assets/competence/software_dev.svg');

-- Listage de la structure de table portfolio. Message
CREATE TABLE IF NOT EXISTS `Message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(500) NOT NULL DEFAULT '',
  `sending_date` datetime NOT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Message : ~8 rows (environ)
INSERT INTO `Message` (`id_message`, `email`, `content`, `sending_date`, `readed`) VALUES
	(4, 'mateoluque@aol.com', 'hello c\'est un message de test', '2023-12-19 01:02:21', 1),
	(10, 'test@sd', 'bonne année en avance !!!\r\n', '2023-12-31 19:00:06', 0),
	(11, 'test@sd.token', 'test avec token de serveur', '2024-01-09 00:11:59', 1),
	(13, 'mateo.luque@ynov.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vehicula sem eget mi tincidunt, in interdum risus maximus. Vestibulum metus velit, ultricies ac tortor in, pulvinar varius diam. Maecenas in ultricies mi, at dictum orci. Nam vulputate purus ipsum, et molestie massa auctor accumsan. In eget nisl eros. Quisque in orci dapibus, lacinia tellus nec, gravida magna. Nulla at ligula et turpis gravida accumsan eu non ante. Nunc ultrices pharetra dui in volutpat. Aliquam mollis tristique m', '2024-01-09 14:52:16', 1),
	(14, 'test@sd', 'test de temp ', '2024-01-09 17:09:18', 0),
	(15, 'mateoluque@aol.com', 'truc final test', '2024-01-21 16:08:07', 0),
	(16, 'mateoluque@aol.com', 'test final 2 par contact', '2024-01-21 16:08:55', 0),
	(17, 'mateoluque@aol.com', '&lt;script&gt;alert(&quot;hack&quot;)&lt;/script&gt;', '2024-01-23 14:04:07', 0);

-- Listage de la structure de table portfolio. Project
CREATE TABLE IF NOT EXISTS `Project` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL DEFAULT '',
  `main_img` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `publi_date` date NOT NULL,
  `content` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Project : ~6 rows (environ)
INSERT INTO `Project` (`id_project`, `titre`, `main_img`, `description`, `publi_date`, `content`) VALUES
	(2, 'test titre 2', '/assets/categorie/php.svg', 'test description\r\ntest description\r\ntest descriptionv\r\ntest description\r\ntest description\r\ntest descriptionv\r\ntest description\r\ntest description test description\r\ntest description\r\ntest descriptionv\r\ntest description\r\ntest description\r\ntest descriptionv\r\ntest description\r\ntest description\r\ntest descriptionv\r\ntest descriptionv', '2023-12-01', '<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>\r\n<div class="text_wrapper">\r\n     <p>\r\n     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sed finibus lectus. Morbi placerat consequat dui, at tincidunt neque vehicula at. Sed imperdiet pulvinar pellentesque. Nunc in laoreet velit. Aenean porta rutrum augue et lacinia. Donec aliquet odio nec nulla molestie posuere. Donec tincidunt dolor non massa volutpat, non lacinia sapien ultrices. Ut varius, purus in ullamcorper tristique, lorem eros bibendum leo, ac rhoncus lorem elit id augue. Cras hendrerit metus a erat faucibus, malesuada semper nibh volutpat. Morbi ornare dui tellus, quis vestibulum enim congue et.\r\n     Ut ultricies odio et odio euismod pellentesque. Proin suscipit ipsum ipsum, sit amet malesuada eros elementum eu. Pellentesque in leo laoreet, faucibus massa at, rutrum ligula. Aliquam ornare interdum nulla, vel accumsan est dapibus suscipit. Nulla nec hendrerit ante. Aliquam diam turpis, posuere ut faucibus at, lacinia quis tellus. Morbi eu consectetur elit. Pellentesque mauris diam, scelerisque dignissim iaculis non, dictum at purus. Mauris ut placerat sem. Donec posuere elementum rhoncus.\r\n     Mauris eget feugiat quam. Vestibulum dictum semper lorem, in tempus eros aliquet at. Nulla non pharetra magna, eu condimentum quam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ut molestie felis. Maecenas a libero tempor, consequat felis vel, dignissim felis. Donec euismod commodo sem rutrum pharetra. Mauris et molestie quam. Nullam id felis id tellus accumsan sagittis. Pellentesque quis magna nulla. Phasellus ac venenatis massa. Cras non dui eu felis varius feugiat ac id nisl.\r\n     Curabitur at malesuada arcu. Nullam eget lorem semper, tristique turpis sed, tincidunt elit. In bibendum, turpis et fermentum euismod, lorem tortor ullamcorper sapien, a bibendum nibh nunc a ante. Nunc mi massa, vulputate consectetur porta sed, viverra sit amet dolor. Suspendisse vitae aliquam purus, id pharetra massa. Integer commodo vitae leo vel elementum. Aenean arcu orci, lacinia a purus nec, aliquet tempus nulla. Phasellus luctus lacus nec urna pretium, vel aliquam libero volutpat. Proin vehicula egestas auctor. Vestibulum eu tempus libero. Proin fringilla ex id dolor imperdiet, quis maximus leo sodales. Mauris lobortis vehicula metus, eu blandit augue consectetur non.\r\n     Quisque congue sapien sit amet tellus vulputate vestibulum. Fusce eu ex iaculis, consectetur quam vel, ultricies mauris. Cras scelerisque egestas imperdiet. Integer et nunc commodo, dignissim lorem in, viverra dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id ullamcorper sapien, id iaculis nulla. Pellentesque est justo, facilisis eu tellus sed, accumsan eleifend metus. Vestibulum vulputate nibh nunc, sed tincidunt massa sollicitudin a. Duis pellentesque sodales urna et mattis. In sit amet convallis quam.\r\n     </p>\r\n</div>\r\n<hr>\r\n<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/920/600">\r\n</div>'),
	(3, 'test titre 3', '/assets/categorie/java.svg', 'test description', '2021-09-23', '<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1900/1080">\r\n</div>\r\n<hr>\r\n<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/920/600">\r\n</div>'),
	(4, 'test titre 4', '/assets/categorie/java.svg', 'test description', '2023-12-05', '<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1900/1080">\r\n</div>\r\n<hr>\r\n<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/920/600">\r\n</div>'),
	(5, 'test titre 2', '/assets/categorie/php.svg', 'test description\r\ntest description\r\n\r\n\r\ntest descriptionv', '2023-06-12', '<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1900/1080">\r\n</div>\r\n<hr>\r\n<h6>test</h6>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/920/600">\r\n</div>'),
	(6, 'test proj', '/assets/github.svg', 'test d&#039;ajout de projet', '2023-07-12', '<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1920/1080">\r\n</div>\r\n<div class="img_wrapper">\r\n    <img src="https://picsum.photos/1900/1080">\r\n</div>'),
	(7, 'test titre 25', '/assets/github.svg', 'test', '2024-01-23', '<div class="text_wrapper">\r\n    <p>\r\n        Contenu en cours de création\r\n    </p>\r\n</div>');

-- Listage de la structure de table portfolio. Project_categorie
CREATE TABLE IF NOT EXISTS `Project_categorie` (
  `id_pro_cat` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL DEFAULT 1,
  `id_project` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_pro_cat`),
  KEY `FK_Project_categorie_Categorie` (`id_categorie`),
  KEY `FK_Project_categorie_Project` (`id_project`),
  CONSTRAINT `FK_Project_categorie_Categorie` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Project_categorie_Project` FOREIGN KEY (`id_project`) REFERENCES `Project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Listage des données de la table portfolio.Project_categorie : ~7 rows (environ)
INSERT INTO `Project_categorie` (`id_pro_cat`, `id_categorie`, `id_project`) VALUES
	(1, 9, 3),
	(2, 3, 4),
	(3, 2, 3),
	(4, 1, 3),
	(5, 11, 3),
	(6, 1, 4),
	(12, 7, 4);
