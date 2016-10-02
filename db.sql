-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-07-02 04:21:25
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tzlshop_2`
--
CREATE DATABASE IF NOT EXISTS `tzlshop_2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tzlshop_2`;

-- --------------------------------------------------------

--
-- 表的结构 `tzl_admin`
--
-- 创建时间： 2016-06-29 05:26:38
--

DROP TABLE IF EXISTS `tzl_admin`;
CREATE TABLE IF NOT EXISTS `tzl_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(18) NOT NULL COMMENT '账号',
  `password` char(32) NOT NULL COMMENT '密码',
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=2 ;

--
-- 插入之前先把表清空（truncate） `tzl_admin`
--

TRUNCATE TABLE `tzl_admin`;
--
-- 转存表中的数据 `tzl_admin`
--

INSERT INTO `tzl_admin` (`id`, `account`, `password`, `name`) VALUES
(1, 'root', 'c9f8a442c7d834e34d2b21541f00a316', '我是超级管理员嘛');

-- --------------------------------------------------------

--
-- 表的结构 `tzl_admin_role`
--
-- 创建时间： 2016-06-29 04:42:30
--

DROP TABLE IF EXISTS `tzl_admin_role`;
CREATE TABLE IF NOT EXISTS `tzl_admin_role` (
  `admin_id` mediumint(8) unsigned NOT NULL COMMENT '管理员ID',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色ID',
  PRIMARY KEY (`admin_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 插入之前先把表清空（truncate） `tzl_admin_role`
--

TRUNCATE TABLE `tzl_admin_role`;
--
-- 转存表中的数据 `tzl_admin_role`
--

INSERT INTO `tzl_admin_role` (`admin_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_attribute`
--
-- 创建时间： 2016-06-29 04:42:38
--

DROP TABLE IF EXISTS `tzl_attribute`;
CREATE TABLE IF NOT EXISTS `tzl_attribute` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `attr_type` enum('唯一','可选') NOT NULL COMMENT '属性类型',
  `attr_values` varchar(200) NOT NULL COMMENT '属性可选值',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '类型id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='类型表' AUTO_INCREMENT=8 ;

--
-- 插入之前先把表清空（truncate） `tzl_attribute`
--

TRUNCATE TABLE `tzl_attribute`;
--
-- 转存表中的数据 `tzl_attribute`
--

INSERT INTO `tzl_attribute` (`id`, `attr_name`, `attr_type`, `attr_values`, `type_id`) VALUES
(1, '罡气大灯', '唯一', '我有罡气大灯', 1),
(2, '颜色', '可选', '赤，橙，黄，绿，青，蓝，紫', 1),
(3, '挡风玻璃', '可选', '软绵绵玻璃，铁牛玻璃', 1),
(4, '轮胎', '可选', '钢铁轮胎，塑胶轮胎', 1),
(5, '英国火车头', '唯一', '耐用 实惠', 3),
(6, '颜色', '可选', '次，橙，黄，绿，青', 3),
(7, '头', '可选', '铁，钢', 3);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_brand`
--
-- 创建时间： 2016-06-29 04:42:39
--

DROP TABLE IF EXISTS `tzl_brand`;
CREATE TABLE IF NOT EXISTS `tzl_brand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `brand_name` varchar(30) NOT NULL COMMENT '品牌名称',
  `logo` varchar(125) NOT NULL COMMENT 'logo路径',
  `site` varchar(30) NOT NULL COMMENT '官方网址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='品牌表' AUTO_INCREMENT=2 ;

--
-- 插入之前先把表清空（truncate） `tzl_brand`
--

TRUNCATE TABLE `tzl_brand`;
--
-- 转存表中的数据 `tzl_brand`
--

INSERT INTO `tzl_brand` (`id`, `brand_name`, `logo`, `site`) VALUES
(1, 'Nike', 'Brand/2016-06-29/57735a55c3ea0.jpg', 'www.nike.com');

-- --------------------------------------------------------

--
-- 表的结构 `tzl_cart`
--
-- 创建时间： 2016-06-29 06:04:39
--

DROP TABLE IF EXISTS `tzl_cart`;
CREATE TABLE IF NOT EXISTS `tzl_cart` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_number` mediumint(9) NOT NULL COMMENT '购买的数量',
  `member_id` mediumint(9) NOT NULL COMMENT '会员id',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '属性商品id',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='购物车' AUTO_INCREMENT=6 ;

--
-- 插入之前先把表清空（truncate） `tzl_cart`
--

TRUNCATE TABLE `tzl_cart`;
--
-- 转存表中的数据 `tzl_cart`
--

INSERT INTO `tzl_cart` (`id`, `goods_id`, `goods_number`, `member_id`, `goods_attr_id`) VALUES
(4, 2, 1, 1, '11,15'),
(5, 1, 1, 1, '2,6,7');

-- --------------------------------------------------------

--
-- 表的结构 `tzl_category`
--
-- 创建时间： 2016-06-29 04:47:42
--

DROP TABLE IF EXISTS `tzl_category`;
CREATE TABLE IF NOT EXISTS `tzl_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` char(30) NOT NULL COMMENT '分类名称',
  `parent_id` mediumint(8) unsigned DEFAULT '0' COMMENT '上级分类 0  0就代表顶级分类',
  `is_show` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否楼层',
  `sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `sort_num` (`sort_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=17 ;

--
-- 插入之前先把表清空（truncate） `tzl_category`
--

TRUNCATE TABLE `tzl_category`;
--
-- 转存表中的数据 `tzl_category`
--

INSERT INTO `tzl_category` (`id`, `cat_name`, `parent_id`, `is_show`, `sort_num`) VALUES
(1, '手机', 0, 'y', 100),
(2, '冰箱', 0, 'y', 100),
(3, '电脑', 0, 'y', 100),
(4, '安卓手机', 1, 'n', 100),
(5, '苹果手机', 1, 'y', 100),
(6, '塞班手机', 1, 'y', 100),
(7, '国产安卓', 4, 'y', 100),
(8, '国外安卓', 4, 'y', 100),
(9, '国产苹果', 5, 'y', 100),
(10, '国外苹果', 5, 'y', 100),
(11, '国产塞班', 6, 'y', 100),
(12, '国外塞班', 6, 'y', 100),
(13, '海尔冰箱', 2, 'y', 100),
(14, '美的冰箱', 2, 'y', 100),
(15, '联想电脑', 3, 'y', 100),
(16, '宏碁电脑', 3, 'y', 100);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_goods`
--
-- 创建时间： 2016-06-29 05:05:10
--

DROP TABLE IF EXISTS `tzl_goods`;
CREATE TABLE IF NOT EXISTS `tzl_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '原logo',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '小logo',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '中logo',
  `big_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '大logo',
  `is_on_sale` enum('y','n') NOT NULL DEFAULT 'y' COMMENT '是否上架',
  `addtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '类型的ID',
  `cat_id` mediumint(8) unsigned NOT NULL COMMENT '分类ID',
  `promote_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '促销开始时间',
  `promote_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '促销结束时间',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `is_hot` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否热卖',
  `is_rec` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否推荐',
  `is_new` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否新品',
  `is_folor` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否楼层',
  `goods_brand` mediumint(8) unsigned NOT NULL COMMENT '商品品牌',
  PRIMARY KEY (`id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `is_on_sale` (`is_on_sale`),
  KEY `cat_id` (`cat_id`),
  KEY `promote_start` (`promote_start`),
  KEY `promote_end` (`promote_end`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 插入之前先把表清空（truncate） `tzl_goods`
--

TRUNCATE TABLE `tzl_goods`;
--
-- 转存表中的数据 `tzl_goods`
--

INSERT INTO `tzl_goods` (`id`, `goods_name`, `market_price`, `shop_price`, `goods_desc`, `logo`, `sm_logo`, `mid_logo`, `big_logo`, `is_on_sale`, `addtime`, `type_id`, `cat_id`, `promote_start`, `promote_end`, `promote_price`, `is_hot`, `is_rec`, `is_new`, `is_folor`, `goods_brand`) VALUES
(1, '国外一般的塞班', '3000.00', '2000.00', '<p><br /></p><p>[此处键入文章标题]</p><p><img src="http://img.baidu.com/hi/youa/y_0034.gif" width="300" height="200" alt="y_0034.gif" />图文混排方法</p><p>1. 图片居左，文字围绕图片排版</p><p>方法：在文字前面插入图片，设置居左对齐，然后即可在右边输入多行文本</p><p><br /></p><p>2. 图片居右，文字围绕图片排版</p><p>方法：在文字前面插入图片，设置居右对齐，然后即可在左边输入多行文本</p><p><br /></p><p>3. 图片居中环绕排版</p><p>方法：亲，这个真心没有办法。。。</p><p><br /></p><p><br /></p><p><img src="http://img.baidu.com/hi/youa/y_0040.gif" width="300" height="300" alt="y_0040.gif" /></p><p>还有没有什么其他的环绕方式呢？这里是居右环绕</p><p><br /></p><p>欢迎大家多多尝试，为UEditor提供更多高质量模板！</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p><br /></p><p><br /></p><p><br /></p>', 'Goods/2016-06-29/57735b5bd9656.jpg', 'Goods/2016-06-29/sm_57735b5bd9656.jpg', 'Goods/2016-06-29/mid_57735b5bd9656.jpg', 'Goods/2016-06-29/big_57735b5bd9656.jpg', 'y', '2016-06-29 13:23:40', 1, 11, '2016-06-29 13:23:07', '2016-07-29 13:23:12', '250.00', 'y', 'y', 'y', 'y', 1),
(2, '我是电脑下的电脑呢', '5000.00', '4500.00', '<p><br /></p><p>[此处键入文章标题]</p><p><img src="http://img.baidu.com/hi/youa/y_0034.gif" width="300" height="200" alt="y_0034.gif" />图文混排方法</p><p>1. 图片居左，文字围绕图片排版</p><p>方法：在文字前面插入图片，设置居左对齐，然后即可在右边输入多行文本</p><p><br /></p><p>2. 图片居右，文字围绕图片排版</p><p>方法：在文字前面插入图片，设置居右对齐，然后即可在左边输入多行文本</p><p><br /></p><p>3. 图片居中环绕排版</p><p>方法：亲，这个真心没有办法。。。</p><p><br /></p><p><br /></p><p><img src="http://img.baidu.com/hi/youa/y_0040.gif" width="300" height="300" alt="y_0040.gif" /></p><p>还有没有什么其他的环绕方式呢？这里是居右环绕</p><p><br /></p><p>欢迎大家多多尝试，为UEditor提供更多高质量模板！</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p>占位</p><p><br /></p><p><br /></p><p><br /></p>', 'Goods/2016-06-29/57736107ca83d.jpg', 'Goods/2016-06-29/sm_57736107ca83d.jpg', 'Goods/2016-06-29/mid_57736107ca83d.jpg', 'Goods/2016-06-29/big_57736107ca83d.jpg', 'y', '2016-06-29 13:47:51', 3, 9, '2016-06-29 16:48:57', '2016-09-22 13:47:37', '3200.00', 'y', 'y', 'y', 'n', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_goods_attr`
--
-- 创建时间： 2016-06-29 04:42:39
--

DROP TABLE IF EXISTS `tzl_goods_attr`;
CREATE TABLE IF NOT EXISTS `tzl_goods_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `attr_value` varchar(150) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '属性ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品属性表' AUTO_INCREMENT=17 ;

--
-- 插入之前先把表清空（truncate） `tzl_goods_attr`
--

TRUNCATE TABLE `tzl_goods_attr`;
--
-- 转存表中的数据 `tzl_goods_attr`
--

INSERT INTO `tzl_goods_attr` (`id`, `attr_value`, `attr_id`, `goods_id`) VALUES
(1, '我有罡气大灯', 1, 1),
(2, '紫', 2, 1),
(3, '蓝', 2, 1),
(4, '橙', 2, 1),
(5, '黄', 2, 1),
(6, '铁牛玻璃', 3, 1),
(7, '塑胶轮胎', 4, 1),
(8, '软绵绵玻璃', 3, 1),
(9, '钢铁轮胎', 4, 1),
(10, '耐用 实惠', 5, 2),
(11, '次', 6, 2),
(12, '黄', 6, 2),
(13, '绿', 6, 2),
(14, '橙', 6, 2),
(15, '铁', 7, 2),
(16, '钢', 7, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_goods_number`
--
-- 创建时间： 2016-06-29 04:42:40
--

DROP TABLE IF EXISTS `tzl_goods_number`;
CREATE TABLE IF NOT EXISTS `tzl_goods_number` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '库存量',
  `attr_list` varchar(150) NOT NULL DEFAULT '' COMMENT '属性组合列表',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品库存量表';

--
-- 插入之前先把表清空（truncate） `tzl_goods_number`
--

TRUNCATE TABLE `tzl_goods_number`;
--
-- 转存表中的数据 `tzl_goods_number`
--

INSERT INTO `tzl_goods_number` (`goods_id`, `goods_number`, `attr_list`) VALUES
(1, 12, '2,6,7'),
(1, 14, '2,6,9'),
(1, 14, '2,8,7'),
(1, 14, '2,8,9'),
(1, 12, '3,6,7'),
(1, 14, '3,6,9'),
(1, 14, '3,8,7'),
(1, 14, '3,8,9'),
(1, 14, '4,6,7'),
(1, 14, '4,6,9'),
(1, 14, '4,8,7'),
(1, 14, '4,8,9'),
(1, 14, '5,6,7'),
(1, 14, '5,6,9'),
(1, 14, '5,8,7'),
(1, 14, '5,8,9'),
(2, 17, '11,15'),
(2, 18, '11,16'),
(2, 18, '12,15'),
(2, 9, '12,16'),
(2, 28, '13,15'),
(2, 28, '13,16'),
(2, 18, '14,15'),
(2, 18, '14,16');

-- --------------------------------------------------------

--
-- 表的结构 `tzl_goods_pic`
--
-- 创建时间： 2016-06-29 04:42:32
--

DROP TABLE IF EXISTS `tzl_goods_pic`;
CREATE TABLE IF NOT EXISTS `tzl_goods_pic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `photo` varchar(150) NOT NULL DEFAULT '' COMMENT '原logo',
  `sm_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '小logo',
  `mid_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '中logo',
  `big_photo` varchar(150) NOT NULL DEFAULT '' COMMENT '大logo',
  `goods_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 插入之前先把表清空（truncate） `tzl_goods_pic`
--

TRUNCATE TABLE `tzl_goods_pic`;
--
-- 转存表中的数据 `tzl_goods_pic`
--

INSERT INTO `tzl_goods_pic` (`id`, `photo`, `sm_photo`, `mid_photo`, `big_photo`, `goods_id`) VALUES
(1, 'Goods_pic/2016-06-29/57735d6072bf1.jpg', 'Goods_pic/2016-06-29/sm_57735d6072bf1.jpg', 'Goods_pic/2016-06-29/mid_57735d6072bf1.jpg', 'Goods_pic/2016-06-29/big_57735d6072bf1.jpg', 1),
(2, 'Goods_pic/2016-06-29/57735d6073b91.jpg', 'Goods_pic/2016-06-29/sm_57735d6073b91.jpg', 'Goods_pic/2016-06-29/mid_57735d6073b91.jpg', 'Goods_pic/2016-06-29/big_57735d6073b91.jpg', 1),
(3, 'Goods_pic/2016-06-29/57735d6074b32.jpg', 'Goods_pic/2016-06-29/sm_57735d6074b32.jpg', 'Goods_pic/2016-06-29/mid_57735d6074b32.jpg', 'Goods_pic/2016-06-29/big_57735d6074b32.jpg', 1),
(4, 'Goods_pic/2016-06-29/57735d6075ad2.jpg', 'Goods_pic/2016-06-29/sm_57735d6075ad2.jpg', 'Goods_pic/2016-06-29/mid_57735d6075ad2.jpg', 'Goods_pic/2016-06-29/big_57735d6075ad2.jpg', 1),
(5, 'Goods_pic/2016-06-29/57735d6076a72.jpg', 'Goods_pic/2016-06-29/sm_57735d6076a72.jpg', 'Goods_pic/2016-06-29/mid_57735d6076a72.jpg', 'Goods_pic/2016-06-29/big_57735d6076a72.jpg', 1),
(6, 'Goods_pic/2016-06-29/57735d6077a12.jpg', 'Goods_pic/2016-06-29/sm_57735d6077a12.jpg', 'Goods_pic/2016-06-29/mid_57735d6077a12.jpg', 'Goods_pic/2016-06-29/big_57735d6077a12.jpg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_member`
--
-- 创建时间： 2016-06-29 04:42:41
--

DROP TABLE IF EXISTS `tzl_member`;
CREATE TABLE IF NOT EXISTS `tzl_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `account` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `regtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `jyz` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员表' AUTO_INCREMENT=3 ;

--
-- 插入之前先把表清空（truncate） `tzl_member`
--

TRUNCATE TABLE `tzl_member`;
--
-- 转存表中的数据 `tzl_member`
--

INSERT INTO `tzl_member` (`id`, `account`, `password`, `regtime`, `jyz`) VALUES
(1, 'q542684913', '675ea12ab315defbec16d53ccb69f68c', '2016-06-29 13:28:38', 0),
(2, 'w542684913', '675ea12ab315defbec16d53ccb69f68c', '2016-06-29 13:29:22', 2800);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_member_level`
--
-- 创建时间： 2016-06-29 04:42:32
--

DROP TABLE IF EXISTS `tzl_member_level`;
CREATE TABLE IF NOT EXISTS `tzl_member_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `m_name` char(35) NOT NULL COMMENT '会员名称',
  `jf_sx` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  `jf_xx` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 插入之前先把表清空（truncate） `tzl_member_level`
--

TRUNCATE TABLE `tzl_member_level`;
--
-- 转存表中的数据 `tzl_member_level`
--

INSERT INTO `tzl_member_level` (`id`, `goods_id`, `m_name`, `jf_sx`, `jf_xx`) VALUES
(1, 0, '英勇黄铜', 2000, 0),
(2, 0, '不屈白银', 3000, 2001);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_member_price`
--
-- 创建时间： 2016-06-29 04:42:35
--

DROP TABLE IF EXISTS `tzl_member_price`;
CREATE TABLE IF NOT EXISTS `tzl_member_price` (
  `price` decimal(10,2) NOT NULL COMMENT '会员价格',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '会员级别',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  PRIMARY KEY (`goods_id`,`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 插入之前先把表清空（truncate） `tzl_member_price`
--

TRUNCATE TABLE `tzl_member_price`;
--
-- 转存表中的数据 `tzl_member_price`
--

INSERT INTO `tzl_member_price` (`price`, `level_id`, `goods_id`) VALUES
('180.00', 1, 1),
('160.00', 2, 1),
('2800.00', 1, 2),
('2500.00', 2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_orderinfo`
--
-- 创建时间： 2016-06-30 14:03:55
--

DROP TABLE IF EXISTS `tzl_orderinfo`;
CREATE TABLE IF NOT EXISTS `tzl_orderinfo` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `shrname` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人',
  `province` char(3) NOT NULL DEFAULT '' COMMENT '省',
  `city` char(3) NOT NULL DEFAULT '' COMMENT '市',
  `area` char(3) NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(130) NOT NULL DEFAULT '' COMMENT '详细地址',
  `tel` char(11) NOT NULL DEFAULT '' COMMENT '电话',
  `post_method` varchar(30) NOT NULL COMMENT '快递',
  `pay` varchar(30) NOT NULL COMMENT '支付方式',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `addtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '下单时间',
  `is_paid` enum('y','n') NOT NULL DEFAULT 'n' COMMENT '是否支付',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `post_status` enum('s','r','n') NOT NULL DEFAULT 'n' COMMENT '是否收货 s:已发货;n:未收到r:已收到',
  `total_price` decimal(10,2) NOT NULL COMMENT '订单总价格',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `addtime` (`addtime`),
  KEY `is_paid` (`is_paid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单信息表' AUTO_INCREMENT=6 ;

--
-- 插入之前先把表清空（truncate） `tzl_orderinfo`
--

TRUNCATE TABLE `tzl_orderinfo`;
--
-- 转存表中的数据 `tzl_orderinfo`
--

INSERT INTO `tzl_orderinfo` (`id`, `shrname`, `province`, `city`, `area`, `address`, `tel`, `post_method`, `pay`, `member_id`, `addtime`, `is_paid`, `pay_time`, `post_status`, `total_price`) VALUES
(1, '王尼玛', '内蒙古', '乌海市', '海勃湾', '详细地址', '13346578923', '顺丰', '微信', 1, '2016-06-30 23:07:32', 'n', 0, 'n', '3380.00'),
(2, '王雅俊', '黑龙江', '大庆市', '大同区', '详细地址', '13346578923', '顺丰', '微信', 1, '2016-06-30 23:11:46', 'n', 0, 'n', '540.00'),
(3, '王尼玛', '江苏省', '宿迁市', '沭阳县', '出现大bug', '13346578923', '顺丰', '微信', 1, '2016-06-30 23:22:02', 'n', 0, 'n', '3200.00'),
(4, '王尼玛', '黑龙江', '七台河', '茄子河', '详细地址', '13346578923', '顺丰', '微信', 1, '2016-06-30 23:24:04', 'n', 0, 'n', '180.00'),
(5, '2016-7-2星期六', '湖北省', '荆州市', '洪湖市', '我是湖北荆州洪湖的', '18519866429', '圆通', '支付宝', 1, '2016-07-02 09:44:09', 'n', 0, 'n', '3740.00');

-- --------------------------------------------------------

--
-- 表的结构 `tzl_order_goods`
--
-- 创建时间： 2016-06-30 12:58:47
--

DROP TABLE IF EXISTS `tzl_order_goods`;
CREATE TABLE IF NOT EXISTS `tzl_order_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_id` mediumint(8) unsigned NOT NULL COMMENT '订单id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性ID',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '购买的数量',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `member_id` (`member_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单商品表' AUTO_INCREMENT=9 ;

--
-- 插入之前先把表清空（truncate） `tzl_order_goods`
--

TRUNCATE TABLE `tzl_order_goods`;
--
-- 转存表中的数据 `tzl_order_goods`
--

INSERT INTO `tzl_order_goods` (`id`, `order_id`, `goods_id`, `member_id`, `goods_attr_id`, `price`, `goods_number`) VALUES
(1, 1, 1, 1, '3,6,7', '180.00', 1),
(2, 1, 2, 1, '11,15', '3200.00', 1),
(3, 2, 1, 1, '2,6,7', '180.00', 3),
(4, 3, 2, 1, '11,15', '3200.00', 1),
(5, 4, 1, 1, '2,6,7', '180.00', 1),
(6, 5, 1, 1, '3,6,7', '180.00', 2),
(7, 5, 1, 1, '2,6,7', '180.00', 1),
(8, 5, 2, 1, '11,15', '3200.00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_privilege`
--
-- 创建时间： 2016-06-29 04:42:28
--

DROP TABLE IF EXISTS `tzl_privilege`;
CREATE TABLE IF NOT EXISTS `tzl_privilege` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pri_name` char(30) NOT NULL COMMENT '分类名称',
  `m_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的所在模块',
  `c_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应所在控制器',
  `a_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应所在控制器的方法',
  `parent_id` mediumint(8) unsigned DEFAULT '0' COMMENT '上级权限的ID',
  `sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序数字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限表' AUTO_INCREMENT=49 ;

--
-- 插入之前先把表清空（truncate） `tzl_privilege`
--

TRUNCATE TABLE `tzl_privilege`;
--
-- 转存表中的数据 `tzl_privilege`
--

INSERT INTO `tzl_privilege` (`id`, `pri_name`, `m_name`, `c_name`, `a_name`, `parent_id`, `sort_num`) VALUES
(1, '商品模块', '', '', '', 0, 100),
(2, '分类列表', 'Admin', 'Category', 'lst', 1, 100),
(3, '添加分类', 'Admin', 'Category', 'add', 2, 100),
(4, '修改分类', 'Admin', 'Category', 'edit', 2, 100),
(5, '删除分类', 'Admin', 'Category', 'delete', 2, 100),
(6, '后台首页', 'Admin', 'Index', 'index', 0, 120),
(7, '后台左', 'Admin', 'Index', 'menu', 6, 100),
(8, '后台上', 'Admin', 'Index', 'top', 6, 100),
(9, '后面右', 'Admin', 'Index', 'main', 6, 100),
(10, '商品列表', 'Admin', 'Goods', 'lst', 1, 100),
(11, '添加商品', 'Admin', 'Goods', 'add', 10, 100),
(12, '修改商品', 'Admin', 'Goods', 'edit', 10, 100),
(13, '删除商品', 'Admin', 'Goods', 'delete', 10, 100),
(14, 'RBAC', '', '', '', 0, 130),
(15, '权限列表', 'Admin', 'Privilege', 'lst', 14, 100),
(16, '添加权限', 'Admin', 'Privilege', 'add', 15, 100),
(17, '修改权限', 'Admin', 'Privilege', 'edit', 15, 100),
(18, '删除权限', 'Admin', 'Privilege', 'delete', 15, 100),
(19, '角色列表', 'Admin', 'Role', 'lst', 14, 100),
(20, '添加角色', 'Admin', 'Role', 'add', 19, 100),
(21, '修改角色', 'Admin', 'Role', 'edit', 19, 100),
(22, '删除角色', 'Admin', 'Role', 'delete', 19, 100),
(23, '管理员列表', 'Admin', 'Admin', 'lst', 14, 100),
(24, '添加管理员', 'Admin', 'Admin', 'add', 23, 100),
(25, '修改管理员', 'Admin', 'Admin', 'edit', 23, 100),
(26, '删除管理员', 'Admin', 'Admin', 'delete', 23, 100),
(27, '商品相册', 'Admin', 'Goods', 'goods_pic', 10, 100),
(28, 'ajax删除图片', 'Admin', 'Goods', 'ajaxDelImg', 27, 100),
(29, '会员模块', '', '', '', 0, 112),
(30, '会员级别列表', 'Admin', 'MemberLevel', 'lst', 29, 100),
(31, '添加级别', 'Admin', 'MemberLevel', 'add', 30, 100),
(32, '修改级别', 'Admin', 'MemberLevel', 'edit', 30, 100),
(33, '删除级别', 'Admin', 'MemberLevel', 'delete', 30, 100),
(34, '类型列表', 'Admin', 'Type', 'lst', 1, 100),
(35, '添加类型', 'Admin', 'Type', 'add', 34, 100),
(36, '修改类型', 'Admin', 'Type', 'edit', 34, 100),
(37, '删除类型', 'Admin', 'Type', 'delete', 34, 100),
(38, '属性列表', 'Admin', 'Attribute', 'lst', 34, 100),
(39, '添加属性', 'Admin', 'Attribute', 'add', 38, 100),
(40, '修改属性', 'Admin', 'Attribute', 'edit', 38, 100),
(41, '删除属性', 'Admin', 'Attribute', 'delete', 38, 100),
(42, '商品属性', 'Admin', 'Goods', 'goods_attr', 10, 100),
(43, 'ajax获取属性', 'Admin', 'Goods', 'ajaxGetAttr', 42, 100),
(44, '商品品牌', '', '', '', 0, 111),
(45, '品牌列表', 'Admin', 'Brand', 'lst', 44, 100),
(46, '添加品牌', 'Admin', 'Brand', 'add', 45, 100),
(47, '修改品牌', 'Admin', 'Brand', 'edit', 45, 100),
(48, '删除品牌', 'Admin', 'Brand', 'delete', 45, 100);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_role`
--
-- 创建时间： 2016-06-29 04:42:29
--

DROP TABLE IF EXISTS `tzl_role`;
CREATE TABLE IF NOT EXISTS `tzl_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` char(30) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=2 ;

--
-- 插入之前先把表清空（truncate） `tzl_role`
--

TRUNCATE TABLE `tzl_role`;
--
-- 转存表中的数据 `tzl_role`
--

INSERT INTO `tzl_role` (`id`, `role_name`) VALUES
(1, '楼梯走道清扫员');

-- --------------------------------------------------------

--
-- 表的结构 `tzl_role_pri`
--
-- 创建时间： 2016-06-29 04:42:29
--

DROP TABLE IF EXISTS `tzl_role_pri`;
CREATE TABLE IF NOT EXISTS `tzl_role_pri` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色ID',
  `pri_id` mediumint(8) unsigned NOT NULL COMMENT '权限ID',
  PRIMARY KEY (`role_id`,`pri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色所拥有的权限表';

--
-- 插入之前先把表清空（truncate） `tzl_role_pri`
--

TRUNCATE TABLE `tzl_role_pri`;
--
-- 转存表中的数据 `tzl_role_pri`
--

INSERT INTO `tzl_role_pri` (`role_id`, `pri_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43);

-- --------------------------------------------------------

--
-- 表的结构 `tzl_type`
--
-- 创建时间： 2016-06-29 04:42:38
--

DROP TABLE IF EXISTS `tzl_type`;
CREATE TABLE IF NOT EXISTS `tzl_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='类型表' AUTO_INCREMENT=4 ;

--
-- 插入之前先把表清空（truncate） `tzl_type`
--

TRUNCATE TABLE `tzl_type`;
--
-- 转存表中的数据 `tzl_type`
--

INSERT INTO `tzl_type` (`id`, `type_name`) VALUES
(1, '汽车'),
(2, '书本'),
(3, '火车头');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE  tzl_remark(
id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
member_id MEDIUMINT UNSIGNED NOT NULL COMMENT'会员ID',
goods_id MEDIUMINT UNSIGNED NOT NULL COMMENT'商品id',
zan_num MEDIUMINT UNSIGNED  NOT NULL DEFAULT '0' COMMENT'赞的次数',
start TINYINT UNSIGNED NOT NULL COMMENT'打分1-5',
addtime DATETIME NOT NULL  DEFAULT CURRENT_TIMESTAMP COMMENT'添加时间',
content VARCHAR(220) NOT NULL COMMENT'评论内容',
PRIMARY KEY(id),
KEY addtime(addtime),
KEY goods_id(goods_id),
KEY member_id(member_id)
)ENGINE=InnoDB COMMENT'评论表';

CREATE TABLE  tzl_remark_pic(
id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
remark_id MEDIUMINT UNSIGNED NOT NULL COMMENT'评论的id',
pic VARCHAR(120) NOT NULL COMMENT'原图',
sm_pic VARCHAR(120) NOT NULL COMMENT'小图',
PRIMARY KEY(id)
)ENGINE=InnoDB COMMENT'评论的图片';

CREATE TABLE tzl_zan_history(
remark_id MEDIUMINT UNSIGNED NOT NULL COMMENT'评论的id',
member_id MEDIUMINT UNSIGNED NOT NULL COMMENT'会员的id',
PRIMARY KEY(remark_id,member_id)
)ENGINE=InnoDB COMMENT'赞的记录';

CREATE TABLE tzl_reply(
id  MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
member_id MEDIUMINT UNSIGNED NOT NULL COMMENT'回复的ID',
addtime DATETIME NOT NULL  DEFAULT CURRENT_TIMESTAMP COMMENT'回复时间',
content VARCHAR(200) NOT NULL COMMENT'回复的内容',
remark_id MEDIUMINT UNSIGNED NOT NULL COMMENT'回复哪一条评论',
reply_id MEDIUMINT UNSIGNED NOT NULL COMMENT'回复回复的评论id',
PRIMARY KEY(id),
KEY remark_id(remark_id)
)ENGINE=InnoDB COMMENT'回复表';

CREATE TABLE tzl_impression(
id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT'映像id',
goods_id MEDIUMINT UNSIGNED NOT NULL COMMENT'商品ID',
imp_name VARCHAR(30) NOT NULL COMMENT'印象名称',
imp_count MEDIUMINT UNSIGNED NOT NULL DEFAULT '1' COMMENT'这个印象出现的次数',
PRIMARY KEY(id)
)ENGINE=InnoDB COMMENT'映像表';















