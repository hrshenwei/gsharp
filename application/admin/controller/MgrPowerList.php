<?php
namespace app\admin\controller;

use app\admin\common\AuthorizedController;
use app\admin\common\JQueryDataTableParamModel;
use app\admin\model\MgrPower;
use app\admin\model\MgrController;
use app\admin\model\MgrAction;
/**
 * File Name: MgrPowerList.php
 * Author Name: ShenWei
 * Date: 2016 下午6:15:05
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class MgrPowerList extends AuthorizedController{
	
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
		
		$mgrControllerList = MgrController::field('controllerId,controllerName')->select();
		$this->assign('controllerIdList', $mgrControllerList);
		
		$mgrActionList = MgrAction::field('actionId,actionName')->select();
		$this->assign('actionIdList', $mgrActionList);
				
		return $this->fetch();
	}
	
	/**
	 * 分页显示查询
	 */
	public function pageIndex(){
		$dTablesParam = new JQueryDataTableParamModel($_GET);
			
		$powerName = $_REQUEST["sSearch_0"];
		$metaStatus = $_REQUEST["sSearch_1"];
			
		$where = '';
		if(!empty($powerName)){
			$where['powerName'] = ['like', "%$powerName%"];
		}
		if(!empty($metaStatus)){
			$where['metaStatus'] = $metaStatus;
		}
	
		$mgrPowerList = MgrPower::where($where)->limit($dTablesParam->iDisplayStart, $dTablesParam->iDisplayLength)->order('serialNumber', 'desc')->select();
		$dbCount = MgrPower::where($where)->count();
		
		foreach ($mgrPowerList as $mgrPower){
			$mgrPower->controllerName = $mgrPower->mgrController->controllerName;
			$mgrPower->actionName = $mgrPower->mgrAction->actionName;
		}
		
		$jsonResult = $dTablesParam->getDatatablesJsonData(intval( $dbCount ),intval( $dbCount ), $mgrPowerList);
	
		return $jsonResult;
	}
	
	/**
	 * Create
	 */
	public function Create(){
		if(IS_POST){
			$result['bSuccess'] = false;
			try {
				$powerName = input('post.powerName');
				$where['powerName'] = $powerName;
				$mgrMenuCount = MgrPower::where($where)->count();
				if($mgrMenuCount === 0){
					$mgrMenu = new MgrPower($_POST);
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
				$powerId = input('post.powerId');
				$powerName = input('post.powerName');
				$where['powerId'] = array('neq', $powerId);
				$where['powerName'] = $powerName;
				$mgrMenuCount = MgrPower::where($where)->count();
				if($mgrMenuCount === 0){
					$postMgrPowerData = $_POST;
					$postMgrPowerData['lastTime'] = date('Y-m-d H:i:s');
					MgrPower::update($postMgrPowerData);
						
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
			$powerId = input('get.powerId');
			if(isset($powerId)){
				$data = MgrPower::find($powerId);
				return $data;
			}
		}
	}
	
	/**
	 * 编辑
	 */
	public function editMgrPower(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $powerId) = explode('_', $id);
		$reVal = $oldValue;
		if($columnName === 'powerName'){
			$where['powerName'] = $value;
			$where['powerId'] = ['neq', $powerId];
				
			$mgrMenuCount = MgrPower::where($where)->count();
			if($mgrMenuCount === 0){
				$mgrMenu = new MgrPower();
				$mgrMenu->save([$columnName => $value],['powerId' => $powerId]);
				$reVal = $value;
			}
		}
		else{
			$mgrMenu = new MgrPower();
			$mgrMenu->save([$columnName => $value],['powerId' => $powerId]);
			$reVal = $value;
		}
		return $reVal;
	}
	
	public function editSelectMgrPower(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $mgrActionId) = explode('_', $id);
		$mgrAction = new MgrPower();
		$mgrAction->save([$columnName => $value],['powerId' => $mgrActionId]);
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
		$powerId = input('get.powerId');
		$powerName = input('get.powerName');
		$where['powerName'] = $powerName;
		if(isset($powerId) && !empty($powerId)){
			$where['powerId'] = array('neq', $powerId);
		}
		$mgrMenuCount = MgrPower::where($where)->count();
		if($mgrMenuCount === 0){
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	
	public function delete(){
		$powerId = input('post.powerId');
		$result['bSuccess'] = false;
		if(isset($powerId)){
			MgrPower::destroy($powerId);
	
			$result['bSuccess'] = true;
			$result['message'] = '删除成功';
		}
		return $result;
	}
}