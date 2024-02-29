#
# TABLE STRUCTURE FOR: absen
#

DROP TABLE IF EXISTS `absen`;

CREATE TABLE `absen` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `real_masuk` datetime DEFAULT NULL,
  `masuk` datetime DEFAULT NULL,
  `real_pulang` datetime DEFAULT NULL,
  `pulang` datetime DEFAULT NULL,
  `jam_masuk_lembur` datetime DEFAULT NULL,
  `real_masuk_lembur` datetime DEFAULT NULL,
  `jam_pulang_lembur` datetime DEFAULT NULL,
  `real_pulang_lembur` datetime DEFAULT NULL,
  `id_session` varchar(100) DEFAULT NULL,
  `lembur` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (1, 2, '2023-09-01', '2023-09-07 12:14:24', '2023-09-01 12:00:00', '2023-09-07 21:34:36', '2023-09-07 21:00:00', NULL, NULL, NULL, NULL, 'wgr6FhpiAl', 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (4, 2, '2023-09-02', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 16:50:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (5, 2, '2023-09-03', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (6, 2, '2023-09-04', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (7, 2, '2023-09-05', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (8, 2, '2023-09-06', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (9, 2, '2023-09-07', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (10, 2, '2023-09-08', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (11, 2, '2023-09-09', NULL, '2023-09-07 08:00:00', NULL, '2023-09-07 17:00:00', NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (12, 7, '2023-09-08', '2023-09-08 07:25:39', '2023-09-08 07:25:39', NULL, NULL, NULL, NULL, NULL, NULL, 'I2DKhl5GHv', 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (13, 4, '2023-09-08', '2023-09-08 07:29:54', '2023-09-08 07:29:54', NULL, NULL, NULL, NULL, NULL, NULL, 'y5p4bWU2Oa', 0);
INSERT INTO `absen` (`ID`, `id_user`, `tgl`, `real_masuk`, `masuk`, `real_pulang`, `pulang`, `jam_masuk_lembur`, `real_masuk_lembur`, `jam_pulang_lembur`, `real_pulang_lembur`, `id_session`, `lembur`) VALUES (14, 2, '2024-02-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);


#
# TABLE STRUCTURE FOR: akun
#

DROP TABLE IF EXISTS `akun`;

CREATE TABLE `akun` (
  `no_reff` int NOT NULL,
  `id_user` int NOT NULL,
  `nama_reff` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `keterangan` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `laba_rugi` int NOT NULL DEFAULT '0',
  `aktiva` int NOT NULL DEFAULT '0',
  `pasiva` int NOT NULL DEFAULT '0',
  `kewajiban` int NOT NULL DEFAULT '0',
  `beban` int NOT NULL DEFAULT '0',
  `urutan` int NOT NULL DEFAULT '0',
  `kunci` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_reff`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (102, 1, 'Persediaan', 'Persediaan Barang', 2, 2, 0, 0, 0, 4, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (110, 1, 'Bank', 'Kas di Bank', 0, 1, 0, 0, 0, 2, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (111, 1, 'Kas', 'Kas', 0, 1, 0, 0, 0, 1, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (112, 1, 'Piutang', 'Piutang Usaha', 0, 1, 0, 0, 0, 3, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (113, 1, 'Perlengkapan', 'Perlengkapan Perusahaan', 0, 1, 0, 0, 0, 5, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (121, 1, 'Peralatan', 'Peralatan Perusahaan', 0, 0, 1, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (122, 1, 'Akumulasi Peralatan', 'Akumulasi Penyusutan Peralatan', 0, 0, 1, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (211, 1, 'Utang Usaha', 'Utang Usaha', 0, 0, 0, 1, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (212, 1, 'Utang Gaji', 'Utang Gaji', 0, 0, 0, 1, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (213, 1, 'Utang pajak', 'Utang pajak', 0, 2, 0, 1, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (311, 1, 'Modal', 'Modal', 0, 4, 0, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (312, 1, 'Prive', 'Prive', 2, 2, 2, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (400, 1, 'Pendapatan', 'Pendapatan', 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (401, 1, 'Retur Penjualan', 'Retur Penjualan', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (402, 1, 'Diskon Penjualan', 'Diskon Penjualan', 2, 1, 0, 0, 0, 4, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (403, 1, 'Deposit Penjualan', 'Deposit Penjualan', 2, 2, 0, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (411, 1, 'Pendapatan jasa/usaha\r\n			', 'Pendapatan jasa/usaha\r\n			', 0, 3, 0, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (412, 1, 'Pendapatan lain-lain', 'Pendapatan lain-lain', 0, 3, 0, 0, 0, 0, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (511, 1, 'Beban Gaji', 'Beban Gaji', 0, 0, 0, 0, 1, 6, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (512, 1, 'Beban Sewa', 'Beban Sewa', 0, 0, 0, 0, 1, 7, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (513, 1, 'Beban Penyusutan Peralatan', 'Beban Penyusutan Peralatan', 0, 0, 0, 0, 1, 8, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (514, 1, 'Beban Lat', 'Beban air, listrik, dan telepon', 0, 0, 0, 0, 1, 9, 0);
INSERT INTO `akun` (`no_reff`, `id_user`, `nama_reff`, `keterangan`, `laba_rugi`, `aktiva`, `pasiva`, `kewajiban`, `beban`, `urutan`, `kunci`) VALUES (515, 1, 'Beban Perlengkapan', 'Beban Perlengkapan', 0, 0, 0, 0, 1, 10, 0);


#
# TABLE STRUCTURE FOR: bahan
#

DROP TABLE IF EXISTS `bahan`;

CREATE TABLE `bahan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis` int NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `harga_modal` int NOT NULL DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  `harga` int NOT NULL DEFAULT '0',
  `id_satuan` int NOT NULL DEFAULT '0',
  `status_stok` enum('Y','N') NOT NULL DEFAULT 'N',
  `kunci` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `pub` int NOT NULL DEFAULT '0',
  `type_harga` int NOT NULL DEFAULT '1',
  `featured` int NOT NULL DEFAULT '0',
  `barcode` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (1, 1, 'NONE', 0, 0, 0, 0, 'N', 1, 0, 1, 1, 0, NULL);
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (2, 3, 'FLEXI CHINA 280GSM', 754000, 0, 0, 5, 'Y', 0, 0, 1, 2, 0, '601898933417');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (3, 3, 'FLEXI KOREA 440GSM', 507500, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '756208177404');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (4, 3, 'X BANNER', 60000, 0, 0, 1, 'Y', 1, 0, 1, 2, 0, '465218197542');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (5, 3, 'ROLL UP BANNER', 180000, 0, 0, 1, 'Y', 1, 0, 1, 2, 0, '201190171297');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (6, 4, 'ART CARTON 260GSM', 151000, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '769846635917');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (7, 4, 'ART PAPER 150GSM', 150500, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '873186203203');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (8, 4, 'BW', 3000, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '985439833125');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (9, 4, 'CHROMO', 3000, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '381401611637');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (10, 4, 'VINYL PUTIH', 6000, 0, 0, 4, 'Y', 0, 1, 1, 2, 0, '707828402477');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (11, 4, 'VINYL TRANSPARAN', 6000, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '790952193532');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (12, 4, 'HVS 70GSM', 60750, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '910580146634');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (13, 4, 'KERTAS TIK', 2500, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '899568305034');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (14, 4, 'LINEN', 3000, 0, 0, 4, 'Y', 0, 0, 1, 2, 0, '241388680980');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (15, 9, 'DESAIN', 30000, 0, 0, 1, 'N', 1, 0, 1, 1, 0, '662227720599');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (16, 2, 'FLEXY CHINA 340GSM', 40000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '702060234076');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (17, 2, 'ALBATROS', 40000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '208803349187');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (18, 2, 'GLOSSY PHOTO PAPER', 45000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '901730225965');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (19, 2, 'LUSTER', 45000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '325879520955');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (21, 2, 'STICKER ONE WAY', 60000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '586176474309');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (22, 2, 'STICKER ALBATROS', 70000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '631444457459');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (23, 2, 'STICKER SANDBLAST', 70000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '516279420409');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (24, 2, 'STICKER HOLOGRAM', 100000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '454513051125');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (25, 2, 'STICKER VINYL PUTIH QUANTAC', 35000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '676301784547');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (26, 2, 'STICKER VINYL PUTIH ORAJET', 40000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '134574190078');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (27, 2, 'STICKER VINYL PUTIH RITRAMA', 40000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '600294652961');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (28, 2, 'STICKER VINYL TRANSPARANT QUANTAC', 30000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '220457754499');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (29, 2, 'STICKER VINYL TRANSPARANT ORAJET', 40000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '864098633834');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (30, 2, 'STICKER VINYL TRANSPARANT RITRAMA', 40000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '512251400998');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (31, 10, 'AC260 1 SISI', 10000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, '760279099191');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (32, 10, 'AC260 2 SISI', 25000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, '534089094227');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (20, 2, 'DURATTRANS MATTE', 60000, 0, 0, 5, 'Y', 0, 1, 1, 2, 0, '649246922191');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (34, 10, 'AC260 1 SISI  LAMINASI', 25000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, '908650909918');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (35, 10, 'AC260 2 SISI  LAMINASI:', 35000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, '273260599579');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (36, 10, 'BW 1 SISI', 15000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, '167726302561');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (37, 10, 'BW 2 SISI', 30000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (38, 10, 'KANVAS 1 SISI', 25000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (39, 10, 'KANVAS 2 SISI', 40000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (40, 10, 'CONCORD 1 SISI', 20000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (41, 10, 'CONCORD 2 SISI', 35000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (42, 10, 'LINEN 1 SISI', 20000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (43, 10, 'LINEN 2 SISI', 30000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (44, 10, 'PYRAMID 1 SISI', 30000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (45, 10, 'PYRAMID 2 SISI', 45000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (46, 10, 'NEWTOP 1 SISI', 35000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');
INSERT INTO `bahan` (`id`, `id_jenis`, `title`, `harga_modal`, `harga_jual`, `harga`, `id_satuan`, `status_stok`, `kunci`, `status`, `pub`, `type_harga`, `featured`, `barcode`) VALUES (47, 10, 'NEWTOP 2 SISI', 60000, 0, 0, 2, 'Y', 1, 0, 1, 2, 0, 'NULL');


#
# TABLE STRUCTURE FOR: bayar_gaji
#

DROP TABLE IF EXISTS `bayar_gaji`;

CREATE TABLE `bayar_gaji` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_slip` int DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int DEFAULT NULL,
  `id_byr` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `jurnal` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=39 ROW_FORMAT=FIXED;

#
# TABLE STRUCTURE FOR: bayar_invoice_detail
#

DROP TABLE IF EXISTS `bayar_invoice_detail`;

CREATE TABLE `bayar_invoice_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_invoice` int DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jam_bayar` time DEFAULT NULL,
  `jml_bayar` int DEFAULT NULL,
  `jdiskon` int NOT NULL DEFAULT '0',
  `kunci` int NOT NULL DEFAULT '0',
  `id_bayar` int DEFAULT NULL,
  `id_sub_bayar` int NOT NULL DEFAULT '0',
  `lampiran` varchar(255) DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `rekap` enum('Y','N') NOT NULL DEFAULT 'N',
  `setor` enum('Y','N') NOT NULL DEFAULT 'N',
  `tgl_setor` datetime DEFAULT NULL,
  `hapus` int NOT NULL DEFAULT '0',
  `urutan` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bayar_pembelian
#

DROP TABLE IF EXISTS `bayar_pembelian`;

CREATE TABLE `bayar_pembelian` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pembelian` int DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int DEFAULT NULL,
  `id_bayar` int DEFAULT NULL,
  `id_sub_bayar` int NOT NULL DEFAULT '0',
  `id_user` int DEFAULT NULL,
  `setor` enum('Y','N') NOT NULL DEFAULT 'N',
  `tgl_setor` datetime DEFAULT NULL,
  `jurnal` enum('Y','N') DEFAULT 'N',
  `lampiran` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bayar_pengeluaran
#

DROP TABLE IF EXISTS `bayar_pengeluaran`;

CREATE TABLE `bayar_pengeluaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengeluaran` int DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int DEFAULT NULL,
  `id_bayar` int DEFAULT NULL,
  `id_sub_bayar` int NOT NULL DEFAULT '0',
  `id_user` int DEFAULT NULL,
  `setor` enum('Y','N') NOT NULL DEFAULT 'N',
  `tgl_setor` datetime DEFAULT NULL,
  `jurnal` enum('Y','N') DEFAULT 'N',
  `lampiran` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bayar_piutang
#

DROP TABLE IF EXISTS `bayar_piutang`;

CREATE TABLE `bayar_piutang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengeluaran` int DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jml_bayar` int DEFAULT NULL,
  `id_bayar` int DEFAULT NULL,
  `id_sub_bayar` int NOT NULL DEFAULT '0',
  `id_user` int DEFAULT NULL,
  `setor` enum('Y','N') NOT NULL DEFAULT 'N',
  `tgl_setor` datetime DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `jurnal` enum('Y','N') DEFAULT 'N',
  `lampiran` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bonus
#

DROP TABLE IF EXISTS `bonus`;

CREATE TABLE `bonus` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `bonus` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=37 ROW_FORMAT=FIXED;

#
# TABLE STRUCTURE FOR: cc_project
#

DROP TABLE IF EXISTS `cc_project`;

CREATE TABLE `cc_project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_project` date NOT NULL,
  `update_date` datetime NOT NULL,
  `stat` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: cc_terjual
#

DROP TABLE IF EXISTS `cc_terjual`;

CREATE TABLE `cc_terjual` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL DEFAULT '0',
  `id_barang` int NOT NULL,
  `jumlah` int DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `ket` varchar(300) NOT NULL,
  `stat` int DEFAULT NULL,
  `rekap` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: ci_sessions
#

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: deposit
#

DROP TABLE IF EXISTS `deposit`;

CREATE TABLE `deposit` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT '0',
  `id_konsumen` int DEFAULT NULL,
  `id_invoice` int DEFAULT '0',
  `masuk` int DEFAULT '0',
  `keluar` int DEFAULT '0',
  `create_date` date DEFAULT NULL,
  `status` int DEFAULT '0',
  `catatan` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: device
#

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(20) NOT NULL,
  `device` varchar(20) NOT NULL,
  `device_status` varchar(20) NOT NULL,
  `expired` varchar(50) NOT NULL,
  `messages` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `package` varchar(20) NOT NULL,
  `quota` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: gaji
#

DROP TABLE IF EXISTS `gaji`;

CREATE TABLE `gaji` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `gaji_pokok` int DEFAULT NULL,
  `tun_jab` int DEFAULT NULL,
  `transport` int DEFAULT NULL,
  `makan` int DEFAULT NULL,
  `asuransi` int DEFAULT NULL,
  `jam_kerja` float DEFAULT NULL,
  `istirahat` float DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=37 ROW_FORMAT=FIXED;

INSERT INTO `gaji` (`ID`, `id_user`, `gaji_pokok`, `tun_jab`, `transport`, `makan`, `asuransi`, `jam_kerja`, `istirahat`) VALUES (2, 2, 0, 0, 0, 0, 0, '0', '0');


#
# TABLE STRUCTURE FOR: hak_akses
#

DROP TABLE IF EXISTS `hak_akses`;

CREATE TABLE `hak_akses` (
  `id_level` int NOT NULL AUTO_INCREMENT,
  `id_parent` int NOT NULL,
  `nama` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `publish` enum('Y','N') NOT NULL DEFAULT 'Y',
  `status` int DEFAULT '0',
  PRIMARY KEY (`id_level`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`, `status`) VALUES (1, 0, 'Administrator', 'admin', 'Y', 0);
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`, `status`) VALUES (2, 0, 'Owner', 'owner', 'Y', 0);
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`, `status`) VALUES (3, 0, 'Kasir', 'kasir', 'Y', 0);
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`, `status`) VALUES (4, 0, 'Keuangan', 'keu', 'Y', 0);
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`, `status`) VALUES (5, 0, 'Desain', 'desain', 'Y', 1);
INSERT INTO `hak_akses` (`id_level`, `id_parent`, `nama`, `level`, `publish`, `status`) VALUES (6, 0, 'Operator', 'operator', 'Y', 0);


#
# TABLE STRUCTURE FOR: harga
#

DROP TABLE IF EXISTS `harga`;

CREATE TABLE `harga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: harga_member
#

DROP TABLE IF EXISTS `harga_member`;

CREATE TABLE `harga_member` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_satuan` int NOT NULL DEFAULT '0',
  `id_bahan` int NOT NULL DEFAULT '0',
  `id_member` int NOT NULL DEFAULT '0',
  `harga_pokok` int DEFAULT '0',
  `harga_jual` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: harga_range_member
#

DROP TABLE IF EXISTS `harga_range_member`;

CREATE TABLE `harga_range_member` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_member` int NOT NULL DEFAULT '0',
  `id_bahan` int NOT NULL DEFAULT '0',
  `id_satuan` int NOT NULL DEFAULT '0',
  `jumlah_minimal` int NOT NULL DEFAULT '0',
  `jumlah_maksimal` int NOT NULL DEFAULT '0',
  `harga_pokok` int DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `diskon` int NOT NULL DEFAULT '0',
  `pub` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: harga_satuan
#

DROP TABLE IF EXISTS `harga_satuan`;

CREATE TABLE `harga_satuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_satuan` int NOT NULL DEFAULT '0',
  `id_bahan` int NOT NULL DEFAULT '0',
  `harga_pokok` int DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (1, 5, 2, 0, 18000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (2, 5, 3, 0, 35000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (3, 1, 4, 0, 80000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (4, 1, 5, 0, 250000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (5, 4, 6, 0, 3500);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (6, 4, 7, 0, 3000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (7, 4, 8, 0, 5000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (8, 4, 9, 0, 4500);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (9, 4, 10, 0, 9000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (10, 4, 11, 0, 9000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (11, 4, 12, 0, 3000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (12, 4, 13, 0, 5000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (13, 4, 14, 0, 6000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (14, 1, 15, 0, 30000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (15, 5, 16, 0, 65000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (16, 5, 17, 0, 70000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (17, 5, 18, 0, 75000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (18, 5, 19, 0, 75000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (19, 5, 20, 0, 115000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (20, 5, 21, 0, 90000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (21, 5, 22, 0, 100000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (22, 5, 23, 0, 110000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (23, 5, 24, 0, 160000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (24, 5, 25, 0, 65000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (25, 5, 26, 0, 80000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (26, 5, 27, 0, 80000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (27, 5, 28, 0, 65000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (28, 5, 29, 0, 80000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (29, 5, 30, 0, 80000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (30, 2, 31, 0, 25000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (31, 2, 32, 0, 50000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (32, 2, 34, 0, 50000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (33, 2, 35, 0, 70000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (34, 2, 36, 0, 30000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (35, 2, 37, 0, 60000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (36, 2, 38, 0, 50000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (37, 2, 39, 0, 80000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (38, 2, 40, 0, 40000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (39, 2, 41, 0, 60000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (40, 2, 43, 0, 60000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (41, 2, 44, 0, 55000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (42, 2, 45, 0, 90000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (43, 2, 46, 0, 70000);
INSERT INTO `harga_satuan` (`id`, `id_satuan`, `id_bahan`, `harga_pokok`, `harga_jual`) VALUES (44, 2, 47, 0, 120000);


#
# TABLE STRUCTURE FOR: hari_libur
#

DROP TABLE IF EXISTS `hari_libur`;

CREATE TABLE `hari_libur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=37 ROW_FORMAT=FIXED;

#
# TABLE STRUCTURE FOR: history_stok
#

DROP TABLE IF EXISTS `history_stok`;

CREATE TABLE `history_stok` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_laporan` int NOT NULL,
  `tb` varchar(20) NOT NULL,
  `id_bahan` int NOT NULL,
  `create_date` date DEFAULT NULL,
  `jumlah` int NOT NULL,
  `ket` varchar(200) NOT NULL,
  `stat` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: info
#

DROP TABLE IF EXISTS `info`;

CREATE TABLE `info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `perusahaan` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `keywords` text,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `fb` varchar(50) DEFAULT NULL,
  `tw` varchar(50) DEFAULT NULL,
  `ig` varchar(50) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `logo_bw` varchar(255) DEFAULT NULL,
  `favicon` varchar(100) DEFAULT NULL,
  `stamp_l` varchar(100) DEFAULT NULL,
  `stamp_b` varchar(100) DEFAULT NULL,
  `warna_lunas` varchar(10) DEFAULT NULL,
  `warna_blunas` varchar(10) DEFAULT NULL,
  `tema` varchar(10) DEFAULT NULL,
  `ket` text,
  `footer_invoice` text,
  `demo` enum('Y','N') NOT NULL DEFAULT 'N',
  `api_key` varchar(255) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `dev_tools` int DEFAULT '0',
  `user_name` varchar(20) DEFAULT NULL,
  `user_pass` varchar(20) DEFAULT NULL,
  `versi_pro` varchar(20) DEFAULT NULL,
  `versi_custom` varchar(20) DEFAULT NULL,
  `kode_qris` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `info` (`id`, `title`, `perusahaan`, `deskripsi`, `keywords`, `email`, `phone`, `fb`, `tw`, `ig`, `logo`, `logo_bw`, `favicon`, `stamp_l`, `stamp_b`, `warna_lunas`, `warna_blunas`, `tema`, `ket`, `footer_invoice`, `demo`, `api_key`, `version`, `dev_tools`, `user_name`, `user_pass`, `versi_pro`, `versi_custom`, `kode_qris`) VALUES (1, 'Apps', 'UQIMEDIA PRINTING', 'PHA+SmwuIFJheWEgQ2VtcGxhbmcgTm8uS00uMTksIER1a3VoLCBLZWMuIENpYnVuZ2J1bGFuZywgS2FidXBhdGVuIEJvZ29yLCBKYXdhIEJhcmF0IDE2NjMwPGJyPjwvcD4=', 'Bogor', 'uqimedia@gmail.com', '081266612015', '-', 'R2Bjv**********2oR@t', '-', 'logo-700-164.png', 'logo-700-1641.png', 'logo.png', 'STAM_LUNAS.png', 'belum_lunas.png', '#1ABC9C', '#000000', '#16A085', 'PHAgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsiPlNFTEFNQVQgREFUQU5HPC9wPg==', 'PHA+VGVyaW1ha2FzaWggYXRhcyBrZXBlcmNheWFhbiBhbmRhLjwvcD48cD5QZXJpa3NhIGtlbWJhbGkgTm90YSBzZWJlbHVtIGtlbHVhci48L3A+', 'N', '12345z', '1.5.0', 1, 'xposappx', '', NULL, NULL, '');


#
# TABLE STRUCTURE FOR: invoice
#

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id_invoice` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` varchar(11) DEFAULT NULL,
  `total_bayar` int NOT NULL DEFAULT '0',
  `jumlah_bayar` int NOT NULL DEFAULT '0',
  `kembalian` int NOT NULL DEFAULT '0',
  `potongan_harga` int NOT NULL DEFAULT '0',
  `cashback` int DEFAULT '0',
  `pajak` float NOT NULL DEFAULT '0',
  `pos` enum('Y','N') NOT NULL DEFAULT 'N',
  `lunas` int NOT NULL DEFAULT '0',
  `tgl_trx` date DEFAULT NULL,
  `jam_order` time NOT NULL,
  `tgl_ambil` datetime DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `id_marketing` int DEFAULT NULL,
  `id_desain` int NOT NULL DEFAULT '0',
  `tgl_update` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('baru','simpan','edit','pending','batal') NOT NULL DEFAULT 'baru',
  `oto` int NOT NULL DEFAULT '0',
  `history` text,
  `data_json` text,
  `id_konsumen` int DEFAULT NULL,
  `cetak` int NOT NULL DEFAULT '0',
  `sesi_cart` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_invoice`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `invoice` (`id_invoice`, `id_transaksi`, `total_bayar`, `jumlah_bayar`, `kembalian`, `potongan_harga`, `cashback`, `pajak`, `pos`, `lunas`, `tgl_trx`, `jam_order`, `tgl_ambil`, `id_user`, `id_marketing`, `id_desain`, `tgl_update`, `status`, `oto`, `history`, `data_json`, `id_konsumen`, `cetak`, `sesi_cart`) VALUES (1, 'TRX-00001', 120000, 0, 0, 0, 0, '0', 'N', 0, '2024-02-29', '03:53:31', '2024-02-29 03:53:31', 1, 1, 0, '2024-02-29 10:53:31', 'baru', 0, NULL, NULL, 1, 0, 'e08f4c4b8374815597bcc5eec3400a6390e8439b');


#
# TABLE STRUCTURE FOR: invoice_detail
#

DROP TABLE IF EXISTS `invoice_detail`;

CREATE TABLE `invoice_detail` (
  `id_rincianinvoice` int NOT NULL AUTO_INCREMENT,
  `no_spk` varchar(50) DEFAULT NULL,
  `id_invoice` int DEFAULT NULL,
  `id_produk` int NOT NULL DEFAULT '0',
  `jenis_cetakan` int DEFAULT '0',
  `status_hitung` int NOT NULL DEFAULT '0',
  `type_harga` int NOT NULL DEFAULT '0',
  `id_mesin` int NOT NULL DEFAULT '1',
  `keterangan` text,
  `detail` text,
  `jumlah` int DEFAULT '0',
  `harga` int DEFAULT '0',
  `diskon` int NOT NULL DEFAULT '0',
  `satuan` varchar(10) DEFAULT NULL,
  `id_satuan` int NOT NULL DEFAULT '0',
  `ukuran` varchar(20) DEFAULT NULL,
  `tot_ukuran` float DEFAULT '0',
  `hpp` int NOT NULL DEFAULT '0',
  `uk_real` varchar(20) DEFAULT '0',
  `id_bahan` int DEFAULT '0',
  `catatan` text,
  `ambil` enum('Y','N') DEFAULT 'N',
  `rak` enum('Y','N') NOT NULL DEFAULT 'N',
  `id_operator` int DEFAULT '0',
  `id_pengirim` int DEFAULT '0',
  `id_gudang` int DEFAULT '0',
  `jumlah_kirim` int DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `kunci` int NOT NULL DEFAULT '0',
  `token` varchar(6) DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rincianinvoice`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: izin
#

DROP TABLE IF EXISTS `izin`;

CREATE TABLE `izin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=37 ROW_FORMAT=FIXED;

#
# TABLE STRUCTURE FOR: jenis_akun
#

DROP TABLE IF EXISTS `jenis_akun`;

CREATE TABLE `jenis_akun` (
  `id_jenis_akun` int NOT NULL,
  `nama_jenis_akun` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_jenis_akun`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: jenis_bayar
#

DROP TABLE IF EXISTS `jenis_bayar`;

CREATE TABLE `jenis_bayar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_akun` int NOT NULL DEFAULT '0',
  `nama_bayar` varchar(50) NOT NULL,
  `publish` enum('Y','N') NOT NULL DEFAULT 'Y',
  `kunci` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `jenis_bayar` (`id`, `id_akun`, `nama_bayar`, `publish`, `kunci`) VALUES (1, 111, 'Tunai', 'Y', 0);
INSERT INTO `jenis_bayar` (`id`, `id_akun`, `nama_bayar`, `publish`, `kunci`) VALUES (2, 110, 'Transfer', 'Y', 0);
INSERT INTO `jenis_bayar` (`id`, `id_akun`, `nama_bayar`, `publish`, `kunci`) VALUES (3, 211, 'Tempo', 'Y', 1);


#
# TABLE STRUCTURE FOR: jenis_cetakan
#

DROP TABLE IF EXISTS `jenis_cetakan`;

CREATE TABLE `jenis_cetakan` (
  `id_jenis` int NOT NULL AUTO_INCREMENT,
  `jenis_cetakan` varchar(20) DEFAULT NULL,
  `kunci` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `id_akun` int NOT NULL DEFAULT '0',
  `pub` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_jenis`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (1, '-', 1, 0, 0, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (2, 'Indoor', 0, 1, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (3, 'Outdoor', 0, 1, 400, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (4, 'Digital', 0, 0, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (5, 'Offset', 0, 0, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (6, 'Konveksi', 0, 0, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (7, 'Sablon', 0, 0, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (8, 'Merchandise', 0, 0, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (9, 'Desain', 0, 0, 411, 'Y');
INSERT INTO `jenis_cetakan` (`id_jenis`, `jenis_cetakan`, `kunci`, `status`, `id_akun`, `pub`) VALUES (10, 'Kartu Nama', 0, 0, 400, 'Y');


#
# TABLE STRUCTURE FOR: jenis_kas
#

DROP TABLE IF EXISTS `jenis_kas`;

CREATE TABLE `jenis_kas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `id_akun` int DEFAULT NULL,
  `kunci` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `aktiva` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `jenis_kas` (`id`, `title`, `id_akun`, `kunci`, `status`, `aktiva`) VALUES (1, 'Kas Kecil', 111, 0, 0, 'N');
INSERT INTO `jenis_kas` (`id`, `title`, `id_akun`, `kunci`, `status`, `aktiva`) VALUES (2, 'Kas Penjualan', 411, 0, 0, 'N');
INSERT INTO `jenis_kas` (`id`, `title`, `id_akun`, `kunci`, `status`, `aktiva`) VALUES (3, 'Kas Bank Umum', 110, 0, 0, 'N');
INSERT INTO `jenis_kas` (`id`, `title`, `id_akun`, `kunci`, `status`, `aktiva`) VALUES (4, 'Hutang Usaha', 211, 1, 0, 'N');
INSERT INTO `jenis_kas` (`id`, `title`, `id_akun`, `kunci`, `status`, `aktiva`) VALUES (5, 'Piutang Usaha', 112, 1, 0, 'N');
INSERT INTO `jenis_kas` (`id`, `title`, `id_akun`, `kunci`, `status`, `aktiva`) VALUES (6, 'Withdraw', 403, 1, 1, 'N');


#
# TABLE STRUCTURE FOR: jenis_lembaga
#

DROP TABLE IF EXISTS `jenis_lembaga`;

CREATE TABLE `jenis_lembaga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `pub` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (1, 'Perorangan', 0);
INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (2, 'Perusahaan Swasta', 0);
INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (3, 'Perusahaan BUMN', 0);
INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (4, 'Lembaga Pendidikan', 0);
INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (5, 'Hotel', 0);
INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (6, 'Instansi Pemerintahan', 0);
INSERT INTO `jenis_lembaga` (`id`, `title`, `pub`) VALUES (7, 'Lainya', 0);


#
# TABLE STRUCTURE FOR: jenis_pengeluaran
#

DROP TABLE IF EXISTS `jenis_pengeluaran`;

CREATE TABLE `jenis_pengeluaran` (
  `id_jenis` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `kunci` int NOT NULL DEFAULT '0',
  `id_akun` int NOT NULL DEFAULT '0',
  `pub` enum('Y','N') NOT NULL DEFAULT 'Y',
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jenis`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (1, '-', 1, 0, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (2, 'Bahan', 0, 102, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (3, 'Cetak Dtf', 0, 113, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (4, 'Polyflex', 0, 113, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (5, 'Internet', 0, 515, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (8, 'Kaos Polos', 0, 102, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (9, 'Ekspedisi', 0, 514, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (10, 'Bagian Owner', 0, 312, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (11, 'Sewa Ruko', 0, 512, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (12, 'Pln', 0, 514, 'Y', 0);
INSERT INTO `jenis_pengeluaran` (`id_jenis`, `title`, `kunci`, `id_akun`, `pub`, `status`) VALUES (13, 'Umum', 0, 513, 'Y', 0);


#
# TABLE STRUCTURE FOR: jurnal_transaksi
#

DROP TABLE IF EXISTS `jurnal_transaksi`;

CREATE TABLE `jurnal_transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `no_reff` int NOT NULL,
  `reff` varchar(50) DEFAULT NULL,
  `tgl_input` datetime NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `jenis_saldo` enum('debit','kredit') NOT NULL,
  `saldo` int NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `jurnal_transaksi` (`id_transaksi`, `id_user`, `no_reff`, `reff`, `tgl_input`, `tgl_transaksi`, `jenis_saldo`, `saldo`, `keterangan`) VALUES (1, 1, 111, NULL, '2024-02-29 03:42:01', '2024-02-29', 'debit', 50000000, 'MODAL AWAL');
INSERT INTO `jurnal_transaksi` (`id_transaksi`, `id_user`, `no_reff`, `reff`, `tgl_input`, `tgl_transaksi`, `jenis_saldo`, `saldo`, `keterangan`) VALUES (2, 1, 311, NULL, '2024-02-29 03:42:01', '2024-02-29', 'kredit', 50000000, 'MODAL AWAL');


#
# TABLE STRUCTURE FOR: kas_masuk
#

DROP TABLE IF EXISTS `kas_masuk`;

CREATE TABLE `kas_masuk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_generate` varchar(20) DEFAULT NULL,
  `id_jenis` int DEFAULT NULL,
  `id_parent` int NOT NULL DEFAULT '0',
  `id_user` int NOT NULL DEFAULT '0',
  `id_bayar` int NOT NULL DEFAULT '0',
  `id_sub_bayar` int NOT NULL DEFAULT '0',
  `no_reff` varchar(50) DEFAULT NULL,
  `catatan` varchar(200) DEFAULT NULL,
  `pemasukan` int NOT NULL DEFAULT '0',
  `pengeluaran` int NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `kas_masuk` (`id`, `id_generate`, `id_jenis`, `id_parent`, `id_user`, `id_bayar`, `id_sub_bayar`, `no_reff`, `catatan`, `pemasukan`, `pengeluaran`, `create_date`) VALUES (1, 'REF-00001', NULL, 0, 1, 1, 0, '111', 'MODAL AWAL', 50000000, 0, '2024-02-29 10:42:01');


#
# TABLE STRUCTURE FOR: kasbon
#

DROP TABLE IF EXISTS `kasbon`;

CREATE TABLE `kasbon` (
  `id_kasbon` int NOT NULL AUTO_INCREMENT,
  `tgl_kasbon` date DEFAULT NULL,
  `jenis_kasbon` varchar(20) DEFAULT NULL,
  `id_pegawai` int DEFAULT NULL,
  `pinjam` int NOT NULL DEFAULT '0',
  `bayar` int NOT NULL DEFAULT '0',
  `catatan` varchar(50) DEFAULT NULL,
  `status_bayar` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_kasbon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: konsumen
#

DROP TABLE IF EXISTS `konsumen`;

CREATE TABLE `konsumen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_member` varchar(20) DEFAULT NULL,
  `kode_unik` varchar(20) DEFAULT NULL,
  `panggilan` varchar(10) DEFAULT NULL,
  `jenis` int NOT NULL DEFAULT '1',
  `jenis_member` int NOT NULL DEFAULT '1',
  `nama` varchar(50) DEFAULT NULL,
  `no_hp` varchar(17) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `last_update` datetime DEFAULT CURRENT_TIMESTAMP,
  `referal` varchar(20) DEFAULT NULL,
  `alamat` text,
  `perusahaan` varchar(50) DEFAULT NULL,
  `alamat_lembaga` varchar(255) NOT NULL,
  `no_telp` varchar(17) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tampil` int NOT NULL DEFAULT '0',
  `kunci` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `hapus` int NOT NULL DEFAULT '0',
  `history` text,
  `max_utang` int DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `konsumen` (`id`, `id_member`, `kode_unik`, `panggilan`, `jenis`, `jenis_member`, `nama`, `no_hp`, `tgl_daftar`, `last_update`, `referal`, `alamat`, `perusahaan`, `alamat_lembaga`, `no_telp`, `email`, `tampil`, `kunci`, `status`, `hapus`, `history`, `max_utang`) VALUES (1, 'P000001', 'Axzerf', NULL, 1, 1, 'Default', '-', '2020-12-07', '2024-02-28 17:01:02', '-', '-', '-', '', '', '', 0, 1, 0, 0, NULL, 0);
INSERT INTO `konsumen` (`id`, `id_member`, `kode_unik`, `panggilan`, `jenis`, `jenis_member`, `nama`, `no_hp`, `tgl_daftar`, `last_update`, `referal`, `alamat`, `perusahaan`, `alamat_lembaga`, `no_telp`, `email`, `tampil`, `kunci`, `status`, `hapus`, `history`, `max_utang`) VALUES (6, 'P000003', 'SBQD0NR', 'Bpk', 1, 0, 'Wildan', '081212656699', '2024-02-28', '2024-02-28 17:01:02', 'build', 'Bogor', '', '', '', '', 0, 0, 0, 0, NULL, 0);


#
# TABLE STRUCTURE FOR: laporan_penerimaan
#

DROP TABLE IF EXISTS `laporan_penerimaan`;

CREATE TABLE `laporan_penerimaan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_invoice` text,
  `id_user` int NOT NULL DEFAULT '0',
  `id_penerima` int NOT NULL DEFAULT '0',
  `total` int NOT NULL,
  `tanggal` date NOT NULL,
  `tanggal_verifikasi` date DEFAULT NULL,
  `tanggal_setor` date DEFAULT NULL,
  `tanggal_terima` date DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: laporan_stok
#

DROP TABLE IF EXISTS `laporan_stok`;

CREATE TABLE `laporan_stok` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `stat` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: member
#

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `nominal_belanja` int NOT NULL DEFAULT '0',
  `nominal_upgrade` int NOT NULL DEFAULT '0',
  `potongan_diskon` int NOT NULL DEFAULT '0',
  `potongan_harga` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `member` (`id`, `title`, `nominal_belanja`, `nominal_upgrade`, `potongan_diskon`, `potongan_harga`, `status`) VALUES (1, 'Non Membe', 0, 0, 5, 0, 1);
INSERT INTO `member` (`id`, `title`, `nominal_belanja`, `nominal_upgrade`, `potongan_diskon`, `potongan_harga`, `status`) VALUES (2, 'Member Gold', 0, 0, 10, 0, 1);
INSERT INTO `member` (`id`, `title`, `nominal_belanja`, `nominal_upgrade`, `potongan_diskon`, `potongan_harga`, `status`) VALUES (3, 'Member Silver', 0, 0, 15, 0, 1);
INSERT INTO `member` (`id`, `title`, `nominal_belanja`, `nominal_upgrade`, `potongan_diskon`, `potongan_harga`, `status`) VALUES (4, 'Member Platinum', 0, 0, 5, 0, 1);


#
# TABLE STRUCTURE FOR: menuadmin
#

DROP TABLE IF EXISTS `menuadmin`;

CREATE TABLE `menuadmin` (
  `idmenu` int NOT NULL AUTO_INCREMENT,
  `idparent` int NOT NULL DEFAULT '0',
  `id_level` tinytext,
  `nama_menu` varchar(200) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `target` varchar(10) NOT NULL DEFAULT '_self',
  `link_on` enum('Y','N') NOT NULL DEFAULT 'Y',
  `treeview` varchar(20) NOT NULL DEFAULT 'treeview',
  `classes` varchar(20) DEFAULT NULL,
  `classicon` enum('Y','N') NOT NULL DEFAULT 'Y',
  `icon` varchar(20) DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `level` varchar(100) DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idmenu`)
) ENGINE=MyISAM AUTO_INCREMENT=221 DEFAULT CHARSET=latin1;

INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (154, 196, '1,2', 'Satuan', 'produk/satuan', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 8);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (148, 196, '1,2', 'Kategori', 'produk/jenis', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 7);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (24, 112, '1', 'Menu Admin', 'main/menuadmin', '_self', 'N', '', '', 'N', '', 'Y', 'admin', 48);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (33, 112, '1,2', 'Pengguna', 'user', '_self', 'Y', 'treeview', 'menu5', 'N', '', 'Y', 'admin', 42);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (109, 196, '1,2', 'Produk Sale', 'produk/data', '_self', 'N', '', 'menu5', 'N', 'file-text', 'Y', '', 5);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (112, 0, '1,2', 'Pengaturan', '#pengaturan', '_self', 'Y', 'treeview', 'icon-settings', 'Y', 'fa-cog', 'Y', '', 41);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (217, 207, '1,2,3', 'Laporan Pesan', 'whatsapp/report', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 54);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (199, 0, '1,2', 'Pembukuan', '#', '_self', 'Y', 'treeview', NULL, 'Y', 'fa-address-book', 'Y', NULL, 15);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (139, 112, '1,2', 'Aplikasi', 'main/info', '_self', 'N', '', '', 'Y', '', 'Y', NULL, 45);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (153, 196, '1,2,3', 'Jenis Barang', 'produk/bahan', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 6);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (147, 0, '1,3', 'Data Transaksi', 'penjualan/order', '_self', 'N', '', 'icon-chart', 'Y', 'fa-cart-plus', 'Y', NULL, 1);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (155, 0, '1,2,3,4,5,6', 'Laporan', 'pembukuan', '_self', 'Y', 'treeview', NULL, 'Y', 'fa-book', 'Y', NULL, 25);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (156, 155, '1,2,3,4', 'Rincian Penjualan', 'pembukuan/omset', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 30);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (157, 155, '1,2,3,4', 'Pengeluaran', 'pengeluaran/data', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 36);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (180, 155, '1,2,3,4', 'Omset Penjualan', 'laporan/penjualan', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 28);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (159, 155, '1,2,3,4', 'Rincian Pendapatan', 'pembukuan/uang_masuk', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 29);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (160, 155, '1,2,3,4', 'Piutang Penjualan', 'pembukuan/piutang', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 31);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (162, 0, '1,2,3,4,5,6', 'Grafik', 'grafik', '_self', 'N', '', NULL, 'Y', 'fa-bar-chart', 'Y', NULL, 2);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (185, 112, '1,2', 'Folder', 'main/folder', '_self', 'N', '', NULL, 'Y', 'fa-folder-open', 'Y', NULL, 47);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (165, 0, '1', 'Backup Database', 'backupdata/database', '_self', 'N', '', NULL, 'Y', 'fa-database', 'Y', NULL, 60);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (166, 0, '1,2,3,4', 'Pelanggan', '#', '_self', 'Y', 'treeview', NULL, 'Y', 'fa-user-circle-o', 'Y', NULL, 38);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (167, 0, '1,2,3,4,6', 'Dokumentasi', 'dokumentasi/page', '_blank', 'N', '', NULL, 'Y', 'fa-file-text', 'Y', NULL, 62);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (168, 0, '1', 'Patch', 'updateversi', '_self', 'N', 'a', NULL, 'Y', 'fa-cloud-download', 'Y', NULL, 59);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (170, 112, '1,2,4', 'Jenis Pembayaran', 'pembayaran/jenis', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 43);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (171, 0, '1,2,3,4', 'Keuangan', '#', '_self', 'N', 'treeview', NULL, 'Y', 'fa-credit-card', 'Y', NULL, 21);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (174, 171, '1,2,3,4', 'Kas', 'kas/data', '_self', 'N', '', NULL, 'Y', 'fa-file-pdf-o', 'Y', NULL, 22);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (175, 112, '1,2,3,4', 'Printer', 'main/printer', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 46);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (176, 0, '1', 'History User', 'history', '_self', 'N', '', NULL, 'Y', 'fa-history', 'Y', NULL, 61);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (177, 112, '1,2', 'Rekening Bank', 'pembayaran/rekening', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 44);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (178, 171, '1,2,4', 'Mutasi Kas', 'kas/mutasi', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 23);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (179, 196, '1,2,3,4', 'Supplier', 'supplier/data', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 9);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (181, 199, '1,2,4', 'Jenis Transaksi Akun', 'kas/pengeluaran', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 20);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (182, 199, '1,2,3,4', 'Laba Rugi', 'pembukuan/laba-rugi', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 18);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (183, 0, '1,2', 'Master Data', '#', '_self', 'N', 'header', NULL, 'Y', '', 'Y', NULL, 3);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (184, 0, '1', 'Patch & Backup', '#', '_self', 'N', 'header', NULL, 'Y', '', 'Y', NULL, 58);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (186, 155, '1,2,3,4', 'Log Transaksi', 'aktifitas/transaksi', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 37);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (187, 0, '1,2,3,4,5,6', 'Akun Demo', 'home/account', '_self', 'N', 'a', NULL, 'Y', 'fa-user-circle-o', 'Y', NULL, 50);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (188, 0, '1,2,3,4,5,6', 'Dashboard', 'home', '_self', 'N', '', NULL, 'Y', 'fa-dashboard', 'Y', NULL, 0);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (189, 112, '1', 'Reset & Input Sample', 'rollback/resetdata', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 49);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (190, 155, '1,2,3,4,5', 'Desain', 'laporan/desain', '_self', 'N', '', NULL, 'Y', 'fa-desktop', 'Y', NULL, 33);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (191, 155, '1,2,3,4,5,6', 'PPN', 'laporan/ppn', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 34);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (193, 155, '1,3,5,6', 'List Pekerjaan', 'laporan/operator', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 32);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (194, 196, '1,2', 'Data Stok', 'stok/data', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 11);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (195, 196, '1,2', 'History stok', 'stok/history', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 14);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (198, 199, '1,2', 'Neraca', 'pembukuan/neraca', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 17);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (196, 0, '1,2', 'Manajemen', '#', '_self', 'Y', 'treeview', NULL, 'Y', 'fa-book', 'Y', NULL, 4);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (197, 196, '1,2', 'Stok Keluar', 'stok/keluar', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 13);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (200, 155, '1,2', 'Pembelian', 'pembelian/data', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 35);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (201, 196, '1,2', 'Stok Masuk', 'stok/masuk', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 12);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (202, 199, '1,2', 'Neraca Saldo', 'pembukuan/neraca_saldo', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 19);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (203, 199, '1,2', 'Jurnal Umum', 'jurnal', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 16);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (204, 196, '1,2', 'Harga Range', 'produk/harga_range', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 10);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (205, 166, '1,2,4', 'Jenis Member', 'konsumen/member', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 40);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (206, 166, '1,2,3,4', 'Data pelanggan', 'konsumen', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 39);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (207, 0, '1', 'Whatsapp', '#', '_self', 'N', 'treeview', NULL, 'Y', 'fa-whatsapp', 'Y', NULL, 51);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (208, 207, '1', 'Device', 'whatsapp', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 52);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (209, 207, '1', 'Template Pesan', 'whatsapp/template', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 53);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (213, 155, '1,2,3,4,5,6', 'Surat jalan', 'laporan/suratjalan', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 27);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (214, 155, '1,2,3', 'Transaksi', 'transaksi', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 26);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (215, 207, '1,2', 'Kirim Promo', 'promo/panel', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 55);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (216, 207, '1,2,3', 'Edit Promosi', 'promo/template', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 56);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (218, 207, '1,2,3', 'Laporan Promo', 'promo/report', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 57);
INSERT INTO `menuadmin` (`idmenu`, `idparent`, `id_level`, `nama_menu`, `link`, `target`, `link_on`, `treeview`, `classes`, `classicon`, `icon`, `aktif`, `level`, `urutan`) VALUES (220, 171, '1,2', 'Cashback', 'kas/cashback', '_self', 'N', '', NULL, 'Y', '', 'Y', NULL, 24);


#
# TABLE STRUCTURE FOR: mesin
#

DROP TABLE IF EXISTS `mesin`;

CREATE TABLE `mesin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_mesin` varchar(50) DEFAULT NULL,
  `pemilik` varchar(50) DEFAULT NULL,
  `publish` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: migrations
#

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `migrations` (`version`) VALUES ('1');
INSERT INTO `migrations` (`version`) VALUES ('1');
INSERT INTO `migrations` (`version`) VALUES ('1');


#
# TABLE STRUCTURE FOR: nama_barang
#

DROP TABLE IF EXISTS `nama_barang`;

CREATE TABLE `nama_barang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_satuan` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `stat` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: pembelian
#

DROP TABLE IF EXISTS `pembelian`;

CREATE TABLE `pembelian` (
  `id_pembelian` int NOT NULL AUTO_INCREMENT,
  `id_bayar` int NOT NULL DEFAULT '0',
  `id_kas` int NOT NULL DEFAULT '0',
  `tgl_pembelian` date DEFAULT NULL,
  `tgl_rekap` date DEFAULT NULL,
  `tgl_jatuhtempo` date DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `total_bayar` int DEFAULT NULL,
  `pos` enum('Y','N') NOT NULL DEFAULT 'N',
  `rekap` enum('Y','N') NOT NULL DEFAULT 'N',
  `stok` enum('Y','N') NOT NULL DEFAULT 'N',
  `lunas` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id_pembelian`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: pembelian_detail
#

DROP TABLE IF EXISTS `pembelian_detail`;

CREATE TABLE `pembelian_detail` (
  `no` int NOT NULL AUTO_INCREMENT,
  `id_bahan` int NOT NULL DEFAULT '0',
  `id_pembelian` int DEFAULT NULL,
  `id_biaya` int DEFAULT '0',
  `id_supplier` int DEFAULT '1',
  `no_invo` varchar(25) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `jumlah` float DEFAULT '0',
  `harga` int DEFAULT '0',
  `satuan` varchar(10) DEFAULT NULL,
  `id_pemesan` int DEFAULT '0',
  `no_order` varchar(20) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: pengaturan_kertas
#

DROP TABLE IF EXISTS `pengaturan_kertas`;

CREATE TABLE `pengaturan_kertas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `modul` varchar(50) DEFAULT NULL,
  `ukuran` enum('A3','A4','A5','A6') NOT NULL DEFAULT 'A4',
  `posisi` enum('potrait','landscape') NOT NULL DEFAULT 'potrait',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: pengaturan_presensi
#

DROP TABLE IF EXISTS `pengaturan_presensi`;

CREATE TABLE `pengaturan_presensi` (
  `id` int NOT NULL,
  `jam_masuk_shift_1` time NOT NULL,
  `jam_masuk_shift_2` time NOT NULL,
  `jam_pulang_shift_1` time NOT NULL,
  `jam_pulang_shift_2` time NOT NULL,
  `toleransi_shift_1` time NOT NULL,
  `toleransi_shift_2` time NOT NULL,
  `jumlah_libur` int NOT NULL,
  `hari_kerja` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `pengaturan_presensi` (`id`, `jam_masuk_shift_1`, `jam_masuk_shift_2`, `jam_pulang_shift_1`, `jam_pulang_shift_2`, `toleransi_shift_1`, `toleransi_shift_2`, `jumlah_libur`, `hari_kerja`) VALUES (1, '07:25:00', '12:00:00', '16:00:00', '21:00:00', '08:15:00', '12:15:00', 5, 26);


#
# TABLE STRUCTURE FOR: pengeluaran
#

DROP TABLE IF EXISTS `pengeluaran`;

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int NOT NULL AUTO_INCREMENT,
  `id_bayar` int NOT NULL DEFAULT '0',
  `id_kas` int NOT NULL DEFAULT '0',
  `tgl_pengeluaran` date DEFAULT NULL,
  `tgl_rekap` date DEFAULT NULL,
  `tgl_jatuhtempo` date DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `total_bayar` int DEFAULT NULL,
  `pos` enum('Y','N') NOT NULL DEFAULT 'N',
  `rekap` enum('Y','N') NOT NULL DEFAULT 'N',
  `lunas` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id_pengeluaran`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: pengeluaran_detail
#

DROP TABLE IF EXISTS `pengeluaran_detail`;

CREATE TABLE `pengeluaran_detail` (
  `no` int NOT NULL AUTO_INCREMENT,
  `id_pengeluaran` int DEFAULT NULL,
  `id_biaya` int DEFAULT '0',
  `id_supplier` int DEFAULT '1',
  `no_invo` varchar(25) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `jumlah` float DEFAULT '0',
  `harga` int DEFAULT '0',
  `satuan` varchar(10) DEFAULT NULL,
  `id_pemesan` int DEFAULT '0',
  `no_order` varchar(20) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: printer
#

DROP TABLE IF EXISTS `printer`;

CREATE TABLE `printer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ukuran_kertas` varchar(10) DEFAULT NULL,
  `ukuran_font` decimal(10,0) NOT NULL,
  `posisi` varchar(20) DEFAULT NULL,
  `max_item` int NOT NULL DEFAULT '0',
  `shared_name` varchar(50) DEFAULT NULL,
  `slug` varchar(10) DEFAULT NULL,
  `pub` int NOT NULL DEFAULT '0',
  `show_footer` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `printer` (`id`, `name`, `ukuran_kertas`, `ukuran_font`, `posisi`, `max_item`, `shared_name`, `slug`, `pub`, `show_footer`) VALUES (1, 'Inject/PDF', 'A5', '14', 'landscape', 12, 'AdobePDF', 'in', 0, 0);
INSERT INTO `printer` (`id`, `name`, `ukuran_kertas`, `ukuran_font`, `posisi`, `max_item`, `shared_name`, `slug`, `pub`, `show_footer`) VALUES (2, 'Thermal 85mm', '85', '10', 'potrait', 100, 'POS80 Printer', 'th', 0, 0);
INSERT INTO `printer` (`id`, `name`, `ukuran_kertas`, `ukuran_font`, `posisi`, `max_item`, `shared_name`, `slug`, `pub`, `show_footer`) VALUES (3, 'Thermal 58mm', '58', '0', 'potrait', 100, 'POS80 Printer', 'th58', 0, 0);
INSERT INTO `printer` (`id`, `name`, `ukuran_kertas`, `ukuran_font`, `posisi`, `max_item`, `shared_name`, `slug`, `pub`, `show_footer`) VALUES (4, 'Direct Thermal 58mm', '58', '10', 'potrait', 100, 'EPSON L120 Series', 'direct58', 0, 0);
INSERT INTO `printer` (`id`, `name`, `ukuran_kertas`, `ukuran_font`, `posisi`, `max_item`, `shared_name`, `slug`, `pub`, `show_footer`) VALUES (5, 'Direct Thermal 85mm', '85', '10', 'potrait', 100, 'EPSON L120 Series', 'direct85', 0, 0);
INSERT INTO `printer` (`id`, `name`, `ukuran_kertas`, `ukuran_font`, `posisi`, `max_item`, `shared_name`, `slug`, `pub`, `show_footer`) VALUES (6, 'Dotmatrix', '14', '14', 'potrait', 12, 'EPSON Dotmatrix', 'dotmatrix', 1, 0);


#
# TABLE STRUCTURE FOR: produk
#

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jenis` int DEFAULT '0',
  `id_bahan` varchar(200) DEFAULT '0',
  `barcode` varchar(15) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `harga_beli` int NOT NULL DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  `harga_grosir` int NOT NULL DEFAULT '0',
  `diskon` int NOT NULL DEFAULT '0',
  `ukuran` varchar(10) DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `pub` int NOT NULL DEFAULT '1',
  `kunci` int NOT NULL DEFAULT '0',
  `lock_harga` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (1, 1, '1', NULL, '-', 0, 0, 0, 0, NULL, 1, 1, 1, 'Y');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (2, 3, '0', '364675812945', 'BANNER', 0, 0, 0, 0, '1x1M', 1, 1, 0, 'N');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (3, 3, '0', '355385704483', 'X BANNER', 0, 0, 0, 0, '60x160CM', 1, 1, 0, 'Y');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (4, 4, '0', '665517183376', 'CETAK A3', 0, 0, 0, 0, '29,7x42CM', 1, 1, 0, 'Y');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (5, 2, '0', '863357185534', 'CETAK INDOOR', 0, 0, 0, 0, '1x1M', 1, 1, 0, 'Y');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (6, 4, '0', '648466349660', 'STICKER', 0, 0, 0, 0, '29,7x42CM', 1, 1, 0, 'Y');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (7, 9, '0', '273481908887', 'DESAIN', 0, 0, 0, 0, '-', 1, 1, 0, 'N');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (8, 3, '0', '550316515375', 'ROLL UP BANNER', 0, 0, 0, 0, '60x160CM', 1, 1, 0, 'Y');
INSERT INTO `produk` (`id`, `id_jenis`, `id_bahan`, `barcode`, `title`, `harga_beli`, `harga_jual`, `harga_grosir`, `diskon`, `ukuran`, `jumlah`, `pub`, `kunci`, `lock_harga`) VALUES (9, 10, '0', '767954377277', 'KARTU NAMA', 0, 0, 0, 0, '-', 1, 1, 0, 'Y');


#
# TABLE STRUCTURE FOR: range_harga
#

DROP TABLE IF EXISTS `range_harga`;

CREATE TABLE `range_harga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bahan` int NOT NULL DEFAULT '0',
  `id_satuan` int NOT NULL DEFAULT '0',
  `jumlah_minimal` int NOT NULL DEFAULT '0',
  `jumlah_maksimal` int NOT NULL DEFAULT '0',
  `harga_pokok` int DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `diskon` int NOT NULL DEFAULT '0',
  `pub` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: referal
#

DROP TABLE IF EXISTS `referal`;

CREATE TABLE `referal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  `slug` varchar(20) DEFAULT NULL,
  `pub` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: rekening_bank
#

DROP TABLE IF EXISTS `rekening_bank`;

CREATE TABLE `rekening_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_akun` int DEFAULT '3',
  `nama_bank` varchar(30) DEFAULT NULL,
  `inisial` varchar(10) DEFAULT NULL,
  `nomor_rekening` varchar(20) DEFAULT NULL,
  `pemilik` varchar(40) DEFAULT NULL,
  `footer_invoice` int NOT NULL DEFAULT '0',
  `publish` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (4, 3, 'Bank Mandiri', 'MANDIRI', '900 00 2856 0093', 'Muhammad Fadhil Ramdhani', 1, 'Y');
INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (1, 3, 'Bank Central Asia', 'BCA', '0953 650 875', 'Muhammad Fadhil Ramdhani', 1, 'Y');
INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (5, 3, 'Bank Rakyat Indonesia', 'BRI', '0595 0102 4644 504', 'Muhammad Fadhil Ramdhani', 1, 'Y');
INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (6, 3, 'Bank Syariah Indonesia', 'BSI', '72414 36106', 'Muhammad Fadhil Ramdhani', 1, 'Y');
INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (7, 3, 'Bank Negara Indonesia', 'BNI', '0308 7116 19', 'Muhammad Fadhil Ramdhani', 1, 'Y');
INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (8, 3, 'Bank Jabar Banten', 'BJB', '0131578377100', 'Muhammad Fadhil Ramdhani', 1, 'Y');
INSERT INTO `rekening_bank` (`id`, `id_akun`, `nama_bank`, `inisial`, `nomor_rekening`, `pemilik`, `footer_invoice`, `publish`) VALUES (9, 3, 'QRIS', 'QRIS', '00020101021126650013', 'Muhammad Fadhil Ramdhani', 0, 'Y');


#
# TABLE STRUCTURE FOR: report
#

DROP TABLE IF EXISTS `report`;

CREATE TABLE `report` (
  `id` int NOT NULL,
  `device` varchar(20) DEFAULT NULL,
  `target` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `stateid` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: report_pesan
#

DROP TABLE IF EXISTS `report_pesan`;

CREATE TABLE `report_pesan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kirim` int NOT NULL,
  `id_konsumen` int NOT NULL DEFAULT '0',
  `device` varchar(255) DEFAULT NULL,
  `target` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `stateid` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: satu_harga
#

DROP TABLE IF EXISTS `satu_harga`;

CREATE TABLE `satu_harga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bahan` int NOT NULL DEFAULT '0',
  `id_satuan` int NOT NULL DEFAULT '0',
  `harga_beli` int DEFAULT '0',
  `harga_pokok` int NOT NULL DEFAULT '0',
  `detail_harga_pokok` varchar(50) DEFAULT NULL,
  `persen` int NOT NULL DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: satuan
#

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `satuan` varchar(20) NOT NULL,
  `nama_satuan` varchar(50) DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `pub` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (1, 'PCS', 'Pieces', 1, 0);
INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (2, 'BOX', 'Box', 1, 0);
INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (3, 'LSN', 'Lusin', 12, 0);
INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (4, 'LBR', 'Lembar', 1, 0);
INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (5, 'MTR', 'Meter', 1, 0);
INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (6, 'RIM', 'Rim', 500, 0);
INSERT INTO `satuan` (`id`, `satuan`, `nama_satuan`, `jumlah`, `pub`) VALUES (7, 'ROLL', 'Roll', 210, 0);


#
# TABLE STRUCTURE FOR: shared_folder
#

DROP TABLE IF EXISTS `shared_folder`;

CREATE TABLE `shared_folder` (
  `id` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `isi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (1, 'computer_name', 'DESKTOP-TLAULNQ');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (2, 'folder_af', 'A-F');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (3, 'folder_gm', 'G-M');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (4, 'folder_ns', 'N-S');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (5, 'folder_tz', 'T-Z');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (6, 'ukuran', 'U');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (7, 'qty', 'Q');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (8, 'bahan', 'B');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (9, 'produk', 'P');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (10, 'tanggal', 'TGL');
INSERT INTO `shared_folder` (`id`, `nama`, `isi`) VALUES (11, 'fo', 'FO');


#
# TABLE STRUCTURE FOR: slip_gaji
#

DROP TABLE IF EXISTS `slip_gaji`;

CREATE TABLE `slip_gaji` (
  `id_slip` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `tgl_rekap` date DEFAULT NULL,
  `bulan_gaji` varchar(5) DEFAULT NULL,
  `tahun_gaji` int DEFAULT NULL,
  `gaji_pokok` int DEFAULT NULL,
  `tun_jab` int DEFAULT NULL,
  `transport` int DEFAULT NULL,
  `makan` int DEFAULT NULL,
  `asuransi` int DEFAULT NULL,
  `jam_kerja` int DEFAULT NULL,
  `istirahat` int DEFAULT NULL,
  `jml_kerja` int DEFAULT NULL,
  `jml_cuti` int DEFAULT NULL,
  `jml_libur` int DEFAULT NULL,
  `gaji_kotor` int DEFAULT NULL,
  `lembur` int DEFAULT NULL,
  `tot_makan` int DEFAULT NULL,
  `tot_transport` int DEFAULT NULL,
  `tot_tun_cuti` int DEFAULT NULL,
  `tot_tun_libur` int DEFAULT NULL,
  `tot_tun_jab` int DEFAULT NULL,
  `tot_bonus` int DEFAULT NULL,
  `pot_absen` int DEFAULT NULL,
  `pot_asuransi` int DEFAULT NULL,
  `pot_kasbon` int DEFAULT NULL,
  `uang_makan_diambil` int NOT NULL DEFAULT '0',
  `uang_trans_diambil` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_slip`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=37 ROW_FORMAT=FIXED;

INSERT INTO `slip_gaji` (`id_slip`, `id_user`, `tgl_rekap`, `bulan_gaji`, `tahun_gaji`, `gaji_pokok`, `tun_jab`, `transport`, `makan`, `asuransi`, `jam_kerja`, `istirahat`, `jml_kerja`, `jml_cuti`, `jml_libur`, `gaji_kotor`, `lembur`, `tot_makan`, `tot_transport`, `tot_tun_cuti`, `tot_tun_libur`, `tot_tun_jab`, `tot_bonus`, `pot_absen`, `pot_asuransi`, `pot_kasbon`, `uang_makan_diambil`, `uang_trans_diambil`) VALUES (4, 2, '2024-02-28', '02', 2024, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);


#
# TABLE STRUCTURE FOR: stok_keluar
#

DROP TABLE IF EXISTS `stok_keluar`;

CREATE TABLE `stok_keluar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_invoice` int NOT NULL,
  `id_bahan` int NOT NULL,
  `jumlah` float NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `ket` varchar(200) DEFAULT NULL,
  `stat` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: stok_keluar_gudang
#

DROP TABLE IF EXISTS `stok_keluar_gudang`;

CREATE TABLE `stok_keluar_gudang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_barang` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `stat` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: stok_masuk
#

DROP TABLE IF EXISTS `stok_masuk`;

CREATE TABLE `stok_masuk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bahan` int NOT NULL,
  `jumlah` float NOT NULL DEFAULT '0',
  `harga_beli` int NOT NULL DEFAULT '0',
  `harga_jual` int NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ket` varchar(200) DEFAULT NULL,
  `stat` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (1, 2, '180', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (2, 3, '180', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (3, 4, '10', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (4, 5, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (5, 6, '500', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (6, 7, '500', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (7, 10, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (8, 11, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (9, 12, '500', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (11, 8, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (12, 9, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (13, 13, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (14, 14, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (15, 16, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (16, 17, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (17, 18, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (18, 19, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (19, 20, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (20, 21, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (21, 22, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (22, 23, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (23, 24, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (24, 25, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (25, 26, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (26, 27, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (27, 28, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (28, 29, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (29, 30, '100', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (30, 31, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (31, 32, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (32, 33, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (33, 34, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (34, 34, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (35, 35, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (36, 36, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (37, 37, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (38, 38, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (39, 39, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (40, 40, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (41, 41, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (42, 42, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (43, 43, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (44, 44, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (45, 45, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (46, 46, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);
INSERT INTO `stok_masuk` (`id`, `id_bahan`, `jumlah`, `harga_beli`, `harga_jual`, `create_date`, `update_date`, `ket`, `stat`) VALUES (47, 47, '5', 0, 0, '2024-02-29 02:27:10', '2024-02-29 09:27:10', NULL, 1);


#
# TABLE STRUCTURE FOR: stok_masuk_gudang
#

DROP TABLE IF EXISTS `stok_masuk_gudang`;

CREATE TABLE `stok_masuk_gudang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_barang` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `stat` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: storage
#

DROP TABLE IF EXISTS `storage`;

CREATE TABLE `storage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `namafile` varchar(255) NOT NULL,
  `nama_original` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: supplier
#

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_supplier` int NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(100) NOT NULL,
  `jenis_usaha` varchar(100) DEFAULT NULL,
  `pemilik` varchar(20) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `telp` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nomor_rekening` varchar(20) DEFAULT NULL,
  `tgl_terdaftar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publish` enum('Y','N') DEFAULT 'Y',
  `kunci` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_supplier`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `supplier` (`id_supplier`, `nama_perusahaan`, `jenis_usaha`, `pemilik`, `jabatan`, `alamat`, `telp`, `email`, `nomor_rekening`, `tgl_terdaftar`, `publish`, `kunci`) VALUES (1, 'UMUM', '-', '-', '-', '-', '-', '-', '-', '2023-12-23 00:09:44', 'Y', 1);


#
# TABLE STRUCTURE FOR: surat_jalan
#

DROP TABLE IF EXISTS `surat_jalan`;

CREATE TABLE `surat_jalan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_invoice` int NOT NULL,
  `no_pol` varchar(10) DEFAULT NULL,
  `alamat_kirim` text,
  `catatan` text,
  `tanggal` date NOT NULL,
  `stat` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tb_users
#

DROP TABLE IF EXISTS `tb_users`;

CREATE TABLE `tb_users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `parent` int NOT NULL DEFAULT '0',
  `idmenu` text,
  `id_level` varchar(100) DEFAULT '2',
  `idlevel` varchar(50) DEFAULT '1,2,3,4',
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `alamat` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `hak_akses` int NOT NULL DEFAULT '0',
  `type_akses` varchar(50) NOT NULL DEFAULT '0',
  `id_session` varchar(100) DEFAULT NULL,
  `sesi_login` varchar(100) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `verify` int NOT NULL DEFAULT '0',
  `app_secret` varchar(255) DEFAULT NULL,
  `last_invoice` int NOT NULL DEFAULT '0',
  `last_idp` int DEFAULT '0',
  `last_idbeli` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`, `last_idbeli`) VALUES (2, 1, '188,147,162,153,179,182,171,174,155,214,213,180,159,156,160,193,190,191,157,186,166,206,175,187,217,216,218,167', '3', '1,2,3,4', '$2y$10$ppUnso/Y3BqWhmJshLraa.LQ28jIH/RPNzN5e4j25iWgdfuiUKbha', 'Nur', '2024-01-01', 'Bogor', 'nur@uqimedia.com', '-', '/upload/images/user/favicon.png', 'kasir', 'Y', 0, '1,2,4,5,6,7,8,9,10', 'ca43-608e-5c5b-7b50-2085', '21ae994d7714ecc8cff9df4b9a06cf13cf721934', NULL, 1, 'Kasir', 0, 0, 0);
INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`, `last_idbeli`) VALUES (1, 0, '188,147,162,183,196,109,153,148,154,179,204,194,201,197,195,199,203,198,182,202,181,171,174,178,220,155,214,213,180,159,156,160,193,190,191,200,157,186,166,206,205,112,33,170,177,139,175,185,24,189,187,207,208,209,217,215,216,218,184,168,165,176,167', '1', '1,2,3,4,5,6', '$2y$10$45CBxnsdRX/cMZLWZloJPOQ/Fnp8pEJj7S4G558VvswRTnDWfi6T.', 'Super Admin', '2024-01-01', 'Bogor', 'admin@uqimedia.com', '-', NULL, 'admin', 'Y', 1, '1,2,4,5,6,7,8,9,10', '2R86je3fod', '3ddd738dc5facd350caca09987195c9e86c2bb29', NULL, 1, 'Administrator', 1, 0, 0);
INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`, `last_idbeli`) VALUES (4, 1, '188,162,183,196,109,153,148,154,179,204,194,201,197,195,199,203,198,182,202,181,171,174,178,220,155,214,213,180,159,156,160,190,191,200,157,186,166,206,205,112,33,170,177,139,175,185,187,217,215,216,218,167', '2', '2,3,4,5,6', '$2y$10$DPZgn.MIIBCDBLO5Gkd/JeWqi3v8F2mNjPrFI6dPmjhvT7xx9Bwnm', 'Fadhil', '2024-01-01', 'Bogor', 'owner@uqimedia.com', '-', NULL, 'owner', 'Y', 0, '1,2,4,5,6,8', NULL, '581ec9338255068c262de68b115da0ba95325e96', NULL, 1, 'Owner', 0, 0, 0);
INSERT INTO `tb_users` (`id_user`, `parent`, `idmenu`, `id_level`, `idlevel`, `password`, `nama_lengkap`, `tgl_daftar`, `alamat`, `email`, `no_hp`, `foto`, `level`, `aktif`, `hak_akses`, `type_akses`, `id_session`, `sesi_login`, `logo`, `verify`, `app_secret`, `last_invoice`, `last_idp`, `last_idbeli`) VALUES (13, 1, '188,147,162,153,179,182,171,174,155,214,213,180,159,156,160,193,190,191,157,186,166,206,175,187,217,216,218,167', '3', '1,2,3,4', '$2y$10$cOmepPDfCCyvftQi6fh3Du/loc1RSYr2dcxnGEb7FJ.8iddBSRKrG', 'Ilmi', '2024-02-01', 'Bogor', 'ilmi@uqimedia.com', '-', NULL, 'kasir', 'Y', 0, '1,2,4,5,6,7,8,9,10', NULL, 'c04ec25a750cea603e0e4e1a84c700c7fca56361', NULL, 1, 'Front Desk', 0, 0, 0);


#
# TABLE STRUCTURE FOR: template_pesan
#

DROP TABLE IF EXISTS `template_pesan`;

CREATE TABLE `template_pesan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `status` varchar(1) DEFAULT '0',
  `create_date` datetime NOT NULL,
  `active` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `template_pesan` (`id`, `title`, `deskripsi`, `status`, `create_date`, `active`) VALUES (1, 'Invoice Link', '#Nomor Pesanan Anda adalah: {invoice}\nUntuk melihat nota pesanan silahkan klik link berikut : {link_desktop}\n\nTerima Kasih.', '1', '2023-05-07 10:09:05', 'Y');


#
# TABLE STRUCTURE FOR: template_promo
#

DROP TABLE IF EXISTS `template_promo`;

CREATE TABLE `template_promo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `deskripsi` mediumtext,
  `status` varchar(1) DEFAULT '0',
  `jenis_pesan` int NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `filetype` varchar(10) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `active` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `template_promo` (`id`, `title`, `deskripsi`, `status`, `jenis_pesan`, `url`, `filename`, `filetype`, `create_date`, `active`) VALUES (4, 'Promo Kirim Promo', '{selamat}, {panggilan} {nama}\r\n\r\nKami Memiliki Promo Bulan Ramadhan\r\n\r\nhubungi kami di https://wa.me/{hp}', NULL, 0, '', '', '', '2023-05-07 10:09:05', 'Y');


#
# TABLE STRUCTURE FOR: themes
#

DROP TABLE IF EXISTS `themes`;

CREATE TABLE `themes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `folder` varchar(10) DEFAULT NULL,
  `pub` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `themes` (`id`, `title`, `folder`, `pub`) VALUES (1, 'dashboard', 'dashboard', 0);


#
# TABLE STRUCTURE FOR: type_akses
#

DROP TABLE IF EXISTS `type_akses`;

CREATE TABLE `type_akses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_parent` int NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL,
  `slug` varchar(10) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `pub` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (1, 0, 'Edit Order', 'edit', 1, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (2, 0, 'Hapus Pembayaran', 'hapus', 1, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (3, 0, 'Edit Order Lunas', 'lunas', 1, 1);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (4, 0, 'Pending Order', 'pending', 1, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (5, 0, 'Batal Order', 'batal', 1, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (6, 0, 'Buat Order', 'add', 0, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (7, 0, 'Create Data', 'create', 0, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (8, 0, 'Read Data', 'read', 0, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (9, 0, 'Update Data', 'update', 0, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (10, 0, 'Delete Data', 'delete', 0, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (11, 0, 'Reset Database', 'reset', 0, 0);
INSERT INTO `type_akses` (`id`, `id_parent`, `title`, `slug`, `status`, `pub`) VALUES (12, 0, 'Rollback Data', 'rollback', 0, 0);


#
# TABLE STRUCTURE FOR: uang_makan
#

DROP TABLE IF EXISTS `uang_makan`;

CREATE TABLE `uang_makan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: uang_transport
#

DROP TABLE IF EXISTS `uang_transport`;

CREATE TABLE `uang_transport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: user_agent
#

DROP TABLE IF EXISTS `user_agent`;

CREATE TABLE `user_agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `counter` int NOT NULL DEFAULT '1',
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=434 DEFAULT CHARSET=latin1;

INSERT INTO `user_agent` (`id`, `ip`, `os`, `browser`, `counter`, `create_date`, `update_date`) VALUES (433, '127.0.0.1', 'Mac OS X', 'Chrome 121.0.0.0', 13, '2024-02-26 13:33:48', '2024-02-26 20:33:48');


