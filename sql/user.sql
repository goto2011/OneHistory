-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2015 年 02 月 05 日 13:18
-- 服务器版本: 5.6.22
-- PHP 版本: 5.5.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `one-history`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_UUID` char(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` char(48) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_right` tinyint(1) NOT NULL,
  `add_time` datetime NOT NULL,
  `score` int(4) NOT NULL,
  `self_introduction` varchar(200) DEFAULT NULL,
  `email` varchar(48) DEFAULT NULL,
  `weixin` varchar(48) DEFAULT NULL,
  `weibo` varchar(48) DEFAULT NULL,
  `qq` varchar(48) DEFAULT NULL,
  UNIQUE KEY `user_UUID` (`user_UUID`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_UUID`, `user_name`, `password`, `user_right`, `add_time`, `score`, `self_introduction`, `email`, `weixin`, `weibo`, `qq`) VALUES
('64789949-6480-311f-9478-54b0d78b2c72', 'Gandhi', 'e10adc3949ba59abbe56e057f20f883e', 1, '2015-01-10 15:39:15', 0, NULL, NULL, NULL, NULL, NULL),
('cd40c514-0261-dcdc-683c-54b3bfc7c5a3', 'qiuju', 'e10adc3949ba59abbe56e057f20f883e', 11, '2015-01-12 20:36:45', 0, NULL, NULL, NULL, NULL, NULL),
('d3c17c8c-691f-0044-19b1-54c4aa73bf69', 'duangan', 'c2a9cedc8729409da0c1d5117eab0027', 11, '2015-01-25 16:34:01', 0, NULL, '451877089@qq.com', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
