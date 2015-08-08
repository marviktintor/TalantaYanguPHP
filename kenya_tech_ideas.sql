-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2015 at 10:00 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kenya_tech_ideas`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id_comment` int(11) NOT NULL,
  `id_project` int(11) NOT NULL DEFAULT '-1',
  `id_user` int(11) NOT NULL DEFAULT '-1',
  `comment_text` text NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_comment`, `id_project`, `id_user`, `comment_text`, `commit_time`) VALUES
(1, 2, 2, 'This is a very good idea,we can have all techies post all their ideas in a cental pool', '2015-08-06 13:33:53'),
(2, 1, 2, 'Where is your hub?', '2015-08-06 16:01:45'),
(3, 1, 2, 'They have an online hub! ha-ha', '2015-08-06 21:21:06'),
(4, 3, 0, 'There is a Lipa na MPESA Online API. You can use it for now', '2015-08-08 03:21:56'),
(5, 3, 0, 'You need a certain consumer key from safaricom', '2015-08-08 03:23:14'),
(6, 3, 0, 'There are some open source indocumented api''s that you can find on git', '2015-08-08 03:31:21'),
(7, 3, 2, 'Safaricom always says the API is coming from Romania', '2015-08-08 03:37:13'),
(8, 3, 2, 'I have a private API I use for that', '2015-08-08 06:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `comments_impressions`
--

CREATE TABLE IF NOT EXISTS `comments_impressions` (
`id_comment_impression` int(11) NOT NULL,
  `id_comment` int(11) NOT NULL DEFAULT '-1',
  `id_user` int(11) NOT NULL DEFAULT '-1',
  `likes` int(11) NOT NULL DEFAULT '0',
  `unlikes` int(11) NOT NULL DEFAULT '0',
  `favorites` int(11) NOT NULL DEFAULT '0',
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments_impressions`
--

INSERT INTO `comments_impressions` (`id_comment_impression`, `id_comment`, `id_user`, `likes`, `unlikes`, `favorites`, `commit_time`) VALUES
(43, 1, 2, 0, 0, 1, '2015-08-08 02:16:23'),
(57, 2, 3, 0, 1, 0, '2015-08-08 02:19:28'),
(59, 1, 3, 1, 0, 0, '2015-08-08 02:52:56'),
(63, 1, 3, 0, 0, 1, '2015-08-08 03:02:31'),
(65, 5, 0, 0, 1, 0, '2015-08-08 03:25:22'),
(66, 5, 0, 0, 0, 1, '2015-08-08 03:25:23'),
(68, 4, 0, 1, 0, 0, '2015-08-08 03:25:25'),
(69, 4, 2, 0, 0, 1, '2015-08-08 03:32:27'),
(70, 4, 2, 0, 1, 0, '2015-08-08 03:32:28'),
(83, 7, 2, 0, 0, 1, '2015-08-08 03:37:31'),
(101, 7, 2, 1, 0, 0, '2015-08-08 03:42:09'),
(108, 3, 2, 0, 0, 1, '2015-08-08 03:52:32'),
(110, 3, 2, 1, 0, 0, '2015-08-08 03:52:35'),
(115, 6, 2, 0, 1, 0, '2015-08-08 06:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
`id_company` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `county` text NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id_company`, `company_name`, `county`, `commit_time`) VALUES
(1, 'Origi Check', 'Nairobi', '2015-08-07 15:58:07'),
(2, 'Astor Computers', 'Laikipia', '2015-08-08 00:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `employment_info`
--

CREATE TABLE IF NOT EXISTS `employment_info` (
`id_employment_info` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `stop_date` date DEFAULT NULL,
  `role` text NOT NULL,
  `county` text NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employment_info`
--

INSERT INTO `employment_info` (`id_employment_info`, `id_company`, `id_user`, `start_date`, `stop_date`, `role`, `county`, `commit_time`) VALUES
(1, 1, 2, '2015-08-07', '2015-08-07', 'Tech Lead and Project Manager', 'Nairobi', '2015-08-07 15:58:07'),
(2, 2, 3, '2014-01-01', '2014-12-31', 'Software Developer', 'Laikipia', '2015-08-08 00:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
`id_files` int(11) NOT NULL,
  `file_uri` text NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
`id_project` int(11) NOT NULL,
  `project_title` text NOT NULL,
  `project_tags` text NOT NULL,
  `project_desc` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id_project`, `project_title`, `project_tags`, `project_desc`, `id_user`, `commit_time`) VALUES
(1, 'Kenya Innovation Center', 'kenya,innovation,ideas,tech,programming,development,software', 'Create A Project where Investors can meet innovators', 2, '2015-08-06 12:15:57'),
(2, 'Kenya Pitching Center', 'tech,programming,development,software', 'Create A Project where Investors can meet innovators, Post Projects, Investors can talk with clients e.t.c', 2, '2015-08-06 12:22:33'),
(3, 'MPESA API OPEN SOURCE', 'apache,mpesa-api,safaricom', 'Develop an Open source Mpesa Api', 3, '2015-08-07 12:40:22'),
(4, 'How to Integrate bank services with your app?', 'bank,apps,api', 'I want someone to develop an API where I can integrate my business with my user apps. I have a point of sale', 2, '2015-08-08 06:25:36'),
(5, 'Point of Sale ERP for Android', 'pos,erp,android', 'I am selling a point of sale android application that supports "SAAS" Services and Custom Codebase Check it out here <a target="_blank" href="https://play.google.com/store/apps/details?id=com.marvik.apps.pos">Here</a>', 2, '2015-08-08 06:35:40'),
(6, 'Point of Sale for Android', 'android,pos,erp', 'I am looking for android developers who can continue with the development of my application.\nFind my application <a target="_blank" href="https://play.google.com/store/apps/details?id=com.manager.biashara">here</a> \n', 4, '2015-08-08 07:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `project_impressions`
--

CREATE TABLE IF NOT EXISTS `project_impressions` (
`id_project_impression` int(11) NOT NULL,
  `id_project` int(11) NOT NULL DEFAULT '-1',
  `id_user` int(11) NOT NULL DEFAULT '-1',
  `likes` int(11) NOT NULL DEFAULT '0',
  `unlikes` int(11) NOT NULL DEFAULT '0',
  `favorites` int(11) NOT NULL DEFAULT '0',
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_impressions`
--

INSERT INTO `project_impressions` (`id_project_impression`, `id_project`, `id_user`, `likes`, `unlikes`, `favorites`, `commit_time`) VALUES
(127, 1, 2, 1, 0, 0, '2015-08-08 02:17:44'),
(131, 2, 3, 1, 0, 0, '2015-08-08 02:18:57'),
(136, 1, 3, 1, 0, 0, '2015-08-08 02:19:12'),
(137, 3, 3, 1, 0, 0, '2015-08-08 02:19:39'),
(139, 3, 3, 0, 0, 1, '2015-08-08 03:02:25'),
(140, 1, 2, 0, 0, 1, '2015-08-08 03:56:13'),
(150, 3, 2, 1, 0, 0, '2015-08-08 06:46:36'),
(152, 4, 2, 0, 0, 1, '2015-08-08 06:46:41'),
(171, 5, 2, 0, 1, 0, '2015-08-08 07:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `project_media`
--

CREATE TABLE IF NOT EXISTS `project_media` (
`id_project_media` int(11) NOT NULL,
  `id_file` text NOT NULL,
  `id_project` int(11) NOT NULL DEFAULT '-1',
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_views`
--

CREATE TABLE IF NOT EXISTS `project_views` (
`id_project_views` int(11) NOT NULL,
  `id_project` int(11) NOT NULL DEFAULT '-1',
  `id_user` int(11) NOT NULL DEFAULT '-1',
  `count_views` int(11) NOT NULL DEFAULT '0',
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_views`
--

INSERT INTO `project_views` (`id_project_views`, `id_project`, `id_user`, `count_views`, `commit_time`) VALUES
(1, 2, 2, 102, '2015-08-06 15:24:47'),
(2, 1, 2, 87, '2015-08-06 15:24:49'),
(3, 3, 2, 44, '2015-08-07 12:40:29'),
(4, 3, 3, 56, '2015-08-08 00:42:25'),
(5, 2, 3, 7, '2015-08-08 01:06:53'),
(6, 1, 3, 3, '2015-08-08 02:19:06'),
(7, 3, 0, 22, '2015-08-08 03:21:41'),
(8, 2, 0, 6, '2015-08-08 03:25:13'),
(9, 1, 0, 1, '2015-08-08 03:25:14'),
(10, -1, 2, 321, '2015-08-08 03:44:05'),
(11, 4, 2, 32, '2015-08-08 06:25:38'),
(12, 5, 2, 33, '2015-08-08 06:35:44'),
(13, 3, 2, 22, '2015-08-08 06:46:14'),
(14, 6, 2, 1, '2015-08-08 07:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
`id_school` int(11) NOT NULL,
  `school_name` text NOT NULL,
  `county` text NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id_school`, `school_name`, `county`, `commit_time`) VALUES
(1, 'Masinde Muliro University of Science and Technology', 'Kakamega', '2015-08-07 15:59:26'),
(2, 'MMUST', 'Kakamega', '2015-08-08 00:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `school_info`
--

CREATE TABLE IF NOT EXISTS `school_info` (
`id_school_info` int(11) NOT NULL,
  `id_school` int(11) NOT NULL,
  `id_user` text NOT NULL,
  `join_date` date NOT NULL,
  `course` text NOT NULL,
  `leave_date` date DEFAULT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_info`
--

INSERT INTO `school_info` (`id_school_info`, `id_school`, `id_user`, `join_date`, `course`, `leave_date`, `commit_time`) VALUES
(1, 1, '2', '2012-08-25', 'Bachelor of Science in Information Technology', '2015-08-07', '2015-08-07 15:59:26'),
(2, 2, '3', '2012-08-25', 'Bsc I.T', '2015-08-08', '2015-08-08 00:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id_users` int(11) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT '-1',
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `id_number` varchar(128) NOT NULL,
  `commit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `user_type`, `firstname`, `lastname`, `username`, `password`, `email`, `phone`, `id_number`, `commit_time`) VALUES
(-1, 1, 'Anonymous', 'Anonymous', 'Anonymous', 'Anonymous', 'anonymous@anonymous.com', '0000000000', '00000000', '2015-08-06 10:20:37'),
(2, 1, 'Victor ', 'Mwenda', 'marvik', 'pass123', 'vmwenda.vm@gmail.com', '0718034449', '32361839', '2015-08-06 10:21:18'),
(3, 1, 'Mwenda', 'Victor', 'victor', 'pass123', 'victormwenda@hotmail.com', '0718034449', '32361839', '2015-08-08 00:24:40'),
(4, 1, 'John', 'Doe', 'johndoe', '#sbxob@', 'johndoe@john.com', '0712345678', '12345678', '2015-08-08 07:36:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `comments_impressions`
--
ALTER TABLE `comments_impressions`
 ADD PRIMARY KEY (`id_comment_impression`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
 ADD PRIMARY KEY (`id_company`);

--
-- Indexes for table `employment_info`
--
ALTER TABLE `employment_info`
 ADD PRIMARY KEY (`id_employment_info`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
 ADD PRIMARY KEY (`id_files`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
 ADD PRIMARY KEY (`id_project`);

--
-- Indexes for table `project_impressions`
--
ALTER TABLE `project_impressions`
 ADD PRIMARY KEY (`id_project_impression`);

--
-- Indexes for table `project_media`
--
ALTER TABLE `project_media`
 ADD PRIMARY KEY (`id_project_media`);

--
-- Indexes for table `project_views`
--
ALTER TABLE `project_views`
 ADD PRIMARY KEY (`id_project_views`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
 ADD PRIMARY KEY (`id_school`);

--
-- Indexes for table `school_info`
--
ALTER TABLE `school_info`
 ADD PRIMARY KEY (`id_school_info`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `comments_impressions`
--
ALTER TABLE `comments_impressions`
MODIFY `id_comment_impression` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employment_info`
--
ALTER TABLE `employment_info`
MODIFY `id_employment_info` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
MODIFY `id_files` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `project_impressions`
--
ALTER TABLE `project_impressions`
MODIFY `id_project_impression` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT for table `project_media`
--
ALTER TABLE `project_media`
MODIFY `id_project_media` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_views`
--
ALTER TABLE `project_views`
MODIFY `id_project_views` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
MODIFY `id_school` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `school_info`
--
ALTER TABLE `school_info`
MODIFY `id_school_info` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
