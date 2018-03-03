/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.7.11 : Database - iget
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`iget` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `iget`;

/*Table structure for table `ig_user` */

DROP TABLE IF EXISTS `ig_user`;

CREATE TABLE `ig_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(500) DEFAULT NULL,
  `pw_encrypt` varchar(500) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `openid` varchar(500) DEFAULT NULL,
  `type` varchar(500) DEFAULT NULL,
  `sch_id` int(11) DEFAULT NULL,
  `visible` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `ig_user` */

insert  into `ig_user`(`id`,`account`,`pw_encrypt`,`name`,`openid`,`type`,`sch_id`,`visible`) values (1,'123001','44209a6a592dea91bcf7d4dd53e47a5a','傅松',NULL,'teacher',1,1),(2,'123002','44209a6a592dea91bcf7d4dd53e47a5a','郑瑾',NULL,'teacher',1,1),(3,'123003','44209a6a592dea91bcf7d4dd53e47a5a','丁根宝',NULL,'teacher',1,1),(4,'123004','44209a6a592dea91bcf7d4dd53e47a5a','励聪 ',NULL,'teacher',2,1),(5,'123005','44209a6a592dea91bcf7d4dd53e47a5a','罗雨峰',NULL,'teacher',2,1),(6,'20160101','44209a6a592dea91bcf7d4dd53e47a5a','张海粟',NULL,'student',1,1),(7,'20160102','44209a6a592dea91bcf7d4dd53e47a5a','陈臻毅',NULL,'student',1,1),(8,'20170101','44209a6a592dea91bcf7d4dd53e47a5a','蔡翔一',NULL,'student',1,1),(9,'20170102','44209a6a592dea91bcf7d4dd53e47a5a','赵耀',NULL,'student',1,1),(10,'20160103','44209a6a592dea91bcf7d4dd53e47a5a','李周蜜',NULL,'student',1,1),(11,'20160104','44209a6a592dea91bcf7d4dd53e47a5a','安梦琪',NULL,'student',1,1),(12,'20160105','44209a6a592dea91bcf7d4dd53e47a5a','吴王博',NULL,'student',1,1),(13,'20160106','44209a6a592dea91bcf7d4dd53e47a5a','马晨恺',NULL,'student',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
