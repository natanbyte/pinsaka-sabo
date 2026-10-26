-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ci4
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bagian`
--

DROP TABLE IF EXISTS `bagian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bagian` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_bagian` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bagian`
--

LOCK TABLES `bagian` WRITE;
/*!40000 ALTER TABLE `bagian` DISABLE KEYS */;
INSERT INTO `bagian` VALUES (1,'Tata Usaha'),(2,'Umum dan Kepegawaian'),(3,'Keuangan'),(4,'Perencanaan'),(5,'Teknis');
/*!40000 ALTER TABLE `bagian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foto_laporan`
--

DROP TABLE IF EXISTS `foto_laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foto_laporan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `laporan_id` int(11) unsigned NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `jenis` enum('awal','perbaikan') DEFAULT 'awal',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foto_laporan_laporan_id_foreign` (`laporan_id`),
  CONSTRAINT `foto_laporan_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporan_kerusakan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foto_laporan`
--

LOCK TABLES `foto_laporan` WRITE;
/*!40000 ALTER TABLE `foto_laporan` DISABLE KEYS */;
INSERT INTO `foto_laporan` VALUES (1,1,'1792651103_a5c389aa25e6359bdf60.png','awal','2026-10-22 13:38:23'),(2,1,'1792651103_ef656a1e243dcf040933.png','awal','2026-10-22 13:38:23'),(3,1,'1792651103_7c2cbd669cfae22684ef.png','awal','2026-10-22 13:38:23'),(4,1,'1792651103_260302e075d85cc42ea4.png','awal','2026-10-22 13:38:23'),(5,1,'1792651103_1776aa031e9734848d7a.png','awal','2026-10-22 13:38:23'),(6,2,'1792651400_1bcf35e1520c2e12bc11.png','awal','2026-10-22 13:43:20'),(7,5,'test_rem_rusak.jpg','awal','2026-10-26 07:11:59'),(8,5,'test_rem_selesai.jpg','perbaikan','2026-10-26 07:11:59');
/*!40000 ALTER TABLE `foto_laporan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laporan_kerusakan`
--

DROP TABLE IF EXISTS `laporan_kerusakan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laporan_kerusakan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kode_laporan` varchar(30) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `kategori_laporan` enum('sarpras','kendaraan') DEFAULT 'sarpras',
  `lokasi_id` int(11) unsigned DEFAULT NULL,
  `kendaraan_id` int(11) unsigned DEFAULT NULL,
  `nama_kendaraan` varchar(150) DEFAULT NULL,
  `nomor_polisi` varchar(20) DEFAULT NULL,
  `odometer` varchar(30) DEFAULT NULL,
  `bagian_kendaraan` varchar(100) DEFAULT NULL,
  `lokasi_kejadian` varchar(200) DEFAULT NULL,
  `jenis_kerusakan` enum('ringan','sedang','berat') NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('baru','diproses','selesai') NOT NULL DEFAULT 'baru',
  `catatan_admin` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_laporan` (`kode_laporan`),
  KEY `laporan_kerusakan_user_id_foreign` (`user_id`),
  KEY `laporan_kerusakan_lokasi_id_foreign` (`lokasi_id`),
  KEY `status` (`status`),
  CONSTRAINT `laporan_kerusakan_lokasi_id_foreign` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi_sarpras` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `laporan_kerusakan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan_kerusakan`
--

LOCK TABLES `laporan_kerusakan` WRITE;
/*!40000 ALTER TABLE `laporan_kerusakan` DISABLE KEYS */;
INSERT INTO `laporan_kerusakan` VALUES (1,'LK-261022-8AE600',2,'sarpras',2,NULL,NULL,NULL,NULL,NULL,NULL,'berat','Rusak Bagian AC','diproses','oke kita tindak lanjuti','2026-10-22 13:38:22','2026-10-24 10:27:32'),(2,'LK-261022-21E54F',2,'sarpras',4,NULL,NULL,NULL,NULL,NULL,NULL,'sedang','kerusakan pada ac, dan tempat duduk','selesai','terima kasih','2026-10-22 13:43:20','2026-10-22 14:06:36'),(5,'LK-TEST-711',2,'kendaraan',NULL,1,'Toyota Hilux Double Cabin 4x4 Lapangan','AB 1042 BS','68.500 km','Sistem Rem, Suspensi & Kaki-kaki','Jalur Survei Sabo Dam Kali Krasak','sedang','Test kerusakan kendaraan dinas masuk database MySQL.','selesai','Perbaikan kampas rem telah selesai dan diuji coba.','2026-10-26 07:11:59','2026-10-26 07:11:59');
/*!40000 ALTER TABLE `laporan_kerusakan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokasi_sarpras`
--

DROP TABLE IF EXISTS `lokasi_sarpras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lokasi_sarpras` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(150) NOT NULL,
  `kategori` enum('ruang','kendaraan','fasilitas') NOT NULL DEFAULT 'fasilitas',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lokasi_sarpras`
--

LOCK TABLES `lokasi_sarpras` WRITE;
/*!40000 ALTER TABLE `lokasi_sarpras` DISABLE KEYS */;
INSERT INTO `lokasi_sarpras` VALUES (1,'Media Center Auditorium Merapi','ruang'),(2,'Ruang Rapat Semeru','ruang'),(3,'Ruang Rapat Kelud','ruang'),(4,'Ruang Rapat Sinabung','ruang'),(5,'Kendaraan Dinas','kendaraan'),(6,'Gedung Kantor Utama','fasilitas'),(7,'Area Parkir','fasilitas'),(8,'Toilet','fasilitas'),(9,'Media Center Auditorium Merapi','ruang'),(10,'Ruang Rapat Semeru','ruang'),(11,'Ruang Rapat Kelud','ruang'),(12,'Ruang Rapat Sinabung','ruang'),(13,'Kendaraan Dinas','kendaraan'),(14,'Gedung Kantor Utama','fasilitas'),(15,'Area Parkir','fasilitas'),(16,'Toilet','fasilitas');
/*!40000 ALTER TABLE `lokasi_sarpras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-10-22-000001','App\\Database\\Migrations\\CreateBagian','default','App',1792650467,1),(2,'2026-10-22-000002','App\\Database\\Migrations\\CreateUsers','default','App',1792650467,1),(3,'2026-10-22-000003','App\\Database\\Migrations\\CreateLokasiSarpras','default','App',1792650467,1),(4,'2026-10-22-000004','App\\Database\\Migrations\\CreateLaporanKerusakan','default','App',1792650467,1),(5,'2026-10-22-000005','App\\Database\\Migrations\\CreateFotoLaporan','default','App',1792650467,1),(6,'2026-10-25-000006','App\\Database\\Migrations\\AddKendaraanToLaporanKerusakan','default','App',1792991374,2),(7,'2026-10-26-000007','App\\Database\\Migrations\\AddJenisToFotoLaporan','default','App',1792991407,3),(8,'2026-10-26-000008','App\\Database\\Migrations\\MakeLokasiIdNullableInLaporanKerusakan','default','App',1792995112,4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(150) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `bagian_id` int(11) unsigned DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pegawai','admin') NOT NULL DEFAULT 'pegawai',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`),
  UNIQUE KEY `email` (`email`),
  KEY `users_bagian_id_foreign` (`bagian_id`),
  CONSTRAINT `users_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `bagian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','000000000000000001',1,'081200000001','admin@pinsaka.test','$2y$10$tPiu/ZTz0uGSo6ITOA.vJObD7UvqCrnpwkORlWhL3jwnWVuIvfY5W','admin','2026-10-22 06:28:18','2026-10-22 06:28:18'),(2,'Pegawai Contoh','199001012020011001',2,'081200000002','pegawai@pinsaka.test','$2y$10$K7AD7yyknZB1u8P5YDkzweOKkKQwK3HgExtXoIzfqTOADGIoy5w3O','pegawai','2026-10-22 06:28:18','2026-10-22 06:28:18');
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

-- Dump completed on 2026-10-26 13:12:23
