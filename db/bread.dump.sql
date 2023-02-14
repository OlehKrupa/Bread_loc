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

 Date: 14/02/2023 11:12:13
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Consignment_OUT
-- ----------------------------
INSERT INTO `Consignment_OUT` VALUES (1, 2, 1000, '2023-02-13 01:32:51', '1', '1', 1, 1, 1, 1);

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
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Crop
-- ----------------------------
INSERT INTO `Crop` VALUES (2, 2, '2022-12-08', 5, 4000, 3, 'Соняшник', 'Олійка', 'Задовільно', 0.01, 0.001, 0.005, 800);
INSERT INTO `Crop` VALUES (3, 3, '2023-01-09', 3, 800, 3, 'Овес', 'Ірен', 'Погано', 0.5, 0.5, 0.0005, 900);
INSERT INTO `Crop` VALUES (4, 2, '2023-02-10', 3, 100, 3, 'Соя', 'Сія', 'Погано', 0.1, 0.1, 0.001, 950);
INSERT INTO `Crop` VALUES (5, 1, '2023-02-07', 5, 3015, 1, 'Пшениця', 'Зернятко', 'Відмінно', 0.11, 0.01, 0.001, 1100);
INSERT INTO `Crop` VALUES (6, 1, '2023-02-07', 5, 3015, 1, 'Пшениця', 'Зернятко', 'Відмінно', 0.11, 0.01, 0.001, 1100);
INSERT INTO `Crop` VALUES (8, 3, '2023-01-09', 3, 800, 3, 'Овес', 'Ірен', 'Погано', 0.5, 0.5, 0.0005, 900);
INSERT INTO `Crop` VALUES (9, 2, '2023-02-10', 3, 100, 3, 'Соя', 'Сія', 'Погано', 0.1, 0.1, 0.001, 950);
INSERT INTO `Crop` VALUES (10, 1, '2023-02-07', 5, 3015, 1, 'Пшениця', 'Зернятко', 'Відмінно', 0.11, 0.01, 0.001, 1100);
INSERT INTO `Crop` VALUES (11, 2, '2022-12-08', 5, 4000, 3, 'Соняшник', 'Олійка', 'Задовільно', 0.01, 0.001, 0.005, 800);
INSERT INTO `Crop` VALUES (12, 3, '2023-01-09', 3, 800, 3, 'Овес', 'Ірен', 'Погано', 0.5, 0.5, 0.0005, 900);
INSERT INTO `Crop` VALUES (13, 2, '2023-02-10', 3, 100, 3, 'Соя', 'Сія', 'Погано', 0.1, 0.1, 0.001, 950);
INSERT INTO `Crop` VALUES (14, 1, '2023-02-07', 5, 3015, 1, 'Пшениця', 'Зернятко', 'Відмінно', 0.11, 0.01, 0.001, 1100);
INSERT INTO `Crop` VALUES (15, 2, '2022-12-08', 5, 4000, 3, 'Соняшник', 'Олійка', 'Задовільно', 0.01, 0.001, 0.005, 800);
INSERT INTO `Crop` VALUES (16, 3, '2023-01-09', 3, 800, 3, 'Овес', 'Ірен', 'Погано', 0.5, 0.5, 0.0005, 900);
INSERT INTO `Crop` VALUES (17, 2, '2023-02-10', 3, 100, 3, 'Соя', 'Сія', 'Погано', 0.1, 0.1, 0.001, 950);
INSERT INTO `Crop` VALUES (18, 1, '2023-02-07', 5, 3015, 1, 'Пшениця', 'Зернятко', 'Відмінно', 0.11, 0.01, 0.001, 1100);
INSERT INTO `Crop` VALUES (19, 2, '2022-12-08', 5, 4000, 3, 'Соняшник', 'Олійка', 'Задовільно', 0.01, 0.001, 0.005, 800);
INSERT INTO `Crop` VALUES (20, 3, '2023-01-09', 3, 800, 3, 'Овес', 'Ірен', 'Погано', 0.5, 0.5, 0.0005, 900);
INSERT INTO `Crop` VALUES (21, 2, NULL, 1, 12000, 2, 'якийто', 'какойто', 'Задовільно', 0.2, 0.02, 0.002, 975);
INSERT INTO `Crop` VALUES (22, 3, NULL, 4, 124, 3, ' ww4', ' 5e3', 'Погано', 0.2, 0.02, 0.002, 975);

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Standard
-- ----------------------------
INSERT INTO `Standard` VALUES (1, 'М\'який', 2, 12, 0.05, 0.2, 0.03, 0.1, 0.005, 0.01, 940, 980);
INSERT INTO `Standard` VALUES (2, 'Звичайний', 2, 12, 0.12, 0.18, 0.03, 0.1, 0.004, 0.012, 950, 975);
INSERT INTO `Standard` VALUES (3, 'Суворий', 2, 12, 0.03, 0.1, 0.01, 0.05, 0.001, 0.006, 960, 980);
INSERT INTO `Standard` VALUES (5, 'test2', 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Supplier
-- ----------------------------
INSERT INTO `Supplier` VALUES (1, 'ООО &quot;Агроінвест&quot;', '384165216515');
INSERT INTO `Supplier` VALUES (2, 'ПАТ &quot;Зерно&quot;', '380365214532');
INSERT INTO `Supplier` VALUES (3, 'ВАТ \"ЗерноБуд\"', '385455646441');
INSERT INTO `Supplier` VALUES (5, 'Власівка', '123');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of Warehouse
-- ----------------------------
INSERT INTO `Warehouse` VALUES (1, 'Склад &quot;Королівство&quot; 1', 'Власівка', 6660);
INSERT INTO `Warehouse` VALUES (2, 'Склад \"Королівство\" 2', 'Власівка', 4000);
INSERT INTO `Warehouse` VALUES (3, 'Приміщення \"Зернятко\" 1', 'Кременчук', 1000);
INSERT INTO `Warehouse` VALUES (4, 'Приміщення \"Зернятко\" 2', 'Кременчук', 4000);
INSERT INTO `Warehouse` VALUES (5, 'Елеватор \"Дніпро\"', 'Світловодськ', 10000);

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
