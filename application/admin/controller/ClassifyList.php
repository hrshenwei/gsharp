<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;

class ClassifyList extends AuthorizedController
{
	public function index(){
		return $this->fetch();
	}
}