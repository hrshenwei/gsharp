<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;
use app\admin\common\JQueryDataTableParamModel;
use app\admin\model\MgrController;
/**
 * File Name: MgrControllerList.php
 * Author Name: ShenWei
 * Date: 2016 下午6:11:54
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class MgrControllerList extends AuthorizedController{
	
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
		
		$where['topControllerId'] = 0;
		$topControllerList = MgrController::where($where)->field('controllerId,controllerName')->select();
		$this->assign('topControllerList', $topControllerList);
		
		$topControllerListArr = [];
		foreach ($topControllerList as $topController){
			$topControllerListArr[$topController->controllerId] = $topController->controllerName;
		}
		$this->assign('topControllerJson', json_encode($topControllerListArr));
		
		return $this->fetch();
	}
	
	/**
	 * 分页显示查询
	 */
	public function pageIndex(){
		$dTablesParam = new JQueryDataTableParamModel($_GET);
			
		$controllerName = $_REQUEST["sSearch_0"];
		$topControllerId = $_REQUEST["sSearch_1"];
		$metaStatus = $_REQUEST["sSearch_2"];
			
		$where = '';
		if(!empty($controllerName)){
			$where['controllerName'] = ['like', "%$controllerName%"];
		}
		if($topControllerId != ''){
			$where['topControllerId'] = $topControllerId;
		}
		if(!empty($metaStatus)){
			$where['metaStatus'] = $metaStatus;
		}
	
		$menuList = MgrController::where($where)->limit($dTablesParam->iDisplayStart, $dTablesParam->iDisplayLength)->order('serialNumber', 'desc')->select();
		$dbCount = MgrController::where($where)->count();
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
				$controllerName = input('post.controllerName');
				$where['controllerName'] = $controllerName;
				$mgrMenuCount = MgrController::where($where)->count();
				if($mgrMenuCount === 0){
					$mgrMenu = new MgrController($_POST);
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
				$controllerId = input('post.controllerId');
				$controllerName = input('post.controllerName');
				$where['controllerId'] = array('neq', $controllerId);
				$where['controllerName'] = $controllerName;
				$mgrMenuCount = MgrController::where($where)->count();
				if($mgrMenuCount === 0){
					$postMgrControllerData = $_POST;
					$postMgrControllerData['lastTime'] = date('Y-m-d H:i:s');
					MgrController::update($postMgrControllerData);
						
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
			$controllerId = input('get.controllerId');
			if(isset($controllerId)){
				$data = MgrController::find($controllerId);
				return $data;
			}
		}
	}
	
	/**
	 * 编辑
	 */
	public function editMgrController(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $controllerId) = explode('_', $id);
		$reVal = $oldValue;
		if($columnName === 'controllerName'){
			$where['controllerName'] = $value;
			$where['controllerId'] = ['neq', $controllerId];
				
			$mgrMenuCount = MgrController::where($where)->count();
			if($mgrMenuCount === 0){
				$mgrMenu = new MgrController();
				$mgrMenu->save([$columnName => $value],['controllerId' => $controllerId]);
				$reVal = $value;
			}
		}
		else{
			$mgrMenu = new MgrController();
			$mgrMenu->save([$columnName => $value],['controllerId' => $controllerId]);
			$reVal = $value;
		}
		echo $reVal;
	}
	
	public function editSelectMgrController(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $mgrActionId) = explode('_', $id);
		$mgrAction = new MgrController();
		$mgrAction->save([$columnName => $value],['controllerId' => $mgrActionId]);
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
	public function checkControllerNameExist(){
		$controllerId = input('get.controllerId');
		$controllerName = input('get.controllerName');
		$where['controllerName'] = $controllerName;
		if(isset($controllerId) && !empty($controllerId)){
			$where['controllerId'] = array('neq', $controllerId);
		}
		$mgrMenuCount = MgrController::where($where)->count();
		if($mgrMenuCount === 0){
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	
	public function delete(){
		$controllerId = input('post.controllerId');
		$result['bSuccess'] = false;
		if(isset($controllerId)){
			MgrController::destroy($controllerId);
	
			$result['bSuccess'] = true;
			$result['message'] = '删除成功';
		}
		return $result;
	}
}