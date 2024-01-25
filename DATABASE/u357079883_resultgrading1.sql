-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 15, 2023 at 01:48 PM
-- Server version: 10.5.16-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u357079883_resultgrading1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(20) NOT NULL,
  `userId` int(20) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `phoneNo` varchar(20) NOT NULL,
  `staffpass` varchar(255) NOT NULL,
  `staffId` varchar(255) NOT NULL,
  `adminTypeId` int(20) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `isAssigned` int(10) NOT NULL,
  `isPasswordChanged` int(10) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `token_expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `userId`, `fullName`, `emailAddress`, `phoneNo`, `staffpass`, `staffId`, `adminTypeId`, `verify_token`, `isAssigned`, `isPasswordChanged`, `dateCreated`, `token_expire`) VALUES
(127, 115, 'David Renz Delos Santos', '', '', 'Dd43055!', 'MIES0235', 4, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(128, 116, 'Angel Mae Flojo', '', '', 'A@b1', 'MIES5486', 4, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(129, 117, 'Marvin Justo', '', '', 'Mj67938!', 'MIES1563', 4, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(130, 118, 'Marie Santos', '', '', 'Ms75035!', 'MIES02160', 4, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(136, 101, 'Dolly Malabanan', '', '', 'Dm40356!', '109850060048', 5, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(137, 102, 'Reynold Smith Mendoza', '', '', 'Rm49496!', '109850060089', 5, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(138, 103, 'Irish Raven Agojo', '', '', 'Ia78472!', '109850060045', 5, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(139, 104, 'Ryan  Lazaro', '', '', 'Rl42046!', '109850070048', 5, '', 0, 0, '2023-01-26 00:00:00', '0000-00-00 00:00:00'),
(144, 108, 'Joanna Landicho', '', '', 'Jl40463!', '109850060056', 5, '', 0, 0, '2023-02-04 00:00:00', '0000-00-00 00:00:00'),
(155, 115, 'Marianne Jane Garcia', '', '', 'Mg93363!', '109854654202', 5, '', 0, 0, '2023-02-07 00:44:57', '0000-00-00 00:00:00'),
(180, 138, 'Oliver Casincad', '', '', 'Co2156!', 'MIES02313', 4, '', 0, 0, '2023-02-07 00:00:00', '0000-00-00 00:00:00'),
(181, 118, 'Liza Nivea', '', '', 'Ln2156!', '15486457864', 5, '', 0, 0, '2023-02-07 14:25:32', '0000-00-00 00:00:00'),
(182, 139, 'Joseph Padua', '', '', 'Jp59591!', 'MIES021655', 4, '', 0, 0, '2023-02-07 18:35:30', '0000-00-00 00:00:00'),
(192, 148, 'Shiella Santos', '', '', 'Mies2425', 'MIES2425', 4, '', 0, 0, '2023-02-08 11:08:45', '0000-00-00 00:00:00'),
(232, 130, 'Lee Andrew De Guzman', '', '', 'Leeandrew21*', '109850060021', 5, '', 0, 0, '2023-02-08 12:00:41', '0000-00-00 00:00:00'),
(233, 131, 'Jolo Tenorio', '', '', 'Jolo22*', '109850060022', 5, '', 0, 0, '2023-02-08 12:00:41', '0000-00-00 00:00:00'),
(234, 132, 'Renzo Ancheta', '', '', 'Renzo23*', '109850060023', 5, '', 0, 0, '2023-02-08 12:00:41', '0000-00-00 00:00:00'),
(235, 133, 'Lhester Paraiso', '', '', 'Lhester24*', '109850060024', 5, '', 0, 0, '2023-02-08 12:00:41', '0000-00-00 00:00:00'),
(237, 135, 'Sarah Lahbatti', '', '', 'Sl98995!', '109850060028', 5, '', 0, 0, '2023-02-08 12:02:01', '0000-00-00 00:00:00'),
(239, 0, 'Lorna N. Platon', 'joydanielacortez@gmail.com', '09567966559', 'Mies1!30', 'AD123', 1, 'eb48169a651b36dc8a5c38b22e626655funda', 0, 0, '2023-02-08 12:13:21', '2023-02-14 21:52:11'),
(242, 138, 'Rain Nicole Alcantara', '', '', 'Ra99529!', '109862326656', 5, '', 0, 0, '2023-02-08 14:58:57', '0000-00-00 00:00:00'),
(243, 139, 'Dalie Mae Justo', '', '', 'Dj99202!', '109851321548', 5, '', 0, 0, '2023-02-08 15:00:22', '0000-00-00 00:00:00'),
(244, 153, 'Sofia Andrea Sario', '', '', 'Ss63864!', 'MIES10235', 4, '', 0, 0, '2023-02-08 17:52:09', '0000-00-00 00:00:00'),
(254, 155, 'Mae Gardiola', '', '', 'Mg33047!', 'MIES00123', 4, '', 0, 0, '2023-02-10 03:09:13', '0000-00-00 00:00:00'),
(262, 155, 'christian Almonte', '', '', 'Ca90878!', '010245451315', 5, '', 0, 0, '2023-02-10 13:21:39', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmintype`
--

CREATE TABLE `tbladmintype` (
  `Id` int(20) NOT NULL,
  `UserType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmintype`
--

INSERT INTO `tbladmintype` (`Id`, `UserType`) VALUES
(1, 'Super Administrator'),
(2, 'Administrator'),
(3, 'Principal'),
(4, 'Faculty'),
(5, 'Student'),
(6, 'Parents');

-- --------------------------------------------------------

--
-- Table structure for table `tbladviser`
--

CREATE TABLE `tbladviser` (
  `Id` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `dateCreated` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladviser`
--

INSERT INTO `tbladviser` (`Id`, `sectionId`, `teacherId`, `sessionId`, `dateCreated`) VALUES
(23, 81, 127, 12, '2023-01-26'),
(27, 72, 129, 12, '2023-01-26'),
(32, 69, 130, 12, '2023-02-06'),
(33, 82, 192, 12, '2023-02-07'),
(36, 92, 182, 12, '2023-02-08'),
(39, 81, 127, 11, '2023-02-08'),
(41, 82, 180, 13, '2023-02-08'),
(42, 76, 128, 13, '2023-02-08'),
(43, 69, 192, 13, '2023-02-08'),
(47, 75, 128, 12, '2023-02-08'),
(49, 76, 180, 12, '2023-02-10');

-- --------------------------------------------------------

--
-- Table structure for table `tblassignedadmin`
--

CREATE TABLE `tblassignedadmin` (
  `id` int(11) NOT NULL,
  `dateAssigned` varchar(200) NOT NULL,
  `staffId` int(11) NOT NULL,
  `facultyId` int(11) NOT NULL,
  `departmentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblassignedadmin`
--

INSERT INTO `tblassignedadmin` (`id`, `dateAssigned`, `staffId`, `facultyId`, `departmentId`) VALUES
(1, '2022-06-13', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblattendance`
--

CREATE TABLE `tblattendance` (
  `Id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `schoolday` int(11) NOT NULL,
  `day_present` int(11) NOT NULL,
  `day_absent` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `dateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`Id`, `studentId`, `month`, `schoolday`, `day_present`, `day_absent`, `sessionId`, `dateCreated`) VALUES
(13, 101, 'January', 23, 17, 6, 12, '2023-01-26'),
(16, 105, 'February', 30, 25, 5, 12, '2023-01-26'),
(19, 101, 'February', 20, 19, 1, 12, '2023-02-04'),
(20, 102, 'January', 20, 20, 0, 12, '2023-02-04'),
(21, 102, 'February', 28, 20, 8, 12, '2023-02-04'),
(22, 103, 'January', 20, 18, 2, 12, '2023-02-04'),
(23, 103, 'February', 22, 20, 2, 12, '2023-02-04'),
(25, 108, 'January', 20, 19, 1, 12, '2023-02-04'),
(31, 118, 'January', 30, 30, 0, 12, '2023-02-07'),
(33, 118, 'February', 50, 25, 0, 12, '2023-02-07'),
(52, 134, 'February', 20, 16, 4, 11, '2023-02-08'),
(53, 139, 'January', 23, 20, 3, 12, '2023-02-08'),
(56, 139, 'February', 20, 20, 0, 12, '2023-02-08');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `category`) VALUES
(1, 'Grade 4-6');

-- --------------------------------------------------------

--
-- Table structure for table `tblcgparesult`
--

CREATE TABLE `tblcgparesult` (
  `Id` int(11) NOT NULL,
  `matricNo` varchar(50) NOT NULL,
  `cgpa` varchar(50) NOT NULL,
  `classOfDiploma` varchar(50) NOT NULL,
  `dateAdded` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcgparesult`
--

INSERT INTO `tblcgparesult` (`Id`, `matricNo`, `cgpa`, `classOfDiploma`, `dateAdded`) VALUES
(1, 'SGS100', '1.38', 'Fail', '2022-06-13'),
(2, '10101', '3.38', 'Upper Credit', '2022-06-15'),
(3, '14750', '3.35', 'Upper Credit', '2022-06-15'),
(4, 'SGS123', '3.49', 'Upper Credit', '2022-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `tbldesignation`
--

CREATE TABLE `tbldesignation` (
  `id` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldesignation`
--

INSERT INTO `tbldesignation` (`id`, `designation`) VALUES
(1, 'Principal'),
(2, 'Faculty Head'),
(3, 'School Supervisor'),
(4, 'Teacher 1'),
(5, 'Teacher 2'),
(6, 'Teacher 3'),
(7, 'Teacher 4'),
(8, 'Teacher 5');

-- --------------------------------------------------------

--
-- Table structure for table `tblfaculty`
--

CREATE TABLE `tblfaculty` (
  `Id` int(20) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `fid` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfaculty`
--

INSERT INTO `tblfaculty` (`Id`, `lname`, `fname`, `mname`, `fid`, `password`, `designation`, `sessionId`, `dateCreated`) VALUES
(114, 'Delos Martirez', 'Cherrylyn', 'Abarientos', 'MIES15056', 'Cd56843!', 'Master Teacher I', 0, '2023-01-26 00:00:00'),
(115, 'Delos Santos', 'David Renz', 'Simpao', 'MIES0235', 'Dd43055!', '', 0, '2023-01-26 00:00:00'),
(116, 'Flojo', 'Angel Mae', 'Quinto', 'MIES5486', 'Af55762!', 'Techer 3', 0, '2023-01-26 00:00:00'),
(117, 'Justo', 'Marvin', 'Pangilin', 'MIES1563', 'Mj67938!', '', 0, '2023-01-26 00:00:00'),
(118, 'Santos', 'Marie', '', 'MIES02160', 'Ms75035!', '', 0, '2023-01-26 00:00:00'),
(119, 'Gomez', 'Ronald', 'Piolo', 'MIES1546', 'Rg55280!', 'Teacher 2', 0, '2023-01-26 00:00:00'),
(120, 'Sario', 'Andrea Sophia', 'Velarde', 'MIES05165', 'As24726!', '', 0, '2023-01-26 00:00:00'),
(121, 'Gonzales', 'Andrew', 'Moris', 'MIES01355', 'Ag24193!', 'Teacher1', 0, '2023-01-26 00:00:00'),
(122, 'Bulos', 'April Lyn', 'Villanueva', 'MIES02135', 'Ab37659!', 'ICT', 0, '2023-01-26 00:00:00'),
(124, 'Fajardo', 'Jopay', 'Magdaye', 'MIES01556', 'Jf97771!', 'Master Teacher I', 0, '2023-02-04 00:00:00'),
(126, 'Gardiola', 'Mary Grace', 'Lerico', 'MIES01567', 'Mg28785!', 'Teacher II', 0, '2023-02-07 06:42:03'),
(138, 'Casincad', 'Oliver', 'Navida', 'MIES02313', 'Co2156!', 'Teacher I', 0, '2023-02-07 13:33:35'),
(139, 'Padua', 'Joseph', 'Mangilin', 'MIES021655', 'Jp59591!', 'Teacher II', 0, '2023-02-07 18:35:30'),
(148, 'Santos', 'Shiella', 'Masongsong', 'MIES2425', 'Mies2425', '', 0, '2023-02-08 11:08:45'),
(153, 'Sario', 'Sofia Andrea', 'Raval', 'MIES10235', 'Ss63864!', 'Teacher III', 0, '2023-02-08 17:52:09'),
(155, 'Gardiola', 'Mae', 'Abarientos', 'MIES00123', 'Mg33047!', 'Instructor I', 0, '2023-02-10 03:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `tblfacultyload`
--

CREATE TABLE `tblfacultyload` (
  `id` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfacultyload`
--

INSERT INTO `tblfacultyload` (`id`, `teacherId`, `sectionId`, `subjectId`, `sessionId`, `dateCreated`) VALUES
(35, 127, 81, 58, 12, '2023-01-26 00:00:00'),
(43, 130, 76, 61, 12, '2023-01-26 00:00:00'),
(46, 130, 83, 75, 12, '2023-01-26 00:00:00'),
(49, 127, 81, 60, 12, '2023-01-26 00:00:00'),
(51, 127, 81, 56, 12, '2023-01-26 00:00:00'),
(55, 127, 81, 59, 12, '2023-02-06 00:00:00'),
(56, 127, 81, 57, 12, '2023-02-06 09:19:28'),
(74, 130, 84, 94, 11, '2023-02-08 11:17:54'),
(77, 127, 72, 80, 11, '2023-02-08 11:17:54'),
(79, 127, 81, 60, 11, '2023-02-08 12:34:23'),
(80, 127, 81, 59, 11, '2023-02-08 12:34:32'),
(81, 127, 81, 58, 11, '2023-02-08 12:34:39'),
(82, 127, 81, 85, 13, '2023-02-08 16:52:01'),
(83, 127, 81, 85, 12, '2023-02-08 16:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `tblfinalresult`
--

CREATE TABLE `tblfinalresult` (
  `Id` int(10) NOT NULL,
  `matricNo` varchar(50) NOT NULL,
  `levelId` varchar(10) NOT NULL,
  `semesterId` varchar(10) NOT NULL,
  `sessionId` varchar(10) NOT NULL,
  `totalCourseUnit` varchar(10) NOT NULL,
  `totalScoreGradePoint` varchar(10) NOT NULL,
  `gpa` varchar(255) NOT NULL,
  `classOfDiploma` varchar(50) NOT NULL,
  `dateAdded` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblfinalresult`
--

INSERT INTO `tblfinalresult` (`Id`, `matricNo`, `levelId`, `semesterId`, `sessionId`, `totalCourseUnit`, `totalScoreGradePoint`, `gpa`, `classOfDiploma`, `dateAdded`) VALUES
(1, 'SGS100', '1', '1', '1', '5', '0', '0', 'Fail', '2022-06-13'),
(2, 'SGS100', '1', '2', '1', '5', '13.75', '2.75', 'Lower Credit', '2022-06-13'),
(3, '10101', '1', '1', '1', '5', '17.5', '3.5', 'Distinction', '2022-06-15'),
(4, '10101', '1', '2', '1', '5', '16.25', '3.25', 'Upper Credit', '2022-06-15'),
(5, '14750', '1', '1', '1', '18', '63', '3.5', 'Distinction', '2022-06-15'),
(6, '14750', '1', '2', '1', '17', '54.25', '3.19', 'Upper Credit', '2022-06-15'),
(7, 'SGS123', '1', '1', '1', '22', '81', '3.68', 'Distinction', '2022-06-16'),
(8, 'SGS123', '1', '2', '1', '19', '62.25', '3.28', 'Upper Credit', '2022-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `tblgrade`
--

CREATE TABLE `tblgrade` (
  `id` int(11) NOT NULL,
  `grade` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblgrade`
--

INSERT INTO `tblgrade` (`id`, `grade`) VALUES
(1, 'Quarterly'),
(2, 'Overall');

-- --------------------------------------------------------

--
-- Table structure for table `tblgrading`
--

CREATE TABLE `tblgrading` (
  `gradeId` int(11) NOT NULL,
  `taskId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblgrading`
--

INSERT INTO `tblgrading` (`gradeId`, `taskId`, `studentId`, `score`, `dateCreated`) VALUES
(1, 3, 39, 10, '2022-12-01 05:45:35'),
(2, 3, 43, 5, '2022-12-01 05:45:43'),
(3, 4, 50, 7, '2022-12-01 07:39:22'),
(4, 4, 17, 5, '2022-12-01 07:39:34'),
(5, 5, 54, 15, '2022-12-06 22:33:51'),
(6, 12, 51, 30, '2022-12-09 18:44:39'),
(7, 13, 31, 5, '2022-12-20 13:54:35'),
(8, 13, 22, 10, '2022-12-21 05:43:39'),
(10, 5, 22, 1, '2022-12-21 05:43:50'),
(11, 14, 31, 15, '2022-12-22 03:46:02'),
(12, 15, 51, 10, '2022-12-27 02:57:33'),
(13, 13, 52, 10, '2022-12-27 02:58:38'),
(14, 16, 55, 10, '2022-12-29 01:53:13'),
(15, 16, 58, 9, '2022-12-30 10:02:52'),
(16, 17, 59, 10, '2022-12-30 11:10:59'),
(17, 18, 59, 10, '2023-01-13 00:13:53'),
(18, 19, 60, 1, '2023-01-13 01:24:10'),
(19, 23, 59, 15, '2023-01-13 01:30:46'),
(20, 23, 60, 70, '2023-01-13 01:30:50'),
(21, 24, 59, 10, '2023-01-13 01:31:14'),
(22, 24, 60, 50, '2023-01-13 01:31:18'),
(23, 25, 59, 10, '2023-01-13 01:31:23'),
(24, 25, 60, 50, '2023-01-13 01:31:28'),
(25, 26, 59, 50, '2023-01-13 01:31:34'),
(26, 26, 60, 60, '2023-01-13 01:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbllevel`
--

CREATE TABLE `tbllevel` (
  `Id` int(20) NOT NULL,
  `levelName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbllevel`
--

INSERT INTO `tbllevel` (`Id`, `levelName`) VALUES
(1, 'Grade 1'),
(2, 'Grade 2'),
(3, 'Grade 3'),
(4, 'Grade 4'),
(5, 'Grade 5'),
(6, 'Grade 6'),
(7, 'Graduate');

-- --------------------------------------------------------

--
-- Table structure for table `tblpromoted`
--

CREATE TABLE `tblpromoted` (
  `Id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `levelId` text NOT NULL,
  `sectionId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `adviseeId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpromoted`
--

INSERT INTO `tblpromoted` (`Id`, `studentId`, `levelId`, `sectionId`, `sessionId`, `adviseeId`, `dateCreated`) VALUES
(58, 101, '1', 81, 12, 0, '2023-01-26 00:00:00'),
(59, 102, '1', 81, 12, 0, '2023-01-26 00:00:00'),
(60, 103, '1', 81, 12, 0, '2023-01-26 00:00:00'),
(61, 104, '2', 76, 12, 0, '2023-01-26 00:00:00'),
(66, 102, '2', 76, 13, 23, '2023-01-27 00:00:00'),
(67, 108, '1', 75, 12, 0, '2023-02-04 00:00:00'),
(74, 103, '2', 76, 13, 23, '2023-02-06 00:00:00'),
(75, 115, '1', 81, 12, 0, '2023-02-07 00:00:00'),
(80, 115, '2', 76, 13, 23, '2023-02-07 00:00:00'),
(82, 118, '1', 81, 12, 0, '2023-02-07 00:00:00'),
(103, 130, '1', 81, 11, 0, '2023-02-08 00:00:00'),
(104, 131, '1', 81, 11, 0, '2023-02-08 00:00:00'),
(105, 132, '1', 81, 11, 0, '2023-02-08 00:00:00'),
(106, 133, '1', 81, 11, 0, '2023-02-08 00:00:00'),
(108, 135, '1', 81, 11, 0, '2023-02-08 00:00:00'),
(173, 133, '2', 69, 13, 39, '2023-02-08 00:00:00'),
(174, 132, '2', 69, 13, 39, '2023-02-08 00:00:00'),
(187, 135, '2', 76, 13, 39, '2023-02-08 00:00:00'),
(188, 131, '2', 76, 13, 39, '2023-02-08 00:00:00'),
(190, 130, '2', 69, 13, 39, '2023-02-08 00:00:00'),
(194, 138, '1', 81, 12, 23, '2023-02-08 00:00:00'),
(195, 139, '1', 81, 12, 23, '2023-02-08 00:00:00'),
(208, 139, '2', 82, 13, 23, '2023-02-08 00:00:00'),
(209, 138, '2', 82, 13, 23, '2023-02-08 00:00:00'),
(216, 101, '2', 69, 13, 23, '2023-02-09 07:29:36'),
(217, 155, '1', 81, 12, 23, '2023-02-10 13:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `tblquartergrade`
--

CREATE TABLE `tblquartergrade` (
  `gradeId` int(11) NOT NULL,
  `teachingId` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `period` int(11) NOT NULL DEFAULT 1,
  `grade` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `dateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblquartergrade`
--

INSERT INTO `tblquartergrade` (`gradeId`, `teachingId`, `student_id`, `period`, `grade`, `remarks`, `dateCreated`) VALUES
(71, 51, 103, 1, 89, '', '2023-02-04'),
(72, 35, 103, 1, 88, '', '2023-02-04'),
(73, 35, 101, 1, 79, '', '2023-02-09'),
(74, 35, 102, 1, 90, '', '2023-02-04'),
(75, 35, 103, 2, 84, '', '2023-02-04'),
(76, 35, 101, 2, 85, '', '2023-02-07'),
(77, 35, 102, 2, 80, '', '2023-02-04'),
(78, 49, 103, 1, 86, '', '2023-02-04'),
(79, 49, 101, 1, 84, '', '2023-02-04'),
(80, 49, 102, 1, 87, '', '2023-02-04'),
(81, 49, 103, 2, 88, '', '2023-02-04'),
(82, 49, 101, 2, 85, '', '2023-02-04'),
(83, 49, 102, 2, 83, '', '2023-02-04'),
(85, 51, 101, 1, 90, '', '2023-02-08'),
(86, 51, 102, 1, 87, '', '2023-02-04'),
(87, 51, 103, 2, 87, '', '2023-02-04'),
(88, 51, 101, 2, 88, '', '2023-02-04'),
(89, 51, 102, 2, 84, '', '2023-02-04'),
(92, 54, 108, 1, 90, '', '2023-02-04'),
(93, 54, 108, 2, 87, '', '2023-02-04'),
(94, 35, 115, 2, 78, '', '2023-02-07'),
(95, 35, 115, 1, 79, '', '2023-02-08'),
(98, 67, 103, 1, 89, '', '2023-02-07'),
(100, 67, 115, 1, 85, '', '2023-02-07'),
(103, 35, 118, 1, 89, '', '2023-02-07'),
(106, 35, 118, 2, 95, '', '2023-02-08'),
(108, 81, 132, 1, 88, '', '2023-02-08'),
(109, 81, 134, 1, 79, '', '2023-02-08'),
(110, 81, 130, 1, 67, '', '2023-02-08'),
(111, 81, 135, 1, 78, '', '2023-02-08'),
(112, 81, 133, 1, 79, '', '2023-02-08'),
(113, 81, 131, 1, 80, '', '2023-02-08'),
(114, 81, 132, 2, 78, '', '2023-02-08'),
(115, 81, 134, 2, 77, '', '2023-02-08'),
(116, 81, 130, 2, 78, '', '2023-02-08'),
(117, 81, 135, 2, 80, '', '2023-02-08'),
(118, 81, 133, 2, 75, '', '2023-02-08'),
(119, 81, 131, 2, 78, '', '2023-02-08'),
(120, 83, 103, 1, 85, '', '2023-02-09'),
(121, 83, 101, 1, 85, '', '2023-02-09'),
(122, 83, 138, 1, 74, '', '2023-02-09'),
(123, 35, 138, 1, 78, '', '2023-02-09'),
(125, 35, 139, 1, 60, '', '2023-02-09'),
(126, 35, 155, 1, 79, '', '2023-02-13');

-- --------------------------------------------------------

--
-- Table structure for table `tblresult`
--

CREATE TABLE `tblresult` (
  `Id` int(10) NOT NULL,
  `matricNo` varchar(50) NOT NULL,
  `levelId` varchar(10) NOT NULL,
  `semesterId` varchar(10) NOT NULL,
  `sessionId` varchar(10) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `courseUnit` varchar(50) NOT NULL,
  `score` varchar(50) NOT NULL,
  `scoreGradePoint` varchar(50) NOT NULL,
  `scoreLetterGrade` varchar(10) NOT NULL,
  `totalScoreGradePoint` varchar(50) NOT NULL,
  `dateAdded` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblresult`
--

INSERT INTO `tblresult` (`Id`, `matricNo`, `levelId`, `semesterId`, `sessionId`, `courseCode`, `courseUnit`, `score`, `scoreGradePoint`, `scoreLetterGrade`, `totalScoreGradePoint`, `dateAdded`) VALUES
(1, 'SGS100', '1', '1', '1', 'PI01', '5', '30', '0', 'F', '0', '2022-06-13'),
(2, 'SGS100', '1', '2', '1', 'NT100', '5', '55', '2.75', 'BC', '13.75', '2022-06-13'),
(3, '10101', '1', '1', '1', 'PI01', '5', '72', '3.5', 'A', '17.5', '2022-06-15'),
(4, '10101', '1', '2', '1', 'NT100', '5', '68', '3.25', 'AB', '16.25', '2022-06-15'),
(5, '14750', '1', '1', '1', 'LC1', '6', '60', '3', 'B', '18', '2022-06-15'),
(6, '14750', '1', '1', '1', 'CL12', '6', '79', '4', 'AA', '24', '2022-06-15'),
(7, '14750', '1', '1', '1', 'PLi5', '6', '72', '3.5', 'A', '21', '2022-06-15'),
(8, '14750', '1', '2', '1', 'AL2', '6', '68', '3.25', 'AB', '19.5', '2022-06-15'),
(9, '14750', '1', '2', '1', 'LC8', '5', '57', '2.75', 'BC', '13.75', '2022-06-15'),
(10, '14750', '1', '2', '1', 'LII8', '6', '73', '3.5', 'A', '21', '2022-06-15'),
(11, 'SGS123', '1', '1', '1', 'EM12', '5', '63', '3', 'B', '15', '2022-06-16'),
(12, 'SGS123', '1', '1', '1', 'PS77', '4', '73', '3.5', 'A', '14', '2022-06-16'),
(13, 'SGS123', '1', '1', '1', 'CS69', '5', '80', '4', 'AA', '20', '2022-06-16'),
(14, 'SGS123', '1', '1', '1', 'SS88', '5', '82', '4', 'AA', '20', '2022-06-16'),
(15, 'SGS123', '1', '1', '1', 'MCP8', '3', '79', '4', 'AA', '12', '2022-06-16'),
(16, 'SGS123', '1', '2', '1', 'FC25', '5', '65', '3.25', 'AB', '16.25', '2022-06-16'),
(17, 'SGS123', '1', '2', '1', 'MM895', '6', '60', '3', 'B', '18', '2022-06-16'),
(18, 'SGS123', '1', '2', '1', 'PL08', '3', '72', '3.5', 'A', '10.5', '2022-06-16'),
(19, 'SGS123', '1', '2', '1', 'P225', '5', '74', '3.5', 'A', '17.5', '2022-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `tblsection`
--

CREATE TABLE `tblsection` (
  `Id` int(11) NOT NULL,
  `sectionName` varchar(50) NOT NULL,
  `levelId` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblsection`
--

INSERT INTO `tblsection` (`Id`, `sectionName`, `levelId`, `dateCreated`) VALUES
(69, 'Rose', '2', '0000-00-00 00:00:00'),
(70, 'Lily', '3', '0000-00-00 00:00:00'),
(71, 'Tulip', '4', '0000-00-00 00:00:00'),
(72, 'Orchid', '5', '0000-00-00 00:00:00'),
(73, 'Carnation', '5', '0000-00-00 00:00:00'),
(74, 'Freesia', '6', '0000-00-00 00:00:00'),
(75, 'Hyacinth', '1', '0000-00-00 00:00:00'),
(76, 'Chrysanthemum', '2', '0000-00-00 00:00:00'),
(77, 'Daffodil', '4', '0000-00-00 00:00:00'),
(78, 'Sunflower', '3', '0000-00-00 00:00:00'),
(79, 'Marigold', '5', '0000-00-00 00:00:00'),
(80, 'Amaryllis', '6', '0000-00-00 00:00:00'),
(81, 'Lotus', '1', '0000-00-00 00:00:00'),
(82, 'Begonia', '2', '0000-00-00 00:00:00'),
(83, 'Plume', '4', '0000-00-00 00:00:00'),
(84, 'Amber', '5', '0000-00-00 00:00:00'),
(85, 'Ambrosia', '6', '0000-00-00 00:00:00'),
(87, 'Jasmine', '3', '0000-00-00 00:00:00'),
(88, 'Sampaguita', '3', '0000-00-00 00:00:00'),
(89, 'Magnolia', '3', '0000-00-00 00:00:00'),
(91, 'Daisy', '1', '2023-02-08 03:05:29'),
(92, 'Lavender', '1', '2023-02-08 03:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `tblsemester`
--

CREATE TABLE `tblsemester` (
  `Id` int(20) NOT NULL,
  `semesterName` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsemester`
--

INSERT INTO `tblsemester` (`Id`, `semesterName`) VALUES
(1, 'First Grading'),
(2, 'Second Grading'),
(3, 'Third Grading'),
(4, 'Fourth Grading');

-- --------------------------------------------------------

--
-- Table structure for table `tblsession`
--

CREATE TABLE `tblsession` (
  `Id` int(20) NOT NULL,
  `sessionName` varchar(30) NOT NULL,
  `isActive` int(5) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsession`
--

INSERT INTO `tblsession` (`Id`, `sessionName`, `isActive`, `dateCreated`) VALUES
(13, '2023-2024', 0, '0000-00-00 00:00:00'),
(12, '2022-2023', 1, '0000-00-00 00:00:00'),
(11, '2021-2022', 0, '0000-00-00 00:00:00'),
(19, '2024-2025', 0, '2023-02-11 11:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `tblstaff`
--

CREATE TABLE `tblstaff` (
  `Id` int(20) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `otherName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `phoneNo` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `staffId` varchar(255) NOT NULL,
  `isAssigned` int(10) NOT NULL,
  `isPasswordChanged` int(10) NOT NULL,
  `dateCreated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblstaff`
--

INSERT INTO `tblstaff` (`Id`, `firstName`, `lastName`, `otherName`, `emailAddress`, `phoneNo`, `password`, `staffId`, `isAssigned`, `isPasswordChanged`, `dateCreated`) VALUES
(3, 'Bamidele', 'Bayo', 'olakunle', 'Bamidele@gmail.com', '07065903222', '12345', 'STF001111', 1, 0, '2020-06-21'),
(4, 'busola', 'keji', 'busayo', 'KemisolAde@gmail.com', '09073930022', '12345', 'STF002', 1, 0, '2020-06-21'),
(14, 'Samuel', 'Samuel', 'John', 'SamuelJohn@yahoo.com', '09087654321', '12345', 'STF0032', 1, 0, '2020-09-14'),
(15, 'asd', 'asd', 'asd', 'asd@asd.ccc', '5555666654', '12345', '444', 0, 0, '2022-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `Id` int(20) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `age` text NOT NULL,
  `gender` text NOT NULL,
  `LRN` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `levelId` int(10) NOT NULL,
  `sectionId` varchar(10) NOT NULL,
  `sessionId` int(10) NOT NULL,
  `father` varchar(50) NOT NULL,
  `fathernum` varchar(11) NOT NULL,
  `mother` varchar(50) NOT NULL,
  `mothernum` varchar(11) NOT NULL,
  `guardian` varchar(50) NOT NULL,
  `guardiannum` varchar(11) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`Id`, `firstName`, `lastName`, `middleName`, `age`, `gender`, `LRN`, `password`, `levelId`, `sectionId`, `sessionId`, `father`, `fathernum`, `mother`, `mothernum`, `guardian`, `guardiannum`, `dateCreated`) VALUES
(101, 'Dolly', 'Malabanan', 'Justo', '7', 'Male', '109850060048', 'Dm40356!', 1, '81', 12, 'Reynaldo Cortez', '09569564761', 'Fe Cortez', '09569564761', 'Reynaldo Cortez', '09569564761', '2023-01-26 00:00:00'),
(102, 'Reynold Smith', 'Mendoza', 'Javier', '8', 'Male', '109850060089', 'Rm49496!', 1, '81', 12, 'Jundel Mendoza', '09135546546', 'Marie Mendoza', '09135546546', 'Marie Mendoza', '09135546546', '2023-01-26 00:00:00'),
(103, 'Irish Raven', 'Agojo', 'Gonzales', '7', 'Female', '109850060045', 'Ia78472!', 1, '81', 12, 'Rafael Agojo', '0956549482', 'Luzviminda Agojo', '0956549482', 'Luzviminda Agojo', '0956549482', '2023-01-26 00:00:00'),
(104, 'Ryan ', 'Lazaro', 'Mejeda', '7', 'Male', '109850070048', 'Rl42046!', 2, '76', 12, 'Many Lazaro', '09765815498', 'Lyra Joy Lazaro', '09782346513', 'Lyra Joy Lazaro', '09782346513', '2023-01-26 00:00:00'),
(108, 'Joanna', 'Landicho', 'Mendoza', '8', 'Female', '109850060056', 'Jl40463!', 1, '75', 12, '', '', 'Maria Luz Landicho', '09456562655', 'Maria Luz Landicho', '09456562655', '2023-02-04 00:00:00'),
(115, 'Marianne Jane', 'Garcia', 'Burgos', '8', 'Male', '10985465420', 'Mg93363!', 1, '81', 12, 'Jomar Garcia', '09231325513', 'Magdaline Garcia', '09655454531', 'Jomar Garcia', '09231325513', '2023-02-07 00:44:57'),
(118, 'Liza', 'Nivea', 'Reyes', '8', 'Female', '10985645789', 'Ln2156!', 1, '81', 12, 'Randy Nivea', '09455495535', 'Fe Nivea', '09455495535', 'Fe Nivea', '09455495535', '2023-02-07 14:25:32'),
(130, 'Lee Andrew', 'De Guzman', 'Santiago', '6', 'Male', '109850060021', 'Leeandrew21*', 1, '81', 11, 'Angelo De Guzman', '9087657864', 'Shantal De Guzman', '', 'Marife De Guzman', '9876567456', '2023-02-08 12:00:41'),
(131, 'Jolo', 'Tenorio', '', '6', 'Male', '109850060022', 'Jolo22*', 1, '81', 11, 'Cyrus Tenorio', '9078765763', 'Zeny Tenorio', '', 'Zeny Tenorio', '9976435564', '2023-02-08 12:00:41'),
(132, 'Renzo', 'Ancheta', 'Alfonso', '7', 'Male', '109850060023', 'Renzo23*', 1, '81', 11, 'Ervin Ancheta', '9876785676', 'Anabelle Ancheta', '', 'Anabelle Ancheta', '9987677654', '2023-02-08 12:00:41'),
(133, 'Lhester', 'Paraiso', 'Santarosa', '7', 'Male', '109850060024', 'Lhester24*', 1, '81', 11, 'Mark Paraiso', '9767435642', 'Hazel Paraiso', '', 'Hazel Paraiso', '9776544734', '2023-02-08 12:00:41'),
(135, 'Sarah', 'Lahbatti', 'Guittierez', '7', 'Female', '109850060028', 'Sl98995!', 1, '81', 11, '', '', '', '', 'Raymond Lahbatti', '09987675543', '2023-02-08 12:02:01'),
(138, 'Rain Nicole', 'Alcantara', 'Sopriano', '8', 'Female', '109862326656', 'Ra99529!', 1, '81', 12, '', '', '', '', 'Reynold Alcantara', '09555155544', '2023-02-08 14:58:57'),
(139, 'Dalie Mae', 'Justo', 'Tuazon', '7', 'Female', '109851321548', 'Dj99202!', 1, '81', 12, '', '', '', '', 'Randy Justo', '09212121355', '2023-02-08 15:00:22'),
(155, 'christian', 'Almonte', '', '7', 'Male', '010245451315', 'Ca90878!', 1, '81', 12, '', '', '', '', 'Eloisa Dalere', '09522353020', '2023-02-10 13:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubject`
--

CREATE TABLE `tblsubject` (
  `Id` int(11) NOT NULL,
  `subjectTitle` varchar(255) NOT NULL,
  `levelId` varchar(10) NOT NULL,
  `semesterId` varchar(20) NOT NULL,
  `dateAdded` varchar(50) NOT NULL,
  `sub_Id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsubject`
--

INSERT INTO `tblsubject` (`Id`, `subjectTitle`, `levelId`, `semesterId`, `dateAdded`, `sub_Id`) VALUES
(80, 'Math', '5', '', '2023-01-26', 0),
(79, 'English', '5', '', '2023-01-26', 0),
(78, 'Filipino', '5', '', '2023-01-26', 0),
(77, 'Araling Panlipunan', '5', '', '2023-01-26', 0),
(76, 'English', '4', '', '2023-01-26', 0),
(75, 'Esp', '4', '', '2023-01-26', 0),
(74, 'Science', '4', '', '2023-01-26', 0),
(73, 'Math', '4', '', '2023-01-26', 0),
(72, 'Filipino', '4', '', '2023-01-26', 0),
(71, 'Araling Panlipunan', '4', '', '2023-01-26', 0),
(70, 'ESP', '3', '', '2023-01-26', 0),
(69, 'Filipino', '3', '', '2023-01-26', 0),
(68, 'Math', '3', '', '2023-01-26', 0),
(67, 'Araling Panlipunan', '3', '', '2023-01-26', 0),
(66, 'Science', '3', '', '2023-01-26', 0),
(65, 'Mother Tongue', '2', '', '2023-01-26', 0),
(64, 'Math', '2', '', '2023-01-26', 0),
(63, 'Filipino', '2', '', '2023-01-26', 0),
(62, 'English', '2', '', '2023-01-26', 0),
(61, 'Araling Panlipunan', '2', '', '2023-01-26', 0),
(60, 'Filipino', '1', '', '2023-01-26', 0),
(59, 'Math', '1', '', '2023-01-26', 0),
(58, 'EsP', '1', '', '2023-01-26', 0),
(57, 'English', '1', '', '2023-01-26', 0),
(56, 'Araling Panlipunan', '1', '', '2023-01-26', 0),
(81, 'English', '6', '', '2023-01-26', 0),
(82, 'Math', '6', '', '2023-01-26', 0),
(83, 'Science', '6', '', '2023-01-26', 0),
(95, 'Filipino', '6', '', '2023-02-07', 0),
(85, 'Mother Tongue', '1', '', '2023-02-07', 0),
(86, 'Mapeh', '1', '', '2023-02-07', 0),
(87, 'MAPEH', '4', '', '2023-02-07', 0),
(88, 'EPP', '4', '', '2023-02-07', 0),
(89, 'Mapeh', '2', '', '2023-02-07', 0),
(90, 'EsP', '2', '', '2023-02-07', 0),
(91, 'Science', '5', '', '2023-02-07', 0),
(92, 'EsP', '5', '', '2023-02-07', 0),
(93, 'EPP', '5', '', '2023-02-07', 0),
(94, 'Mapeh', '5', '', '2023-02-07', 0),
(96, 'Esp', '6', '', '2023-02-07', 0),
(97, 'TLE', '6', '', '2023-02-07', 0),
(98, 'AP', '6', '', '2023-02-07', 0),
(99, 'MAPEH', '6', '', '2023-02-07', 0),
(100, 'English', '3', '', '2023-02-07', 0),
(101, 'MAPEH', '3', '', '2023-02-07', 0),
(102, 'EPP', '3', '', '2023-02-07', 0),
(111, 'Music', '1', '', '2023-02-09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbltask`
--

CREATE TABLE `tbltask` (
  `Id` int(11) NOT NULL,
  `taskname` varchar(50) NOT NULL,
  `tasktype` varchar(50) NOT NULL,
  `gradingperiod` varchar(50) NOT NULL,
  `teachingId` int(11) NOT NULL,
  `highest` int(10) NOT NULL,
  `passing` int(10) NOT NULL,
  `flagvisible` int(11) NOT NULL,
  `dateCreated` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbltask`
--

INSERT INTO `tbltask` (`Id`, `taskname`, `tasktype`, `gradingperiod`, `teachingId`, `highest`, `passing`, `flagvisible`, `dateCreated`) VALUES
(1, 'Task1', 'Written Work', '1st Grading', 0, 50, 26, 0, '2022-11-04'),
(2, 'Task1', 'Written Work', '1st Grading', 0, 50, 26, 0, '2022-11-04'),
(3, 'Quiz 1 ', '1', '1', 14, 10, 6, 0, '2022-12-01'),
(4, 'Quiz 1 ', '4', '1', 15, 10, 6, 0, '2022-12-01'),
(6, 'Quiz 1 ', '7', '2', 8, 10, 6, 0, '2022-12-09'),
(10, 'Quiz 1 ', '7', '2', 8, 10, 6, 0, '2022-12-09'),
(11, 'Quiz 1 ', '7', '2', 8, 10, 6, 0, '2022-12-09'),
(12, 'Quiz 1 ', '7', '1', 8, 50, 26, 0, '2022-12-09'),
(13, 'Quiz 1 ', '6', '1', 18, 10, 6, 0, '2022-12-20'),
(14, 'Quiz 2', '6', '2', 18, 15, 9, 0, '2022-12-22'),
(15, 'Task1', '10', '1', 10, 10, 4, 0, '2022-12-27'),
(16, 'Quiz 1 ', '11', '1', 19, 10, 6, 0, '2022-12-29'),
(18, 'Quiz 1 ', '12', '3', 9, 10, 6, 0, '2023-01-13'),
(23, 'Quiz 1 ', '12', '1', 9, 100, 50, 0, '2023-01-13'),
(24, 'Task1', '15', '1', 9, 100, 50, 0, '2023-01-13'),
(25, 'Essay', '13', '1', 9, 100, 50, 0, '2023-01-13'),
(26, 'Quiz 1', '14', '1', 9, 100, 50, 0, '2023-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `tbltask_type`
--

CREATE TABLE `tbltask_type` (
  `Id` int(11) NOT NULL,
  `title` text NOT NULL,
  `percent` int(11) NOT NULL,
  `teachingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbltask_type`
--

INSERT INTO `tbltask_type` (`Id`, `title`, `percent`, `teachingId`) VALUES
(1, 'Written Work', 40, 14),
(2, 'Performance', 30, 14),
(3, 'Exam', 30, 14),
(4, 'Written Work', 40, 15),
(5, 'Exam', 20, 15),
(6, 'Written work', 40, 18),
(7, 'written work', 60, 8),
(9, 'written', 30, 8),
(10, 'Written Work', 30, 10),
(11, 'written', 40, 19),
(12, 'written', 40, 9),
(13, 'machine problem', 40, 9),
(14, 'practical test', 40, 9),
(15, 'written examination', 40, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `staffId` (`staffId`);

--
-- Indexes for table `tbladmintype`
--
ALTER TABLE `tbladmintype`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbladviser`
--
ALTER TABLE `tbladviser`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `sectionId` (`sectionId`,`sessionId`) USING BTREE,
  ADD UNIQUE KEY `teacherId` (`teacherId`,`sessionId`);

--
-- Indexes for table `tblassignedadmin`
--
ALTER TABLE `tblassignedadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `studentId` (`studentId`,`month`,`sessionId`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcgparesult`
--
ALTER TABLE `tblcgparesult`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbldesignation`
--
ALTER TABLE `tbldesignation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblfaculty`
--
ALTER TABLE `tblfaculty`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `fid` (`fid`),
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `lname` (`lname`,`fname`,`mname`);

--
-- Indexes for table `tblfacultyload`
--
ALTER TABLE `tblfacultyload`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacherId` (`sectionId`,`subjectId`,`sessionId`) USING BTREE;

--
-- Indexes for table `tblfinalresult`
--
ALTER TABLE `tblfinalresult`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblgrade`
--
ALTER TABLE `tblgrade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblgrading`
--
ALTER TABLE `tblgrading`
  ADD PRIMARY KEY (`gradeId`),
  ADD UNIQUE KEY `taskId_2` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_3` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_4` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_5` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_6` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_7` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_8` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_9` (`taskId`,`studentId`),
  ADD UNIQUE KEY `taskId_10` (`taskId`,`studentId`),
  ADD KEY `taskId` (`taskId`);

--
-- Indexes for table `tbllevel`
--
ALTER TABLE `tbllevel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblpromoted`
--
ALTER TABLE `tblpromoted`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `studentId_2` (`studentId`,`sessionId`),
  ADD UNIQUE KEY `studentId` (`studentId`,`levelId`,`sectionId`,`sessionId`,`adviseeId`) USING HASH;

--
-- Indexes for table `tblquartergrade`
--
ALTER TABLE `tblquartergrade`
  ADD PRIMARY KEY (`gradeId`),
  ADD UNIQUE KEY `teachingId` (`teachingId`,`student_id`,`period`);

--
-- Indexes for table `tblresult`
--
ALTER TABLE `tblresult`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsection`
--
ALTER TABLE `tblsection`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `sectionName` (`sectionName`);

--
-- Indexes for table `tblsemester`
--
ALTER TABLE `tblsemester`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsession`
--
ALTER TABLE `tblsession`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `sessionName` (`sessionName`);

--
-- Indexes for table `tblstaff`
--
ALTER TABLE `tblstaff`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `firstName` (`firstName`,`lastName`,`middleName`,`LRN`,`father`,`mother`,`guardian`),
  ADD UNIQUE KEY `LRN` (`LRN`),
  ADD UNIQUE KEY `firstName_2` (`firstName`,`lastName`,`middleName`,`father`,`mother`,`guardian`);

--
-- Indexes for table `tblsubject`
--
ALTER TABLE `tblsubject`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `subjectTitle` (`subjectTitle`,`levelId`);

--
-- Indexes for table `tbltask`
--
ALTER TABLE `tbltask`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbltask_type`
--
ALTER TABLE `tbltask_type`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `tbladmintype`
--
ALTER TABLE `tbladmintype`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbladviser`
--
ALTER TABLE `tbladviser`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tblassignedadmin`
--
ALTER TABLE `tblassignedadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcgparesult`
--
ALTER TABLE `tblcgparesult`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbldesignation`
--
ALTER TABLE `tbldesignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblfaculty`
--
ALTER TABLE `tblfaculty`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `tblfacultyload`
--
ALTER TABLE `tblfacultyload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tblfinalresult`
--
ALTER TABLE `tblfinalresult`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblgrade`
--
ALTER TABLE `tblgrade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblgrading`
--
ALTER TABLE `tblgrading`
  MODIFY `gradeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbllevel`
--
ALTER TABLE `tbllevel`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpromoted`
--
ALTER TABLE `tblpromoted`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `tblquartergrade`
--
ALTER TABLE `tblquartergrade`
  MODIFY `gradeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `tblresult`
--
ALTER TABLE `tblresult`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblsection`
--
ALTER TABLE `tblsection`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `tblsemester`
--
ALTER TABLE `tblsemester`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsession`
--
ALTER TABLE `tblsession`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblstaff`
--
ALTER TABLE `tblstaff`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `tblsubject`
--
ALTER TABLE `tblsubject`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `tbltask`
--
ALTER TABLE `tbltask`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbltask_type`
--
ALTER TABLE `tbltask_type`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
