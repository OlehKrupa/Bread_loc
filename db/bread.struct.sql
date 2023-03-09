/*
 Navicat Premium Data Transfer

 Source Server         : Vagrant
 Source Server Type    : MySQL
 Source Server Version : 80032
 Source Host           : localhost:3306
 Source Schema         : bread.loc

 Target Server Type    : MySQL
 Target Server Version : 80032
 File Encoding         : 65001

 Date: 09/03/2023 19:16:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for Consignment_OUT
-- ----------------------------
DROP TABLE IF EXISTS `Consignment_OUT`;
CREATE TABLE `Consignment_OUT`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Crop_id` int NOT NULL,
  `amount` decimal(10, 0) NOT NULL,
  `date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `number` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `moisture` float NOT NULL,
  `garbage` float NOT NULL,
  `minerals` float NOT NULL,
  `nature` float NOT NULL,
  PRIMARY KEY (`id`, `Crop_id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE,
  INDEX `fk_Consignment_OUT_Crop1_idx`(`Crop_id`) USING BTREE,
  CONSTRAINT `fk_Consignment_OUT_Crop1` FOREIGN KEY (`Crop_id`) REFERENCES `Crop` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for Crop
-- ----------------------------
DROP TABLE IF EXISTS `Crop`;
CREATE TABLE `Crop`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `Supplier_id` int NOT NULL,
  `date` date NULL DEFAULT NULL,
  `Warehouse_id` int NOT NULL,
  `amount` decimal(10, 0) NOT NULL,
  `Standard_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `variety` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `grade` enum('Відмінно','Добре','Задовільно','Погано','Зіпсовано') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Задовільно',
  `moisture` float NOT NULL,
  `garbage` float NOT NULL,
  `minerals` float NOT NULL,
  `nature` float NOT NULL,
  PRIMARY KEY (`id`, `Supplier_id`, `Warehouse_id`, `Standard_id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE,
  INDEX `fk_Crop_Warehouse1_idx`(`Warehouse_id`) USING BTREE,
  INDEX `fk_Crop_Supplier1_idx`(`Supplier_id`) USING BTREE,
  INDEX `fk_Crop_Standard1_idx`(`Standard_id`) USING BTREE,
  CONSTRAINT `fk_Crop_Standard1` FOREIGN KEY (`Standard_id`) REFERENCES `Standard` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_Crop_Supplier1` FOREIGN KEY (`Supplier_id`) REFERENCES `Supplier` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_Crop_Warehouse1` FOREIGN KEY (`Warehouse_id`) REFERENCES `Warehouse` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for Standard
-- ----------------------------
DROP TABLE IF EXISTS `Standard`;
CREATE TABLE `Standard`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `minor_risk` int NOT NULL DEFAULT 2,
  `major_risk` int NOT NULL DEFAULT 12,
  `min_moisture` float NOT NULL,
  `max_moisture` float NOT NULL,
  `min_garbage` float NOT NULL,
  `max_garbage` float NOT NULL,
  `min_minerals` float NOT NULL,
  `max_minerals` float NOT NULL,
  `min_nature` float NOT NULL,
  `max_nature` float NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for Supplier
-- ----------------------------
DROP TABLE IF EXISTS `Supplier`;
CREATE TABLE `Supplier`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `number` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for Warehouse
-- ----------------------------
DROP TABLE IF EXISTS `Warehouse`;
CREATE TABLE `Warehouse`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `capacity` decimal(10, 0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idWarehouse_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for Alert_view
-- ----------------------------
DROP VIEW IF EXISTS `Alert_view`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Alert_view` AS select `Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture` from `Crop`;

-- ----------------------------
-- View structure for ConsignmentView
-- ----------------------------
DROP VIEW IF EXISTS `ConsignmentView`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `ConsignmentView` AS select `Consignment_OUT`.`id` AS `id`,`Consignment_OUT`.`Crop_id` AS `Crop_id`,`Crop`.`name` AS `crop_name`,`Consignment_OUT`.`amount` AS `amount`,`Consignment_OUT`.`date` AS `date`,`Consignment_OUT`.`name` AS `name`,`Consignment_OUT`.`number` AS `number`,`Consignment_OUT`.`moisture` AS `moisture`,`Consignment_OUT`.`garbage` AS `garbage`,`Consignment_OUT`.`minerals` AS `minerals`,`Consignment_OUT`.`nature` AS `nature` from (`Consignment_OUT` join `Crop` on((`Consignment_OUT`.`Crop_id` = `Crop`.`id`)));

-- ----------------------------
-- View structure for Crop_View
-- ----------------------------
DROP VIEW IF EXISTS `Crop_View`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Crop_View` AS select `Crop`.`id` AS `id`,`Supplier`.`name` AS `supplier_name`,`Crop`.`date` AS `date`,`Warehouse`.`name` AS `warehouse_name`,`Crop`.`amount` AS `amount`,`Standard`.`name` AS `standard_name`,`Crop`.`name` AS `name`,`Crop`.`variety` AS `variety`,`Crop`.`grade` AS `grade`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage`,`Crop`.`minerals` AS `minerals`,`Crop`.`nature` AS `nature` from (((`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) join `Supplier` on((`Crop`.`Supplier_id` = `Supplier`.`id`))) join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`)));

-- ----------------------------
-- View structure for Dry_view
-- ----------------------------
DROP VIEW IF EXISTS `Dry_view`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `Dry_view` AS select `Crop`.`id` AS `id`,`Crop`.`amount` AS `amount`,`Crop`.`moisture` AS `moisture`,`Crop`.`garbage` AS `garbage` from `Crop`;

-- ----------------------------
-- View structure for grade_view
-- ----------------------------
DROP VIEW IF EXISTS `grade_view`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `grade_view` AS select `Crop`.`id` AS `id`,`Crop`.`moisture` AS `moisture`,`Standard`.`min_moisture` AS `min_moisture`,`Standard`.`max_moisture` AS `max_moisture`,`Crop`.`garbage` AS `garbage`,`Standard`.`min_garbage` AS `min_garbage`,`Standard`.`max_garbage` AS `max_garbage`,`Crop`.`minerals` AS `minerals`,`Standard`.`min_minerals` AS `min_minerals`,`Standard`.`max_minerals` AS `max_minerals`,`Crop`.`nature` AS `nature`,`Standard`.`min_nature` AS `min_nature`,`Standard`.`max_nature` AS `max_nature`,`Crop`.`date` AS `date`,`Standard`.`minor_risk` AS `minor_risk`,`Standard`.`major_risk` AS `major_risk`,`Crop`.`grade` AS `grade` from (`Crop` join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`)));

SET FOREIGN_KEY_CHECKS = 1;
