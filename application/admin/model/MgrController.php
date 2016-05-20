<?php
namespace app\admin\model;

use app\admin\common\BaseModel;
/**
 * File Name: MgrController.php
 * Author Name: ShenWei
 * Date: 2016 下午4:38:25
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class MgrController extends BaseModel{
	protected $pk = 'controllerId';
	
	public function mgrPower(){
		return $this->hasMany('MgrPower', 'controllerId');
	}
}