SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--
CREATE DATABASE `oocms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `oocms`;

-- --------------------------------------------------------

--
-- Table structure for table `blogroll`
--

CREATE TABLE IF NOT EXISTS `blogroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `blog` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commenter_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(50) NOT NULL,
  `comments` longtext NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_time` time NOT NULL,
  `commenter_type` varchar(50) NOT NULL,
  `reply_to` int(50) NOT NULL,
  `approval` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_date` date NOT NULL,
  `article_time` time NOT NULL,
  `date_gmt` date NOT NULL,
  `time_gmt` time NOT NULL,
  `user_timezone` varchar(200) NOT NULL,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `folder` varchar(50) NOT NULL,
  `content_author` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `tab`
--

CREATE TABLE IF NOT EXISTS `tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_title` varchar(200) NOT NULL,
  `tag_line` varchar(200) NOT NULL,
  `limits` int(200) NOT NULL,
  `storage_server` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

CREATE TABLE IF NOT EXISTS `widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usernameblog` varchar(200) NOT NULL,
  `passwordblog` varchar(200) NOT NULL,
  `fullnameblog` varchar(200) NOT NULL,
  `gmtblog` varchar(200) NOT NULL,
  `emailblog` varchar(200) NOT NULL,
  `websiteblog` varchar(200) NOT NULL,
  `typeblog` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
