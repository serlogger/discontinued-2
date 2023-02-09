-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2023 at 05:44 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se_m1p`
--

-- --------------------------------------------------------

--
-- Table structure for table `cat1_industries`
--

CREATE TABLE `cat1_industries` (
  `ind_id` int(11) NOT NULL,
  `ind` varchar(50) NOT NULL,
  `path` varchar(31) NOT NULL,
  `industry_en` varchar(255) NOT NULL,
  `industry_fi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cat1_industries`
--

INSERT INTO `cat1_industries` (`ind_id`, `ind`, `path`, `industry_en`, `industry_fi`) VALUES
(1, '_it_', '001', 'IT', 'IT & tietotekniikka'),
(2, '_construction_', '002', 'Construction', 'Rakentaminen'),
(6, '_repair_restoration_', '006', 'Repair & restoration', 'Korjaus & entisöinti'),
(8, '_transportation_', '008', 'Transportation', 'Kuljetus'),
(10, '_gardening_agriculture_', '010', 'Gardening & agriculture', 'Maatalous ja puutarhanhoito'),
(12, '_media_digital_products_', '012', 'Media & digital products', 'Media & digitaaliset tuotteet'),
(14, '_other_', '014', 'Other', 'Muut'),
(15, '_healthcare_', '015', 'Healthcare', 'Terveydenhuolto'),
(16, '_lifestyle_wealth_', '016', 'Lifestyle & Wealth', 'Hyvinvointi & elämäntapa'),
(17, '_art_', '017', 'Art', 'Taide'),
(18, '_design_', '018', 'Design', 'Suunnittelu'),
(19, '_money_finance_', '019', 'Money & finance', 'Raha & talous');

-- --------------------------------------------------------

--
-- Table structure for table `cat2_categories`
--

CREATE TABLE `cat2_categories` (
  `cat_id` int(11) NOT NULL,
  `cat` varchar(50) NOT NULL,
  `path` varchar(31) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `category_en` varchar(255) NOT NULL,
  `category_fi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cat2_categories`
--

INSERT INTO `cat2_categories` (`cat_id`, `cat`, `path`, `parent_id`, `category_en`, `category_fi`) VALUES
(3, '_programming_development_', '001_003', 1, 'Programming & development', 'Ohjelmointi & kehitys'),
(4, '_it_support_', '001_004', 1, 'IT support', 'IT-tuki'),
(5, '_information_security_', '001_005', 1, 'Information security', 'Tietoturva'),
(6, '_servers_hosting_', '001_006', 1, 'Servers & hosting', 'Palvelimet & verkon ylläpito'),
(7, '_networking_', '001_007', 1, 'Networking', 'Tietoverkot'),
(11, '_vehicle_repair_', '006_011', 6, 'Vehicle repair', 'Auton korjaus'),
(23, '_news_magazines_', '012_023', 12, 'News & magazines', 'Uutiset & lehdet'),
(24, '_social_media_', '012_024', 12, 'Social media', 'Sosiaalinen media'),
(25, '_blogs_', '012_025', 12, 'Blogs', 'Blogit'),
(26, '_video_blogs_', '012_026', 12, 'Video blogs', 'Videoblogit'),
(27, '_photography_videography_', '012_027', 12, 'Photography & videography', 'Valo- ja videokuvaus'),
(28, '_audio_voiceover_', '012_028', 12, 'Audio & voiceover', 'Ääni & puhe'),
(29, '_music_', '012_029', 12, 'Music', 'Musiikki'),
(30, '_art_painting_', '012_030', 12, 'Art & painting', 'Taide & maalaukset'),
(31, '_beauty_', '016_031', 16, 'Beauty', 'Kauneus'),
(32, '_home_appliance_repair_', '006_032', 6, 'Home appliance repair', 'Kodinkoneiden huolto'),
(33, '_item_restoration_', '006_033', 6, 'Item restoration', 'Esineiden entisöinti'),
(36, '_user_interface_design_', '018_036', 18, 'User interface design', 'Käyttöliittymäsuunnittelu'),
(37, '_visual_arts_', '017_037', 17, 'Visual arts', 'Kuvataide'),
(39, '_coaching_consultancy_', '016_039', 16, 'Coaching & consultancy', 'Valmennus & konsultointi'),
(40, '_banking_', '019_040', 19, 'Banking', 'Pankkiala'),
(41, '_investing_saving_', '019_041', 19, 'Investing & saving', 'Sijoittaminen & säästäminen');

-- --------------------------------------------------------

--
-- Table structure for table `cat3_subcat`
--

CREATE TABLE `cat3_subcat` (
  `sc_id` int(11) NOT NULL,
  `sc` varchar(50) NOT NULL,
  `path` varchar(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `sub_category_en` varchar(255) NOT NULL,
  `sub_category_fi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cat3_subcat`
--

INSERT INTO `cat3_subcat` (`sc_id`, `sc`, `path`, `parent_id`, `sub_category_en`, `sub_category_fi`) VALUES
(1, '_web_development_', '001_003_001', 3, 'Web development', 'Verkkosivut'),
(2, '_mobile_applications_', '001_003_002', 3, 'Mobile applications', 'Mobiilisovellukset'),
(3, '_desktop_applications_', '001_003_003', 3, 'Desktop applications', 'Työpöytäsovellukset'),
(4, '_cryptocurrencies_blockchain_', '001_003_004', 3, 'Cryptocurrencies & blockchain', 'Kryptovaluutat & lohkoketjut'),
(11, '_cryptocurrencies_blockchain_', '012_023_011', 23, 'Cryptocurrencies & blockchain', 'Kryptovaluutat & lohkoketjut'),
(12, '_it_', '012_026_012', 26, 'IT', 'Tietotekniikka'),
(13, '_science_', '012_026_013', 26, 'Science', 'Tiede'),
(14, '_beauty_', '012_026_014', 26, 'Beauty', 'Kauneus'),
(15, '_it_', '012_025_015', 25, 'IT', 'Tietotekniikka'),
(16, '_science_', '012_025_016', 25, 'Science', 'Tiede'),
(17, '_beauty_', '012_025_017', 25, 'Beauty', 'Kauneus'),
(18, '_drone_photos_videos_', '012_027_018', 27, 'Drone photos & videos', 'Dronekuvaus'),
(19, '_nft_collections_', '017_037_019', 37, 'NFT collections', 'NFT-kokoelmat'),
(20, '_photography_', '012_027_020', 27, 'Photography', 'Valokuvaus'),
(21, '_microscope_photography_', '012_027_021', 27, 'Microscope photography', 'Mikroskooppikuvaus'),
(22, '_life_coaching_', '016_039_022', 39, 'Life coaching', 'Elämäntaidon valmennus'),
(23, '_financial_coaching_', '016_039_023', 39, 'Financial coaching', 'Talous- ja rahavalmennus'),
(24, '_nlp_', '016_039_024', 39, 'NLP', 'NLP'),
(25, '_cryptocurrencies_', '019_041_025', 41, 'Cryptocurrencies', 'Kryptovaluutat');

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(49) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `temp` varchar(50) NOT NULL,
  `metadata_en` varchar(4095) NOT NULL,
  `metadata_fi` varchar(4095) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`id`, `name`, `path`, `parent_id`, `temp`, `metadata_en`, `metadata_fi`) VALUES
(2, '_it_', '002', 0, 'ind', 'it information technology', 'it tietotekniikka atk'),
(3, '_construction_', '003', 0, 'ind', 'construction building houses buildings cottages', 'rakennusala rakennuttaa rakennuttaminen'),
(4, '_repair_restoration_', '004', 0, 'ind', '', ''),
(5, '_transportation_', '005', 0, 'ind', '', ''),
(6, '_gardening_agriculture_', '006', 0, 'ind', '', ''),
(7, '_media_digital_products_', '007', 0, 'ind', '', ''),
(8, '_other_', '008', 0, 'ind', '', ''),
(9, '_healthcare_', '009', 0, 'ind', '', ''),
(10, '_lifestyle_wealth_', '010', 0, 'ind', '', ''),
(11, '_art_', '011', 0, 'ind', '', ''),
(13, '_money_finance_', '013', 0, 'ind', '', ''),
(17, '_programming_development_', '002_017', 2, 'cat', '002_017', ''),
(18, '_it_support_', '002_018', 2, 'cat', 'it tech support', 'tekninen it-tuki'),
(19, '_information_security_', '002_019', 2, 'cat', '002_019', ''),
(20, '_servers_hosting_', '002_020', 2, 'cat', '002_020', ''),
(21, '_networking_', '002_021', 2, 'cat', '002_021', ''),
(22, '_vehicle_repair_', '004_022', 4, 'cat', '004_022', ''),
(23, '_news_magazines_', '007_023', 7, 'cat', '007_023', ''),
(24, '_social_media_', '007_024', 7, 'cat', '007_024', ''),
(25, '_blogs_', '007_025', 7, 'cat', '007_025', ''),
(26, '_video_blogs_', '007_026', 7, 'cat', '007_026', ''),
(27, '_photography_videography_', '007_027', 7, 'cat', '007_027', ''),
(28, '_audio_voiceover_', '007_028', 7, 'cat', '007_028', ''),
(29, '_music_', '007_029', 7, 'cat', '007_029', ''),
(30, '_art_painting_', '007_030', 7, 'cat', '007_030', ''),
(32, '_home_appliance_repair_', '004_032', 4, 'cat', '004_032', ''),
(33, '_item_restoration_', '004_033', 4, 'cat', '004_033', ''),
(35, '_visual_arts_', '011_035', 11, 'cat', '011_035', ''),
(36, '_coaching_consultancy_', '010_036', 10, 'cat', '010_036', ''),
(37, '_banking_', '013_037', 13, 'cat', '013_037', ''),
(38, '_investing_saving_', '013_038', 13, 'cat', 'investing saving investment', 'sijoittaminen sijoitus sijoitukset'),
(48, '_web_development_', '002_017_048', 17, 'sc', 'web development programming coding', 'verkkosivut ohjelmointi koodaus nettisivut nettisivujen'),
(49, '_mobile_applications_', '002_017_049', 17, 'sc', '', ''),
(50, '_desktop_applications_', '002_017_050', 17, 'sc', '', ''),
(51, '_cryptocurrencies_blockchain_', '002_017_051', 17, 'sc', '', ''),
(52, '_cryptocurrencies_blockchain_', '007_023_052', 23, 'sc', '', ''),
(53, '_it_', '007_025_053', 25, 'sc', '', ''),
(54, '_science_', '007_025_054', 25, 'sc', '', ''),
(55, '_beauty_', '007_025_055', 25, 'sc', '', ''),
(56, '_it_', '007_026_056', 26, 'sc', '', ''),
(57, '_science_', '007_026_057', 26, 'sc', '', ''),
(58, '_beauty_', '007_026_058', 26, 'sc', '', ''),
(59, '_drone_photos_videos_', '007_027_059', 27, 'sc', '', ''),
(61, '_photography_', '007_027_061', 27, 'sc', '', ''),
(62, '_microscope_photography_', '007_027_062', 27, 'sc', '', ''),
(63, '_life_coaching_', '007_027_063', 27, 'sc', '', ''),
(64, '_financial_coaching_', '010_036_064', 36, 'sc', '', ''),
(65, '_nlp_', '010_036_065', 36, 'sc', '', ''),
(66, '_cryptocurrencies_', '013_038_066', 38, 'sc', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `srv_id` int(11) NOT NULL,
  `m_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `mainpic` tinyint(1) NOT NULL,
  `uploaded_date` datetime NOT NULL DEFAULT current_timestamp(),
  `type` varchar(10) NOT NULL,
  `thumbnail` varchar(255) NOT NULL DEFAULT '',
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `srv_id`, `m_title`, `description`, `filepath`, `mainpic`, `uploaded_date`, `type`, `thumbnail`, `approved`, `likes`, `dislikes`) VALUES
(157, 482, '', '', 'kendall-henderson-Pj6TgpS_Vt4-unsplash.jpg', 1, '2022-04-17 23:00:18', '', '', 1, 0, 0),
(158, 482, '', '', 'img--2022-04-17--20-00-19--gx6BavTC-resized.jpg', 0, '2022-04-17 23:00:19', '', '', 1, 0, 0),
(159, 482, '', '', 'img--2022-04-17--20-00-19--c7FAlJj6-resized.jpg', 0, '2022-04-17 23:00:19', '', '', 1, 0, 0),
(160, 482, '', '', 'img--2022-04-17--20-00-19--Ryu4BA0a-resized.jpg', 0, '2022-04-17 23:00:20', '', '', 1, 0, 0),
(161, 482, '', '', 'img--2022-04-17--20-00-20--Iwzx9Me2-resized.jpg', 0, '2022-04-17 23:00:20', '', '', 1, 0, 0),
(162, 482, '', '', 'img--2022-04-17--20-00-20--4CY5J1vc-resized.jpg', 0, '2022-04-17 23:00:20', '', '', 1, 0, 0),
(164, 482, '', '', 'img--2022-04-17--20-00-22--xlNIzf8H-resized.jpg', 0, '2022-04-17 23:00:23', '', '', 1, 0, 0),
(165, 482, '', '', 'img--2022-04-17--20-00-23--gITd2Fir-resized.jpg', 0, '2022-04-17 23:00:25', '', '', 1, 0, 0),
(166, 482, '', '', 'img--2022-04-17--20-00-25--7Itl1vi2-resized.jpg', 0, '2022-04-17 23:00:25', '', '', 1, 0, 0),
(167, 482, '', '', 'img--2022-04-17--20-00-25--SsZXrkeB-resized.jpg', 0, '2022-04-17 23:00:25', '', '', 1, 0, 0),
(169, 492, '', '', 'galen-crout-FBOZsPbqhfM-unsplash.jpg', 1, '2022-04-20 18:42:32', '', '', 1, 0, 0),
(170, 492, '', '', 'img--2022-04-20--15-42-32--VE0qt6Zu-resized.jpg', 0, '2022-04-20 18:42:32', '', '', 1, 0, 0),
(171, 494, '', '', 'img--2022-04-24--13-02-22--KtbWn7yV-resized.jpg', 1, '2022-04-24 16:02:23', '', '', 1, 0, 0),
(172, 494, '', '', 'img--2022-04-24--13-02-23--uSG7Qodw-resized.jpg', 0, '2022-04-24 16:02:24', '', '', 1, 0, 0),
(175, 497, '', '', 'img--2022-04-24--17-06-24--k81mSYyD-resized.jpg', 1, '2022-04-24 20:06:25', '', '', 1, 0, 0),
(176, 497, '', '', 'img--2022-04-24--17-06-25--OPenCsfA-resized.jpg', 0, '2022-04-24 20:06:26', '', '', 1, 0, 0),
(177, 498, '', '', 'img--2022-04-25--11-14-17--CgMtnix6-resized.jpg', 0, '2022-04-25 14:14:18', '', '', 1, 0, 0),
(178, 498, '', '', 'img--2022-04-25--11-14-18--fzVKWHrc-resized.jpg', 0, '2022-04-25 14:14:19', '', '', 1, 0, 0),
(179, 517, '', '', 'img--2022-04-30--20-55-40--8FDdSkgE-resized.jpg', 1, '2022-04-28 09:55:50', '', '', 1, 0, 0),
(180, 517, '', '', 'img--2022-04-28--06-55-50--YN2Wrcha-resized.jpg', 0, '2022-04-28 09:55:50', '', '', 1, 0, 0),
(181, 460, '', '', 'img--2021-10-14--18-45-47-GMT-24h--CMyRuSa3-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(182, 463, '', '', 'img--2021-10-16--07-20-23-GMT-24h--xSFuTUpc-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(183, 464, '', '', 'img--2021-10-16--07-39-39-GMT-24h--E71A3Smp-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(184, 466, '', '', 'img--2021-10-17--18-15-45-GMT-24h--sOzfi4u0-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(185, 465, '', '', 'img--2021-10-16--08-22-27-GMT-24h--QPxRj6Iu-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(186, 482, '', '', 'img--2022-04-17--20-00-18--uXexkplK-resized.jpg', 0, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(187, 486, '', '', 'img--2022-04-20--14-05-26--w5oyCWAh-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(188, 487, '', '', 'img--2022-04-20--14-05-50--O9US2sFC-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(189, 488, '', '', 'img--2022-04-20--14-06-56--usrWLKm6-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(190, 489, '', '', 'img--2022-04-20--14-07-10--kO1HwUoC-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(191, 490, '', '', 'img--2022-04-20--14-07-23--beIzQZTX-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(192, 491, '', '', 'img--2022-04-20--14-07-37--I9MSrC0D-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(193, 492, '', '', 'img--2022-04-20--15-42-29--NwmQUk6S-resized.jpg', 0, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(194, 493, '', '', 'img--2022-04-20--19-57-51--su1cI7wy-resized.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(195, 494, '', '', 'img--2022-04-24--13-02-20--iCGngOzB-resized.jpg', 0, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(196, 495, '', '', 'javygo-ZdySMOIicMo-unsplash.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(197, 497, '', '', 'img--2022-04-24--17-06-23--MACOr5xX-resized.jpg', 0, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(198, 498, '', '', 'kate-ibragimova-iFQpqbLMOFU-unsplash.jpg', 1, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(199, 517, '', '', 'img--2022-04-28--06-55-48--6ayVtedL-resized.jpg', 0, '2022-05-03 18:21:06', '', '', 1, 0, 0),
(200, 520, '', '', 'nathan-dumlao-zUNs99PGDg0-unsplash.jpg', 1, '2022-05-14 17:17:41', '', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `media_mainpics`
--

CREATE TABLE `media_mainpics` (
  `id` int(11) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `srv_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media_mainpics`
--

INSERT INTO `media_mainpics` (`id`, `filepath`, `srv_id`) VALUES
(135, 'img--2021-10-14--18-45-47-GMT-24h--CMyRuSa3-resized.jpg', 460),
(136, 'img--2021-10-16--07-20-23-GMT-24h--xSFuTUpc-resized.jpg', 463),
(137, 'img--2021-10-16--07-39-39-GMT-24h--E71A3Smp-resized.jpg', 464),
(138, 'img--2021-10-17--18-15-45-GMT-24h--sOzfi4u0-resized.jpg', 466),
(139, 'img--2021-10-16--08-22-27-GMT-24h--QPxRj6Iu-resized.jpg', 465),
(145, 'img--2022-04-17--20-00-18--uXexkplK-resized.jpg', 482),
(146, 'img--2022-04-20--14-05-26--w5oyCWAh-resized.jpg', 486),
(147, 'img--2022-04-20--14-05-50--O9US2sFC-resized.jpg', 487),
(148, 'img--2022-04-20--14-06-56--usrWLKm6-resized.jpg', 488),
(149, 'img--2022-04-20--14-07-10--kO1HwUoC-resized.jpg', 489),
(150, 'img--2022-04-20--14-07-23--beIzQZTX-resized.jpg', 490),
(151, 'img--2022-04-20--14-07-37--I9MSrC0D-resized.jpg', 491),
(152, 'img--2022-04-20--15-42-29--NwmQUk6S-resized.jpg', 492),
(153, 'img--2022-04-20--19-57-51--su1cI7wy-resized.jpg', 493),
(154, 'img--2022-04-24--13-02-20--iCGngOzB-resized.jpg', 494),
(155, 'img--2022-04-24--13-08-38--RugxeUTC-resized.jpg', 495),
(156, 'img--2022-04-24--17-06-23--MACOr5xX-resized.jpg', 497),
(157, 'kate-ibragimova-iFQpqbLMOFU-unsplash.jpg', 498),
(175, 'img--2022-04-28--06-55-48--6ayVtedL-resized.jpg', 517);

-- --------------------------------------------------------

--
-- Table structure for table `media_originals`
--

CREATE TABLE `media_originals` (
  `id` int(11) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `srv_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media_originals`
--

INSERT INTO `media_originals` (`id`, `filepath`, `srv_id`) VALUES
(39, 'img--2022-04-17--20-00-18--WVjT9q2Q-original.jpg', 482),
(40, 'img--2022-04-17--20-00-18--uXexkplK-original.jpg', 482),
(41, 'img--2022-04-17--20-00-19--gx6BavTC-original.jpg', 482),
(42, 'img--2022-04-17--20-00-19--c7FAlJj6-original.jpg', 482),
(43, 'img--2022-04-17--20-00-19--Ryu4BA0a-original.jpg', 482),
(44, 'img--2022-04-17--20-00-20--Iwzx9Me2-original.jpg', 482),
(45, 'img--2022-04-17--20-00-20--4CY5J1vc-original.jpg', 482),
(46, 'img--2022-04-17--20-00-20--biJ0HoTd-original.jpg', 482),
(47, 'img--2022-04-17--20-00-22--xlNIzf8H-original.jpg', 482),
(48, 'img--2022-04-17--20-00-23--gITd2Fir-original.jpg', 482),
(49, 'img--2022-04-17--20-00-25--7Itl1vi2-original.jpg', 482),
(50, 'img--2022-04-17--20-00-25--SsZXrkeB-original.jpg', 482),
(52, 'img--2022-04-20--14-05-26--w5oyCWAh-original.jpg', 486),
(53, 'img--2022-04-20--14-05-50--O9US2sFC-original.jpg', 487),
(54, 'img--2022-04-20--14-06-56--usrWLKm6-original.jpg', 488),
(55, 'img--2022-04-20--14-07-10--kO1HwUoC-original.jpg', 489),
(56, 'img--2022-04-20--14-07-23--beIzQZTX-original.jpg', 490),
(57, 'img--2022-04-20--14-07-37--I9MSrC0D-original.jpg', 491),
(58, 'img--2022-04-20--15-42-29--NwmQUk6S-original.jpg', 492),
(59, 'img--2022-04-20--15-42-31--2MX1VCof-original.jpg', 492),
(60, 'img--2022-04-20--15-42-32--VE0qt6Zu-original.jpg', 492),
(61, 'img--2022-04-20--19-57-51--su1cI7wy-original.jpg', 493),
(62, 'img--2022-04-24--13-02-20--iCGngOzB-original.jpg', 494),
(63, 'img--2022-04-24--13-02-22--KtbWn7yV-original.jpg', 494),
(64, 'img--2022-04-24--13-02-23--uSG7Qodw-original.jpg', 494),
(65, 'img--2022-04-24--13-08-38--RugxeUTC-original.jpg', 495),
(68, 'img--2022-04-24--17-06-23--MACOr5xX-original.jpg', 497),
(69, 'img--2022-04-24--17-06-24--k81mSYyD-original.jpg', 497),
(70, 'img--2022-04-24--17-06-25--OPenCsfA-original.jpg', 497),
(71, 'img--2022-04-25--11-14-17--GABuV72a-original.jpg', 498),
(72, 'img--2022-04-25--11-14-17--CgMtnix6-original.jpg', 498),
(73, 'img--2022-04-25--11-14-18--fzVKWHrc-original.jpg', 498),
(75, 'img--2022-04-25--11-30-15--y3bKY2sn-original.jpg', 500),
(76, 'img--2022-04-25--11-41-12--diDGJtfz-original.jpg', 501),
(77, 'img--2022-04-25--11-41-21--wHJpv30F-original.jpg', 502),
(78, 'img--2022-04-25--11-41-52--SzDE2lu9-original.jpg', 503),
(79, 'img--2022-04-25--11-42-17--VDfCWek1-original.jpg', 504),
(80, 'img--2022-04-25--11-43-20--ZS3Hartu-original.jpg', 505),
(91, 'img--2022-04-28--06-55-48--6ayVtedL-original.jpg', 517),
(92, 'img--2022-04-28--06-55-49--URWBAT69-original.jpg', 517),
(93, 'img--2022-04-28--06-55-50--YN2Wrcha-original.jpg', 517),
(94, 'img--2022-05-14--14-17-40--TFZwLouP-original.jpg', 520);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `title`, `address`, `latitude`, `longitude`, `created`, `modified`, `status`) VALUES
(1, 'San francisco', 'Ch st 23', '37.7749', '-122.4194', '2022-04-23 19:56:26', '2022-04-23 19:56:26', 1),
(2, 'NY', 'CL st 2', '40.7128', '-74.0060', '2022-04-23 19:56:26', '2022-04-23 19:56:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `creator_id` varchar(255) NOT NULL,
  `service_email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `url` varchar(2048) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `created_u` int(11) NOT NULL,
  `edited` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_u` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `paym_opt` varchar(2048) NOT NULL,
  `paym_opt_csv` varchar(255) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `locality_csv` varchar(50) NOT NULL,
  `brands` text NOT NULL,
  `radius` float NOT NULL,
  `ind_id` int(50) NOT NULL,
  `ind` varchar(50) NOT NULL,
  `cat_id` varchar(50) NOT NULL,
  `cat` varchar(50) NOT NULL,
  `js_tree_cat` int(11) NOT NULL,
  `sc_id` varchar(50) NOT NULL,
  `sc` varchar(50) NOT NULL,
  `sc_details1` varchar(255) NOT NULL,
  `sc_details2` varchar(255) NOT NULL,
  `srv_stat` int(3) NOT NULL DEFAULT 1,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `min_cp` int(11) NOT NULL,
  `max_cp` int(11) NOT NULL,
  `min_dt` int(11) NOT NULL,
  `max_dt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `creator_id`, `service_email`, `phone`, `url`, `title`, `description`, `created`, `created_u`, `edited`, `edited_u`, `location`, `paym_opt`, `paym_opt_csv`, `locality`, `locality_csv`, `brands`, `radius`, `ind_id`, `ind`, `cat_id`, `cat`, `js_tree_cat`, `sc_id`, `sc`, `sc_details1`, `sc_details2`, `srv_stat`, `lat`, `lon`, `min_cp`, `max_cp`, `min_dt`, `max_dt`) VALUES
(460, '14', 'admin@kryptouutiset.net', '', 'kryptouutiset.net', 'Kryptouutiset.net', 'Kryptovaluutta- ja lohkoketju-uutiset suomeksi', '2021-10-14 20:44:00', 1634237040, '2021-10-14 20:44:00', 1634237040, 'Uusimaa, Finland', 'a:9:{i:0;s:4:\"iban\";i:1;s:4:\"cash\";i:2;s:3:\"btc\";i:3;s:3:\"eth\";i:4;s:4:\"doge\";i:5;s:3:\"ltc\";i:6;s:6:\"paypal\";i:7;s:10:\"mobile_pay\";i:8;s:14:\"more_available\";}', '_iban_, _cash_, _btc_, _eth_, _doge_, _ltc_, _paypal_, _mobile_pay_, _more_available_', 'a:1:{i:0;s:6:\"online\";}', '_online_', '_huawei_, _samsung_', 0, 12, '_media_digital_products_', '23', '_news_magazines_', 1, '11', '_cryptocurrencies_blockchain_', '', '', 1, 62.3355, 22.3214, 0, 120, 0, 0),
(463, '7', 'mj.ilm@pm.me', '', '', 'Dronekuvausta Suomessa', 'Kuvaamme kohteesi haluamastasi korkeudesta (120 m asti) ja haluamastasi kulmasta. Palvelumme sopii hyvin erilaisiin tapahtumiin, asuntojen ja muiden tuotteiden myyntiesittelyihin, rakennustyömaille sekä tonttien, tai vaikka kotipolkujen kuvaamiseen. Toteutamme myös henkilökuvauksia erilaisissa ympäristöissä kilpailukykyiseen hintaan.', '2021-10-16 10:20:00', 1634372400, '2021-10-16 10:20:00', 1634372400, 'Lohja, Finland', 'a:9:{i:0;s:4:\"iban\";i:1;s:4:\"cash\";i:2;s:3:\"btc\";i:3;s:3:\"eth\";i:4;s:4:\"doge\";i:5;s:3:\"ltc\";i:6;s:6:\"paypal\";i:7;s:10:\"mobile_pay\";i:8;s:14:\"more_available\";}', '_stripe_onl_, _btc_, _eth_, _more_available_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_', '_nokia_, _xiaomi_', 100, 12, '_media_digital_products_', '27', '_photography_videography_', 2, '18', '_drone_photos_videos_', '', '', 1, 60.2512, 24.0675, 120, 480, 0, 0),
(464, '7', 'mj.ilm@pm.me', '', '', 'Verkkosivujen kehitystä tarpeisiisi', 'Kauttamme saat toimivat verkkosivut niin uudelle ideallesi kuin jo olemassa olevalle liiketoiminnallesi. Toteutamme sivuston käyttöliittymäsuunnittelun ja ohjelmoinnin sekä autamme sinut alkuun sivuston ylläpidossa. Toki myös ylläpito onnistuu toimestamme tarpeitasi vastaavasti. Tekijänä toimii mm. Serlog.me -sivuston suunnitellut ja ohjelmoinut Marko Ilmari.', '2021-10-16 10:27:00', 1634372820, '2021-10-16 10:27:00', 1634372820, 'Lohja, Finland', 'a:9:{i:0;s:4:\"iban\";i:1;s:4:\"cash\";i:2;s:3:\"btc\";i:3;s:3:\"eth\";i:4;s:4:\"doge\";i:5;s:3:\"ltc\";i:6;s:6:\"paypal\";i:7;s:10:\"mobile_pay\";i:8;s:14:\"more_available\";}', '_credit_debit_, _mobile_payments_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_', '_samsung_, _apple_', 100, 1, '_it_', '3', '_programming_development_', 3, '1', '_web_development_', '', '', 1, 60.2512, 24.0675, 1500, 8000, 0, 0),
(465, '7', 'mj.ilm@pm.me', '', '', 'Mikroskooppikuvausta Suomessa', 'Oletko koskaan miettinyt, miltä lempiesineesi, tai -keräilykohteesi pinta näyttää erittäin läheltä tarkasteltuna?\r\n\r\nMikroskooppikuvan tarkkuus alkaa siitä, mihin teräväpiirtokameran tarkkuus loppuu. Kauttamme saat kohteestasi jopa 20-300 x suurennokset digitaalisten kuvien, tai videoiden muodossa. Kerro toiveesi ja lähetä kuvattava kohteesi meille, niin kuvaamme sen ja lähetämme kohteen takaisin sinulle. Kuvat ja videot lähetämme sinulle sähköisesti. \r\n\r\nToimimme myös paikallisesti Lohjalla. Voit tuoda kohteesi meille ja vaikuttaa kuvaukseen paikan päällä. Tällöin kuvauksen hinta laskee postituksen verran.\r\n\r\nLaatu: Aivan solutasolle mikroskooppimme ei sentään ulotu, mutta esimerkiksi kaiverrukset, postimerkit, arvokolikot ja muut mielenkiintoiset kohteet sillä saa kuvattua varmasti riittävän tarkasti.', '2021-10-16 10:56:00', 1634374560, '2021-10-16 10:56:00', 1634374560, 'Lohja, Finland', 'a:9:{i:0;s:4:\"iban\";i:1;s:4:\"cash\";i:2;s:3:\"btc\";i:3;s:3:\"eth\";i:4;s:4:\"doge\";i:5;s:3:\"ltc\";i:6;s:6:\"paypal\";i:7;s:10:\"mobile_pay\";i:8;s:14:\"more_available\";}', '_btc_, _eth_, _doge_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_', '_samsung_, _xiaomi_', 0, 12, '_media_digital_products_', '27', '_photography_videography_', 4, '21', '_microscope_photography_', '', '', 1, 60.2512, 24.0675, 100, 120, 0, 0),
(466, '13', 'mj.ilm@pm.me', '', 'https://www.binance.com/en/register?ref=20286865', 'Binance', 'Binance is the leading cryptocurrency exchange that provides a variety of tools for investing, exchanging and trading cryptocurrencies. New currencies, including fiat-backed stablecoins are added frequently. Binance also offers ways to earn interest with your savings. If you haven&#39;t registered already, we highly recommend you to do so via the link below.', '2021-10-17 21:01:00', 1634497260, '2021-10-17 21:01:00', 1634497260, 'Brooklyn, NY', 'a:4:{i:0;s:10:\"stripe_onl\";i:1;s:3:\"btc\";i:2;s:3:\"eth\";i:3;s:14:\"more_available\";}', '_btc_gold_loc_', 'a:1:{i:0;s:6:\"online\";}', '_locally_', '_nokia_', 0, 19, '_money_finance_', '41', '_investing_saving_', 5, '25', '_cryptocurrencies_', '', '', 1, 40.6744, -73.9468, 0, 0, 0, 0),
(482, '7', '', '', '', 'Kuljetuspalvelu Kovala', 'Kuljetuspalvelu tarjoaa asiakkailleen henkilökohtaista ja luotettavaa kuljetusratkaisua erilaisiin tarpeisiin. Voimme tarjota kuljetuspalvelua niin yksityishenkilöille kuin yrityksillekin. Kulkuneuvoina meillä on monipuolinen valikoima erikokoisia autoja, jotta löydämme juuri sinun tarpeisiisi sopivan vaihtoehdon.', '2022-04-17 21:59:00', 1650225540, '2022-04-17 21:59:00', 1650225540, '', 'a:2:{i:0;s:12:\"credit_debit\";i:1;s:15:\"mobile_payments\";}', '_credit_debit_, _mobile_payments_', 'a:1:{i:0;s:6:\"online\";}', '_online_, _locally_', '_samsung_, _nokia_', 0, 1, '_it_', '3', '_programming_development_', 5, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(486, '7', '', '', '', 'Palvelu 88208393', '', '2022-04-20 16:05:00', 1650463500, '2022-04-20 16:05:00', 1650463500, '', '', '_iban_, _ltc_, _doge_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_, _locally_', '_samsung_', 0, 1, '_it_', '3', '_programming_development_', 6, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(487, '7', '', '', '', 'Palvelu 208679451', '', '2022-04-20 16:05:00', 1650463500, '2022-04-20 16:05:00', 1650463500, '', '', '_ltc_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_, _locally_', '_nokia_', 0, 1, '_it_', '3', '_programming_development_', 7, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(488, '7', '', '', '', 'Palvelu 583943948', '', '2022-04-20 16:06:00', 1650463560, '2022-04-20 16:06:00', 1650463560, '', '', '_iban_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_, _locally_', '_xiaomi_, _apple_', 0, 1, '_it_', '3', '_programming_development_', 8, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(489, '7', '', '', '', 'Palvelu 751255220', '', '2022-04-20 16:06:00', 1650463560, '2022-04-20 16:06:00', 1650463560, '', '', '_eth_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_', '_apple_', 0, 1, '_it_', '3', '_programming_development_', 9, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(490, '7', '', '', '', 'Palvelu 1620718009', '', '2022-04-20 16:07:00', 1650463620, '2022-04-20 16:07:00', 1650463620, '', '', '_btc_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_, _locally_', '_apple_', 0, 1, '_it_', '3', '_programming_development_', 10, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(491, '7', '', '', '', 'Palvelu 1164162576', '', '2022-04-20 16:07:00', 1650463620, '2022-04-20 16:07:00', 1650463620, '', '', '_cash_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_, _locally_', '_apple_', 0, 1, '_it_', '3', '_programming_development_', 11, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(492, '7', '', '', '', 'Henkilökuljetuspalvelu', 'Tarjoamme matkustajakuljetuksia, jos tarvitset kuljetusta suuremmalle ryhmälle. Olemme sitoutuneet tarjoamaan asiakkaillemme turvallisen ja mukavan matkan, ja henkilökuntamme on ammattitaitoista ja ystävällistä. Ota meihin yhteyttä ja varaa kuljetus jo tänään!', '2022-04-20 17:41:00', 1650469260, '2022-04-20 17:41:00', 1650469260, '', '', '_btc_gold_loc_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_locally_', '_huawei_, _samsung_', 0, 1, '_it_', '3', '_programming_development_', 1, '2', '_mobile_applications_', '', '', 1, 0, 0, 0, 0, 0, 0),
(493, '7', '', '', '', 'Palvelu 1798807176', '', '2022-04-20 21:57:00', 1650484620, '2022-04-20 21:57:00', 1650484620, '', '', '_btc_gold_loc_, _btc_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_locally_', '_xiaomi_', 0, 16, '_lifestyle_wealth_', '39', '_coaching_consultancy_', 2, '22', '_life_coaching_', '', '', 1, 0, 0, 10, 22, 0, 0),
(494, '7', '', '', '', 'NFT creation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2022-04-24 14:59:00', 1650805140, '2022-04-24 14:59:00', 1650805140, 'Jyväskylä, Finland', 'a:3:{i:0;s:3:\"btc\";i:1;s:3:\"eth\";i:2;s:4:\"doge\";}', '_iban_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_, _locally_', '_nokia_, _apple_', 66, 17, '_art_', '37', '_visualarts_', 3, '19', '_nft_collections_', '', '', 1, 62.2426, 25.7473, 0, 0, 0, 0),
(495, '7', '', '', '', 'Palvelu 1291100711', '', '2022-04-24 15:08:00', 1650805680, '2022-04-24 15:08:00', 1650805680, 'Karjalohja, Finland', 'a:3:{i:0;s:3:\"btc\";i:1;s:3:\"eth\";i:2;s:4:\"doge\";}', '_cash_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_', '_samsung_, _apple_', 88, 12, '_media_digital_products_', '27', '_photography_videography_', 4, '20', '_photography_', '', '', 1, 60.2402, 23.7179, 0, 0, 0, 0),
(497, '7', '', '', '', 'Graphical design', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2022-04-24 19:05:00', 1650819900, '2022-04-24 19:05:00', 1650819900, 'London, UK', '', '_paypal_', 'a:1:{i:0;s:7:\"locally\";}', '_online_', '_huawei_, _xiaomi_', 100, 17, '_art_', '37', '_visualarts_', 5, '19', '_nft_collections_', '', '', 1, 51.5072, -0.1276, 0, 0, 0, 0),
(498, '7', '155334028mail@mail.co', '', '', 'Autokorjaamo Räsä', 'Test Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2022-04-25 13:13:00', 1650885180, '2022-04-25 13:13:00', 1650885180, 'Detroit', 'a:1:{i:0;s:12:\"btc_gold_loc\";}', '_eth_, _more_available_, _credit_debit_', 'a:1:{i:0;s:7:\"locally\";}', '_online_, _locally_', '_xiaomi_, _nokia_', 552, 1, '_it_', '3', '_programming_development_', 6, '1', '_web_development_', '', '', 1, 0, 0, 22, 22, 0, 0),
(517, '7', '812552628mail@mail.co', '', 'serlog.com/', 'Koodauspalvelu', 'Ohjelmointipalvelumme tarjoaa ammattitaitoista ohjelmointia erilaisiin tarpeisiin. Voimme auttaa yrityksiä kehittämään ohjelmistoja ja sähköisiä palveluita, sekä tarjota ohjelmointipalveluja yksityishenkilöille esimerkiksi verkkosivujen tai sovellusten kehittämiseen. Henkilökuntamme koostuu kokeneista ja osaavista ohjelmoijista, jotka ovat valmiita auttamaan sinua saavuttamaan tavoitteesi. Ota yhteyttä ja kysy lisää ohjelmointipalveluistamme!', '2022-04-28 08:54:00', 1651128948, '2022-04-28 08:54:00', 1651128948, '', 'a:5:{i:0;s:12:\"credit_debit\";i:1;s:15:\"mobile_payments\";i:2;s:4:\"iban\";i:3;s:4:\"cash\";i:4;s:6:\"paypal\";}', '_stripe_onl_, _btc_', 'a:2:{i:0;s:6:\"online\";i:1;s:7:\"locally\";}', '_online_', '_nokia_', 33, 1, '_it_', '3', '_programming_development_', 13, '4', '_cryptocurrencies_blockchain_', '', '', 1, 0, 0, 120, 30000, 0, 90),
(520, '7', '', '', '', 'Kahvihuone Kaninkulma', 'Kahvilamme tarjoaa laajan valikoiman herkullisia kahveja, teetä sekä makeita ja suolaisia leivonnaisia. Henkilökuntamme on iloista ja palvelevaa, ja kahvilassamme on viihtyisä ja rento ilmapiiri. Tervetuloa nauttimaan kahvilaamme!', '2022-05-14 16:17:00', 1652537860, '2022-05-14 16:17:00', 1652537860, '', 'a:3:{i:0;s:6:\"paypal\";i:1;s:10:\"mobile_pay\";i:2;s:14:\"more_available\";}', '_doge_, _ltc_, _paypal_, _mobile_pay_, _more_available_, _stripe_onl_, _btc_, _eth_', '', '_online_', '_nokia_', 0, 1, '_it_', '3', '_programming_development_', 12, '1', '_web_development_', '', '', 1, 0, 0, 50, 5500, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services_childs`
--

CREATE TABLE `services_childs` (
  `ID` int(24) UNSIGNED NOT NULL,
  `par_srv_id` int(11) DEFAULT NULL,
  `pars_child_number` int(11) DEFAULT NULL,
  `child_title` varchar(255) DEFAULT NULL,
  `child_desc` varchar(5000) DEFAULT NULL,
  `child_delivery_time_from` int(11) DEFAULT NULL,
  `child_delivery_time_to` int(11) DEFAULT NULL,
  `child_price` int(11) DEFAULT NULL,
  `child_price_spec` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_childs`
--

INSERT INTO `services_childs` (`ID`, `par_srv_id`, `pars_child_number`, `child_title`, `child_desc`, `child_delivery_time_from`, `child_delivery_time_to`, `child_price`, `child_price_spec`) VALUES
(183, 460, 0, 'Yleishyödyllinen uutisartikkeli haluamastasi kryptoaiheesta', 'Julkaisemme sivustollamme haluamasi kryptoaiheisen uutisen. Voimme haastatella sinua, suomentaa uutisen, tai kirjoittaa sen antamiesi tietojen perusteella. Aiheen ollessa yleishyödyllinen, kuten uuden uuden open source -projektin esittely, emme peri artikkelin luomisesta maksua.', 0, 3, 0, ''),
(184, 460, 0, 'Sponsoroitu uutisartikkeli haluamastasi kryptoaiheesta', 'Julkaisemme sivustollamme haluamasi kryptoaiheisen uutisen. Voimme haastatella sinua, suomentaa uutisen, tai kirjoittaa sen antamiesi tietojen perusteella. Aiheen ollessa sponsoroitu, kuten esim. kryptoaiheisen yrityksesi esittely, tuotamme artikkelin sinulle kilpailukykyiseen hintaan. \r\n\r\nMeiltä onnistuu niin lyhyiden kuin laajojenkin esittelyjen teko. Nopeimmillaan artikkeli valmistuu yhdessä tunnissa, joskin myös huomattavasti laajemmat esittelyt ovat kauttamme mahdollisia.', 0, 7, 120, ''),
(190, 463, 0, 'Dronekuvaus kohteestasi, tuntihinta', 'Kuvaamme kohdettasi noin tunnin ajan eri kulmista. Tiedostomuotoina ovat 48 MP valokuvat ja 4K-videot. Voit myös itse kertoa, mistä kulmista haluat kohdettasi kuvattavan.', 0, 4, 120, ''),
(191, 463, 0, 'Matkakorvaus, tuntihinta', 'Matkakulu lyhyemmille kuvauksille', 0, 4, 120, ''),
(192, 463, 0, 'Matkakorvaus, päivähinta', 'Matkakulu yli 4 h kestäville kuvauksille', 0, 4, 480, ''),
(193, 464, 0, 'Käyttöliittymäsuunnittelu', 'Suunnittelemme sivustosi osat niin, että käyttäjä osaa varmasti navigoida siinä. Hyvänä esimerkkinä toimii juuri tämä sivu, serlog.me, jossa vasen sivupalkki ei jätä arvailun varaa siitä, missä mennään. Suunnittelu toteutetaan painike ja elementti kerrallaan, ja se kestää sivuston laajuudesta riippuen tyypillisesti noin kahdesta viikosta kuukauteen.', 7, 30, 1500, 'per viikko'),
(194, 464, 0, 'Ohjelmointi', 'Suunnittelun jälkeen vuorossa on sivuston ohjelmointi. Tämä vaihe vie vaatimustasosta riippuen n. 1-2 kk. Ohjelmoinnin kesto sovitaan etukäteen, jolloin myös projektin hinta on tiedossa ennen aloittamista.', 7, 60, 8000, 'per kk'),
(195, 465, 0, 'Kuvaustyö, sisältää toimitukset', 'Saatuamme kohteesi kuvaamme sen digitaalisella mikroskoopilla, postitamme kohteen sinulle takaisin kirjattuna lähetyksenä ja lähetämme kuvat sähköisesti. Kuvauksessa menee toimituksineen noin reilu tunti. Toteutamme kuvauksen täysin toiveitasi kuunnellen. Mikäli sinulla ei ole erityistoiveita, kuvaus kattaa 30 tarkkaa mikroskooppikuvaa ja 10 minuuttia videota kohteestasi. Halutessasi voit antaa kuvattavaksi myös useampia kohteita.', 0, 7, 120, 'per kuvaus'),
(196, 465, 0, 'Kuvaustyö paikallisesti Lohjalla', 'Tämä työ suoritetaan paikallisesti ollessasi läsnä kuvauspaikalla. Kuvaamme kohteesi digitaalisella mikroskoopilla ja annamme kuvamateriaalin sinulle. Kuvauksessa menee paikallisesti tehtynä vajaa tunti. Toteutamme kuvauksen täysin toiveitasi kuunnellen. Mikäli sinulla ei ole erityistoiveita, kuvaus kattaa 30 tarkkaa mikroskooppikuvaa ja 10 minuuttia videota kohteestasi. Halutessasi voit antaa kuvattavaksi myös useampia kohteita.', 0, 7, 100, 'per kuvaus'),
(197, 492, 0, 'Kilometrihinta', '', 0, 0, 22, ''),
(198, 492, 0, 'Keikkapalkkio', '', 0, 0, 10, ''),
(199, 493, 0, 'Kilometrihinta', '', 0, 0, 22, ''),
(200, 493, 0, 'Keikkapalkkio', '', 0, 0, 10, ''),
(201, 497, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor i', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0, 0, ''),
(202, 498, 0, 'tt', 'tt', 22, 23, 22, ''),
(252, 517, 0, 'Koodaus, tuntihinta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 7, 120, 'per hour'),
(253, 517, 0, 'Kootiprojekti', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 7, 90, 30000, ''),
(256, 520, 0, 'Verkkosivujen ohjelmointi, tuntihinta', 'Kielet: HTML, SASS, JavaScript, jQuery, PHP, MySQL', 1, 1, 50, ''),
(257, 520, 0, 'Verkkosivujen ohjelmointi, kuukausihinta', 'Kielet: HTML, SASS, JavaScript, jQuery, PHP, MySQL', 1, 1, 5500, '');

-- --------------------------------------------------------

--
-- Table structure for table `teeest`
--

CREATE TABLE `teeest` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `treeview_items`
--

CREATE TABLE `treeview_items` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `text` varchar(200) NOT NULL,
  `parent_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `treeview_items`
--

INSERT INTO `treeview_items` (`id`, `name`, `text`, `parent_id`) VALUES
(1, 'task1', 'task1 title', '0'),
(2, 'task1', 'task2 title', '0'),
(3, 'task3', 'task3 title', '0'),
(4, 'task4', 'task4 title', '3'),
(5, 'task5', 'task5 title', '3'),
(6, 'task6', 'task6 title', '5'),
(7, 'task7', 'task7 title', '2'),
(8, 'task8', 'task8 title', '2'),
(9, 'task9', 'task9 title', '1'),
(10, 'task10', 'task10 tite', '5'),
(11, 'task11', 'task11 title', '3'),
(12, 'task12', 'task12 tile', '6'),
(13, 'task13', 'task13 title', '12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `private_email` varchar(100) NOT NULL,
  `activation_code` varchar(50) NOT NULL DEFAULT '',
  `rememberme` varchar(255) NOT NULL DEFAULT '',
  `role` enum('Member','Admin') NOT NULL DEFAULT 'Member',
  `theme` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `public_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `private_email`, `activation_code`, `rememberme`, `role`, `theme`, `language`, `created`, `public_email`) VALUES
(2, 'member', '$2y$10$7vKi0TjZimZyp/S5aCtK0eLsGagyIJVfpzGSFgRSqDGkJMxqoIYV.', 'member@example.com', 'activated', '', 'Member', 'blue', 'en', '2021-10-10', ''),
(7, 'admin', '$2y$10$B4rPE9BvYfuSG6gIorZ.AOqtOKmk/0d6SmiQ6ZK6./Q/vE9dVPB9C', 'admin@example.com', 'activated', '$2y$10$FIfKpMN5EGDBVjCWe8ZCKuswPrMlgLu02CISdpO3d8Xr8m8b4sEeC', 'Admin', 'blue', 'en', '2021-10-10', ''),
(13, 'serlog_referral', '', '', '', '', 'Member', '', '', '2021-10-21', ''),
(14, 'kryptouutiset', '$2y$10$qWZrGFPw2Q6y3dlmoqkT0O5MrORhrFKiPHjWOB666SV9WkJ6jlU36', 'admin@kryptouutiset.net', 'activated', '', 'Admin', 'blue', '', '2021-10-17', ''),
(17, 'admin2', '$2y$10$vPRZxwTmI4zlByxAddqdeOYt2R2jKYZRab.x8/wbwgDNbRupGWsPa', 'marko.ilmari324@gmail.com', '6280b0ea7d578', '', 'Member', '', '', '2022-05-15', '');

-- --------------------------------------------------------

--
-- Table structure for table `view_counter`
--

CREATE TABLE `view_counter` (
  `id` int(11) NOT NULL,
  `srv_id` int(20) NOT NULL,
  `viewer_id` int(11) DEFAULT NULL,
  `ip` varchar(46) NOT NULL,
  `count` int(20) NOT NULL,
  `last_viewed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `view_counter`
--

INSERT INTO `view_counter` (`id`, `srv_id`, `viewer_id`, `ip`, `count`, `last_viewed`) VALUES
(195, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:13:09'),
(196, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:13:48'),
(197, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:20:12'),
(198, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:24:40'),
(199, 460, 7, '127.0.0.1', 118, '2022-06-14 12:44:05'),
(200, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:25:43'),
(201, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:26:02'),
(202, 460, 8, '44.122.111.232', 1, '2021-10-15 19:26:03'),
(203, 460, NULL, '44.122.111.232', 1, '2021-10-15 19:26:04'),
(204, 460, NULL, '44.122.111.232', 11, '2021-10-15 19:29:56'),
(214, 460, 8, '44.154.11.122', 1, '2021-10-15 20:11:16'),
(221, 460, 8, '44.154.11.112', 1, '2021-10-15 20:30:18'),
(222, 460, 8, '44.154.11.112', 1, '2021-10-15 20:30:23'),
(223, 460, 8, '44.154.11.112', 1, '2021-10-15 20:30:24'),
(224, 460, 8, '44.154.11.112', 1, '2021-10-15 20:30:49'),
(225, 460, 8, '44.154.11.112', 1, '2021-10-15 20:30:51'),
(226, 460, 8, '44.154.11.12', 19, '2021-10-15 21:57:10'),
(234, 461, NULL, '44.154.11.12', 1, '2021-10-16 05:54:39'),
(235, 463, 5, '44.154.11.12', 45, '2021-11-23 12:07:28'),
(236, 465, 5, '44.154.11.12', 25, '2021-11-23 12:05:14'),
(237, 460, 5, '44.154.11.12', 115, '2021-10-21 10:33:55'),
(238, 466, 5, '44.154.11.12', 64, '2021-10-21 10:25:56'),
(239, 461, 5, '44.154.11.12', 65, '2021-10-21 02:24:51'),
(240, 464, 5, '44.154.11.12', 46, '2021-11-23 12:07:43'),
(241, 470, NULL, '44.154.11.12', 1, '2021-10-21 10:30:03'),
(242, 463, NULL, '127.0.0.1', 3, '2021-10-21 13:26:04'),
(243, 463, NULL, '127.0.0.1', 1, '2021-10-21 15:30:03'),
(244, 463, 7, '::1', 1251, '2022-07-11 14:27:06'),
(245, 465, 7, '::1', 312, '2021-11-22 15:18:53'),
(246, 464, 7, '::1', 645, '2022-04-24 19:52:03'),
(247, 471, 7, '::1', 135, '2022-04-13 09:53:19'),
(248, 472, 7, '::1', 99, '2021-11-22 15:19:38'),
(249, 466, 7, '127.0.0.1', 149, '2022-04-20 13:14:23'),
(250, 0, 7, '127.0.0.1', 202, '2021-10-27 07:21:51'),
(251, 463, NULL, '::1', 3, '2021-11-10 13:03:52'),
(252, 471, NULL, '::1', 3, '2021-11-10 13:14:34'),
(253, 472, NULL, '::1', 3, '2021-11-10 13:14:57'),
(254, 466, NULL, '::1', 4, '2021-11-10 13:14:56'),
(255, 460, NULL, '::1', 2, '2021-11-10 13:14:56'),
(256, 463, NULL, '127.0.0.1', 1, '2021-11-13 18:13:40'),
(257, 464, NULL, '127.0.0.1', 1, '2021-11-13 18:14:13'),
(258, 472, 5, '44.154.11.12', 1, '2021-11-23 12:05:08'),
(259, 471, 5, '44.154.11.12', 1, '2021-11-23 12:05:18'),
(260, 482, NULL, '::1', 2, '2022-04-18 12:28:01'),
(261, 464, NULL, '::1', 1, '2022-04-18 12:27:52'),
(262, 482, NULL, '127.0.0.1', 4, '2022-04-19 09:57:43'),
(263, 486, 7, '127.0.0.1', 3, '2022-04-20 13:14:22'),
(264, 487, 7, '127.0.0.1', 3, '2022-04-20 13:14:23'),
(265, 482, 7, '127.0.0.1', 10, '2022-04-25 21:47:42'),
(266, 492, 7, '127.0.0.1', 4, '2022-04-21 09:41:42'),
(267, 493, 7, '::1', 3, '2022-04-25 09:08:19'),
(268, 460, NULL, '127.0.0.1', 6, '2022-04-20 21:44:28'),
(269, 465, NULL, '127.0.0.1', 2, '2022-04-20 19:35:02'),
(270, 14, NULL, '127.0.0.1', 6, '2022-04-20 21:30:55'),
(271, 7, NULL, '127.0.0.1', 2, '2022-04-20 21:30:57'),
(272, 494, 7, '::1', 6, '2022-07-11 14:19:22'),
(273, 495, 7, '127.0.0.1', 5, '2022-04-28 04:37:05'),
(274, 460, NULL, '::1', 1, '2022-04-24 12:57:07'),
(275, 465, NULL, '::1', 1, '2022-04-24 12:57:13'),
(276, 496, 7, '::1', 1, '2022-04-24 17:04:50'),
(277, 497, 7, '127.0.0.1', 15, '2022-04-28 04:36:53'),
(278, 498, 7, '127.0.0.1', 11, '2022-05-03 17:46:38'),
(279, 514, 7, '127.0.0.1', 1, '2022-04-25 16:47:25'),
(280, 515, 7, '127.0.0.1', 3, '2022-04-26 23:34:03'),
(281, 516, 7, '127.0.0.1', 8, '2022-04-28 04:18:47'),
(282, 517, 7, '127.0.0.1', 25, '2022-09-18 23:13:50'),
(285, 512, NULL, '127.0.0.1', 1, '2022-04-28 05:36:27'),
(286, 511, NULL, '127.0.0.1', 1, '2022-04-28 05:36:34'),
(287, 510, NULL, '127.0.0.1', 1, '2022-04-28 05:36:38'),
(288, 496, NULL, '127.0.0.1', 1, '2022-04-28 05:36:44'),
(289, 517, 2, '127.0.0.1', 7, '2022-05-13 08:39:37'),
(290, 520, 7, '127.0.0.1', 1, '2022-05-14 14:40:08'),
(291, 463, NULL, '127.0.0.1', 1, '2022-07-04 14:58:22'),
(292, 517, NULL, '127.0.0.1', 10, '2022-07-11 20:19:39'),
(293, 492, NULL, '127.0.0.1', 1, '2022-07-23 11:46:56'),
(294, 482, NULL, '127.0.0.1', 3, '2022-12-28 20:20:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat1_industries`
--
ALTER TABLE `cat1_industries`
  ADD PRIMARY KEY (`ind_id`);

--
-- Indexes for table `cat2_categories`
--
ALTER TABLE `cat2_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `cat3_subcat`
--
ALTER TABLE `cat3_subcat`
  ADD PRIMARY KEY (`sc_id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_mainpics`
--
ALTER TABLE `media_mainpics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_originals`
--
ALTER TABLE `media_originals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_childs`
--
ALTER TABLE `services_childs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `treeview_items`
--
ALTER TABLE `treeview_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `view_counter`
--
ALTER TABLE `view_counter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat1_industries`
--
ALTER TABLE `cat1_industries`
  MODIFY `ind_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cat2_categories`
--
ALTER TABLE `cat2_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cat3_subcat`
--
ALTER TABLE `cat3_subcat`
  MODIFY `sc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `media_mainpics`
--
ALTER TABLE `media_mainpics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `media_originals`
--
ALTER TABLE `media_originals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=546;

--
-- AUTO_INCREMENT for table `services_childs`
--
ALTER TABLE `services_childs`
  MODIFY `ID` int(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `treeview_items`
--
ALTER TABLE `treeview_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `view_counter`
--
ALTER TABLE `view_counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
