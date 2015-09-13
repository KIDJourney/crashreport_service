-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2015 年 09 月 13 日 14:39
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_crashreport`
--
CREATE DATABASE `app_crashreport` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `app_crashreport`;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_report_id` int(11) NOT NULL,
  `comment_reporter_id` int(11) NOT NULL,
  `comment_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_login` varchar(60) NOT NULL,
  `manager_passwd` varchar(32) NOT NULL,
  `manager_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `manager_login` (`manager_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `repairer`
--

CREATE TABLE IF NOT EXISTS `repairer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repairer_login` varchar(60) NOT NULL,
  `repairer_passwd` varchar(60) NOT NULL,
  `repairer_name` varchar(8) NOT NULL,
  `repairer_tel` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_pos` int(11) NOT NULL,
  `report_info` varchar(128) DEFAULT NULL,
  `report_type` int(11) NOT NULL,
  `report_picurl` varchar(128) DEFAULT NULL,
  `report_status` tinyint(4) NOT NULL DEFAULT '0',
  `report_fixerid` int(11) DEFAULT '0',
  `report_reporter` int(11) NOT NULL,
  `report_comment` tinyint(1) NOT NULL DEFAULT '0',
  `report_createat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `report_acceptat` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `report_endat` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `report_type`
--

CREATE TABLE IF NOT EXISTS `report_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL,
  `user_passwd` varchar(32) NOT NULL,
  `user_nickname` varchar(60) NOT NULL,
  `user_tel` varchar(12) NOT NULL,
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_login` (`user_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;
