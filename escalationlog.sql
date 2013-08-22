/*
SQLyog Enterprise - MySQL GUI v8.05 RC 
MySQL - 5.5.8-log : Database - escalationlog_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `brands` */

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(30) DEFAULT NULL,
  `disable` smallint(6) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `center` */

DROP TABLE IF EXISTS `center`;

CREATE TABLE `center` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(100) DEFAULT NULL,
  `center_address` varchar(255) DEFAULT NULL,
  `disable` tinyint(4) DEFAULT '0',
  `center_acronym` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `issues` */

DROP TABLE IF EXISTS `issues`;

CREATE TABLE `issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(30) DEFAULT NULL,
  `disable` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Table structure for table `log_escalation` */

DROP TABLE IF EXISTS `log_escalation`;

CREATE TABLE `log_escalation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_received` date DEFAULT NULL,
  `es_from_id` int(11) DEFAULT NULL,
  `es_from` varchar(30) DEFAULT NULL,
  `cust_name` varchar(60) DEFAULT NULL,
  `serial_no` varchar(25) DEFAULT NULL,
  `brands_id` int(11) DEFAULT NULL,
  `brands` varchar(25) DEFAULT NULL,
  `issues_cat_id` int(11) DEFAULT NULL,
  `issues_cat` varchar(60) DEFAULT NULL,
  `issues_details` text,
  `sent_fj` varchar(4) DEFAULT NULL COMMENT 'Yes / No',
  `block_email_fj` varchar(4) DEFAULT NULL COMMENT 'Yes / No',
  `repeat_cust` varchar(4) DEFAULT NULL,
  `root_cause` varchar(100) DEFAULT NULL,
  `resolution_id` int(11) DEFAULT NULL,
  `resolution` text,
  `cr_no` varchar(25) DEFAULT NULL COMMENT 'Yes / No',
  `cr_deploy_date` date DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_fullname` varchar(60) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `last_updateby_id` int(11) DEFAULT NULL,
  `last_udpateby_name` varchar(25) DEFAULT NULL,
  `last_updateby_fullname` varchar(60) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `last_update_ip` varchar(20) DEFAULT NULL,
  `po_cust_impact` varchar(200) DEFAULT NULL,
  `es_status` varchar(10) DEFAULT NULL,
  `es_min` varchar(30) DEFAULT NULL,
  `es_contact` varchar(30) DEFAULT NULL,
  `ca_ticket_no` varchar(30) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `system_impacting` varchar(60) DEFAULT NULL,
  `issues_cat_other` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `es_from_id_index1` (`es_from_id`),
  KEY `brands_id_index1` (`brands_id`),
  KEY `issues_cat_id_index1` (`issues_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

/*Table structure for table `log_escalation_copy` */

DROP TABLE IF EXISTS `log_escalation_copy`;

CREATE TABLE `log_escalation_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_received` date DEFAULT NULL,
  `es_from_id` int(11) DEFAULT NULL,
  `es_from` varchar(30) DEFAULT NULL,
  `cust_name` varchar(60) DEFAULT NULL,
  `serial_no` varchar(25) DEFAULT NULL,
  `brands_id` int(11) DEFAULT NULL,
  `brands` varchar(25) DEFAULT NULL,
  `issues_cat_id` int(11) DEFAULT NULL,
  `issues_cat` varchar(60) DEFAULT NULL,
  `issues_details` text,
  `sent_fj` varchar(4) DEFAULT NULL COMMENT 'Yes / No',
  `block_email_fj` varchar(4) DEFAULT NULL COMMENT 'Yes / No',
  `repeat_cust` varchar(4) DEFAULT NULL,
  `root_cause` text,
  `resolution_id` int(11) DEFAULT NULL,
  `resolution` varchar(60) DEFAULT NULL,
  `cr_no` varchar(25) DEFAULT NULL COMMENT 'Yes / No',
  `cr_deploy_date` date DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_fullname` varchar(60) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `last_updateby_id` int(11) DEFAULT NULL,
  `last_udpateby_name` varchar(25) DEFAULT NULL,
  `last_updateby_fullname` varchar(60) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `last_update_ip` varchar(20) DEFAULT NULL,
  `po_cust_impact` varchar(200) DEFAULT NULL,
  `es_status` varchar(10) DEFAULT NULL,
  `es_min` varchar(30) DEFAULT NULL,
  `es_contact` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `es_from_id_index1` (`es_from_id`),
  KEY `brands_id_index1` (`brands_id`),
  KEY `issues_cat_id_index1` (`issues_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

/*Table structure for table `log_issues` */

DROP TABLE IF EXISTS `log_issues`;

CREATE TABLE `log_issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `issue_no` varchar(25) DEFAULT NULL,
  `total_downtime` varchar(10) DEFAULT NULL,
  `total_downtime_in_sec` int(11) DEFAULT NULL,
  `sys_impacting` text,
  `sys_impacting_other` varchar(60) DEFAULT NULL,
  `center` varchar(200) DEFAULT NULL,
  `incident_no` varchar(25) DEFAULT NULL,
  `issue_desc` text,
  `root_cause` varchar(60) DEFAULT NULL,
  `root_cause_id` int(11) DEFAULT NULL,
  `cr_no` varchar(25) DEFAULT NULL,
  `cr_deploy_date` date DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolve_by` varchar(40) DEFAULT NULL,
  `po_cust_impact` varchar(200) DEFAULT NULL,
  `ca_ticket_no` varchar(25) DEFAULT NULL,
  `notification_no` varchar(25) DEFAULT NULL,
  `staff_mia` int(11) DEFAULT '0',
  `staff_atl` int(11) DEFAULT '0',
  `agent_impacted` int(11) DEFAULT '0',
  `drop_calls` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_fullname` varchar(60) DEFAULT NULL,
  `last_updateby_id` int(11) DEFAULT NULL,
  `last_udpateby_name` varchar(25) DEFAULT NULL,
  `last_updateby_fullname` varchar(60) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `last_update_ip` varchar(20) DEFAULT NULL,
  `tobetag` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=latin1;

/*Table structure for table `log_issues_copy` */

DROP TABLE IF EXISTS `log_issues_copy`;

CREATE TABLE `log_issues_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `issue_no` varchar(25) DEFAULT NULL,
  `total_downtime` varchar(10) DEFAULT NULL,
  `total_downtime_in_sec` int(11) DEFAULT NULL,
  `sys_impacting` text,
  `sys_impacting_other` varchar(60) DEFAULT NULL,
  `center` varchar(200) DEFAULT NULL,
  `incident_no` varchar(25) DEFAULT NULL,
  `issue_desc` text,
  `root_cause` varchar(60) DEFAULT NULL,
  `root_cause_id` int(11) DEFAULT NULL,
  `cr_no` varchar(25) DEFAULT NULL,
  `cr_deploy_date` date DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolve_by` varchar(40) DEFAULT NULL,
  `po_cust_impact` varchar(200) DEFAULT NULL,
  `ca_ticket_no` varchar(25) DEFAULT NULL,
  `notification_no` varchar(25) DEFAULT NULL,
  `staff_mia` int(11) DEFAULT '0',
  `staff_atl` int(11) DEFAULT '0',
  `agent_impacted` int(11) DEFAULT '0',
  `drop_calls` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL,
  `user_fullname` varchar(60) DEFAULT NULL,
  `last_updateby_id` int(11) DEFAULT NULL,
  `last_udpateby_name` varchar(25) DEFAULT NULL,
  `last_updateby_fullname` varchar(60) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `last_update_ip` varchar(20) DEFAULT NULL,
  `tobetag` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=274 DEFAULT CHARSET=latin1;

/*Table structure for table `log_issues_sysimp_link` */

DROP TABLE IF EXISTS `log_issues_sysimp_link`;

CREATE TABLE `log_issues_sysimp_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_issue_id` int(11) DEFAULT NULL,
  `sys_imp_id` int(11) DEFAULT NULL,
  `sys_imp` varchar(30) DEFAULT NULL,
  `sys_imp_other` varchar(60) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`log_issue_id`),
  KEY `NewIndex2` (`sys_imp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;

/*Table structure for table `log_issues_sysimp_link_copy` */

DROP TABLE IF EXISTS `log_issues_sysimp_link_copy`;

CREATE TABLE `log_issues_sysimp_link_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_issue_id` int(11) DEFAULT NULL,
  `sys_imp_id` int(11) DEFAULT NULL,
  `sys_imp` varchar(30) DEFAULT NULL,
  `sys_imp_other` varchar(60) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`log_issue_id`),
  KEY `NewIndex2` (`sys_imp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=latin1;

/*Table structure for table `root_cause` */

DROP TABLE IF EXISTS `root_cause`;

CREATE TABLE `root_cause` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(60) DEFAULT NULL,
  `disable` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `system_impacting` */

DROP TABLE IF EXISTS `system_impacting`;

CREATE TABLE `system_impacting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(30) DEFAULT NULL,
  `disable` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_from` */

DROP TABLE IF EXISTS `tbl_from`;

CREATE TABLE `tbl_from` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(30) DEFAULT NULL,
  `disable` smallint(6) DEFAULT '0',
  `ordering` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '4',
  `centerid` int(11) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(34) NOT NULL,
  `fullname` varchar(60) DEFAULT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `access` varchar(100) DEFAULT NULL,
  `isVisible` smallint(6) DEFAULT '1',
  `isSuper` smallint(6) DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) DEFAULT NULL,
  `newpass` varchar(34) DEFAULT NULL,
  `newpass_key` varchar(32) DEFAULT NULL,
  `newpass_time` datetime DEFAULT NULL,
  `last_ip` varchar(40) DEFAULT NULL,
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

/* Procedure structure for procedure `escalationsourse` */

/*!50003 DROP PROCEDURE IF EXISTS  `escalationsourse` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `escalationsourse`( yr CHAR(4) )
BEGIN
	DECLARE done INT DEFAULT FALSE; 
	
	declare fid INT;
	DECLARE fdesc char(20);
	
	DECLARE lfrom CHAR(20);
	DECLARE ldate char(8);
	DECLARE lcount int;
	 
	DECLARE cur_froms CURSOR FOR SELECT id, tbl_from.desc FROM tbl_from;		 
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done := TRUE; 
	
	drop temporary table if EXISTS query_eslog;	
	
	OPEN cur_froms;
	
	create temporary table query_eslog(
		desc1 varchar(20),
		m01 int,
		m02 int,
		m03 int,
		m04 INT,
		m05 INT,
		m06 INT,
		m07 INT,
		m08 INT,
		m09 INT,
		m10 INT,
		m11 INT,
		m12 INT
	)ENGINE=MYISAM;
	
	read_loop: LOOP
		fetch cur_froms into fid, fdesc;
		if done THEN
			LEAVE read_loop;
		end if;
		BLOCK2: BEGIN
		DECLARE done1 INT DEFAULT FALSE;		
		DECLARE logs1 CURSOR FOR SELECT  es_from, DATE_FORMAT(created_date,'%m'), COUNT(*)  FROM log_escalation  WHERE  DATE_FORMAT(created_date,'%Y') = yr and es_from_id = fid GROUP BY DATE_FORMAT(created_date,'%Y-%m');
		
		DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 := TRUE;		
		
		INSERT INTO query_eslog(desc1) VALUES(fdesc);	
		
		open logs1;
		read_logs1: LOOP
			FETCH logs1 INTO lfrom, ldate, lcount;
				
			IF done1 THEN
				LEAVE read_logs1;
			END IF;		
			 
			CASE 
				WHEN ldate = '01' THEN 	UPDATE query_eslog SET  m01=lcount WHERE desc1=lfrom;
				WHEN ldate = '02' THEN 	UPDATE query_eslog SET  m02=lcount WHERE desc1=lfrom;
				WHEN ldate = '03' THEN 	UPDATE query_eslog SET  m03=lcount WHERE desc1=lfrom;
				WHEN ldate = '04' THEN 	UPDATE query_eslog SET  m04=lcount WHERE desc1=lfrom;
				WHEN ldate = '05' THEN 	UPDATE query_eslog SET  m05=lcount WHERE desc1=lfrom;
				WHEN ldate = '06' THEN 	UPDATE query_eslog SET  m06=lcount WHERE desc1=lfrom;
				WHEN ldate = '07' THEN 	UPDATE query_eslog SET  m07=lcount WHERE desc1=lfrom;
				WHEN ldate = '08' THEN 	UPDATE query_eslog SET  m08=lcount WHERE desc1=lfrom;
				WHEN ldate = '09' THEN 	UPDATE query_eslog SET  m09=lcount WHERE desc1=lfrom;
				WHEN ldate = '10' THEN 	UPDATE query_eslog SET  m10=lcount WHERE desc1=lfrom;
				WHEN ldate = '11' THEN 	UPDATE query_eslog SET  m11=lcount WHERE desc1=lfrom;
				WHEN ldate = '12' THEN 	UPDATE query_eslog SET  m12=lcount WHERE desc1=lfrom;
			END CASE;			
			 
			
		END LOOP read_logs1;
		end BLOCK2;
	END LOOP read_loop;
	
	select * from query_eslog;
	DROP TEMPORARY TABLE IF EXISTS query_eslog; 
	
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;