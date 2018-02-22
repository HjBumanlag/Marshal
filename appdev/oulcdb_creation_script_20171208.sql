-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: oulcdb
-- ------------------------------------------------------
-- Server version	5.7.20-log

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
-- Table structure for table `accesslevel_ref`
--

DROP TABLE IF EXISTS `accesslevel_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesslevel_ref` (
  `code` varchar(5) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesslevel_ref`
--

LOCK TABLES `accesslevel_ref` WRITE;
/*!40000 ALTER TABLE `accesslevel_ref` DISABLE KEYS */;
INSERT INTO `accesslevel_ref` (`code`, `description`) VALUES ('R','Read'),('RE ','Read  Edit'),('RED','Read  Edit Delete'),('REDA','Read Edit Delete Add');
/*!40000 ALTER TABLE `accesslevel_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions_audit`
--

DROP TABLE IF EXISTS `actions_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions_audit` (
  `actionDate` datetime NOT NULL,
  `username` varchar(45) NOT NULL,
  `actionPerformed` longtext NOT NULL,
  `affectedTables` longtext NOT NULL,
  `referenceRow` varchar(45) NOT NULL,
  KEY `fk_actions_audit_users_idx` (`username`),
  CONSTRAINT `fk_actions_audit_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions_audit`
--

LOCK TABLES `actions_audit` WRITE;
/*!40000 ALTER TABLE `actions_audit` DISABLE KEYS */;
/*!40000 ALTER TABLE `actions_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `entryNo` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`entryNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_audit`
--

DROP TABLE IF EXISTS `comment_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_audit` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `documentTrackingNumber` int(11) DEFAULT NULL,
  `documentTitle` varchar(45) DEFAULT NULL,
  `Comments` varchar(20) DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`commentID`),
  KEY `fk_docu_title_idx` (`documentTitle`),
  KEY `fk_docu_trackingnum_idx` (`documentTrackingNumber`),
  CONSTRAINT `fk_docu_title_idx` FOREIGN KEY (`documentTitle`) REFERENCES `documents` (`title`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_docu_trackingnum_idx` FOREIGN KEY (`documentTrackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_audit`
--

LOCK TABLES `comment_audit` WRITE;
/*!40000 ALTER TABLE `comment_audit` DISABLE KEYS */;
INSERT INTO `comment_audit` (`commentID`, `documentTrackingNumber`, `documentTitle`, `Comments`, `dateUpdated`) VALUES (3,201700003,'Sample 3','meow','2017-12-08 02:30:30'),(4,201700001,'Sample 1','sdasdsa','2017-12-08 02:33:07');
/*!40000 ALTER TABLE `comment_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doc_path_ref`
--

DROP TABLE IF EXISTS `doc_path_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_path_ref` (
  `doctype` varchar(5) NOT NULL,
  `sequence` int(3) NOT NULL,
  `officeCode` varchar(10) NOT NULL,
  `pathName` varchar(45) NOT NULL,
  KEY `DOC_PATH_REF_OFFICE_FK_idx` (`officeCode`),
  KEY `DOC_PATH_REF_DOC_TYPE_REF_FK_idx` (`doctype`),
  CONSTRAINT `DOC_PATH_REF_DOC_TYPE_REF_FK` FOREIGN KEY (`doctype`) REFERENCES `doc_type_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `DOC_PATH_REF_OFFICE_FK` FOREIGN KEY (`officeCode`) REFERENCES `office` (`officeCode`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_path_ref`
--

LOCK TABLES `doc_path_ref` WRITE;
/*!40000 ALTER TABLE `doc_path_ref` DISABLE KEYS */;
/*!40000 ALTER TABLE `doc_path_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doc_type_ref`
--

DROP TABLE IF EXISTS `doc_type_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_type_ref` (
  `code` varchar(5) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_type_ref`
--

LOCK TABLES `doc_type_ref` WRITE;
/*!40000 ALTER TABLE `doc_type_ref` DISABLE KEYS */;
INSERT INTO `doc_type_ref` (`code`, `description`) VALUES ('D','Donation'),('ELC','Employee Labor Contract'),('G','Grant'),('IL','Industry Linkages'),('LA','Licensing Agreement'),('MOA','Memorandum of Agreement'),('O','Others (please specify)'),('RA','Research Agreement'),('SA','Sponsorship Agreement'),('SeA','Service Agreement'),('SFE','Student & Faculty Exchange');
/*!40000 ALTER TABLE `doc_type_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_annotations`
--

DROP TABLE IF EXISTS `document_annotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_annotations` (
  `annotationTrackingNumber` int(11) NOT NULL,
  `docTrackingNumber` int(11) NOT NULL,
  `dateAnnotated` date NOT NULL,
  `annotatedBy` varchar(45) NOT NULL,
  `annotations` varchar(50) NOT NULL,
  KEY `fk_document_annotations_documents1_idx` (`docTrackingNumber`),
  CONSTRAINT `fk_document_annotations_documents1` FOREIGN KEY (`docTrackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_annotations`
--

LOCK TABLES `document_annotations` WRITE;
/*!40000 ALTER TABLE `document_annotations` DISABLE KEYS */;
INSERT INTO `document_annotations` (`annotationTrackingNumber`, `docTrackingNumber`, `dateAnnotated`, `annotatedBy`, `annotations`) VALUES (20170001,201700002,'2017-08-07','Christopher Cruz','No further comments');
/*!40000 ALTER TABLE `document_annotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_approved`
--

DROP TABLE IF EXISTS `document_approved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_approved` (
  `trackingNumber` int(11) NOT NULL,
  `duration` varchar(45) NOT NULL,
  `dateSubmissionOfFinalCopy` date NOT NULL,
  `dateApproved` date NOT NULL,
  `finalComments` varchar(45) DEFAULT NULL,
  KEY `fk_document_approved_documents_idx` (`trackingNumber`),
  CONSTRAINT `fk_document_approved_documents` FOREIGN KEY (`trackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_approved`
--

LOCK TABLES `document_approved` WRITE;
/*!40000 ALTER TABLE `document_approved` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_approved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_file`
--

DROP TABLE IF EXISTS `document_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_file` (
  `trackingNumber` int(11) NOT NULL,
  `fileID` int(11) NOT NULL,
  `fileName` varchar(100) NOT NULL,
  `fileType` longtext,
  `filesize` int(11) DEFAULT NULL,
  PRIMARY KEY (`fileID`),
  KEY `trackingNumber` (`trackingNumber`),
  CONSTRAINT `document_file_ibfk_1` FOREIGN KEY (`trackingNumber`) REFERENCES `documents` (`trackingNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_file`
--

LOCK TABLES `document_file` WRITE;
/*!40000 ALTER TABLE `document_file` DISABLE KEYS */;
INSERT INTO `document_file` (`trackingNumber`, `fileID`, `fileName`, `fileType`, `filesize`) VALUES (201700005,20170000,'2015maf.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document',687854);
/*!40000 ALTER TABLE `document_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_path`
--

DROP TABLE IF EXISTS `document_path`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_path` (
  `trackingNumber` int(11) NOT NULL,
  `doctype` varchar(5) NOT NULL,
  `sequence` int(3) NOT NULL,
  `officeCode` varchar(10) NOT NULL,
  `status` varchar(45) NOT NULL,
  `dateReceived` date DEFAULT NULL,
  `dateReleased` date DEFAULT NULL,
  KEY `fk_document_path_documents1_idx` (`trackingNumber`),
  KEY `fk_document_path_office1_idx` (`officeCode`),
  KEY `fk_document_path_doc_type_ref1` (`doctype`),
  CONSTRAINT `fk_document_path_doc_type_ref1` FOREIGN KEY (`doctype`) REFERENCES `doc_type_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_document_path_documents1` FOREIGN KEY (`trackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_document_path_office1` FOREIGN KEY (`officeCode`) REFERENCES `office` (`officeCode`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_path`
--

LOCK TABLES `document_path` WRITE;
/*!40000 ALTER TABLE `document_path` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_path` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_revisions`
--

DROP TABLE IF EXISTS `document_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_revisions` (
  `revisionTrackingNumber` int(11) NOT NULL,
  `docTrackingNumber` int(11) NOT NULL,
  `version` int(3) NOT NULL,
  KEY `fk_document_revisions_documents1_idx` (`docTrackingNumber`),
  CONSTRAINT `fk_document_revisions_documents1` FOREIGN KEY (`docTrackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_revisions`
--

LOCK TABLES `document_revisions` WRITE;
/*!40000 ALTER TABLE `document_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `trackingNumber` int(11) NOT NULL,
  `requestingPartyID` int(11) DEFAULT NULL,
  `title` varchar(45) NOT NULL,
  `type` varchar(3) NOT NULL,
  `processingType` varchar(3) NOT NULL,
  `scope` varchar(45) NOT NULL,
  `startingDate` date NOT NULL,
  `amount` float DEFAULT NULL,
  `summary` varchar(50) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `duration` varchar(10) DEFAULT NULL,
  `annotationTrackingNumber` int(11) DEFAULT NULL,
  `revisionTrackingNumber` int(11) DEFAULT NULL,
  `status` varchar(3) NOT NULL,
  `dateApproved` date DEFAULT NULL,
  `dateSubmissionOfFinalCopy` date DEFAULT NULL,
  `finalComments` longtext,
  `store_safe` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`trackingNumber`,`type`,`processingType`,`status`),
  KEY `fk_documents_requesting_party1_idx` (`requestingPartyID`),
  KEY `fk_documents_doc_type_ref1_idx` (`type`),
  KEY `fk_documents_status_ref1_idx` (`status`),
  KEY `fk_documents_process_type_ref1_idx` (`processingType`),
  KEY `fk_docu_title` (`title`),
  CONSTRAINT `fk_documents_doc_type_ref1` FOREIGN KEY (`type`) REFERENCES `doc_type_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_process_type_ref1` FOREIGN KEY (`processingType`) REFERENCES `process_type_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_requesting_party1` FOREIGN KEY (`requestingPartyID`) REFERENCES `requesting_party` (`idNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documents_status_ref1` FOREIGN KEY (`status`) REFERENCES `status_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` (`trackingNumber`, `requestingPartyID`, `title`, `type`, `processingType`, `scope`, `startingDate`, `amount`, `summary`, `remarks`, `duration`, `annotationTrackingNumber`, `revisionTrackingNumber`, `status`, `dateApproved`, `dateSubmissionOfFinalCopy`, `finalComments`, `store_safe`) VALUES (201700001,11500000,'Sample 1','G','RR','College','2017-08-07',NULL,'Sample Doc','SAMPLE DOC',NULL,NULL,NULL,'FR',NULL,NULL,'sdasdsa',0),(201700002,11500001,'Sample 2','SeA','RR','College','2017-08-07',NULL,'Sample 2','SAMPLE 2','1 day',20170001,NULL,'AFP','2017-08-07','2017-08-07',NULL,0),(201700003,11500002,'Sample 3','MOA','ER','Department','2017-08-07',NULL,'Sample Doc 3','SAMPLE DOC 3',NULL,NULL,20170001,'R',NULL,NULL,NULL,1),(201700004,11500004,'Sample 4','IL','RR','College','2018-01-10',10000,'Sample Doc 4','Fix it please','2 years',NULL,NULL,'IR',NULL,NULL,'this is almost done but pls review for grammar errors',0),(201700004,11500003,'hello','SA','RR','College','2017-12-08',200,'something something','something else','',NULL,NULL,'IR',NULL,NULL,NULL,1),(201700005,11500003,'hello','SA','RR','College','2017-12-08',200,'something something','something else','',NULL,NULL,'OA',NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_access`
--

DROP TABLE IF EXISTS `form_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_access` (
  `accessID` int(11) NOT NULL AUTO_INCREMENT,
  `formTrackingNumber` int(11) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `accessLevel` varchar(45) DEFAULT NULL,
  `formTitle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`accessID`),
  KEY `username` (`username`),
  KEY `aclvl` (`accessLevel`),
  KEY `fk_tn` (`formTrackingNumber`),
  CONSTRAINT `fk_access_id` FOREIGN KEY (`accessLevel`) REFERENCES `accesslevel_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tn` FOREIGN KEY (`formTrackingNumber`) REFERENCES `form_access_request` (`formTrackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `form_access_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_access`
--

LOCK TABLES `form_access` WRITE;
/*!40000 ALTER TABLE `form_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_access_req_audit`
--

DROP TABLE IF EXISTS `form_access_req_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_access_req_audit` (
  `requestID` int(11) DEFAULT NULL,
  `dateRequested` datetime DEFAULT NULL,
  `dateStatusChange` datetime DEFAULT NULL,
  `auditID` int(11) NOT NULL AUTO_INCREMENT,
  `statusChange` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`auditID`),
  KEY `fk_req_id` (`requestID`),
  KEY `fk_date_requested` (`dateRequested`),
  KEY `fk_status` (`statusChange`),
  CONSTRAINT `fk_date_req` FOREIGN KEY (`dateRequested`) REFERENCES `form_access_request` (`dateRequested`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_req_id` FOREIGN KEY (`requestID`) REFERENCES `form_access_request` (`requestID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_status` FOREIGN KEY (`statusChange`) REFERENCES `form_access_request` (`StatusRequest`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_access_req_audit`
--

LOCK TABLES `form_access_req_audit` WRITE;
/*!40000 ALTER TABLE `form_access_req_audit` DISABLE KEYS */;
INSERT INTO `form_access_req_audit` (`requestID`, `dateRequested`, `dateStatusChange`, `auditID`, `statusChange`) VALUES (4,'2017-12-07 17:01:07','2017-12-07 17:09:52',16,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:12:08',17,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:12:17',18,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:13:37',19,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:23:45',20,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:24:01',21,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:38:16',22,'Rejected'),(4,'2017-12-07 17:01:07','2017-12-07 17:39:25',23,'Rejected'),(4,'2017-12-07 17:01:07','2017-12-07 17:40:19',24,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:40:49',25,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:41:03',26,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:42:21',27,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:42:40',28,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:43:00',29,NULL),(4,'2017-12-07 17:01:07','2017-12-07 17:46:57',30,NULL),(4,'2017-12-07 17:01:07','2017-12-07 20:22:07',31,NULL),(4,'2017-12-07 17:01:07',NULL,32,NULL),(1,'2017-09-05 10:30:00',NULL,33,NULL),(1,'2017-09-05 10:30:00',NULL,34,NULL),(1,'2017-09-05 10:30:00',NULL,35,NULL),(1,'2017-09-05 10:30:00',NULL,36,NULL),(1,'2017-09-05 10:30:00',NULL,37,NULL),(1,'2017-09-05 10:30:00',NULL,38,NULL),(1,'2017-09-05 10:30:00',NULL,39,NULL),(1,'2017-09-05 10:30:00',NULL,40,NULL),(1,'2017-09-05 10:30:00',NULL,41,NULL),(1,'2017-09-05 10:30:00',NULL,42,NULL),(1,'2017-09-05 10:30:00',NULL,43,NULL),(4,'2017-12-07 17:01:07',NULL,44,'Rejected'),(1,'2017-09-05 10:30:00',NULL,45,'Rejected'),(1,'2017-09-05 10:30:00',NULL,46,'Rejected');
/*!40000 ALTER TABLE `form_access_req_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_access_request`
--

DROP TABLE IF EXISTS `form_access_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_access_request` (
  `requestID` int(11) NOT NULL AUTO_INCREMENT,
  `formTrackingNumber` int(11) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `StatusRequest` varchar(45) DEFAULT 'Pending',
  `accessLevelRequested` varchar(45) DEFAULT NULL,
  `formTitle` varchar(45) DEFAULT NULL,
  `dateRequested` datetime NOT NULL,
  PRIMARY KEY (`requestID`),
  KEY `username` (`username`),
  KEY `fk_date_req` (`dateRequested`),
  KEY `fk_tn` (`formTrackingNumber`),
  KEY `fk_stat` (`StatusRequest`),
  KEY `fk_access_lvl` (`accessLevelRequested`),
  KEY `fk_form_title_idx` (`formTitle`),
  KEY `form_title` (`formTitle`),
  CONSTRAINT `fk_access_lvl` FOREIGN KEY (`accessLevelRequested`) REFERENCES `accesslevel_ref` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_forms_title` FOREIGN KEY (`formTitle`) REFERENCES `forms` (`formTitle`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `form_access_request_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_access_request`
--

LOCK TABLES `form_access_request` WRITE;
/*!40000 ALTER TABLE `form_access_request` DISABLE KEYS */;
INSERT INTO `form_access_request` (`requestID`, `formTrackingNumber`, `username`, `StatusRequest`, `accessLevelRequested`, `formTitle`, `dateRequested`) VALUES (1,20170001,'admin','Pending','RE','Form 1','2017-09-05 10:30:00'),(2,20170002,'cao','Pending','RE','Form 2','2017-12-06 14:33:00'),(3,20170003,'accounting','Pending','RED','Form 3','2017-12-06 14:37:01'),(4,20170004,'accounting','Pending','RE','Form 4','2017-12-07 17:01:07');
/*!40000 ALTER TABLE `form_access_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_todipo`
--

DROP TABLE IF EXISTS `form_todipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_todipo` (
  `formTrackingNumber` int(11) NOT NULL,
  `dateReceived` date NOT NULL,
  KEY `fk_form_todipo_forms_idx` (`formTrackingNumber`),
  CONSTRAINT `fk_form_todipo_forms` FOREIGN KEY (`formTrackingNumber`) REFERENCES `forms` (`formTrackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_todipo`
--

LOCK TABLES `form_todipo` WRITE;
/*!40000 ALTER TABLE `form_todipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_todipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_tooulc`
--

DROP TABLE IF EXISTS `form_tooulc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_tooulc` (
  `formTrackingNumber` int(11) NOT NULL,
  `dateReceived` date NOT NULL,
  KEY `fk_form_tooulc_forms_idx` (`formTrackingNumber`),
  CONSTRAINT `fk_form_tooulc_forms` FOREIGN KEY (`formTrackingNumber`) REFERENCES `forms` (`formTrackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_tooulc`
--

LOCK TABLES `form_tooulc` WRITE;
/*!40000 ALTER TABLE `form_tooulc` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_tooulc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_type_ref`
--

DROP TABLE IF EXISTS `form_type_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_type_ref` (
  `formType` varchar(5) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`formType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_type_ref`
--

LOCK TABLES `form_type_ref` WRITE;
/*!40000 ALTER TABLE `form_type_ref` DISABLE KEYS */;
INSERT INTO `form_type_ref` (`formType`, `description`) VALUES ('ERIO','ERIO Form'),('FRF','Final Review Form'),('IRF','Initial Review Form'),('TF2','Test Form 2');
/*!40000 ALTER TABLE `form_type_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forms` (
  `formTrackingNumber` int(11) NOT NULL,
  `docTrackingNumber` int(11) NOT NULL,
  `formType` varchar(5) NOT NULL,
  `formTitle` varchar(45) NOT NULL,
  `dateAdded` date NOT NULL,
  PRIMARY KEY (`formTrackingNumber`),
  KEY `fk_forms_documents1_idx` (`docTrackingNumber`),
  KEY `fk_forms_form_type_ref_idx` (`formType`),
  KEY `fk_forms_title` (`formTitle`),
  CONSTRAINT `fk_forms_documents1` FOREIGN KEY (`docTrackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_forms_form_type_ref` FOREIGN KEY (`formType`) REFERENCES `form_type_ref` (`formType`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
INSERT INTO `forms` (`formTrackingNumber`, `docTrackingNumber`, `formType`, `formTitle`, `dateAdded`) VALUES (20170001,201700001,'IRF','Form 1','2017-08-07'),(20170002,201700002,'FRF','Form 2','2017-08-15'),(20170003,201700001,'IRF','Form 3','2017-08-07'),(20170004,201700002,'FRF','Form 4','2017-08-20');
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initial_review`
--

DROP TABLE IF EXISTS `initial_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initial_review` (
  `trackingNumber` int(11) NOT NULL,
  `initialReviewDate` date NOT NULL,
  `IRFDateReceivedOULC` date NOT NULL,
  `IRFDateReceivedDIPO` date NOT NULL,
  `dateReceivedWithIRF` date NOT NULL,
  KEY `fk_initial_review_documents1_idx` (`trackingNumber`),
  CONSTRAINT `fk_initial_review_documents1` FOREIGN KEY (`trackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initial_review`
--

LOCK TABLES `initial_review` WRITE;
/*!40000 ALTER TABLE `initial_review` DISABLE KEYS */;
INSERT INTO `initial_review` (`trackingNumber`, `initialReviewDate`, `IRFDateReceivedOULC`, `IRFDateReceivedDIPO`, `dateReceivedWithIRF`) VALUES (201700001,'2017-08-07','2017-08-07','2017-08-07','2017-08-07');
/*!40000 ALTER TABLE `initial_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `loginTicket` int(20) NOT NULL,
  `userType` int(3) NOT NULL,
  `username` varchar(45) NOT NULL,
  `inTime` datetime DEFAULT NULL,
  `outTime` datetime DEFAULT NULL,
  UNIQUE KEY `loginTicket_UNIQUE` (`loginTicket`),
  KEY `fk_login_users_idx` (`username`),
  CONSTRAINT `fk_login_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`loginTicket`, `userType`, `username`, `inTime`, `outTime`) VALUES (1,101,'admin','2017-01-01 12:02:00','2017-01-01 12:30:00'),(2,102,'legalcounsel','2017-01-01 15:30:00','2017-01-01 16:00:04'),(3,103,'assistantlegalcounsel','2017-01-02 16:23:08','2017-01-02 17:02:00'),(4,104,'secretary','2017-01-02 12:00:17','2017-01-02 12:51:34'),(5,105,'cao','2017-12-08 01:01:13','2017-12-08 01:01:18'),(6,101,'admin','2017-12-08 01:01:26','2017-12-08 01:01:50'),(7,105,'cao','2017-12-08 01:01:54','2017-12-08 01:02:06'),(8,101,'admin','2017-12-08 01:02:10','2017-12-08 01:03:46'),(9,104,'secretary','2017-12-08 01:03:55','2017-12-08 01:04:12'),(10,101,'admin','2017-12-08 01:04:17','2017-12-08 01:41:41'),(11,101,'admin','2017-12-08 01:50:11','2017-12-08 06:08:35'),(12,102,'legalcounsel','2017-12-08 06:08:43','2017-12-08 08:22:55'),(13,103,'assistantlegalcounsel','2017-12-08 08:23:07','2017-12-08 08:23:36'),(14,104,'secretary','2017-12-08 08:25:26','2017-12-08 09:40:15'),(15,105,'cao','2017-12-08 09:40:20','2017-12-08 10:08:44'),(16,104,'secretary','2017-12-08 10:09:01','2017-12-08 10:26:06'),(17,104,'secretary','2017-12-08 10:34:37','2017-12-08 10:53:31');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `office`
--

DROP TABLE IF EXISTS `office`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `office` (
  `officeCode` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `contactPerson` varchar(45) NOT NULL,
  PRIMARY KEY (`officeCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `office`
--

LOCK TABLES `office` WRITE;
/*!40000 ALTER TABLE `office` DISABLE KEYS */;
INSERT INTO `office` (`officeCode`, `name`, `contactPerson`) VALUES ('A','Accounting','$$$$$'),('AARO','Alumni Advancement and Relations Office','Big Shaq'),('CAO','Culture and Arts Office','CAO Person'),('HSO','Health Services Office','Ship Mahlown'),('ITEO','Institutional Testing and Evaluation Office','Nik E. Minaj'),('LG','Legal Counsel','Atty. Christopher Cruz'),('LSPO','Lasallian Pastoral Office','Br. Mark'),('OAS','Office of Admissions and Scholarships','Caardi B.'),('OCCS','Office of Counseling and Career Services','Bodak Yellow'),('OSM','Office of Strategic Management','Man\'s not hot'),('PMO','Personnel Management Office','Jeff'),('R','Registrar','It\'s Ya Boi'),('RMCA','Risk Management and Compliance Office','Joji'),('SDFO','Student Discipline and Formation Office','Whomst Thy Contact'),('SMO','Student Media Office','H. Styles'),('SO','Safety Office','Martha Stewart'),('STRATCOM','Office of the Excecutive Director for Strategic Communications','He Who Must Not Be Named'),('USO','University Safety Office','Jodi Sta. Maria'),('VCA','Office of the Vice Chancellor for Academics','Boo K. Wurm');
/*!40000 ALTER TABLE `office` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_type_ref`
--

DROP TABLE IF EXISTS `process_type_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process_type_ref` (
  `code` varchar(5) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_type_ref`
--

LOCK TABLES `process_type_ref` WRITE;
/*!40000 ALTER TABLE `process_type_ref` DISABLE KEYS */;
INSERT INTO `process_type_ref` (`code`, `description`) VALUES ('ER','Express Review'),('RR','Regular Review');
/*!40000 ALTER TABLE `process_type_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requesting_party`
--

DROP TABLE IF EXISTS `requesting_party`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requesting_party` (
  `college` varchar(6) NOT NULL,
  `department` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `contactPerson` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `idNumber` int(11) NOT NULL,
  PRIMARY KEY (`idNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requesting_party`
--

LOCK TABLES `requesting_party` WRITE;
/*!40000 ALTER TABLE `requesting_party` DISABLE KEYS */;
INSERT INTO `requesting_party` (`college`, `department`, `name`, `contactPerson`, `email`, `idNumber`) VALUES ('CCS','','CPL','Someone','someone@dlsu.edu.ph',11500000),('COB','Marketing','JEMA','Someone2','someone2@dlsu.edu.ph',11500001),('COE','',NULL,'Someone 3','someone_3@dlsu.edu.ph',11500002),('CLA','Psychology',NULL,'Someone4','someone_4@dlsu.edu.ph',11500003),('CLA','Behavioural Sciences',NULL,'Someone5','someone_5@dlsu.edu.ph',11500004),('CLA','Literature',NULL,'Someone6','someone_6@dlsu.edu.ph',11500005),('CLA','History',NULL,'Someone7','someone_7@dlsu.edu.ph',11500006),('CLA','Political Science',NULL,'Someone8','someone_8@dlsu.edu.ph',11500007),('CLA','Communication',NULL,'Someone10','someone_10@dlsu.edu.ph',11500009),('COB','Commercial Law',NULL,'Someone11','someone_11@dlsu.edu.ph',11500010),('COS','Biology',NULL,'Someone12','someone_12@dlsu.edu.ph',11500011),('COS','Chemistry',NULL,'Someone12','someone_13@dlsu.edu.ph',11500012);
/*!40000 ALTER TABLE `requesting_party` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_change_audit`
--

DROP TABLE IF EXISTS `status_change_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_change_audit` (
  `auditID` int(11) NOT NULL AUTO_INCREMENT,
  `previousStatus` varchar(45) DEFAULT NULL,
  `newStatus` varchar(45) DEFAULT NULL,
  `documentNumber` int(11) DEFAULT NULL,
  `dateChanged` datetime DEFAULT NULL,
  PRIMARY KEY (`auditID`),
  KEY `fk_docu_num` (`documentNumber`),
  CONSTRAINT `fk_docu_num` FOREIGN KEY (`documentNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_change_audit`
--

LOCK TABLES `status_change_audit` WRITE;
/*!40000 ALTER TABLE `status_change_audit` DISABLE KEYS */;
INSERT INTO `status_change_audit` (`auditID`, `previousStatus`, `newStatus`, `documentNumber`, `dateChanged`) VALUES (1,'OR','DR',201700004,'2017-12-07 18:19:49'),(2,'IR','OA',201700005,NULL),(3,'OA','OA',201700005,NULL),(4,'OA','OA',201700005,NULL),(5,'OA','OA',201700005,NULL);
/*!40000 ALTER TABLE `status_change_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_ref`
--

DROP TABLE IF EXISTS `status_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_ref` (
  `code` varchar(5) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_ref`
--

LOCK TABLES `status_ref` WRITE;
/*!40000 ALTER TABLE `status_ref` DISABLE KEYS */;
INSERT INTO `status_ref` (`code`, `description`) VALUES ('A','Archived'),('AFP','Approved for Printing'),('D','Deadlocked'),('DA','DIPO Approval'),('DR','DIPO Review'),('EC','Escalated to Chancellor'),('ES','External Signing'),('IR','Initial Reception'),('NCC','Notarization and Completion of Contract'),('NF','No Finalized'),('OA','OULC Approval'),('OR','OULC Review'),('R','Rejected'),('RFNR','Recevied for Next Review'),('RFRF','Receive Final Review Form'),('RIRF','Receive Initial Review Form'),('ROC','Receive Original Copy with annexes'),('RtRP','Return document to Requesting Party');
/*!40000 ALTER TABLE `status_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storesafe_audit`
--

DROP TABLE IF EXISTS `storesafe_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storesafe_audit` (
  `auditID` int(11) NOT NULL AUTO_INCREMENT,
  `documentTrackingNumber` int(11) NOT NULL,
  `documentTitle` varchar(45) NOT NULL,
  `safe_stat` int(11) DEFAULT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`auditID`),
  KEY `fk_safe_status_idx` (`safe_stat`),
  KEY `fk_docu_trackingnum_idx` (`documentTrackingNumber`),
  KEY `fk_docu_title_idx` (`documentTitle`),
  CONSTRAINT `fk_docu_title` FOREIGN KEY (`documentTitle`) REFERENCES `documents` (`title`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_docu_trackingnum` FOREIGN KEY (`documentTrackingNumber`) REFERENCES `documents` (`trackingNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_safe_status` FOREIGN KEY (`safe_stat`) REFERENCES `statmade` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storesafe_audit`
--

LOCK TABLES `storesafe_audit` WRITE;
/*!40000 ALTER TABLE `storesafe_audit` DISABLE KEYS */;
INSERT INTO `storesafe_audit` (`auditID`, `documentTrackingNumber`, `documentTitle`, `safe_stat`, `dateUpdated`) VALUES (15,201700002,'Sample 2',0,'2017-12-08 02:26:24'),(16,201700002,'Sample 2',0,'2017-12-08 02:26:31'),(17,201700004,'Sample 4',1,'2017-12-08 02:26:46'),(18,201700004,'Sample 4',1,'2017-12-08 02:26:48'),(19,201700004,'Sample 4',1,'2017-12-08 02:27:28'),(20,201700004,'Sample 4',0,'2017-12-08 02:27:35');
/*!40000 ALTER TABLE `storesafe_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(25) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `userType` int(3) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `firstName`, `lastName`, `userType`) VALUES (7,'accounting','accounting','Reech','Munai',104),(1,'admin','webadmin','John','Baptiste',101),(3,'assistantlegalcounsel','assistantlegalcounsel','Jack','Black',103),(6,'cao','cao','Jerimiah','Ocamps',105),(2,'legalcounsel','legalcounsel','Christopher','Cruz',102),(5,'occsmean','occsmean','Mean','Tesoro',105),(4,'secretary','secretary','Nina','Lang',104);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'oulcdb'
--

--
-- Dumping routines for database 'oulcdb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-08 10:56:23
