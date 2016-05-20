<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

return [
    'url_route_on' 				=>	true,
    'log'          				=>	[
        'type' 					=>	'file', // 支持 socket trace file
    ],
    'template'					=>	[
    		'layout_on'			=>	true,
    		'layout_name'		=>	'Layout/layout',
    ],
    'view_replace_str'					=>	[
    		'__PUBLIC__'		=>	'/public',
    		'__ROOT__'			=>	'/',
    ],
    // 关闭控制器名的自动转换
    'url_controller_convert'	=>  false,
    // 关闭操作名的自动转换
    'url_action_convert'        =>  false,
    'db_attr_case'				=>	\PDO::CASE_NATURAL,
];
