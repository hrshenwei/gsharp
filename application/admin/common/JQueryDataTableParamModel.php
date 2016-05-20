<?php
/**
 * File Name: JQueryDataTableParamModel.php
 * Author Name: ShenWei
 * Date: 2016 上午11:36:12
 * Encoding: UTF-8
 * Copyright (c) 2016,  All Rights Reserved.
 *
 */
namespace app\admin\common;

class JQueryDataTableParamModel{
	public $sEcho = 0, $sSearch, $iDisplayLength = 0, $iDisplayStart = 10, $iColumns, $iSortingCols, $sColumns;

	/**
	 *
	 * @param unknown $request
	 */
	public function __construct($request){
		$this->sEcho = $request['sEcho'];
		$this->sSearch = $request['sSearch'];
		$this->iDisplayLength = $request['iDisplayLength'];
		$this->iDisplayStart = $request['iDisplayStart'];
		$this->iColumns = $request['iColumns'];
		if(isset($request['iSortingCols'])){
			$this->iSortingCols = $request['iSortingCols'];
		}
		$this->sColumns = $request['sColumns'];
	}

	function getDatatablesJsonData($recordsTotal = 0, $recordsFiltered = 0, $data = array()){
		$jsonResult = array(
				"recordsTotal"    => isset($recordsTotal) ? $recordsTotal : 0,
				"recordsFiltered" => isset($recordsFiltered) ? $recordsFiltered : 0,
				"data"            => isset($data) ? $data : array()
		);
		return $jsonResult;
	}
}