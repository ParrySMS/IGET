CREATE DATABASE  IF NOT EXISTS `iget` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `iget`;
-- MySQL dump 10.13  Distrib 5.7.14, for Win64 (x86_64)
--
-- Host: localhost    Database: iget
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ig_all_badge`
--

DROP TABLE IF EXISTS `ig_all_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_all_badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `intro` varchar(400) DEFAULT NULL,
  `pic` varchar(200) NOT NULL,
  `exp` int(11) NOT NULL DEFAULT '0',
  `gp` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_all_badge`
--

LOCK TABLES `ig_all_badge` WRITE;
/*!40000 ALTER TABLE `ig_all_badge` DISABLE KEYS */;
INSERT INTO `ig_all_badge` VALUES (1,'书写小能手','人文底蕴',NULL,'1.png',1,1,1),(2,'朗读小老师','人文底蕴',NULL,'2.png',1,1,1),(3,'小小数学家','科学精神',NULL,'3.png',1,1,1),(4,'小小科学家','科学精神',NULL,'4.png',1,1,1);
/*!40000 ALTER TABLE `ig_all_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_badge_storage`
--

DROP TABLE IF EXISTS `ig_badge_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_badge_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bs_num` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `schbadge_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_badge_storage`
--

LOCK TABLES `ig_badge_storage` WRITE;
/*!40000 ALTER TABLE `ig_badge_storage` DISABLE KEYS */;
INSERT INTO `ig_badge_storage` VALUES (1,1,NULL,1,1),(2,1,NULL,2,1),(3,1,NULL,3,1),(4,1,NULL,4,1),(5,2,NULL,1,1),(6,2,NULL,2,1),(7,2,NULL,3,1),(8,2,NULL,4,1),(9,3,NULL,1,1),(10,3,NULL,2,1),(11,3,NULL,3,1),(12,3,NULL,4,1),(13,4,NULL,5,1),(14,4,NULL,6,1),(15,4,NULL,7,1),(16,4,NULL,8,1),(17,5,NULL,5,1),(18,5,NULL,6,1),(19,5,NULL,7,1),(20,5,NULL,8,1),(21,6,NULL,1,1),(22,6,NULL,2,1),(23,6,NULL,3,1),(24,6,NULL,4,1);
/*!40000 ALTER TABLE `ig_badge_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_class`
--

DROP TABLE IF EXISTS `ig_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `school` varchar(500) NOT NULL,
  `sch_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_class`
--

LOCK TABLES `ig_class` WRITE;
/*!40000 ALTER TABLE `ig_class` DISABLE KEYS */;
INSERT INTO `ig_class` VALUES (1,1,2016,'水田小学',1,1),(2,1,2017,'水田小学',1,1),(3,2,2017,'水田小学',1,1),(4,1,2017,'深圳小学',2,1),(5,2,2017,'深圳小学',2,1);
/*!40000 ALTER TABLE `ig_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_group`
--

DROP TABLE IF EXISTS `ig_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_num` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_group`
--

LOCK TABLES `ig_group` WRITE;
/*!40000 ALTER TABLE `ig_group` DISABLE KEYS */;
INSERT INTO `ig_group` VALUES (1,1,'智慧小组',1,1,1,1),(2,1,'智慧小组',2,1,1,1),(3,2,'希望小组',3,1,1,1),(4,2,'希望小组',4,1,1,1),(5,3,'快乐小组',5,1,1,0),(6,3,'快乐小组',6,1,1,1),(7,3,'快乐小组',7,1,1,1);
/*!40000 ALTER TABLE `ig_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_group_character`
--

DROP TABLE IF EXISTS `ig_group_character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_group_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_num` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `lv` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `gp` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_group_character`
--

LOCK TABLES `ig_group_character` WRITE;
/*!40000 ALTER TABLE `ig_group_character` DISABLE KEYS */;
INSERT INTO `ig_group_character` VALUES (3,1,1,1,1,1,1,1),(4,2,1,1,1,1,1,1);
/*!40000 ALTER TABLE `ig_group_character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_log_group_badge`
--

DROP TABLE IF EXISTS `ig_log_group_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_log_group_badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(50) NOT NULL,
  `awarder_num` int(11) NOT NULL,
  `awarder_name` varchar(50) NOT NULL,
  `group_num` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `schbadge_id` int(11) NOT NULL,
  `message` varchar(400) DEFAULT NULL,
  `class` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `sch_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_log_group_badge`
--

LOCK TABLES `ig_log_group_badge` WRITE;
/*!40000 ALTER TABLE `ig_log_group_badge` DISABLE KEYS */;
INSERT INTO `ig_log_group_badge` VALUES (4,'2018-02-07 18:55:49',123001,'傅松',1,'智慧小组','数学',3,NULL,1,2,1,1,1),(5,'2018-02-18 17:34:16',123001,'傅松',2,'希望小组','数学',3,NULL,1,2,1,1,1);
/*!40000 ALTER TABLE `ig_log_group_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_log_single_badge`
--

DROP TABLE IF EXISTS `ig_log_single_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_log_single_badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(50) NOT NULL,
  `awarder_num` int(11) NOT NULL,
  `awarder_name` varchar(50) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `schbadge_id` int(11) NOT NULL,
  `message` varchar(400) DEFAULT NULL,
  `class` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `sch_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_log_single_badge`
--

LOCK TABLES `ig_log_single_badge` WRITE;
/*!40000 ALTER TABLE `ig_log_single_badge` DISABLE KEYS */;
INSERT INTO `ig_log_single_badge` VALUES (1,'2018-02-06 17:50:54',123001,'傅松',3,'蔡翔一','数学',3,NULL,1,1,2,1,1),(2,'2018-02-07 17:38:50',123001,'傅松',3,'蔡翔一','数学',3,NULL,1,1,2,1,0),(3,'2018-02-18 16:00:06',123001,'傅松',3,'蔡翔一','数学',3,NULL,1,1,2,1,1),(4,'2018-02-18 16:29:25',123001,'傅松',3,'蔡翔一','数学',3,NULL,1,1,2,1,0),(5,'2018-02-18 17:12:20',123003,'丁根宝',3,'蔡翔一','英语',1,NULL,1,1,2,1,1);
/*!40000 ALTER TABLE `ig_log_single_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_sch_badge`
--

DROP TABLE IF EXISTS `ig_sch_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_sch_badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allbadge_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `intro` varchar(400) DEFAULT NULL,
  `pic` varchar(200) NOT NULL,
  `exp` int(11) NOT NULL DEFAULT '0',
  `gp` int(11) NOT NULL DEFAULT '0',
  `sch_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_sch_badge`
--

LOCK TABLES `ig_sch_badge` WRITE;
/*!40000 ALTER TABLE `ig_sch_badge` DISABLE KEYS */;
INSERT INTO `ig_sch_badge` VALUES (1,1,'书写小能手','人文底蕴',NULL,'1.png',1,1,1,1),(2,2,'朗读小老师','人文底蕴',NULL,'2.png',1,1,1,1),(3,3,'小小数学家','科学精神',NULL,'3.png',1,1,1,1),(4,4,'小小科学家','科学精神',NULL,'4.png',1,1,1,1),(5,5,'书写小能手','人文底蕴',NULL,'1.png',1,1,2,1),(6,6,'朗读小老师','人文底蕴',NULL,'2.png',1,1,2,1),(7,7,'小小数学家','科学精神',NULL,'3.png',1,1,2,1),(8,8,'小小科学家','科学精神',NULL,'4.png',1,1,2,1);
/*!40000 ALTER TABLE `ig_sch_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_school`
--

DROP TABLE IF EXISTS `ig_school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `town` varchar(50) DEFAULT NULL,
  `name` varchar(500) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_school`
--

LOCK TABLES `ig_school` WRITE;
/*!40000 ALTER TABLE `ig_school` DISABLE KEYS */;
INSERT INTO `ig_school` VALUES (1,'广东省','深圳市',NULL,'水田小学',1),(2,'广东省','深圳市',NULL,'深圳小学',1);
/*!40000 ALTER TABLE `ig_school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_single_character`
--

DROP TABLE IF EXISTS `ig_single_character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_single_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `lv` int(11) NOT NULL DEFAULT '0',
  `exp` int(11) NOT NULL DEFAULT '0',
  `gp` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_single_character`
--

LOCK TABLES `ig_single_character` WRITE;
/*!40000 ALTER TABLE `ig_single_character` DISABLE KEYS */;
INSERT INTO `ig_single_character` VALUES (1,3,2,1,1,2,2,1),(2,3,2,3,1,1,1,1);
/*!40000 ALTER TABLE `ig_single_character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_student`
--

DROP TABLE IF EXISTS `ig_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_num` int(11) NOT NULL,
  `sex` enum('男','女','保密') NOT NULL DEFAULT '保密',
  `icon` varchar(200) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `patents_uid` int(11) DEFAULT '0',
  `sch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_student`
--

LOCK TABLES `ig_student` WRITE;
/*!40000 ALTER TABLE `ig_student` DISABLE KEYS */;
INSERT INTO `ig_student` VALUES (1,20160101,'保密','1.png','张海粟',1,0,1,6,1),(2,20160102,'保密','2.png','陈臻毅',1,0,1,7,1),(3,20170101,'保密','3.png','蔡翔一',2,0,1,8,1),(4,20170102,'保密','4.png','赵耀',2,0,1,9,1),(5,20160103,'保密','5.png','李周蜜',1,0,1,10,1),(6,20160104,'保密','6.png','安梦琪',1,0,1,11,1),(7,20160105,'保密','7.png','吴王博',1,0,1,12,1),(8,20160106,'保密','8.png','马晨恺',1,0,1,13,1);
/*!40000 ALTER TABLE `ig_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_subject`
--

DROP TABLE IF EXISTS `ig_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  `sch_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_subject`
--

LOCK TABLES `ig_subject` WRITE;
/*!40000 ALTER TABLE `ig_subject` DISABLE KEYS */;
INSERT INTO `ig_subject` VALUES (1,'数学',1,1),(2,'语文',1,1),(3,'英语',1,1),(4,'音乐',1,1),(5,'美术',1,1),(6,'体育',1,1),(7,'思想品德',1,1),(8,'书法',1,1),(9,'劳动',1,1);
/*!40000 ALTER TABLE `ig_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_teacher`
--

DROP TABLE IF EXISTS `ig_teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_num` int(11) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `bs_num` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `sch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_teacher`
--

LOCK TABLES `ig_teacher` WRITE;
/*!40000 ALTER TABLE `ig_teacher` DISABLE KEYS */;
INSERT INTO `ig_teacher` VALUES (1,123001,'1.png','傅松',1,1,1,1,1,1),(2,123002,'2.png','郑瑾',1,2,2,1,2,1),(3,123003,'3.png','丁根宝',2,3,3,1,3,1),(4,123004,'4.png','励聪 ',3,4,5,1,4,1),(5,123005,'5.png','罗雨峰',4,5,6,1,5,1),(6,123001,'1.png','傅松',2,1,1,1,1,1);
/*!40000 ALTER TABLE `ig_teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ig_user`
--

DROP TABLE IF EXISTS `ig_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ig_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `openid` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `sch_id` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ig_user`
--

LOCK TABLES `ig_user` WRITE;
/*!40000 ALTER TABLE `ig_user` DISABLE KEYS */;
INSERT INTO `ig_user` VALUES (1,'123001','202cb962ac59075b964b07152d234b70','傅松',NULL,1,1,1),(2,'123002','202cb962ac59075b964b07152d234b70','郑瑾',NULL,1,1,1),(3,'123003','202cb962ac59075b964b07152d234b70','丁根宝',NULL,1,1,1),(4,'123004','202cb962ac59075b964b07152d234b70','励聪 ',NULL,1,2,1),(5,'123005','202cb962ac59075b964b07152d234b70','罗雨峰',NULL,1,2,1),(6,'20160101','202cb962ac59075b964b07152d234b70','张海粟',NULL,0,1,1),(7,'20160102','202cb962ac59075b964b07152d234b70','陈臻毅',NULL,0,1,1),(8,'20170101','202cb962ac59075b964b07152d234b70','蔡翔一',NULL,0,1,1),(9,'20170102','202cb962ac59075b964b07152d234b70','赵耀',NULL,0,1,1),(10,'20160103','202cb962ac59075b964b07152d234b70','李周蜜',NULL,0,1,1),(11,'20160104','202cb962ac59075b964b07152d234b70','安梦琪',NULL,0,1,1),(12,'20160105','202cb962ac59075b964b07152d234b70','吴王博',NULL,0,1,1),(13,'20160106','202cb962ac59075b964b07152d234b70','马晨恺',NULL,0,1,1);
/*!40000 ALTER TABLE `ig_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-18 23:56:07
