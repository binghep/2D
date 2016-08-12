<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

require_once __DIR__.'/department_object.php';

/********************************************************************************
* This object contains $all_workers, which holds a list of worker objects represeting each row in 2D_workers table, plus joining the 2 tables to get the parking spot label as well. 
********************************************************************************/
class departments{
	//an array of department_object, which is used in providing first half of stock report
	public $all_departments;

	public $db_handle;
	function __construct($db_handle){
		$this->db_handle=$db_handle;
		$this->init();//fill the all_departments array
	}	
	/**
	 * this function initialize the array $all_departments, which is false if failed to be initizalized
	 */ 
	function init(){
		$all_departments=array();	
				
		$query="select * from 2D_departments";
		$result=$this->db_handle->runQuery($query);

		if (!is_null($result)){
			foreach ($result as $row) {
				// var_dump($row);
				$department_object=new department_object($row['id'],$this->db_handle);
				array_push($all_departments,$department_object);
			}
			$this->all_departments=$all_departments;
			return true;
		}else{
			echo 'Error. cannot find rows in departments table.<br>';
			return false;
		}
	}
}


/*******************************************
*test cases:
*******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $departments=new departments($db_handle);
// var_dump($departments->all_departments);