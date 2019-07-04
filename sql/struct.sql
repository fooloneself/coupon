/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.53 : Database - coupon
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `coupon` */

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券id',
  `mch_id` int(11) DEFAULT NULL COMMENT '商户id',
  `user_id` int(11) DEFAULT NULL COMMENT '发布券的账户id',
  `total_num` int(11) DEFAULT NULL COMMENT '发放总量',
  `race_num` int(11) DEFAULT '0' COMMENT '已抢占数量',
  `uper_limit_per_person` int(11) DEFAULT '1' COMMENT '每人可领取的数量上限',
  `type` tinyint(1) DEFAULT NULL COMMENT '优惠券类型：1代金券 2折扣券 3兑换券 4团购券 5特价券',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态:1待审核 2拒绝 3待投放 4已投放 5已下架',
  `end_date` date DEFAULT NULL COMMENT '券可用截止日期',
  `title` varchar(100) DEFAULT NULL COMMENT '卡券名称',
  `sub_title` varchar(100) DEFAULT NULL COMMENT '卡券副标题',
  `shop_price` decimal(10,2) DEFAULT '0.00' COMMENT '店面价格',
  `discount` varchar(100) DEFAULT NULL COMMENT '优惠',
  `minimum_consumption` decimal(10,2) DEFAULT NULL COMMENT '最低消费',
  `usable_slot` text COMMENT '可用时段',
  `notice` text COMMENT '使用须知',
  `suitable_product` text COMMENT '适合产品',
  `unsuitable_product` text COMMENT '不适合产品',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券表';

/*Table structure for table `coupon_item` */

CREATE TABLE `coupon_item` (
  `code` varchar(100) NOT NULL COMMENT '券码',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：1未使用 2已核销',
  `coupon_id` int(11) DEFAULT NULL COMMENT '券id',
  `own_user_id` int(11) DEFAULT NULL COMMENT '拥有用户id',
  `own_time` int(11) DEFAULT NULL COMMENT '抢占时间',
  `write_off_user_id` int(11) DEFAULT NULL COMMENT '核销人用户id',
  `write_off_time` int(11) DEFAULT NULL COMMENT '核销时间',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='实例券表';

/*Table structure for table `merchant` */

CREATE TABLE `merchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商户id',
  `user_id` int(11) DEFAULT NULL COMMENT '创建人用户ID',
  `serial_number` varchar(100) NOT NULL COMMENT '商户编号',
  `logo` varchar(100) DEFAULT NULL COMMENT '商户logo',
  `name` varchar(100) DEFAULT NULL COMMENT '商户名称',
  `contact_info` varchar(50) DEFAULT NULL COMMENT '联系方式',
  `contact_person` varchar(100) DEFAULT NULL COMMENT '联系人',
  `longitude` decimal(10,6) DEFAULT NULL COMMENT '经度',
  `latitude` decimal(10,6) DEFAULT NULL COMMENT '纬度',
  `register_date` date DEFAULT NULL COMMENT '注册日期',
  `not_limit_end_date` date DEFAULT NULL COMMENT '不限次截止日期',
  `register_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `coupon_currency` int(11) DEFAULT '0' COMMENT '券币',
  `is_recommend` tinyint(1) DEFAULT '0' COMMENT '是否推荐：0否 1是',
  `address` text COMMENT '商户地址',
  `introduce` text COMMENT '商户介绍',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户信息表';

/*Table structure for table `merchant_coupon_currency_record` */

CREATE TABLE `merchant_coupon_currency_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `serial_number` varchar(100) DEFAULT NULL COMMENT '流水号',
  `mch_id` int(11) NOT NULL COMMENT '商户id',
  `type` tinyint(1) NOT NULL COMMENT '1进账 2出账',
  `amount` int(11) DEFAULT '0' COMMENT '金额：<0 出账 >0进账',
  `happen_time` int(11) DEFAULT NULL COMMENT '发生时间',
  `mark` text COMMENT '资金流向备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户券币流动记录表';

/*Table structure for table `merchant_product` */

CREATE TABLE `merchant_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品id',
  `user_id` int(11) DEFAULT NULL COMMENT '发布账号id',
  `mch_id` int(11) DEFAULT NULL COMMENT '商户id',
  `code` varchar(100) DEFAULT NULL COMMENT '产品编号',
  `name` varchar(100) DEFAULT NULL COMMENT '产品名称',
  `price` decimal(10,2) DEFAULT NULL COMMENT '产品单价',
  `cover_img` varchar(200) DEFAULT NULL COMMENT '产品封面图',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户产品表';

/*Table structure for table `user` */

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL COMMENT '微信openid',
  `session_key` varchar(100) DEFAULT NULL COMMENT '会话令牌',
  `session_token` varchar(100) DEFAULT NULL COMMENT '会话令牌',
  `mch_id` varchar(100) DEFAULT '0' COMMENT '商户id',
  `type` tinyint(1) DEFAULT '1' COMMENT '账号类型：1消费者账户 2商户账户',
  `token_expire_time` int(11) DEFAULT NULL COMMENT '会话令牌过期时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='账号信息表';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
