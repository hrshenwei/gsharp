<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;
use app\admin\common\JQueryDataTableParamModel;
use app\admin\model\MgrAction;
/**
 * File Name: MgrActionList.php
 * Author Name: ShenWei
 * Date: 2016 下午6:07:14
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class MgrActionList extends AuthorizedController{
	
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
		
		return $this->fetch();
	}
	
	/**
	 * 分页显示查询
	 */
	public function pageIndex(){
		$dTablesParam = new JQueryDataTableParamModel($_GET);
			
		$actionName = $_REQUEST["sSearch_0"];
		$metaStatus = $_REQUEST["sSearch_1"];
			
		$where = '';
		if(!empty($actionName)){
			$where['actionName'] = ['like', "%$actionName%"];
		}
		if(!empty($metaStatus)){
			$where['metaStatus'] = $metaStatus;
		}
	
		$menuList = MgrAction::where($where)->limit($dTablesParam->iDisplayStart, $dTablesParam->iDisplayLength)->order('lastTime', 'desc')->select();
		$dbCount = MgrAction::where($where)->count();
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
				$actionName = input('post.actionName');
				$where['actionName'] = $actionName;
				$mgrMenuCount = MgrAction::where($where)->count();
				if($mgrMenuCount === 0){
					$mgrMenu = new MgrAction($_POST);
					$mgrMenu->createTime = date('Y-m-d H:i:s');
					$mgrMenu->lastTime = date('Y-m-d H:i:s');
						
					$mgrMenu->save();
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
				$actionId = input('post.actionId');
				$actionName = input('post.actionName');
				$where['actionId'] = array('neq', $actionId);
				$where['actionName'] = $actionName;
				$mgrMenuCount = MgrAction::where($where)->count();
				if($mgrMenuCount === 0){
					$postMgrActionData = $_POST;
					$postMgrActionData['lastTime'] = date('Y-m-d H:i:s');
					MgrAction::update($postMgrActionData);
						
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
			$actionId = input('get.actionId');
			if(isset($actionId)){
				$data = MgrAction::find($actionId);
				return $data;
			}
		}
	}
	
	/**
	 * 编辑
	 */
	public function editMgrAction(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $actionId) = explode('_', $id);
		$reVal = $oldValue;
		if($columnName === 'actionName'){
			$where['actionName'] = $value;
			$where['actionId'] = ['neq', $actionId];
				
			$mgrMenuCount = MgrAction::where($where)->count();
			if($mgrMenuCount === 0){
				$mgrMenu = new MgrAction();
				$mgrMenu->save([$columnName => $value],['actionId' => $actionId]);
				$reVal = $value;
			}
		}
		else{
			$mgrMenu = new MgrAction();
			$mgrMenu->save([$columnName => $value],['actionId' => $actionId]);
			$reVal = $value;
		}
		echo $reVal;
	}
	
	public function editSelectMgrAction(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $mgrActionId) = explode('_', $id);
		$mgrAction = new MgrAction();
		$mgrAction->save([$columnName => $value],['actionId' => $mgrActionId]);
		$metaStatusList = [
				'1' => '启用',
				'2' => '停用',
				'selected' => $value
		];
		return $metaStatusList;
	}
	
	/**
	 * 判断菜单名称是否存在
	 */
	public function checkActionNameExist(){
		$actionId = input('get.actionId');
		$actionName = input('get.actionName');
		$where['actionName'] = $actionName;
		if(isset($actionId) && !empty($actionId)){
			$where['actionId'] = array('neq', $actionId);
		}
		$mgrMenuCount = MgrAction::where($where)->count();
		if($mgrMenuCount === 0){
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	
	public function delete(){
		$actionId = input('post.actionId');
		$result['bSuccess'] = false;
		if(isset($actionId)){
			MgrAction::destroy($actionId);
	
			$result['bSuccess'] = true;
			$result['message'] = '删除成功';
		}
		return $result;
	}
}