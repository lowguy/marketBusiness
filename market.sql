CREATE TABLE `balance_apply` (
  `user_id` int(11) NOT NULL COMMENT '�û�ID',
  `card_id` int(11) NOT NULL COMMENT '��ƬID',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '״̬ 0����� 1��ͨ�� -1�Ѿܾ�',
  `type` int(4) NOT NULL COMMENT '���� 1���� 2�ֽ�',
  `amount` decimal(10,2) NOT NULL COMMENT '���',
  `comment` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '��ע',
  `created_at` int(11) NOT NULL COMMENT '����ʱ��',
  `confirmed_at` int(11) DEFAULT NULL COMMENT '��׼ʱ��',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=ndbcluster AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�����¼��' 

CREATE TABLE `card` (
  `user_id` int(11) NOT NULL COMMENT '�û�ID',
  `card_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '��ƬID',
  `name` char(32) COLLATE utf8_bin NOT NULL COMMENT '�û�����',
  `account` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '���˻���',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '�˻����� 1֧���� 2���п�',
  `bank` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '��ѡ��1',
  PRIMARY KEY (`card_id`),
  UNIQUE KEY `account_key` (`account`)
) ENGINE=ndbcluster AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�̼Ұ󶨵Ŀ���'     
CREATE TABLE `category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `category_name` char(32) COLLATE utf8_bin NOT NULL COMMENT '��������',
  `mark` int(4) DEFAULT '0' COMMENT '�˷����µĲ�Ʒ�Ƿ���Ҫ��ע 0����Ҫ 1��Ҫ',
  PRIMARY KEY (`category_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='������Ϣ' 
CREATE TABLE `category_category` (
  `start` int(11) unsigned NOT NULL COMMENT '������ID',
  `end` int(11) unsigned NOT NULL COMMENT '�ӷ���ID',
  `distance` int(11) unsigned NOT NULL COMMENT '��ϵ����',
  KEY `start_key` (`start`),
  KEY `end_key` (`end`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='����-�����ϵ��' 
CREATE TABLE `code` (
  `phone` char(20) COLLATE utf8_bin DEFAULT NULL,
  `created_at` int(11) DEFAULT '0',
  `senario` char(128) COLLATE utf8_bin NOT NULL COMMENT 'Ӧ�ó���',
  `code` int(4) NOT NULL COMMENT '��֤��',
  KEY `phone_key` (`phone`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='��֤���¼��'   
CREATE TABLE `market` (
  `market_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '�г�ID',
  `city` char(16) COLLATE utf8_bin NOT NULL COMMENT '����',
  `district` char(16) COLLATE utf8_bin NOT NULL COMMENT '����',
  `free_area` polygon NOT NULL COMMENT '���������',
  `boundary` polygon NOT NULL,
  PRIMARY KEY (`market_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='��Ȧ��Ϣ'  
CREATE TABLE `market_product` (
  `market_id` int(11) NOT NULL COMMENT '�г�ID',
  `product_id` int(11) NOT NULL COMMENT '��ƷID',
  `user_id` int(11) DEFAULT NULL COMMENT '�̼�ID',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '����',
  `stock` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '���',
  `sales` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `start` int(11) DEFAULT '0',
  `end` int(11) DEFAULT '0',
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT '0',
  `close_time` int(11) DEFAULT NULL COMMENT '�ر�ʱ��',
  `start_time` int(11) DEFAULT NULL COMMENT '����ʱ��',
  `open` int(4) DEFAULT '1' COMMENT '0�ر� 1����',
  `activity` int(4) DEFAULT '0',
  `discount` decimal(10,2) DEFAULT '0.00',
  `status` int(4) DEFAULT '1' COMMENT '�̻�״̬',
  `inprice` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '����'
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�г���Ʒ'    
CREATE TABLE `market_user` (
  `market_id` int(11) NOT NULL COMMENT '�г�ID',
  `user_id` int(11) NOT NULL COMMENT '�û�ID',
  `role_id` int(11) NOT NULL COMMENT '��ɫID',
  `status` tinyint(4) NOT NULL COMMENT '״̬,0Ϊδ���,1Ϊ���ͨ����2Ϊ��˾ܾ�',
  `open` int(4) DEFAULT '1' COMMENT '0�ر� 1����',
  `close_time` int(11) DEFAULT '86400' COMMENT '�رյ���ʱ��',
  `start_time` int(11) DEFAULT '0' COMMENT '����ÿ�쿪��ʱ��',
  `address` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '�̻���ַ',
  `geo_address` point DEFAULT NULL COMMENT '�̻���ַ����',
  KEY `market_key` (`market_id`),
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�г�-����Ա��ϵ��'
CREATE TABLE `market_category` (
  `market_id` int(11) unsigned NOT NULL COMMENT '�г�ID',
  `category_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Ȩ��',
  `status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '״̬',
  KEY `market_key` (`market_id`),
  KEY `category_key` (`category_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�г�-�����ϵ��'  
CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `order_no` varchar(16) COLLATE utf8_bin NOT NULL COMMENT '������',
  `market_id` int(11) unsigned NOT NULL COMMENT '�г� ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '���ID',
  `amount` decimal(10,2) unsigned NOT NULL COMMENT '�ܽ��',
  `status` tinyint(4) unsigned NOT NULL COMMENT '����״̬',
  `created_at` int(11) unsigned NOT NULL COMMENT '����ʱ��',
  `paid_at` int(11) DEFAULT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `phone` char(16) COLLATE utf8_bin DEFAULT NULL,
  `address` char(80) COLLATE utf8_bin DEFAULT NULL,
  `geo_address` point DEFAULT NULL,
  `trade_no` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT '������ˮ��',
  `payment` int(4) DEFAULT NULL COMMENT '1֧���� 2΢��',
  `total_fee` decimal(10,2) DEFAULT NULL COMMENT 'ʵ��֧��',
  `balance_status` int(2) DEFAULT '0' COMMENT '���ֶ���',
  `deliver` decimal(10,2) DEFAULT NULL COMMENT '���ͷ�',
  `evaluate_deliver` int(4) DEFAULT '0' COMMENT '��������',
  `c_year` int(4) DEFAULT NULL COMMENT '��',
  `c_month` int(4) DEFAULT NULL COMMENT '��',
  `c_day` int(4) DEFAULT NULL COMMENT '��',
  `inamount` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '����',
  `goods_less` int(4) DEFAULT '1' COMMENT 'ȱ�� 0 �л�1',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `key_market` (`market_id`),
  KEY `user_key` (`user_id`),
  KEY `balance_status` (`balance_status`),
  KEY `month_key` (`c_month`),
  KEY `day_key` (`c_day`),
  KEY `year_key` (`c_year`)
) ENGINE=ndbcluster AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='������Ϣ��'
CREATE TABLE `order_delivery` (
  `order_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '����ԱID',
  `created_at` int(11) unsigned NOT NULL COMMENT '����ʱ��',
  `status` int(4) DEFAULT '0',
  `confirmed_at` int(11) unsigned DEFAULT NULL COMMENT 'ȷ�Ͻӵ�ʱ��',
  PRIMARY KEY (`order_id`),
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='����-����Ա��ϵ��'
CREATE TABLE `order_merchant` (
  `shop_id` int(11) NOT NULL COMMENT '�̻�ID',
  `order_id` int(11) NOT NULL COMMENT '����ID',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '״̬ 0 δ���� 1�Ѵ���',
  UNIQUE KEY `shop_id` (`shop_id`,`order_id`,`status`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�̻�������'  
CREATE TABLE `order_product` (
  `order_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `product_id` int(11) unsigned NOT NULL COMMENT '��ƷID',
  `user_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `title` char(128) COLLATE utf8_bin NOT NULL COMMENT '��Ʒ����',
  `amount` decimal(10,2) NOT NULL,
  `number` int(11) NOT NULL COMMENT '����',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '�̻��Ƿ���',
  `comment` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '����',
  `pick_at` int(11) DEFAULT NULL COMMENT 'ȡ��ʱ��',
  `inprice` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '����',
  `price` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '����',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '�ۿۼ�',
  `inamount` decimal(10,2) NOT NULL DEFAULT '0.01' COMMENT '�ܽ���',
  KEY `order_key` (`order_id`),
  KEY `product_key` (`product_id`),
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='����-��Ʒ��ϵ��' 
CREATE TABLE `product` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '��ƷID',
  `category_id` int(11) unsigned NOT NULL COMMENT '����ID',
  `title` char(128) COLLATE utf8_bin NOT NULL COMMENT 'Ʒ��',
  `slogan` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '�����',
  PRIMARY KEY (`product_id`),
  KEY `category_key` (`category_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=2667 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='��Ʒ��Ϣ'
CREATE TABLE `reflect_record` (
  `card_id` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '��ƬID',
  `created_at` int(10) NOT NULL COMMENT '����ʱ��',
  `status` int(4) NOT NULL COMMENT '״̬ 1����� 2������',
  `amount` decimal(10,2) NOT NULL COMMENT '������',
  `mark` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '��ע��Ϣ'
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�̼Ұ󶨵Ŀ���'      
CREATE TABLE `role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` char(32) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=ndbcluster AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�û���ɫ'   
CREATE TABLE `score_log` (
  `user_id` int(11) unsigned NOT NULL COMMENT '�û�ID',
  `event` int(11) unsigned NOT NULL COMMENT '�¼�',
  `amount` int(11) NOT NULL COMMENT '����������Ϊ����/����Ϊ����',
  KEY `user_key` (`user_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='������־��'  
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '�û�ID',
  `phone` char(16) COLLATE utf8_bin NOT NULL COMMENT '�ֻ���',
  `password` char(32) COLLATE utf8_bin NOT NULL COMMENT '����',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '״̬��0Ϊ����/1Ϊ����',
  `created_at` int(11) unsigned NOT NULL COMMENT '����ʱ��',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '���',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '����',
  `device` char(64) COLLATE utf8_bin DEFAULT NULL COMMENT '�豸ID',
  `platform` int(4) DEFAULT NULL,
  `frozen_score` int(11) DEFAULT '0' COMMENT '�������',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `phone_key` (`phone`)
) ENGINE=ndbcluster AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�û�����ң��˻���Ϣ'  
CREATE TABLE `user_operator` (
  `user_id` int(11) NOT NULL COMMENT '�û�ID',
  `shop_id` int(11) NOT NULL COMMENT '�̻�ID'
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='����Ա��'       
CREATE TABLE `user_role` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  KEY `user_key` (`user_id`),
  KEY `role_key` (`role_id`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='��Ӫ-��ɫ��ϵ��Ϣ'    
CREATE TABLE `user_user` (
  `start` int(11) unsigned NOT NULL,
  `end` int(11) unsigned NOT NULL,
  `distance` int(11) unsigned NOT NULL,
  UNIQUE KEY `r_unique` (`start`,`end`,`distance`),
  KEY `parent` (`start`),
  KEY `child` (`end`)
) ENGINE=ndbcluster DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='�û���ϵ��' 
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_product_category` AS select `product`.`product_id` AS `product_id`,`product`.`category_id` AS `category_id`,`product`.`title` AS `title`,`product`.`slogan` AS `slogan`,`market_product`.`price` AS `price`,`market_product`.`stock` AS `stock`,`market_product`.`start` AS `m_p_start`,`market_product`.`end` AS `m_p_end`,`market_product`.`activity` AS `activity`,`market_product`.`discount` AS `discount`,`market_product`.`market_id` AS `market`,`market_product`.`inprice` AS `inprice`,`category_category`.`start` AS `start`,`category_category`.`end` AS `end`,`category_category`.`distance` AS `distance`,`category`.`category_name` AS `category_name` from (((`product` left join `category_category` on(((`category_category`.`end` = `product`.`category_id`) and (`category_category`.`start` <> `product`.`category_id`)))) left join `category` on((`category`.`category_id` = `product`.`category_id`))) left join `market_product` on((`market_product`.`product_id` = `product`.`product_id`))) 

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_role` AS select `user`.`user_id` AS `user_id`,`user`.`phone` AS `phone`,`user`.`password` AS `password`,`user`.`status` AS `status`,`user`.`created_at` AS `created_at`,`user`.`money` AS `money`,`user`.`score` AS `score`,`user`.`device` AS `device`,`role`.`role_id` AS `role_id`,`role`.`role_name` AS `role_name` from ((`user` left join `user_role` on((`user`.`user_id` = `user_role`.`user_id`))) left join `role` on((`user_role`.`role_id` = `role`.`role_id`))) 

