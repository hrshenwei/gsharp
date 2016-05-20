<?php
//配置文件
return [
		'Admin_AUTH_KEY'	=>	'_Admin_AUTH_KEY',
		'admin_menu' => array(
				array('menuId' => '1', 'menuCaption' => '管理员', 'menuUrl' => '', 'menuIcon' => '', 'childMenu' => array(
						0	=>	array('menuId' => '2', 'menuCaption' => '管理员列表', 'menuUrl' => '/admin/AdminUserList', 'menuIcon' => ''),
				)),
				array('menuId' => '3', 'menuCaption' => '分类管理', 'menuUrl' => '', 'menuIcon' => '', 'childMenu' => array(
						0	=>	array('menuId' => '4', 'menuCaption' => '分类列表', 'menuUrl' => '/admin/ClassifyList', 'menuIcon' => ''),
				)),
				array('menuId' => '5', 'menuCaption' => 'App管理', 'menuUrl' => '', 'menuIcon' => '',
						'childMenu' => array(
								0 => array('menuId' => '6', 'menuCaption' => '广告主列表', 'menuUrl' => '/admin/AdvertiserList', 'menuIcon' => ''),
								1 => array('menuId' => '7', 'menuCaption' => '投放App列表', 'menuUrl' => '/admin/AppList', 'menuIcon' => ''),
								2 => array('menuId' => '8', 'menuCaption' => '充值明细', 'menuUrl' => '/admin/AppRechargeDetailsList', 'menuIcon' => ''),
						)),
				array('menuId' => '9', 'menuCaption' => '用户管理', 'menuUrl' => '', 'menuIcon' => '',
						'childMenu' => array(
								0 => array('menuId' => '10', 'menuCaption' => '用户列表', 'menuUrl' => '/admin/UserList', 'menuIcon' => ''),
								1 => array('menuId' => '11', 'menuCaption' => '用户试用App', 'menuUrl' => '/admin/UserHasAppList', 'menuIcon' => ''),
								//2 => array('menuId' => '12', 'menuCaption' => '用户App运行详情', 'menuUrl' => '/admin/UserRunAppList', 'menuIcon' => ''),
								2 => array('menuId' => '12', 'menuCaption' => '账单', 'menuUrl' => '/admin/UserBillHistoryList', 'menuIcon' => ''),
								3 => array('menuId' => '13', 'menuCaption' => 'Push信息', 'menuUrl' => '/admin/UserPushMsg', 'menuIcon' => ''),
								4 => array('menuId' => '14', 'menuCaption' => '提现审核', 'menuUrl' => '/admin/SpendAudit', 'menuIcon' => ''),
						)),
				array('menuId' => '15', 'menuCaption' => '统计管理', 'menuUrl' => '', 'menuIcon' => '', 'childMenu' => array(
						0	=>	array('menuId' => '16', 'menuCaption' => '统计列表', 'menuUrl' => '/admin/DailyStatList', 'menuIcon' => ''),
				)),
		),
];