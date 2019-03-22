/*
Navicat MySQL Data Transfer

Source Server         : 77777
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : shoe

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-22 17:01:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for material
-- ----------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `partnerID` int(11) DEFAULT NULL COMMENT '供应商ID',
  `name` varchar(55) NOT NULL COMMENT '材料名称',
  `type` varchar(55) NOT NULL COMMENT '材料类型',
  `count` int(11) DEFAULT NULL COMMENT '库存',
  `newCount` int(11) DEFAULT NULL COMMENT '入库存',
  `outCount` int(11) DEFAULT NULL COMMENT '出库存',
  `amount` float DEFAULT NULL COMMENT '单价',
  `orderID` int(11) DEFAULT NULL COMMENT '订单ID',
  `inputUserID` varchar(55) DEFAULT NULL COMMENT '录入人ID',
  `inputTime` varchar(25) NOT NULL COMMENT '录入时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='材料库存列表';

-- ----------------------------
-- Records of material
-- ----------------------------
INSERT INTO `material` VALUES ('1', null, '', '', null, null, null, null, null, null, '');
INSERT INTO `material` VALUES ('2', '1', '大黄', '', null, null, null, null, null, null, '2019-03-22 16:19:45');

-- ----------------------------
-- Table structure for material_record
-- ----------------------------
DROP TABLE IF EXISTS `material_record`;
CREATE TABLE `material_record` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `materialID` int(11) NOT NULL COMMENT '材料ID',
  `type` int(255) DEFAULT NULL COMMENT '1:入库,2:出库',
  `taskID` int(11) DEFAULT NULL COMMENT '任务ID',
  `count` int(11) DEFAULT NULL COMMENT '数量',
  `amount` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `optUserID` varchar(55) NOT NULL,
  `inputUserID` varchar(55) NOT NULL,
  `inputTime` varchar(55) NOT NULL COMMENT '录入时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of material_record
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` varchar(255) NOT NULL COMMENT '用户编号',
  `userName` varchar(55) NOT NULL COMMENT '用户姓名',
  `telephone` varchar(55) NOT NULL COMMENT '手机号',
  `userPsw` varchar(55) NOT NULL COMMENT '密码',
  `encryptSalt` varchar(55) NOT NULL COMMENT '用于密码加密的随机盐',
  `portrait` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `role` varchar(255) DEFAULT NULL COMMENT '角色',
  `position` varchar(255) DEFAULT NULL COMMENT '职位',
  `status` int(11) NOT NULL COMMENT '1：在职2：离职3：删除',
  `inputUserID` varchar(255) NOT NULL COMMENT '创建人ID',
  `inputTime` varchar(255) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='员工列表';

-- ----------------------------
-- Records of user
-- ----------------------------
