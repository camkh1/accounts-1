/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.17 : Database - music_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`music_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `music_db`;

/*Table structure for table `m_category` */

DROP TABLE IF EXISTS `m_category`;

CREATE TABLE `m_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_lml` varchar(100) DEFAULT NULL,
  `name_utf` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `image` varchar(150) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `m_category` */

insert  into `m_category`(`id`,`name_lml`,`name_utf`,`parent_id`,`status`,`image`,`slug`) values (1,'Language','ភាសា',0,1,'','language'),(2,'Khmer Songs','ចម្រៀងខ្មែរ',1,1,'https://lh3.googleusercontent.com/-KZQ0acE0aDY/Vg5eSftz32I/AAAAAAAAOSg/reiMw9aPPhc/s418-Ic42/0001.jpg','khmer-songs'),(3,'Khmer Surin','ខ្មែរសុរិន្ទ',1,1,'https://lh3.googleusercontent.com/-e-jLiXWgPko/Vg5fDbNqTtI/AAAAAAAAOSo/aYnuwOEbR4Y/s128-Ic42/0001.jpg','khmer-surin'),(4,'English songs','ចម្រៀងអង់គ្លេស',1,1,'http://1.bp.blogspot.com/_jQMLbN6FKNw/TGK3QfUXL2I/AAAAAAAAACQ/nMR3n0hGyoA/s100/Copia+de+Justin+Bieber.jpg','english-songs'),(5,'Korean Songs','ចម្រៀងកូរ៉េ',1,1,'http://1.bp.blogspot.com/-yjQfR4sjv1I/UEBJRcr1iWI/AAAAAAAAOgY/LYmVqDNuqD8/s100-c/IU+Lee+Ji+Eun+Korean+singer+cute.jpg','korean-songs'),(6,'Thai Songs','ចម្រៀងថៃ',1,1,'http://4.bp.blogspot.com/-shay-KRAG-g/Uvyxu6-nyjI/AAAAAAAAKsQ/4YiBgYzofEY/s100-c/tai.jpg','thai-songs'),(7,'Production','ផលិតកម្ម',0,1,'','production'),(8,'Bigman','ប៊ីកមែន',7,1,'http://2.bp.blogspot.com/-8jFVACSI_u0/VZq0iJYAkeI/AAAAAAAAKbg/5NFoHhTyvRs/s150-c/bigman.png','bigman'),(9,'Rock','រ៉ុក',7,1,'http://2.bp.blogspot.com/-okUN-mMRG1w/VZq1OpScNWI/AAAAAAAAKbo/e4BzdbhYURQ/s150-c/Rock-production-logo.jpg','rock'),(10,'Trojeakkam','ត្រចៀកកម្ម',7,1,'http://3.bp.blogspot.com/--isRclY_XAg/VZq3XUvDaUI/AAAAAAAAKcE/VSwdVqaPnUg/s150-c/trojeakkam.jpg','trojeakkam'),(11,'Diamond music','ដាយអឹមែន',7,1,'http://2.bp.blogspot.com/-rf9izIJunrw/VcGrCPweWZI/AAAAAAAACn0/wkmKYuTuuyg/s150-c/Diamond%2BMusic.jpg','diamond-music'),(12,'C-Star','ស៊ីស្តារ',7,1,'http://2.bp.blogspot.com/-g5ycolNbqy8/VcGsqnvXS9I/AAAAAAAACoA/y-GmBZW1KPo/s150-c/C-Star.jpg','c-star'),(13,'SaSda','សាស្ដា',7,1,'http://3.bp.blogspot.com/-KpVo8cJRDu8/VcGuiYpScbI/AAAAAAAACoM/OlEDCsLsn5g/s150-c/SaSda.jpg','sasda'),(14,'WE','វី',7,1,'http://3.bp.blogspot.com/-dK9c8czayIo/VcGvPwitMlI/AAAAAAAACoU/RGOsGpJZhmU/s150-c/WE%2BProductions.jpg','we'),(15,'Phleng Record','ភ្លេងរីខត',7,1,'http://3.bp.blogspot.com/-AeUPk-nfTfA/VZq2LDfovfI/AAAAAAAAKb0/RbCax2vavmk/s150-c/phlengRecord.jpg','phleng-record'),(16,'M','អ៊ឹម',7,1,'http://4.bp.blogspot.com/-qzd4gDf-jrU/VZq254ytJhI/AAAAAAAAKb8/DVEx7VXpF8k/s150-c/m.jpg','m'),(17,'Hang Meas','ហង្សមាស',7,1,'http://3.bp.blogspot.com/-5P9KoT5dcTg/VZq4J5BCiPI/AAAAAAAAKcU/eJPZz8z427o/s150-c/hangMeas.jpg','hang-meas'),(18,'Town','ថោន',7,1,'http://2.bp.blogspot.com/-bHaduefYTcc/VZq3tYzw3MI/AAAAAAAAKcM/gOCO88rkVyc/s150-c/town.jpg','town'),(19,'Sunday','សាន់ដេ',7,1,'http://1.bp.blogspot.com/-SpkUlcF6PIo/VZqj_kMeJ3I/AAAAAAAAKbU/XedB1Gfc5yw/s150-c/sunday.jpg','sunday'),(20,'Artist','អ្នកចម្រៀង',0,1,'','artist'),(21,'Vichaboth','វីជ្ជបុត្រ',20,1,'http://4.bp.blogspot.com/-Qyt3qph800U/VZdOApJ5EXI/AAAAAAAABV4/UettJXIlofE/s72-c/Vichaboth.JPG','vichaboth');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
