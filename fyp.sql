-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2020 at 03:52 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(255) NOT NULL,
  `board_id` varchar(255) NOT NULL,
  `cat_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='To store note categories for each board';

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `board_id`, `cat_name`) VALUES
(2, '03857e3daab4f75dba5b304f3d962c9c', 'test category 1'),
(3, '03857e3daab4f75dba5b304f3d962c9c', 'test category 2'),
(16, '47c5f1aeb58f33a1426322a2be1d61fe', 'whoa man nice'),
(18, '47c5f1aeb58f33a1426322a2be1d61fe', 'yes'),
(26, '03857e3daab4f75dba5b304f3d962c9c', 'hello welcome xd'),
(27, '03857e3daab4f75dba5b304f3d962c9c', 'empty category test'),
(28, '27d46079539c1490e91bce62f32cb09a', 'yes 2'),
(30, '9903cea20f091476787d5340880d047c', 'Bleh');

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE `invite` (
  `invite_id` int(255) NOT NULL,
  `invite_board` varchar(255) NOT NULL,
  `invite_to` varchar(255) NOT NULL,
  `invite_from` varchar(255) NOT NULL,
  `invite_msg` varchar(100) NOT NULL,
  `invite_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='To store noteboard invitations for each user';

--
-- Dumping data for table `invite`
--

INSERT INTO `invite` (`invite_id`, `invite_board`, `invite_to`, `invite_from`, `invite_msg`, `invite_datetime`) VALUES
(43, '03857e3daab4f75dba5b304f3d962c9c', 'lukazlim3@yahoo.com', 'lukazlim@yahoo.com', 'come', '2020-11-06 16:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `note_id` int(255) NOT NULL,
  `board_id` varchar(255) NOT NULL,
  `note_creator` varchar(12) NOT NULL,
  `note_editor` varchar(12) NOT NULL,
  `note_title` varchar(200) NOT NULL,
  `note_category` int(255) NOT NULL,
  `note_content` longtext NOT NULL,
  `note_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='To store note information and what board they belong to';

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`note_id`, `board_id`, `note_creator`, `note_editor`, `note_title`, `note_category`, `note_content`, `note_modified`) VALUES
(6, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'asgffsgsa', 0, '# heading 1\r\n## heading 2\r\n\r\n---\r\n\r\n- whoa 1\r\n- whoa 2\r\n- whoa 3\r\n\r\n**yeeeeaaahh**', '2020-10-29 15:14:20'),
(14, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'test', 0, '### Greetings\r\nI am an *uncategorized* note!', '2020-10-29 15:39:21'),
(34, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'test collab owner create', 3, 'it\'s me lukazio', '2020-11-02 15:08:24'),
(35, '03857e3daab4f75dba5b304f3d962c9c', 'lukazlim', 'lukazlim', 'test collab member create', 3, 'it\'s me 2nd lukazio', '2020-11-02 15:09:49'),
(36, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'another uncategorised note', 0, 'yes it\'s me finally apostrophes work i\'m happy now', '2020-11-02 15:11:25'),
(37, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'yes very welcome', 26, 'haha yes wwww', '2020-11-02 15:12:21'),
(38, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'finally correct timezone', 3, 'remembered how to set the default timezone, i\'m now relieved.', '2020-11-05 10:23:29'),
(39, '27d46079539c1490e91bce62f32cb09a', 'lukazlim', 'lukazlim', 'hee ho', 0, 'whoa nice 2', '2020-11-03 18:25:57'),
(40, '27d46079539c1490e91bce62f32cb09a', 'lukazlim', 'lukazlim', 'another', 0, '', '2020-11-03 01:10:50'),
(41, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'fsdgsdgf d gs gdaf dfas adfs fads afsdfas  adsdfsa fads da fas d', 0, '', '2020-11-03 13:06:31'),
(44, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'Hello lmao this is a test XD', 26, '### I\'m testing this Markdown note stuff now\r\n\r\n**Stuff to do:**\r\n1. sleep\r\n2. sleep more\r\n3. wake up\r\n\r\n---\r\n\r\n- yeah\r\n- unordered\r\n- lists success\r\n    1. suddenly\r\n    2. indented list items\r\n- cool\r\n    - right?\r\n        - funny staircase time\r\n\r\nI hope this is over soon...\r\n> I am *very* tired :(  \r\n> ***send help***\r\n\r\n![Gordon H](https://video-images.vice.com/articles/5a6a4c2d014bfe6bdb87bf8f/lede/1516916522679-Screen-Shot-2018-01-25-at-44145-PM.png?crop=0.7325102880658436xw:1xh;center,center \"test image\")\r\n\r\nThis is a test link by itself https://www.google.com\r\n\r\n[This is a test link in a text and has a hover title](https://www.google.com \"Hello I\'m a title!\")\r\n\r\n\r\n`I am a test code line, below me is a code block`\r\n\r\n    createCodeBlock() {\r\n        print \"I am a test code block of a pseudocode!\"\r\n    }', '2020-11-05 12:17:19'),
(45, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'dfsgfdg', 0, '>blockquote test', '2020-11-03 16:46:50'),
(46, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'yes', 26, 'lmao test', '2020-11-04 11:22:35'),
(50, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'another note edited', 2, '# Hello.\r\n\r\n- why are we here?\r\n- why is ***this*** here?\r\n\r\n> I hope this is done', '2020-11-05 20:09:34'),
(51, '9903cea20f091476787d5340880d047c', 'lukazio', 'lukazio', 'jkghjfgsdASAsfsrgtjuuerrqNGHGHHGDFASDjhjkjhdgf', 30, '_srtsdgfhjuytfdcdfd_  \r\n*fsd*\r\n#wheeee\r\n\r\n- asfdvadds\r\n- asfasd\r\n- avfsgfgd\r\n\r\n(faosijdslfj)[https://archiveofourown.org/]', '2020-11-04 14:39:32'),
(52, '9903cea20f091476787d5340880d047c', 'lukazio', 'lukazio', 'd', 0, 'g', '2020-11-04 14:40:46'),
(53, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'hjhjhjhj', 0, 'srxdcgfvhg', '2020-11-04 14:43:51'),
(54, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'demonstration dfg adfg hfad ghafd gh fgh gh fgh f ghf ghf ryhy', 0, '# this is a test\r\n\r\n- one\r\n- two\r\n- three\r\n\r\n> hello\r\n\r\nhttps://drive.google.com/file/d/1mpobPsAzmUfKpPphGwWCBsJk_9uJluQJ/view?usp=sharing', '2020-11-05 10:20:12'),
(58, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'empty note test', 0, '', '2020-11-05 20:45:36'),
(59, '03857e3daab4f75dba5b304f3d962c9c', 'lukazio', 'lukazio', 'drsgdfsgdfags', 0, 'dfthdtysdtwydrab', '2020-11-06 20:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `noteboard`
--

CREATE TABLE `noteboard` (
  `board_id` varchar(255) NOT NULL,
  `board_name` varchar(50) NOT NULL,
  `board_owner` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='To store noteboards and their owners';

--
-- Dumping data for table `noteboard`
--

INSERT INTO `noteboard` (`board_id`, `board_name`, `board_owner`) VALUES
('03857e3daab4f75dba5b304f3d962c9c', 'noteboard 1', 4),
('27d46079539c1490e91bce62f32cb09a', 'dfgsghsd', 5),
('47c5f1aeb58f33a1426322a2be1d61fe', 'noteboard 2', 4),
('7432074ddd6bd4db7e364d6586df8b7c', 'fff  fff', 4),
('9903cea20f091476787d5340880d047c', 'jkgdfgsdg', 4),
('bd5bf2e6be965f76db3af81a10639efc', 'yes board welcome here xd', 4),
('c20e4431127c9450ebf99f6dc1c8e3bc', 'noteboard 1123', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(255) NOT NULL,
  `user_name` varchar(12) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User accounts table';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(4, 'lukazio', 'lukazlim@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$ekpHRVhoRzh3L0E1dGsxdw$57XLj++c1P2ICVJJzm/9uQAOVAetDJ9Q6cf4n7ZxPZc'),
(5, 'lukazlim', 'lukazlim2@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$RWNqL3VreDhid2FhcVhWcw$u3NHBbJB8k83RlZuF22rravAh8HEJNxPKroQL9ra83g'),
(6, 'lukazio123', 'lukazholiao@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$cUd0QnhYbUpkOFpDVi5tVQ$F5ygB+btlP9BOVysQfa0mAxnWINFGkiqGon9ZLkMGps'),
(7, 'lukazio123jk', 'lukazlimdd@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$NlRKME1IdmptNExSUy82dw$sSn03iyi/l2348yBKXtzLpe3QRt3B3zzdiibPRqwN8s'),
(8, 'ssdasdasd', 'lukazlsssim@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$M3lpVzJhdG1HL2RTLnBkSQ$LPNou0TP2Wpctqt32sOu36qH3Rbwau5kRPN9yg3MZaU'),
(9, 'lukazio456', 'lukazlim3@yahoo.com', '$argon2id$v=19$m=65536,t=4,p=1$a0tCanJiV0psckFISkExTg$D9LEZrI+DNOdN1+Q4Wf+QTE1YUMyjIX7/UkAA8qaotQ');

-- --------------------------------------------------------

--
-- Table structure for table `user_noteboard`
--

CREATE TABLE `user_noteboard` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `board_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='To store info of what noteboard users joined';

--
-- Dumping data for table `user_noteboard`
--

INSERT INTO `user_noteboard` (`id`, `user_id`, `board_id`) VALUES
(24, 4, '27d46079539c1490e91bce62f32cb09a'),
(25, 5, '03857e3daab4f75dba5b304f3d962c9c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `board_id` (`board_id`);

--
-- Indexes for table `invite`
--
ALTER TABLE `invite`
  ADD PRIMARY KEY (`invite_id`),
  ADD KEY `invite_board` (`invite_board`),
  ADD KEY `invite_to` (`invite_to`),
  ADD KEY `invite_from` (`invite_from`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `note_creator` (`note_creator`),
  ADD KEY `note_editor` (`note_editor`),
  ADD KEY `note_category` (`note_category`);

--
-- Indexes for table `noteboard`
--
ALTER TABLE `noteboard`
  ADD PRIMARY KEY (`board_id`),
  ADD KEY `board_owner` (`board_owner`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`) USING BTREE,
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `user_noteboard`
--
ALTER TABLE `user_noteboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `board_id` (`board_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `invite`
--
ALTER TABLE `invite`
  MODIFY `invite_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `note_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_noteboard`
--
ALTER TABLE `user_noteboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `noteboard` (`board_id`);

--
-- Constraints for table `invite`
--
ALTER TABLE `invite`
  ADD CONSTRAINT `invite_ibfk_1` FOREIGN KEY (`invite_board`) REFERENCES `noteboard` (`board_id`),
  ADD CONSTRAINT `invite_ibfk_2` FOREIGN KEY (`invite_to`) REFERENCES `user` (`user_email`),
  ADD CONSTRAINT `invite_ibfk_3` FOREIGN KEY (`invite_from`) REFERENCES `user` (`user_email`);

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `noteboard` (`board_id`),
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`note_creator`) REFERENCES `user` (`user_name`),
  ADD CONSTRAINT `note_ibfk_3` FOREIGN KEY (`note_editor`) REFERENCES `user` (`user_name`);

--
-- Constraints for table `noteboard`
--
ALTER TABLE `noteboard`
  ADD CONSTRAINT `noteboard_ibfk_1` FOREIGN KEY (`board_owner`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_noteboard`
--
ALTER TABLE `user_noteboard`
  ADD CONSTRAINT `user_noteboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_noteboard_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `noteboard` (`board_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
