-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: mapache_itch_bd
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asignaciones_personal`
--

DROP TABLE IF EXISTS `asignaciones_personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignaciones_personal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_id` bigint unsigned NOT NULL,
  `habitacion_id` bigint unsigned NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asignaciones_personal_personal_id_foreign` (`personal_id`),
  KEY `asignaciones_personal_habitacion_id_foreign` (`habitacion_id`),
  CONSTRAINT `asignaciones_personal_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignaciones_personal_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaciones_personal`
--

LOCK TABLES `asignaciones_personal` WRITE;
/*!40000 ALTER TABLE `asignaciones_personal` DISABLE KEYS */;
/*!40000 ALTER TABLE `asignaciones_personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edificios`
--

DROP TABLE IF EXISTS `edificios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edificios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edificios`
--

LOCK TABLES `edificios` WRITE;
/*!40000 ALTER TABLE `edificios` DISABLE KEYS */;
INSERT INTO `edificios` VALUES (1,'Edificio N','Departamento de Sistemas y Computación, \r\nLaboratorio de Cómputo.',18.51821100,-88.30173800,'2024-10-31 11:33:08','2024-12-03 23:40:10'),(2,'Edificio W','Centro de Innovación Tecnologica del estado de Quintana Roo,  Departamento de Ingeniería Química y Bioquímica.',18.51910100,-88.30273600,'2024-12-03 22:56:10','2024-12-05 10:01:14'),(3,'Edificio L','-DIRECCIÓN\r\n-SUBDIRECCIÓN DE PLANEACIÓN Y VINCULACIÓN\r\n-SUBDIRECCIÓN DE SERVICIOS ADMINISTRATIVOS\r\n-DEPARTAMENTO DE RECURSOS FINANCIEROS\r\n-DEPARTAMENTO DE RECURSOS HUMANOS\r\n-DEPARTAMENTO DE PLANEACIÓN\r\n-PROGRAMACIÓN Y PRESUPUESTACIÓN\r\n-DEPARTAMENTO DE SERVICIOS ESCOLARES\r\n-BAÑOS',18.51882600,-88.30204900,'2024-12-05 09:49:48','2024-12-05 09:49:48'),(4,'Edificio A','-TALLER DE ESCOLTA Y BANDA DE GUERRA\r\n-TALLER DE DANZA\r\n-BAILE MODERNO Y TEATRO\r\n-TALLER DE MÚSICA\r\n-TALLER DE PINTURA Y AJEDREZ\r\n-TALLER DE TAEKWONDO\r\n-BAÑOS',18.51892100,-88.30320800,'2024-12-05 10:02:05','2024-12-05 10:04:56'),(5,'Edificio C','-DEPARTAMENTO DE CIENCIAS ECONÓMICO-ADMINISTRATIVAS\r\n-TECNOLÓGICO ABIERTO',18.51867900,-88.30356700,'2024-12-05 10:21:42','2024-12-05 10:21:42'),(6,'Edificio D','-DEPARTAMENTO DE ACTIVIDADES EXTRAESCOLARES\r\n-DEPARTAMENTO DE GESTIÓN TECNOLÓGICA Y VINCULACIÓN\r\n-LABORATORIO DE CIENCIAS ECONÓMICO-ADMINISTRATIVAS',18.51842200,-88.30359700,'2024-12-05 10:23:31','2024-12-05 10:23:31'),(7,'Edificio I','-AULA I-1\r\n-AULA I-2\r\n-AULA I-3\r\n-AULA I-4',18.51818300,-88.30357500,'2024-12-05 10:45:15','2024-12-05 10:45:15');
/*!40000 ALTER TABLE `edificios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `habitacion_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `eventos_habitacion_id_foreign` (`habitacion_id`),
  CONSTRAINT `eventos_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (1,'Congreso de Residencias 2024','Se realizará el congreso de residencias Diciembre 2024','2024-12-06 08:00:00','2024-12-06 15:00:00',1,'2024-12-05 21:06:14','2024-12-05 21:06:14'),(2,'Prueba de evento','Descripción del evento','2024-12-07 13:00:00','2024-12-07 18:00:00',1,'2024-12-05 21:07:01','2024-12-05 21:07:01');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habitaciones`
--

DROP TABLE IF EXISTS `habitaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitaciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `edificio_id` bigint unsigned NOT NULL,
  `tipo_habitacion_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `habitaciones_edificio_id_foreign` (`edificio_id`),
  KEY `habitaciones_tipo_habitacion_id_foreign` (`tipo_habitacion_id`),
  CONSTRAINT `habitaciones_edificio_id_foreign` FOREIGN KEY (`edificio_id`) REFERENCES `edificios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `habitaciones_tipo_habitacion_id_foreign` FOREIGN KEY (`tipo_habitacion_id`) REFERENCES `tipos_habitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitaciones`
--

LOCK TABLES `habitaciones` WRITE;
/*!40000 ALTER TABLE `habitaciones` DISABLE KEYS */;
INSERT INTO `habitaciones` VALUES (1,'Salon V-10','Aula de Sistemas',1,1,'2024-10-31 12:12:16','2024-10-31 12:12:16');
/*!40000 ALTER TABLE `habitaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios_personal`
--

DROP TABLE IF EXISTS `horarios_personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios_personal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `personal_id` bigint unsigned NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `habitacion_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `horarios_personal_personal_id_foreign` (`personal_id`),
  KEY `horarios_personal_habitacion_id_foreign` (`habitacion_id`),
  CONSTRAINT `horarios_personal_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `horarios_personal_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios_personal`
--

LOCK TABLES `horarios_personal` WRITE;
/*!40000 ALTER TABLE `horarios_personal` DISABLE KEYS */;
INSERT INTO `horarios_personal` VALUES (1,1,'Lunes','13:00:00','15:00:00',1,'2024-12-03 20:39:01','2024-12-03 20:39:01'),(2,1,'Martes','13:00:00','15:00:00',1,'2024-12-03 20:39:32','2024-12-03 20:39:32'),(3,2,'Jueves','17:00:00','20:00:00',1,'2024-12-03 20:48:38','2024-12-03 20:48:38');
/*!40000 ALTER TABLE `horarios_personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2024_10_07_235835_create_permission_tables',1),(5,'2024_10_30_185912_crear_tabla_edificios',2),(6,'2024_10_31_063726_crear_tabla_tipos_habitaciones',3),(7,'2024_10_31_063815_crear_tabla_habitaciones',3),(8,'2024_12_02_041018_add_firebase_uid_to_users_table',4),(9,'2024_12_03_150917_create_personal_table',5),(10,'2024_12_03_150941_create_asignaciones_personal_table',5),(11,'2024_12_03_150952_create_horarios_personal_table',5),(12,'2024_12_05_155324_create_eventos_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` VALUES (21,'App\\Models\\User',3);
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',2),(3,'App\\Models\\User',3),(2,'App\\Models\\User',4);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'ver-rol','web','2024-10-31 10:55:41','2024-10-31 10:55:41'),(2,'crear-rol','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(3,'editar-rol','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(4,'borrar-rol','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(5,'ver-usuario','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(6,'crear-usuario','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(7,'editar-usuario','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(8,'borrar-usuario','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(9,'ver-edificio','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(10,'crear-edificio','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(11,'editar-edificio','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(12,'borrar-edificio','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(13,'ver-habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(14,'crear-habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(15,'editar-habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(16,'borrar-habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(17,'ver-tipo_habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(18,'crear-tipo_habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(19,'editar-tipo_habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(20,'borrar-tipo_habitaciones','web','2024-10-31 10:55:42','2024-10-31 10:55:42'),(21,'ver-ubicacion-maestros','web','2024-12-02 09:47:45','2024-12-02 09:47:45'),(22,'ver-personal','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(23,'crear-personal','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(24,'editar-personal','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(25,'borrar-personal','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(26,'ver-horarios','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(27,'crear-horarios','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(28,'editar-horarios','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(29,'borrar-horarios','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(30,'ver-eventos','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(31,'crear-eventos','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(32,'editar-eventos','web','2024-12-09 01:41:33','2024-12-09 01:41:33'),(33,'borrar-eventos','web','2024-12-09 01:41:33','2024-12-09 01:41:33');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('Docente','Administrativo') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_correo_unique` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (1,'Prueba de maestro','maestro@gmail.com','Docente','2024-12-03 20:26:14','2024-12-03 20:26:14'),(2,'Prueba de maestro 2','maestro2@gmail.com','Docente','2024-12-03 20:47:57','2024-12-03 20:47:57'),(4,'Prueba admnistrativo','administrativo@gmail.com','Administrativo','2024-12-09 01:47:05','2024-12-09 01:47:05');
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(1,2),(3,2),(5,2),(7,2),(9,2),(11,2),(13,2),(15,2),(17,2),(19,2),(22,2),(24,2),(26,2),(28,2),(30,2),(32,2),(21,3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','web','2024-10-31 11:22:43','2024-10-31 11:22:43'),(2,'Editor','web','2024-10-31 11:23:18','2024-10-31 11:23:18'),(3,'Alumno','web','2024-12-02 09:55:14','2024-12-02 09:55:14');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_habitaciones`
--

DROP TABLE IF EXISTS `tipos_habitaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_habitaciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_habitaciones`
--

LOCK TABLES `tipos_habitaciones` WRITE;
/*!40000 ALTER TABLE `tipos_habitaciones` DISABLE KEYS */;
INSERT INTO `tipos_habitaciones` VALUES (1,'Aula','Aula de clases','2024-10-31 12:11:19','2024-10-31 12:11:19'),(2,'Laboratorio','Laboratorio de la carrera','2024-10-31 12:11:41','2024-10-31 12:11:41'),(3,'Oficina','Oficina departamental','2024-10-31 12:11:53','2024-10-31 12:11:53');
/*!40000 ALTER TABLE `tipos_habitaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firebase_uid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Administrador','admin@gmail.com',NULL,'$2y$10$yY3Rh6tFNSMgWTqCWt12X.ucO.DxygQXya3YCI4YvtA6SllyjSv0q',NULL,NULL,'2024-10-31 10:42:26','2024-10-31 10:42:26'),(3,'ALEJANDRO TAFFAREL REYES GARZA','l20390301@chetumal.tecnm.mx',NULL,'$2y$10$EITP2uM1R3hTjnuEU.wPj.CKFzz6WcKW3tqrzOXxlkgjKVSGL3wCW','d7vxtKuegAORMjT4qvJuLyBIyc42',NULL,'2024-12-02 09:12:47','2024-12-02 09:32:14'),(4,'Alejandro Reyes','alejandro@gmail.com',NULL,'$2y$10$zCdYIWTTzQA8xC7qI4s2l.CkeNWhl1VaEfnpUvtJzzajZxNDs4iUy',NULL,NULL,'2024-12-02 21:46:27','2024-12-02 21:46:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-30 16:29:04
