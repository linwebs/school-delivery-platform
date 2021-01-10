<?php

define('APP_NAME', '貓貓餓了');

define('FOLDER_PATH', __DIR__ . '/../');

define('LANG', 'zh-Hant-TW');

define('ITEM_MAX_BUY', 6);

define('DELIVERY_FEE', 15);

define('TICKET_STATUS', array(0 => '訂單未成立', 1 => '新訂單', 2 => '餐點準備中', 3 => '等待送餐中', 4 => '餐點外送中', 5 => '餐點已送達',
	6 => '訂單已完成', 7 => '訂單已取消'));

define('TICKET_STATUS_ACTIVE', array(1, 2, 3, 4, 5));

define('USER_TYPE', array(1 => '使用者', 2 => '外送員', 3 => '店家'));