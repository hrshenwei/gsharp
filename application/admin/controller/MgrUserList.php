<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;

class MgrUserList extends AuthorizedController
{
	public function index(){
		return $this->fetch();
	}
}