CREATE TABLE `myhadir_aksesprogram` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(128) NOT NULL,
  `idprogram` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `myhadir_kategoripenerima` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `myhadir_kategoripenerima` (`id`, `kategori`) VALUES
(1, 'Peserta'),
(2, 'Ahli Jawatankuasa'),
(3, 'Penceramah'),
(4, 'Fasilitator');

CREATE TABLE `myhadir_konfigurasiumum` (
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

INSERT INTO `myhadir_konfigurasiumum` (`id`, `urusetiagroupid`, `urusetiacpgroupid`, `admingroupid`, `namaagensi`, `namasingkatan`, `alamat1`, `alamat2`, `negeri`, `notelefon`, `lamanweb`, `emailrasmi`, `apppassword`) VALUES
(1, 17, 32, 33, 'Hospital Beaufort', 'HBFT', 'Peti Surat 40', '89807 Beaufort', 'Sabah', '087-212333', 'https://jknsabah.moh.gov.my/hbeaufort/', 'hbeaufort@moh.gov.my', 'etndicexvhuroipw');


CREATE TABLE `myhadir_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idprogram` int(11) unsigned NOT NULL,
  `tindakan` varchar(128) NOT NULL,
  `tarikh` datetime NOT NULL,
  `uid` int(255) NOT NULL
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `myhadir_lokasi` (
  `idlokasi` int(10) NOT NULL AUTO_INCREMENT,
  `lokasi` varchar(256) NOT NULL,
  `susunan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `myhadir_lokasi` (`idlokasi`, `lokasi`, `susunan`) VALUES
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


CREATE TABLE `myhadir_nama` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idprogram` int(10) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `mykad` varchar(256) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idkategoripenerima` int(11) NOT NULL,
  `kehadiran` int(11) NOT NULL,
    PRIMARY KEY (`id`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_penganjur` (
  `idpenganjur` int(10) NOT NULL AUTO_INCREMENT,
  `penganjur` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `myhadir_penganjur` (`idpenganjur`, `penganjur`) VALUES
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

CREATE TABLE `myhadir_program` (
  `idprogram` int(100) NOT NULL AUTO_INCREMENT,
  `namaprogram` varchar(500) NOT NULL,
  `tarikhmula` date NOT NULL,
  `tarikhtamat` date DEFAULT NULL,
  `idlokasi` varchar(254) NOT NULL,
  `idpenganjur` varchar(254) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `myhadir_aksesadmin` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;