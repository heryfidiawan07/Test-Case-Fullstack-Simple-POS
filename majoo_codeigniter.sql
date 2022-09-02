/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : majoo_codeigniter

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 03/09/2022 01:38:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('3fc9f76c-2999-4332-a4a0-708fb3fa10dc', 'Category 1', '2022-09-01 16:30:48', '2022-09-01 16:30:48');
INSERT INTO `categories` VALUES ('8fe3d98d-ed6c-4f28-a8a9-406c25057a7f', 'Category 2', '2022-09-01 16:30:48', '2022-09-01 16:30:48');
INSERT INTO `categories` VALUES ('b4c054e4-067c-4f1c-abf1-5743d827fcc4', 'Category 4', '2022-09-01 23:30:00', '2022-09-01 23:30:00');
INSERT INTO `categories` VALUES ('cae9b2a0-bbbf-4547-ad86-527e03f106cf', 'Category 3', '2022-09-01 16:30:48', '2022-09-01 16:30:48');
INSERT INTO `categories` VALUES ('ea16c503-f614-4427-8085-b01a5143efe2', 'Category 5', '2022-09-01 23:55:21', '2022-09-02 00:21:30');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_menu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('0a5ddcad-29bc-11ed-aa5b-00090ffe0001', 'Administrator', NULL, 'role-index', 'Role', 'role', 'fas fa-shield-alt', 'fas fa-users-cog', '2022-09-01 13:05:12', '2022-09-01 15:55:08');
INSERT INTO `permissions` VALUES ('0d801cc8-29bc-11ed-aa5b-00090ffe0001', NULL, '0a5ddcad-29bc-11ed-aa5b-00090ffe0001', 'role-store', NULL, NULL, NULL, NULL, '2022-09-01 13:05:17', '2022-09-01 13:07:06');
INSERT INTO `permissions` VALUES ('0ff2720b-29bc-11ed-aa5b-00090ffe0001', NULL, '0a5ddcad-29bc-11ed-aa5b-00090ffe0001', 'role-update', NULL, NULL, NULL, NULL, '2022-09-01 13:05:21', '2022-09-01 13:07:07');
INSERT INTO `permissions` VALUES ('1295ba97-29bc-11ed-aa5b-00090ffe0001', NULL, '0a5ddcad-29bc-11ed-aa5b-00090ffe0001', 'role-destroy', NULL, NULL, NULL, NULL, '2022-09-01 13:05:26', '2022-09-01 13:07:08');
INSERT INTO `permissions` VALUES ('1e382da9-29d7-11ed-aa5b-00090ffe0001', 'Master', NULL, 'category-index', 'Category', 'category', 'fas fa-tags', 'fas fa-certificate', '2022-09-01 16:19:02', '2022-09-02 23:45:21');
INSERT INTO `permissions` VALUES ('34a2984e-29d2-11ed-aa5b-00090ffe0001', NULL, NULL, 'product-list', 'All Product', 'product-list', 'fas fa-shopping-cart', NULL, '2022-09-01 15:43:52', '2022-09-02 02:32:46');
INSERT INTO `permissions` VALUES ('48453457-29d2-11ed-aa5b-00090ffe0001', 'Master', NULL, 'product-index', 'Product', 'product', 'fas fa-shopping-cart', 'fas fa-certificate', '2022-09-01 15:44:25', '2022-09-01 15:53:55');
INSERT INTO `permissions` VALUES ('495f9fd3-2a0a-11ed-aa5b-00090ffe0001', NULL, '1e382da9-29d7-11ed-aa5b-00090ffe0001', 'category-store', NULL, NULL, NULL, NULL, '2022-09-01 22:25:21', '2022-09-01 22:25:21');
INSERT INTO `permissions` VALUES ('50d9873a-2a0a-11ed-aa5b-00090ffe0001', NULL, '1e382da9-29d7-11ed-aa5b-00090ffe0001', 'category-update', NULL, NULL, NULL, NULL, '2022-09-01 22:25:34', '2022-09-01 22:25:34');
INSERT INTO `permissions` VALUES ('580b8b55-29bd-11ed-aa5b-00090ffe0001', NULL, NULL, 'dashboard', 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', NULL, '2022-09-01 13:14:32', '2022-09-01 13:53:05');
INSERT INTO `permissions` VALUES ('58ee4028-2a0a-11ed-aa5b-00090ffe0001', NULL, '1e382da9-29d7-11ed-aa5b-00090ffe0001', 'category-destroy', NULL, NULL, NULL, NULL, '2022-09-01 22:25:47', '2022-09-01 22:25:47');
INSERT INTO `permissions` VALUES ('5c1eba12-29d2-11ed-aa5b-00090ffe0001', NULL, '48453457-29d2-11ed-aa5b-00090ffe0001', 'product-store', NULL, NULL, NULL, NULL, '2022-09-01 15:44:58', '2022-09-01 15:44:58');
INSERT INTO `permissions` VALUES ('62ac7527-29d2-11ed-aa5b-00090ffe0001', NULL, '48453457-29d2-11ed-aa5b-00090ffe0001', 'product-update', NULL, NULL, NULL, NULL, '2022-09-01 15:45:09', '2022-09-02 22:03:16');
INSERT INTO `permissions` VALUES ('6b36e5b9-29d2-11ed-aa5b-00090ffe0001', NULL, '48453457-29d2-11ed-aa5b-00090ffe0001', 'product-destroy', NULL, NULL, NULL, NULL, '2022-09-01 15:45:23', '2022-09-01 15:45:23');
INSERT INTO `permissions` VALUES ('6ecc2e6f-29d2-11ed-aa5b-00090ffe0001', NULL, '48453457-29d2-11ed-aa5b-00090ffe0001', 'product-detail', NULL, NULL, NULL, NULL, '2022-09-01 15:45:29', '2022-09-02 22:03:31');
INSERT INTO `permissions` VALUES ('9e8ee87f-2ad6-11ed-aa5b-00090ffe0001', NULL, NULL, 'report', 'Report', 'report', 'fas fa-file', NULL, '2022-09-02 22:47:31', '2022-09-02 22:49:13');
INSERT INTO `permissions` VALUES ('e8f9cb3e-29bb-11ed-aa5b-00090ffe0001', 'Administrator', NULL, 'user-index', 'User', 'user', 'fas fa-users', 'fas fa-users-cog', '2022-09-01 13:04:16', '2022-09-01 15:53:35');
INSERT INTO `permissions` VALUES ('ee1617f2-29bb-11ed-aa5b-00090ffe0001', NULL, 'e8f9cb3e-29bb-11ed-aa5b-00090ffe0001', 'user-store', NULL, NULL, NULL, NULL, '2022-09-01 13:04:24', '2022-09-01 13:06:57');
INSERT INTO `permissions` VALUES ('f2f06b8d-29bb-11ed-aa5b-00090ffe0001', NULL, 'e8f9cb3e-29bb-11ed-aa5b-00090ffe0001', 'user-update', NULL, NULL, NULL, NULL, '2022-09-01 13:04:32', '2022-09-01 13:06:58');
INSERT INTO `permissions` VALUES ('ffcae45c-29bb-11ed-aa5b-00090ffe0001', NULL, 'e8f9cb3e-29bb-11ed-aa5b-00090ffe0001', 'user-destroy', NULL, NULL, NULL, NULL, '2022-09-01 13:04:54', '2022-09-01 13:06:59');

-- ----------------------------
-- Table structure for product_category
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category`  (
  `product_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  INDEX `fk_product`(`product_id`) USING BTREE,
  INDEX `fk_category`(`category_id`) USING BTREE,
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_category
-- ----------------------------
INSERT INTO `product_category` VALUES ('dcc4af0d-7058-4e12-8e1b-9ded83b12c84', '3fc9f76c-2999-4332-a4a0-708fb3fa10dc');
INSERT INTO `product_category` VALUES ('dcc4af0d-7058-4e12-8e1b-9ded83b12c84', 'cae9b2a0-bbbf-4547-ad86-527e03f106cf');
INSERT INTO `product_category` VALUES ('081502bc-972e-4050-9746-a38ff19167e7', '8fe3d98d-ed6c-4f28-a8a9-406c25057a7f');
INSERT INTO `product_category` VALUES ('0c2a433e-aed6-4c40-9d26-503df47e8798', '8fe3d98d-ed6c-4f28-a8a9-406c25057a7f');
INSERT INTO `product_category` VALUES ('5baff579-e847-4c89-bc7a-eca8e44f07b6', '8fe3d98d-ed6c-4f28-a8a9-406c25057a7f');
INSERT INTO `product_category` VALUES ('190a83e7-79c9-4ce9-bdea-e8655629e497', '3fc9f76c-2999-4332-a4a0-708fb3fa10dc');
INSERT INTO `product_category` VALUES ('80c8218e-98a1-4ed4-8c02-eef8060271a5', '3fc9f76c-2999-4332-a4a0-708fb3fa10dc');
INSERT INTO `product_category` VALUES ('96a52db8-8d86-49bb-81a1-4ff6cd4b3b4d', '3fc9f76c-2999-4332-a4a0-708fb3fa10dc');
INSERT INTO `product_category` VALUES ('7c90d5ed-9e64-41f5-8f18-bf0a5e6d59f5', '3fc9f76c-2999-4332-a4a0-708fb3fa10dc');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(255) NOT NULL,
  `qty_stock` int(255) NOT NULL DEFAULT 0,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_user_products`(`created_by`) USING BTREE,
  UNIQUE INDEX `unique_product_name`(`name`) USING BTREE,
  INDEX `fk_supplier_products`(`supplier_id`) USING BTREE,
  CONSTRAINT `fk_user_products` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_supplier_products` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('081502bc-972e-4050-9746-a38ff19167e7', 'Dashboard Gatepass', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 100000000, 0, 'Dashboard_Gatepass-6310c2f4a16cb.png', '<h2 xss=removed>Plus toko online terintegrasi dengan marketplace</h2><h5 xss=removed>Mudahnya kelola penjualan online dari satu platform majoo</h5><p xss=removed><br></p><h2 xss=removed>Layanan lengkap bisnis tumbuh berkembang</h2><h5 xss=removed>Maksimalkan keuntungan dengan dukungan layanan bisnis tersedia kapanpun dibutuhkan</h5>', '418573e7-c0ab-47d8-837b-f64c84200812', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 21:34:28', '2022-09-02 10:59:40');
INSERT INTO `products` VALUES ('0c2a433e-aed6-4c40-9d26-503df47e8798', 'Single Truck Indentity', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 100000000, 0, 'single-truck-indentity-6310c3c59ea51.png', '<h2 xss=removed>Plus toko online terintegrasi dengan marketplace</h2><h5 xss=removed>Mudahnya kelola penjualan online dari satu platform majoo</h5><p xss=removed><br></p><h2 xss=removed>Layanan lengkap bisnis tumbuh berkembang</h2><h5 xss=removed>Maksimalkan keuntungan dengan dukungan layanan bisnis tersedia kapanpun dibutuhkan</h5>', '418573e7-c0ab-47d8-837b-f64c84200812', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 21:37:57', '2022-09-02 10:59:41');
INSERT INTO `products` VALUES ('190a83e7-79c9-4ce9-bdea-e8655629e497', 'Project Sample', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 2, 0, 'project-sample-6310cc52c68d3.png', '<h2 xss=removed>Layanan lengkap bisnis tumbuh berkembang</h2><h5 xss=removed>Maksimalkan keuntungan dengan dukungan layanan bisnis tersedia kapanpun dibutuhkan</h5>', 'c937e048-38e6-4ae9-9bbe-a01f4f712523', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 22:14:26', '2022-09-02 10:59:50');
INSERT INTO `products` VALUES ('5baff579-e847-4c89-bc7a-eca8e44f07b6', 'Driver ID', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 50000, 0, 'driver-id-6310c40b6e714.png', '<h2 xss=removed>Plus toko online terintegrasi dengan marketplace</h2><h5 xss=removed>Mudahnya kelola penjualan online dari satu platform majoo</h5><p xss=removed><br></p><h2 xss=removed>Layanan lengkap bisnis tumbuh berkembang</h2><h5 xss=removed>Maksimalkan keuntungan dengan dukungan layanan bisnis tersedia kapanpun dibutuhkan</h5>', '0b59acc1-97ce-4eb0-91d2-3dc4fc36fec3', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 21:39:07', '2022-09-02 23:48:01');
INSERT INTO `products` VALUES ('7c90d5ed-9e64-41f5-8f18-bf0a5e6d59f5', 'Hijab Sandana', '7rv7b8tn86tb8  b7t8tv8b7t 8bt87t9', 5467867986, 656, 'fb21e192-d1f8-4c09-85a1-9e531ce95df0.jpg', '<p>6vb78ynmudv97ty8d</p><p>sc8tscb8nt89cs</p><p>sxtsb87sxy8sxn</p><p>sx6rsbxtn8sx87</p>', '0b59acc1-97ce-4eb0-91d2-3dc4fc36fec3', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-03 00:10:31', '2022-09-03 00:56:19');
INSERT INTO `products` VALUES ('80c8218e-98a1-4ed4-8c02-eef8060271a5', 'Product Sample 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 31, 0, 'product-sample-2-6310ce33064eb.png', '<p><span xss=removed>The UUIDs generated by this site are provided AS IS without warranty of any kind, not even the warranty that the generated UUIDs are actually unique. You are responsible for using the UUIDs and assume any risk inherent to using them. You are not permitted to use the UUIDs generated by this site if you do not agree to these terms. Do not use any UUIDs found on cached versions of this page.</span><br xss=removed><a href=\"https://www.uuidgenerator.net/privacy_policy\" xss=removed>Privacy Policy</a><span xss=removed></span><br xss=removed><span xss=removed>This website uses cookies. We use cookies to personalise content/ads and to analyse our traffic.</span><br></p>', 'c937e048-38e6-4ae9-9bbe-a01f4f712523', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 22:22:27', '2022-09-02 10:59:51');
INSERT INTO `products` VALUES ('96a52db8-8d86-49bb-81a1-4ff6cd4b3b4d', 'Sample 3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 12000121, 0, 'sample-3-6310d1af7faa8.png', '<h4 xss=removed>What is a Version 1 UUID?</h4><p class=\"indented mb-0\" xss=removed>A Version 1 UUID is a universally unique identifier that is generated using a timestamp and the MAC address of the computer on which it was generated.</p>', '418573e7-c0ab-47d8-837b-f64c84200812', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 22:37:19', '2022-09-02 10:59:44');
INSERT INTO `products` VALUES ('dcc4af0d-7058-4e12-8e1b-9ded83b12c84', 'Product One', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.', 10000, 0, 'driver-id-6310c40b6e714.png', 'The UUIDs generated by this site are provided AS IS without warranty of any kind, not even the warranty that the generated UUIDs are actually unique. You are responsible for using the UUIDs and assume any risk inherent to using them. You are not permitted to use the UUIDs generated by this site if you do not agree to these terms. Do not use any UUIDs found on cached versions of this page.', '0b59acc1-97ce-4eb0-91d2-3dc4fc36fec3', '37f69fec-cd26-4de3-b29b-f87aaf548fec', '2022-09-01 16:31:31', '2022-09-02 10:59:58');

-- ----------------------------
-- Table structure for purchase
-- ----------------------------
DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int(255) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purchase
-- ----------------------------
INSERT INTO `purchase` VALUES ('2f94e15a-0bf4-4d4e-8b41-d05e6495efb1', 'INV-11111', 18000, '2022-09-02 23:47:33', '2022-09-02 23:47:33');
INSERT INTO `purchase` VALUES ('30ae5d89-cd2b-410b-935c-e34ba5aa7618', 'INV-22222', 120000, '2022-09-02 23:48:11', '2022-09-02 23:48:11');

-- ----------------------------
-- Table structure for purchase_detail
-- ----------------------------
DROP TABLE IF EXISTS `purchase_detail`;
CREATE TABLE `purchase_detail`  (
  `purchase_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(255) NOT NULL,
  `total` int(255) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  INDEX `fk_purchase`(`purchase_id`) USING BTREE,
  INDEX `fk_product_purchase`(`product_id`) USING BTREE,
  CONSTRAINT `fk_product_purchase` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_purchase` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purchase_detail
-- ----------------------------
INSERT INTO `purchase_detail` VALUES ('2f94e15a-0bf4-4d4e-8b41-d05e6495efb1', 'dcc4af0d-7058-4e12-8e1b-9ded83b12c84', 2, 18000, '2022-09-02 23:49:25', '2022-09-02 23:49:25');
INSERT INTO `purchase_detail` VALUES ('30ae5d89-cd2b-410b-935c-e34ba5aa7618', '5baff579-e847-4c89-bc7a-eca8e44f07b6', 3, 120000, '2022-09-02 23:49:41', '2022-09-02 23:49:41');

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission`  (
  `role_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  INDEX `fk_role`(`role_id`) USING BTREE,
  INDEX `fk_permissions`(`permission_id`) USING BTREE,
  CONSTRAINT `fk_permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES ('0ed0d6b5-333f-48df-8b8b-0b729604674a', '0a5ddcad-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('0ed0d6b5-333f-48df-8b8b-0b729604674a', '0d801cc8-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('0ed0d6b5-333f-48df-8b8b-0b729604674a', '0ff2720b-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('0ed0d6b5-333f-48df-8b8b-0b729604674a', '1295ba97-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '0a5ddcad-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '0d801cc8-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '0ff2720b-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '1295ba97-29bc-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '1e382da9-29d7-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '495f9fd3-2a0a-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '50d9873a-2a0a-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '58ee4028-2a0a-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '34a2984e-29d2-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '48453457-29d2-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '5c1eba12-29d2-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '62ac7527-29d2-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '6b36e5b9-29d2-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '6ecc2e6f-29d2-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '580b8b55-29bd-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '9e8ee87f-2ad6-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', 'e8f9cb3e-29bb-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', 'ee1617f2-29bb-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', 'f2f06b8d-29bb-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', 'ffcae45c-29bb-11ed-aa5b-00090ffe0001');
INSERT INTO `role_permission` VALUES ('b9ac6ff7-87b8-46f7-8594-df37c540b028', '9e8ee87f-2ad6-11ed-aa5b-00090ffe0001');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('0ed0d6b5-333f-48df-8b8b-0b729604674a', 'Admin', 'adfdsfdsf', '2022-09-02 02:35:11', '2022-09-02 02:43:48');
INSERT INTO `roles` VALUES ('b9ac6ff7-87b8-46f7-8594-df37c540b028', 'Manager', '678bt87t9y9n8ym98', '2022-09-03 00:18:36', '2022-09-03 00:18:36');
INSERT INTO `roles` VALUES ('ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', 'Super Admin', 'Role super admin', '2022-09-01 13:10:31', '2022-09-01 13:10:31');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('0b59acc1-97ce-4eb0-91d2-3dc4fc36fec3', 'PT Tirta Alam Segar', '2022-09-02 10:55:35', '2022-09-02 10:55:35');
INSERT INTO `supplier` VALUES ('418573e7-c0ab-47d8-837b-f64c84200812', 'PT Unilever', '2022-09-02 10:54:49', '2022-09-02 10:54:49');
INSERT INTO `supplier` VALUES ('c937e048-38e6-4ae9-9bbe-a01f4f712523', 'PT Mulia Boga Raya', '2022-09-02 10:55:19', '2022-09-02 10:55:19');

-- ----------------------------
-- Table structure for temporary
-- ----------------------------
DROP TABLE IF EXISTS `temporary`;
CREATE TABLE `temporary`  (
  `token` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  INDEX `fk_user`(`token`) USING BTREE,
  CONSTRAINT `fk_user` FOREIGN KEY (`token`) REFERENCES `users` (`token`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transaction_detail
-- ----------------------------
DROP TABLE IF EXISTS `transaction_detail`;
CREATE TABLE `transaction_detail`  (
  `transaction_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `total` bigint(255) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  INDEX `fk_transaction`(`transaction_id`) USING BTREE,
  INDEX `fk_product_detail`(`product_id`) USING BTREE,
  CONSTRAINT `fk_product_detail` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaction_detail
-- ----------------------------
INSERT INTO `transaction_detail` VALUES ('c786b1e7-b52f-4f75-a0f2-a662b914f43f', '96a52db8-8d86-49bb-81a1-4ff6cd4b3b4d', 1, 12000121, '2022-09-02 11:04:55', '2022-09-02 11:04:55');
INSERT INTO `transaction_detail` VALUES ('af7c8d6b-069d-4a8f-91f0-b0099aa09e48', '80c8218e-98a1-4ed4-8c02-eef8060271a5', 2, 62, '2022-09-02 11:05:29', '2022-09-02 11:05:29');
INSERT INTO `transaction_detail` VALUES ('af7c8d6b-069d-4a8f-91f0-b0099aa09e48', '190a83e7-79c9-4ce9-bdea-e8655629e497', 1, 4, '2022-09-02 11:05:45', '2022-09-02 11:05:45');

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` bigint(255) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES ('af7c8d6b-069d-4a8f-91f0-b0099aa09e48', 'INV-00001', 64, '2022-09-02 11:02:01', '2022-09-02 23:05:43');
INSERT INTO `transactions` VALUES ('c786b1e7-b52f-4f75-a0f2-a662b914f43f', 'INV-00002', 12000121, '2022-09-02 11:01:38', '2022-09-02 23:09:57');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `token`(`token`) USING BTREE,
  UNIQUE INDEX `unique_users_username_email`(`username`, `email`) USING BTREE,
  INDEX `fk_roles`(`role_id`) USING BTREE,
  CONSTRAINT `fk_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('37f69fec-cd26-4de3-b29b-f87aaf548fec', 'Hery Fidiawan', 'fidiawan', 'heryfidiawan07@gmail.com', '$2y$10$2CHY89YWNeb5XLAqoMH3IOWqzrjwoChsQCInlrOZmtWijr06t7voS', 'ebdf9b32-91a8-4c0c-8671-8b7e8bf56cc1', '3fdd3487-ac85-4696-8349-c65dece68d92', '2022-09-01 13:10:05', '2022-09-03 00:38:06');
INSERT INTO `users` VALUES ('46fe423b-4468-4b8a-92ce-9f70fb416af1', 'Rarakirana', 'rarakirana07', 'rarakirana07@gmail.com', '$2y$10$TGCXZKLnJWEA6cyw3i2d0OQZlD1qgo41qjASI6QQ1paOQfVCDgTv6', 'b9ac6ff7-87b8-46f7-8594-df37c540b028', '27043309-d63a-47ba-9ebd-71f80a7fe87b', '2022-09-03 00:21:55', '2022-09-03 00:36:45');

-- ----------------------------
-- Triggers structure for table permissions
-- ----------------------------
DROP TRIGGER IF EXISTS `generate_uuid`;
delimiter ;;
CREATE TRIGGER `generate_uuid` BEFORE INSERT ON `permissions` FOR EACH ROW SET NEW.id = UUID()
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
