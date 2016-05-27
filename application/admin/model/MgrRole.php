<?php
namespace app\admin\model;

use app\admin\common\BaseModel;
/**
 * File Name: MgrRole.php
 * Author Name: ShenWei
 * Date: 2016 下午6:57:16
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
class MgrRole extends BaseModel{
	protected $pk = 'roleId';
	
	public function mgrRolePower(){
		return $this->hasMany('MgrRolePower', 'roleId');
	}
	
	public function tranCreate(){
		$this->db()->startTrans();
		try {
			$cData = [
					'roleName'	=> $this->roleName,
					'roleCaption'	=> $this->roleCaption,
					'createTime'	=> $this->createTime,
					'lastTime'	=> $this->lastTime,
					'metaStatus'	=>	$this->metaStatus
			];
			$dbData = $this->create($cData);
			
			foreach ($this->mgrRolePower as $mgrRolePower){
				MgrRolePower::create([
						'roleId'	=>	$dbData->roleId,
						'powerId'	=>	$mgrRolePower['powerId']
				]);
			}
			// 提交事务
			$this->db()->commit();
			
		} catch (\PDOException $e){
			// 回滚事务
			$this->db()->rollback();
		}
	}
	
	public function tranUpdate(){
		$this->db()->startTrans();
		try {
			$upData = [
					'roleName'	=> $this->roleName,
					'roleCaption'	=> $this->roleCaption,
					'lastTime'	=> $this->lastTime,
					'metaStatus'	=>	$this->metaStatus
					];
			$this->update($upData,['roleId'	=> $this->roleId]);
			$where['roleId'] = $this->roleId;
			
			$mgrRolePowerList = MgrRolePower::where($where)->select();
			
			$mgrRolePowerInsertList = $this->mgrRolePower;
			foreach ($mgrRolePowerList as $dbMgrRolePower){
				$blDelete = true;
				foreach ($this->mgrRolePower as $key => $mgrRolePower){
					if($dbMgrRolePower->powerId == $mgrRolePower['powerId']){
						unset($mgrRolePowerInsertList[$key]);
						
						$blDelete = false;
						break;
					}
				}
				if($blDelete){
					MgrRolePower::destroy($dbMgrRolePower->rolePowerId);
				}
			}
			foreach ($mgrRolePowerInsertList as $mgrRolePower){
				MgrRolePower::create([
						'roleId'	=>	$this->roleId,
						'powerId'	=>	$mgrRolePower['powerId']
				]);
			}
			
			// 提交事务
			$this->db()->commit();
		}
		catch (\PDOException $e){
			// 回滚事务
			$this->db()->rollback();
		}
	}
}