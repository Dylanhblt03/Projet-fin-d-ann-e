/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Win64 (AMD64)
--
-- Host: 192.168.56.56    Database: oleris_db
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB-ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `entreprise` varchar(150) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `pays` varchar(100) DEFAULT 'France',
  `siret` varchar(50) DEFAULT NULL,
  `photo_profil` varchar(255) DEFAULT NULL,
  `statut_compte` varchar(50) DEFAULT 'actif',
  `email_verifie` tinyint(1) DEFAULT 0,
  `token_verification` varchar(255) DEFAULT NULL,
  `token_reset_password` varchar(255) DEFAULT NULL,
  `date_inscription` datetime DEFAULT current_timestamp(),
  `date_creation` datetime DEFAULT current_timestamp(),
  `derniere_connexion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES
(1,'Dubois','Sophie','Alpha Tech Solutions','sophie.dubois@alpha-tech.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0612345678','12 Rue des Innovations','75002','Paris','France',NULL,NULL,'actif',1,NULL,NULL,'2024-10-17 15:03:19','2025-10-17 15:03:19','2025-10-17 15:03:19'),
(2,'Lefevre','Marc','Eco Vert Jardinage','marc.lefevre@eco-vert.fr','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0789012345','45 Avenue des Champs','69003','Lyon','France',NULL,NULL,'actif',1,NULL,NULL,'2025-02-17 15:03:19','2025-10-17 15:03:19','2025-10-16 15:03:19'),
(3,'Dupont','Emma','Le Délice Boulangerie','emma.dupont@delice-boulangerie.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0123456789','8 Rue de la Patisserie','13008','Marseille','France',NULL,NULL,'actif',1,NULL,NULL,'2025-04-17 15:03:19','2025-10-17 15:03:19','2025-10-10 15:03:19'),
(4,'Petit','Thomas','Startup X','thomas.petit@startup-x.io','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0601020304','2 Impasse du Futur','33000','Bordeaux','France',NULL,NULL,'actif',0,NULL,NULL,'2025-07-17 15:03:19','2025-10-17 15:03:19',NULL),
(5,'Garcia','Laura','Cabinet Garcia & Associés','laura.garcia@cabinet-jur.fr','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','0556789012','7 Place de la Loi','31000','Toulouse','France',NULL,NULL,'actif',1,NULL,NULL,'2025-06-17 15:03:19','2025-10-17 15:03:19','2025-10-15 15:03:19'),
(6,'Panin','Elodie',NULL,'elop.panin@gmail.com','$2y$10$pi7Q5fhWki4pfgeFZQCsDu.VbEG/JxBX1KVS3JpwJZHzcIuiHiNYe',NULL,NULL,NULL,NULL,'France',NULL,NULL,'actif',0,NULL,NULL,'2025-10-31 13:52:39','2025-10-31 13:52:39',NULL),
(7,'Savoca','Nicolas',NULL,'nicolas@gmail.com','$2y$10$iTw/kug/CTRZwiXbBaksTeC8Kdac49t2O7OYSW.HyVk.jJjvgQ5Ji',NULL,NULL,NULL,NULL,'France',NULL,NULL,'actif',0,NULL,NULL,'2025-11-07 14:02:25','2025-11-07 14:02:25',NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devis`
--

DROP TABLE IF EXISTS `devis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_devis` varchar(50) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `projet_id` int(11) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `montant_ht` decimal(10,2) DEFAULT 0.00,
  `tva` decimal(5,2) DEFAULT 20.00,
  `montant_ttc` decimal(10,2) DEFAULT 0.00,
  `statut` varchar(50) DEFAULT 'en_attente',
  `date_emission` date DEFAULT NULL,
  `date_validite` date DEFAULT NULL,
  `date_acceptation` date DEFAULT NULL,
  `conditions` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `fichier_pdf` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devis`
--

LOCK TABLES `devis` WRITE;
/*!40000 ALTER TABLE `devis` DISABLE KEYS */;
INSERT INTO `devis` VALUES
(1,'DEV-2025-001',1,1,'Refonte Site Alpha Tech Solutions','Refonte complète du site institutionnel avec nouveau design responsif et optimisation SEO',3750.00,20.00,4500.00,'accepte','2025-08-01','2025-08-31','2025-08-10','Paiement: 50% acompte, 50% à livraison','Projet accepté le 10 août. Débuté 01 août.','devis_2025_001.pdf','2025-10-19 13:49:39'),
(2,'DEV-2025-002',2,2,'Boutique E-commerce Eco Vert','Plateforme e-commerce WooCommerce avec 100 produits, paiement Stripe, gestion stocks',6666.67,20.00,8000.00,'accepte','2025-07-01','2025-07-31','2025-07-05','Paiement: 30% acompte, 40% mi-projet, 30% livraison','Accepté rapidement. Excellent client.','devis_2025_002.pdf','2025-10-19 13:49:39'),
(3,'DEV-2025-003',3,3,'Identité Visuelle Délice Boulangerie','Logo + charte graphique 20 pages + supports imprimés (cartes, entête courrier)',1000.00,20.00,1200.00,'accepte','2025-06-15','2025-07-15','2025-06-20','Paiement: 50% acompte, 50% livraison','Client très enthousiaste. 3 concepts proposés.','devis_2025_003.pdf','2025-10-19 13:49:39'),
(4,'DEV-2025-004',4,4,'Landing Page Startup X','Landing page haute conversion, formulaire lead intégré, animations, SEO basique',1666.67,20.00,2000.00,'accepte','2025-05-15','2025-06-15','2025-05-18','Paiement: 50% acompte, 50% livraison','Startup rapide en prise de décision.','devis_2025_004.pdf','2025-10-19 13:49:39'),
(5,'DEV-2025-005',5,5,'Shooting Photo Cabinet Juridique','Shooting 4 heures: photos locaux + 5 portraits individuels. Retouche complète. Galerie web.',1250.00,20.00,1500.00,'accepte','2025-05-20','2025-06-20','2025-05-22','Paiement: 100% à la confirmation','Cabinet sérieux. RDV de consultation prévu.','devis_2025_005.pdf','2025-10-19 13:49:39');
/*!40000 ALTER TABLE `devis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devis_lignes`
--

DROP TABLE IF EXISTS `devis_lignes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `devis_lignes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devis_id` int(11) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `quantite` decimal(10,2) DEFAULT 1.00,
  `prix_unitaire` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `ordre_affichage` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `devis_id` (`devis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devis_lignes`
--

LOCK TABLES `devis_lignes` WRITE;
/*!40000 ALTER TABLE `devis_lignes` DISABLE KEYS */;
INSERT INTO `devis_lignes` VALUES
(1,1,'Audit et stratégie Web',1.00,500.00,500.00,1),
(2,1,'Design et maquettes (5 pages)',1.00,1500.00,1500.00,2),
(3,1,'Développement Front-end',1.00,1000.00,1000.00,3),
(4,1,'Intégration CMS WordPress',1.00,750.00,750.00,4),
(5,2,'Architecture WooCommerce',1.00,1500.00,1500.00,1),
(6,2,'Design boutique (20 pages)',1.00,2000.00,2000.00,2),
(7,2,'Intégration 100 produits',1.00,1500.00,1500.00,3),
(8,2,'Configuration Stripe + test paiement',1.00,1000.00,1000.00,4),
(9,2,'Formation client (2h)',1.00,666.67,666.67,5),
(10,3,'Création 3 concepts logo',1.00,600.00,600.00,1),
(11,3,'Charte graphique 20 pages',1.00,300.00,300.00,2),
(12,3,'Supports imprimés (design)',1.00,100.00,100.00,3),
(13,4,'Design Landing Page',1.00,800.00,800.00,1),
(14,4,'Développement + Animations',1.00,700.00,700.00,2),
(15,4,'Intégration formulaire lead',1.00,166.67,166.67,3),
(16,5,'Shooting photo 4h',1.00,800.00,800.00,1),
(17,5,'Retouche 50 photos',1.00,300.00,300.00,2),
(18,5,'Galerie web + optimisation images',1.00,150.00,150.00,3);
/*!40000 ALTER TABLE `devis_lignes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factures`
--

DROP TABLE IF EXISTS `factures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `factures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_facture` varchar(50) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `devis_id` int(11) DEFAULT NULL,
  `projet_id` int(11) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `montant_ht` decimal(10,2) DEFAULT 0.00,
  `tva` decimal(5,2) DEFAULT 20.00,
  `montant_ttc` decimal(10,2) DEFAULT 0.00,
  `montant_paye` decimal(10,2) DEFAULT 0.00,
  `statut` varchar(50) DEFAULT 'impayee',
  `moyen_paiement` varchar(50) DEFAULT NULL,
  `reference_paiement` varchar(100) DEFAULT NULL,
  `date_emission` date DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `date_paiement` date DEFAULT NULL,
  `conditions` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `fichier_pdf` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `devis_id` (`devis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factures`
--

LOCK TABLES `factures` WRITE;
/*!40000 ALTER TABLE `factures` DISABLE KEYS */;
INSERT INTO `factures` VALUES
(1,'FAC-2025-001',1,1,1,'Refonte Site Alpha Tech Solutions','Refonte complète site institutionnel - Projet terminé',3750.00,20.00,4500.00,4500.00,'payee','virement','VIR20250920ALPHATECH','2025-09-15','2025-10-15','2025-09-20','Conditions de paiement acceptées','Paiement reçu le 20/09. Projet livré.','facture_2025_001.pdf','2025-10-19 13:49:39'),
(2,'FAC-2025-002',2,2,2,'Boutique E-commerce Eco Vert','Plateforme e-commerce WooCommerce - Projet terminé',6666.67,20.00,8000.00,8000.00,'payee','virement','VIR20250918ECOVERT','2025-08-20','2025-09-20','2025-09-18','Conditions de paiement acceptées','Paiement complet reçu. Système en production.','facture_2025_002.pdf','2025-10-19 13:49:39'),
(3,'FAC-2025-003',3,3,3,'Identité Visuelle Délice Boulangerie','Logo et charte graphique - Projet terminé',1000.00,20.00,1200.00,1200.00,'payee','cheque','CHQ789456','2025-07-10','2025-08-10','2025-07-25','Conditions de paiement acceptées','Chèque reçu. Tous fichiers livrés.','facture_2025_003.pdf','2025-10-19 13:49:39'),
(4,'FAC-2025-004',4,4,4,'Landing Page Startup X','Landing page haute conversion - Projet terminé',1666.67,20.00,2000.00,2000.00,'payee','carte','CARD***6789','2025-06-05','2025-07-05','2025-06-15','Conditions de paiement acceptées','Paiement par carte approuvé. Site en ligne.','facture_2025_004.pdf','2025-10-19 13:49:39'),
(5,'FAC-2025-005',5,5,5,'Shooting Photo Cabinet Juridique','Shooting professionnel et retouche - Projet terminé',1250.00,20.00,1500.00,1500.00,'payee','virement','VIR20250628CABINET','2025-06-25','2025-07-25','2025-06-28','Conditions de paiement acceptées','Virement reçu. Galerie web livrée.','facture_2025_005.pdf','2025-10-19 13:49:39');
/*!40000 ALTER TABLE `factures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `url_projet` varchar(255) DEFAULT NULL,
  `client` varchar(150) DEFAULT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `ordre_affichage` int(11) DEFAULT 0,
  `date_realisation` date DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES
(1,'Yummy Nouille','Yummy Nouilles redéfinit l\'expérience du ramen en France à travers une immersion culinaire totale. Présente dans plusieurs grandes villes, cette enseigne propose une cuisine japonaise traditionnelle exécutée avec passion par des chefs venus directement du Japon. Chaque bol raconte une histoire de savoir-faire ancestral, où les bouillons mijotés de longues heures et les nouilles fraîches rencontrent un concept original et moderne. L\'architecture digitale que nous avons conçue pour eux reflète cette alliance entre tradition nippone et dynamisme urbain. Un projet sur-mesure pour une chaîne de restaurants qui place l\'authenticité et l\'excellence au cœur de son développement national.','site_web','yummy-nouille.png',NULL,NULL,NULL,1,0,NULL,'2026-01-24 15:46:55'),
(2,'Yummy Nouille','Yummy Nouilles redéfinit l\'expérience du ramen en France à travers une immersion culinaire totale. Présente dans plusieurs grandes villes, cette enseigne propose une cuisine japonaise traditionnelle exécutée avec passion par des chefs venus directement du Japon. Chaque bol raconte une histoire de savoir-faire ancestral, où les bouillons mijotés de longues heures et les nouilles fraîches rencontrent un concept original et moderne. L\'architecture digitale que nous avons conçue pour eux reflète cette alliance entre tradition nippone et dynamisme urbain. Un projet sur-mesure pour une chaîne de restaurants qui place l\'authenticité et l\'excellence au cœur de son développement national.','site_web','yummy-nouille-entier.png',NULL,NULL,NULL,0,0,NULL,'2026-01-24 15:46:55'),
(3,'Subway','Plongez dans l\'univers dynamique de Subway à travers une plateforme web haute en couleurs, conçue pour refléter la fraîcheur et la diversité de leurs célèbres sandwichs. Ce site au design audacieux et original propose une expérience interactive unique : un configurateur de menus sur mesure. Les utilisateurs peuvent composer leur sandwich idéal ingrédient par ingrédient, créant ainsi un repas totalement personnalisé selon leurs envies du moment. Pour les plus aventureux, nous avons intégré une fonctionnalité exclusive de sélection aléatoire, ajoutant une touche de fun et de surprise à la commande. Un projet digital innovant qui transforme la personnalisation alimentaire en un véritable jeu visuel et gastronomique.','site_web','subway.png',NULL,NULL,NULL,1,0,NULL,'2026-01-24 15:46:55'),
(4,'Subway','Plongez dans l\'univers dynamique de Subway à travers une plateforme web haute en couleurs, conçue pour refléter la fraîcheur et la diversité de leurs célèbres sandwichs. Ce site au design audacieux et original propose une expérience interactive unique : un configurateur de menus sur mesure. Les utilisateurs peuvent composer leur sandwich idéal ingrédient par ingrédient, créant ainsi un repas totalement personnalisé selon leurs envies du moment. Pour les plus aventureux, nous avons intégré une fonctionnalité exclusive de sélection aléatoire, ajoutant une touche de fun et de surprise à la commande. Un projet digital innovant qui transforme la personnalisation alimentaire en un véritable jeu visuel et gastronomique.','site_web','subway-entier.png',NULL,NULL,NULL,0,0,NULL,'2026-01-24 15:46:55'),
(5,'Soif200','SOIF 200 est une plateforme digitale immersive conçue exclusivement pour une clientèle surnaturelle, allant des vampires aux loups-garous. Sous le slogan évocateur \'Une vie éternellement confortable\', le site propose une gamme de services premium adaptés aux besoins des êtres éthérés : gestion de cryptes, soins esthétiques pour immortels et organisation d\'événements nocturnes raffinés. L\'interface, aux teintes pourpres et sombres, reflète une esthétique gothique moderne tout en offrant une navigation fluide et élégante. Avec une tarification claire pour des prestations de luxe et une section de contact directe, SOIF 200 s\'impose comme la référence absolue pour ceux qui vivent en dehors des heures solaires.','site_web','soif200.png',NULL,NULL,NULL,1,0,NULL,'2026-01-24 15:46:55'),
(6,'Soif200','SOIF 200 est une plateforme digitale immersive conçue exclusivement pour une clientèle surnaturelle, allant des vampires aux loups-garous. Sous le slogan évocateur \'Une vie éternellement confortable\', le site propose une gamme de services premium adaptés aux besoins des êtres éthérés : gestion de cryptes, soins esthétiques pour immortels et organisation d\'événements nocturnes raffinés. L\'interface, aux teintes pourpres et sombres, reflète une esthétique gothique moderne tout en offrant une navigation fluide et élégante. Avec une tarification claire pour des prestations de luxe et une section de contact directe, SOIF 200 s\'impose comme la référence absolue pour ceux qui vivent en dehors des heures solaires.','site_web','soif200-entier.png',NULL,NULL,NULL,0,0,NULL,'2026-01-24 15:46:55'),
(7,'Snapface','SnapFace est un réseau social à taille humaine, conçu pour remettre l\'essentiel au cœur des échanges numériques. Loin de la complexité des plateformes traditionnelles, il propose une interface épurée et intuitive, pensée spécifiquement pour les familles et les personnes moins à l\'aise avec la technologie. L\'objectif est simple : permettre à chacun de partager des moments de vie, des photos et des souvenirs en quelques clics seulement. Grâce à son design \'simple mais efficace\', SnapFace devient le pont idéal pour garder un contact précieux avec ses proches et ses amis, garantissant une expérience fluide où la technologie s\'efface au profit du lien social. Une solution rassurante pour ne plus jamais perdre le fil avec ceux qui comptent vraiment.','site_web','snapface.png',NULL,NULL,NULL,1,0,NULL,'2026-01-24 15:46:55'),
(8,'Snapface','SnapFace est un réseau social à taille humaine, conçu pour remettre l\'essentiel au cœur des échanges numériques. Loin de la complexité des plateformes traditionnelles, il propose une interface épurée et intuitive, pensée spécifiquement pour les familles et les personnes moins à l\'aise avec la technologie. L\'objectif est simple : permettre à chacun de partager des moments de vie, des photos et des souvenirs en quelques clics seulement. Grâce à son design \'simple mais efficace\', SnapFace devient le pont idéal pour garder un contact précieux avec ses proches et ses amis, garantissant une expérience fluide où la technologie s\'efface au profit du lien social. Une solution rassurante pour ne plus jamais perdre le fil avec ceux qui comptent vraiment.','site_web','snapface-entier.png',NULL,NULL,NULL,0,0,NULL,'2026-01-24 15:46:55'),
(9,'Bibliothèque','La plateforme Bibliothèque a été conçue comme l\'outil de gestion ultime pour les bibliophiles passionnés. Elle permet de répertorier, trier et filtrer ses ouvrages par auteur ou par genre littéraire en un clin d\'œil. Pensée pour ceux qui aiment aller à l\'essentiel, son interface épurée facilite l\'organisation d\'une collection personnelle, garantissant aux lecteurs de toujours savoir quel sera leur prochain livre. C\'est la solution idéale pour garder une vue d\'ensemble sur sa pile à lire et ne jamais se retrouver à court d\'inspiration. Un véritable assistant numérique qui transforme la gestion d\'une bibliothèque en une expérience fluide et gratifiante.','site_web','bibliotheque.png',NULL,NULL,NULL,1,0,NULL,'2026-01-24 15:46:55'),
(10,'Bibliothèque','La plateforme Bibliothèque a été conçue comme l\'outil de gestion ultime pour les bibliophiles passionnés. Elle permet de répertorier, trier et filtrer ses ouvrages par auteur ou par genre littéraire en un clin d\'œil. Pensée pour ceux qui aiment aller à l\'essentiel, son interface épurée facilite l\'organisation d\'une collection personnelle, garantissant aux lecteurs de toujours savoir quel sera leur prochain livre. C\'est la solution idéale pour garder une vue d\'ensemble sur sa pile à lire et ne jamais se retrouver à court d\'inspiration. Un véritable assistant numérique qui transforme la gestion d\'une bibliothèque en une expérience fluide et gratifiante.','site_web','bibliotheque-entier.png',NULL,NULL,NULL,0,0,NULL,'2026-01-24 15:46:55'),
(11,'LuxeList','LuxeList est une plateforme de gestion de tâches haut de gamme, conçue par des professionnels pour des professionnels exigeants. Alliant une esthétique minimaliste à une efficacité redoutable, cet outil permet de structurer vos flux de travail en catégorisant vos actions : à faire, terminées ou en cours. La force de LuxeList réside dans son compteur dynamique intégré, qui offre une vision en temps réel de l\'avancement de vos projets. C’est le compagnon idéal pour ne jamais perdre le fil au cœur d\'une production complexe et garantir une organisation sans faille. Une interface élégante au service d\'une productivité maximale, pour ceux qui ne laissent aucune place au hasard.','site_web','luxeList.png',NULL,NULL,NULL,1,0,NULL,'2026-01-24 15:46:55'),
(12,'LuxeList','LuxeList est une plateforme de gestion de tâches haut de gamme, conçue par des professionnels pour des professionnels exigeants. Alliant une esthétique minimaliste à une efficacité redoutable, cet outil permet de structurer vos flux de travail en catégorisant vos actions : à faire, terminées ou en cours. La force de LuxeList réside dans son compteur dynamique intégré, qui offre une vision en temps réel de l\'avancement de vos projets. C’est le compagnon idéal pour ne jamais perdre le fil au cœur d\'une production complexe et garantir une organisation sans faille. Une interface élégante au service d\'une productivité maximale, pour ceux qui ne laissent aucune place au hasard.','site_web','luxeList-entier.png',NULL,NULL,NULL,0,0,NULL,'2026-01-24 15:46:55');
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projets`
--

DROP TABLE IF EXISTS `projets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `projets` (
  `budget_estime` decimal(10,2) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_debut` date DEFAULT NULL,
  `date_fin_prevue` date DEFAULT NULL,
  `date_fin_reelle` date DEFAULT NULL,
  `date_modification` datetime DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` text DEFAULT NULL,
  `pourcentage_avancement` int(11) DEFAULT 0,
  `statut` varchar(50) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `type_projet` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projets`
--

LOCK TABLES `projets` WRITE;
/*!40000 ALTER TABLE `projets` DISABLE KEYS */;
INSERT INTO `projets` VALUES
(4500.00,1,'2025-10-19 13:49:38','2025-08-01','2025-09-15','2025-09-15','2025-10-19 13:49:38','Refonte complète du site institutionnel avec nouveau design',1,'Projet terminé avec succès. Client satisfait.',100,'termine','Refonte site Alpha Tech','site_web'),
(8000.00,2,'2025-10-19 13:49:38','2025-07-01','2025-08-20','2025-08-20','2025-10-19 13:49:38','Création plateforme e-commerce pour vente produits jardinage',2,'Mise en ligne et formation client complétée.',100,'termine','Boutique E-commerce Eco Vert','site_web'),
(1200.00,3,'2025-10-19 13:49:38','2025-06-15','2025-07-10','2025-07-10','2025-10-19 13:49:38','Création logo et identité visuelle complète',3,'Client très satisfait des propositions.',100,'termine','Logo + Charte Délice Boulangerie','design'),
(2000.00,4,'2025-10-19 13:49:38','2025-05-15','2025-06-05','2025-06-05','2025-10-19 13:49:38','Landing page haute conversion pour lancement produit',4,'En attente de photos produit pour finalisation.',100,'termine','Landing Page Startup X','site_web'),
(1500.00,5,'2025-10-19 13:49:38','2025-05-20','2025-06-25','2025-06-25','2025-10-19 13:49:38','Shooting photo locaux et portraits professionnels',5,'Retouches complétées, galerie en ligne livrée.',100,'termine','Photos Cabinet Juridique','photo'),
(4500.00,1,'2025-10-27 14:34:00','2025-08-01','2025-09-15','2025-09-15','2025-10-27 14:34:00','Refonte complète du site institutionnel avec nouveau design',6,'Projet terminé avec succès. Client satisfait.',100,'termine','Refonte site Alpha Tech','site_web'),
(8000.00,2,'2025-10-27 14:34:00','2025-07-01','2025-08-20','2025-08-20','2025-10-27 14:34:00','Création plateforme e-commerce pour vente produits jardinage',7,'Mise en ligne et formation client complétée.',100,'termine','Boutique E-commerce Eco Vert','site_web'),
(1200.00,3,'2025-10-27 14:34:00','2025-06-15','2025-07-10','2025-07-10','2025-10-27 14:34:00','Création logo et identité visuelle complète',8,'Client très satisfait des propositions.',100,'termine','Logo + Charte Délice Boulangerie','design'),
(2000.00,4,'2025-10-27 14:34:00','2025-05-15','2025-06-05','2025-06-05','2025-10-27 14:34:00','Landing page haute conversion pour lancement produit',9,'En attente de photos produit pour finalisation.',100,'termine','Landing Page Startup X','site_web'),
(1500.00,5,'2025-10-27 14:34:00','2025-05-20','2025-06-25','2025-06-25','2025-10-27 14:34:00','Shooting photo locaux et portraits professionnels',10,'Retouches complétées, galerie en ligne livrée.',100,'termine','Photos Cabinet Juridique','photo'),
(4500.00,1,'2025-10-27 14:34:10','2025-08-01','2025-09-15','2025-09-15','2025-10-27 14:34:10','Refonte complète du site institutionnel avec nouveau design',11,'Projet terminé avec succès. Client satisfait.',100,'termine','Refonte site Alpha Tech','site_web'),
(1200.00,3,'2025-10-27 14:34:10','2025-06-15','2025-07-10','2025-07-10','2025-10-27 14:34:10','Création logo et identité visuelle complète',13,'Client très satisfait des propositions.',100,'termine','Logo + Charte Délice Boulangerie','design'),
(2000.00,4,'2025-10-27 14:34:10','2025-05-15','2025-06-05','2025-06-05','2025-10-27 14:34:10','Landing page haute conversion pour lancement produit',14,'En attente de photos produit pour finalisation.',100,'termine','Landing Page Startup X','site_web'),
(1500.00,5,'2025-10-27 14:34:10','2025-05-20','2025-06-25','2025-06-25','2025-10-27 14:34:10','Shooting photo locaux et portraits professionnels',15,'Retouches complétées, galerie en ligne livrée.',100,'termine','Photos Cabinet Juridique','photo');
/*!40000 ALTER TABLE `projets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duree_estimee` varchar(100) DEFAULT NULL,
  `icone` varchar(100) DEFAULT NULL,
  `prix_min` decimal(10,2) DEFAULT NULL,
  `prix_max` decimal(10,2) DEFAULT NULL,
  `ordre_affichage` int(11) DEFAULT 0,
  `actif` tinyint(1) DEFAULT 1,
  `date_creation` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES
(1,'Sites Web Sur-Mesure','Développement de solutions web performantes et évolutives, pensées pour la conversion.','4-12 semaines','fa-code',950.00,5000.00,1,1,'2025-10-19 13:49:38'),
(2,'Design & Identité Visuelle','Création d\'un univers graphique unique pour affirmer votre positionnement.','1-3 semaines','fa-palette',500.00,2500.00,2,1,'2025-10-19 13:49:38'),
(3,'Photographie Professionnelle','Reportage métier et packshot produit pour humaniser votre communication.','1-2 semaines','fa-camera',350.00,1200.00,3,1,'2025-10-19 13:49:38'),
(4,'Hébergement Haute Performance & Sécurité','Offrez à votre site un environnement technique robuste, rapide et sécurisé.',NULL,'fa-code',NULL,NULL,4,1,'2025-12-30 23:05:53'),
(5,'Référencement SEO','Audit technique et optimisation sémantique pour propulser votre site en première page.','3-6 mois','fa-search',500.00,2500.00,5,1,'2025-10-19 13:49:38'),
(6,'Maintenance & Support','Externalisez la gestion technique de votre outil de travail.','Mensuel','fa-cog',50.00,200.00,6,1,'2025-10-19 13:49:38');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'oleris_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-01-30 12:20:29
