/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : hotel_db

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-12-08 13:38:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for additional_services
-- ----------------------------
DROP TABLE IF EXISTS `additional_services`;
CREATE TABLE `additional_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of additional_services
-- ----------------------------
INSERT INTO `additional_services` VALUES ('1', 'breakfast', '55');
INSERT INTO `additional_services` VALUES ('2', 'lunch', '60');
INSERT INTO `additional_services` VALUES ('3', 'dinner', '70');
INSERT INTO `additional_services` VALUES ('6', 'cleaning', '100');

-- ----------------------------
-- Table structure for bookings
-- ----------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `confirmed` smallint(6) NOT NULL,
  `pay_method` varchar(100) NOT NULL,
  `paid` smallint(6) NOT NULL,
  `adults_number` int(11) NOT NULL,
  `children_number` int(11) NOT NULL DEFAULT '0',
  `fk_users_dni_dni` varchar(40) NOT NULL,
  `fk_rooms_id_name` int(11) NOT NULL,
  `room_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_dni` (`fk_users_dni_dni`),
  KEY `bookings_room_id` (`fk_rooms_id_name`),
  KEY `bookings` (`room_type`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_type`) REFERENCES `roomtypes` (`id`),
  CONSTRAINT `bookings_room_id` FOREIGN KEY (`fk_rooms_id_name`) REFERENCES `rooms` (`id`),
  CONSTRAINT `bookings_user_dni` FOREIGN KEY (`fk_users_dni_dni`) REFERENCES `users` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bookings
-- ----------------------------
INSERT INTO `bookings` VALUES ('1', '01/18/2017', '02/28/2018', '1', 'visa', '1', '2', '0', '41609409v', '1', '2');
INSERT INTO `bookings` VALUES ('2', '11/17/2017', '12/21/2017', '1', 'visa', '0', '2', '0', '41609409v', '1', '1');
INSERT INTO `bookings` VALUES ('3', '01/11/2018', '01/25/2018', '0', 'visa', '0', '2', '0', '41609409v', '1', '1');
INSERT INTO `bookings` VALUES ('6', '01/27/2018', '01/30/2018', '1', 'visa', '0', '2', '0', '41609230e', '1', '2');
INSERT INTO `bookings` VALUES ('7', '11/29/2017', '01/17/2018', '0', 'visa', '0', '2', '0', '41609230e', '1', '1');
INSERT INTO `bookings` VALUES ('9', '11/22/2017', '05/23/2018', '0', 'visa', '0', '2', '0', '41609230e', '1', '1');
INSERT INTO `bookings` VALUES ('10', '01/01/2019', '01/18/2019', '1', 'visa', '0', '2', '0', 'x4374801v', '1', '1');

-- ----------------------------
-- Table structure for booking_additionals_services
-- ----------------------------
DROP TABLE IF EXISTS `booking_additionals_services`;
CREATE TABLE `booking_additionals_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `additional_service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `additional_service_booking_booking_id` (`booking_id`),
  KEY `additional_service_booking_additional_service_id` (`additional_service_id`),
  CONSTRAINT `additional_service_booking_additional_service_id` FOREIGN KEY (`additional_service_id`) REFERENCES `additional_services` (`id`),
  CONSTRAINT `additional_service_booking_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of booking_additionals_services
-- ----------------------------
INSERT INTO `booking_additionals_services` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_roomtypes_id_name` int(11) NOT NULL,
  `adults_max_number` int(11) NOT NULL,
  `children_max_number` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `booked` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rooms_types_id_rooms_room_type_id` (`fk_roomtypes_id_name`),
  CONSTRAINT `rooms_types_id_rooms_room_type_id` FOREIGN KEY (`fk_roomtypes_id_name`) REFERENCES `roomtypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES ('1', '2', '2', '0', 'caixer senyorffffffffffff', '1');
INSERT INTO `rooms` VALUES ('2', '1', '2', '0', 'hello', '1');
INSERT INTO `rooms` VALUES ('3', '3', '2', '0', 'josep room', '0');
INSERT INTO `rooms` VALUES ('4', '1', '234', '0', 'josep', '1');
INSERT INTO `rooms` VALUES ('5', '2', '22', '3', 'jpons1room', '1');

-- ----------------------------
-- Table structure for roomtypes
-- ----------------------------
DROP TABLE IF EXISTS `roomtypes`;
CREATE TABLE `roomtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roomtypes
-- ----------------------------
INSERT INTO `roomtypes` VALUES ('1', 'suite1', '111');
INSERT INTO `roomtypes` VALUES ('2', 'double_suite', '200');
INSERT INTO `roomtypes` VALUES ('3', 'caixer senyor', '300');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `dni` varchar(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surnames` varchar(150) NOT NULL,
  `email` varchar(200) CHARACTER SET ascii NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fk_usertypes_id_usertypename` varchar(100) NOT NULL,
  PRIMARY KEY (`dni`),
  KEY `user_types_id_users_user_type` (`fk_usertypes_id_usertypename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('41609230e', 'dani', 'dani', 'dawdani24@jmail.org', '666666666', '$2y$10$nrgA0YGvQY3T1lxGruSrROae3tsmDU5AbdycdAqjVrjDWxxTh2tCW', '3');
INSERT INTO `users` VALUES ('41609409v', 'Josep Pons Pons', 'Josep Pons Pons', 'jponspons@gmail.com', '666666666', '$2y$10$iPLQNIzQfBcafzK5xcaVHOek7cIKigZJSFY6sPOasP2GedN.JsbJm', '1');
INSERT INTO `users` VALUES ('x4374801v', 'Andersito', 'Andersito', 'daw2alunauceta@iesjoanramis.org', '666666666', '$2y$10$gjw0zNgRR2ZI8OTVawRL1.B73fLnmtKvVSSPOg06pT6t9tcgXLP0e', '3');

-- ----------------------------
-- Table structure for usertypes
-- ----------------------------
DROP TABLE IF EXISTS `usertypes`;
CREATE TABLE `usertypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usertypename` varchar(50) NOT NULL,
  `permissions` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usertypes
-- ----------------------------
INSERT INTO `usertypes` VALUES ('1', 'root', '300');
INSERT INTO `usertypes` VALUES ('2', 'hotelier', '200');
INSERT INTO `usertypes` VALUES ('3', 'member', '100');

-- ----------------------------
-- Function structure for DATE_BIGGER
-- ----------------------------
DROP FUNCTION IF EXISTS `DATE_BIGGER`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `DATE_BIGGER`(DATE1 DATE, DATE2 DATE) RETURNS varchar(5) CHARSET utf8
BEGIN
    IF (DATE1 > DATE2) THEN
      RETURN 'true';
      ELSE
        RETURN 'false';
    END IF;
  END
;;
DELIMITER ;
