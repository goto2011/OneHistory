-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2015 年 01 月 18 日 15:29
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
-- 表的结构 `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `property_UUID` char(48) NOT NULL,
  `user_UUID` char(48) NOT NULL,
  `add_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `follow`
--

INSERT INTO `follow` (`property_UUID`, `user_UUID`, `add_time`) VALUES
('a1a00e5f-4b0d-ade3-20ca-54a93b26a3ad', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:26:47'),
('b4ada6d1-3b0f-58b4-c2df-54a40420524f', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:02'),
('3cd468a2-5370-7036-e36c-54a94b693918', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:08'),
('2b05268f-5ec6-de45-473b-54a94a48931c', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:13'),
('ec9bef8d-3f04-d5cd-2cde-54a93b78dddb', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:18'),
('67557b01-87bf-d450-95ae-54a94a9493e0', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:23'),
('9d2df8f7-dba0-671f-729b-54ad39f2fc08', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:33'),
('ffe5051f-c311-83a5-43cc-54a952d5c96e', '64789949-6480-311f-9478-54b0d78b2c72', '2015-01-18 22:28:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
