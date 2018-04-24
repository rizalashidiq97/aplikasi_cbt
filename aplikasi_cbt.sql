-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2018 at 07:13 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_cbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_tes`
--

CREATE TABLE `hasil_tes` (
  `id` int(30) NOT NULL,
  `id_tes` int(3) NOT NULL,
  `id_kategori` varchar(100) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(6) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_tes`
--

INSERT INTO `hasil_tes` (`id`, `id_tes`, `id_kategori`, `id_user`, `list_soal`, `list_jawaban`, `jml_benar`, `tgl_mulai`, `tgl_selesai`, `status`) VALUES
(1, 1, '1', '5', '15', '15:C', 1, '2018-03-03 16:03:12', '2018-03-03 16:05:12', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_tes_trial`
--

CREATE TABLE `hasil_tes_trial` (
  `id` int(11) NOT NULL,
  `id_tes` int(2) NOT NULL,
  `id_user` int(11) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `nilai` int(5) NOT NULL,
  `jumlah_benar` int(8) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('N','Y') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil_tes_trial`
--

INSERT INTO `hasil_tes_trial` (`id`, `id_tes`, `id_user`, `list_soal`, `list_jawaban`, `nilai`, `jumlah_benar`, `tgl_mulai`, `tgl_selesai`, `status`) VALUES
(1, 2, 1, '4,3,2,1,5', '4:A,3:A,2:C,1:D,5:A', 0, 0, '2018-02-26 17:15:38', '2018-02-26 17:25:38', 'N'),
(2, 2, 7, '4,5,1,3,2', '4:C,5:C,1:A,3:C,2:B', 80, 4, '2018-02-28 22:19:58', '2018-02-28 22:29:58', 'N'),
(3, 2, 17, '2,1,5,4,3', '2:B,1:A,5:C,4:C,3:D', 100, 5, '2018-03-01 08:06:30', '2018-03-01 08:16:30', 'N'),
(4, 2, 2, '1,2,3,5,4', '1:A,2:B,3:D,5:C,4:C', 100, 5, '2018-03-03 07:00:17', '2018-03-03 07:10:17', 'N'),
(5, 2, 5, '2,3,5,1,4', '2:B,3:D,5:C,1:A,4:C', 100, 5, '2018-03-03 12:23:34', '2018-03-03 12:33:34', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'verbal'),
(2, 'spasial'),
(3, 'aritmatika'),
(4, 'logika umum ');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(30) NOT NULL,
  `id_user` int(30) NOT NULL,
  `laporan` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `id_user`, `laporan`) VALUES
(1, 1, 'user 1'),
(2, 2, '<p>user 2 laporan untuk user ini</p>'),
(3, 14, 'user 14'),
(4, 18, 'user 18'),
(5, 16, 'user 16'),
(6, 25, 'user 25'),
(7, 3, '<p>user 3 edit</p>'),
(8, 6, '<p>user 6 edit</p>');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int(30) NOT NULL,
  `nama` varchar(110) NOT NULL,
  `no_peserta` varchar(30) NOT NULL,
  `no_kursi` int(5) NOT NULL,
  `periode` int(5) NOT NULL,
  `kode_prodi` varchar(10) NOT NULL,
  `pilih_prodi` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama`, `no_peserta`, `no_kursi`, `periode`, `kode_prodi`, `pilih_prodi`, `tgl_lahir`, `status`) VALUES
(1, 'KWIK HAN CHUNG JONATHAN', '99106120001', 1, 1, '7007', 'MAGISTER ILMU HUKUM', '1993-03-19', '0'),
(2, 'ROSNA', '99236120001', 2, 1, '7017', 'MAGISTER KENOTARIATAN', '1993-06-20', '0'),
(3, 'DESY MARYANI', '99016120001', 3, 1, '8003', 'DOKTOR ILMU HUKUM', '1985-12-18', '0'),
(4, 'NIKMATUNIAYAH, SE. MSI. AKT', '99036120001', 4, 1, '8002', 'DOKTOR ILMU EKONOMI', '1973-02-14', '0'),
(5, 'L. ADI MADYA ARTANTYO', '99116120001', 5, 1, '7023', 'MAGISTER MANAJEMEN', '1992-11-05', '0'),
(6, 'KETTY WIDYASARI', '99236120002', 6, 1, '7017', 'MAGISTER KENOTARIATAN', '1981-02-01', '0'),
(7, 'NELCIANA YULITA SORUH', '99176120001', 7, 1, '7001', 'MAGISTER AKUNTANSI', '1983-07-28', '0'),
(8, 'PUSPITA RAHMAWATI,S.KM', '99286120001', 8, 1, '7021', 'MAGISTER KESEHATAN LINGKUNGAN', '1993-08-17', '0'),
(9, 'YOHANES FATELIUS HENDRA', '99236120003', 9, 1, '7017', 'MAGISTER KENOTARIATAN', '1993-02-20', '0'),
(10, 'VINCENTIA RENI VITASURYA', '99056120001', 10, 2, '8004', 'DOKTOR TEK ARSITEKTUR & PERKOTAAN', '1979-11-10', '0'),
(11, 'RIFKA ANNISA APRIANA ', '99236120004', 11, 2, '7017', 'MAGISTER KENOTARIATAN', '1993-04-29', '0'),
(12, 'DHARANINDRA WARDHANA', '99236120005', 12, 2, '7017', 'MAGISTER KENOTARIATAN', '1974-04-06', '0'),
(13, 'EKO ARI WIBOWO', '99106120002', 13, 2, '7007', 'MAGISTER ILMU HUKUM', '1992-05-30', '0'),
(14, 'STEFANUS  BINTANG SUNU JATI', '99236120006', 14, 2, '7017', 'MAGISTER KENOTARIATAN', '1990-02-04', '0'),
(15, 'TRESNONINGTIAS MUTIARA ANISA', '99536120001', 15, 2, '7022', 'MAGISTER KIMIA', '1992-01-08', '0'),
(16, 'OCKY HARMONIANTO', '99236120007', 16, 2, '7017', 'MAGISTER KENOTARIATAN', '1990-10-05', '0'),
(17, 'TEGAR OCTORA YOLANDHI', '99236120008', 17, 2, '7017', 'MAGISTER KENOTARIATAN', '1993-10-07', '0'),
(18, 'FAISAL BAYU PRIHANDONO', '99236120009', 18, 3, '7017', 'MAGISTER KENOTARIATAN', '1984-09-19', '0'),
(19, 'NESTI RAHMAWATI', '99266120001', 19, 3, '7005', 'MAGISTER ILMU GIZI', '1993-08-25', '0'),
(20, 'ABDUL HARIS KUSPRANOTO', '99556120001', 20, 4, '7027', 'MAGISTER TEKNIK ELEKTRO', '1990-02-11', '0'),
(21, 'NASIR SUDIRMAN', '99226120001', 21, 4, '7009', 'MAGISTER ILMU LINGKUNGAN', '1986-01-06', '0'),
(22, 'FITA ASIH SEPTIAMIN', '99236120010', 22, 4, '7017', 'MAGISTER KENOTARIATAN', '1994-09-28', '0'),
(23, 'DIKO RIZKI ADYATMA', '99236120011', 23, 4, '7017', 'MAGISTER KENOTARIATAN', '1993-01-03', '0'),
(24, 'YOSE TRIMIARTI', '99236120012', 24, 4, '7017', 'MAGISTER KENOTARIATAN', '1994-12-09', '0'),
(25, 'SISCA SEPTIMALINA SENGAJI', '99236120013', 25, 5, '7017', 'MAGISTER KENOTARIATAN', '1988-09-01', '0'),
(26, 'VIVIN OKTALIA', '99176120002', 26, 5, '7001', 'MAGISTER AKUNTANSI', '1991-10-17', '0'),
(27, 'CHOERUL ANAM', '99246120001', 27, 5, '7012', 'MAGISTER ILMU SUSASTRA', '1991-01-04', '0'),
(28, 'MUHADZ ALI JIDZAR', '99106120003', 28, 5, '7007', 'MAGISTER ILMU HUKUM', '1987-09-13', '0'),
(29, 'RICKY', '99236120014', 29, 5, '7017', 'MAGISTER KENOTARIATAN', '1992-11-13', '0'),
(30, 'FERIZALDI,SE.,M.SI', '99096120001', 30, 5, '8001', 'DOKTOR ADMINISTRASI PUBLIK', '1977-05-29', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `no_kursi` int(11) NOT NULL,
  `id_ruang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`no_kursi`, `id_ruang`) VALUES
(1, '1'),
(2, '1'),
(3, '1'),
(4, '1'),
(5, '1'),
(6, '1'),
(7, '1'),
(8, '1'),
(9, '1'),
(10, '1'),
(11, '1'),
(12, '1'),
(13, '1'),
(14, '1'),
(15, '1'),
(16, '1'),
(17, '1'),
(18, '1'),
(19, '1'),
(20, '1'),
(21, '2'),
(22, '2'),
(23, '2'),
(24, '2'),
(25, '2'),
(26, '2'),
(27, '2'),
(28, '2'),
(29, '2'),
(30, '2'),
(31, '2'),
(32, '2'),
(33, '2'),
(34, '2'),
(35, '2'),
(36, '2'),
(37, '2'),
(38, '2'),
(39, '2'),
(40, '2'),
(41, '3'),
(42, '3'),
(43, '3'),
(44, '3'),
(45, '3'),
(46, '3'),
(47, '3'),
(48, '3'),
(49, '3'),
(50, '3'),
(51, '3'),
(52, '3'),
(53, '3'),
(54, '3'),
(55, '3'),
(56, '3'),
(57, '3'),
(58, '3'),
(59, '3'),
(60, '3');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `versi` int(3) NOT NULL,
  `kategori` int(3) NOT NULL,
  `soal` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `versi`, `kategori`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`, `tgl_input`) VALUES
(1, 1, 1, '<p>Soal 1 Versi 1</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'C', '2018-03-01 17:45:05'),
(2, 1, 2, '<p>Soal 1 Versi 1</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'D', '2018-03-01 17:46:01'),
(3, 1, 2, '<p>Soal 2 Versi 1</p>', '<p>Soal A.2</p>', '<p>Soal B.2</p>', '<p>Soal C.2</p>', '<p>Soal D.2</p>', 'B', '2018-03-01 17:47:29'),
(4, 1, 3, '<p>Soal 1 Versi 1</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'A', '2018-03-01 17:49:03'),
(5, 1, 3, '<p>Soal 2 Versi 1</p>', '<p>Opsi A.2</p>', '<p>Opsi B.2</p>', '<p>Opsi C.2</p>', '<p>Opsi D.2</p>', 'A', '2018-03-01 17:50:01'),
(6, 1, 3, '<p>Soal 3 Versi 1</p>', '<p>Opsi A.3</p>', '<p>Opsi B.3</p>', '<p>Opsi C.3</p>', '<p>Opsi D.3</p>', 'D', '2018-03-01 17:52:06'),
(7, 1, 4, '<p>Soal 1 Versi 1</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'C', '2018-03-01 17:53:03'),
(8, 2, 1, '<p>Soal 1 Versi 2</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'A', '2018-03-01 17:54:13'),
(9, 2, 2, '<p>Soal 1 Versi 2</p>', '<p>Opsi A.2</p>', '<p>Opsi B.2</p>', '<p>Opsi C.2</p>', '<p>Opsi D.2</p>', 'C', '2018-03-01 17:54:47'),
(10, 2, 3, '<p>Soal 2 Versi 2</p>', '<p>Opsi A.2</p>', '<p>Opsi B.2</p>', '<p>Opsi C.2</p>', '<p>Opsi D.2</p>', 'B', '2018-03-01 17:56:29'),
(11, 2, 2, '<p>Soal 2 Versi 2</p>', '<p>Opsi A.2</p>', '<p>Opsi B.2</p>', '<p>Opsi C.2</p>', '<p>Opsi D.2</p>', 'D', '2018-03-01 17:57:42'),
(12, 2, 3, '<p>Soal 1 Versi 2</p>', '<p>Opsi A.1</p>', '<p>Opsi B.2</p>', '<p>Opsi C.2</p>', '<p>Opsi D.2</p>', 'B', '2018-03-01 17:58:18'),
(13, 2, 3, '<p>Soal 3 Versi 2</p>', '<p>Opsi A.3</p>', '<p>Opsi B.3</p>', '<p>Opsi C.3</p>', '<p>Opsi D.4</p>', 'C', '2018-03-01 17:59:15'),
(14, 2, 4, '<p>Soal 1 Versi 2</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'A', '2018-03-01 18:00:47'),
(15, 3, 1, '<p>Soal 1 Versi 3</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'C', '2018-03-01 18:02:03'),
(16, 3, 2, '<p>Soal 1 Versi 3</p>', '<p>Opsi A.1</p>', '<p>Opsi B.1</p>', '<p>Opsi C.1</p>', '<p>Opsi D.1</p>', 'D', '2018-03-01 18:02:51'),
(17, 3, 2, '<p>Soal 2 Versi 3</p>', '<p>Opsi A.2</p>', '<p>Opsi B.2</p>', '<p>Opsi C.2</p>', '<p>Opsi D.2</p>', 'C', '2018-03-01 18:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `soal_trial`
--

CREATE TABLE `soal_trial` (
  `id` int(11) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `soal` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `tgl_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal_trial`
--

INSERT INTO `soal_trial` (`id`, `kategori`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`, `tgl_input`) VALUES
(1, 'verbal', 'Soal 1', 'Opsi 1.A', 'Opsi 1.B', 'Opsi 1.C', 'Opsi 1.D', 'A', '2018-02-20 08:00:00'),
(2, 'spasial', 'Soal 2', 'Opsi 2.A', 'Opsi 2.B', 'Opsi 2.C', 'Opsi 2.D', 'B', '2018-02-20 08:00:00'),
(3, 'spasial', '<p><img src=\"/Aplikasi_CBT/upload/gambar/47e895e3506acc55075cf00d69b12c86cf58d786.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/f14b17b95122f80b184f3edc595d72a1d9532ac0.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/46c750f1d1257e6bb004c4fa6ad8e4d8a60639a4.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/5986e768dc50bfd2c216b2c19736b121312dd65f.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/dffa54d816f20f21f6de9a3781e3eb103096b6c3.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', 'D', '2018-02-21 07:29:39'),
(4, 'spasial', '<p><img src=\"/Aplikasi_CBT/upload/gambar/928ad92e3c43b646d2c425375818b7173fb2fdde.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p>ini gambar 1</p><p><img src=\"/Aplikasi_CBT/upload/gambar/99e48c15542b2fa35b785741c85c653c40fa4c23.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p>ini gambar 2</p><p><img src=\"/Aplikasi_CBT/upload/gambar/a5e476b904207bd58984a4744c28a7131c1bd384.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p>ini gambar 3</p><p><img src=\"/Aplikasi_CBT/upload/gambar/e34013584a8a3dac9da81cd776b6f4f54f53e652.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p>ini gambar 4</p><p><img src=\"/Aplikasi_CBT/upload/gambar/2081acc145ceb99397fe6cabca9806714ccba5f8.JPG\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', 'C', '2018-02-21 07:49:41'),
(5, 'spasial', '<p>manakah gambar berikut ini yang menurut anda terlucu ?</p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/0558d0d7388c15958ab659b9d0909eeaa51a4bbd.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/683a921108174d980158dae1c150bfb7a6add64c.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/920e94df01421319b1fb45713c9ea77944310d22.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', '<p><img src=\"/Aplikasi_CBT/upload/gambar/42fa50cdc2c997b62fb7658798a6499f3e5469df.jpg\" style=\"width: 300px;\" class=\"fr-fic fr-dib\"></p>', 'C', '2018-02-21 07:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(40) NOT NULL,
  `nama_ujian` varchar(50) NOT NULL,
  `idkategori` int(11) DEFAULT NULL,
  `waktu` int(5) NOT NULL,
  `terlambat` int(11) DEFAULT NULL,
  `tgl_mulai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `nama_ujian`, `idkategori`, `waktu`, `terlambat`, `tgl_mulai`) VALUES
(1, 'Tes Uji Verbal', 1, 2, 1, '2018-03-03 16:03:00'),
(2, 'Test Trial', NULL, 10, NULL, NULL),
(3, 'Test Uji Spasial', 2, 55, 2, '2018-03-01 19:09:00'),
(4, 'Tes Uji Logika Umum', 4, 10, 2, '2018-03-01 08:07:00'),
(5, 'Tes Uji Aritmatika', 3, 10, 2, '2018-02-26 11:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_ruang` varchar(20) NOT NULL,
  `periode` varchar(5) NOT NULL,
  `grup` varchar(30) NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `id_ruang`, `periode`, `grup`, `status`) VALUES
(1, 'rizal', '9309ce1164ced068411b8d9353bf8b73', '-', '-', 'administrator', 0),
(2, 'billy', 'a470203fa78fd5b171c36be79cc476f8', '-', '-', 'operator utama', 0),
(3, 'wahyu', 'b4168d1a8f765fd2db2c78e456da9d64', '1', '1', 'operator ruangan', 0),
(4, 'budi', '1ac9c1e3af64b142774f3fe922986ba6', '1', '2', 'operator ruangan', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_tes`
--
ALTER TABLE `hasil_tes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_tes_trial`
--
ALTER TABLE `hasil_tes_trial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`no_kursi`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soal_trial`
--
ALTER TABLE `soal_trial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_tes`
--
ALTER TABLE `hasil_tes`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hasil_tes_trial`
--
ALTER TABLE `hasil_tes_trial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `soal_trial`
--
ALTER TABLE `soal_trial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
