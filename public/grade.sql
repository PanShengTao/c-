/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : grade

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 03/02/2021 01:04:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sys_config
-- ----------------------------
DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config`  (
  `variable` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `set_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `set_by` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`variable`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_config
-- ----------------------------
INSERT INTO `sys_config` VALUES ('diagnostics.allow_i_s_tables', 'OFF', '2019-05-06 13:42:05', NULL);
INSERT INTO `sys_config` VALUES ('diagnostics.include_raw', 'OFF', '2019-05-06 13:42:05', NULL);
INSERT INTO `sys_config` VALUES ('ps_thread_trx_info.max_length', '65535', '2019-05-06 13:42:05', NULL);
INSERT INTO `sys_config` VALUES ('statement_performance_analyzer.limit', '100', '2019-05-06 13:42:05', NULL);
INSERT INTO `sys_config` VALUES ('statement_performance_analyzer.view', NULL, '2019-05-06 13:42:05', NULL);
INSERT INTO `sys_config` VALUES ('statement_truncate_len', '64', '2019-05-06 13:42:05', NULL);

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `userpawd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `userimg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `userrole` int(255) NULL DEFAULT NULL COMMENT '1超级用户',
  `useread` int(255) NULL DEFAULT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`, `username`, `phone`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES (1, 'root', '123456', NULL, 1, 0, '18385642411');

-- ----------------------------
-- Triggers structure for table sys_config
-- ----------------------------
DROP TRIGGER IF EXISTS `sys_config_insert_set_user`;
delimiter ;;
CREATE TRIGGER `sys_config_insert_set_user` BEFORE INSERT ON `sys_config` FOR EACH ROW BEGIN IF @sys.ignore_sys_config_triggers != true AND NEW.set_by IS NULL THEN SET NEW.set_by = USER(); END IF; END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table sys_config
-- ----------------------------
DROP TRIGGER IF EXISTS `sys_config_update_set_user`;
delimiter ;;
CREATE TRIGGER `sys_config_update_set_user` BEFORE UPDATE ON `sys_config` FOR EACH ROW BEGIN IF @sys.ignore_sys_config_triggers != true AND NEW.set_by IS NULL THEN SET NEW.set_by = USER(); END IF; END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
