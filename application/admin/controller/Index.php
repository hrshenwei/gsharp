<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;
use app\admin\model\Area;

class Index extends AuthorizedController
{
    public function index()
    {
    	return $this->fetch();
    }
    
    public function t(){
    	
    	$area = new Area;
    	dump($area);
    }
}
