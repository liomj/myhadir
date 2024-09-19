-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 02:10 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xsso_hbft`
--

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_aksesadmin`
--

CREATE TABLE `x083_myhadir_aksesadmin` (
  `id` int(255) NOT NULL,
  `uid` int(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_aksesadmin`
--

INSERT INTO `x083_myhadir_aksesadmin` (`id`, `uid`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_aksesprogram`
--

CREATE TABLE `x083_myhadir_aksesprogram` (
  `id` int(255) NOT NULL,
  `uid` int(128) NOT NULL,
  `idprogram` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_aksesprogram`
--

INSERT INTO `x083_myhadir_aksesprogram` (`id`, `uid`, `idprogram`) VALUES
(1, 1, 4),
(2, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_kategoripenerima`
--

CREATE TABLE `x083_myhadir_kategoripenerima` (
  `id` int(255) NOT NULL,
  `kategori` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_kategoripenerima`
--

INSERT INTO `x083_myhadir_kategoripenerima` (`id`, `kategori`) VALUES
(1, 'Peserta'),
(2, 'Ahli Jawatankuasa'),
(3, 'Penceramah'),
(4, 'Fasilitator');

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_kehadiran`
--

CREATE TABLE `x083_myhadir_kehadiran` (
  `idkehadiran` int(10) NOT NULL,
  `idprogram` int(10) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `mykad` varchar(256) NOT NULL,
  `idptj` int(11) NOT NULL,
  `idunit` int(11) NOT NULL,
  `idjawatan` int(11) NOT NULL,
  `idgred` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notelefon` varchar(255) NOT NULL,
  `statuskehadiran` int(11) NOT NULL,
  `idkategorikehadiran` int(11) NOT NULL,
  `tarikhdaftar` datetime DEFAULT NULL,
  `uidkemaskini` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_kehadiran`
--

INSERT INTO `x083_myhadir_kehadiran` (`idkehadiran`, `idprogram`, `nama`, `mykad`, `idptj`, `idunit`, `idjawatan`, `idgred`, `email`, `notelefon`, `statuskehadiran`, `idkategorikehadiran`, `tarikhdaftar`, `uidkemaskini`) VALUES
(15, 4, 'xoops1', '901116125496', 0, 51, 0, 0, 'liomj83@gai1.com', '', 0, 0, NULL, 0),
(9, 4, 'Lionel Michael Jominin', '830909125079', 0, 4, 0, 0, 'lionel.m@moh.gov.my', '', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_konfigurasiumum`
--

CREATE TABLE `x083_myhadir_konfigurasiumum` (
  `id` int(255) NOT NULL,
  `urusetiagroupid` int(11) NOT NULL,
  `urusetiacpgroupid` int(11) NOT NULL,
  `admingroupid` int(11) NOT NULL,
  `namaagensi` varchar(255) NOT NULL,
  `namasingkatan` varchar(255) NOT NULL,
  `alamat1` varchar(255) NOT NULL,
  `alamat2` varchar(255) NOT NULL,
  `negeri` varchar(255) NOT NULL,
  `notelefon` varchar(255) NOT NULL,
  `lamanweb` varchar(255) NOT NULL,
  `emailrasmi` varchar(255) NOT NULL,
  `apppassword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_konfigurasiumum`
--

INSERT INTO `x083_myhadir_konfigurasiumum` (`id`, `urusetiagroupid`, `urusetiacpgroupid`, `admingroupid`, `namaagensi`, `namasingkatan`, `alamat1`, `alamat2`, `negeri`, `notelefon`, `lamanweb`, `emailrasmi`, `apppassword`) VALUES
(1, 17, 32, 33, 'Hospital Beaufort', 'HBFT', 'Peti Surat 40', '89807 Beaufort', 'Sabah', '087-212333', 'https://jknsabah.moh.gov.my/hbeaufort/', 'hbeaufort@moh.gov.my', 'etndicexvhuroipw');

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_log`
--

CREATE TABLE `x083_myhadir_log` (
  `id` int(11) UNSIGNED NOT NULL,
  `idprogram` int(11) UNSIGNED NOT NULL,
  `tindakan` varchar(128) NOT NULL,
  `tarikh` datetime NOT NULL,
  `uid` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_log`
--

INSERT INTO `x083_myhadir_log` (`id`, `idprogram`, `tindakan`, `tarikh`, `uid`) VALUES
(40, 0, 'Hapus Semua Log', '2024-09-19 14:01:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_lokasi`
--

CREATE TABLE `x083_myhadir_lokasi` (
  `idlokasi` int(10) NOT NULL,
  `lokasi` varchar(256) NOT NULL,
  `susunan` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_lokasi`
--

INSERT INTO `x083_myhadir_lokasi` (`idlokasi`, `lokasi`, `susunan`) VALUES
(1, 'Hospital Beaufort', 1),
(2, 'Bilik Mesyuarat Weston Hospital Beaufort', 2),
(3, 'Bilik Mesyuarat Luagan Hospital Beaufort', 3),
(4, 'Dalam Talian', 4),
(5, 'Dewan Pak Musa Beaufort', 5),
(6, 'Pejabat Kesihatan Kawasan Beaufort', 6),
(7, 'Dewan Datuk Seri Panglima Haji Mohd Dun Banir, Beaufort', 7),
(8, 'Dewan Kesenian Islam Membakut', 8),
(9, 'Laman Saujana Hospital Beaufort', 9),
(10, 'Ruang Legar Jabatan Pesakit Luar Hospital Beaufort', 10),
(11, 'Unit Tabung Darah Hospital Beaufort', 11),
(12, 'Jabatan Pesakit Luar Hospital Beaufort', 12),
(13, 'Unit Hemodialisis Hospital Beaufort', 13),
(14, 'Unit Kecemasan dan Trauma', 14);

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_penganjur`
--

CREATE TABLE `x083_myhadir_penganjur` (
  `idpenganjur` int(10) NOT NULL,
  `penganjur` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_penganjur`
--

INSERT INTO `x083_myhadir_penganjur` (`idpenganjur`, `penganjur`) VALUES
(1, 'Jabatan Farmasi Hospital Beaufort'),
(2, 'Jawatankuasa Budaya Korporat Hospital Beaufort'),
(3, 'Hospital Beaufort'),
(4, 'Unit Pengurusan Aset dan Stor HBFT & JKN Sabah'),
(5, 'Hospital Beaufort & Pejabat Kesihatan Kawasan Beaufort'),
(6, 'Unit Kawalan Infeksi Hospital Beaufort'),
(7, 'Unit Pengurusan Hospital Beaufort'),
(8, 'Jawatankuasa Pain Free Hospital Beaufort'),
(9, 'AJK Breast Feeding Hospital Beaufort'),
(10, 'AJK Medication Safety Hospital Beaufort'),
(11, 'Unit Latihan Hospital Beaufort'),
(12, 'Jawatankuasa Anti Dadah Hospital Beaufort'),
(13, 'Jawatankuasa Basic Life Support Hospital Beaufort'),
(14, 'Jawatankuasa Budaya Korporat & AKRAB Hospital Beaufort'),
(15, 'Jawatankuasa Anti Dadah PKK Beaufort & Hospital Beaufort'),
(16, 'Unit Aset Hospital Beaufort'),
(17, 'Jabatan Kesihatan Negeri Sabah'),
(18, 'Jawatankuasa Hospital Infection & Antibiotic Control Committee'),
(19, 'Jawatankuasa Keselamatan Dan Kebakaran HBFT'),
(20, 'Unit Kejururawatan Hospital Beaufort'),
(21, 'Unit Teknologi Maklumat Hospital Beaufort'),
(24, 'Jawatankuasa Patient Safety Goal Hospital Beaufort'),
(25, 'Jawatankuasa HACCP Hospital Beaufort'),
(28, 'Jawatankuasa Incident Reporting Hospital Beaufort'),
(29, 'Jawatankuasa Pengurusan Aset Kerajaan HBFT');

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_program`
--

CREATE TABLE `x083_myhadir_program` (
  `idprogram` int(100) NOT NULL,
  `namaprogram` varchar(500) NOT NULL,
  `tarikhmula` datetime NOT NULL,
  `tarikhtamat` datetime DEFAULT NULL,
  `tarikhsahmula` datetime DEFAULT NULL,
  `tarikhsahtamat` datetime DEFAULT NULL,
  `idlokasi` varchar(254) NOT NULL,
  `idpenganjur` varchar(254) NOT NULL,
  `statusprogram` tinyint(1) NOT NULL COMMENT '0 - Tutup 1 - Buka'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_program`
--

INSERT INTO `x083_myhadir_program` (`idprogram`, `namaprogram`, `tarikhmula`, `tarikhtamat`, `tarikhsahmula`, `tarikhsahtamat`, `idlokasi`, `idpenganjur`, `statusprogram`) VALUES
(4, 'Mesyuarat Ketua-Ketua Unit Hospital Beaufort Bil 1/2024', '2024-09-18 00:00:00', '2024-09-19 00:00:00', NULL, NULL, '3', '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `x083_myhadir_unit`
--

CREATE TABLE `x083_myhadir_unit` (
  `idunit` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `x083_myhadir_unit`
--

INSERT INTO `x083_myhadir_unit` (`idunit`, `unit`) VALUES
(1, 'Unit Pengurusan'),
(4, 'Unit Teknologi Maklumat'),
(5, 'Unit Hasil'),
(6, 'Unit Kejuruteraan Operasi'),
(7, 'Unit Rekod Perubatan'),
(8, 'Unit Farmasi dan Logistik'),
(9, 'Unit Dietetik dan Sajian'),
(10, 'Unit Kejururawatan'),
(12, 'Unit Kawalan Infeksi'),
(13, 'Unit Hemodialisis'),
(15, 'Unit Fisioterapi'),
(16, 'Unit Pemulihan Cara Kerja'),
(17, 'Unit Kerja Sosial Perubatan'),
(19, 'Unit Radiologi'),
(20, 'Unit Patologi dan Transfusi Darah'),
(21, 'Unit Kecemasan dan Trauma'),
(26, 'Wad Lelaki'),
(27, 'Wad Perempuan'),
(28, 'Wad Kanak-Kanak'),
(30, 'Wad Obstetrik dan Ginekologi'),
(31, 'Wad Rehabilitasi'),
(32, 'Unit Penyeliaan Penolong Pegawai Perubatan'),
(33, 'Unit Latihan'),
(34, 'Unit Sucihama dan Bekalan Steril (CSSU)'),
(35, 'Unit Kualiti'),
(36, 'Unit Perhubungan Awam'),
(37, 'Unit Pesakit Luar'),
(38, 'Unit Promosi Kesihatan'),
(39, 'Unit Dewan Bedah'),
(50, 'Lain-Lain'),
(51, 'Hospital Kuala Penyu'),
(52, 'Hospital Sipitang'),
(53, 'Pejabat Kesihatan Kawasan Beaufort'),
(54, 'Unit Kesihatan Awam'),
(55, 'Unit Keselamatan Perlindungan'),
(56, 'Unit Kewangan dan Akaun'),
(57, 'Unit Aset dan Stor'),
(58, 'Unit Perubatan Forensik'),
(59, 'Unit Pembangunan,Perolehan dan Latihan'),
(60, 'Unit Sumber Manusia'),
(61, 'Unit Pentadbiran'),
(62, 'Hospital Beaufort'),
(63, 'Sedafiat'),
(64, 'Pekerja Mesra Ibadah (PMI)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `x083_myhadir_aksesadmin`
--
ALTER TABLE `x083_myhadir_aksesadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x083_myhadir_aksesprogram`
--
ALTER TABLE `x083_myhadir_aksesprogram`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x083_myhadir_kategoripenerima`
--
ALTER TABLE `x083_myhadir_kategoripenerima`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x083_myhadir_kehadiran`
--
ALTER TABLE `x083_myhadir_kehadiran`
  ADD PRIMARY KEY (`idkehadiran`);

--
-- Indexes for table `x083_myhadir_log`
--
ALTER TABLE `x083_myhadir_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `x083_myhadir_lokasi`
--
ALTER TABLE `x083_myhadir_lokasi`
  ADD PRIMARY KEY (`idlokasi`);

--
-- Indexes for table `x083_myhadir_penganjur`
--
ALTER TABLE `x083_myhadir_penganjur`
  ADD PRIMARY KEY (`idpenganjur`);

--
-- Indexes for table `x083_myhadir_program`
--
ALTER TABLE `x083_myhadir_program`
  ADD PRIMARY KEY (`idprogram`);

--
-- Indexes for table `x083_myhadir_unit`
--
ALTER TABLE `x083_myhadir_unit`
  ADD PRIMARY KEY (`idunit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `x083_myhadir_aksesadmin`
--
ALTER TABLE `x083_myhadir_aksesadmin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `x083_myhadir_aksesprogram`
--
ALTER TABLE `x083_myhadir_aksesprogram`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `x083_myhadir_kategoripenerima`
--
ALTER TABLE `x083_myhadir_kategoripenerima`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `x083_myhadir_kehadiran`
--
ALTER TABLE `x083_myhadir_kehadiran`
  MODIFY `idkehadiran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `x083_myhadir_log`
--
ALTER TABLE `x083_myhadir_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `x083_myhadir_lokasi`
--
ALTER TABLE `x083_myhadir_lokasi`
  MODIFY `idlokasi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `x083_myhadir_penganjur`
--
ALTER TABLE `x083_myhadir_penganjur`
  MODIFY `idpenganjur` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `x083_myhadir_program`
--
ALTER TABLE `x083_myhadir_program`
  MODIFY `idprogram` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `x083_myhadir_unit`
--
ALTER TABLE `x083_myhadir_unit`
  MODIFY `idunit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
