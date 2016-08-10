<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

require_once __DIR__.'/../../../app/Mage.php';
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
require_once __DIR__.'/worker_object.php';

/********************************************************************************
* This object contains $all_workers, which holds a list of worker objects represeting each row in 2D_workers table, plus joining the 2 tables to get the parking spot label as well. 
********************************************************************************/
class workers{
	//an array of product_stock_object, which is used in providing first half of stock report
	public $all_workers;

	public $db_handle;
	function __construct($db_handle){
		$this->db_handle=$db_handle;
		$this->init();//fill the all_workers array
	}	
	/**
	 * this function initialize the array $all_workers, which is false if failed to be initizalized
	 */ 
	function init(){
		$all_workers=array();	
		
		// $result=$this->db_handle->runQuery("select * from 2D_workers");
		
		/*$query="select * from 2D_workers
				inner join 2D_parking_spots
				on 2D_parking_spots.id=2D_workers.assigned_parking_spot";
		*/
		$query="select 2D_workers.id as worker_id, 2D_workers.name as worker_name,2D_departments.id as department_id, 2D_departments.name as department_name, 2D_workers.car_model,2D_workers.assigned_parking_spot,2D_parking_spots.spot_label  
from 2D_workers
				
				left join 2D_parking_spots
					on 2D_parking_spots.id=2D_workers.assigned_parking_spot
				left join 2D_departments
					on 2D_departments.id=2D_workers.department_id
				";
		$result=$this->db_handle->runQuery($query);

		if (!is_null($result)){
			foreach ($result as $row) {
				// var_dump($row);
				$worker_object=new worker_object($row['worker_id'],$row['worker_name'],$row['department_id'],$row['department_name'],$row['car_model'],$row['assigned_parking_spot'],$row['spot_label']);
				array_push($all_workers,$worker_object);
			}
			$this->all_workers=$all_workers;
		}
	}
}


/*******************************************
*test cases:
*******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $workers=new workers($db_handle);
// var_dump($workers->all_workers);