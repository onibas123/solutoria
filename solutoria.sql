/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.15-log : Database - solutoria
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`solutoria` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `solutoria`;

/*Table structure for table `indicators` */

DROP TABLE IF EXISTS `indicators`;

CREATE TABLE `indicators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `indicators` */

insert  into `indicators`(`id`,`code`,`name`,`value`,`date`,`created`,`modified`) values (1,'uf','Unidad de fomento (U',29741.33,'2021-07-14','2021-07-14 17:26:16','2021-07-14 17:26:16'),(4,'uf','Unidad de fomento (U',29712.8,'2021-07-01','2021-07-14 18:05:59','2021-07-14 18:05:59'),(5,'uf','Unidad de fomento (U',29712.8,'2021-07-01','2021-07-14 18:11:24','2021-07-14 18:11:24'),(6,'uf','Unidad de fomento (U',29741.33,'2021-07-14','2021-07-14 18:11:34','2021-07-14 18:11:34'),(7,'uf','Unidad de fomento (U',29712.8,'2021-07-01','2021-07-14 18:11:44','2021-07-14 18:11:44'),(8,'uf','Unidad de fomento (U',29712.8,'2021-07-01','2021-07-14 18:11:54','2021-07-14 18:11:54'),(9,'uf','Unidad de fomento (U',29439.2,'2021-04-15','2021-07-14 18:13:12','2021-07-14 18:35:54');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
