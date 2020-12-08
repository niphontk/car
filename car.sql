/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : car

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-12-08 08:37:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for approve
-- ----------------------------
DROP TABLE IF EXISTS `approve`;
CREATE TABLE `approve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of approve
-- ----------------------------
INSERT INTO `approve` VALUES ('1', 'อนุมัติ');
INSERT INTO `approve` VALUES ('2', 'ไม่อนุมัติ');

-- ----------------------------
-- Table structure for brand
-- ----------------------------
DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of brand
-- ----------------------------
INSERT INTO `brand` VALUES ('47', '22', 'TOYOTA', 'Y', 'N', '2020-05-13 09:13:03', '2020-05-13 09:13:03');
INSERT INTO `brand` VALUES ('48', '21', 'TOYOTA', 'Y', 'N', '2020-05-13 09:13:12', '2020-05-13 09:13:12');
INSERT INTO `brand` VALUES ('49', '21', 'NISSAN', 'Y', 'N', '2020-05-13 09:13:21', '2020-05-13 09:13:21');
INSERT INTO `brand` VALUES ('50', '19', 'TOYOTA', 'Y', 'N', '2020-05-13 09:13:32', '2020-05-13 09:13:32');
INSERT INTO `brand` VALUES ('51', '20', 'TOYOTA', 'Y', 'N', '2020-05-13 09:13:37', '2020-05-13 09:13:37');
INSERT INTO `brand` VALUES ('52', '20', 'FORD', 'Y', 'N', '2020-05-13 10:57:00', '2020-05-13 10:57:00');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('29', 'รถยนต์', 'Y', 'N', '2020-05-13 09:11:40', '2020-05-13 09:11:40');
INSERT INTO `category` VALUES ('30', 'รถตู้', 'Y', 'N', '2020-05-13 09:11:46', '2020-05-13 09:11:46');

-- ----------------------------
-- Table structure for check
-- ----------------------------
DROP TABLE IF EXISTS `check`;
CREATE TABLE `check` (
  `check_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `check_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `check_result_id` tinyint(1) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `check_by_id` tinyint(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`check_id`),
  KEY `check_result` (`check_result_id`) USING BTREE,
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `checkby` (`check_by_id`) USING BTREE,
  CONSTRAINT `check_ibfk_1` FOREIGN KEY (`check_result_id`) REFERENCES `check_result` (`CHECK_RESULT_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `check_ibfk_2` FOREIGN KEY (`check_by_id`) REFERENCES `check_by` (`CHECK_BY_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `check_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `items` (`ITEM_ID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of check
-- ----------------------------

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `depart_name` varchar(200) DEFAULT '',
  `is_active` enum('Y','N') DEFAULT NULL,
  `is_delete` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('1', 'งานเวชระเบียน', 'Y', 'N');
INSERT INTO `department` VALUES ('2', 'ห้องตรวจ1', 'Y', 'N');
INSERT INTO `department` VALUES ('3', 'ห้องตรวจ2', 'Y', 'N');
INSERT INTO `department` VALUES ('4', 'ห้องอุบัติเหตุฉุกเฉิน', 'Y', 'N');
INSERT INTO `department` VALUES ('5', 'ห้องทันตกรรม', 'Y', 'N');
INSERT INTO `department` VALUES ('6', 'ห้องแพทย์แผนไทย(บริการ)', 'Y', 'N');
INSERT INTO `department` VALUES ('7', 'ห้องกายภาพ', 'Y', 'N');
INSERT INTO `department` VALUES ('8', 'ตึกกุมารเวชกรรม', 'Y', 'N');
INSERT INTO `department` VALUES ('9', 'ห้องคลังยา', 'Y', 'N');
INSERT INTO `department` VALUES ('10', 'ห้องเภสัชกรรมผู้ป่วยนอก', 'Y', 'N');
INSERT INTO `department` VALUES ('11', 'งานการเงิน', 'Y', 'N');
INSERT INTO `department` VALUES ('12', 'ห้องประชุมพนาภินันท์', 'Y', 'N');
INSERT INTO `department` VALUES ('13', 'ห้องกลุ่มงานบริหาร', 'Y', 'N');
INSERT INTO `department` VALUES ('14', 'ห้องงานเคลม', 'Y', 'N');
INSERT INTO `department` VALUES ('15', 'กลุ่มงานเทคนิคการแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('16', 'ห้อง X-RAY', 'Y', 'N');
INSERT INTO `department` VALUES ('17', 'ห้อง SERVER', 'Y', 'N');
INSERT INTO `department` VALUES ('18', 'ห้องพักแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('19', 'ห้องผู้อำนวยการ', 'Y', 'N');
INSERT INTO `department` VALUES ('20', 'ห้องกลุ่มการพยาบาล', 'Y', 'N');
INSERT INTO `department` VALUES ('21', 'ห้องคลินิกเฉพาะโรค', 'Y', 'N');
INSERT INTO `department` VALUES ('22', 'ห้องกลุ่มงานเวชปฏิบัติฯ', 'Y', 'N');
INSERT INTO `department` VALUES ('23', 'หน้าห้องตรวจแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('24', 'ผู้ป่วยนอก(OPD)', 'Y', 'N');
INSERT INTO `department` VALUES ('25', 'ห้องตรวจ 3', 'Y', 'N');
INSERT INTO `department` VALUES ('26', 'ห้องตรวจ 4', 'Y', 'N');
INSERT INTO `department` VALUES ('27', 'ห้องตรวจ 5', 'Y', 'N');
INSERT INTO `department` VALUES ('28', 'ห้องตรวจ 6', 'Y', 'N');
INSERT INTO `department` VALUES ('29', 'ห้องตรวจ 7', 'Y', 'N');
INSERT INTO `department` VALUES ('30', 'ห้องตรวจ 8', 'Y', 'N');
INSERT INTO `department` VALUES ('31', 'ห้องตรวจ 9', 'Y', 'N');
INSERT INTO `department` VALUES ('32', 'กลุ่มงานประกันสุขภาพ ยุทธศาสตร์และสารสนเทศทางการแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('33', 'งานสารสนเทศทางการแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('34', '	ห้องแพทย์แผนไทย(ผลิต)', 'Y', 'N');
INSERT INTO `department` VALUES ('35', 'ตึก ICU', 'Y', 'N');
INSERT INTO `department` VALUES ('36', 'งานพัสดุ', 'Y', 'N');
INSERT INTO `department` VALUES ('37', 'งานธุรการ', 'Y', 'N');
INSERT INTO `department` VALUES ('38', 'ศูนย์ยานพาหนะ', 'Y', 'N');
INSERT INTO `department` VALUES ('39', 'งานคุณภาพ', 'Y', 'N');
INSERT INTO `department` VALUES ('40', 'งานคลินิกพิเศษ', 'Y', 'N');
INSERT INTO `department` VALUES ('41', 'ศูนย์ไต', 'Y', 'N');
INSERT INTO `department` VALUES ('42', 'ห้องเภสัชกรรมผู้ป่วยใน', 'Y', 'N');
INSERT INTO `department` VALUES ('43', 'ตึกนรีเวชกรรม', 'Y', 'N');
INSERT INTO `department` VALUES ('44', 'ตึกพิเศษ', 'Y', 'N');
INSERT INTO `department` VALUES ('45', 'ห้องผ่าตัด', 'Y', 'N');
INSERT INTO `department` VALUES ('46', 'ตึกอายุรกรรมชาย', 'Y', 'N');
INSERT INTO `department` VALUES ('47', 'ตึกอายุรกรรมหญิง', 'Y', 'N');
INSERT INTO `department` VALUES ('48', 'ตึกศัลยกรรม ออร์โธ', 'Y', 'N');
INSERT INTO `department` VALUES ('49', 'งานห้องคลอด', 'Y', 'N');
INSERT INTO `department` VALUES ('50', 'ห้องเก็บเงิน', 'Y', 'N');
INSERT INTO `department` VALUES ('51', 'ศูนย์ซ่อมบำรุง', 'Y', 'N');
INSERT INTO `department` VALUES ('52', 'คลินิกฟ้าใส', 'Y', 'N');
INSERT INTO `department` VALUES ('53', 'งาน PCU', 'Y', 'N');
INSERT INTO `department` VALUES ('54', 'คลินิก ANC', 'Y', 'N');
INSERT INTO `department` VALUES ('55', 'โรงพยาบาลตระการพืชผล', 'Y', 'N');
INSERT INTO `department` VALUES ('56', 'คลังพัสดุ', 'Y', 'N');
INSERT INTO `department` VALUES ('57', 'ห้องประชุมอุดมสุข', 'Y', 'N');
INSERT INTO `department` VALUES ('58', 'องค์กรแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('59', 'ห้องรองผู้อำนวยการ', 'Y', 'N');
INSERT INTO `department` VALUES ('60', 'ห้องยาแยกโรค', 'Y', 'N');
INSERT INTO `department` VALUES ('61', 'ห้องพัก ER', 'Y', 'N');
INSERT INTO `department` VALUES ('62', 'ห้องผ่าตัดเล็ก', 'Y', 'N');
INSERT INTO `department` VALUES ('63', 'ห้องประชุมหอไตร', 'Y', 'N');
INSERT INTO `department` VALUES ('64', 'ห้องประชุมพนาภินันท์เล็ก', 'Y', 'N');
INSERT INTO `department` VALUES ('65', 'ห้องประชุมConferenec', 'Y', 'N');
INSERT INTO `department` VALUES ('66', 'ห้องตรวจโรค', 'Y', 'N');
INSERT INTO `department` VALUES ('67', 'ห้องฉีดยา', 'Y', 'N');
INSERT INTO `department` VALUES ('68', 'ห้องเสียงตามสาย', 'Y', 'N');
INSERT INTO `department` VALUES ('69', 'สำนังานสาธารณสุขอำเภอ', 'Y', 'N');
INSERT INTO `department` VALUES ('70', 'สำนังานสาธารณสุขจังหวัด', 'Y', 'N');
INSERT INTO `department` VALUES ('71', 'ศูนย์รายได้', 'Y', 'N');
INSERT INTO `department` VALUES ('72', 'ศูนย์เปล EMS ศูนย์ประสาน', 'Y', 'N');
INSERT INTO `department` VALUES ('73', 'ลานเบาหวาน', 'Y', 'N');
INSERT INTO `department` VALUES ('74', 'งานโภชนาการ', 'Y', 'N');
INSERT INTO `department` VALUES ('75', 'โรงอาหาร', 'Y', 'N');
INSERT INTO `department` VALUES ('76', 'กลุ่มการพยาบาล', 'Y', 'N');
INSERT INTO `department` VALUES ('77', 'สูติกรรม', 'Y', 'N');
INSERT INTO `department` VALUES ('78', 'ป้อมยาม', 'Y', 'N');
INSERT INTO `department` VALUES ('79', 'เตรียมเบรก', 'Y', 'N');
INSERT INTO `department` VALUES ('80', 'ตึกอุดมสุข', 'Y', 'N');
INSERT INTO `department` VALUES ('81', 'ตึกสงฆ์', 'Y', 'N');
INSERT INTO `department` VALUES ('82', 'ตรวจภายใน', 'Y', 'N');
INSERT INTO `department` VALUES ('83', 'งานซักฟอกเก่า', 'Y', 'N');
INSERT INTO `department` VALUES ('84', 'งานซักฟอก', 'Y', 'N');
INSERT INTO `department` VALUES ('85', 'งานจ่ายยา IPD', 'Y', 'N');
INSERT INTO `department` VALUES ('86', 'งานจ่ายยาคลินิกพิเศษ', 'Y', 'N');
INSERT INTO `department` VALUES ('87', 'งานสนาม เวชฯ', 'Y', 'N');
INSERT INTO `department` VALUES ('88', 'หน่วยจ่ายกลาง', 'Y', 'N');
INSERT INTO `department` VALUES ('89', 'คิลนิกสูตินารีเวช', 'Y', 'N');
INSERT INTO `department` VALUES ('90', 'VIP ห้องประชุม', 'Y', 'N');
INSERT INTO `department` VALUES ('91', 'VIP จนท.', 'Y', 'N');
INSERT INTO `department` VALUES ('92', 'VIP 3', 'Y', 'N');
INSERT INTO `department` VALUES ('93', 'VIP 2', 'Y', 'N');
INSERT INTO `department` VALUES ('94', 'VIP 1', 'Y', 'N');
INSERT INTO `department` VALUES ('95', 'URI', 'Y', 'N');
INSERT INTO `department` VALUES ('96', 'งานสุขศึกษาประชาสัมพันธ์', 'Y', 'N');
INSERT INTO `department` VALUES ('97', 'งานยาเสพติด', 'Y', 'N');
INSERT INTO `department` VALUES ('98', 'บ้านพักแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('99', 'แฟลตแพทย์', 'Y', 'N');
INSERT INTO `department` VALUES ('100', 'รพ.สต.กุดยาลวน', 'Y', 'N');
INSERT INTO `department` VALUES ('101', 'รพ.สต.เกษม', 'Y', 'N');
INSERT INTO `department` VALUES ('102', 'รพ.สต.โคกน้อย', 'Y', 'N');
INSERT INTO `department` VALUES ('103', 'รพ.สต.เซเป็ด', 'Y', 'N');
INSERT INTO `department` VALUES ('104', 'รพ.สต.บ้านกุง', 'Y', 'N');
INSERT INTO `department` VALUES ('105', 'รพ.สต.ไหล่ทุ่ง', 'Y', 'N');
INSERT INTO `department` VALUES ('106', 'ห้องยา11', 'Y', 'N');

-- ----------------------------
-- Table structure for driver
-- ----------------------------
DROP TABLE IF EXISTS `driver`;
CREATE TABLE `driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of driver
-- ----------------------------
INSERT INTO `driver` VALUES ('32', 'นายบุญช่วย  สุดหา', 'Y', 'N', '2020-11-12 14:48:17', '2020-05-13 14:40:32');
INSERT INTO `driver` VALUES ('33', 'นายกิตติ  เถื่อนกลาง', 'Y', 'Y', '2020-11-12 14:47:49', '2020-05-13 14:40:46');
INSERT INTO `driver` VALUES ('34', 'นายพิทยา  จันทรา', 'Y', 'N', '2020-11-12 14:48:26', '2020-11-12 14:48:26');

-- ----------------------------
-- Table structure for inventory
-- ----------------------------
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `serial_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N','RP','WO') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `depart_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT '',
  `id_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `moneytype_id` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=480 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of inventory
-- ----------------------------
INSERT INTO `inventory` VALUES ('478', 'รถตู้โดยสารขนาด 12 ที่นั่ง', 'นข-3616 อบ', '30', '21', '48', '1589336690_26.png', 'Y', 'N', '2020-12-07 13:55:02', '2020-05-13 09:24:50', '2310-004-0003/2', '', '2183', '3');
INSERT INTO `inventory` VALUES ('479', 'รถตู้พยาบาลฉุกเฉิน ขนาด ALS  ทะเบียน กอ 903 อบ', '-', '30', '22', '47', '1589337638_26.jpg', 'Y', 'N', '2020-11-12 14:35:09', '2020-05-13 09:40:38', '2310-001-0002/6', '', '2184', '4');

-- ----------------------------
-- Table structure for linetoken
-- ----------------------------
DROP TABLE IF EXISTS `linetoken`;
CREATE TABLE `linetoken` (
  `linetoken` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of linetoken
-- ----------------------------
INSERT INTO `linetoken` VALUES ('Ju6wQWvITvsRtwMxzdDuKeBSlVSlbNNKupGLYqLf3vR_');

-- ----------------------------
-- Table structure for moneytype
-- ----------------------------
DROP TABLE IF EXISTS `moneytype`;
CREATE TABLE `moneytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moneytype
-- ----------------------------
INSERT INTO `moneytype` VALUES ('1', 'บำรุง');
INSERT INTO `moneytype` VALUES ('2', 'DPL');
INSERT INTO `moneytype` VALUES ('3', 'งบประมาณ');
INSERT INTO `moneytype` VALUES ('4', 'รับบริจาค');
INSERT INTO `moneytype` VALUES ('5', 'เงินบริจาค');
INSERT INTO `moneytype` VALUES ('6', 'ค่าเสื่อม');
INSERT INTO `moneytype` VALUES ('7', 'โครงการเงินกู้ไทยเข้มแข็ง');
INSERT INTO `moneytype` VALUES ('8', 'งบ PCU');
INSERT INTO `moneytype` VALUES ('9', 'โครงการ');
INSERT INTO `moneytype` VALUES ('10', 'บำรุง(นอกแผน)');

-- ----------------------------
-- Table structure for place
-- ----------------------------
DROP TABLE IF EXISTS `place`;
CREATE TABLE `place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of place
-- ----------------------------
INSERT INTO `place` VALUES ('31', 'อู่นิพนธ์กลการ', 'Y', 'N', '2020-05-13 10:32:57', '2020-05-13 10:26:16');
INSERT INTO `place` VALUES ('32', 'อุบลวิบูลย์การยาง/ท่าบ่อ', 'Y', 'N', '2020-05-13 10:29:05', '2020-05-13 10:26:44');
INSERT INTO `place` VALUES ('33', 'อู่ปองการช่าง', 'Y', 'N', '2020-05-13 10:29:07', '2020-05-13 10:26:53');
INSERT INTO `place` VALUES ('34', 'TOYOTA ดีเยี่ยม สาขาตระการ', 'Y', 'N', '2020-11-12 14:44:24', '2020-11-12 14:44:24');
INSERT INTO `place` VALUES ('35', 'ร้านตระการยางยนต์', 'Y', 'N', '2020-11-12 14:45:19', '2020-11-12 14:45:19');
INSERT INTO `place` VALUES ('36', 'NISSAN อุบล ดอนกลาง', 'Y', 'N', '2020-11-12 14:46:04', '2020-11-12 14:46:04');

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of position
-- ----------------------------
INSERT INTO `position` VALUES ('1', 'ผู้ดูแล');
INSERT INTO `position` VALUES ('2', 'ผู้ใช้งาน');
INSERT INTO `position` VALUES ('3', 'ช่างซ่อม');
INSERT INTO `position` VALUES ('4', 'หัวหน้าช่าง');

-- ----------------------------
-- Table structure for problem
-- ----------------------------
DROP TABLE IF EXISTS `problem`;
CREATE TABLE `problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of problem
-- ----------------------------
INSERT INTO `problem` VALUES ('23', 'ซ่อมตามรอบการใช้งาน', 'Y', 'N', '2020-05-13 09:50:29', '2020-05-13 09:50:29');
INSERT INTO `problem` VALUES ('24', 'ซ่อมเฉพาะกิจ', 'Y', 'N', '2020-05-13 09:50:40', '2020-05-13 09:50:40');
INSERT INTO `problem` VALUES ('25', 'ซ่อมฉุกเฉิน (อุบัติเหตุ)', 'Y', 'N', '2020-11-12 14:32:15', '2020-11-12 14:32:15');

-- ----------------------------
-- Table structure for repair
-- ----------------------------
DROP TABLE IF EXISTS `repair`;
CREATE TABLE `repair` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` int(11) NOT NULL,
  `problem` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `technician` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jobdetail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of repair
-- ----------------------------
INSERT INTO `repair` VALUES ('130', '478', '23', 'สลับยาง', '95', '32', '2020-05-18 08:32:33', '2020-05-18 08:31:41', null);
INSERT INTO `repair` VALUES ('131', '478', '23', 'fyyrstyr', '26', '32', '2020-07-21 15:45:07', '2020-07-21 15:45:07', null);
INSERT INTO `repair` VALUES ('132', '478', '23', 'เปลี่ยนน้ำมันเครื่อง', '26', '31', '2020-11-06 13:54:41', '2020-11-06 13:54:41', null);

-- ----------------------------
-- Table structure for repair_detail
-- ----------------------------
DROP TABLE IF EXISTS `repair_detail`;
CREATE TABLE `repair_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repair_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `repair_id` (`repair_id`),
  CONSTRAINT `repair` FOREIGN KEY (`repair_id`) REFERENCES `repair` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of repair_detail
-- ----------------------------
INSERT INTO `repair_detail` VALUES ('214', '130', '14', null, '2020-05-18 08:31:41', '2020-05-18 08:31:41');
INSERT INTO `repair_detail` VALUES ('215', '131', '14', null, '2020-07-21 15:45:07', '2020-07-21 15:45:07');
INSERT INTO `repair_detail` VALUES ('216', '132', '14', null, '2020-11-06 13:54:41', '2020-11-06 13:54:41');

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bg_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `text_color` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', 'กำลังดำเนินการ', '#0080ff', '#ffffff', 'Y', 'N', '2020-04-01 08:41:34', '2020-04-01 08:41:34');
INSERT INTO `status` VALUES ('2', 'สำเร็จ', '#008040', '#ffffff', 'Y', 'N', '2020-04-01 08:41:34', '2020-04-01 08:41:34');
INSERT INTO `status` VALUES ('3', 'ยกเลิก', '#ff0000', '#ffffff', 'Y', 'N', '2020-04-01 08:41:34', '2020-04-01 08:41:34');
INSERT INTO `status` VALUES ('12', 'ส่งซ่อมศูนย์', '#8000ff', '#ffffff', 'Y', 'N', '2020-04-02 00:48:18', '2020-04-02 00:48:18');
INSERT INTO `status` VALUES ('13', 'ส่งร้านนอก', '#800080', '#ffffff', 'Y', 'N', '2020-04-02 00:48:24', '2020-04-02 00:48:24');
INSERT INTO `status` VALUES ('14', 'แจ้งซ่อม', '#80ffff', '#000000', 'Y', 'N', '2020-04-02 19:05:30', '2020-04-02 19:05:30');
INSERT INTO `status` VALUES ('15', 'ไม่สำเร็จ', '#ff8000', '#000000', 'Y', 'N', '2020-04-02 19:06:04', '2020-04-02 19:06:04');
INSERT INTO `status` VALUES ('16', 'รออะไหล่', '#808000', '#ffffff', 'Y', 'N', '2020-04-02 19:06:12', '2020-04-02 19:06:12');
INSERT INTO `status` VALUES ('17', 'รอตรวจสอบ', '#ffff00', '#000000', 'Y', 'N', '2020-04-03 08:28:19', '2020-04-03 08:28:19');
INSERT INTO `status` VALUES ('18', 'จำหน่าย', '#ff0000', '#ffffff', 'Y', 'N', '2020-04-09 14:57:56', '2020-04-09 14:57:56');
INSERT INTO `status` VALUES ('19', 'จัดซื้อทดแทน', '#00ff00', '#000000', 'Y', 'N', '2020-04-14 15:32:48', '2020-04-14 15:32:48');

-- ----------------------------
-- Table structure for system
-- ----------------------------
DROP TABLE IF EXISTS `system`;
CREATE TABLE `system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of system
-- ----------------------------
INSERT INTO `system` VALUES ('1', 'ระบบข้อมูลรถยนต์', 'Car System', '2020-05-13 09:54:41', '2019-12-27 01:36:13');

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES ('19', '29', 'รถยนต์ 2 ประตู CAB', 'Y', 'N', '2020-05-13 09:12:16', '2020-05-13 09:12:16');
INSERT INTO `type` VALUES ('20', '29', 'รถยนต์ 4 ประตู', 'Y', 'N', '2020-05-13 09:12:25', '2020-05-13 09:12:25');
INSERT INTO `type` VALUES ('21', '30', 'รถตู้โดยสาร', 'Y', 'N', '2020-05-13 09:12:35', '2020-05-13 09:12:35');
INSERT INTO `type` VALUES ('22', '30', 'รถตู้รีเฟอร์', 'Y', 'N', '2020-05-13 09:12:49', '2020-05-13 09:12:49');

-- ----------------------------
-- Table structure for ui_language
-- ----------------------------
DROP TABLE IF EXISTS `ui_language`;
CREATE TABLE `ui_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `en` text COLLATE utf8_unicode_ci NOT NULL,
  `th` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ui_language
-- ----------------------------
INSERT INTO `ui_language` VALUES ('2', 'Login', 'เข้าสู่ระบบ');
INSERT INTO `ui_language` VALUES ('3', 'Thailand', 'ภาษาไทย');
INSERT INTO `ui_language` VALUES ('4', 'English', 'ภาษาอังกฤษ');
INSERT INTO `ui_language` VALUES ('5', 'Username', 'ชื่อผู้ใช้งาน');
INSERT INTO `ui_language` VALUES ('6', 'Password', 'รหัสผ่าน');
INSERT INTO `ui_language` VALUES ('7', 'Welcome', 'ยินดีต้อนรับ');
INSERT INTO `ui_language` VALUES ('9', 'Dashboard', 'แดชบอร์ด');
INSERT INTO `ui_language` VALUES ('10', 'Home', 'หน้าแรก');
INSERT INTO `ui_language` VALUES ('11', 'Profile', 'โปรไฟล์');
INSERT INTO `ui_language` VALUES ('12', 'Logout', 'ออกจากระบบ');
INSERT INTO `ui_language` VALUES ('13', 'Users', 'ผู้ใช้งาน');
INSERT INTO `ui_language` VALUES ('14', 'Systems', 'ระบบ');
INSERT INTO `ui_language` VALUES ('15', 'Settings', 'ตั้งค่า');
INSERT INTO `ui_language` VALUES ('16', 'Category', 'หมวดหมู่');
INSERT INTO `ui_language` VALUES ('17', 'Type', 'ประเภท');
INSERT INTO `ui_language` VALUES ('18', 'Brand', 'ยี่ห้อ');
INSERT INTO `ui_language` VALUES ('19', 'Problems', 'ปัญหา');
INSERT INTO `ui_language` VALUES ('20', 'Status', 'สถานะ');
INSERT INTO `ui_language` VALUES ('21', 'Inventory', 'ครุภัณฑ์ทั้งหมด');
INSERT INTO `ui_language` VALUES ('22', 'Repair', 'แจ้งซ่อม');
INSERT INTO `ui_language` VALUES ('23', 'Enabled', 'เปิดใช้งาน');
INSERT INTO `ui_language` VALUES ('24', 'Disabled', 'จำหน่าย');
INSERT INTO `ui_language` VALUES ('25', 'Background Color', 'สีพื้นหลัง');
INSERT INTO `ui_language` VALUES ('26', 'Select Color', 'เลือกสี');
INSERT INTO `ui_language` VALUES ('27', 'Text Color', 'สีข้อความ');
INSERT INTO `ui_language` VALUES ('28', 'Save', 'บันทึก');
INSERT INTO `ui_language` VALUES ('29', 'Problem', 'ประเภทซ่อม');
INSERT INTO `ui_language` VALUES ('30', 'Name', 'ชื่อ');
INSERT INTO `ui_language` VALUES ('31', 'Color', 'สี');
INSERT INTO `ui_language` VALUES ('32', 'Edit', 'แก้ไข');
INSERT INTO `ui_language` VALUES ('33', 'Delete', 'ลบ');
INSERT INTO `ui_language` VALUES ('34', 'Select All', 'เลือกทั้งหมด');
INSERT INTO `ui_language` VALUES ('35', 'Trash', 'ถังขยะ');
INSERT INTO `ui_language` VALUES ('36', 'No', 'ไม่');
INSERT INTO `ui_language` VALUES ('37', 'Yes', 'ใช่');
INSERT INTO `ui_language` VALUES ('38', 'Are you want to delete all?', 'คุณต้องการลบทั้งหมด?');
INSERT INTO `ui_language` VALUES ('39', 'Do you want to delete this information?', 'คุณต้องการลบข้อมูลนี้หรือไม่?');
INSERT INTO `ui_language` VALUES ('40', 'Please Enter Name', 'โปรดระบุชื่อ');
INSERT INTO `ui_language` VALUES ('41', 'New Inventory', 'เพิ่มใหม่');
INSERT INTO `ui_language` VALUES ('42', 'Picture', 'รูปภาพ');
INSERT INTO `ui_language` VALUES ('43', 'Send to Repair', 'ส่งซ่อม');
INSERT INTO `ui_language` VALUES ('44', 'Worn out', 'ชำรุด');
INSERT INTO `ui_language` VALUES ('45', 'Choose File', 'เลือกไฟล์');
INSERT INTO `ui_language` VALUES ('46', 'Serial Number', 'รหัสเครื่อง');
INSERT INTO `ui_language` VALUES ('48', 'Please Select Category', 'โปรดเลือกหมวดหมู่');
INSERT INTO `ui_language` VALUES ('49', 'Please Select Type', 'โปรดเลือกประเภท');
INSERT INTO `ui_language` VALUES ('50', 'Please Select Brand', 'โปรดเลือกยี่ห้อ');
INSERT INTO `ui_language` VALUES ('51', 'Please Enter Serial Number', 'โปรดระบุรหัสเครื่อง');
INSERT INTO `ui_language` VALUES ('52', 'Disnabled', 'จำหน่าย');
INSERT INTO `ui_language` VALUES ('53', 'Extensions Support', '');
INSERT INTO `ui_language` VALUES ('54', 'Hone', 'หน้าหลัก');
INSERT INTO `ui_language` VALUES ('55', 'Please Enter Problem', 'โปรดระบุปัญหา');
INSERT INTO `ui_language` VALUES ('56', 'Please Enter Brand', 'โปรดระบุยี่ห้อ');
INSERT INTO `ui_language` VALUES ('58', 'Title', 'หัวข้อ');
INSERT INTO `ui_language` VALUES ('59', 'Data update successful.', 'ปรับปรุงข้อมูลเสร็จสิ้น');
INSERT INTO `ui_language` VALUES ('60', 'Please Enter Title', 'โปรดระบุหัวข้อ');
INSERT INTO `ui_language` VALUES ('61', 'Please Enter Type', 'โปรดระบุประเภท');
INSERT INTO `ui_language` VALUES ('62', 'Please Enter Category', 'โปรดระบุหมวดหมู่');
INSERT INTO `ui_language` VALUES ('64', 'New User', 'เพิ่มผู้ใช้');
INSERT INTO `ui_language` VALUES ('65', 'Full Name', 'ชื่อ - สกุล');
INSERT INTO `ui_language` VALUES ('66', 'Position', 'ตำแหน่ง');
INSERT INTO `ui_language` VALUES ('67', 'View', 'ดู');
INSERT INTO `ui_language` VALUES ('68', 'User', 'ผู้ใช้');
INSERT INTO `ui_language` VALUES ('69', 'Prolfile', 'โปรไฟล์');
INSERT INTO `ui_language` VALUES ('70', 'Email', 'อีเมล์');
INSERT INTO `ui_language` VALUES ('71', 'Gender', 'เพศ');
INSERT INTO `ui_language` VALUES ('72', 'BirthDay', 'วันเกิด');
INSERT INTO `ui_language` VALUES ('73', 'Phone Number', 'เบอร์โทร');
INSERT INTO `ui_language` VALUES ('74', 'Male', 'ชาย');
INSERT INTO `ui_language` VALUES ('75', 'First Name', 'ชื่อ');
INSERT INTO `ui_language` VALUES ('76', 'Last Name', 'นามสกุล');
INSERT INTO `ui_language` VALUES ('77', 'Gendor', 'เพศ');
INSERT INTO `ui_language` VALUES ('78', 'Female', 'หญิง');
INSERT INTO `ui_language` VALUES ('80', 'Upload', 'อัพโหลด');
INSERT INTO `ui_language` VALUES ('81', 'Info', 'ข้อมูล');
INSERT INTO `ui_language` VALUES ('82', 'Change Password', 'เปลี่ยนรหัสผ่าน');
INSERT INTO `ui_language` VALUES ('83', 'Current Password', 'รหัสผ่านปัจจุบัน');
INSERT INTO `ui_language` VALUES ('84', 'New Password', 'รหัสผ่านใหม่');
INSERT INTO `ui_language` VALUES ('85', 'Confirm Password', 'ยืนยันรหัสผ่าน');
INSERT INTO `ui_language` VALUES ('86', 'Please Enter Username', '');
INSERT INTO `ui_language` VALUES ('87', 'Please Enter First Name', '');
INSERT INTO `ui_language` VALUES ('88', 'Please Enter Last Name', '');
INSERT INTO `ui_language` VALUES ('89', 'Please Enter Email', '');
INSERT INTO `ui_language` VALUES ('90', 'Please Enter Current Password', '');
INSERT INTO `ui_language` VALUES ('91', 'Please Enter New Password', '');
INSERT INTO `ui_language` VALUES ('92', 'Your password must be at least 6 characters long.', '');
INSERT INTO `ui_language` VALUES ('93', 'Please Enter Confirm Password', '');
INSERT INTO `ui_language` VALUES ('94', 'Please enter the same password as above.', '');
INSERT INTO `ui_language` VALUES ('95', 'Uoload', '');
INSERT INTO `ui_language` VALUES ('96', 'Last Namee', '');
INSERT INTO `ui_language` VALUES ('97', 'Repair List', 'รายการส่งซ่อม');
INSERT INTO `ui_language` VALUES ('98', 'Date', 'วันที่');
INSERT INTO `ui_language` VALUES ('99', 'Repairer', 'ผู้แจ้งซ่อม');
INSERT INTO `ui_language` VALUES ('100', 'Technician', 'หัวหน้าช่าง');
INSERT INTO `ui_language` VALUES ('101', 'Please Select Inventory', 'เลือกรถ');
INSERT INTO `ui_language` VALUES ('102', 'Please Select Problem', 'เลือกประเภทซ่อม');
INSERT INTO `ui_language` VALUES ('103', 'Description', 'รายละเอียด');
INSERT INTO `ui_language` VALUES ('104', 'Techician', 'ช่าง');
INSERT INTO `ui_language` VALUES ('105', 'Please Select Technician', 'เลือกช่าง');
INSERT INTO `ui_language` VALUES ('106', 'No results found', '');
INSERT INTO `ui_language` VALUES ('107', 'Please Enter Description', 'กรุณากรอกรายละเอียด');
INSERT INTO `ui_language` VALUES ('108', 'Successful data deletion.', 'ลบข้อมูลสำเร็จ');
INSERT INTO `ui_language` VALUES ('109', 'Repair Today', 'ส่งซ่อมวันนี้');
INSERT INTO `ui_language` VALUES ('110', 'View More', '');
INSERT INTO `ui_language` VALUES ('111', 'Successfully saved data.', 'บันทึกสำเร็จ');
INSERT INTO `ui_language` VALUES ('112', 'Inventory Enabled', 'ครุภัณฑ์พร้อมใช้งาน');
INSERT INTO `ui_language` VALUES ('113', 'Inventory Disabled', 'ครุภัณฑ์จำหน่าย');
INSERT INTO `ui_language` VALUES ('114', 'Inventory Send To Repair', 'ครุภัณฑ์ส่งซ่อม');
INSERT INTO `ui_language` VALUES ('115', 'Inventory Worn out', 'ครุภัณฑ์ชำรุด');
INSERT INTO `ui_language` VALUES ('116', 'Do you want to Logout?', 'คุณต้องการออกจากระบบ');
INSERT INTO `ui_language` VALUES ('117', 'Language', 'ภาษา');
INSERT INTO `ui_language` VALUES ('118', 'EN', 'อังกฤษ');
INSERT INTO `ui_language` VALUES ('119', 'TH', 'ไทย');
INSERT INTO `ui_language` VALUES ('120', 'Detail', 'ลำดับงาน');
INSERT INTO `ui_language` VALUES ('121', 'Repair Update', 'ปรับปรุงรายการซ่อม');
INSERT INTO `ui_language` VALUES ('122', 'Note', 'หมายเหตุ');
INSERT INTO `ui_language` VALUES ('123', 'Close', 'ปิด');
INSERT INTO `ui_language` VALUES ('124', 'Add', 'เพิ่ม');
INSERT INTO `ui_language` VALUES ('125', 'Cancel successful.', 'ยกเลิกสำเร็จ');
INSERT INTO `ui_language` VALUES ('126', 'Repair Info', 'รายละเอียดการส่งซ่อม');
INSERT INTO `ui_language` VALUES ('127', 'List Repair', 'รายการส่งซ่อม');
INSERT INTO `ui_language` VALUES ('128', 'Teahician', '');
INSERT INTO `ui_language` VALUES ('129', 'List Techician', 'รายการช่าง');
INSERT INTO `ui_language` VALUES ('130', 'Id Number', 'เลขครุภัณฑ์');
INSERT INTO `ui_language` VALUES ('131', 'Inventory1', 'ชื่อครุภัณฑ์');
INSERT INTO `ui_language` VALUES ('132', 'Technician1', 'ผู้รับงาน');
INSERT INTO `ui_language` VALUES ('133', 'department', 'กลุ่มงาน/งาน');
INSERT INTO `ui_language` VALUES ('134', 'Please Select Department', 'กรุณาเลือกฝ่ายงาน');
INSERT INTO `ui_language` VALUES ('135', 'History', 'ประวัติ');
INSERT INTO `ui_language` VALUES ('136', 'Mainternance', 'บำรุงรักษา');
INSERT INTO `ui_language` VALUES ('137', 'Back', 'กลับ');
INSERT INTO `ui_language` VALUES ('138', 'HistoryList', 'ประวัติการส่งซ่อม');
INSERT INTO `ui_language` VALUES ('139', 'PrintJob', 'พิมพ์');
INSERT INTO `ui_language` VALUES ('140', 'JobDetail', 'ข้อมูลการซ่อม');
INSERT INTO `ui_language` VALUES ('141', 'Invalid Data.', 'ผิดพลาด');
INSERT INTO `ui_language` VALUES ('142', 'Report', 'รายงาน');
INSERT INTO `ui_language` VALUES ('143', 'Report01', 'รายงานสรุปยอดการส่งซ่อม');
INSERT INTO `ui_language` VALUES ('144', 'Count', 'จำนวน');
INSERT INTO `ui_language` VALUES ('145', 'EndJob', 'ส่งงาน');
INSERT INTO `ui_language` VALUES ('146', 'Are you want to send job?', 'คุณต้องการส่งมอบงานใช่หรือไม่');
INSERT INTO `ui_language` VALUES ('147', 'reciver', 'วิธีการได้มา');
INSERT INTO `ui_language` VALUES ('148', 'Please Select reciver', 'กรุณาเลือกวิธีการได้มา');
INSERT INTO `ui_language` VALUES ('149', 'Number', 'เลขลำดับ');
INSERT INTO `ui_language` VALUES ('150', 'Please Select Idnumber', 'กรุณากรอกเลขครุภัณฑ์');
INSERT INTO `ui_language` VALUES ('151', 'Car', 'รถยนต์');
INSERT INTO `ui_language` VALUES ('152', 'RepairPlace', 'สถานที่ซ่อม');
INSERT INTO `ui_language` VALUES ('153', 'Please Select RepairPlace', 'เลือกสถานที่ซ่อม');
INSERT INTO `ui_language` VALUES ('154', 'UseCar', 'การใช้รถ');
INSERT INTO `ui_language` VALUES ('155', 'Driver', 'คนขับรถ');
INSERT INTO `ui_language` VALUES ('156', 'fname', 'ชื่อ');
INSERT INTO `ui_language` VALUES ('157', 'lname', 'นามสกุล');
INSERT INTO `ui_language` VALUES ('158', 'usecar1', 'ขอใช้รถ');
INSERT INTO `ui_language` VALUES ('159', 'carname', 'รถที่ให้บริการ');
INSERT INTO `ui_language` VALUES ('160', 'usename', 'เรื่องที่ขอไปราชการ');
INSERT INTO `ui_language` VALUES ('161', 'goto', 'สถานที่ไปราชการ');
INSERT INTO `ui_language` VALUES ('162', 'departuse', 'หน่วยงานที่ขอใช้รถ');
INSERT INTO `ui_language` VALUES ('163', 'personnum', 'จำนวนคน');
INSERT INTO `ui_language` VALUES ('164', 'Please Select Driver', 'กรุณาเลือกคนขับรถ');
INSERT INTO `ui_language` VALUES ('165', 'usedate', 'วันที่ใช้รถ');
INSERT INTO `ui_language` VALUES ('166', 'worklist', 'ลำดับงาน');
INSERT INTO `ui_language` VALUES ('167', 'worklistprocess', 'ปรับปรุงลำดับงาน');
INSERT INTO `ui_language` VALUES ('168', 'approve', 'อนุมัติ');
INSERT INTO `ui_language` VALUES ('169', 'Are you want to approve job?', 'คุณต้องการอนุมัติใช่หรือไม่');

-- ----------------------------
-- Table structure for usecar
-- ----------------------------
DROP TABLE IF EXISTS `usecar`;
CREATE TABLE `usecar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depart_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `goto` varchar(250) DEFAULT NULL,
  `person` varchar(5) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `use_date` date DEFAULT NULL,
  `use_time` varchar(50) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `approve` int(11) DEFAULT NULL,
  `noapprove` varchar(250) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usecar
-- ----------------------------
INSERT INTO `usecar` VALUES ('3', '1', 'fff', 'ggggg', '1', '478', '2020-05-14', null, '33', 'ddddd', null, null, null, '95', '2020-05-13 16:03:43', '2020-05-18 15:41:25');
INSERT INTO `usecar` VALUES ('4', '1', 'jj', 'jjj', '10', '479', '2020-05-11', null, '33', 'ffffff', null, '1', null, '95', '2020-05-18 12:34:59', '2020-05-18 16:07:47');
INSERT INTO `usecar` VALUES ('5', '4', '11', 'kkkkkkkkkkkk', '9', '478', '2020-05-31', null, '32', 'hhhhhhhh', null, null, null, '26', '2020-05-18 12:37:55', '2020-05-18 15:41:25');
INSERT INTO `usecar` VALUES ('6', '5', 'ddddddddd', 'wwwwwwwwwwwwwwww', '15', '478', '2020-06-01', null, '32', '', null, '1', null, '26', '2020-05-18 15:43:12', '2020-05-18 16:07:39');
INSERT INTO `usecar` VALUES ('7', '1', 'ประชุม สสจ.', 'สสจ.อุบล', '10', '478', '2020-11-10', null, '32', '-', null, null, null, '26', '2020-11-06 14:00:45', '2020-11-06 14:00:45');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('M','F') COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL DEFAULT 2,
  `is_active` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `is_delete` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `position_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('26', 'admin', '$2y$10$r8OKTqVZ3ZBeYx/ZBx7uOOPbuBjr61D5lqMlWfTUo/CI8PnC8NRXS', 'นายนิพนธ์', 'เทียนหอม', 'M', '1981-08-29', 'niphon.theanhom@gmail.com', '0910139660', '1586220737_26.JPG', '1', 'Y', 'N', '2020-05-13 09:05:36', '2019-12-27 11:28:27', 'นักวิชาการคอมพิวเตอร์');
INSERT INTO `users` VALUES ('95', 'test', '$2y$10$clQ84r9A3wCTvTkYHodMWuLiihbWIIIpKhsR5JgY9/HCJhskLDncy', 's', 'sss', 'M', '2020-05-18', 'sss@dd.com', '0910139660', '', '2', 'Y', 'N', '2020-05-18 08:31:13', '2020-05-18 08:31:13', null);
