CREATE TABLE `balance_apply` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `card_id` int(11) NOT NULL COMMENT '卡片ID',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '状态 0审核中 1已通过 -1已拒绝',
  `type` int(4) NOT NULL COMMENT '类型 1积分 2现金',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `comment` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `created_at` int(11) NOT NULL COMMENT '申请时间',
  `confirmed_at` int(11) DEFAULT NULL COMMENT '批准时间',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=ndbcluster AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='申请记录表' 

CREATE TABLE `card` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `card_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '卡片ID',
  `name` char(32) COLLATE utf8_bin NOT NULL COMMENT '用户姓名',
  `account` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '绑定账户号',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '账户类型 1支付宝 2银行卡',
  `bank` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '首选项1',
  PRIMARY KEY (`card_id`),
  UNIQUE KEY `account_key` (`account`)
) ENGINE=ndbcluster AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商家绑定的卡号'     
CREATE TABLE `category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `category_name` char(32) COLLATE utf8_bin NOT NULL COMMENT '分类名称',
  `mark` int(4) DEFAULT '0' COMMENT '此分类下的产品是否需要备注 0不需要 1需要',
  PRIMARY KEY (`category_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='分类信息' 
CREATE TABLE `category_category` (
  `start` int(11) unsigned NOT NULL COMMENT '父分类ID',
  `end` int(11) unsigned NOT NULL COMMENT '子分类ID',
  `distance` int(11) unsigned NOT NULL COMMENT '关系距离',
  KEY `start_key` (`start`),
  KEY `end_key` (`end`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='分类-分类关系表' 
CREATE TABLE `code` (
  `phone` char(20) COLLATE utf8_bin DEFAULT NULL,
  `created_at` int(11) DEFAULT '0',
  `senario` char(128) COLLATE utf8_bin NOT NULL COMMENT '应用场景',
  `code` int(4) NOT NULL COMMENT '验证码',
  KEY `phone_key` (`phone`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='验证码记录表'   
CREATE TABLE `market` (
  `market_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '市场ID',
  `city` char(16) COLLATE utf8_bin NOT NULL COMMENT '城市',
  `district` char(16) COLLATE utf8_bin NOT NULL COMMENT '区县',
  `free_area` polygon NOT NULL COMMENT '免费配送区',
  `boundary` polygon NOT NULL,
  PRIMARY KEY (`market_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商圈信息'  
CREATE TABLE `market_product` (
  `market_id` int(11) NOT NULL COMMENT '市场ID',
  `product_id` int(11) NOT NULL COMMENT '产品ID',
  `user_id` int(11) DEFAULT NULL COMMENT '商家ID',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价',
  `stock` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `sales` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `start` int(11) DEFAULT '0',
  `end` int(11) DEFAULT '0',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `close_time` int(11) DEFAULT NULL COMMENT '关闭时间',
  `start_time` int(11) DEFAULT NULL COMMENT '开启时间',
  `open` int(4) DEFAULT '1' COMMENT '0关闭 1开启',
  `activity` int(4) DEFAULT '0',
  `discount` decimal(10,2) DEFAULT '0.00',
  `status` int(4) DEFAULT '1' COMMENT '商户状态',
  `inprice` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '进价'
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='市场产品'    
CREATE TABLE `market_user` (
  `market_id` int(11) NOT NULL COMMENT '市场ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `status` tinyint(4) NOT NULL COMMENT '状态,0为未审核,1为审核通过，2为审核拒绝',
  `open` int(4) DEFAULT '1' COMMENT '0关闭 1开启',
  `close_time` int(11) DEFAULT '86400' COMMENT '关闭店铺时间',
  `start_time` int(11) DEFAULT '0' COMMENT '店铺每天开启时间',
  `address` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '商户地址',
  `geo_address` point DEFAULT NULL COMMENT '商户地址坐标',
  KEY `market_key` (`market_id`),
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='市场-管理员关系表'
CREATE TABLE `market_category` (
  `market_id` int(11) unsigned NOT NULL COMMENT '市场ID',
  `category_id` int(11) unsigned NOT NULL COMMENT '分类ID',
  `weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  KEY `market_key` (`market_id`),
  KEY `category_key` (`category_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='市场-分类关系表'  
CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_no` varchar(16) COLLATE utf8_bin NOT NULL COMMENT '订单号',
  `market_id` int(11) unsigned NOT NULL COMMENT '市场 ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '买家ID',
  `amount` decimal(10,2) unsigned NOT NULL COMMENT '总金额',
  `status` tinyint(4) unsigned NOT NULL COMMENT '订单状态',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `paid_at` int(11) DEFAULT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `phone` char(16) COLLATE utf8_bin DEFAULT NULL,
  `address` char(80) COLLATE utf8_bin DEFAULT NULL,
  `geo_address` point DEFAULT NULL,
  `trade_no` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT '交易流水号',
  `payment` int(4) DEFAULT NULL COMMENT '1支付宝 2微信',
  `total_fee` decimal(10,2) DEFAULT NULL COMMENT '实际支付',
  `balance_status` int(2) DEFAULT '0' COMMENT '积分冻结',
  `deliver` decimal(10,2) DEFAULT NULL COMMENT '配送费',
  `evaluate_deliver` int(4) DEFAULT '0' COMMENT '评价配送',
  `c_year` int(4) DEFAULT NULL COMMENT '年',
  `c_month` int(4) DEFAULT NULL COMMENT '月',
  `c_day` int(4) DEFAULT NULL COMMENT '日',
  `inamount` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '进价',
  `goods_less` int(4) DEFAULT '1' COMMENT '缺货 0 有货1',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `key_market` (`market_id`),
  KEY `user_key` (`user_id`),
  KEY `balance_status` (`balance_status`),
  KEY `month_key` (`c_month`),
  KEY `day_key` (`c_day`),
  KEY `year_key` (`c_year`)
) ENGINE=ndbcluster AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='订单信息表'
CREATE TABLE `order_delivery` (
  `order_id` int(11) unsigned NOT NULL COMMENT '订单ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '配送员ID',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `status` int(4) DEFAULT '0',
  `confirmed_at` int(11) unsigned DEFAULT NULL COMMENT '确认接单时间',
  PRIMARY KEY (`order_id`),
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='订单-配送员关系表'
CREATE TABLE `order_merchant` (
  `shop_id` int(11) NOT NULL COMMENT '商户ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '状态 0 未处理 1已处理',
  UNIQUE KEY `shop_id` (`shop_id`,`order_id`,`status`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商户订单表单'  
CREATE TABLE `order_product` (
  `order_id` int(11) unsigned NOT NULL COMMENT '订单ID',
  `product_id` int(11) unsigned NOT NULL COMMENT '商品ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '卖家ID',
  `title` char(128) COLLATE utf8_bin NOT NULL COMMENT '商品名称',
  `amount` decimal(10,2) NOT NULL,
  `number` int(11) NOT NULL COMMENT '数量',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '商户是否处理',
  `comment` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '评论',
  `pick_at` int(11) DEFAULT NULL COMMENT '取货时间',
  `inprice` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '进价',
  `price` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '单价',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '折扣价',
  `inamount` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '总进价',
  KEY `order_key` (`order_id`),
  KEY `product_key` (`product_id`),
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='订单-商品关系表' 
CREATE TABLE `product` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `category_id` int(11) unsigned NOT NULL COMMENT '分类ID',
  `title` char(128) COLLATE utf8_bin NOT NULL COMMENT '品名',
  `slogan` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '广告语',
  PRIMARY KEY (`product_id`),
  KEY `category_key` (`category_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=2667 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商品信息'
CREATE TABLE `reflect_record` (
  `card_id` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '卡片ID',
  `created_at` int(10) NOT NULL COMMENT '申请时间',
  `status` int(4) NOT NULL COMMENT '状态 1审核中 2已审批',
  `amount` decimal(10,2) NOT NULL COMMENT '申请额度',
  `mark` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '备注信息'
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='商家绑定的卡号'      
CREATE TABLE `role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` char(32) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户角色'   
CREATE TABLE `score_log` (
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `event` int(11) unsigned NOT NULL COMMENT '事件',
  `amount` int(11) NOT NULL COMMENT '数量，正数为增加/负数为减少',
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='积分日志表'  
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `phone` char(16) COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `password` char(32) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态，0为禁用/1为启用',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `device` char(64) COLLATE utf8_bin DEFAULT NULL COMMENT '设备ID',
  `platform` int(4) DEFAULT NULL,
  `frozen_score` int(11) DEFAULT '0' COMMENT '冻结积分',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `phone_key` (`phone`)
) ENGINE=ndbcluster AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户（买家）账户信息'  
CREATE TABLE `user_operator` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `shop_id` int(11) NOT NULL COMMENT '商户ID'
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='操作员表'       
CREATE TABLE `user_role` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  KEY `user_key` (`user_id`),
  KEY `role_key` (`role_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='运营-角色关系信息'    
CREATE TABLE `user_user` (
  `start` int(11) unsigned NOT NULL,
  `end` int(11) unsigned NOT NULL,
  `distance` int(11) unsigned NOT NULL,
  UNIQUE KEY `r_unique` (`start`,`end`,`distance`),
  KEY `parent` (`start`),
  KEY `child` (`end`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户关系树' 
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_product_category` AS select `product`.`product_id` AS `product_id`,`product`.`category_id` AS `category_id`,`product`.`title` AS `title`,`product`.`slogan` AS `slogan`,`market_product`.`price` AS `price`,`market_product`.`stock` AS `stock`,`market_product`.`start` AS `m_p_start`,`market_product`.`end` AS `m_p_end`,`market_product`.`activity` AS `activity`,`market_product`.`discount` AS `discount`,`market_product`.`market_id` AS `market`,`market_product`.`inprice` AS `inprice`,`category_category`.`start` AS `start`,`category_category`.`end` AS `end`,`category_category`.`distance` AS `distance`,`category`.`category_name` AS `category_name` from (((`product` left join `category_category` on(((`category_category`.`end` = `product`.`category_id`) and (`category_category`.`start` <> `product`.`category_id`)))) left join `category` on((`category`.`category_id` = `product`.`category_id`))) left join `market_product` on((`market_product`.`product_id` = `product`.`product_id`))) 

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_role` AS select `user`.`user_id` AS `user_id`,`user`.`phone` AS `phone`,`user`.`password` AS `password`,`user`.`status` AS `status`,`user`.`created_at` AS `created_at`,`user`.`money` AS `money`,`user`.`score` AS `score`,`user`.`device` AS `device`,`role`.`role_id` AS `role_id`,`role`.`role_name` AS `role_name` from ((`user` left join `user_role` on((`user`.`user_id` = `user_role`.`user_id`))) left join `role` on((`user_role`.`role_id` = `role`.`role_id`))) 

