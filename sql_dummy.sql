-- --------------------------------------------------------
-- Host:                         localhost
-- Versi server:                 10.4.19-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win64
-- HeidiSQL Versi:               9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Membuang struktur basisdata untuk 20211_wp2_412019037
DROP DATABASE IF EXISTS `20211_wp2_412019037`;
CREATE DATABASE IF NOT EXISTS `20211_wp2_412019037` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `20211_wp2_412019037`;

-- membuang struktur untuk table 20211_wp2_412019037.account_tb
DROP TABLE IF EXISTS `account_tb`;
CREATE TABLE IF NOT EXISTS `account_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `gambar_profil` varchar(255) DEFAULT 'no-photo.png',
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.account_tb: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `account_tb` DISABLE KEYS */;
INSERT INTO `account_tb` (`id`, `email`, `gambar_profil`, `password`) VALUES
	(18, 'budi@santoso.com', '18.jpg', 'dono3232');
/*!40000 ALTER TABLE `account_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.admin_tb
DROP TABLE IF EXISTS `admin_tb`;
CREATE TABLE IF NOT EXISTS `admin_tb` (
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.admin_tb: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `admin_tb` DISABLE KEYS */;
INSERT INTO `admin_tb` (`email`, `pass`) VALUES
	('admin_database@foodever.com', 'admin');
/*!40000 ALTER TABLE `admin_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.feedback_tb
DROP TABLE IF EXISTS `feedback_tb`;
CREATE TABLE IF NOT EXISTS `feedback_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `feedback_text` text NOT NULL,
  `acc_id` int(255) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.feedback_tb: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `feedback_tb` DISABLE KEYS */;
INSERT INTO `feedback_tb` (`id`, `feedback_text`, `acc_id`) VALUES
	(5, 'Semoga terus berkembang', 18),
	(6, 'Makanannya enak bangeeeeeeet.....', 18);
/*!40000 ALTER TABLE `feedback_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.gallery_foto_restaurant_tb
DROP TABLE IF EXISTS `gallery_foto_restaurant_tb`;
CREATE TABLE IF NOT EXISTS `gallery_foto_restaurant_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nama_foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.gallery_foto_restaurant_tb: ~4 rows (lebih kurang)
/*!40000 ALTER TABLE `gallery_foto_restaurant_tb` DISABLE KEYS */;
INSERT INTO `gallery_foto_restaurant_tb` (`id`, `nama_foto`) VALUES
	(1, '1.jpg'),
	(2, '2.jpg'),
	(3, '3.jpg'),
	(4, '4.jpg');
/*!40000 ALTER TABLE `gallery_foto_restaurant_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.kategori_tb
DROP TABLE IF EXISTS `kategori_tb`;
CREATE TABLE IF NOT EXISTS `kategori_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  `nama_foto` varchar(50) NOT NULL DEFAULT 'non.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.kategori_tb: ~4 rows (lebih kurang)
/*!40000 ALTER TABLE `kategori_tb` DISABLE KEYS */;
INSERT INTO `kategori_tb` (`id`, `nama_kategori`, `nama_foto`) VALUES
	(0, 'Null', 'non.png'),
	(12, 'Jus', '12.jpg'),
	(13, 'Makanan', '13.jpg'),
	(14, 'Es Krim', '14.jpg');
/*!40000 ALTER TABLE `kategori_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.menu_tb
DROP TABLE IF EXISTS `menu_tb`;
CREATE TABLE IF NOT EXISTS `menu_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nama_makanan` varchar(100) NOT NULL DEFAULT '0',
  `harga_makanan` int(10) NOT NULL DEFAULT 0,
  `deskripsi_makanan` varchar(400) DEFAULT '0',
  `gambar_makanan` varchar(255) DEFAULT 'non.png',
  `kategori_id` int(255) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `menu_kat_rel` (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.menu_tb: ~13 rows (lebih kurang)
/*!40000 ALTER TABLE `menu_tb` DISABLE KEYS */;
INSERT INTO `menu_tb` (`id`, `nama_makanan`, `harga_makanan`, `deskripsi_makanan`, `gambar_makanan`, `kategori_id`) VALUES
	(77, 'Nasi Goreng', 15000, '    ', '77.jpg', 13),
	(78, 'Jus Jambu', 7000, '', '78.jpg', 12),
	(79, 'Bakso Malang', 15000, ' ', '79.jpg', 13),
	(80, 'Es Krim Strawberry', 15000, '', '80.jpg', 14),
	(81, 'Es Krim Coklat', 15000, '', '81.png', 14),
	(82, 'Milkshake Oreo', 15000, '', '82.jpg', 14),
	(83, 'Es Krim Vanilla', 15000, '', '83.jpg', 14),
	(84, 'Jus Sirsak', 12000, '', '84.jpg', 12),
	(85, 'Jus Alpukat', 15000, '', '85.jpg', 12),
	(86, 'Dimsum', 15000, '', '86.jpg', 13),
	(87, 'Mie Ayam', 15000, '', '87.jpg', 13),
	(88, 'Sop Iga Sapi', 23333, '', '88.jpg', 13),
	(89, 'Capcay', 15000, '', '89.jpg', 13),
	(90, 'Es Jeruk Peras', 7000, '', '90.jpg', 12);
/*!40000 ALTER TABLE `menu_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.personal_info_tb
DROP TABLE IF EXISTS `personal_info_tb`;
CREATE TABLE IF NOT EXISTS `personal_info_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_telepon` varchar(12) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `account_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.personal_info_tb: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `personal_info_tb` DISABLE KEYS */;
INSERT INTO `personal_info_tb` (`id`, `nama_lengkap`, `no_telepon`, `alamat`, `account_id`) VALUES
	(23, 'Budi Santoso', '088454550000', 'JL. KAYUMANIS LAMA V/I', 18);
/*!40000 ALTER TABLE `personal_info_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.purchase_history_detail_tb
DROP TABLE IF EXISTS `purchase_history_detail_tb`;
CREATE TABLE IF NOT EXISTS `purchase_history_detail_tb` (
  `receipt_code` varchar(255) NOT NULL,
  `menu_id` int(255) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.purchase_history_detail_tb: ~8 rows (lebih kurang)
/*!40000 ALTER TABLE `purchase_history_detail_tb` DISABLE KEYS */;
INSERT INTO `purchase_history_detail_tb` (`receipt_code`, `menu_id`, `jumlah`) VALUES
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 78, 1),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 90, 1),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 84, 1),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 85, 2),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 89, 2),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 87, 3),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 80, 1),
	('535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 83, 1),
	('c2356069e9d1e79ca924378153cfbbfb4d4416b1f99d41a2940bfdb66c5319db', 78, 4),
	('c2356069e9d1e79ca924378153cfbbfb4d4416b1f99d41a2940bfdb66c5319db', 84, 3);
/*!40000 ALTER TABLE `purchase_history_detail_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.purchase_history_tb
DROP TABLE IF EXISTS `purchase_history_tb`;
CREATE TABLE IF NOT EXISTS `purchase_history_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `receipt_code` varchar(255) NOT NULL,
  `tanggal_beli` datetime NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `acc_id` int(255) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.purchase_history_tb: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `purchase_history_tb` DISABLE KEYS */;
INSERT INTO `purchase_history_tb` (`id`, `receipt_code`, `tanggal_beli`, `alamat`, `acc_id`, `filename`) VALUES
	(23, '535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', '2022-01-02 11:48:47', 'JL. MATRAMAN RAYA', 18, 'receipt-23.pdf'),
	(24, 'c2356069e9d1e79ca924378153cfbbfb4d4416b1f99d41a2940bfdb66c5319db', '2022-01-02 15:33:20', 'JL. KAYUMANIS LAMA V/I', 18, 'receipt-24.pdf');
/*!40000 ALTER TABLE `purchase_history_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.reserve_history_tb
DROP TABLE IF EXISTS `reserve_history_tb`;
CREATE TABLE IF NOT EXISTS `reserve_history_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `tanggal_dipesan` datetime NOT NULL,
  `reserve_table_id` int(255) NOT NULL,
  `acc_id` int(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `receipt_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.reserve_history_tb: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `reserve_history_tb` DISABLE KEYS */;
INSERT INTO `reserve_history_tb` (`id`, `tanggal`, `tanggal_dipesan`, `reserve_table_id`, `acc_id`, `filename`, `receipt_code`) VALUES
	(12, '2022-01-08 17:17:00', '2022-01-02 17:18:39', 8, 18, 'receipt-12.pdf', '6b51d431df5d7f141cbececcf79edf3dd861c3b4069f0b11661a3eefacbba918'),
	(13, '2022-01-11 17:22:00', '2022-01-02 17:22:09', 9, 18, 'receipt-13.pdf', '3fdba35f04dc8c462986c992bcf875546257113072a909c162f7e470e581e278');
/*!40000 ALTER TABLE `reserve_history_tb` ENABLE KEYS */;

-- membuang struktur untuk table 20211_wp2_412019037.reserve_table_tb
DROP TABLE IF EXISTS `reserve_table_tb`;
CREATE TABLE IF NOT EXISTS `reserve_table_tb` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nama_meja` varchar(255) NOT NULL,
  `kapasitas` int(10) NOT NULL DEFAULT 0,
  `harga` int(10) NOT NULL DEFAULT 0,
  `posisi` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT '',
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Membuang data untuk tabel 20211_wp2_412019037.reserve_table_tb: ~4 rows (lebih kurang)
/*!40000 ALTER TABLE `reserve_table_tb` DISABLE KEYS */;
INSERT INTO `reserve_table_tb` (`id`, `nama_meja`, `kapasitas`, `harga`, `posisi`, `deskripsi`, `status`) VALUES
	(7, 'Meja 1', 4, 385000, 'Indoor, dekat Live Band', 'Meja ini berada di sekitar live band. Sangat cocok bagi anda yang ingin menikmati musik beserta makanan anda.', 'tersedia'),
	(8, 'Meja 4', 4, 350000, 'Indoor', 'Meja untuk 4 orang. Anda dapat menggunakannya untuk berkumpul bersama keluarga atau berjumpa dengan rekan kantor anda.', 'tersedia'),
	(9, 'Meja Ulang Tahun', 8, 1000000, 'Indoor, dekat Live Band', 'Merayakan ulang tahun, kini lebih berkelas dengan makan di tempat ini. Anda juga dapat merequest lagu yang ingin dinyanyikan', 'tersedia'),
	(11, 'Meja Panjang 1', 16, 600000, 'Outdoor, berada di sisi pemandangan alam', 'Ingin makan bersama-sama dengan keluarga besar dan mendapatkan pemandangan yang bagus? Pilih meja ini sekarang!', 'tersedia');
/*!40000 ALTER TABLE `reserve_table_tb` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
