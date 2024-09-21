CREATE TABLE `myhadir_aksesadmin` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_aksesprogram` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(128) NOT NULL,
  `idprogram` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_kategorikehadiran` (
  `idkategorikehadiran` int(255) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(256) NOT NULL,
  PRIMARY KEY (`idkategorikehadiran`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_kehadiran` (
  `idkehadiran` int(10) NOT NULL AUTO_INCREMENT,
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
  `uidkemaskini` int(11) NOT NULL,
  PRIMARY KEY (`idkehadiran`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_konfigurasiumum` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
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
  `apppassword` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `myhadir_konfigurasiumum` (`id`, `urusetiagroupid`, `admingroupid`, `namaagensi`, `namasingkatan`, `alamat1`, `alamat2`, `negeri`, `notelefon`, `lamanweb`, `emailrasmi`, `apppassword`) VALUES
(1, 34, 35,'Hospital Beaufort', 'HBFT', 'Peti Surat 40', '89807 Beaufort', 'Sabah', '087-212333', 'https://jknsabah.moh.gov.my/hbeaufort/', 'hbeaufort@moh.gov.my', 'etndicexvhuroipw');

CREATE TABLE `myhadir_log` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idprogram` int(11) UNSIGNED NOT NULL,
  `tindakan` varchar(128) NOT NULL,
  `tarikh` datetime NOT NULL,
  `uid` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_lokasi` (
  `idlokasi` int(10) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(256) NOT NULL,
  `susunan` int(11) NOT NULL,
  PRIMARY KEY (`idlokasi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `myhadir_lokasi` (`idlokasi`, `lokasi`, `susunan`) VALUES
(1, 'Hospital Beaufort', 1),
(2, 'Bilik Mesyuarat Weston Hospital Beaufort', 2),
(3, 'Bilik Mesyuarat Luagan Hospital Beaufort', 3),
(4, 'Dalam Talian', 4);

CREATE TABLE `myhadir_penganjur` (
  `idpenganjur` int(10) NOT NULL AUTO_INCREMENT,
  `penganjur` varchar(256) NOT NULL,
  PRIMARY KEY (`idpenganjur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `myhadir_penganjur` (`idpenganjur`, `penganjur`) VALUES
(1, 'Hospital Beaufort');

CREATE TABLE `myhadir_organisasi` (
  `idorganisasi` int(10) NOT NULL AUTO_INCREMENT,
  `organisasi` varchar(256) NOT NULL,
  PRIMARY KEY (`idorganisasi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `myhadir_organisasi` (`idorganisasi`, `organisasi`) VALUES
(1, 'Hospital Beaufort'),
(2, 'Sedafiat');

CREATE TABLE `myhadir_program` (
  `idprogram` int(100) NOT NULL AUTO_INCREMENT,
  `namaprogram` varchar(500) NOT NULL,
  `tarikhmula` datetime NOT NULL,
  `tarikhtamat` datetime DEFAULT NULL,
  `tarikhsahmula` datetime DEFAULT NULL,
  `tarikhsahtamat` datetime DEFAULT NULL,
  `idlokasi` varchar(254) NOT NULL,
  `idpenganjur` varchar(254) NOT NULL,
  `statusprogram` tinyint(1) NOT NULL COMMENT '0 - Tutup 1 - Buka',
  PRIMARY KEY (`idprogram`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_unit` (
  `idunit` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) NOT NULL,
  PRIMARY KEY (`idunit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `myhadir_unit` (`idunit`, `unit`) VALUES
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
(19, 'Jabatan Radiologi'),
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
(64, 'Pekerja Mesra Ibadah (PMI)'),
(65, 'Jabatan Pembedahan Am'),
(66, 'Jabatan Perubatan Am'),
(67, 'Jabatan Anestesiologi dan Rawatan Rapi'),
(68, 'Jabatan Pediatrik'),
(69, 'Jabatan Obstetrik dan Ginekologi');