/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: kapakodu
-- ------------------------------------------------------
-- Server version	10.11.18-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `liigid`
--

DROP TABLE IF EXISTS `liigid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `liigid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nimetus` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liigid`
--

LOCK TABLES `liigid` WRITE;
/*!40000 ALTER TABLE `liigid` DISABLE KEYS */;
INSERT INTO `liigid` VALUES
(1,'Koer'),
(2,'Kass'),
(3,'Küülik');
/*!40000 ALTER TABLE `liigid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loomad`
--

DROP TABLE IF EXISTS `loomad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `loomad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `liik_id` int(10) unsigned NOT NULL,
  `toug_id` int(10) unsigned NOT NULL,
  `tootaja_id` int(10) unsigned NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `sugu` enum('isane','emane') NOT NULL,
  `vanus` int(10) unsigned NOT NULL,
  `sunnikuupaev` date DEFAULT NULL,
  `suurus` enum('väike','keskmine','suur') NOT NULL,
  `varvus` varchar(100) NOT NULL,
  `asukoht` varchar(100) NOT NULL,
  `luhikirjeldus` varchar(255) NOT NULL,
  `kirjeldus` text NOT NULL,
  `pilt` varchar(255) NOT NULL,
  `staatus` enum('saadaval','broneeritud','hoolduses') NOT NULL DEFAULT 'saadaval',
  `steriliseeritud` tinyint(1) NOT NULL DEFAULT 0,
  `kiibistatud` tinyint(1) NOT NULL DEFAULT 0,
  `lisatud` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`id`),
  KEY `fk_loomad_liik` (`liik_id`),
  KEY `fk_loomad_toug` (`toug_id`),
  KEY `fk_loomad_tootaja` (`tootaja_id`),
  CONSTRAINT `fk_loomad_liik` FOREIGN KEY (`liik_id`) REFERENCES `liigid` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_loomad_tootaja` FOREIGN KEY (`tootaja_id`) REFERENCES `tootajad` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_loomad_toug` FOREIGN KEY (`toug_id`) REFERENCES `toud` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loomad`
--

LOCK TABLES `loomad` WRITE;
/*!40000 ALTER TABLE `loomad` DISABLE KEYS */;
INSERT INTO `loomad` VALUES
(1,1,3,2,'Pontu','isane',3,'2023-04-10','keskmine','Pruun','Tallinn','Sõbralik ja mänguhimuline koer.','Pontu armastab jalutamist ja mängimist.','pontu.jpg','broneeritud',1,1,'2026-10-21'),
(3,1,1,2,'Rex','isane',2,'2023-05-12','keskmine','Kuldne','Tallinn','Sõbralik koer','Energiat täis ja armastab jalutuskäike.','rex.jpg','saadaval',1,1,'2026-07-01'),
(4,2,5,1,'Mimi','emane',6,'2020-08-14','väike','Hall-valge','Tartu','Rahulik kass','Väga sõbralik ning naudib inimese seltskonda.','mimi.jpg','saadaval',1,1,'2026-07-02'),
(5,1,2,2,'Bruno','isane',5,'2021-01-22','suur','Pruun','Pärnu','Valvekoer','Rahulik ja ustav perekoer.','bruno.jpg','broneeritud',1,1,'2026-07-03'),
(6,1,3,1,'Bella','emane',1,'2025-02-18','keskmine','Must','Haapsalu','Mänguhimuline','Noor ja aktiivne koer.','bella.jpg','saadaval',0,1,'2026-07-04'),
(7,2,4,2,'Miisu','emane',4,'2022-06-30','väike','Triibuline','Viljandi','Uudishimulik kass','Armastab ronida ja mängida.','miisu.jpg','broneeritud',1,1,'2026-07-05'),
(8,2,4,1,'Nurr','isane',3,'2023-03-10','väike','Hall','Rakvere','Vaikne kass','Sobib rahulikku koju.','nurr.jpg','hoolduses',1,0,'2026-07-06'),
(9,1,3,2,'Musti','isane',3,'2022-04-01','keskmine','Pruun-must','Tallinn','Rõõmsameelne','Naudib pikki jalutuskäike.','musti.jpg','saadaval',1,1,'2026-07-07'),
(10,1,3,1,'Lotte','emane',7,'2019-09-19','keskmine','Beež','Narva','Rahulik','Väga sõbralik vanem koer.','lotte.jpg','saadaval',1,1,'2026-07-08'),
(11,2,4,2,'Pätu','isane',2,'2024-02-11','väike','Must','Jõhvi','Mänguline','Armastab pallidega mängida.','patu.jpg','saadaval',0,1,'2026-07-09'),
(12,3,7,1,'Kribu','emane',1,'2025-01-15','väike','Valge','Tallinn','Armas küülik','Harjunud inimestega.','kribu.jpg','saadaval',0,0,'2026-07-10'),
(13,1,3,2,'Roki','isane',8,'2018-07-07','suur','Must','Tartu','Kogenud sõber','Rahulik ja kuulekas.','roki.jpg','hoolduses',1,1,'2026-07-11'),
(14,2,4,1,'Lumi','emane',5,'2021-12-24','väike','Valge','Pärnu','Hellik','Naudib pai tegemist.','lumi.jpg','saadaval',1,1,'2026-07-12'),
(15,1,3,2,'Marta','emane',4,'2022-10-09','keskmine','Pruun','Rapla','Sõbralik','Sobib lastega perre.','marta.jpg','broneeritud',1,1,'2026-07-13'),
(16,2,4,1,'Simba','isane',2,'2024-01-08','väike','Oranž','Valga','Julge','Väga uudishimulik kass.','simba.jpg','saadaval',1,0,'2026-07-14'),
(17,1,3,2,'Bobby','isane',6,'2020-05-03','suur','Must-valge','Võru','Truu kaaslane','Armastab õues joosta.','bobby.jpg','hoolduses',1,1,'2026-07-15'),
(18,2,6,1,'Kiisu','emane',1,'2025-03-14','väike','Kilpkonn','Paide','Noor kass','Õpib alles maailma tundma.','kiisu.jpg','saadaval',0,1,'2026-07-16'),
(19,1,3,2,'Rufi','isane',2,'2023-08-18','keskmine','Hall','Kuressaare','Aktiivne','Sobib sportlikule perele.','rufi.jpg','saadaval',0,1,'2026-07-17'),
(20,1,3,1,'Muri','emane',9,'2017-11-11','suur','Must','Tallinn','Rahulik','Vajab rahulikku kodu.','muri.jpg','hoolduses',1,1,'2026-07-18'),
(21,2,4,2,'Triibu','isane',7,'2019-04-20','väike','Triibuline','Põlva','Tasane','Meeldib aknal istuda.','triibu.jpg','broneeritud',1,1,'2026-07-19'),
(22,2,4,1,'Sipsik','emane',3,'2023-06-06','väike','Must-valge','Keila','Seltskondlik','Naudib mängimist ja tähelepanu.','sipsik.jpg','saadaval',1,1,'2026-07-20');
/*!40000 ALTER TABLE `loomad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nimetus` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `jarjekord` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `nahtav` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES
(1,'Avaleht','index.php',1,1),
(2,'Loomad','all_animals.php',2,1),
(3,'Kontakt','contact.php',3,1);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paringud`
--

DROP TABLE IF EXISTS `paringud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `paringud` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loom_id` int(10) unsigned DEFAULT NULL,
  `nimi` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `teema` varchar(150) NOT NULL,
  `sonum` text NOT NULL,
  `staatus` enum('uus','menetlustes','suletud') NOT NULL DEFAULT 'uus',
  `lisatud` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_paringud_loom` (`loom_id`),
  CONSTRAINT `fk_paringud_loom` FOREIGN KEY (`loom_id`) REFERENCES `loomad` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paringud`
--

LOCK TABLES `paringud` WRITE;
/*!40000 ALTER TABLE `paringud` DISABLE KEYS */;
INSERT INTO `paringud` VALUES
(1,3,'Kati Mae','kati@example.com','Rexi adopteerimine','Tere! Soovin Rexi kohta rohkem infot.','uus','2026-10-27 11:37:33'),
(2,NULL,'Martin Tamm','martin@example.com','Üldine küsimus','Millal te lahti olete?','uus','2026-10-27 11:37:33'),
(3,NULL,'Mari Tamm','mari.tamm@example.com','Küsimus adopteerimise kohta','Tere! Kuidas käib kassi adopteerimine ja kas varjupaika peab enne külastama?','uus','2026-11-04 09:20:49'),
(4,22,'Jaan Kask','jaan.kask@example.com','Sipsiku kohta','Tere! Kas Sipsik on veel saadaval ja kas ta sobib lastega peresse?','uus','2026-11-04 09:20:49'),
(5,NULL,'Liis Mägi','liis.magi@example.com','Vabatahtlikuks','Tere! Tahaksin tulla vabatahtlikuks loomi jalutama. Kuidas see käib?','menetlustes','2026-11-04 09:20:49'),
(6,NULL,'Test Testija','test@example.com','Annetamine','See on testsõnum kontrollimiseks.','uus','2026-11-04 09:24:11'),
(7,22,'Kaspar','k@example.com','Looma adopteerimine','Soovin Sipsikut adopteerida, kuidas edasi?','uus','2026-11-04 09:24:11');
/*!40000 ALTER TABLE `paringud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tootajad`
--

DROP TABLE IF EXISTS `tootajad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tootajad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nimi` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefon` varchar(30) NOT NULL,
  `parool` varchar(255) NOT NULL,
  `roll` enum('admin','töötaja') NOT NULL,
  `lisatud` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tootajad`
--

LOCK TABLES `tootajad` WRITE;
/*!40000 ALTER TABLE `tootajad` DISABLE KEYS */;
INSERT INTO `tootajad` VALUES
(1,'Alina Dmytrenko','alina@varjupaik.ee','+372 5555 1001','f9c80861456cdd34bebfa8886ae3436f22bbc7343e27df6a3376bcce23ed330d','admin','2026-10-27 11:31:39'),
(2,'Mari Tamm','mari@varjupaik.ee','+372 5555 1002','f9c80861456cdd34bebfa8886ae3436f22bbc7343e27df6a3376bcce23ed330d','töötaja','2026-10-27 11:31:39');
/*!40000 ALTER TABLE `tootajad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `toud`
--

DROP TABLE IF EXISTS `toud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `toud` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `liik_id` int(10) unsigned NOT NULL,
  `nimetus` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_toud_liik` (`liik_id`),
  CONSTRAINT `fk_toud_liik` FOREIGN KEY (`liik_id`) REFERENCES `liigid` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `toud`
--

LOCK TABLES `toud` WRITE;
/*!40000 ALTER TABLE `toud` DISABLE KEYS */;
INSERT INTO `toud` VALUES
(1,1,'Labrador'),
(2,1,'Saksa lambakoer'),
(3,1,'Segavereline'),
(4,2,'Euroopa lühikarvaline'),
(5,2,'Siiami'),
(6,2,'Maine Coon'),
(7,3,'Päkapikk-küülik');
/*!40000 ALTER TABLE `toud` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-04  9:24:22
