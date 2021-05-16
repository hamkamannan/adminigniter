# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.32)
# Database: ci4
# Generation Time: 2021-05-11 01:05:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table auth_activation_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_activation_attempts`;

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_activation_attempts` WRITE;
/*!40000 ALTER TABLE `auth_activation_attempts` DISABLE KEYS */;

INSERT INTO `auth_activation_attempts` (`id`, `ip_address`, `user_agent`, `token`, `created_at`)
VALUES
	(1,'::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36','6ee263f534b60324f04ec670963d86a8','2021-05-08 00:28:33');

/*!40000 ALTER TABLE `auth_activation_attempts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_groups`;

CREATE TABLE `auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_groups` WRITE;
/*!40000 ALTER TABLE `auth_groups` DISABLE KEYS */;

INSERT INTO `auth_groups` (`id`, `name`, `description`)
VALUES
	(1,'admin','Administrator'),
	(2,'user','User'),
	(5,'operational',''),
	(6,'leader','');

/*!40000 ALTER TABLE `auth_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_groups_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_groups_permissions`;

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`),
  CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_groups_permissions` WRITE;
/*!40000 ALTER TABLE `auth_groups_permissions` DISABLE KEYS */;

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`)
VALUES
	(2,29),
	(2,30),
	(2,31),
	(2,33),
	(5,29),
	(5,30),
	(6,29),
	(6,30),
	(6,32),
	(6,34);

/*!40000 ALTER TABLE `auth_groups_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_groups_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_groups_users`;

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`),
  CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_groups_users` WRITE;
/*!40000 ALTER TABLE `auth_groups_users` DISABLE KEYS */;

INSERT INTO `auth_groups_users` (`group_id`, `user_id`)
VALUES
	(1,1),
	(1,2),
	(2,2),
	(2,10),
	(2,11),
	(2,12),
	(5,2);

/*!40000 ALTER TABLE `auth_groups_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_logins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_logins`;

CREATE TABLE `auth_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_logins` WRITE;
/*!40000 ALTER TABLE `auth_logins` DISABLE KEYS */;

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`)
VALUES
	(1,'::1','admin@admin.com',1,'2021-04-30 19:34:17',1),
	(2,'::1','admin@admin.com',1,'2021-05-08 00:04:41',1),
	(3,'::1','hamka@mannan.id',2,'2021-05-08 00:28:50',1),
	(4,'::1','hamka@mannan.id',2,'2021-05-08 00:34:38',1),
	(5,'::1','hamka@mannan.id',2,'2021-05-08 00:36:23',1),
	(6,'::1','hamka@mannan.id',NULL,'2021-05-08 02:21:46',0),
	(7,'::1','hamka@mannan.id',2,'2021-05-08 02:21:55',1),
	(8,'::1','hamkamannan.id@gmail.com',3,'2021-05-08 02:26:38',1),
	(9,'::1','hamkamannan.id@gmail.com',3,'2021-05-08 02:26:53',1),
	(10,'::1','hamka@mannan.id',NULL,'2021-05-08 03:23:09',0),
	(11,'::1','hamka@mannan.id',2,'2021-05-08 03:23:18',1),
	(12,'::1','hamka@mannan.id',2,'2021-05-08 17:22:03',1),
	(13,'::1','admin@admin.com',1,'2021-05-08 19:58:01',1),
	(14,'::1','admin',NULL,'2021-05-09 00:50:24',0),
	(15,'::1','admin@domain.com',NULL,'2021-05-09 00:50:34',0),
	(16,'::1','admin@admin.com',1,'2021-05-09 00:51:00',1),
	(17,'::1','admin',NULL,'2021-05-09 00:52:08',0),
	(18,'::1','admin@admin.com',1,'2021-05-09 00:52:15',1),
	(19,'::1','admin@admin.com',1,'2021-05-09 09:08:35',1),
	(20,'::1','admin@admin.com',1,'2021-05-09 17:13:45',1),
	(21,'::1','admin@admin.com',1,'2021-05-09 17:34:58',1),
	(22,'::1','admin',NULL,'2021-05-09 17:35:26',0),
	(23,'::1','admin@admin.com',1,'2021-05-09 17:49:02',1),
	(24,'::1','admin@admin.com',1,'2021-05-09 17:49:07',1),
	(25,'::1','admin',NULL,'2021-05-09 17:49:12',0),
	(26,'::1','hamka@mannan.id',2,'2021-05-09 17:49:22',1),
	(27,'::1','hamka@mannan.id',2,'2021-05-09 17:49:40',1),
	(28,'::1','admin',NULL,'2021-05-09 17:49:45',0),
	(29,'::1','admin@domain.com',NULL,'2021-05-09 17:50:00',0),
	(30,'::1','hamka',NULL,'2021-05-09 17:50:07',0),
	(31,'::1','hamka@mannan.id',2,'2021-05-09 17:50:13',1),
	(32,'::1','hamka@mannan.id',NULL,'2021-05-09 17:51:07',0),
	(33,'::1','hamka@mannan.id',2,'2021-05-09 17:51:17',1),
	(34,'::1','hamka@mannan.id',2,'2021-05-09 17:51:54',1),
	(35,'::1','hamka',NULL,'2021-05-09 17:52:00',0),
	(36,'::1','hamka',NULL,'2021-05-09 17:52:07',0),
	(37,'::1','hamka@mannan.id',2,'2021-05-09 17:52:31',1),
	(38,'::1','hamkamannan.id@gmail.com',10,'2021-05-09 17:53:59',1),
	(39,'::1','hamka@mannan.id',2,'2021-05-09 17:54:27',1),
	(40,'::1','hamkamannan.id@gmail.com',10,'2021-05-09 17:55:20',1),
	(41,'::1','admin@admin.com',1,'2021-05-09 17:57:22',1),
	(42,'::1','admin',NULL,'2021-05-09 17:57:53',0),
	(43,'::1','admin@admin.com',1,'2021-05-09 18:06:51',1),
	(44,'::1','admin@admin.com',1,'2021-05-09 18:07:30',1),
	(45,'::1','admin@admin.com',1,'2021-05-09 18:08:07',1),
	(46,'::1','admin@admin.com',1,'2021-05-09 18:11:00',1),
	(47,'::1','admin',NULL,'2021-05-09 18:22:59',0),
	(48,'::1','admin@admin.com',1,'2021-05-09 18:23:50',1),
	(49,'::1','admin',NULL,'2021-05-09 18:24:16',0),
	(50,'::1','admin',NULL,'2021-05-09 18:29:34',0),
	(51,'::1','admin',NULL,'2021-05-09 18:29:46',0),
	(52,'::1','admin@admin.com',1,'2021-05-09 18:30:09',1),
	(53,'::1','admin@admin.com',1,'2021-05-09 18:31:58',1),
	(54,'::1','admin@admin.com',1,'2021-05-09 18:58:20',1),
	(55,'::1','admin@admin.com',1,'2021-05-09 18:59:21',1),
	(56,'::1','admin@admin.com',1,'2021-05-10 02:39:44',1),
	(57,'::1','admin@admin.com',1,'2021-05-10 16:47:45',1),
	(58,'::1','admin@admin.com',1,'2021-05-10 17:19:00',1),
	(59,'::1','admin@admin.com',1,'2021-05-10 19:54:10',1),
	(60,'::1','admin@admin.com',1,'2021-05-10 20:00:54',1);

/*!40000 ALTER TABLE `auth_logins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_permissions`;

CREATE TABLE `auth_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auth_permissions` WRITE;
/*!40000 ALTER TABLE `auth_permissions` DISABLE KEYS */;

INSERT INTO `auth_permissions` (`id`, `name`, `description`)
VALUES
	(29,'dashboard/access',''),
	(30,'banner/access',''),
	(31,'banner/create',''),
	(32,'banner/read',''),
	(33,'banner/update',''),
	(34,'contact/access',''),
	(36,'banner/delete',''),
	(37,'sdf',''),
	(38,'label_menu/access','');

/*!40000 ALTER TABLE `auth_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_reset_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_reset_attempts`;

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_tokens`;

CREATE TABLE `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`),
  CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_users_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_users_permissions`;

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`),
  CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table c_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `c_logs`;

CREATE TABLE `c_logs` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `operation` varchar(50) DEFAULT NULL,
  `ref_table` varchar(50) DEFAULT NULL,
  `ref_id` mediumint(11) unsigned DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `c_logs` WRITE;
/*!40000 ALTER TABLE `c_logs` DISABLE KEYS */;

INSERT INTO `c_logs` (`id`, `message`, `controller`, `operation`, `ref_table`, `ref_id`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Ubah User','user','edit','auth_users',1,NULL,1,NULL,'2021-05-09 20:43:57','2021-05-09 20:43:57',NULL),
	(2,'Ubah Parameter','param','edit','c_params',39,NULL,1,NULL,'2021-05-09 20:45:50','2021-05-09 20:45:50',NULL),
	(3,'Tambah Access','access','create','auth_groups_permission',0,NULL,1,NULL,'2021-05-09 20:56:59','2021-05-09 20:56:59',NULL),
	(4,'Tambah Access|Group ID: 2|Access:dashboard/access,banner/access,banner/update,banner/delete,','access','create','auth_groups_permission',0,NULL,1,NULL,'2021-05-09 20:58:26','2021-05-09 20:58:26',NULL),
	(5,'Tambah Access<br>Group ID: 2<br>Access:dashboard/access,banner/access,banner/create,banner/update,','access','create','auth_groups_permission',0,NULL,1,NULL,'2021-05-09 20:59:06','2021-05-09 20:59:06',NULL),
	(6,'Tambah Banner','banner','create','t_banner',6,NULL,1,NULL,'2021-05-10 16:54:40','2021-05-10 16:54:40',NULL),
	(7,'Hapus Banner','banner','delete','t_banner',5,NULL,1,NULL,'2021-05-10 16:54:45','2021-05-10 16:54:45',NULL),
	(8,'Ubah Banner','banner','edit','t_banner',6,NULL,1,NULL,'2021-05-10 16:54:55','2021-05-10 16:54:55',NULL),
	(9,'Hapus Banner','banner','delete','t_banner',6,NULL,1,NULL,'2021-05-10 16:54:59','2021-05-10 16:54:59',NULL),
	(10,'Tambah Halaman','page','create','t_page',6,NULL,1,NULL,'2021-05-10 16:55:17','2021-05-10 16:55:17',NULL),
	(11,'Hapus Halaman','page','delete','t_page',6,NULL,1,NULL,'2021-05-10 16:55:39','2021-05-10 16:55:39',NULL),
	(12,'Tambah User','user','create','auth_users',0,NULL,1,NULL,'2021-05-10 16:55:58','2021-05-10 16:55:58',NULL),
	(13,'Ubah User','user','edit','auth_users',11,NULL,1,NULL,'2021-05-10 16:56:11','2021-05-10 16:56:11',NULL),
	(14,'Hapus User','user','delete','auth_users',11,NULL,1,NULL,'2021-05-10 16:56:21','2021-05-10 16:56:21',NULL),
	(15,'Tambah Group','param','create','auth_groups',9,NULL,1,NULL,'2021-05-10 16:58:07','2021-05-10 16:58:07',NULL),
	(16,'Hapus Group','param','delete','auth_groups',7,NULL,1,NULL,'2021-05-10 16:58:16','2021-05-10 16:58:16',NULL),
	(17,'Hapus Group','param','delete','auth_groups',8,NULL,1,NULL,'2021-05-10 16:58:20','2021-05-10 16:58:20',NULL),
	(18,'Hapus Group','param','delete','auth_groups',9,NULL,1,NULL,'2021-05-10 16:58:24','2021-05-10 16:58:24',NULL),
	(19,'Tambah Access<br>Group ID: 2<br>Access: label_menu/access,dashboard/access,banner/access,banner/create,banner/update,','access','create','auth_groups_permission',0,NULL,1,NULL,'2021-05-10 16:59:01','2021-05-10 16:59:01',NULL),
	(20,'Hapus Reference','reference','delete','t_reference',11,NULL,1,NULL,'2021-05-10 16:59:42','2021-05-10 16:59:42',NULL),
	(21,'Tambah Access<br>Group ID: 2<br>Access: dashboard/access,banner/access,banner/create,banner/update,','access','create','auth_groups_permission',0,NULL,1,NULL,'2021-05-10 17:07:33','2021-05-10 17:07:33',NULL),
	(22,'Tambah Group','param','create','auth_groups',10,NULL,1,NULL,'2021-05-10 17:07:57','2021-05-10 17:07:57',NULL),
	(23,'Ubah Group','param','edit','auth_groups',10,NULL,1,NULL,'2021-05-10 17:08:06','2021-05-10 17:08:06',NULL),
	(24,'Hapus Group','param','delete','auth_groups',10,NULL,1,NULL,'2021-05-10 17:08:22','2021-05-10 17:08:22',NULL),
	(25,'Tambah User','user','create','auth_users',0,NULL,1,NULL,'2021-05-10 17:31:03','2021-05-10 17:31:03',NULL);

/*!40000 ALTER TABLE `c_logs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table c_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `c_menus`;

CREATE TABLE `c_menus` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `parent` mediumint(8) NOT NULL DEFAULT '0',
  `controller` varchar(50) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `permission` varchar(255) DEFAULT NULL,
  `sort` mediumint(8) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('menu','label','reference') NOT NULL DEFAULT 'menu',
  `menu_category_id` int(11) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `c_menus` WRITE;
/*!40000 ALTER TABLE `c_menus` DISABLE KEYS */;

INSERT INTO `c_menus` (`id`, `name`, `parent`, `controller`, `icon`, `permission`, `sort`, `description`, `type`, `menu_category_id`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Menu',0,'label_menu','','access',1,NULL,'label',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(2,'Dashboard',0,'dashboard','pe-7s-display1','access',2,NULL,'menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(10,'Banner',0,'banner','pe-7s-photo','access|create|read|update|delete',4,NULL,'menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(14,'Laporan',0,'report','pe-7s-graph2','access',6,'','menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(15,'Kunjungan',14,'report/visitors','pe-7s-graph2','access',8,'','menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(16,'Admin',0,'label_admin','','access',9,NULL,'label',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(17,'User',0,'user','pe-7s-user','access|create|read|update|delete|enable|disable',10,NULL,'menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(18,'Group',0,'group','pe-7s-users','access|create|delete|read|update',11,'','menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(19,'Menu',22,'menu','pe-7s-menu','access|create|read|update|delete|enable|disable',14,NULL,'menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(22,'Setting',0,'param','pe-7s-config','access|create|read|update|delete',13,NULL,'menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(23,'Parameter',22,'param','','access',16,NULL,'menu',1,1,NULL,NULL,NULL,'2021-05-10 17:13:51',NULL),
	(24,'Beranda',0,'home','','access',30,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(25,'Kelembagaan',0,'#','','access',31,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(26,'Sejarah',31,'kelembagaan?slug=sejarah','','access',32,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(27,'Visi dan Misi',31,'kelembagaan?slug=visi-dan-misi','','access',33,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(28,'Tugas dan Fungsi',31,'kelembagaan?slug=tugas-dan-fungsi','','access',34,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(29,'Struktur Organisasi',31,'kelembagaan?slug=struktur-organisasi','','access',35,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(30,'Layanan',0,'#','','access',36,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(31,'Katalog Online',36,'layanan?slug=katalog-online','','access',37,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(32,'Keangotaan',36,'layanan?slug=keanggotaan','','access',38,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(33,'eResources',36,'layanan?slug=eresources','','access',39,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(34,'Peminjaman Online',36,'layanan?slug=peminjaman-online','','access',40,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(35,'Koleksi Digital',0,'#','','access',41,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(36,'Semua Koleksi',41,'koleksi?type=all','','access',42,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(37,'Koleksi Foto',41,'koleksi?type=image','','access',43,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(38,'Koleksi Video',41,'koleksi?type=video','','access',44,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(39,'Koleksi Audio',41,'koleksi?type=audio','','access',45,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(40,'Koleksi PDF Flipbook',41,'koleksi?type=pdf','','access',46,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(41,'Informasi',0,'#','','access',47,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(42,'Pengumuman',47,'pengumuman','','access',48,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(43,'Agenda',47,'agenda','','access',49,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(44,'Artikel',47,'artikel','','access',50,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(45,'Galeri Bung Hatta',47,'artikel?slug=bung-hatta','','access',51,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(46,'Tentang Minangkabau',47,'artikel?slug=minangkabau','','access',52,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(47,'Reformasi Birokrasi',47,'artikel?slug=reformasi-birokrasi','','access',53,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(48,'FAQs',47,'faqs','','access',54,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(49,'Kontak',0,'kontak','','access',55,NULL,'menu',2,1,NULL,NULL,NULL,NULL,NULL),
	(50,'Permission',0,'reference_','','access',0,'','menu',3,1,NULL,NULL,'2021-05-09 03:35:09','2021-05-09 03:35:09',NULL),
	(51,'Referensi',22,'reference','','access',17,'','menu',1,1,NULL,NULL,'2021-05-09 03:35:51','2021-05-10 17:13:51',NULL),
	(52,'Permission',22,'permission','pe-7s-shield','access',15,'','menu',1,1,NULL,NULL,'2021-05-09 03:48:13','2021-05-10 17:13:51',NULL),
	(53,'Access',0,'access','pe-7s-unlock','access',12,'','menu',1,1,NULL,NULL,'2021-05-09 03:52:27','2021-05-10 17:13:51',NULL),
	(54,'Halaman',0,'page','pe-7s-news-paper','access',5,'','menu',1,1,NULL,NULL,'2021-05-09 12:20:38','2021-05-10 17:13:51',NULL),
	(56,'Banner',0,'reference_banner','','access',0,'','menu',3,1,NULL,NULL,'2021-05-09 19:00:39','2021-05-09 19:00:39',NULL),
	(57,'Aktivitas',14,'report/logs','','access',7,'','menu',1,1,NULL,NULL,'2021-05-09 19:05:44','2021-05-10 17:13:51',NULL);

/*!40000 ALTER TABLE `c_menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table c_menus_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `c_menus_categories`;

CREATE TABLE `c_menus_categories` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `sort` mediumint(8) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `c_menus_categories` WRITE;
/*!40000 ALTER TABLE `c_menus_categories` DISABLE KEYS */;

INSERT INTO `c_menus_categories` (`id`, `name`, `slug`, `sort`, `description`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Side Menu','side-menu',1,NULL,1,NULL,NULL,NULL,NULL,NULL),
	(2,'Top Menu','top-menu',2,NULL,1,NULL,NULL,NULL,NULL,NULL),
	(3,'Reference Menu','reference-menu',3,NULL,1,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `c_menus_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table c_params
# ------------------------------------------------------------

DROP TABLE IF EXISTS `c_params`;

CREATE TABLE `c_params` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `c_params` WRITE;
/*!40000 ALTER TABLE `c_params` DISABLE KEYS */;

INSERT INTO `c_params` (`id`, `name`, `value`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'timezone','Asia/Jakarta','',NULL,NULL,NULL,NULL,NULL),
	(2,'site-name','Adminigniter','',NULL,NULL,NULL,'2021-05-09 17:20:09',NULL),
	(3,'site-description','Admin Codeigniter','',NULL,NULL,NULL,'2021-05-09 17:20:01',NULL),
	(4,'site-visitor-mode','1','0 = Read from Param site-visitor | 1 = Calculate by IP',NULL,NULL,NULL,NULL,NULL),
	(5,'site-visitor','50','',NULL,NULL,NULL,NULL,NULL),
	(6,'site-copyright','&copy; 2021 Adminigniter','',NULL,NULL,NULL,'2021-05-09 17:19:41',NULL),
	(7,'author','Hamka Mannan','',NULL,NULL,NULL,NULL,NULL),
	(8,'logo','/uploads/logo.png','',NULL,NULL,NULL,NULL,NULL),
	(9,'logo-small','/uploads/logo-small.png','',NULL,NULL,NULL,NULL,NULL),
	(10,'logo-inverse','/uploads/logo-inverse.png','',NULL,NULL,NULL,NULL,NULL),
	(11,'favicon','/uploads/favicon.png','',NULL,NULL,NULL,NULL,NULL),
	(12,'sidebar-mode','auto','auto = from database | manual = from file',NULL,NULL,NULL,NULL,NULL),
	(13,'topbar-mode','auto','auto = from database | manual = from file',NULL,NULL,NULL,NULL,NULL),
	(14,'sidebar-file','layout/backend/partial/navigation','file path without extention .php',NULL,NULL,NULL,NULL,NULL),
	(15,'topbar-file','layout/frontend/partial/navigation','file path without extention .php',NULL,NULL,NULL,NULL,NULL),
	(16,'show-logo-login','1','1 = show | 0 = hide means show site name',NULL,NULL,NULL,NULL,NULL),
	(17,'show-logo-sidebar','0','1 = show | 0 = hide means show site name',NULL,NULL,NULL,'2021-05-09 17:22:45',NULL),
	(18,'show-top-checkbox','1','1 = show | 0 = hide for top checkbox',NULL,NULL,NULL,'2021-05-09 17:22:36',NULL),
	(19,'show-layout-setting','0','1 = show | 0 = hide for floating bottom right icon',NULL,NULL,NULL,'2021-05-09 17:22:42',NULL),
	(20,'show-banner-intro','1','1 = show | 0 = hide for banner intro',NULL,NULL,NULL,NULL,NULL),
	(21,'logo-cs-class','bg-night-sky','bg-primary|bg-success|bg-warning|bg-danger|bg-royalbg-slick-carbon|bg-focus|bg-dark|bg-light',NULL,NULL,NULL,NULL,NULL),
	(22,'header-cs-class','bg-primary header-text-light','background and text',NULL,NULL,NULL,NULL,NULL),
	(23,'sidebar-cs-class','bg-night-sky sidebar-text-light','background and text',NULL,NULL,NULL,NULL,NULL),
	(24,'container-header-class','fixed-header','fixed-header',NULL,NULL,NULL,NULL,NULL),
	(25,'container-sidebar-class','fixed-sidebar','fixed-sidebar',NULL,NULL,NULL,NULL,NULL),
	(26,'container-footer-class','','fixed-footer',NULL,NULL,NULL,NULL,NULL),
	(27,'contact_initial','Adminigniter','',NULL,NULL,NULL,'2021-05-09 17:19:29',NULL),
	(28,'contact-name','Adminigniter','',NULL,NULL,NULL,'2021-05-09 17:19:22',NULL),
	(29,'contact-phone','08123456789','',NULL,NULL,NULL,'2021-05-09 17:21:43',NULL),
	(30,'contact-email','hamka@mannan.id','',NULL,NULL,NULL,'2021-05-09 17:21:23',NULL),
	(31,'contact-facebook','Adminigniter','',NULL,NULL,NULL,'2021-05-09 17:19:14',NULL),
	(32,'contact-facebook-url','https://facebook.com/','',NULL,NULL,NULL,NULL,NULL),
	(33,'contact-instagram','@adminigniter','',NULL,NULL,NULL,'2021-05-09 17:21:05',NULL),
	(34,'contact-instagram-url','https://instagram.com/','',NULL,NULL,NULL,NULL,NULL),
	(35,'contact-youtube','Adminigniter','',NULL,NULL,NULL,'2021-05-09 17:19:00',NULL),
	(36,'contact-youtube-url','https://youtube.com/','',NULL,NULL,NULL,NULL,NULL),
	(37,'contact-twitter','@adminigniter','',NULL,NULL,NULL,'2021-05-09 17:21:11',NULL),
	(38,'contact-twitter-url','https://twitter.com/','',NULL,NULL,NULL,NULL,NULL),
	(39,'limit-banner','5','',NULL,NULL,NULL,'2021-05-09 20:45:50',NULL);

/*!40000 ALTER TABLE `c_params` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table c_references
# ------------------------------------------------------------

DROP TABLE IF EXISTS `c_references`;

CREATE TABLE `c_references` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sort` mediumint(8) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `c_references` WRITE;
/*!40000 ALTER TABLE `c_references` DISABLE KEYS */;

INSERT INTO `c_references` (`id`, `slug`, `name`, `sort`, `description`, `menu_id`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,NULL,'access',1,'',50,1,NULL,NULL,'2021-05-09 03:41:43','2021-05-09 11:18:40',NULL),
	(2,NULL,'create',2,'',50,1,NULL,NULL,'2021-05-09 03:41:53','2021-05-09 11:18:51',NULL),
	(3,NULL,'read',3,'',50,1,NULL,NULL,'2021-05-09 03:42:04','2021-05-09 11:19:15',NULL),
	(4,NULL,'update',4,'',50,1,NULL,NULL,'2021-05-09 03:42:14','2021-05-09 11:19:24',NULL),
	(5,NULL,'delete',5,'',50,1,NULL,NULL,'2021-05-09 03:42:21','2021-05-09 11:19:34',NULL),
	(6,NULL,'enable',6,'',50,1,NULL,NULL,'2021-05-09 03:42:33','2021-05-09 11:19:42',NULL),
	(7,NULL,'disable',7,'',50,1,NULL,NULL,'2021-05-09 03:42:40','2021-05-09 11:19:50',NULL),
	(9,NULL,'Public',NULL,'',56,1,NULL,NULL,'2021-05-09 19:01:00','2021-05-09 19:01:00',NULL);

/*!40000 ALTER TABLE `c_references` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table c_visitors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `c_visitors`;

CREATE TABLE `c_visitors` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `ip_country` varchar(255) DEFAULT NULL,
  `ip_regionName` varchar(255) DEFAULT NULL,
  `ip_city` varchar(255) DEFAULT NULL,
  `ip_lat` varchar(255) DEFAULT NULL,
  `ip_lon` varchar(255) DEFAULT NULL,
  `ip_isp` varchar(255) DEFAULT NULL,
  `timestamp` date DEFAULT NULL,
  `hits` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_lon` (`ip_lon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`)
VALUES
	(1,'2017-11-20-223112','Myth\\Auth\\Database\\Migrations\\CreateAuthTables','default','Myth\\Auth',1619828323,1),
	(2,'20210101_000004','App\\Database\\Migrations\\Menus','default','App',1620513099,2),
	(6,'20210101_000008','App\\Database\\Migrations\\Params','default','App',1620513099,2),
	(7,'20210101_000009','App\\Database\\Migrations\\Logs','default','App',1620513099,2),
	(8,'20210101_000011','App\\Database\\Migrations\\Visitors','default','App',1620513099,2),
	(9,'20210101_000012','App\\Database\\Migrations\\References','default','App',1620513099,2),
	(12,'2021-05-09-002619','App\\Database\\Migrations\\AlterTableUsers','default','App',1620523885,3),
	(16,'20210101_000101','App\\Database\\Migrations\\Banner','default','App',1620580641,4),
	(17,'20210101_000106','App\\Database\\Migrations\\Page','default','App',1620580642,4);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table t_banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_banner`;

CREATE TABLE `t_banner` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `file_image` varchar(255) DEFAULT NULL,
  `sort` mediumint(8) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `url_title` varchar(255) DEFAULT NULL,
  `url_target` varchar(255) DEFAULT '_blank',
  `category_id` int(11) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table t_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_page`;

CREATE TABLE `t_page` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text,
  `tags` text,
  `file_image` varchar(255) DEFAULT NULL,
  `blog_category_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `viewers` int(11) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`, `first_name`, `last_name`, `phone`, `section`, `department`, `division`, `unit`, `company`, `address`)
VALUES
	(1,'admin@admin.com','admin','$2y$10$G/9kdP3SNUhMvIjmc37k7.1/01xb63vCY8GkmXt4D/rt7pV9WRffK',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-04-30 19:34:05','2021-05-09 20:43:57',NULL,'Admin1','Root1','sd',NULL,NULL,NULL,'das','sd','sd'),
	(2,'hamka@mannan.id','hamka','$2y$10$YX0YnK8K3csYBBvSycoZfeLWF6jbl/Vhj75miee/3FXB8QlGiBfmq',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-05-08 00:27:54','2021-05-09 11:16:37',NULL,'Hamka123','Mannan123','021',NULL,NULL,NULL,'Unit','Institusi','Alamat'),
	(10,'hamkamannan.id@gmail.com','hamkamannan','$2y$10$YX0YnK8K3csYBBvSycoZfeLWF6jbl/Vhj75miee/3FXB8QlGiBfmq',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-05-09 17:53:46','2021-05-09 17:53:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'sfd@werew.com','dsf','$2y$10$6qDxvS4uwC5iAsf0HuF75uzfgHnMYFARmk4K7tMGmZAgvoxIh/AxW',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-05-10 16:55:58','2021-05-10 16:56:21','2021-05-10 16:56:21','sdf','sdf','',NULL,NULL,NULL,'','',''),
	(12,'asd@we.com','asdads','$2y$10$BQIYkY2uEBeCbl.732EwWeWyf/1YQn5ahAO/GycDviprZXrHmkrN2',NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2021-05-10 17:31:03','2021-05-10 17:31:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
