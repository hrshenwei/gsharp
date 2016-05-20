<?php
namespace app\admin\model;

use app\admin\common\BaseModel;
/**
 * File Name: MgrPower.php
 * Author Name: ShenWei
 * Date: 2016 上午10:55:00
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */

class MgrPower extends BaseModel{
	protected $pk = 'powerId';
		
	public function mgrController(){
		return $this->belongsTo('MgrController', 'controllerId');
	}
	
	public function mgrAction(){
		return $this->belongsTo('MgrAction', 'actionId');
	}
}