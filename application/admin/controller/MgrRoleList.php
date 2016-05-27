<?php
namespace app\admin\controller;
use app\admin\common\AuthorizedController;
use app\admin\model\MgrRole;
use app\admin\common\JQueryDataTableParamModel;
use app\admin\model\MgrPower;
use app\admin\model\MgrController;
use app\admin\model\app\admin\model;
/**
 * File Name: MgrRoleList.php
 * Author Name: ShenWei
 * Date: 2016 下午6:19:35
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class MgrRoleList extends AuthorizedController{
	
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
		
		//$powerList = MgrPower::where('metaStatus', 1)->order('controllerId, serialNumber')->select();
		//$this->assign('powerList', $powerList);
		
		$controllerList = MgrController::where('metaStatus', 1)->order('controllerId')->select();
		$this->assign('controllerList', $controllerList);
		
		return $this->fetch();
	}
	
	/**
	 * 分页显示查询
	 */
	public function pageIndex(){
		$dTablesParam = new JQueryDataTableParamModel($_GET);
			
		$roleName = $_REQUEST["sSearch_0"];
		$metaStatus = $_REQUEST["sSearch_1"];
			
		$where = '';
		if(!empty($roleName)){
			$where['roleName'] = ['like', "%$roleName%"];
		}
		if(!empty($metaStatus)){
			$where['metaStatus'] = $metaStatus;
		}
	
		$mgrPowerList = MgrRole::where($where)->limit($dTablesParam->iDisplayStart, $dTablesParam->iDisplayLength)->order('lastTime', 'desc')->select();
		$dbCount = MgrRole::where($where)->count();
		
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
				$roleName = input('post.roleName');
				$where['roleName'] = $roleName;
				$mgrRoleCount = MgrRole::where($where)->count();
				if($mgrRoleCount === 0){
					$mgrRole = new MgrRole($_POST);
					$mgrRole->createTime = date('Y-m-d H:i:s');
					$mgrRole->lastTime = date('Y-m-d H:i:s');
						
					$mgrRole->tranCreate();
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
			return $this->fetch();
		}
	}
	
	public function Edit(){
		$this->view->engine->layout(false);
				
		return $this->fetch();
	}
	
	public function EditData(){
		if(IS_POST){
			$result['bSuccess'] = false;
			try {
				$roleId = input('post.roleId');
				$roleName = input('post.roleName');
				$where['roleId'] = array('neq', $roleId);
				$where['roleName'] = $roleName;
				$mgrRoleCount = MgrRole::where($where)->count();
				if($mgrRoleCount === 0){
					$dbMgrRole = new MgrRole($_POST);
					$dbMgrRole->lastTime = date('Y-m-d H:i:s');
					$dbMgrRole->tranUpdate();
					//MgrRole::update($postMgrRoleData);
						
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
			$roleId = input('get.roleId');
			if(isset($roleId)){
				$data = MgrRole::with('mgrRolePower')->find($roleId);
				return $data;
			}
		}
	}
	
	/**
	 * 编辑
	 */
	public function editMgrRole(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $roleId) = explode('_', $id);
		$reVal = $oldValue;
		if($columnName === 'roleName'){
			$where['roleName'] = $value;
			$where['roleId'] = ['neq', $roleId];
				
			$mgrRoleCount = MgrRole::where($where)->count();
			if($mgrRoleCount === 0){
				$mgrRole = new MgrRole();
				$mgrRole->save([$columnName => $value],['roleId' => $roleId]);
				$reVal = $value;
			}
		}
		else{
			$mgrRole = new MgrRole();
			$mgrRole->save([$columnName => $value],['roleId' => $roleId]);
			$reVal = $value;
		}
		echo $reVal;
	}
	
	public function editSelectMgrRole(){
		$id = $_POST['id'];
		$value = $_POST['value'];
		list($columnName, $oldValue, $roleId) = explode('_', $id);
		$mgrAction = new MgrRole();
		$mgrAction->save([$columnName => $value],['roleId' => $roleId]);
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
	public function checkRoleNameExist(){
		$roleId = input('get.roleId');
		$roleName = input('get.roleName');
		$where['roleName'] = $roleName;
		if(isset($roleId) && !empty($roleId)){
			$where['roleId'] = array('neq', $roleId);
		}
		$mgrRoleCount = MgrRole::where($where)->count();
		if($mgrRoleCount === 0){
			echo 'true';
		}
		else{
			echo 'false';
		}
	}
	
	public function delete(){
		$roleId = input('post.roleId');
		$result['bSuccess'] = false;
		if(isset($roleId)){
			MgrRole::destroy($roleId);
	
			$result['bSuccess'] = true;
			$result['message'] = '删除成功';
		}
		return $result;
	}
}