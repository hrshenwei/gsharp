<?php
namespace app\admin\common;
use think\Model;
/**
 * File Name: BaseModel.php
 * Author Name: ShenWei
 * Date: 2016 上午10:13:51
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class BaseModel extends Model{
	// 是否需要自动写入时间戳
	protected $autoWriteTimestamp = false;
}