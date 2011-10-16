SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `oocms`
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

INSERT INTO `blogroll` (`id`, `user_name`, `blog`) VALUES
(1, 'Kevin Dummy', 'http://google.com'),
(2, 'Chester Dummy', 'http://google.com'),
(3, 'Tonya Dummy', 'http://google.com');

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

INSERT INTO `comments` (`id`, `commenter_name`, `email`, `website`, `comments`, `post_id`, `comment_date`, `comment_time`, `commenter_type`, `reply_to`, `approval`) VALUES
(1, 'Mario Dummy', 'dummy@dummy.com', 'http://dummy.com', 'This is a dummy comment.', 1, '2011-02-18', '06:59:30', 'viewer', 0, 'approved');

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

INSERT INTO `content` (`id`, `article_date`, `article_time`, `date_gmt`, `time_gmt`, `user_timezone`, `title`, `content`, `folder`, `content_author`) VALUES
(1, '2011-02-17', '11:51:10', '2011-02-17', '04:51:10', 'Asia/Jakarta', 'Dummy Post', '<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec nisl arcu, eget mattis lectus. Donec mattis, erat vitae pharetra elementum, erat elit pellentesque sapien, eu vestibulum tellus nibh eu eros. Fusce non eros at leo malesuada mollis vitae vitae tellus. Ut eget felis libero, nec dictum elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec leo turpis, lacinia et egestas ut, sagittis sed leo. Vestibulum ornare rutrum nunc, dictum rhoncus sem dapibus vitae. Etiam sed diam neque, lacinia fermentum lectus. In erat urna, posuere vitae placerat mollis, rhoncus eget quam.\r\n</p>\r\n', 'Announcement', 'Dummy');

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

INSERT INTO `tab` (`id`, `title`, `content`) VALUES
(1, 'Sample Tab', '<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec nisl arcu, eget mattis lectus. Donec mattis, erat vitae pharetra elementum, erat elit pellentesque sapien, eu vestibulum tellus nibh eu eros. Fusce non eros at leo malesuada mollis vitae vitae tellus. Ut eget felis libero, nec dictum elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec leo turpis, lacinia et egestas ut, sagittis sed leo. Vestibulum ornare rutrum nunc, dictum rhoncus sem dapibus vitae. Etiam sed diam neque, lacinia fermentum lectus. In erat urna, posuere vitae placerat mollis, rhoncus eget quam.\r\n</p>');



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

INSERT INTO `options` (`id`, `blog_title`, `tag_line`, `limits`, `storage_server`) VALUES
(1, 'My Blog', 'an oocms powered weblog', 3, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

CREATE TABLE IF NOT EXISTS `widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_type` varchar(50) NOT NULL,
  `content` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

INSERT INTO `widget` (`id`, `widget_type`, `content`) VALUES
(2, 'text', '<p>Around here, however, we dont look backwards for very long. We keep moving forward, opening up new doors and doing new things, because were curious and curiosity keeps leading us down new paths. Were always exploring and experimenting. <br><b>&mdash; Walt Disney</b></p>'),
(1, 'image', 'framework/source/sample.png:separator:this is the alt text'),
(3, 'folder', ''),
(4, 'archive', ''),
(5, 'blogroll', '');

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

INSERT INTO `users` (`id`, `usernameblog`, `passwordblog`, `fullnameblog`, `gmtblog`, `emailblog`, `websiteblog`, `typeblog`) VALUES
(1, 'admin', '74dfc2b27acfa364da55f93a5caee29ccad3557247eda238831b3e9bd931b01d77fe994e4f12b9d4cfa92a124461d2065197d8cf7f33fc88566da2db2a4d6eae', 'Administrator', 'Asia/Jakarta', 'dummy@dummy.com', 'http://dummy.com', 'admin');
