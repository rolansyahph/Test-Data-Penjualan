-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for master_barang
CREATE DATABASE IF NOT EXISTS `master_barang` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `master_barang`;

-- Dumping structure for table master_barang.data_barang
CREATE TABLE IF NOT EXISTS `data_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(25) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `satuan` varchar(25) DEFAULT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table master_barang.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(50) NOT NULL DEFAULT '',
  `nama_barang` varchar(255) NOT NULL DEFAULT '',
  `jumlah_terjual` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`kode_barang`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure master_barang.sp_get_data_barang
DELIMITER //
CREATE PROCEDURE `sp_get_data_barang`()
BEGIN
 SELECT * FROM data_barang;
END//
DELIMITER ;

-- Dumping structure for procedure master_barang.sp_get_data_penjualan
DELIMITER //
CREATE PROCEDURE `sp_get_data_penjualan`()
BEGIN
SELECT * FROM penjualan;
END//
DELIMITER ;

-- Dumping structure for procedure master_barang.sp_hapus_data_barang
DELIMITER //
CREATE PROCEDURE `sp_hapus_data_barang`(
	IN `p_kode_barang` VARCHAR(50)
)
BEGIN
    DELETE FROM data_barang WHERE kode_barang = p_kode_barang;
END//
DELIMITER ;

-- Dumping structure for procedure master_barang.sp_input_data_barang
DELIMITER //
CREATE PROCEDURE `sp_input_data_barang`(
	IN `p_nama_barang` VARCHAR(255),
	IN `p_satuan` VARCHAR(50),
	IN `p_stok` INT,
	IN `p_jenis_barang` VARCHAR(50)
)
BEGIN
    DECLARE lastId INT;
    DECLARE no_kode_barang VARCHAR(25);
    
    SELECT COALESCE(MAX(id), 0) INTO lastId FROM data_barang;

    SET lastId = lastId + 1;

    IF p_jenis_barang = 'pembersih' THEN
        SET no_kode_barang = CONCAT('P-', LPAD(lastId, 5, '0'));
    ELSEIF p_jenis_barang = 'konsumsi' THEN
        SET no_kode_barang = CONCAT('K-', LPAD(lastId, 5, '0'));
    END IF;

    INSERT INTO data_barang (kode_barang, nama_barang, satuan, stok, jenis_barang)
    VALUES (no_kode_barang, p_nama_barang, p_satuan, p_stok, p_jenis_barang);
END//
DELIMITER ;

-- Dumping structure for procedure master_barang.sp_input_data_penjualan
DELIMITER //
CREATE PROCEDURE `sp_input_data_penjualan`(
	IN `p_kode_barang` VARCHAR(50),
	IN `p_jumlah_terjual` INT
)
BEGIN
    -- Variabel untuk menyimpan stok saat ini
    DECLARE v_stok_saat_ini INT;

    -- Ambil stok saat ini dari data_barang
    SELECT stok INTO v_stok_saat_ini
    FROM data_barang
    WHERE kode_barang = p_kode_barang;

    -- Lakukan operasi penjualan hanya jika stok mencukupi
    IF v_stok_saat_ini >= p_jumlah_terjual THEN
        -- Kurangi stok jika stok mencukupi
        UPDATE data_barang
        SET stok = stok - p_jumlah_terjual
        WHERE kode_barang = p_kode_barang;

        -- Simpan data penjualan ke tabel penjualan
        INSERT INTO penjualan (kode_barang, nama_barang, jumlah_terjual, tanggal_transaksi)
        SELECT kode_barang, nama_barang, p_jumlah_terjual, CURDATE()
        FROM data_barang
        WHERE kode_barang = p_kode_barang;
    END IF;
END//
DELIMITER ;

-- Dumping structure for procedure master_barang.sp_update_data_barang
DELIMITER //
CREATE PROCEDURE `sp_update_data_barang`(
	IN `p_kode_barang` VARCHAR(50),
	IN `p_stok` INT
)
BEGIN
    UPDATE data_barang
    SET stok = p_stok
    WHERE kode_barang = p_kode_barang;
END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
