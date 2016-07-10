/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : phalapi-art

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-07-10 20:30:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pa_user`
-- ----------------------------
DROP TABLE IF EXISTS `pa_user`;
CREATE TABLE `pa_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pa_user
-- ----------------------------
INSERT INTO `pa_user` VALUES ('1', 'chenyuanqi', 'vikey@chenyuanqi.com', '$2y$10$fLZqsoSKJWWQjtgL4Owzs.cKsK4M67k55ron26YDrUA3b0oNaIUDe', 'I am a demo!', '2016-07-10 19:26:10', '2016-07-10 19:26:15');
