<?php
/**
 * File Name: AuthorizedController.php
 * Author Name: ShenWei
 * Date: 2016 上午10:45:39
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */

namespace app\admin\common;

use think\Controller;
class AuthorizedController extends Controller{
	protected $title = '';
	protected $description = '';
	protected $keywords = '';
		
	public function _initialize(){
		$this->assignDefault();
		
		//$this->checkLogin();
	}
	
	private function assignDefault(){
		$this->assign('title', $this->title);
		$this->assign('description', $this->description);
		$this->assign('keywords', $this->keywords);
		
		$arrayMenu= config('admin_menu');
		$this->assign('arrayMenu', $arrayMenu);
	}
}