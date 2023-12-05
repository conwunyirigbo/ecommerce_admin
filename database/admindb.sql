-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 06:59 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `position` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `photo` varchar(1000) NOT NULL,
  `phototitle` varchar(600) NOT NULL,
  `showbutton` tinyint(1) NOT NULL,
  `buttontext` varchar(255) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `bannerorder` int(2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `category` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `position`, `size`, `photo`, `phototitle`, `showbutton`, `buttontext`, `url`, `bannerorder`, `status`, `date_created`, `category`) VALUES
(7, '', 'bottom_position', '2 x 750 x 360px', '7.jpg', 'bakan-gizo-mega-sale', 0, '', 'shop', 1, 1, '25-04-2020 22:51 PM', 0),
(14, 'Weekly flash sales', 'middle_position', '1 x 1200 x 200px', 'Weekly-flash-sales14.jpg', 'supermart ad', 0, '', '#', 2, 1, '01-06-2020 18:48 PM', 0),
(16, '', 'below_slider_position', '3 x 600 x 350px', '16.jpg', '', 0, '', '', 2, 1, '02-06-2020 13:44 PM', 0),
(17, '', 'below_slider_position', '3 x 600 x 350px', '17.jpg', '', 0, '', '', 1, 1, '02-06-2020 13:46 PM', 0),
(21, '', 'bottom_position', '2 x 750 x 360px', '21.jpg', 'health', 0, '', '', 2, 1, '02-06-2020 14:12 PM', 0),
(22, '', 'below_slider_position', '3 x 600 x 350px', '22.jpg', 'Frozen Section', 0, '', '', 2, 1, '24-06-2020 21:05 PM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `logo` varchar(600) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `api_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `code`, `status`, `logo`, `date_created`, `api_id`) VALUES
(1, 'Johnsons', 'Johnsons', 1, '', '11-09-2023 00:51 AM', 0),
(2, 'itel', 'Itel', 1, '', '11-09-2023 10:18 AM', 0),
(3, 'Apple', 'apple', 1, '', '11-09-2023 10:50 AM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cart_session_id` varchar(50) NOT NULL,
  `productid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `quantity` int(4) NOT NULL,
  `sizeid` int(6) NOT NULL,
  `colourid` int(6) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `note` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `cart_session_id`, `productid`, `userid`, `quantity`, `sizeid`, `colourid`, `price`, `note`) VALUES
(1, '148503', 1131, 0, 1, 0, 0, '5060.00', ''),
(2, '294463', 1134, 0, 1, 0, 0, '1029999.00', ''),
(3, '267512', 1126, 0, 1, 0, 0, '1350.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `show_home` tinyint(1) NOT NULL,
  `show_menu` tinyint(1) NOT NULL,
  `categoryorder` int(3) NOT NULL,
  `api_id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_restaurant` tinyint(1) NOT NULL,
  `description` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `code`, `status`, `date_created`, `type`, `show_home`, `show_menu`, `categoryorder`, `api_id`, `icon`, `photo`, `is_restaurant`, `description`) VALUES
(1, 'Appliances', 'appliances', 1, '27-08-2023 19:47 PM', 'topmenu', 0, 0, 2, 0, 'ti-desktop', NULL, 0, ''),
(2, 'Baby and Mothers', 'baby-and-mothers', 1, '27-08-2023 19:57 PM', 'topmenu', 1, 0, 2, 0, 'ti-comments-smiley', NULL, 0, ''),
(3, 'Beauty', 'beauty', 1, '27-08-2023 19:58 PM', 'topmenu', 0, 0, 6, 0, 'ti-face-smile', NULL, 0, ''),
(4, 'Phones and Accessories', 'phones-and-accessories', 1, '09-09-2023 00:41 AM', 'topmenu', 1, 0, 4, 0, 'ti-mobile', NULL, 0, ''),
(5, 'Fashion', 'fashion', 1, '09-09-2023 00:42 AM', 'topmenu', 0, 0, 5, 0, 'ti-bag', NULL, 0, ''),
(7, 'Health and Personal Care', 'health-and-personal-care', 1, '09-09-2023 00:47 AM', 'topmenu', 0, 0, 7, 0, 'ti-shield', NULL, 0, ''),
(8, 'Home and Office', 'home-and-office', 1, '09-09-2023 00:48 AM', 'topmenu', 0, 0, 7, 0, 'ti-pencil-alt', NULL, 0, ''),
(9, 'Supermarket', 'supermarket', 1, '09-09-2023 00:49 AM', 'topmenu', 1, 0, 1, 0, 'ti-shopping-cart', NULL, 0, ''),
(10, 'Food Items', 'food-items', 1, '09-09-2023 00:51 AM', 'topmenu', 0, 0, 9, 0, 'ti-bag', NULL, 0, ''),
(11, 'Grocery, Household Essentials & Pet', 'grocery-household-essentials--pet', 1, '09-09-2023 00:52 AM', 'topmenu', 0, 0, 10, 0, 'ti-shopping-cart-full', NULL, 0, ''),
(12, 'Computers and Computer Accessories', 'computers-and-computer-accessories', 1, '09-09-2023 00:53 AM', 'topmenu', 0, 0, 11, 0, 'ti-desktop', NULL, 0, ''),
(13, 'Supermart', 'supermart', 1, '09-09-2023 00:58 AM', 'master', 0, 1, 1, 0, '', NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `stateid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `stateid`, `name`, `status`) VALUES
(1, 1, 'Aba-Abayi', 1),
(2, 1, 'Aba-Ariaria', 1),
(3, 1, 'Aba-Asa Road', 1),
(4, 1, 'Aba-Cemetry Road B', 1),
(5, 1, 'Aba-Ehere', 1),
(6, 1, 'Aba-Eziukwu Road', 1),
(7, 1, 'Aba-Faulks Road', 1),
(8, 1, 'Aba-Hospital Road', 1),
(9, 1, 'Aba-Ikot Ekpene Road', 1),
(10, 1, 'Aba-Ngwa Road', 1),
(11, 1, 'Aba-Obehie', 1),
(12, 1, 'Aba-Ogbor Hill', 1),
(13, 1, 'Aba-Okigwe Road', 1),
(14, 1, 'Aba-Opobo Rd', 1),
(15, 1, 'Aba-Osusu Road', 1),
(16, 1, 'Aba-Owerri Road', 1),
(17, 1, 'Aba-Portharcourt Road', 1),
(18, 1, 'Aba-Saint Michael\'s Road', 1),
(19, 1, 'Aba-Umu Mba', 1),
(20, 1, 'Aba-Umu Ohia', 1),
(21, 1, 'Aba-Umu Okahia', 1),
(22, 1, 'Aba-World Bank Estate', 1),
(23, 1, 'Amaeke', 1),
(24, 1, 'Arochukwu', 1),
(25, 1, 'IKWUANO', 1),
(26, 1, 'Ohafia', 1),
(27, 1, 'Umuahia-Aba road', 1),
(28, 1, 'Umuahia-Afara Road', 1),
(29, 1, 'Umuahia-Agbama Estate', 1),
(30, 1, 'Umuahia-Azikiwe Road', 1),
(31, 1, 'Umuahia-Bende Road', 1),
(32, 1, 'Umuahia-Enugu Road', 1),
(33, 1, 'Umuahia-Library Avenue', 1),
(34, 1, 'Umuahia-Mission Road', 1),
(35, 1, 'Umuahia-Niger Road', 1),
(36, 1, 'Umuahia-Owerri Road', 1),
(37, 1, 'Umuahia-School Road', 1),
(38, 1, 'Umuahia-Secretariat Area', 1),
(39, 1, 'Umuahia-Uwalaka Road', 1),
(40, 1, 'Umuahia-Uzoakoli Road', 1),
(41, 1, 'Umuahia-Worldbank Estate', 1),
(42, 1, 'UMUDIKE', 1),
(43, 2, 'GOMBI', 1),
(44, 2, 'HONG', 1),
(45, 2, 'MAYO BELWA', 1),
(46, 2, 'MUBI', 1),
(47, 2, 'NGURORE', 1),
(48, 2, 'NUMAN', 1),
(49, 2, 'SONG', 1),
(50, 2, 'YOLA-CENTRAL LOCATIONS', 1),
(51, 15, 'ABUJA AIRPORT ROAD- RIVERPARK /TRADEMORE', 1),
(52, 15, 'ABUJA AIRPORT ROAD- SAUKA/IMMIGRATION HQ', 1),
(53, 15, 'ABUJA- APO CENTRAL', 1),
(54, 15, 'ABUJA- APO LEGISLATIVE ZONE A', 1),
(55, 15, 'ABUJA- APO LEGISLATIVE ZONE B', 1),
(56, 15, 'ABUJA- APO LEGISLATIVE ZONE C', 1),
(57, 15, 'ABUJA- APO LEGISLATIVE ZONE D', 1),
(58, 15, 'ABUJA- APO LEGISLATIVE ZONE E', 1),
(59, 15, 'ABUJA- APO MECHANIC VILLAGE', 1),
(60, 15, 'ABUJA- APO RESETTLEMENT ZONE A', 1),
(61, 15, 'ABUJA- APO RESETTLEMENT ZONE B', 1),
(62, 15, 'ABUJA- APO RESETTLEMENT ZONE C', 1),
(63, 15, 'ABUJA- APO RESETTLEMENT ZONE D', 1),
(64, 15, 'ABUJA- APO RESETTLEMENT ZONE E', 1),
(65, 15, 'ABUJA- DURUMI', 1),
(66, 15, 'ABUJA- DURUMI PHASE 2', 1),
(67, 15, 'ABUJA- GARKI AREA 1', 1),
(68, 15, 'ABUJA- GARKI AREA 10', 1),
(69, 15, 'ABUJA- GARKI AREA 11', 1),
(70, 15, 'ABUJA- GARKI AREA 2', 1),
(71, 15, 'ABUJA- GARKI AREA 3', 1),
(72, 15, 'ABUJA- GARKI AREA 7', 1),
(73, 15, 'ABUJA- GARKI AREA 8', 1),
(74, 15, 'ABUJA- GWARINPA 1ST AVENUE', 1),
(75, 15, 'ABUJA- GWARINPA 2ND AVENUE', 1),
(76, 15, 'ABUJA- GWARINPA 3RD AVENUE', 1),
(77, 15, 'ABUJA- GWARINPA 4TH AVENUE', 1),
(78, 15, 'ABUJA- GWARINPA 5TH AVENUE', 1),
(79, 15, 'ABUJA- GWARINPA 6TH AVENUE', 1),
(80, 15, 'ABUJA- GWARINPA 7TH AVENUE', 1),
(81, 15, 'ABUJA- GWARINPA EXTENSION', 1),
(82, 15, 'ABUJA- KATAMPE EXTENSION', 1),
(83, 15, 'ABUJA- KATAMPE MAIN', 1),
(84, 15, 'ABUJA- KUBWA 2/1 PHASE 1', 0),
(85, 15, 'ABUJA- KUBWA 2/2 PHASE 2', 0),
(86, 15, 'ABUJA- KUBWA ARAB ROAD', 0),
(87, 15, 'ABUJA- KUBWA BYAZHIN', 0),
(88, 15, 'ABUJA- KUBWA EXTENSION 3', 0),
(89, 15, 'ABUJA- KUBWA GBAZANGO', 0),
(90, 15, 'ABUJA- KUBWA PHASE 3', 0),
(91, 15, 'ABUJA- KUBWA PW', 0),
(92, 15, 'ABUJA- KUBWA- FCDA/FHA', 0),
(93, 15, 'ABUJA- LIFE CAMP EXTENSION', 1),
(94, 15, 'ABUJA- MABUSHI', 1),
(95, 15, 'ABUJA- MAITAMA ALEIRO', 1),
(96, 15, 'ABUJA- MAITAMA ASO DRIVE', 1),
(97, 15, 'ABUJA- MAITAMA CENTRAL', 1),
(98, 15, 'ABUJA- MAITAMA EXTENSION', 1),
(99, 15, 'ABUJA- ZUBA', 0),
(100, 15, 'ABUJA-ASOKORO', 1),
(101, 15, 'ABUJA-BWARI', 0),
(102, 15, 'Abuja-Central', 1),
(103, 15, 'Abuja-Dakibiyu', 1),
(104, 15, 'ABUJA-DAWAKI', 1),
(105, 15, 'ABUJA-DEI-DEI', 0),
(106, 15, 'ABUJA-DUTSE', 0),
(107, 15, 'ABUJA-EFAB', 1),
(108, 15, 'ABUJA-GALADIMAWA', 1),
(109, 15, 'ABUJA-GAMES VILLAGE', 1),
(110, 15, 'ABUJA-GARKI2', 1),
(111, 15, 'ABUJA-GUDU', 1),
(112, 15, 'ABUJA-GUZAPE', 1),
(113, 15, 'ABUJA-GWAGWALADA', 0),
(114, 15, 'ABUJA-JABI', 1),
(115, 15, 'ABUJA-JAHI', 1),
(116, 15, 'ABUJA-JIKWOYI', 1),
(117, 15, 'ABUJA-KABUSA', 1),
(118, 15, 'ABUJA-KADO', 1),
(119, 15, 'ABUJA-KARIMO', 1),
(120, 15, 'ABUJA-KARU', 0),
(121, 15, 'ABUJA-KAURA DISTRICT', 1),
(122, 15, 'ABUJA-KUJE', 0),
(123, 15, 'ABUJA-KWALI', 1),
(124, 15, 'ABUJA-LIFE CAMP', 1),
(125, 15, 'ABUJA-LOKOGOMA', 1),
(126, 15, 'Abuja-Lugbe Across Zone1-9', 0),
(127, 15, 'Abuja-Lugbe Kapwa', 0),
(128, 15, 'Abuja-Lugbe MrBiggs', 0),
(129, 15, 'Abuja-Lugbe New Site', 0),
(130, 15, 'Abuja-Lugbe Peace Village', 0),
(131, 15, 'Abuja-Lugbe Police Sign Post', 0),
(132, 15, 'Abuja-Lugbe Premier Academy', 0),
(133, 15, 'Abuja-Lugbe Sector F', 0),
(134, 15, 'Abuja-Lugbe Skye Bank', 0),
(135, 15, 'Abuja-Lugbe Total', 0),
(136, 15, 'Abuja-Lugbe Tudun Wada', 0),
(137, 15, 'ABUJA-MARARABA', 0),
(138, 15, 'ABUJA-MPAPE', 0),
(139, 15, 'ABUJA-NYANYA', 0),
(140, 15, 'Abuja-Prince and Princess', 1),
(141, 15, 'ABUJA-SUNCITY', 1),
(142, 15, 'ABUJA-SUNNY VALLE', 1),
(143, 15, 'ABUJA-UTAKO', 1),
(144, 15, 'ABUJA-WUSE ZONE 1', 1),
(145, 15, 'ABUJA-WUSE ZONE 2', 1),
(146, 15, 'ABUJA-WUSE ZONE 3', 1),
(147, 15, 'ABUJA-WUSE ZONE 4', 1),
(148, 15, 'ABUJA-WUSE ZONE 5', 1),
(149, 15, 'ABUJA-WUSE ZONE 6', 1),
(150, 15, 'ABUJA-WUSE ZONE 7', 1),
(151, 15, 'ABUJA-WUSE11', 1),
(152, 15, 'Abuja-Wuye', 1),
(153, 15, 'GIDAN MANGORO', 0),
(154, 15, 'GWAGWA', 1),
(155, 15, 'GWAGWALADA', 0),
(156, 15, 'IDU', 0),
(157, 15, 'KARMO', 1),
(158, 15, 'KARSHI', 1),
(159, 15, 'KARU', 0),
(160, 15, 'MINISTERS HILL', 1),
(161, 15, 'NICON JUNCTION', 1),
(162, 15, 'SHEDA', 0),
(163, 33, 'ABHONEMA', 1),
(164, 33, 'AHOADA', 1),
(165, 33, 'AIRPORT ROAD - PORT HARCOURT', 1),
(166, 33, 'Bonny-0rosikiri', 1),
(167, 33, 'Bonny-Abalambie', 1),
(168, 33, 'Bonny-Akiama', 1),
(169, 33, 'Bonny-Asimini William Pepple', 1),
(170, 33, 'Bonny-Ayambo', 1),
(171, 33, 'Bonny-Bonny town', 1),
(172, 33, 'Bonny-Finima', 1),
(173, 33, 'Bonny-Hospital', 1),
(174, 33, 'Bonny-Iwuoma', 1),
(175, 33, 'Bonny-Macauley', 1),
(176, 33, 'Bonny-Navy', 1),
(177, 33, 'Bonny-New jerusalem', 1),
(178, 33, 'Bonny-NLNG', 1),
(179, 33, 'Bonny-NLNG RA', 1),
(180, 33, 'Bonny-Park community', 1),
(181, 33, 'Bonny-Sand field', 1),
(182, 33, 'Bonny-SDP', 1),
(183, 33, 'Bonny-Shell', 1),
(184, 33, 'ELELE', 1),
(185, 33, 'ELEME-AGBONCHIA', 1),
(186, 33, 'ELEME-AKPAJO', 1),
(187, 33, 'ELEME-ALESA', 1),
(188, 33, 'ELEME-ALETO', 1),
(189, 33, 'ELEME-ALODE', 1),
(190, 33, 'ELEME-EBUBU', 1),
(191, 33, 'ELEME-EKPORO', 1),
(192, 33, 'ELEME-ETEO', 1),
(193, 33, 'ELEME-NCHIA', 1),
(194, 33, 'ELEME-ODIDO', 1),
(195, 33, 'ELEME-OGALE', 1),
(196, 33, 'ELEME-ONNE', 1),
(197, 33, 'EMOUHA', 1),
(198, 33, 'ETCHE', 1),
(199, 33, 'ISIOKPO', 1),
(200, 33, 'OKRIKA-ABAM ? AMA II', 1),
(201, 33, 'OKRIKA-ABULOME', 1),
(202, 33, 'OKRIKA-BOLO TOWN', 1),
(203, 33, 'OKRIKA-DIKIBOAMA', 1),
(204, 33, 'OKRIKA-EKEREKANA', 1),
(205, 33, 'OKRIKA-GEORGE -AMA', 1),
(206, 33, 'OKRIKA-IBAKA', 1),
(207, 33, 'OKRIKA-IBAKA TOWN', 1),
(208, 33, 'OKRIKA-IBULUY-DIKIBOAMA', 1),
(209, 33, 'OKRIKA-IKIRIKOAMA', 1),
(210, 33, 'OKRIKA-KALIO -AMA', 1),
(211, 33, 'OKRIKA-KONIJU TOW', 1),
(212, 33, 'OKRIKA-NDUBUSIAMA', 1),
(213, 33, 'OKRIKA-OBA ? AMA', 1),
(214, 33, 'OKRIKA-OBIARIME -AMA', 1),
(215, 33, 'OKRIKA-OGAN-AMA', 1),
(216, 33, 'OKRIKA-OGBOGBO', 1),
(217, 33, 'OKRIKA-OGBOGBO TOWN', 1),
(218, 33, 'OKRIKA-OGOLOMA TOWN', 1),
(219, 33, 'OKRIKA-OGU TOWN', 1),
(220, 33, 'OKRIKA-OKIRIKA TOWN', 1),
(221, 33, 'OKRIKA-OKOCHIRI', 1),
(222, 33, 'OKRIKA-OKRIKA TOWN(KIRIKE)', 1),
(223, 33, 'OKRIKA-OKUJAGU AMA', 1),
(224, 33, 'OKRIKA-OKUMGBA -AMA', 1),
(225, 33, 'OYIGBO-AFAM', 1),
(226, 33, 'OYIGBO-EGBERU', 1),
(227, 33, 'OYIGBO-IZUOMA', 1),
(228, 33, 'OYIGBO-KOMKOM', 1),
(229, 33, 'OYIGBO-MIRINWANYI', 1),
(230, 33, 'OYIGBO-NDOKI', 1),
(231, 33, 'OYIGBO-OBEAMA', 1),
(232, 33, 'OYIGBO-UMUAGBAI', 1),
(233, 33, 'PHC-NEW GRA -PHASE 1 2 3 4', 1),
(234, 33, 'PHC-RIVER STATE UNIVERSITY', 1),
(235, 33, 'PHC-WOJI Central Location', 1),
(236, 33, 'PORTHARCOURT-ABO AMA', 1),
(237, 33, 'PORTHARCOURT-ABONNEMA TOWN', 1),
(238, 33, 'PORTHARCOURT-ABONNEMA WHARF', 1),
(239, 33, 'PORTHARCOURT-ABULOMA', 1),
(240, 33, 'PORTHARCOURT-ADA GEORGE', 1),
(241, 33, 'PORTHARCOURT-AGIP', 1),
(242, 33, 'PORTHARCOURT-AHODA', 1),
(243, 33, 'PORTHARCOURT-AIRFORCE BASE', 1),
(244, 33, 'PORTHARCOURT-AKPAJO', 1),
(245, 33, 'PORTHARCOURT-ALAKAHIA-UPTH', 1),
(246, 33, 'PORTHARCOURT-ALUU', 1),
(247, 33, 'PORTHARCOURT-AMADI AMA', 1),
(248, 33, 'PORTHARCOURT-AYA-OGOLOGO', 1),
(249, 33, 'PORTHARCOURT-AZUBIE', 1),
(250, 33, 'PORTHARCOURT-BAKANA', 1),
(251, 33, 'PORTHARCOURT-BORI', 1),
(252, 33, 'PORTHARCOURT-BORI CAMP', 1),
(253, 33, 'PORTHARCOURT-BOROKIRI', 1),
(254, 33, 'PORTHARCOURT-BUGUMA', 1),
(255, 33, 'PORTHARCOURT-BUNDU AMA', 1),
(256, 33, 'PORTHARCOURT-BUNDU WATERSIDE', 1),
(257, 33, 'PORTHARCOURT-CHOBA', 1),
(258, 33, 'PORTHARCOURT-CHOBA-UNIPORT', 1),
(259, 33, 'PORTHARCOURT-CHURCHHILL', 1),
(260, 33, 'PORTHARCOURT-D/LINE', 1),
(261, 33, 'PORTHARCOURT-DARICK POLO', 1),
(262, 33, 'PORTHARCOURT-DEGEMA', 1),
(263, 33, 'PORTHARCOURT-DIOBU', 1),
(264, 33, 'PORTHARCOURT-EAGLE ISLAND', 1),
(265, 33, 'PORTHARCOURT-EGBELU', 1),
(266, 33, 'PORTHARCOURT-ELEKAHIA', 1),
(267, 33, 'PORTHARCOURT-ELELEWON', 1),
(268, 33, 'PORTHARCOURT-ELIBOLO', 1),
(269, 33, 'PORTHARCOURT-ELIGBAM', 1),
(270, 33, 'PORTHARCOURT-ELIMGBU', 1),
(271, 33, 'PORTHARCOURT-ELINPARAWON', 1),
(272, 33, 'PORTHARCOURT-ELIOHANI', 1),
(273, 33, 'PORTHARCOURT-ELIOZU', 1),
(274, 33, 'PORTHARCOURT-ENEKA', 1),
(275, 33, 'PORTHARCOURT-GOKANA', 1),
(276, 33, 'PORTHARCOURT-IGBO ETCHE', 1),
(277, 33, 'PORTHARCOURT-IGWURUTA', 1),
(278, 33, 'PORTHARCOURT-INTELS KM 16', 1),
(279, 33, 'PORTHARCOURT-MARINE BASE', 1),
(280, 33, 'PORTHARCOURT-MGBUOBA', 1),
(281, 33, 'PORTHARCOURT-MILE 1', 1),
(282, 33, 'PORTHARCOURT-MILE 2', 1),
(283, 33, 'PORTHARCOURT-MILE 3', 1),
(284, 33, 'PORTHARCOURT-MILE 4', 1),
(285, 33, 'PORTHARCOURT-MILE 5', 1),
(286, 33, 'PORTHARCOURT-MUGBUOSIMINI', 1),
(287, 33, 'PORTHARCOURT-NEW GRA-TOMBIA', 1),
(288, 33, 'PORTHARCOURT-NKPOGU', 1),
(289, 33, 'PORTHARCOURT-NKPOLU', 1),
(290, 33, 'PORTHARCOURT-NPA WHARF', 1),
(291, 33, 'PORTHARCOURT-OGBATAI', 1),
(292, 33, 'PORTHARCOURT-OGBOGORO', 1),
(293, 33, 'PORTHARCOURT-OGBUNABALI', 1),
(294, 33, 'PORTHARCOURT-OGINIGBA', 1),
(295, 33, 'PORTHARCOURT-OKPORO ROAD', 1),
(296, 33, 'PORTHARCOURT-OKURU', 1),
(297, 33, 'PORTHARCOURT-OLD GRA', 1),
(298, 33, 'PORTHARCOURT-OMAGWA', 1),
(299, 33, 'PORTHARCOURT-OMOKU', 1),
(300, 33, 'PORTHARCOURT-ORAZI', 1),
(301, 33, 'PORTHARCOURT-OZUBOKO', 1),
(302, 33, 'PORTHARCOURT-PETER ODILLI ROAD', 1),
(303, 33, 'PORTHARCOURT-PIPELINE', 1),
(304, 33, 'PORTHARCOURT-RECLAMATION', 1),
(305, 33, 'PORTHARCOURT-RUKPOKWU', 1),
(306, 33, 'PORTHARCOURT-RUMEME', 1),
(307, 33, 'PORTHARCOURT-RUMUAGHAOLU', 1),
(308, 33, 'PORTHARCOURT-RUMUAKPAKOLOSI', 1),
(309, 33, 'PORTHARCOURT-RUMUEPIRIKOM', 1),
(310, 33, 'PORTHARCOURT-RUMUEVOLU', 1),
(311, 33, 'PORTHARCOURT-RUMUIBEKWE', 1),
(312, 33, 'PORTHARCOURT-RUMUIGBO', 1),
(313, 33, 'PORTHARCOURT-RUMUKALAGBOR', 1),
(314, 33, 'PORTHARCOURT-RUMUKRUSHI', 1),
(315, 33, 'PORTHARCOURT-RUMUMASI', 1),
(316, 33, 'PORTHARCOURT-RUMUODUMAYA', 1),
(317, 33, 'PORTHARCOURT-RUMUOGBA', 1),
(318, 33, 'PORTHARCOURT-RUMUOKE', 1),
(319, 33, 'PORTHARCOURT-RUMUOKORO', 1),
(320, 33, 'PORTHARCOURT-RUMUOKWUTA', 1),
(321, 33, 'PORTHARCOURT-RUMUOLA', 1),
(322, 33, 'PORTHARCOURT-RUMUOLUMENI', 1),
(323, 33, 'PORTHARCOURT-RUMUOROSI', 1),
(324, 33, 'PORTHARCOURT-RUMUOWAH', 1),
(325, 33, 'PORTHARCOURT-STADIUM ROAD', 1),
(326, 33, 'PORTHARCOURT-TAI', 1),
(327, 33, 'PORTHARCOURT-TOWN', 1),
(328, 33, 'PORTHARCOURT-TRANS AMADI', 1),
(329, 33, 'PORTHARCOURT-UBE SANDFILLED', 1),
(330, 33, 'PORTHARCOURT-UMUROLU', 1),
(331, 33, 'PORTHARCOURT-WOJI ILLOM', 1),
(332, 33, 'PORTHARCOURT-WOJI ROAD', 1),
(333, 33, 'PORTHARCOURT-WOJI YKC', 1),
(334, 33, 'PORTHARCOURT-WOJI-ELIJIJI', 1),
(335, 33, 'RUMUAGHOLU', 1),
(336, 33, 'RUMUODUOMAYA', 1),
(337, 25, 'Abule Egba (Agbado Ijaye Road)', 1),
(338, 25, 'Abule Egba (Ajasa Command Rd)', 1),
(339, 25, 'Abule Egba (Ajegunle)', 1),
(340, 25, 'Abule Egba (Alagbado)', 1),
(341, 25, 'Abule Egba (Alakuko)', 1),
(342, 25, 'Abule Egba (Ekoro road)', 1),
(343, 25, 'Abule Egba (Meiran Road)', 1),
(344, 25, 'Abule Egba (New Oko Oba)', 1),
(345, 25, 'Abule Egba (Old Otta Road)', 1),
(346, 25, 'AGBARA-Ajibade', 1),
(347, 25, 'AGBARA-Checking Point', 1),
(348, 25, 'AGBARA-Church Gate', 1),
(349, 25, 'AGBARA-Ibiye', 1),
(350, 25, 'AGBARA-Industrial Estate', 1),
(351, 25, 'AGBARA-Magbon', 1),
(352, 25, 'AGBARA-Morogbo', 1),
(353, 25, 'Agege (Ajuwon Akute Road)', 1),
(354, 25, 'Agege (Dopemu)', 1),
(355, 25, 'Agege (Iju Road)', 1),
(356, 25, 'Agege (Old Abeokuta Road)', 1),
(357, 25, 'Agege (Old Otta Road)', 1),
(358, 25, 'Agege (Orile Agege)', 1),
(359, 25, 'AGILITI', 1),
(360, 25, 'AGUNGI (LEKKI)', 1),
(361, 25, 'AJAO ESTATE', 1),
(362, 25, 'ALFA BEACH', 1),
(363, 25, 'AMUWO', 1),
(364, 25, 'ANTHONY VILLAGE', 1),
(365, 25, 'Apapa (Ajegunle)', 1),
(366, 25, 'Apapa (Amukoko)', 1),
(367, 25, 'Apapa (GRA)', 1),
(368, 25, 'Apapa (Kiri kiri)', 1),
(369, 25, 'Apapa (Olodi)', 1),
(370, 25, 'Apapa (Suru Alaba)', 1),
(371, 25, 'Apapa (Tincan)', 1),
(372, 25, 'Apapa (Warf Rd)', 1),
(373, 25, 'Awoyaya-Container bustop', 1),
(374, 25, 'Awoyaya-Eko Akete Estate', 1),
(375, 25, 'Awoyaya-Eputu', 1),
(376, 25, 'Awoyaya-Gbetu Iwerekun Road', 1),
(377, 25, 'Awoyaya-Idowu Eletu', 1),
(378, 25, 'Awoyaya-Mayfair Gardens', 1),
(379, 25, 'Awoyaya-Ogunlana Busstop', 1),
(380, 25, 'Awoyaya-Ologunfe', 1),
(381, 25, 'Awoyaya-Oribanwa', 1),
(382, 25, 'Baale', 1),
(383, 25, 'BADAGRY (AJARA)', 1),
(384, 25, 'BADAGRY (ARADAGUN)', 1),
(385, 25, 'BADAGRY (BADAGRY TOWN)', 1),
(386, 25, 'BADAGRY (IKOGA)', 1),
(387, 25, 'BADAGRY (IMEKE)', 1),
(388, 25, 'BADAGRY (IWORO-AJIDO)', 1),
(389, 25, 'BADAGRY (JAH-MICHAEL)', 1),
(390, 25, 'BADAGRY (MOWO)', 1),
(391, 25, 'BADAGRY (OKO-AFOR)', 1),
(392, 25, 'BADAGRY (OWODE APA)', 1),
(393, 25, 'BADAGRY (PURE WATER)', 1),
(394, 25, 'BADAGRY (TOLL GATE)', 1),
(395, 25, 'BERGER', 1),
(396, 25, 'Bogije', 1),
(397, 25, 'Coker', 1),
(398, 25, 'Doyin', 1),
(399, 25, 'Ejigbo-Ailegun Road', 1),
(400, 25, 'Ejigbo-Bucknor', 1),
(401, 25, 'Ejigbo-Ile Epo', 1),
(402, 25, 'Ejigbo-Isheri Osun', 1),
(403, 25, 'Ejigbo-Jakande Wood Market', 1),
(404, 25, 'Ejigbo-NNPC Road', 1),
(405, 25, 'Ejigbo-Oke-Afa', 1),
(406, 25, 'Ejigbo-Pipeline', 1),
(407, 25, 'Ejigbo-Powerline', 1),
(408, 25, 'Elemoro', 1),
(409, 25, 'Epe-Agric', 1),
(410, 25, 'Epe-Aristo', 1),
(411, 25, 'Epe-Ayetoro', 1),
(412, 25, 'Epe-Cele', 1),
(413, 25, 'Epe-Eoka', 1),
(414, 25, 'Epe-Eyindi', 1),
(415, 25, 'Epe-Hospital Road', 1),
(416, 25, 'Epe-Iraye', 1),
(417, 25, 'Epe-Ita Marun', 1),
(418, 25, 'Epe-Ita Opo', 1),
(419, 25, 'Epe-Kemu', 1),
(420, 25, 'Epe-Kolawole Junction', 1),
(421, 25, 'Epe-Marina', 1),
(422, 25, 'Epe-Odumola', 1),
(423, 25, 'Epe-Oke Balogun', 1),
(424, 25, 'Epe-Oke Iyinbo', 1),
(425, 25, 'Epe-Oloja Estate', 1),
(426, 25, 'Epe-Oluwo Market', 1),
(427, 25, 'Epe-Plywood Junction', 1),
(428, 25, 'Epe-Recreation', 1),
(429, 25, 'Epe-Round about', 1),
(430, 25, 'Epe-T Junction', 1),
(431, 25, 'FESTAC (1st Avenue)', 1),
(432, 25, 'FESTAC (2nd Avenue)', 1),
(433, 25, 'FESTAC (3rd Avenue)', 1),
(434, 25, 'FESTAC (4th Avenue)', 1),
(435, 25, 'FESTAC (5th Avenue)', 1),
(436, 25, 'FESTAC (6th Avenue)', 1),
(437, 25, 'FESTAC (7th Avenue)', 1),
(438, 25, 'Gbagada- Ifako', 1),
(439, 25, 'Gbagada-Abule Okuta', 1),
(440, 25, 'Gbagada-Araromi', 1),
(441, 25, 'Gbagada-Deeper Life', 1),
(442, 25, 'Gbagada-Diya', 1),
(443, 25, 'Gbagada-Expressway', 1),
(444, 25, 'Gbagada-Hospital', 1),
(445, 25, 'Gbagada-L&K', 1),
(446, 25, 'Gbagada-New Garage', 1),
(447, 25, 'Gbagada-Olopomeji', 1),
(448, 25, 'Gbagada-Pedro', 1),
(449, 25, 'Gbagada-Sawmill', 1),
(450, 25, 'Gbagada-Sholuyi', 1),
(451, 25, 'Ibeju Lekki-Akodo', 1),
(452, 25, 'Ibeju Lekki-Atunrase', 1),
(453, 25, 'Ibeju Lekki-Baba Adisa', 1),
(454, 25, 'Ibeju Lekki-Dangote Refinery', 1),
(455, 25, 'Ibeju Lekki-Dano Milk', 1),
(456, 25, 'Ibeju Lekki-Igbojia', 1),
(457, 25, 'Ibeju Lekki-Magbon', 1),
(458, 25, 'Ibeju Lekki-Onosa', 1),
(459, 25, 'Ibeju Lekki-Orimedo', 1),
(460, 25, 'Ibeju Lekki-Pan Atlantic University', 1),
(461, 25, 'Ibeju Lekki-Shapati', 1),
(462, 25, 'Ibeju-Lekki-Aiyeteju', 1),
(463, 25, 'Ibeju-Lekki-Eleko', 1),
(464, 25, 'Ibeju-Lekki-Free TradeZone', 1),
(465, 25, 'Ibeju-Lekki-Igando-Oloja', 1),
(466, 25, 'Ibeju-Lekki-Obatedo', 1),
(467, 25, 'IDIMU', 1),
(468, 25, 'IGANDO', 1),
(469, 25, 'IJANIKIN-Aiyetoro', 1),
(470, 25, 'IJANIKIN-AOCOED', 1),
(471, 25, 'IJANIKIN-Cele Vesper', 1),
(472, 25, 'IJANIKIN-Celenizer', 1),
(473, 25, 'IJANIKIN-Iyana Era', 1),
(474, 25, 'IJANIKIN-Ketu', 1),
(475, 25, 'IJEGUN IKOTUN', 1),
(476, 25, 'Ijegun-Obadore Road', 1),
(477, 25, 'IJORA', 1),
(478, 25, 'Ikeja (ADENIYI JONES)', 1),
(479, 25, 'Ikeja (ALAUSA)', 1),
(480, 25, 'Ikeja (ALLEN AVENUE)', 1),
(481, 25, 'Ikeja (computer village)', 1),
(482, 25, 'Ikeja (GRA)', 1),
(483, 25, 'IKEJA (M M Airport)', 1),
(484, 25, 'Ikeja (MANGORO)', 0),
(485, 25, 'Ikeja (OBA-AKRAN)', 1),
(486, 25, 'Ikeja (OPEBI)', 1),
(487, 25, 'IKORODU (Adamo)', 1),
(488, 25, 'IKORODU (Agbede)', 1),
(489, 25, 'Ikorodu (Agbowa)', 1),
(490, 25, 'IKORODU (Agric)', 1),
(491, 25, 'IKORODU (Bayeku)', 1),
(492, 25, 'IKORODU (Eyita)', 1),
(493, 25, 'IKORODU (Gberigbe)', 1),
(494, 25, 'IKORODU (Igbogbo)', 1),
(495, 25, 'IKORODU (Ijede)', 1),
(496, 25, 'IKORODU (Imota)', 1),
(497, 25, 'IKORODU (Ita oluwo)', 1),
(498, 25, 'IKORODU (Itamaga)', 1),
(499, 25, 'IKORODU (Offin)', 1),
(500, 25, 'IKORODU (Owode-Ibese)', 1),
(501, 25, 'Ikorodu Road-Ajegunle', 1),
(502, 25, 'Ikorodu Road-Irawo', 1),
(503, 25, 'Ikorodu Road-Owode Onirin', 1),
(504, 25, 'IKORODU(Elepe)', 1),
(505, 25, 'IKORODU(Laspotech)', 1),
(506, 25, 'Ikorodu(Ogolonto)', 1),
(507, 25, 'IKORODU(Sabo)', 1),
(508, 25, 'Ikorodu- Imota Caleb University', 1),
(509, 25, 'Ikorodu-Agufoye', 1),
(510, 25, 'Ikorodu-Benson', 1),
(511, 25, 'Ikorodu-Garage', 1),
(512, 25, 'Ikorodu-Odokekere', 1),
(513, 25, 'Ikorodu-Odonla', 1),
(514, 25, 'Ikorodu-Ogijo', 1),
(515, 25, 'IKOTA', 1),
(516, 25, 'IKOTUN', 1),
(517, 25, 'Ikoyi (Awolowo Road)', 1),
(518, 25, 'Ikoyi (Bourdillon)', 1),
(519, 25, 'Ikoyi (Dolphin)', 1),
(520, 25, 'Ikoyi (Glover road)', 1),
(521, 25, 'Ikoyi (Keffi)', 1),
(522, 25, 'Ikoyi (Kings way road)', 1),
(523, 25, 'Ikoyi (Obalende)', 1),
(524, 25, 'Ikoyi (Queens Drive)', 1),
(525, 25, 'IKOYI MTN ( PICKUP STATION)', 1),
(526, 25, 'ILAJE (BARIGA)', 1),
(527, 25, 'ILOGBO', 1),
(528, 25, 'ILUPEJU (Lagos)', 1),
(529, 25, 'ISHERI IKOTUN', 1),
(530, 25, 'ISHERI MAGODO', 1),
(531, 25, 'ISOLO', 1),
(532, 25, 'Iyana Ejigbo', 1),
(533, 25, 'Iyana Ipaja (Abesan)', 1),
(534, 25, 'Iyana Ipaja (Ayobo Road)', 1),
(535, 25, 'Iyana Ipaja (Command Road)', 1),
(536, 25, 'Iyana Ipaja (Egbeda)', 1),
(537, 25, 'Iyana Ipaja (Ikola Road)', 1),
(538, 25, 'Iyana Ipaja (Iyana Ipaja Road)', 1),
(539, 25, 'Iyana Ipaja (Shasha)', 1),
(540, 25, 'JAKANDE (LEKKI)', 1),
(541, 25, 'JANKANDE (ISOLO)', 1),
(542, 25, 'Jumia-Experience-Center', 1),
(543, 25, 'Ketu- Agboyi', 1),
(544, 25, 'Ketu-Alapere', 1),
(545, 25, 'Ketu-CMD road', 1),
(546, 25, 'Ketu-Demurin', 1),
(547, 25, 'Ketu-Ikosi Road', 1),
(548, 25, 'Ketu-Ile Ile', 1),
(549, 25, 'Ketu-Iyana School', 1),
(550, 25, 'Ketu-Tipper Garage', 1),
(551, 25, 'Lagos Island (Adeniji)', 1),
(552, 25, 'Lagos Island (Marina)', 1),
(553, 25, 'Lagos Island (Onikan)', 1),
(554, 25, 'Lagos Island (Sura)', 1),
(555, 25, 'Lagos Island (TBS)', 1),
(556, 25, 'Lakowe-Adeba Road', 1),
(557, 25, 'Lakowe-Golf', 1),
(558, 25, 'Lakowe-Kajola', 1),
(559, 25, 'Lakowe-School Gate', 1),
(560, 25, 'LEKKI -CHEVRON', 1),
(561, 25, 'LEKKI -VGC', 1),
(562, 25, 'Lekki 1 (Bishop Durosimi)', 1),
(563, 25, 'Lekki 1 (F.T Kuboye street)', 1),
(564, 25, 'Lekki 1 (Omorinre Johnson)', 1),
(565, 25, 'Lekki Phase 1 (Admiralty Road)', 1),
(566, 25, 'Lekki Phase 1 (Admiralty way)', 1),
(567, 25, 'Lekki Phase 1 (Fola Osibo)', 1),
(568, 25, 'LEKKI-AGUNGI', 1),
(569, 25, 'LEKKI-AJAH (ABIJO)', 1),
(570, 25, 'LEKKI-AJAH (ABRAHAM ADESANYA)', 1),
(571, 25, 'LEKKI-AJAH (ADDO ROAD)', 1),
(572, 25, 'LEKKI-AJAH (BADORE)', 1),
(573, 25, 'LEKKI-AJAH (ILAJE)', 1),
(574, 25, 'LEKKI-AJAH (ILASAN)', 1),
(575, 25, 'LEKKI-AJAH (JAKANDE)', 1),
(576, 25, 'LEKKI-AJAH (LANGBASA)', 1),
(577, 25, 'LEKKI-AJAH (SANGOTEDO)', 1),
(578, 25, 'Lekki-Chisco', 1),
(579, 25, 'LEKKI-ELF', 1),
(580, 25, 'LEKKI-IGBOEFON', 1),
(581, 25, 'LEKKI-IKATE ELEGUSHI', 1),
(582, 25, 'LEKKI-JAKANDE (KAZEEM ELETU)', 1),
(583, 25, 'LEKKI-MARUWA', 1),
(584, 25, 'LEKKI-ONIRU ESTATE', 1),
(585, 25, 'LEKKI-OSAPA LONDON', 1),
(586, 25, 'MAGODO', 1),
(587, 25, 'MARYLAND (MENDE)', 1),
(588, 25, 'MARYLAND (ONIGBONGBO)', 1),
(589, 25, 'MEBANMU', 1),
(590, 25, 'MILE 12', 1),
(591, 25, 'Mile 12 -Ajelogo', 1),
(592, 25, 'Mile 12-Agboyi Ketu', 1),
(593, 25, 'Mile 12-Doyin Omololu', 1),
(594, 25, 'Mile 12-Orishigun', 1),
(595, 25, 'MILE 2', 1),
(596, 25, 'Mushin -Palm Avenue', 1),
(597, 25, 'Mushin-Agege Motor Road', 1),
(598, 25, 'Mushin-Daleko Market', 1),
(599, 25, 'Mushin-Fatai Atere', 1),
(600, 25, 'Mushin-Idi Oro', 1),
(601, 25, 'Mushin-Idi-Araba', 1),
(602, 25, 'Mushin-Ilasamaja Road', 1),
(603, 25, 'Mushin-Isolo Road', 1),
(604, 25, 'Mushin-Ladipo Road', 1),
(605, 25, 'Mushin-Mushin Market', 1),
(606, 25, 'Mushin-Olateju', 1),
(607, 25, 'Mushin-Papa Ajao', 1),
(608, 25, 'Odongunyan', 1),
(609, 25, 'Odunade', 1),
(610, 25, 'Ogba- Akilo Road', 1),
(611, 25, 'Ogba- College Road', 1),
(612, 25, 'Ogba- Lateef Jakande Road', 1),
(613, 25, 'Ogba-Acme Road', 1),
(614, 25, 'Ogba-Aguda', 1),
(615, 25, 'Ogba-County', 1),
(616, 25, 'Ogba-Ifako-Idiagbon', 1),
(617, 25, 'Ogba-Ifako-Orimolade', 1),
(618, 25, 'Ogba-Isheri Road', 1),
(619, 25, 'Ogba-Obawole', 1),
(620, 25, 'Ogba-Ojodu', 1),
(621, 25, 'Ogba-Oke Ira', 1),
(622, 25, 'Ogba-Oke Ira 2nd Juction', 1),
(623, 25, 'Ogba-Wemco Road', 1),
(624, 25, 'OGUDU', 1),
(625, 25, 'Ojo-Abule Oshun', 1),
(626, 25, 'Ojo-Adaloko', 1),
(627, 25, 'OJO-AFROMEDIA', 1),
(628, 25, 'Ojo-Agric', 1),
(629, 25, 'OJO-AJAGBANDI', 1),
(630, 25, 'Ojo-Alaba International', 1),
(631, 25, 'Ojo-Alaba Rago', 1),
(632, 25, 'Ojo-Alaba Suru', 1),
(633, 25, 'Ojo-Alakija', 1),
(634, 25, 'Ojo-Cassidy', 1),
(635, 25, 'Ojo-Iba', 1),
(636, 25, 'Ojo-Iba Estate', 1),
(637, 25, 'Ojo-Igbo Elerin', 1),
(638, 25, 'Ojo-Ijegun', 1),
(639, 25, 'Ojo-Ilogbo', 1),
(640, 25, 'Ojo-Iyana Iba', 1),
(641, 25, 'Ojo-IYANA ISHASHI', 1),
(642, 25, 'Ojo-Iyana School', 1),
(643, 25, 'Ojo-LASU', 1),
(644, 25, 'Ojo-Ojo Barracks', 1),
(645, 25, 'Ojo-Okokomaiko', 1),
(646, 25, 'Ojo-Old Ojo road', 1),
(647, 25, 'Ojo-Onireke', 1),
(648, 25, 'Ojo-PPL', 1),
(649, 25, 'Ojo-Satellite Town', 1),
(650, 25, 'Ojo-Shibiri', 1),
(651, 25, 'Ojo-Tedi Town', 1),
(652, 25, 'Ojo-Trade Fair', 1),
(653, 25, 'Ojo-Volks', 1),
(654, 25, 'OJODU', 1),
(655, 25, 'OJOKORO', 1),
(656, 25, 'OJOTA', 1),
(657, 25, 'OKOTA', 1),
(658, 25, 'Omole Phase 1', 1),
(659, 25, 'Omole Phase 2', 1),
(660, 25, 'OREGUN', 1),
(661, 25, 'Oreyo- Igbe', 1),
(662, 25, 'ORILE', 1),
(663, 25, 'OSAPA (LEKKI)', 1),
(664, 25, 'OSHODI-BOLADE', 1),
(665, 25, 'OSHODI-ISOLO', 1),
(666, 25, 'OSHODI-MAFOLUKU', 1),
(667, 25, 'OSHODI-ORILE', 1),
(668, 25, 'OSHODI-SHOGUNLE', 1),
(669, 25, 'Owode Onirin', 1),
(670, 25, 'Sari-Iganmu', 1),
(671, 25, 'SEME', 1),
(672, 25, 'SOMOLU', 1),
(673, 25, 'Surulere (Adeniran Ogunsanya)', 1),
(674, 25, 'Surulere (Aguda)', 1),
(675, 25, 'Surulere (Bode Thomas)', 1),
(676, 25, 'Surulere (Fatia Shitta)', 1),
(677, 25, 'Surulere (Idi Araba)', 1),
(678, 25, 'Surulere (Ijesha)', 1),
(679, 25, 'Surulere (Iponri)', 1),
(680, 25, 'Surulere (Itire)', 1),
(681, 25, 'Surulere (Lawanson)', 1),
(682, 25, 'Surulere (Masha)', 1),
(683, 25, 'Surulere (Ogunlana drive)', 1),
(684, 25, 'Surulere (Ojuelegba)', 1),
(685, 25, 'TOPO', 1),
(686, 25, 'VI (Adetokunbo Ademola)', 1),
(687, 25, 'VI (Ahmed Bello way)', 1),
(688, 25, 'VI (Bishop Aboyade Cole)', 1),
(689, 25, 'VI(Ajose Adeogun)', 1),
(690, 25, 'VI(Akin Adeshola)', 1),
(691, 25, 'VI(Bishop Oluwale)', 1),
(692, 25, 'VI(Yusuf Abiodun)', 1),
(693, 25, 'Victoria Island (Adeola Odeku)', 1),
(694, 25, 'Victoria Island (Kofo Abayomi)', 1),
(695, 25, 'Yaba- Abule Ijesha', 1),
(696, 25, 'Yaba- Fadeyi', 1),
(697, 25, 'Yaba-(Sabo)', 1),
(698, 25, 'Yaba-(Unilag)', 1),
(699, 25, 'Yaba-Abule Oja', 1),
(700, 25, 'Yaba-Adekunle', 1),
(701, 25, 'Yaba-Akoka', 1),
(702, 25, 'Yaba-Alagomeju', 1),
(703, 25, 'Yaba-College of Education', 1),
(704, 25, 'Yaba-Commercial Avenue', 1),
(705, 25, 'Yaba-Folagoro', 1),
(706, 25, 'Yaba-Herbert Macaulay Way', 1),
(707, 25, 'Yaba-Jibowu', 1),
(708, 25, 'Yaba-Makoko', 1),
(709, 25, 'Yaba-Murtala Muhammed Way', 1),
(710, 25, 'Yaba-Onike Iwaya', 1),
(711, 25, 'Yaba-Oyingbo', 1),
(712, 25, 'Yaba-Tejuosho', 1),
(713, 25, 'Yaba-University Road', 1),
(714, 25, 'Yaba-Yabatech', 1);

-- --------------------------------------------------------

--
-- Table structure for table `colour`
--

CREATE TABLE `colour` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `api_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colour`
--

INSERT INTO `colour` (`id`, `name`, `code`, `status`, `date_created`, `api_id`) VALUES
(1, 'DarK Red', '#570a0a', 1, '24-04-2020 11:52 AM', 0),
(2, 'Blue', '#0f68ba', 1, '24-04-2020 11:52 AM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `userid` varchar(11) NOT NULL,
  `shipping_address` varchar(3000) NOT NULL,
  `cityid` int(11) NOT NULL,
  `stateid` int(6) NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `userid`, `shipping_address`, `cityid`, `stateid`, `phone1`, `phone2`, `status`, `date_created`, `email`) VALUES
(1, '6', 'Eliowhani farm Road', 62, 15, '0000', '', 0, '11-09-2023 00:09 am', 'conwunyirigbo@gmail.com'),
(2, '3', 'Farm Road, Ozor', 182, 33, '0000', '', 0, '18-09-2023 09:44 am', 'conwunyirigbo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_cities`
--

CREATE TABLE `delivery_cities` (
  `id` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `dsid` int(11) NOT NULL,
  `days` int(3) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_cities`
--

INSERT INTO `delivery_cities` (`id`, `cityid`, `dsid`, `days`, `type`) VALUES
(1, 53, 2, 1, ''),
(2, 151, 3, 1, ''),
(3, 1, 5, 2, ''),
(4, 166, 5, 2, ''),
(5, 58, 6, 1, 'hours'),
(6, 58, 7, 1, 'hours'),
(7, 53, 8, 1, 'hours'),
(8, 54, 8, 1, 'hours'),
(9, 57, 8, 1, 'hours'),
(10, 59, 8, 1, 'hours'),
(11, 58, 9, 1, 'days'),
(12, 58, 10, 1, 'hours'),
(13, 53, 18, 1, 'hours'),
(14, 54, 18, 1, 'hours'),
(15, 55, 18, 1, 'hours'),
(16, 56, 18, 1, 'hours'),
(17, 57, 18, 1, 'hours'),
(18, 58, 18, 1, 'hours'),
(19, 59, 18, 1, 'hours'),
(20, 60, 18, 1, 'hours'),
(21, 61, 18, 1, 'hours'),
(22, 62, 18, 1, 'hours'),
(23, 63, 18, 1, 'hours'),
(24, 64, 18, 1, 'hours'),
(25, 74, 19, 1, 'hours'),
(26, 75, 19, 1, 'hours'),
(27, 76, 19, 1, 'hours'),
(28, 77, 19, 1, 'hours'),
(29, 78, 19, 1, 'hours'),
(30, 79, 19, 1, 'hours'),
(31, 80, 19, 1, 'hours'),
(32, 81, 19, 1, 'hours'),
(33, 82, 19, 1, 'hours'),
(34, 83, 19, 1, 'hours'),
(35, 93, 19, 1, 'hours'),
(36, 104, 19, 1, 'hours'),
(37, 51, 31, 2, 'hours'),
(38, 52, 31, 2, 'hours'),
(39, 53, 31, 2, 'hours'),
(40, 54, 31, 2, 'hours'),
(41, 55, 31, 2, 'hours'),
(42, 56, 31, 2, 'hours'),
(43, 57, 31, 2, 'hours'),
(44, 58, 31, 2, 'hours'),
(45, 59, 31, 2, 'hours'),
(46, 60, 31, 2, 'hours'),
(47, 61, 31, 2, 'hours'),
(48, 62, 31, 2, 'hours'),
(49, 63, 31, 2, 'hours'),
(50, 64, 31, 2, 'hours'),
(51, 65, 31, 2, 'hours'),
(52, 66, 31, 2, 'hours'),
(53, 100, 31, 2, 'hours'),
(54, 108, 31, 2, 'hours'),
(55, 109, 31, 2, 'hours'),
(56, 111, 31, 2, 'hours'),
(57, 112, 31, 2, 'hours'),
(58, 116, 31, 2, 'hours'),
(59, 125, 31, 2, 'hours'),
(60, 140, 31, 2, 'hours'),
(61, 141, 31, 2, 'hours'),
(62, 142, 31, 2, 'hours'),
(63, 67, 32, 1, 'hours'),
(64, 68, 32, 1, 'hours'),
(65, 69, 32, 1, 'hours'),
(66, 70, 32, 1, 'hours'),
(67, 71, 32, 1, 'hours'),
(68, 72, 32, 1, 'hours'),
(69, 73, 32, 1, 'hours'),
(70, 74, 32, 1, 'hours'),
(71, 75, 32, 1, 'hours'),
(72, 76, 32, 1, 'hours'),
(73, 77, 32, 1, 'hours'),
(74, 78, 32, 1, 'hours'),
(75, 79, 32, 1, 'hours'),
(76, 80, 32, 1, 'hours'),
(77, 81, 32, 1, 'hours'),
(78, 82, 32, 1, 'hours'),
(79, 83, 32, 1, 'hours'),
(80, 93, 32, 1, 'hours'),
(81, 94, 32, 1, 'hours'),
(82, 95, 32, 1, 'hours'),
(83, 96, 32, 1, 'hours'),
(84, 97, 32, 1, 'hours'),
(85, 98, 32, 1, 'hours'),
(86, 103, 32, 1, 'hours'),
(87, 104, 32, 1, 'hours'),
(88, 107, 32, 1, 'hours'),
(89, 110, 32, 1, 'hours'),
(90, 114, 32, 1, 'hours'),
(91, 115, 32, 1, 'hours'),
(92, 124, 32, 1, 'hours'),
(93, 143, 32, 1, 'hours'),
(94, 144, 32, 1, 'hours'),
(95, 145, 32, 1, 'hours'),
(96, 146, 32, 1, 'hours'),
(97, 147, 32, 1, 'hours'),
(98, 148, 32, 1, 'hours'),
(99, 149, 32, 1, 'hours'),
(100, 150, 32, 1, 'hours'),
(101, 151, 32, 1, 'hours'),
(102, 152, 32, 1, 'hours'),
(103, 160, 32, 1, 'hours'),
(104, 161, 32, 1, 'hours');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_fee`
--

CREATE TABLE `delivery_fee` (
  `id` int(11) NOT NULL,
  `stateid` int(6) NOT NULL,
  `cityid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `days` int(3) NOT NULL,
  `weight_discount` decimal(6,2) NOT NULL,
  `type` varchar(10) NOT NULL,
  `threshold_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_fee`
--

INSERT INTO `delivery_fee` (`id`, `stateid`, `cityid`, `amount`, `days`, `weight_discount`, `type`, `threshold_amount`) VALUES
(30, 0, 0, '500.00', 1, '20.00', 'hours', '5000.00'),
(31, 15, 0, '1000.00', 2, '0.00', 'hours', '0.00'),
(32, 15, 0, '500.00', 1, '0.00', 'hours', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_staff`
--

CREATE TABLE `delivery_staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_staff`
--

INSERT INTO `delivery_staff` (`id`, `name`, `status`, `date_created`) VALUES
(8, 'PAUL SUNDAY (09053699102)', 1, '30-07-2020 11:42 AM'),
(15, 'JENIFFER OBIAGU (08077099171)', 1, '30-07-2020 11:52 AM'),
(18, 'JOLIAN OGAMBA (08077098464)', 1, '03-11-2020 16:09 PM'),
(19, 'UDUAK EKERE (08150903404)', 1, '03-11-2020 16:09 PM');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `description` varchar(600) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `description`, `code`, `status`, `date_created`) VALUES
(1, 'House 20, First Avenue, Gwarimpa, Abuja', 'Gwarimpa', 1, '02-06-2020 13:16 PM'),
(2, '134, Ademola Adetokunbo Crescent, Wuse 2', 'Wuse 2', 1, '02-06-2020 13:17 PM'),
(3, 'AGY Plaza, Abubakar Burga way, Keffi', 'Keffi', 1, '02-06-2020 13:17 PM');

-- --------------------------------------------------------

--
-- Table structure for table `menugroup`
--

CREATE TABLE `menugroup` (
  `id` int(11) NOT NULL,
  `Code` varchar(20) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `Url` varchar(600) NOT NULL,
  `HasMenuItems` tinyint(3) NOT NULL,
  `Icon` varchar(255) NOT NULL,
  `MenuGroupOrder` int(3) NOT NULL,
  `status` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menugroup`
--

INSERT INTO `menugroup` (`id`, `Code`, `Text`, `Url`, `HasMenuItems`, `Icon`, `MenuGroupOrder`, `status`) VALUES
(1, 'tcategory', 'Category', '../admin/category_list', 0, 'icon-laptop', 1, 1),
(2, 'tbrand', 'Brands', '../admin/brand_list', 0, 'icon-check', 2, 1),
(3, 'tproduct', 'Products', '../admin/product_list', 0, 'icon-briefcase', 3, 1),
(4, 'tbanner', 'Banners', '../admin/banner_list', 0, 'icon-flag', 2, 1),
(5, 'dstaff', 'Delivery staff', '../admin/delivery_staff_list', 0, 'icon-user', 5, 1),
(6, 'torder', 'Orders', '../admin/orders', 0, 'icon-book', 5, 1),
(7, 'tcustomer', 'Customers', '../admin/customers', 0, 'icon-group', 7, 1),
(8, 'settings', 'Settings', 'javascript:;', 1, 'icon-cogs', 8, 1),
(10, 'security', 'Security', 'javascript:;', 1, 'icon-lock', 9, 1),
(11, 'tstatus', 'Status', '.', 1, '.', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

CREATE TABLE `menuitem` (
  `id` int(11) NOT NULL,
  `Code` varchar(20) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `GroupCode` varchar(20) NOT NULL,
  `HasMenuItems` tinyint(3) NOT NULL,
  `TopMenuCode` varchar(20) NOT NULL,
  `Url` varchar(600) NOT NULL,
  `MenuItemOrder` int(3) NOT NULL,
  `status` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuitem`
--

INSERT INTO `menuitem` (`id`, `Code`, `Text`, `GroupCode`, `HasMenuItems`, `TopMenuCode`, `Url`, `MenuItemOrder`, `status`) VALUES
(1, 'tgeneral', 'General Settings', 'settings', 0, '', '../admin/site_settings', 1, 1),
(2, 'tcolour', 'Colours', 'settings', 0, '', '../admin/colour_list', 2, 1),
(3, 'tsize', 'Sizes', 'settings', 0, '', '../admin/size_list', 3, 1),
(4, 'tslider', 'Slider', 'settings', 0, '', 'slider_list', 4, 1),
(5, 'tdelivery', 'Delivery Settings', 'settings', 0, '', 'delivery_settings', 5, 1),
(6, 'tcontent', 'Site Content', 'settings', 0, '', 'site_content', 5, 1),
(7, 'tuser', 'Users', 'security', 0, '', 'user_list', 2, 1),
(8, 'changepwd', 'Change Password', 'security', 0, '', 'change_password', 3, 1),
(9, 'role', 'Roles', 'security', 0, '', '../admin/role_list', 1, 1),
(10, 'tcategory', 'Category', 'tcategory', 0, '', '../admin/category_list', 0, 1),
(11, 'tbrand', '../admin/brand_list', 'tbrand', 0, '', '../admin/brand_list', 0, 1),
(12, 'tbanner', 'Banners', 'tbanner', 0, '', '../admin/banner_list', 0, 1),
(13, 'tproduct', 'Products', 'tproduct', 0, '', '../admin/product_list', 0, 1),
(14, 'dstaff', 'Delivery staff', 'dstaff', 0, '', '../admin/delivery_staff_list', 0, 1),
(15, 'torder', 'Orders', 'torder', 0, '', '../admin/orders', 0, 1),
(16, 'tcustomer', 'Customers', 'tcustomer', 0, '', '../admin/customers', 0, 1),
(17, 'pending', 'Pending Order', 'tstatus', 0, '', '#', 0, 1),
(18, 'processing', 'Processing Order', 'tstatus', 0, '', '#', 0, 1),
(21, 'ready_to_ship', 'Ready to Ship', 'tstatus', 0, '', '#', 0, 1),
(23, 'shipped', 'In Transit', 'tstatus', 0, '', '#', 0, 1),
(24, 'delivered', 'Delivered', 'tstatus', 0, '', '#', 0, 1),
(25, 'cancelled', 'Cancelled', 'tstatus', 0, '', '#', 0, 1),
(26, 'trestaurant', 'Restaurant Settings', 'settings', 0, '', '../admin/restaurant_settings', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `body` varchar(6000) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `title`, `recipient`, `sender`, `body`, `date_created`) VALUES
(0, 'Order Successful', 'conwunyirigbo@gmail.com', 'Bakan Gizo', '<p>Dear Chidiebere Onwunyirigbo</p><p>Your order on Bakan Gizo online store was successful. See details below;</p><br/><table><tr style=\"border: 1px solid #ddd\">\r\n                						                  <th colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0\">\r\n                						                      <p style=\"font-size: 13px; color: #ff3399; text-transform:uppercase; font-family: \'open sans\'\">\r\n                            							         <strong>Order No. #</strong>148503 - 11-09-2023 00:12 am\r\n                            						          </p>\r\n                						                  </th>\r\n                						              </tr><tr>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><img src=\"http://localhost/greenstore/uploads/product11131.jpg\" style=\"width: 50px;\"/></td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">SHEA MOISTURE ARGAN BODY LOTION 384 ML</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">1 x &#8358;5,060</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><span class=\"bagde badge-warning\">Pending Order</span></td>\r\n                    						              </tr><tr>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">Delivery Fee</td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">&#8358;1,000</td>\r\n                						              </tr>\r\n                						              <tr>\r\n                						                 \r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><strong>Total</strong></td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\">&#8358;6,060</td>\r\n                						              </tr>\r\n                						              <tr>                						                 \r\n                						                  <td colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><p style=\"font-size: 12px; line-height: 20px\">Delivered within <strong>2 hours</strong> from 11-09-2023 00:12 am.</p></td>\r\n                						              </tr>\r\n</table><br/><p>Thanks for your patronage. <br/>Bakan Gizo Team.</p>', '11-09-2023 12:12 am'),
(0, 'New Order', 'order@bakangizo.com.ng', 'Bakan Gizo Admin', '<p>New order on Bakan Gizo Online Store. See details below;</p><br/><table><tr style=\"border: 1px solid #ddd\">\r\n                						                  <th colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0\">\r\n                						                      <p style=\"font-size: 13px; color: #ff3399; text-transform:uppercase; font-family: \'open sans\'\">\r\n                            							         <strong>Order No. #</strong>148503 - 11-09-2023 00:12 am\r\n                            						          </p>\r\n                						                  </th>\r\n                						              </tr><tr>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><img src=\"http://localhost/greenstore/uploads/product11131.jpg\" style=\"width: 50px;\"/></td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">SHEA MOISTURE ARGAN BODY LOTION 384 ML</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">1 x &#8358;5,060</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><span class=\"bagde badge-warning\">Pending Order</span></td>\r\n                    						              </tr><tr>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">Delivery Fee</td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">&#8358;1,000</td>\r\n                						              </tr>\r\n                						              <tr>\r\n                						                 \r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><strong>Total</strong></td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\">&#8358;6,060</td>\r\n                						              </tr>\r\n                						              <tr>                						                 \r\n                						                  <td colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><p style=\"font-size: 12px; line-height: 20px\">Delivered within <strong>2 hours</strong> from 11-09-2023 00:12 am.</p></td>\r\n                						              </tr>\r\n</table><br/><p>Login to view all details.</p>', '11-09-2023 12:12 am'),
(0, 'Processing Order', 'conwunyirigbo@gmail.com', 'Bakan Bizo', '<p>Dear Chidiebere Onwunyirigbo</p><p>Your order on Bakan Bizo is being processed. See details below;</p><br/><table><tr style=\"border: 1px solid #ddd\">\r\n                    						                  <th colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0\">\r\n                    						                      <p style=\"font-size: 13px; color: #ff3399; text-transform:uppercase; font-family: \'open sans\'\">\r\n                                							         <strong>Order No. #</strong>148503 - 11-09-2023 00:12 am\r\n                                						          </p>\r\n                    						                  </th>\r\n                    						              </tr><tr>\r\n                        						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><img src=\"http://localhost/greenstore/uploads/product11131.jpg\" style=\"width: 50px;\"/></td>\r\n                        						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">SHEA MOISTURE ARGAN BODY LOTION 384 ML</td>\r\n                        						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">1 x &#8358;5,060</td>\r\n                        						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><span class=\"bagde badge-secondary\">Processing Order</span></td>\r\n                        						              </tr><tr>\r\n                    						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">Delivery Fee</td>\r\n                    						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">&#8358;1,000</td>\r\n                    						              </tr>\r\n                    						              <tr>\r\n                    						                 \r\n                    						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><strong>Total</strong></td>\r\n                    						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\">&#8358;6,060</td>\r\n                    						              </tr>\r\n                    						              <tr>                						                 \r\n                    						                  <td colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><p style=\"font-size: 12px; line-height: 20px\">Delivered within <strong>2 hours</strong> from 11-09-2023 00:12 am.</p></td>\r\n                    						              </tr>\r\n    </table><br/><p>Thanks for your patronage. <br/>Bakan Bizo Team.</p>', '11-09-2023 01:13 am'),
(0, 'Order Successful', 'conwunyirigbo@gmail.com', 'Bakan Gizo', '<p>Dear Chidiebere Onwunyirigbo</p><p>Your order on Bakan Gizo online store was successful. See details below;</p><br/><table><tr style=\"border: 1px solid #ddd\">\r\n                						                  <th colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0\">\r\n                						                      <p style=\"font-size: 13px; color: #ff3399; text-transform:uppercase; font-family: \'open sans\'\">\r\n                            							         <strong>Order No. #</strong>267512 - 18-09-2023 09:44 am\r\n                            						          </p>\r\n                						                  </th>\r\n                						              </tr><tr>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><img src=\"http://localhost/greenstore/uploads/product11126.jpg\" style=\"width: 50px;\"/></td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">BABY SOFTENING OIL 300ML</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">1 x &#8358;1,350</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><span class=\"bagde badge-warning\">Pending Order</span></td>\r\n                    						              </tr><tr>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">Delivery Fee</td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">&#8358;500</td>\r\n                						              </tr>\r\n                						              <tr>\r\n                						                 \r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><strong>Total</strong></td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\">&#8358;1,850</td>\r\n                						              </tr>\r\n                						              <tr>                						                 \r\n                						                  <td colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><p style=\"font-size: 12px; line-height: 20px\">Delivered within <strong>1 hours</strong> from 18-09-2023 09:44 am.</p></td>\r\n                						              </tr>\r\n</table><br/><p>Thanks for your patronage. <br/>Bakan Gizo Team.</p>', '18-09-2023 09:44 am'),
(0, 'New Order', 'order@bakangizo.com.ng', 'Bakan Gizo Admin', '<p>New order on Bakan Gizo Online Store. See details below;</p><br/><table><tr style=\"border: 1px solid #ddd\">\r\n                						                  <th colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0\">\r\n                						                      <p style=\"font-size: 13px; color: #ff3399; text-transform:uppercase; font-family: \'open sans\'\">\r\n                            							         <strong>Order No. #</strong>267512 - 18-09-2023 09:44 am\r\n                            						          </p>\r\n                						                  </th>\r\n                						              </tr><tr>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><img src=\"http://localhost/greenstore/uploads/product11126.jpg\" style=\"width: 50px;\"/></td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">BABY SOFTENING OIL 300ML</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">1 x &#8358;1,350</td>\r\n                    						                  <td style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\"><span class=\"bagde badge-warning\">Pending Order</span></td>\r\n                    						              </tr><tr>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">Delivery Fee</td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'\">&#8358;500</td>\r\n                						              </tr>\r\n                						              <tr>\r\n                						                 \r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><strong>Total</strong></td>\r\n                						                  <td colspan=\"2\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\">&#8358;1,850</td>\r\n                						              </tr>\r\n                						              <tr>                						                 \r\n                						                  <td colspan=\"4\" style=\"border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'\"><p style=\"font-size: 12px; line-height: 20px\">Delivered within <strong>1 hours</strong> from 18-09-2023 09:44 am.</p></td>\r\n                						              </tr>\r\n</table><br/><p>Login to view all details.</p>', '18-09-2023 09:44 am');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_session_id` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `paymentstatus` tinyint(1) NOT NULL,
  `transactionref` varchar(50) NOT NULL,
  `orderdate` varchar(50) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL,
  `seenstatus` tinyint(1) NOT NULL DEFAULT 0,
  `days` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `pickup_location` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cart_session_id`, `userid`, `status`, `paymentstatus`, `transactionref`, `orderdate`, `delivery_fee`, `seenstatus`, `days`, `type`, `pickup_location`) VALUES
(1, '148503', 6, 4, 1, '9487S1694387528', '11-09-2023 00:12 am', '1000.00', 1, '2 hours', 'delivery', ''),
(2, '267512', 3, 0, 1, '9760W1695026682', '18-09-2023 09:44 am', '500.00', 0, '1 hours', 'delivery', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_staff`
--

CREATE TABLE `order_delivery_staff` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_delivery_staff`
--

INSERT INTO `order_delivery_staff` (`id`, `order_id`, `staff_id`) VALUES
(1, 11, 2),
(2, 10, 2),
(3, 9, 1),
(4, 8, 1),
(5, 2, 3),
(6, 1, 3),
(7, 14, 2),
(8, 16, 1),
(9, 18, 1),
(10, 17, 3),
(11, 19, 2),
(12, 19, 1),
(13, 17, 1),
(14, 19, 2),
(15, 19, 3),
(16, 24, 2),
(17, 20, 2),
(18, 24, 1),
(19, 14, 11),
(20, 13, 16),
(21, 15, 17),
(22, 16, 16),
(23, 16, 10),
(24, 13, 10),
(25, 7, 17),
(26, 19, 17),
(27, 18, 16),
(28, 18, 17),
(29, 18, 17),
(30, 22, 15),
(31, 13, 16),
(32, 16, 0),
(33, 16, 16),
(34, 20, 15),
(35, 13, 16),
(36, 16, 16),
(37, 23, 15),
(38, 25, 15),
(39, 24, 17),
(40, 28, 16),
(41, 32, 13),
(42, 28, 13),
(43, 28, 16),
(44, 16, 16),
(45, 28, 16),
(46, 33, 16),
(47, 16, 16),
(48, 13, 16),
(49, 28, 16),
(50, 13, 16),
(51, 37, 15),
(52, 55, 15),
(53, 49, 15),
(54, 47, 15),
(55, 57, 8),
(56, 60, 15),
(57, 62, 18),
(58, 64, 18),
(59, 73, 18),
(60, 73, 0),
(61, 73, 18),
(62, 73, 0),
(63, 80, 18),
(64, 72, 18),
(65, 83, 0),
(66, 82, 15),
(67, 152, 19),
(68, 152, 0),
(69, 0, 15);

-- --------------------------------------------------------

--
-- Table structure for table `popular`
--

CREATE TABLE `popular` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `popular`
--

INSERT INTO `popular` (`id`, `categoryid`) VALUES
(0, 2),
(0, 11),
(0, 8),
(0, 4),
(0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `sn` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `categoryid` int(6) DEFAULT NULL,
  `addinfo` varchar(1000) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `oldprice` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `isonline` tinyint(1) DEFAULT NULL,
  `instock` tinyint(1) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `sales` int(6) DEFAULT NULL,
  `date_created` varchar(255) NOT NULL,
  `brandid` int(6) DEFAULT NULL,
  `api_id` int(11) DEFAULT NULL,
  `weight` decimal(6,2) NOT NULL,
  `stock` int(4) NOT NULL,
  `location_18047_stock` int(4) NOT NULL,
  `location_18841_stock` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `sn`, `name`, `description`, `categoryid`, `addinfo`, `price`, `oldprice`, `status`, `isonline`, `instock`, `views`, `sales`, `date_created`, `brandid`, `api_id`, `weight`, `stock`, `location_18047_stock`, `location_18841_stock`) VALUES
(962, 0, 'NESTLE COFFEE-MATE LIGHT 200G', 'NESTLE COFFEE-MATE LIGHT 200G', NULL, '', '800.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12409186, '0.00', 44, 0, 0),
(963, 0, 'BIO-OIL', 'BIO-OIL', NULL, '', '600.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12605389, '0.00', 24, 0, 0),
(964, 0, 'BIG SAM CHICKEN WINGS 1KG', 'BIG SAM CHICKEN WINGS 1KG', NULL, '', '2350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12605471, '0.00', -24000, -24000, -2000),
(965, 0, 'INDOMIE CHICKEN SUPER PACK 120G (CARTON)', 'INDOMIE CHICKEN SUPER PACK 120G (CARTON BY 40)', NULL, '', '4400.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 157238, 12605807, '0.00', 11, -21, 21),
(966, 0, 'INDOMIE CHICKEN SUPER PACK 120G (PCS)	', 'INDOMIE CHICKEN FLAVOR SUPER PACK 120G (PCS)	', NULL, '', '120.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 157238, 12606235, '0.00', 2280, 0, -740),
(967, 0, 'COCA-COLA ORIGINAL TASTE 60CL PET (PACK)', 'COCA-COLA ORIGINAL TASTE 60CL PET (PACK)', NULL, '', '1580.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 157015, 12611714, '0.00', 0, 544, 24),
(968, 0, 'SPRITE 60CL (PACK)', 'SPRITE 60CL (PACK)', NULL, '', '1600.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 150166, 12611730, '0.00', 401, 61, 22),
(969, 0, 'SPRITE 60CL ', 'SPRITE 60CL ', NULL, '', '140.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 150166, 12611735, '0.00', -2, 0, 0),
(970, 0, 'MIRINDA 50CL (PACK)', 'MIRINDA 50CL (PACK)', NULL, '', '1130.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 150175, 12613236, '0.00', -6, -4, 0),
(971, 0, 'MIRINDA 50CL PET', 'MIRINDA 50CL PET', NULL, '', '100.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 150175, 12613246, '0.00', 0, 0, 0),
(972, 0, 'MOUNTAIN DEW 50CL PACK', 'MOUNTAIN DEW 50CL PACK', NULL, '', '1100.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 150175, 12613258, '0.00', 0, 0, 0),
(973, 0, 'MOUNTAIN DEW 50CL PET', 'MOUNTAIN DEW 50CL PET', NULL, '', '100.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 150175, 12613260, '0.00', -23, 0, 0),
(974, 0, 'TEEM BITTER LEMON 50CL PET X PACK', 'TEEM BITTER LEMON 50CL PET X PACK', NULL, '', '1150.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 150175, 12613278, '0.00', 307, 76, 0),
(975, 0, 'ELIM TABLE WATER 75CL (PACK)', 'ELIM TABLE WATER 75CL (PACK)', NULL, '', '800.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 170161, 12613330, '0.00', -17, 188, -3),
(976, 0, 'LOYD GREEN TEA WITH LEMON HONEY & GINGER', 'LOYD GREEN TEA WITH LEMON HONEY & GINGER 40 G', NULL, '', '1350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673801, '0.00', 0, 5, 0),
(977, 0, 'LOYD GREEN TEA WITH RASPBERRY FLAVOUR 40', 'LOYD GREEN TEA WITH RASPBERRY FLAVOUR 30 G', NULL, '', '1150.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673813, '0.00', -3, -1, 0),
(978, 0, 'LOYD MINT MENTHA PIPERITA 40 G', 'LOYD MINT MENTHA PIPERITA 40 G', NULL, '', '1350.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673827, '0.00', 31, 10, 0),
(979, 0, 'LOYD GREEN TEA WITH LEMON & LEMONGRASS ', 'LOYD GREEN TEA WITH LEMON & LEMONGRASS 30 G', NULL, '', '1150.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673850, '0.00', 18, 6, 0),
(980, 0, 'WHITENING UV DEFENCE SPF30', 'BISMID WHITENING UV DEFENCE SPF30 CREAM 50ml', NULL, '', '4200.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12673860, '0.00', 0, 0, 0),
(981, 0, 'VITAMIN E OIL', 'BISMID 100% PURE VITAMIN E OIL 50ml', NULL, '', '2800.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12673871, '0.00', 6, 0, 0),
(982, 0, 'BISMID ACNE TONER 125ml', 'BISMID ACNE TONER 125ml', NULL, '', '1150.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12673881, '0.00', 3, 0, 0),
(983, 0, 'LOYD CRANBERRY & GINGER 40 G', 'LOYD CRANBERRY & GINGER 40 G', NULL, '', '1350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673882, '0.00', -4, 0, 0),
(984, 0, 'BISMID SKIN WHITENING CREAM 200ml', 'BISMID SKIN WHITENING CREAM 200ml', NULL, '', '5400.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12673885, '0.00', 4, 4, 0),
(985, 0, 'LOYD WARMING TEA GINGER, LEMON & HONEY ', 'LOYD WARMING TEA GINGER, LEMON & HONEY 40 G', NULL, '', '1350.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673891, '0.00', 10, 4, 0),
(986, 0, 'GLUTA WHITENING SERUM 45ml', 'BISMID GLUTA WHITENING SERUM 45ml', NULL, '', '2800.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12673893, '0.00', 0, 0, 0),
(987, 0, 'LOYD SUPPORT DIGESTION HERBAL INFUSION ', 'LOYD SUPPORT DIGESTION HERBAL INFUSION 40 G', NULL, '', '1350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673895, '0.00', 0, 1, 0),
(988, 0, 'LOYD GOOD NIGHTS SLEEP HERBAL INFUSION ', 'LOYD GOOD NIGHTS SLEEP HERBAL INFUSION 24 G', NULL, '', '1350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673903, '0.00', 0, -1, 0),
(989, 0, 'LOYD GREEN TEA WITH LEMON 30 G', 'LOYD GREEN TEA WITH LEMON 30 G', NULL, '', '870.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151407, 12673908, '0.00', 18, 3, 0),
(990, 0, 'MAGIC TUMMY & BODY FAT REDUCING TEA', 'MAGIC TUMMY & BODY FAT REDUCING TEA 40 G', NULL, '', '1180.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151409, 12673917, '0.00', 12, 3, 0),
(991, 0, 'MAGIC HERBAL TEA 40 G (7 TYPES)', 'MAGIC HERBAL TEA 40 G (7 TYPES)', NULL, '', '1200.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151409, 12673921, '0.00', -3, 44, -10),
(992, 0, 'MEGIC HERBAL TEA 40 G (18 VARIANTS)', 'MEGIC HERBAL TEA 40 G (18 VARIANTS)', NULL, '', '1200.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151409, 12673923, '0.00', 65, 91, 0),
(993, 0, 'MOISTURE GLOW WHITENING FACE CREAM 50G', 'BISMID MOISTURE GLOW WHITENING FACE CREAM (DAY TIME) 50G', NULL, '', '2700.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12674781, '0.00', 0, 0, 1),
(994, 0, 'BISMID TEA TREE OIL 12ml', 'BISMID TEA TREE OIL 12ml', NULL, '', '1200.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12674790, '0.00', 0, 0, 0),
(995, 0, 'BISMID INTENSIVE WHITENING CREAM 200ml', 'BISMID INTENSIVE WHITENING CREAM LUMINOUS COMPLEXION 200ml', NULL, '', '5400.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151408, 12674793, '0.00', 14, 0, 7),
(996, 0, 'OSLIV PICKWICK NATURAL HERBAL TEA 50 G', 'OSLIV PICKWICK NATURAL HERBAL TEA 50 G (ALL)', NULL, '', '780.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151622, 12674819, '0.00', 0, 0, -24),
(997, 0, 'SACM NATURAL HERBAL TEA 36 G', 'SACM NATURAL HERBAL TEA 36 G (ALL)', NULL, '', '980.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151623, 12674833, '0.00', 0, 0, 0),
(998, 0, 'IMPRA HERBAL TEA 60G', 'IMPRA HERBAL TEA 60G (ALL VARIETIES)', NULL, '', '900.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151624, 12674860, '0.00', 10, 2, 0),
(999, 0, 'TETLEY SUPER GREEN TEA BOOST 40 G Vit B6', 'TETLEY SUPER GREEN TEA BOOST 40 G (LIME & BERRY BURST) Vit B6', NULL, '', '1700.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151626, 12674867, '0.00', 9, 52, 9),
(1000, 0, 'TETLEY ORIGINAL 125 G', 'TETLEY ORIGINAL 125 G', NULL, '', '1290.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151626, 12674877, '0.00', 132, 46, 16),
(1001, 0, 'TETLEY DECAF X40 TEA BAGS 125 G', 'TETLEY DECAF X40 TEA BAGS 125 G', NULL, '', '2080.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151626, 12674882, '0.00', 0, 0, 11),
(1002, 0, 'TWINING HERBAL TEA 50G', 'TWINING HERBAL TEA (SWEET & CITRUS x 25 BAGS) 50G', NULL, '', '1300.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151627, 12674897, '0.00', -10, -3, 0),
(1003, 0, 'JUST A MINUTE HERBAL TEA 28 G', 'JUST A MINUTE LEMON & GREEN TEA 28 G (2 VIARIANTS)', NULL, '', '520.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12677031, '0.00', 0, 0, 0),
(1004, 0, 'QIHUANG RHEUMATISM TEA GRANULES ', 'QIHUANG RHEUMATISM TEA GRANULES ', NULL, '', '510.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151737, 12677034, '0.00', -49, -1, -22),
(1005, 0, 'JIANXI COUGH SPUTUM REMOVING HERBAL TEA ', 'JIANXI COUGH SPUTUM REMOVING HERBAL TEA 40 G', NULL, '', '1150.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12677038, '0.00', 0, 0, -18),
(1006, 0, 'LIPTON CLEAR GREEN TEA CLASSIC 27.5 G', 'LIPTON CLEAR GREEN TEA CLASSIC 27.5 G', NULL, '', '290.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151741, 12677043, '0.00', 60, 15, 0),
(1007, 0, 'LIPTON GREEN TEA MINT & CLASSIC 150 G', 'LIPTON GREEN TEA MINT & CLASSIC 150 G', NULL, '', '2600.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151741, 12679068, '0.00', 0, 0, 0),
(1008, 0, 'TROPICANA SLIM SWEETNER X 50STICKS MIX', 'TROPICANA SLIM SWEETNER X 50STICKS MIX', NULL, '', '2250.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12679075, '0.00', -25, 8, 6),
(1009, 0, 'TROPICANA SLIM LOW CALORIE SWEETENER 50', 'TROPICANA SLIM LOW CALORIE SWEETENER 50 G', NULL, '', '850.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12679080, '0.00', 77, 0, 0),
(1010, 0, 'GOURMET NUT POWER UP MIX NUTS 397 G (ALL', 'GOURMET NUT POWER UP MIX NUTS 397 G (ALL)', NULL, '', '3690.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151746, 12679809, '0.00', 48, 0, 0),
(1011, 0, 'TRS ALMONDS 375 G', 'TRS ALMONDS NUTS 375 G', NULL, '', '3380.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151748, 12679884, '0.00', 0, 15, 0),
(1012, 0, 'TRS POPPING CORN 500 G', 'TRS POPPING CORN 500 G', NULL, '', '740.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151748, 12680148, '0.00', -40, 5, 0),
(1013, 0, 'TRS ALMONDS 100 G', 'TRS ALMONDS 100 G', NULL, '', '1060.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151748, 12680185, '0.00', 18, -50, 22),
(1014, 0, 'GOURMET NUT FLAXSEED 141 G', 'GOURMET NUT FLAXSEED 141 G', NULL, '', '2600.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151746, 12680202, '0.00', 20, 5, 0),
(1015, 0, 'GOURMET NUTCHIA 141 G', 'GOURMET NUTCHIA 141 G', NULL, '', '2600.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151746, 12680217, '0.00', 8, 2, 0),
(1016, 0, 'GERBER BABY CEREALS 227g', 'NESTLE GERBER BABY CEREALS PACK 227g (ALL VARIANTS)', NULL, '', '2950.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12680327, '0.00', 8, 7, 6),
(1017, 0, 'BLUE DIAMOND ALMONDS SMOKEHOUSE 1.27 KG', 'BLUE DIAMOND ALMONDS SMOKEHOUSE 1.27 KG', NULL, '', '9100.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151759, 12680338, '0.00', 0, 0, 0),
(1018, 0, 'JOHN WEST TUNA CHUNKS 160g', 'JOHN WEST TUNA CHUNKS IN SPRING WATER 160g', NULL, '', '700.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151762, 12680359, '0.00', 0, 0, 0),
(1019, 0, 'HARVEST MORN CRUNCHY OAT GRANOLA RAISIN ', 'HARVEST MORN CRUNCHY OAT GRANOLA RAISIN & ALMOND 1 KG', NULL, '', '2470.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151764, 12680364, '0.00', 0, 0, 0),
(1020, 0, 'KIRKLAND DRY ROASTED ALMOND 1.13KG', 'KIRKLAND DRY ROASTED ALMOND 1.13KG', NULL, '', '7800.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151765, 12680390, '0.00', 12, 3, 0),
(1021, 0, 'AMOY DARK SOY SAUCE 150ml', 'AMOY DARK SOY SAUCE 150ml', NULL, '', '430.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151766, 12680404, '0.00', 0, 0, 0),
(1022, 0, 'GOURMET NUT PISTACHIOS 170 G', 'GOURMET NUT PISTACHIOS 170 G', NULL, '', '3470.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151746, 12680427, '0.00', 0, 0, 0),
(1023, 0, 'GOURMET NUT CHIA SEEDS 340 G', 'GOURMET NUT CHIA SEEDS 340 G', NULL, '', '3900.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151746, 12680454, '0.00', 4, 1, 0),
(1024, 0, 'MICHAELS ORGANIC SLIM GREEN TEA 250 G ', 'MICHAELS ORGANIC SLIM GREEN TEA 250 G', NULL, '', '3250.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151770, 12680668, '0.00', 0, 0, 0),
(1025, 0, 'GOURMET ALMONDS 227 G', 'GOURMET ALMONDS 227 G', NULL, '', '3470.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151746, 12680671, '0.00', 0, 0, 0),
(1026, 0, 'SIMPLY NATURE GOLDEN ROASTED FLAX SEED ', 'SIMPLY NATURE GOLDEN ROASTED FLAX SEED 425 G', NULL, '', '5200.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151774, 12680721, '0.00', 2, 2, 0),
(1027, 0, 'TATE LYLE LIGHT SOFT BROWN SUGAR 500 G', 'TATE LYLE LIGHT SOFT BROWN SUGAR 500 G', NULL, '', '1170.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151775, 12680740, '0.00', 16, 4, 0),
(1028, 0, 'MAGGI AROME LIQUID SEASONING 250ml', 'MAGGI AROME LIQUID SEASONING 250ml', NULL, '', '1030.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151768, 12680751, '0.00', 22, 11, 0),
(1029, 0, 'TATE LYLE DEMERARA CANE SUGAR 500 G', 'TATE LYLE DEMERARA CANE SUGAR 500 G', NULL, '', '1200.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151626, 12680757, '0.00', 45, 0, 0),
(1030, 0, 'SKIPPY CREAMY 462 G', 'SKIPPY CREAMY 462 G', NULL, '', '1410.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151779, 12680793, '0.00', 96, 24, 0),
(1031, 0, 'NESTLE NESQUIK CHOCOLATE FLAVOUR', 'NESTLE NESQUIK CHOCOLATE FLAVOUR 1.18kG', NULL, '', '3850.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12680796, '0.00', -2, 0, 0),
(1032, 0, 'TRS COCONUT OIL CUP 250ml', 'TRS COCONUT OIL CUP 250ml', NULL, '', '900.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12680802, '0.00', 32, 8, 0),
(1033, 0, 'CANDEREL SWEET DELICIOUS TASTE 40 G', 'CANDEREL SWEET DELICIOUS TASTE 40 G', NULL, '', '1500.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151784, 12680853, '0.00', -1, 38, 0),
(1034, 0, 'HUNGRY JACK PANCAKE 907g', 'HUNGRY JACK PANCAKE & WAFFLE MIX 907g', NULL, '', '1840.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12680855, '0.00', 88, 22, 0),
(1035, 0, 'MILLVILLE ROLLED OAT QUICK COOK1.19 KG', 'MILLVILLE ROLLED OAT QUICK COOK1.19 KG', NULL, '', '3400.00', '0.00', 1, 1, 1, NULL, NULL, '09-02-2021 09:40 AM', 151785, 12680884, '0.00', 37, 0, -1),
(1036, 0, 'CANDEREL SWEET DELIIOUDS TASTE 75 G', 'CANDEREL SWEET DELIIOUDS TASTE 75 G', NULL, '', '2100.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151784, 12680892, '0.00', -21, -5, 0),
(1037, 0, 'SKIPPY SUPER CHUNK PEANUT BUTTER 426 G', 'SKIPPY SUPER CHUNK PEANUT BUTTER 426 G', NULL, '', '1400.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151779, 12680916, '0.00', 96, 0, 0),
(1038, 0, 'CHOCEUR HO CHOCOLATE DRINK 400 Ge', 'CHOCEUR HO CHOCOLATE DRINK 400 Ge', NULL, '', '1630.00', '0.00', 1, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151786, 12680968, '0.00', 0, 0, 0),
(1039, 0, 'PRINGLES CHEDDAR CHEESE 158 G', 'PRINGLES 158 G ( SOUR & CHEDDAR)', NULL, '', '750.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151787, 12680984, '0.00', 16, 4, 0),
(1040, 0, 'ALFA TOMATO KETCHUP 400ml', 'ALFA TOMATO KETCHUP 400ml', NULL, '', '410.00', '0.00', 1, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12680989, '0.00', 0, 0, 0),
(1041, 0, 'FOOD LOVE MAYONNAISE 445 ML', 'FOOD LOVE MAYONNAISE 445 ML', NULL, '', '800.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151788, 12680995, '0.00', 116, 29, 0),
(1042, 0, 'PRINGLES ORIGINAL 149 G', 'PRINGLES ORIGINAL 149 G', NULL, '', '750.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151787, 12681001, '0.00', 20, 5, 0),
(1043, 0, 'KTC ALMOND OIL 200ml', 'KTC ALMOND OIL 200ml', NULL, '', '1860.00', '0.00', 1, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151791, 12681067, '0.00', -14, 28, 0),
(1044, 0, 'CADBURY DRINKING CHOCOLATE 500 G', 'CADBURY DRINKING CHOCOLATE 500 G', NULL, '', '3040.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151790, 12681077, '0.00', 17, 13, 0),
(1045, 0, 'GOYA ALL PURPOSE SEASONING ADOBO 226 G', 'GOYA ALL PURPOSE SEASONING ADOBO 226 G', NULL, '', '1180.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12681091, '0.00', 55, 28, 0),
(1046, 0, 'GERBER BABY CEREAL 454g', 'GERBER BABY SINGLE GRAIN CEREAL 454g', NULL, '', '2500.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 152792, 12681113, '0.00', 28, 28, 0),
(1047, 0, 'STUTE NO SUGAR ADDED EXTRA JAM 430 G (AL', 'STUTE NO SUGAR ADDED EXTRA JAM 430 G (ALL)', NULL, '', '2060.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151793, 12681121, '0.00', 60, 228, 86),
(1048, 0, 'FIRST CHOICE ADULT DOG FOOD 400 G', 'FIRST CHOICE ADULT DOG FOOD 400 G', NULL, '', '380.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151794, 12681143, '0.00', 280, 70, 0),
(1049, 0, 'QUAKER OATS OLD FASHIONED 2.26g', 'QUAKER OLD FASHIONED 2 IN 1 OATS  2.26g', NULL, '', '8250.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12681200, '0.00', 3, 1, 6),
(1050, 0, 'HEINZ VINEGAR MALT 568 ML', 'HEINZ VINEGAR MALT 568 ML', NULL, '', '750.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151796, 12681209, '0.00', 3, 21, 0),
(1051, 0, 'MORTON IODIZED SALT 737g', 'MORTON IODIZED SALT 737g', NULL, '', '870.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12681215, '0.00', 35, 0, 0),
(1052, 0, 'PRINCESS HAM 454g', 'PRINCESS HAM 454g', NULL, '', '2200.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151799, 12681272, '0.00', 42, 14, 1),
(1053, 0, 'NESTLE COFFEE MATE 400g', 'NESTLE COFFEE MATE 400g', NULL, '', '1480.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12681314, '0.00', -1, 0, 0),
(1054, 0, 'EARLS MEATY CHUNKS IN JELLY 400G MIX', 'EARLS MEATY IN JELLY 400/395GMIX', NULL, '', '450.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151795, 12681316, '0.00', 64, 16, 0),
(1055, 0, 'MAS CHOICES COCONUT CREAM 400 ML', 'MAS CHOICES  DE GREAT & UNIQUE COCONUT CREAM 400 ML', NULL, '', '440.00', '0.00', 1, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151800, 12681351, '0.00', 42, 0, 0),
(1056, 0, 'CADBURY DRINKING CHOCOLATE ', 'CADBURY DRINKING CHOCOLATE 250g', NULL, '', '500.00', '0.00', 1, 0, 0, NULL, NULL, '09-09-2020 00:00 AM', 214810, 12681362, '0.00', 0, 0, 0),
(1057, 0, 'FOOD LOVE MAYONNAISE 947 ML', 'FOOD LOVE MAYONNAISE 947 ML', NULL, '', '1433.33', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151788, 12681388, '0.00', 0, 0, 0),
(1058, 0, 'NESCAFE GOLD BLEND DECAFF 100 G', 'NESCAFE GOLD BLEND DECAFF 100 G', NULL, '', '2310.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12681390, '0.00', 0, -1, -24),
(1059, 0, 'ABBOTT SIMILAC POWDER MILK BASED INFANT ', 'ABBOTT SIMILAC POWDER MILK BASED INFANT FORMULA 658 G ', NULL, '', '14080.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151802, 12681392, '0.00', 2, 2, 0),
(1060, 0, 'HEINZ FRUIT CUSTARD (ALL VARIANTS)', 'HEINZ FRUIT CUSTARD 4 x 100g (ALL VARIANTS)', NULL, '', '1700.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151796, 12681403, '0.00', 252, 63, 0),
(1061, 0, 'ALGOOD PEANUT BUTTER CREAMY 510 G', 'ALGOOD PEANUT BUTTER CREAMY 510 G', NULL, '', '1350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151803, 12681424, '0.00', -2, 0, 0),
(1062, 0, 'NATURAL BROWN SUGAR 500 G', 'BLESSED CHILD FOODS NATURAL BROWN SUGAR 500 G', NULL, '', '1000.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151806, 12681460, '0.00', 21, 42, 24),
(1063, 0, 'STUMBO BUBBLE GUM POPS x 48 (PACK)', 'STUMBO BUBBLE GUM POPS x 48 (PACK)', NULL, '', '1390.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151808, 12681482, '0.00', 0, 0, 0),
(1064, 0, 'STUMBO BUBBLE GUM POPS (PC)', 'STUMBO BUBBLE GUM POPS (PC)', NULL, '', '50.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151808, 12681493, '0.00', 0, 0, 0),
(1065, 0, 'DANACID 12 * 8(PACK)', 'DANACID 12 * 8 (PACK)', NULL, '', '680.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151811, 12681829, '0.00', 15, 29, 19),
(1066, 0, 'CHECKERS CUSTARD POWDER VANILLA FLAVOR ', 'CHECKERS CUSTARD POWDER VANILLA FLAVOR 2 KG', NULL, '', '2080.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151870, 12685755, '0.00', 17, 13, 4),
(1067, 0, 'MEMBERS MARK TM RICH & CREAMY COFFE 1.7K', 'MEMBERS MARK TM RICH & CREAMY NON-DAIRY COFFEE CREAM 1.7KG', NULL, '', '3680.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12685769, '0.00', 48, 12, 0),
(1068, 0, 'GOLDS VANILLA FLAVORED CUSTARD POWDER ', 'GOLDS VANILLA FLAVORED CUSTARD POWDER 2 KG', NULL, '', '1850.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151873, 12685809, '0.00', 0, 0, 0),
(1069, 0, 'EVER WHIITE NATURAL EXTRACT 1380ML', 'EVER WHIITE NATURAL EXTRACT CARROT & PAPAYA WHITENING SHOWER GEL 1380ML', NULL, '', '1650.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151874, 12685832, '0.00', 8, 0, 0),
(1070, 0, 'PALMOLIVE NATURALS HYDRA BALANCE SHAMPOO', 'PALMOLIVE NATURALS HYDRA BALANCE SHAMPOO 2 IN 1 350 ML', NULL, '', '850.00', '0.00', 1, 1, 1, NULL, NULL, '09-07-2021 09:40 AM', 151875, 12685899, '0.00', 7, 5, 5),
(1071, 0, 'HUDA BEAUTY MASCARA & EYELINER', 'HUDA BEAUTYMAX FENFEN MASCARA & EYELINER WATERPROOF x 1 (PCS) ', NULL, '', '400.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151876, 12685917, '0.00', -1, 0, 0),
(1072, 0, 'E45 DERMA PROTECT MOISTURIZING LOTION ', 'E45 DERMA PROTECT MOISTURIZING LOTION 500 ML', NULL, '', '5460.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151877, 12685942, '0.00', -18, 0, 6),
(1073, 0, 'KISS BEAUTY MAKE UP FIXER FACE CARE 120M', 'KISS BEAUTY MAKE UP FIXER FACE CARE 120 ML', NULL, '', '1000.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151878, 12685949, '0.00', 6, 0, 6),
(1074, 0, 'DR MIRACLE DAILY MOISTURIZING GRO OIL ', 'DR MIRACLE DAILY MOISTURIZING GRO OIL 118 ML', NULL, '', '1350.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12685969, '0.00', 0, 0, 0),
(1075, 0, 'SHEA MOISTURE ARGAN & RAW SHEA SOAP 230G', 'SHEA MOISTURE ARGAN  OIL & RAW SHEA SOAP  FRANKINCENSE & MYRRH EXRACT 230 G', NULL, '', '2970.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686012, '0.00', 5, 0, 0),
(1076, 0, 'RED CHERRY EYELASHES ', 'RED CHERRY EYELASHES ', NULL, '', '500.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686015, '0.00', 4, 0, -1),
(1077, 0, 'SHEA MOISTURE AFRICAN BLANCK SOAP 354 ML', 'SHEA MOISTURE AFRICAN BLANCK SOAP ECZEMA & PSORIASIS THERAPY BODY WASH 354 ML', NULL, '', '7150.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686061, '0.00', 7, 0, 0),
(1078, 0, 'GBC SUPER AIR FRESHENER 500 ML', 'GBC SUPER AIR FRESHENER 500 ML', NULL, '', '410.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151881, 12686080, '0.00', 0, 0, 0),
(1079, 0, 'DAVIS EYE LINER & LIP LINER PENCIL', 'DAVIS EYE LINER & LIP LINER PENCIL WATERPROOF', NULL, '', '200.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686084, '0.00', -84, 0, 0),
(1080, 0, 'TOP BREEZE SWEETY AROMA AUTOMATIC SPRAY ', 'TOP BREEZE SWEETY AROMA AUTOMATIC SPRAY 300 ML', NULL, '', '650.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151888, 12686089, '0.00', 0, 0, 0),
(1081, 0, 'MICOLOR 12 COLOR EYE SHADOW', 'MICOLOR 12 COLOR EYE SHADOW', NULL, '', '950.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151889, 12686116, '0.00', 0, 0, 0),
(1082, 0, 'CLEARASIL MULTI-ACTION EXFOLIATING  ', 'CLEARASIL MULTI-ACTION EXFOLIATING SCRUB 150 ML', NULL, '', '3900.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151890, 12686126, '0.00', 3, 1, 0),
(1083, 0, 'CHAMP FOR MEN BODY SPRAY 236 ML', 'CHAMP FOR MEN BODY SPRAY 236 ML', NULL, '', '1400.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 152035, 12686127, '0.00', 78, 0, 0),
(1084, 0, 'FRESH LOOK COLORBLENDS CARE 120 ML', 'FRESH LOOK COLORBLENDS CARE 120 ML', NULL, '', '1100.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151891, 12686151, '0.00', 30, 10, 0),
(1085, 0, 'NEUTROGENA ALCOHOL FREE TONER 250 ML ', 'NEUTROGENA ALCOHOL FREE TONER 250 ML ', NULL, '', '4200.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686163, '0.00', 2, -6, -2),
(1086, 0, 'SHEA MOISTURE OLIVE & GREEN TEA BODY 177', 'SHEA MOISTURE OLIVE & GREEN TEA BODY BUTTER AVOCADO 177 ML', NULL, '', '5060.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686177, '0.00', 1, 0, 1),
(1087, 0, 'PALMERS COCOA BUTTER FORMULA FOR MEN ', 'PALMERS COCOA BUTTER FORMULA FOR MEN 250 ML', NULL, '', '2430.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151893, 12686182, '0.00', 2, 0, 2),
(1088, 0, 'PALMERS COCOA BUTTER FORMULA FOR MEN ', 'PALMERS COCOA BUTTER FORMULA FOR MEN 400 ML', NULL, '', '3220.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151893, 12686190, '0.00', 0, 0, 0),
(1089, 0, 'SHEA MOISTURE AFRICAN BLANCK SOAP 354 ML', 'SHEA MOISTURE AFRICAN BLANCK SOAP ECZEMA & PSORIASIS THERAPY BODY LOTION 354 ML', NULL, '', '7150.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686195, '0.00', 9, 0, 0),
(1090, 0, 'SHEA MOISTURE AFRICAN BLANCK SOAP 354 ML', 'SHEA MOISTURE AFRICAN BLANCK SOAP  DEP CLEANSING SHAMPOO TEA TREE OIL & WILLOW BARK EXTRACT 384 ML', NULL, '', '5060.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686213, '0.00', 12, 0, 0),
(1091, 0, 'MILTON STERILIZING TABLETS 128 G  ', 'MILTON MAXIMUM PROTECTION STERILIZING TABLET  128 G', NULL, '', '2320.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151894, 12686325, '0.00', 0, 0, 2),
(1092, 0, 'L.A. GIRL PRO. COVERAGE FOUNDATION 28 ML', 'L.A. GIRL PRO. COVERAGE FOUNDATION 28 ML', NULL, '', '3650.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151895, 12686330, '0.00', 11, 11, 0),
(1093, 0, 'WILKO INSTANT HAND SANITIZER 200 ML', 'WILKO INSTANT HAND SANITIZER 200 ML', NULL, '', '2000.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151896, 12686337, '0.00', 254, 0, 0),
(1094, 0, ' NEUROGENA OIL FREE ACNE WASH 177 ML', ' NEUROGENA OIL FREE ACNE WASH 177 ML', NULL, '', '4410.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686350, '0.00', 2, 0, 0),
(1095, 0, 'WANDAYA TM 3D BEAUTY PUFF', 'WANDAYA TM  BEAUTY NAIL TOOL3D BEAUTY PUFF ', NULL, '', '500.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151897, 12686351, '0.00', -36, 0, 0),
(1096, 0, 'JORDANA POWDER BRONZER 7.4 G', 'JORDANA POWDER BRONZER 7.4 G', NULL, '', '1050.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151898, 12686359, '0.00', 0, 0, 0),
(1097, 0, 'ENLIVEN REFRESHING SHOWER GEL 500 ML', 'ENLIVEN REFRESHING SHOWER GEL 500 ML', NULL, '', '850.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686370, '0.00', 0, 0, 0),
(1098, 0, 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL ', 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL STRENGTHEN & RESTORE STYLING LOTION 236 ML', NULL, '', '5060.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686374, '0.00', 0, 0, 0),
(1099, 0, 'MILANI MINERALS COMPACT MAKEUP 8.5 G', 'MILANI MINERALS COMPACT MAKEUP 8.5 G', NULL, '', '3500.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151903, 12686380, '0.00', 37, 35, 8),
(1100, 0, 'ENLIVEN REFRESHING SHOWER GEL 500 ML', 'ENLIVEN REFRESHING SHOWER GEL 500 ML', NULL, '', '850.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686385, '0.00', 0, 0, 0),
(1101, 0, 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL ', 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL STRENGTHEN & GROW SHAMPOO 384 ML', NULL, '', '5060.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686389, '0.00', 0, 0, 0),
(1102, 0, 'VOOM SCOURING POWDER 500 G ', 'VOOM SCOURING POWDER 500 G ', NULL, '', '250.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151905, 12686401, '0.00', -1, 0, 0),
(1103, 0, 'MARY KAY COVERAGE FOUNDATION 29 ML', 'MARY KAY COVERAGE FOUNDATION 29 ML', NULL, '', '5100.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151906, 12686405, '0.00', 17, 0, 0),
(1104, 0, 'SHEA MOISTURE ORGANIC RAW SOAP 101 G', 'SHEA MOISTURE ORGANIC RAW SHEA BUTTER SOAP 101 G', NULL, '', '2970.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686406, '0.00', 0, 0, 0),
(1105, 0, 'MARY KAY MATTE- WEAR FOUNDATION 29 ML', 'MARY KAY TIMEWISE MATTE- WEAR LIQUID FOUNDATION 29 ML', NULL, '', '6800.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151906, 12686413, '0.00', 0, 0, 0),
(1106, 0, 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL ', 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL STRENGTHEN, GROW & RESTORE EDGE TREAMEN 113 ML', NULL, '', '4930.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686414, '0.00', 9, 0, 0),
(1107, 0, 'PURIT ANTISEPTIC 250 ML ', 'PURIT ANTISEPTIC 250 ML ', NULL, '', '560.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151907, 12686415, '0.00', 14, 14, 0),
(1108, 0, 'HANDY ANDY CREAM SPRING FRESH 750 ML', 'HANDY ANDY CREAM SPRING FRESH 750 ML', NULL, '', '1375.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151908, 12686433, '0.00', 89, 0, 7),
(1109, 0, 'NATURE SECRETE DARK SPOT CORRECTOR 100G', 'NATURE SECRETE DARK SPOT CORRECTOR 100G', NULL, '', '1800.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151910, 12686436, '0.00', 12, 0, 0),
(1110, 0, 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL ', 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL STRENGTHEN, GROW & RESTORE LEAVE-IN CONDITIONER 453 G', NULL, '', '6080.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686437, '0.00', 16, 0, 0),
(1111, 0, 'DETTOL POWER AND FRESH ANTI-BACTERIAL ', 'DETTOL POWER AND FRESH ANTI-BACTERIAL 1 L( ALL VARIANT)', NULL, '', '1300.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151911, 12686439, '0.00', 57, 10, 0),
(1112, 0, 'SHEA MOISTURE HEAD-TO-TOE NOURISHING 444', 'SHEA MOISTURE HEAD-TO-TOE NOURISHING HYDRAION 100% EXTRA VIRGIN COCONUT OIL 444 ML', NULL, '', '6550.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686446, '0.00', 12, 0, 0),
(1113, 0, 'SALVON ANTISEPTIC PROFESSIONAL GERM ', 'SALVON ANTISEPTIC PROFESSIONAL GERM KILLER 750 ML', NULL, '', '1700.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151912, 12686451, '0.00', 12, 4, 0),
(1114, 0, 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL ', 'SHEA MOISTURE JAMAICAN BLACK CASTOR OIL STRENGHEN, GROW & RESTORE TREATMENT MASQUE 340 G', NULL, '', '6080.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686455, '0.00', 0, 0, 0),
(1115, 0, 'JOHNSON BABY SHAMPOO CAMOMILA 500 ML', 'JOHNSON BABY SHAMPOO CAMOMILA 500 ML', NULL, '', '1420.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151912, 12686463, '0.00', 4, 4, 0),
(1116, 0, 'LISTERINE ANTISEPTICO ORAL STAY WHITE ', 'LISTERINE ANTISEPTICO ORAL STAY WHITE 500 ML', NULL, '', '1820.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', 151913, 12686472, '0.00', 11, 0, 0),
(1117, 0, 'JORDANA BROW/ EYELINER BROWN', 'JORDANA BROW/ EYELINER BROWN                                                                                                    ', NULL, '', '570.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151898, 12686484, '0.00', 8, 0, 0),
(1118, 0, 'KUZA JAMAICAN BLACK CASTOR OIL ORIGINAL ', 'KUZA JAMAICAN BLACK CASTOR OIL ORIGINAL 118 ML', NULL, '', '3380.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151914, 12686487, '0.00', 6, 7, -1),
(1119, 0, 'FRESH LOOK COLORBLENDS CONTACT LENSES', 'FRESH LOOK COLORBLENDS CONTACT LENSES', NULL, '', '1050.00', '0.00', 0, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151915, 12686490, '0.00', 0, 0, 0),
(1120, 0, 'CLEAN & CLEAR BLACK HEAD CLEARING CLEANS', 'CLEAN & CLEAR BLACK HEAD CLEARING CLEANSER 200ML', NULL, '', '2500.00', '0.00', 0, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151912, 12686494, '0.00', -4, 0, 0),
(1121, 0, 'JORDANA BROW/ EYELINER DARK BROWN', 'JORDANA BROW/ EYELINER DARK BROWN', NULL, '', '570.00', '0.00', 0, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151898, 12686497, '0.00', 0, 0, 0),
(1122, 0, 'ADIDAS FOR WOMEN SHAPE 250 ML', 'ADIDAS FOR WOMEN SHAPE 250 ML', NULL, '', '1250.00', '0.00', 0, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 151916, 12686504, '0.00', 98, 0, 0),
(1123, 0, 'DERMACOL WATERPROOF MASCARA', 'DERMACOL WATERPROOF MASCARA', NULL, '', '950.00', '0.00', 1, 1, 0, NULL, NULL, '23-07-2021 09:40 AM', 151917, 12686505, '0.00', 0, 0, 0),
(1124, 0, 'SHEA MOISTURE YUCCA & PLANTAIN 384 ML', 'SHEA MOISTURE YUCCA & PLANTAIN  ANTI-BREAKAGE STRENGTHNING CONDITIONER 384 ML', NULL, '', '5060.00', '0.00', 0, 0, 0, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686513, '0.00', 0, 0, 0),
(1125, 0, 'TANGO MILK MOCHA ALMONDS CHIPS 7.5 G', 'TANGO MILK MOCHA ALMONDS CHIPS 7.5 G', NULL, '', '1750.00', '0.00', 0, 0, 1, NULL, NULL, '23-07-2021 09:40 AM', 151918, 12686514, '0.00', 4, 2, 0),
(1126, 0, 'BABY SOFTENING OIL 300ML', '<p>BABY SOFTENING OIL 300ML</p>', NULL, '', '1350.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 0, 12686515, '0.00', 24, 6, 0),
(1127, 0, 'SHEA MOISTURE COCONUT & HIBISCUS 384 ML', '<p>SHEA MOISTURE COCONUT &amp; HIBISCUS BODY WASH 384 ML</p>', NULL, '', '5060.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 0, 12686517, '0.00', 6, 0, 0),
(1128, 0, 'HANDY ANDY CREAM AMMONIA FRESH 750 ML', '<p>HANDY ANDY CREAM AMMONIA FRESH 750 ML</p>', NULL, '', '1370.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', NULL, 12686519, '0.00', 106, 0, 9),
(1129, 0, 'SHEA MOISTURE SUPERFRUIT COMPLEX SOAP ', '<p>SHEA MOISTURE SUPERFRUIT COMPLEX SOAP 230 G</p>', NULL, '', '2970.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 0, 12686522, '0.00', 2, 0, 0),
(1130, 0, 'ENLIVEN FRESH MINT MOUTH WASH 500 ML', '<p>ENLIVEN FRESH MINT MOUTH WASH 500 ML</p>', NULL, '', '1080.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 0, 12686524, '0.00', 4, 1, 0),
(1131, 0, 'SHEA MOISTURE ARGAN BODY LOTION 384 ML', '<p>SHEA MOISTURE ARGAN &amp; RAW SHEA BODY LOTION 384 ML</p>', NULL, '', '5060.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 0, 12686525, '0.00', 0, 0, 0),
(1132, 0, 'JOHNSONS BABY OIL 414 ML', '<p>JOHNSONS BABY OIL 414 ML</p>', NULL, '', '2340.00', '0.00', 1, 1, 1, NULL, NULL, '23-07-2021 09:40 AM', 0, 12686529, '0.00', 20, 5, 0),
(1133, 1, 'itel S23 6.6', '<p>The phone comes with a 90 Hz refresh rate 6.60-inch touchscreen display offering a resolution of 720x1612 pixels (HD+). Itel S23 is powered by an octa-core Unisoc T606 processor. It comes with 4GB of RAM. The Itel S23 runs Android 12 and is powered by a 5000mAh battery.&nbsp;<strong>The Itel S23 supports proprietary fast charging.</strong></p>\r\n<p>As far as the cameras are concerned, the Itel S23 on the rear packs 50-megapixel camera. It has a single front camera setup for selfies, featuring an 8-megapixel sensor.</p>\r\n<p>Itel S23 is based on Android 12 and packs 256GB of inbuilt storage that can be expanded via microSD card (up to 1000GB).</p>\r\n<p>Connectivity options on the Itel S23 include Wi-Fi with active 4G on both SIM cards. Sensors on the phone include fingerprint sensor. The Itel S23 supports face unlock.</p>', NULL, '<h2 class=\"hdr -upp -fs14 -m -pam\">SPECIFICATIONS</h2>\r\n<ul class=\"-pvs -mvxs -phm -lsn\">\r\n<li class=\"-pvxs\"><span class=\"-b\">SKU</span>: IT724MP4O4KMVNAFAMZ</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Product Line</span>: Itel Mobile</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Model</span>: Itel S23</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Production Country</span>: China</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Size (L x W x H cm)</span>: 146.3 x 70.9 x 7.6 mm</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Weight (kg)</span>: 0.19</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Certifications</span>: Hong Kong Made</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Color</span>: WHITE</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Main Material</span>: Glass</li>\r\n<li class=\"-pvxs\"><span class=\"-b\">Care Label</span>: dispose responsibly</li>\r\n</ul>', '93000.00', '117000.00', 1, 1, 1, NULL, NULL, '11-09-2023 10:47 AM', 2, NULL, '0.00', 0, 0, 0),
(1134, 2, 'Apple IPhone 14 Pro Max 6.7\'\' 6GB 128GB ROM Nano SIM - Gold', '<p><strong>The best iPhone ever, version 2022,</strong>&nbsp;size XL - we have the iPhone 14 Pro Max. The list of novelties this year includes the notch morphing into a pill, the introduction of an Always-On display, and an all-new primary camera - and while you can get all of that on the 14 Pro, the extra screen estate and longevity coupled with the Max\'s \'ultimate\' status mean it has a market niche of its own.</p>\r\n<p>The Face ID notch that\'s been with us since the iPhone X was nobody\'s favorite, and perhaps its reincarnation as a pill is a step towards its eventual removal. But not before turning the eyesore into a feature - the pill is a Dynamic Island of notifications, blurring the line between hardware and software.</p>\r\n<p>In a similar vein is the Always-On display - a software feature only made possible now in Apple\'s world thanks to LTPO displays being able to ramp down to 1Hz refresh rate.</p>\r\n<p>A massive increase in brightness is also among the key developments this year,&', NULL, '<h2 class=\"hdr -upp -fs14 -m -pam\">KEY FEATURES</h2>\r\n<div class=\"markup -pam\">\r\n<ul>\r\n<li>6.7-Inch&nbsp; Display</li>\r\n<li>Nano SIM</li>\r\n<li>6GB RAM, 128GB ROM</li>\r\n<li>iOS 16 up to&nbsp;iOS 16.02</li>\r\n<li>48MP + 12MP + 12MP Rear Camera</li>\r\n<li>12MP&nbsp; Front Camera</li>\r\n<li>Face ID, 5G Network</li>\r\n<li>4323mAh non removable Li-Lon Battery</li>\r\n</ul>\r\n<h2 class=\"hdr -upp -fs14 -m -pam\">WHAT&rsquo;S IN THE BOX</h2>\r\n<div class=\"markup -pam\">iPhone 14 Pro Max&nbsp;USB?C to Lightning Cable&nbsp;</div>\r\n</div>', '1029999.00', '2999999.00', 1, 1, 1, NULL, NULL, '11-09-2023 10:52 AM', 3, NULL, '0.00', 0, 0, 0),
(1306, 3, 'Two-in-one T55promax Smart Watch Bluetooth Headset', '<p>Welcome to my store, For more products,click seller information to enter ourstore for purchaseClick on the Jumia icon to enter our store for more quality productsThis is smart watch T55PRO MAX which comes with a lot features such as-Making calls -Picking calls too from the connected phone through it-Check phonebook(contact list)-Call logs ( missed calls, dial calls, and also received calls )It can also serve as an health tracking device&nbsp; because it has the ability to-Read blood pressure -Read the heart rate-Check caloriesAnd also count steps&nbsp;It can also serve as a notifying device for some of the app on the connected phone ( apps like)-Facebook-WhatsApp -Instagram -TwitterAnd also Gmail too. etc&nbsp;It has some amazing features like-Wallpaper choice display-Alarm-Stopwatch -Thermometer-music player-Camera-find phone&nbsp;<br />One of the amazing fact about this watch is that it comes with an extra&nbsp; STRAPFirst, Supports both Android and IOS. However, the adaptation pl', NULL, '<table border=\"1\" cellspacing=\"1\" cellpadding=\"1\">\r\n<tbody>\r\n<tr>\r\n<td><a href=\"https://www.jumia.com.ng/pen-flash-drive-3.0-32gb-metal-otg-micro-usb-type-c-eaget-mpg2945240.html\" data-cke-saved-href=\"www.jumia.com.ng/pen-flash-drive-3.0-32gb-metal-otg-micro-usb-type-c-eaget-mpg2945240.html\"><img src=\"https://ng.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/12/7540452/1.jpg?4970\" alt=\"\" data-cke-saved-src=\"https://ng.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/12/7540452/1.jpg?4970\" data-=\"\" data-src=\"https://ng.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/12/7540452/1.jpg?4970\" /><br /></a></td>\r\n<td><a href=\"https://www.jumia.com.ng/pen-flash-drive-3.0-64gb-metal-otg-micro-usb-type-c-eaget-mpg2945239.html\" data-cke-saved-href=\"https://www.jumia.com.ng/generic-wireless-earpods-bluetooth-5.0-earphones-pink-for-girls-202242543.html\"><img src=\"https://ng.jumia.is/unsafe/fit-in/300x300/filters:fill(white)/product/01/4180352/1.jpg?2775\" alt=\"\" data', '9999.00', '14999.00', 1, 1, 1, NULL, NULL, '11-09-2023 12:17 PM', 0, NULL, '0.00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `categoryid` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `productid`, `categoryid`) VALUES
(11, 2, 2),
(12, 2, 6),
(13, 2, 7),
(14, 2, 16),
(18, 4, 1),
(19, 4, 6),
(20, 4, 15),
(21, 4, 16),
(22, 1, 2),
(23, 1, 6),
(24, 1, 7),
(25, 5, 20),
(28, 7, 2),
(29, 7, 9),
(34, 6, 2),
(35, 6, 9),
(38, 9, 2),
(39, 1132, 2),
(40, 1132, 11),
(41, 1132, 9),
(42, 1132, 13),
(43, 1131, 2),
(44, 1131, 3),
(45, 1131, 7),
(46, 1131, 9),
(47, 1131, 13),
(48, 1130, 11),
(49, 1130, 7),
(50, 1130, 9),
(51, 1130, 13),
(52, 1129, 2),
(53, 1129, 3),
(54, 1129, 7),
(55, 1129, 9),
(56, 1129, 13),
(57, 1128, 11),
(58, 1128, 8),
(59, 1128, 9),
(60, 1128, 13),
(61, 1127, 7),
(62, 1127, 9),
(63, 1127, 13),
(64, 1126, 2),
(65, 1126, 7),
(66, 1126, 9),
(67, 1126, 13),
(89, 1134, 4),
(90, 1133, 4),
(91, 1306, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_colours`
--

CREATE TABLE `product_colours` (
  `id` int(11) NOT NULL,
  `productid` int(6) NOT NULL,
  `colourid` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_colours`
--

INSERT INTO `product_colours` (`id`, `productid`, `colourid`) VALUES
(5, 42384, 2),
(1159, 42385, 2),
(1195, 41635, 32392),
(1196, 42720, 32392),
(1197, 47854, 33242),
(1198, 47953, 33242),
(1199, 47954, 33242);

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` int(11) NOT NULL,
  `productid` int(6) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `api_id` int(11) NOT NULL,
  `product_api_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`id`, `productid`, `photo`, `api_id`, `product_api_id`) VALUES
(1, 1, 'product11.jpg', 0, 0),
(3, 2, 'product12.jpg', 0, 0),
(5, 3, 'product13.jpg', 0, 0),
(6, 4, 'product14.jpg', 0, 0),
(7, 5, 'product15.jpg', 0, 0),
(8, 6, 'product16.jpg', 0, 0),
(9, 7, 'product17.jpg', 0, 0),
(10, 1132, 'product11132.jpg', 0, 0),
(11, 1131, 'product11131.jpg', 0, 0),
(12, 1130, 'product11130.jpg', 0, 0),
(13, 1129, 'product11129.jpg', 0, 0),
(14, 1128, 'product11128.jpg', 0, 0),
(15, 1127, 'product11127.jpg', 0, 0),
(16, 1126, 'product11126.jpg', 0, 0),
(30, 1134, 'product11134.jpg', 0, 0),
(31, 1134, 'product21134.jpg', 0, 0),
(32, 1134, 'product31134.jpg', 0, 0),
(33, 1133, 'product11133.jpg', 0, 0),
(34, 1133, 'product21133.jpg', 0, 0),
(35, 1133, 'product31133.jpg', 0, 0),
(36, 1306, 'product11306.jpg', 0, 0),
(37, 1306, 'product21306.jpg', 0, 0),
(38, 1306, 'product31306.jpg', 0, 0),
(39, 1306, 'product41306.jpg', 0, 0),
(40, 1306, 'product51306.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(11) NOT NULL,
  `colourid` int(6) NOT NULL,
  `productid` int(6) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `productid` int(6) NOT NULL,
  `sizeid` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quickfind`
--

CREATE TABLE `quickfind` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quickfind`
--

INSERT INTO `quickfind` (`id`, `categoryid`) VALUES
(0, 2),
(0, 3),
(0, 12),
(0, 7),
(0, 4),
(0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_settings`
--

CREATE TABLE `restaurant_settings` (
  `id` int(11) NOT NULL,
  `duration` int(3) NOT NULL,
  `pickup_time` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_settings`
--

INSERT INTO `restaurant_settings` (`id`, `duration`, `pickup_time`) VALUES
(2, 60, 15);

-- --------------------------------------------------------

--
-- Table structure for table `roleauth`
--

CREATE TABLE `roleauth` (
  `id` int(11) NOT NULL,
  `roleid` int(6) NOT NULL,
  `groupcode` varchar(20) NOT NULL,
  `menucode` varchar(20) NOT NULL,
  `allow_new` tinyint(3) NOT NULL,
  `allow_view` tinyint(3) NOT NULL,
  `allow_update` tinyint(3) NOT NULL,
  `allow_delete` tinyint(3) NOT NULL,
  `allow_auth` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roleauth`
--

INSERT INTO `roleauth` (`id`, `roleid`, `groupcode`, `menucode`, `allow_new`, `allow_view`, `allow_update`, `allow_delete`, `allow_auth`) VALUES
(0, 0, 'torder', 'torder', 1, 1, 1, 1, 1),
(0, 0, 'tstatus', 'pending', 1, 1, 1, 1, 1),
(0, 0, 'tstatus', 'processing', 1, 1, 1, 1, 1),
(0, 2, 'tbrand', 'tbrand', 0, 1, 1, 0, 1),
(0, 2, 'tcategory', 'tcategory', 0, 1, 1, 0, 1),
(0, 2, 'tproduct', 'tproduct', 1, 1, 1, 0, 1),
(0, 1, 'torder', 'torder', 1, 1, 1, 1, 1),
(0, 1, 'tstatus', 'delivered', 1, 1, 1, 1, 1),
(0, 1, 'tstatus', 'processing', 1, 1, 1, 1, 1),
(0, 1, 'tstatus', 'ready_to_ship', 1, 1, 1, 1, 1),
(0, 1, 'tstatus', 'shipped', 1, 1, 1, 1, 1),
(0, 3, 'dstaff', 'dstaff', 1, 1, 1, 1, 1),
(0, 3, 'tcustomer', 'tcustomer', 0, 1, 1, 0, 1),
(0, 3, 'torder', 'torder', 1, 1, 1, 1, 1),
(0, 3, 'tproduct', 'tproduct', 0, 1, 1, 0, 1),
(0, 3, 'tstatus', 'cancelled', 1, 1, 1, 1, 1),
(0, 3, 'tstatus', 'delivered', 1, 1, 1, 1, 1),
(0, 3, 'tstatus', 'pending', 1, 1, 1, 1, 1),
(0, 3, 'tstatus', 'processing', 1, 1, 1, 1, 1),
(0, 3, 'tstatus', 'ready_to_ship', 1, 1, 1, 1, 1),
(0, 3, 'tstatus', 'shipped', 1, 1, 1, 1, 1),
(0, 4, 'dstaff', 'dstaff', 1, 1, 1, 0, 1),
(0, 4, 'security', 'changepwd', 1, 1, 1, 0, 1),
(0, 4, 'security', 'tuser', 0, 1, 0, 0, 0),
(0, 4, 'settings', 'tcolour', 1, 1, 1, 0, 1),
(0, 4, 'settings', 'tcontent', 1, 1, 1, 0, 1),
(0, 4, 'settings', 'tdelivery', 1, 1, 1, 0, 1),
(0, 4, 'settings', 'tgeneral', 1, 1, 1, 0, 1),
(0, 4, 'settings', 'tsize', 1, 1, 1, 0, 1),
(0, 4, 'settings', 'tslider', 1, 1, 1, 0, 1),
(0, 4, 'tbanner', 'tbanner', 1, 1, 1, 0, 1),
(0, 4, 'tbrand', 'tbrand', 1, 1, 1, 0, 1),
(0, 4, 'tcategory', 'tcategory', 1, 1, 1, 0, 1),
(0, 4, 'tcustomer', 'tcustomer', 1, 1, 1, 0, 1),
(0, 4, 'torder', 'torder', 1, 1, 1, 0, 1),
(0, 4, 'tproduct', 'tproduct', 1, 1, 1, 0, 1),
(0, 4, 'tstatus', 'cancelled', 1, 1, 1, 0, 1),
(0, 4, 'tstatus', 'delivered', 1, 1, 1, 0, 1),
(0, 4, 'tstatus', 'pending', 1, 1, 1, 0, 1),
(0, 4, 'tstatus', 'processing', 1, 1, 1, 0, 1),
(0, 4, 'tstatus', 'ready_to_ship', 1, 1, 1, 0, 1),
(0, 4, 'tstatus', 'shipped', 1, 1, 1, 0, 1),
(0, 6, 'settings', 'tcontent', 1, 1, 1, 1, 1),
(0, 6, 'settings', 'tsize', 1, 1, 1, 1, 1),
(0, 6, 'settings', 'tslider', 1, 1, 1, 1, 1),
(0, 6, 'tbanner', 'tbanner', 1, 1, 1, 1, 1),
(0, 6, 'torder', 'torder', 1, 1, 1, 1, 1),
(0, 6, 'tproduct', 'tproduct', 1, 1, 1, 1, 1),
(0, 6, 'tstatus', 'cancelled', 1, 1, 1, 1, 1),
(0, 6, 'tstatus', 'delivered', 1, 1, 1, 1, 1),
(0, 6, 'tstatus', 'pending', 1, 1, 1, 1, 1),
(0, 6, 'tstatus', 'processing', 1, 1, 1, 1, 1),
(0, 6, 'tstatus', 'ready_to_ship', 1, 1, 1, 1, 1),
(0, 6, 'tstatus', 'shipped', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `code`, `name`, `status`) VALUES
(1, 'ORDER_ADMI', 'Order Admin', 1),
(2, 'PRODUCT_AD', 'Product Admin', 1),
(3, 'ACCOUNT_AD', 'Account Admin', 1),
(4, 'SUPER U', 'Super User', 1),
(6, 'ORDER_CONT', 'ORDER_CONTENT_ADMIN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `saved_items`
--

CREATE TABLE `saved_items` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `productid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saved_items`
--

INSERT INTO `saved_items` (`id`, `userid`, `productid`) VALUES
(3, 3, 2),
(4, 3, 4),
(5, 3, 6),
(6, 3, 1),
(7, 1, 4),
(8, 1, 1160),
(9, 1, 1161),
(10, 8, 41341),
(13, 8, 41343),
(14, 8, 41192),
(15, 1, 16706),
(16, 3, 41411),
(17, 3, 41410),
(18, 1, 41072),
(19, 289, 41645),
(20, 916, 45768),
(21, 916, 45382),
(22, 916, 45264),
(23, 916, 46297),
(24, 1215, 21955),
(25, 1329, 37832),
(26, 1329, 34699),
(27, 1329, 10098),
(28, 1329, 11359),
(29, 1329, 36430),
(30, 1329, 35758),
(31, 1329, 35247),
(32, 1329, 21675),
(35, 1329, 8744),
(36, 1329, 34153),
(37, 1329, 45412),
(38, 1329, 8159),
(39, 1329, 7968),
(40, 2153, 46490),
(41, 2280, 46805),
(51, 2466, 44403),
(52, 2466, 39300),
(59, 2466, 40646),
(60, 2466, 50053),
(62, 2466, 37632),
(64, 2466, 32636),
(65, 2466, 53538),
(68, 2466, 53567),
(69, 2466, 42927),
(70, 2466, 42925),
(71, 2466, 51174),
(72, 2466, 50483),
(75, 2466, 50333),
(76, 2466, 48761),
(77, 2466, 50328),
(78, 2466, 48723),
(79, 2466, 44021),
(80, 2466, 44024),
(81, 2466, 44018),
(82, 2466, 36950),
(83, 2466, 36239),
(84, 2466, 9171),
(85, 2466, 1786),
(86, 2534, 51938),
(87, 2701, 40033),
(88, 2749, 36836),
(89, 2749, 21820),
(90, 2749, 20672),
(91, 2749, 49464),
(92, 2749, 32782),
(93, 2904, 49108);

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` int(11) NOT NULL,
  `toptext` varchar(255) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `instagram` varchar(50) NOT NULL,
  `pin_interest` varchar(50) NOT NULL,
  `youtube` varchar(50) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `about` varchar(4000) NOT NULL,
  `about_photo` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(400) NOT NULL,
  `address` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`id`, `toptext`, `facebook`, `instagram`, `pin_interest`, `youtube`, `twitter`, `about`, `about_photo`, `phone`, `email`, `address`) VALUES
(0, '', 'https://web.facebook.com/', 'https://www.instagram.com/', 'https://www.pinterest.com/', '#', 'https://twitter.com/', '', '', '09000009009, 09080999099', 'info@greenstore.com', 'Aba Road, Port Harcourt, Rivers State');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `no_home_products` int(3) NOT NULL,
  `banner_list_style` varchar(20) NOT NULL,
  `no_shop_products` int(3) NOT NULL,
  `home_display_style` varchar(20) NOT NULL,
  `logo` varchar(600) NOT NULL,
  `show_featured` tinyint(1) NOT NULL,
  `show_top` tinyint(1) NOT NULL,
  `no_featured` int(3) NOT NULL,
  `no_top` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `no_home_products`, `banner_list_style`, `no_shop_products`, `home_display_style`, `logo`, `show_featured`, `show_top`, `no_featured`, `no_top`) VALUES
(0, 8, 'same_sized', 36, 'grid', 'tishmilli_lingerie_logo0.jpg', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `photo` varchar(600) NOT NULL,
  `smalltagline` varchar(255) NOT NULL,
  `bigtagline` varchar(255) NOT NULL,
  `url` varchar(600) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `phototitle` varchar(255) NOT NULL,
  `showbutton` tinyint(1) NOT NULL,
  `buttontext` varchar(50) NOT NULL,
  `slideorder` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `photo`, `smalltagline`, `bigtagline`, `url`, `status`, `date_created`, `phototitle`, `showbutton`, `buttontext`, `slideorder`) VALUES
(43, 'weekly_sales43.jpg', '', '', '#', 1, '11-09-2023 00:20 AM', 'weekly_sales', 0, '', 3),
(44, 'slider244.jpg', '', '', '#', 1, '11-09-2023 00:40 AM', 'slider2', 0, '', 2),
(45, 'super_marlet-fresh-healthy45.jpg', '', '', '#', 1, '11-09-2023 09:45 AM', 'super_marlet-fresh-healthy', 0, '', 1),
(46, 'shop_inspirational_books_146.jpg', '', '', '', 1, '01-11-2023 23:04 PM', 'shop_inspirational_books_1', 0, '', 4),
(47, 'shop_inspirational_books_247.jpg', '', '', '', 1, '01-11-2023 23:05 PM', 'shop_inspirational_books_2', 0, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='States in Nigeria.';

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `name`, `status`) VALUES
(1, 'Abia', 1),
(2, 'Adamawa', 1),
(3, 'Akwa Ibom', 1),
(4, 'Anambra', 1),
(5, 'Bauchi', 1),
(6, 'Bayelsa', 1),
(7, 'Benue', 1),
(8, 'Borno', 1),
(9, 'Cross River', 1),
(10, 'Delta', 1),
(11, 'Ebonyi', 1),
(12, 'Edo', 1),
(13, 'Ekiti', 1),
(14, 'Enugu', 1),
(15, 'FCT', 1),
(16, 'Gombe', 1),
(17, 'Imo', 1),
(18, 'Jigawa', 1),
(19, 'Kaduna', 1),
(20, 'Kano', 1),
(21, 'Katsina', 1),
(22, 'Kebbi', 1),
(23, 'Kogi', 1),
(24, 'Kwara', 1),
(25, 'Lagos', 1),
(26, 'Nasarawa', 1),
(27, 'Niger', 1),
(28, 'Ogun', 1),
(29, 'Ondo', 1),
(30, 'Osun', 1),
(31, 'Oyo', 1),
(32, 'Plateau', 1),
(33, 'Rivers', 1),
(34, 'Sokoto', 1),
(35, 'Taraba', 1),
(36, 'Yobe', 1),
(37, 'Zamfara', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `mastercategoryid` int(6) NOT NULL,
  `subcategoryid` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `mastercategoryid`, `subcategoryid`) VALUES
(0, 778948, 1257685),
(0, 778948, 1257683),
(0, 778948, 1257686),
(0, 778948, 1257687),
(0, 778948, 1257684),
(0, 1256322, 1267265),
(0, 1256322, 1257470),
(0, 1256322, 1095238),
(0, 1256322, 1257468),
(0, 1256322, 1267266),
(0, 1095326, 1253755),
(0, 1095326, 1256581),
(0, 1095326, 1118279),
(0, 1095326, 1152843),
(0, 1095326, 1087459),
(0, 1095326, 1095325),
(0, 1095326, 1095331),
(0, 1095326, 1256313),
(0, 1095326, 1256585),
(0, 1095326, 1118148),
(0, 1095326, 1095323),
(0, 778945, 1256276),
(0, 778945, 1257673),
(0, 778945, 1257679),
(0, 778945, 1257671),
(0, 778945, 1257677),
(0, 778945, 1257672),
(0, 778945, 1257675),
(0, 778945, 1095343),
(0, 1256316, 1196624),
(0, 1256316, 1095328),
(0, 975364, 1289698),
(0, 975364, 1128517),
(0, 975364, 1289699),
(0, 975364, 1256575),
(0, 975364, 1289697),
(0, 975364, 1289700),
(0, 975364, 1256576),
(0, 975364, 1129412),
(0, 1256317, 1095338),
(0, 1256317, 1095327),
(0, 778929, 1286183),
(0, 778929, 1253757),
(0, 778929, 1336402),
(0, 778929, 1286186),
(0, 778929, 1286180),
(0, 778929, 1253760),
(0, 778929, 1253749),
(0, 778929, 1366163),
(0, 778929, 1286181),
(0, 778929, 1253752),
(0, 778929, 1253758),
(0, 778929, 1307887),
(0, 778929, 1286184),
(0, 778929, 1253761),
(0, 778929, 1253747),
(0, 778929, 1253753),
(0, 778929, 1376031),
(0, 778929, 1253750),
(0, 778929, 1253759),
(0, 778929, 1288904),
(0, 778929, 1286182),
(0, 778929, 1253756),
(0, 778929, 1253745),
(0, 778929, 1253748),
(0, 778929, 1253725),
(0, 778929, 1266234),
(0, 778929, 1253751),
(0, 778929, 1366154),
(0, 778929, 1307860),
(0, 1256277, 1289696),
(0, 1256277, 1095336),
(0, 1256277, 1256278),
(0, 1256277, 1095337),
(0, 1256277, 1289695),
(0, 1087407, 1087460),
(0, 1087407, 1087409),
(0, 1087407, 1087452),
(0, 1087407, 1087436),
(0, 1087407, 1087425),
(0, 1087407, 1087408),
(0, 1087407, 1087437),
(0, 778938, 1256574),
(0, 778938, 1256577),
(0, 778938, 1095361),
(0, 778938, 1165923),
(0, 778938, 1256274),
(0, 778938, 1095324),
(0, 778938, 1095330),
(0, 778938, 1342821),
(0, 778938, 1342695),
(0, 778938, 1256378),
(0, 778938, 1095288),
(0, 778938, 1158597),
(0, 778938, 1256550),
(0, 778938, 1256573),
(0, 778938, 1135477),
(0, 1190310, 1302648),
(0, 1190310, 1191748),
(0, 1190310, 1190332),
(0, 1190310, 1191746),
(0, 1190310, 1190435),
(0, 1190310, 1191755),
(0, 1190310, 1190330),
(0, 1190310, 1195116),
(0, 1190310, 1190436),
(0, 1190310, 1190442),
(0, 1190310, 1191587),
(0, 1190310, 1191670),
(0, 1190310, 1190568),
(0, 782809, 1267268),
(0, 782809, 1134628),
(0, 782809, 1256271),
(0, 782809, 1300880),
(0, 782809, 1256269),
(0, 782809, 817979),
(0, 782809, 1287536),
(0, 782809, 1256272),
(0, 782809, 1256273),
(0, 782809, 1256270),
(0, 1, 13),
(0, 10, 13),
(0, 9, 13);

-- --------------------------------------------------------

--
-- Table structure for table `topmenu_categories`
--

CREATE TABLE `topmenu_categories` (
  `id` int(11) NOT NULL,
  `topmenucategoryid` int(6) NOT NULL,
  `categoryid` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `pword` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(250) NOT NULL DEFAULT 'client',
  `date_created` varchar(250) DEFAULT NULL,
  `reset_key` varchar(60) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `fb_user_id` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `pword`, `email`, `phone`, `role`, `date_created`, `reset_key`, `is_active`, `fb_user_id`) VALUES
(3, 'Chidiebere', 'Onwunyirigbo', '756d34ec39072ab38a76697e05b82f79abe37435', 'conwunyirigbo@gmail.com', '', 'user', '24-04-2020', '', 1, NULL),
(5, 'Admin', 'Admin', '8fecee37565135f0f55257b75eda3e82df1d164a', 'admin', '', 'super_admin', '25-08-2023', '', 1, ''),
(6, 'Chidiebere', 'Onwunyirigbo', '72072cad3dd3a713117f2e7d4c03050fd9db04b3', 'Anon_1643Wx', '', 'user', '11-09-2023', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `userid` int(6) NOT NULL,
  `roleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colour`
--
ALTER TABLE `colour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_cities`
--
ALTER TABLE `delivery_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_fee`
--
ALTER TABLE `delivery_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_staff`
--
ALTER TABLE `delivery_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menugroup`
--
ALTER TABLE `menugroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menuitem`
--
ALTER TABLE `menuitem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_delivery_staff`
--
ALTER TABLE `order_delivery_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=715;

--
-- AUTO_INCREMENT for table `colour`
--
ALTER TABLE `colour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_cities`
--
ALTER TABLE `delivery_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `delivery_fee`
--
ALTER TABLE `delivery_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `delivery_staff`
--
ALTER TABLE `delivery_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menugroup`
--
ALTER TABLE `menugroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menuitem`
--
ALTER TABLE `menuitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_delivery_staff`
--
ALTER TABLE `order_delivery_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1307;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
