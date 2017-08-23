CREATE TABLE IF NOT EXISTS `wx_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区',
  `pid` int(255)  COMMENT '父级',
  `name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '名称',
  `type` tinyint(1)  COMMENT '类型',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：地区表';

CREATE TABLE IF NOT EXISTS `wx_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签',
  `name` VARCHAR(255)  COMMENT '名称',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：地区表';

CREATE TABLE `wx_user_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签',
  `uid` int(11)  COMMENT 'uid',
  `tag_id` int(11)  COMMENT '标签ID',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：用户标签表';

CREATE TABLE `wx_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签',
  `open_id` VARCHAR(255) NOT NULL  COMMENT 'openid',
  `nick` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '标签ID',
  `province` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '省份',
  `city` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '城市',
  `sex` char(255) NOT NULL DEFAULT '' COMMENT '性别',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：用户表';

CREATE TABLE `wx_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户',
  `title` VARCHAR(255) NOT NULL  COMMENT '标题',
  `introduce` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '简介',
  `ptime` int(11)  COMMENT '发布时间',
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '内容',
  `tags` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '标签',
  `url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '原文链接',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：用户表';

CREATE TABLE `wx_nets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '网址',
  `title` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '标题',
  `url` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '链接',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：链接表';

CREATE TABLE `wx_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单',
  `name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '名称',
  `group` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '分组',
  `pid` VARCHAR(255) NOT NULL DEFAULT '0' COMMENT '父级',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：微信自定义菜单表';

CREATE TABLE `wx_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息模板',
  `title` VARCHAR(255) NOT NULL  COMMENT '标题',
  `content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '模板内容',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：消息模板';

CREATE TABLE `wx_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题词',
  `title` VARCHAR(255) NOT NULL  COMMENT '标题',
  `addtime` int(11)  COMMENT '添加时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='：主题词';