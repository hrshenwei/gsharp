<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;
use app\admin\common\JQueryDataTableParamModel;
use app\admin\model\MgrMenu;

class MgrMenuList extends AuthorizedController{
	
	public function index(){
		$metaStatusList = [
				['Id' => '1', 'Value' => '启用'],
				['Id' => '2', 'Value' => '停用']
		];
		$this->assign('metaStatusList', $metaStatusList);
		
		foreach ($metaStatusList as $metaStatus){
			$metaStatusArr[$metaStatus['Id']] = $metaStatus['Value'];
		}
		$this->assign('metaStatusJson', json_encode($metaStatusArr));
		
		$where['topMgrMenuId'] = 0;
		$topMgrMenuList = MgrMenu::where($where)->field('mgrMenuId,menuName')->select();
		$this->assign('topMgrMenuList', $topMgrMenuList);
		
		foreach ($topMgrMenuList as $topMgrMenu){
			$topMgrMenuListArr[$topMgrMenu->mgrMenuId] = $topMgrMenu->menuName;
		}
		$this->assign('topMgrMenuJson', json_encode($topMgrMenuListArr));
		
		return $this->fetch();
	}
	
	/**
	 * 分页显示查询
	 */
	public function pageIndex(){
		$dTablesParam = new JQueryDataTableParamModel($_GET);
			
		$menuName = $_REQUEST["sSearch_0"];
		$topMgrMenuId = $_REQUEST["sSearch_1"];
		$metaStatus = $_REQUEST["sSearch_2"];
			
		$where = '';
		if(!empty($menuName)){
			$where['menuName'] = ['like', "%$menuName%"];
		}
		if($topMgrMenuId != ''){
			$where['topMgrMenuId'] = $topMgrMenuId;
		}
		if(!empty($metaStatus)){
			$where['metaStatus'] = $metaStatus;
		}
		
		$menuList = MgrMenu::where($where)->limit($dTablesParam->iDisplayStart, $dTablesParam->iDisplayLength)->order('serialNumber', 'desc')->select();
		$dbCount = MgrMenu::where($where)->count();
		$jsonResult = $dTablesParam->getDatatablesJsonData(intval( $dbCount ),intval( $dbCount ), $menuList);
		
		return $jsonResult;
	}
	
	/**
	 * Create
	 */
	public function Create(){
		if(IS_POST){
			$result['bSuccess'] = false;
			try {
				$menuName = input('post.menuName');
				$where['menuName'] = $menuName;
				$mgrMenuCount = MgrMenu::where($where)->count();
				if($mgrMenuCount === 0){
					$mgrMenu = new MgrMenu($_POST);
					$mgrMenu->createTime = date('Y-m-d H:i:s');
					$mgrMenu->lastTime = date('Y-m-d H:i:s');
					
					$mgrMenu->save();
					$result['bSuccess'] = true;
					$result['message'] = '保存成功';
					if($mgrMenu->topMgrMenuId == 0){
						$where['topMgrMenuId'] = 0;
						$topMgrMenuList = MgrMenu::where($where)->column('menuName', 'mgrMenuId');
						$result['topMgrMenuArr'] = $topMgrMenuList;
					}
				}
				else{
					$result['bSuccess'] = false;
					$result['message'] = '该菜单名称已存在';
				}
			} catch (Exception $e) {
				$result['message'] = $e;
			}
			return json_encode($result);
		}
		else{
			$this->view->engine->layout(false);
			$this->fetch();
		}
	}
	
	public function Edit(){
		$this->view->engine->layout(false);
	
		$this->fetch();
	}
	
	public function EditData(){
		if(IS_POST){
			$result['bSuccess'] = false;
			try {
				$mgrMenuId = input('post.mgrMenuId');
				$menuName = input('post.menuName');
				$where['mgrMenuId'] = array('neq', $mgrMenuId);
				$where['menuName'] = $menuName;
				$mgrMenuCount = MgrMenu::where($where)->count();
				if($mgrMenuCount === 0){
					$postMgrMenuData = $_POST;
					$postMgrMenuData['lastTime'] = date('Y-m-d H:i:s');
					MgrMenu::update($postMgrMenuData);
					
					/*
					$mgrMenudata = MgrMenu::get($mgrMenuId);
					$mgrMenudata->topMgrMenuId = input('post.topMgrMenuId');
					$mgrMenudata->serialNumber = input('post.serialNumber');
					$mgrMenudata->menuName = input('post.menuName');
					$mgrMenudata->menuCaption = input('post.menuCaption');
					$mgrMenudata->metaStatus = input('post.metaStatus');
					$mgrMenudata->save();
					*/
					
					$result['bSuccess'] = true;
					$result['message'] = '保存成功';
				}
				else{
					$result['bSuccess'] = false;
					$result['message'] = '该菜单名称已存在';
				}
			} catch (Exception $e) {
				$result['message'] = $e;
			}
			return $result;
		}
		else{
			$mgrMenuId = input('get.mgrMenuId');
			if(isset($mgrMenuId)){
				$data = MgrMenu::find($mgrMenuId);
				return $data;
			}
		}
	}
	
	/**
	 * 编辑
	 */
	public function editMgrMenu(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $mgrMenuId) = explode('_', $id);
		$reVal = $oldValue;
		if($columnName === 'menuName'){
			$where['menuName'] = $value;
			$where['mgrMenuId'] = ['neq', $mgrMenuId];
			
			$mgrMenuCount = MgrMenu::where($where)->count();
			if($mgrMenuCount === 0){
				$mgrMenu = new MgrMenu();
				$mgrMenu->save([$columnName => $value],['mgrMenuId' => $mgrMenuId]);
				$reVal = $value;
			}
		}
		else{
			$mgrMenu = new MgrMenu();
			$mgrMenu->save([$columnName => $value],['mgrMenuId' => $mgrMenuId]);
			$reVal = $value;
		}
		return $reVal;
	}
	
	public function editSelectMgrMenu(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $mgrMenuId) = explode('_', $id);
		$mgrMenu = new MgrMenu();
		$mgrMenu->save([$columnName => $value],['mgrMenuId' => $mgrMenuId]);
		$metaStatusList = [
				'1' => '启用',
				'2' => '停用',
				'selected' => $value
		];
		return json_encode($metaStatusList);
	}
	
	/**
	 * 判断菜单名称是否存在
	 */
	public function checkMenuNameExist(){
		$mgrMenuId = input('get.mgrMenuId');
		$menuName = input('get.menuName');
		$where['menuName'] = $menuName;
		if(isset($mgrMenuId) && !empty($mgrMenuId)){
			$where['mgrMenuId'] = array('neq', $mgrMenuId);
		}
		$mgrMenuCount = MgrMenu::where($where)->count();
		if($mgrMenuCount === 0){
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	
	public function delete(){
		$mgrMenuId = input('post.mgrMenuId');
		$result['bSuccess'] = false;
		if(isset($mgrMenuId)){
			MgrMenu::destroy($mgrMenuId);
		
			$result['bSuccess'] = true;
			$result['message'] = '删除成功';
		}
		return json_encode($result);
	}
}