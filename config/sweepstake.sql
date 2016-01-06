-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2016 at 12:17 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sweepstake`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date_registered` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `role`, `date_registered`) VALUES
(1, 'Kaiste Ventures Ltd', 'info@kaisteventures.com', 'Kaiste Ventures', 'ae2b1fca515949e5d54fb22b8ed95575', 'Admin', '2015-08-20'),
(5, 'Mojolagbe J. Babatunde', 'mojolagbe@gmail.com', 'Babatunde', 'ae2b1fca515949e5d54fb22b8ed95575', 'Admin', '2015-12-14'),
(9, 'Toyin Adebolajo', 'tyadex@kaisteventures.com', 'Ty Adex', 'ae2b1fca515949e5d54fb22b8ed95575', 'Admin', '2015-12-14'),
(10, 'Julius Aghaowa', 'juliusoa@kaisteventures.com', 'Aghaowa', 'ae2b1fca515949e5d54fb22b8ed95575', 'Admin', '2015-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `intro` varchar(600) NOT NULL,
  `description` text NOT NULL,
  `header` varchar(300) NOT NULL,
  `logo` varchar(300) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `announcement_date` varchar(200) NOT NULL,
  `winners` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` varchar(500) NOT NULL,
  `point` int(11) NOT NULL,
  `bonus_point` int(11) NOT NULL,
  `rules` text NOT NULL,
  `prize` text NOT NULL,
  `message` varchar(500) NOT NULL,
  `css` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` date NOT NULL,
  `announce_winner` varchar(10) NOT NULL,
  `restart` varchar(10) NOT NULL,
  `restart_interval` int(11) NOT NULL,
  `cut_off_point` int(11) NOT NULL,
  `theme` varchar(300) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`,`start_date`,`end_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `contest`
--

INSERT INTO `contest` (`id`, `title`, `intro`, `description`, `header`, `logo`, `start_date`, `end_date`, `announcement_date`, `winners`, `question`, `answer`, `point`, `bonus_point`, `rules`, `prize`, `message`, `css`, `status`, `date_added`, `announce_winner`, `restart`, `restart_interval`, `cut_off_point`, `theme`) VALUES
(1, 'Free Courses Promo - Nigerian Seminars and Trainngs', 'We''re giving away Free Courses !', 'Invite your friends to start using Nigerian Seminars and Trainings website and you stand a chance of winner free course attendance of your choice!!', '711582_free-courses-promo-nigerian-seminars-and-trainngs.png', '258917_free-courses-promo-editing-mode-nigerian-seminars-and-trainngs.jpe', '23 December 2015 - 14:50', '12 January 2016 - 00:00', '12 January 2016 - 00:00', 3, 'How many premium training providers are there on the home page of nigerianseminarsandtrainings.com website?', '10', 10, 5, '<p>- Register on <a href="https://nigerianseminarsandtrainings.com" target="_blank">Nigerian Seminars and Trainings Website</a></p>\r\n\r\n<p>- Get your friends&#39; emails and make sure that they are not already registered member there</p>\r\n\r\n<p>- Then you are good to go then</p>\r\n', 'Free Courses plus amazing prizes.', 'Thank you for participating in our giveaway.', 'body.desktop, .facebox h2{background-color: #ccff33;}\r\n#wrapper {\r\n    padding-top: 2%;\r\n    background-color: #000;\r\n}\r\n .facebox h2{color:#000;}\r\n.facebox div{border:none}', 1, '2015-12-17', 'Yes', 'No', 14, 700, 'default'),
(2, 'Free Courses Contest - Nigerian Seminars and Trainings ', 'Just testing this for testing sake!', 'This all about testing contest !', '411957_free-courses-contest-nigerian-seminars-and-trainings.jpg', '495480_free-courses-contest-nigerian-seminars-and-trainings.png', '30 December 2015 - 14:10', '31 December 2015 - 14:50', '05 January 2016 - 10:50', 2, 'What is your last name?', 'I don''t know', 5, 2, '<p>The rules goes here</p>\r\n', 'Free Courses', 'Thanks', '', 1, '2015-12-17', 'No', 'Yes', 7, 90, 'default'),
(6, 'Several Attemps 2  - MJB', 'We''re giving away an awesome prize!', 'That''s right, and all you have to do is enter! Fill out the form and be sure to share with friends. The more the merrier!', '213241_several-attemps-2-mjb.png', '621466_several-attemps-2-mjb.jpe', '18 December 2015 - 10:08', '18 December 2015 - 10:08', '18 December 2015 - 10:08', 10, 'What is that?', 'It is a basket', 4, 2, '<p>Registeration on our site is compulsory</p>\r\n', '2 Free Laptop Computers for each winner', 'Thanks', 'body{background:blue}', 1, '2015-12-18', 'Yes', 'Yes', 7, 100, 'default'),
(7, 'PHP Coding 2015 Contest for Beginners', 'Developers award for 2015!', 'Invite for more of your programmer friends and stand a chance to win prizes!', '362600_php-coding-2015-contest-for-beginners.png', '473480_php-coding-2015-contest-for-beginners.jpe', '31 December 2015 - 17:20', '10 February 2016 - 13:20', '16 March 2016 - 06:20', 12, 'What is this ball called?', 'Balloon', 10, 2, '<p>=&gt; That is register</p>\r\n\r\n<p>=&gt; Name with held</p>\r\n', 'Free Laptops computer', 'Thanks', 'body{display:block}', 1, '2015-12-21', 'Yes', 'Yes', 17, 0, 'default'),
(9, 'Test', 'test', 'test', '810541_test.jpg', '966135_test.png', '20 January 2016 - 11:50', '06 January 2016 - 10:50', '30 January 2016 - 18:50', 4, 'No', 'No', 2, 2, '<p>Yeah</p>\r\n', 'rewt', 'Thanks', '', 0, '2016-01-05', 'Yes', 'No', 7, 900, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `entrant`
--

CREATE TABLE IF NOT EXISTS `entrant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `friends` text NOT NULL,
  `names` text NOT NULL,
  `time_entered` int(11) NOT NULL,
  `contest` int(11) NOT NULL,
  `point` decimal(11,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `entrant`
--

INSERT INTO `entrant` (`id`, `email`, `friends`, `names`, `time_entered`, `contest`, `point`) VALUES
(1, 'mojolagbe@gmail.com', 'tester@gmail.com', 'Mojolagbe Jamiu,', 1450795378, 1, '900.00'),
(18, 'info@kaisteventures.com', 'test@gmail.com,hyare@yahoo.com,aladex@gmail.com,adms@in.com,yusf_ibrahim@gmail.com,', 'Ibrahim Yusuf,Dada Abas,Ibrahim Yusuf,None Adams[m],Ibrahim Yusuf,', 1451920758, 1, '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(200) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `value`) VALUES
('COMPANY_NAME', '<p>Sweepstakes &amp; Contests</p>\r\n'),
('FACEBOOK_ADMINS', '<p>123456</p>\r\n'),
('FACEBOOK_APP_ID', '<p>234562</p>\r\n'),
('FACEBOOK_LINK', '<p>https://www.facebook.com/nigerianseminars</p>\r\n'),
('GOOGLEPLUS_LINK', '<p>https://plus.google.com/</p>\r\n'),
('LINKEDIN_LINK', '<p>https://www.linkedin.com/</p>\r\n'),
('MAIN_ADMIN_EMAIL', '<p>info@kaisteventures.com</p>\r\n'),
('PINTEREST_LINK', '<p>https://www.pinterest.com</p>\r\n'),
('RETURN_URL', '<p>https://www.nigerianseminarsandtrainings.com</p>\r\n'),
('TWITTER_LINK', '<p>https://www.twitter.com/+NigerianSeminar</p>\r\n'),
('YOUTUBE_LINK', '<p>https://www.youtube.com/</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `webpage`
--

CREATE TABLE IF NOT EXISTS `webpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(700) NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `winner`
--

CREATE TABLE IF NOT EXISTS `winner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest` text NOT NULL,
  `entrant` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
