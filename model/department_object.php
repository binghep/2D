<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
require_once __DIR__.'/worker_object.php';



class department_object{
	public $department_id;
	public $department_name;
	public $all_workers;//an array of workers.

	public $db_handle;
	function __construct($department_id,$db_handle){
		$this->db_handle=$db_handle;
		
		$this->department_id=(int)$department_id;

		$this->init();
	}

	//----------add a worker to $workers --------------------
	// function add_worker($worker){
	// 	//-------make sure worker belongs to this department-------
	// 	if ((int)$worker->department_id!==$this->department_id){
	// 		echo "worker does not belong to this department, cannot add worker.<br>";
	// 		return false;
	// 	}
	// 	//-------initialize array if needed-----------------------
	// 	if (is_null($this->workers)){
	// 		$this->workers=array();
	// 	}
	// 	$new_workers=$this->workers;
	// 	array_push($new_workers, $worker);
	// 	$this->workers=$new_workers;
	// }

	//----------fill in $department_name and $workers--------------
	function init(){
		$all_workers=array();	
		//------------fill in $department_name-------------------
		$query="select * from 2D_departments where id=".$this->department_id;
		$result=$this->db_handle->runQuery($query);
		if (is_null($result)){
			echo 'Error. cannot find rows matching this department ID in departments table.<br>';
			return false;//cannot find this department row
		}
		foreach ($result as $row) {
			if ((int)$row['id']===$this->department_id){
				$this->department_name=$row['name'];
			}
		}
		//-------------fill in $workers--------------------------
		$query="select 2D_workers.id as worker_id, 2D_workers.name as worker_name,2D_departments.id as department_id, 2D_departments.name as department_name, 2D_workers.car_model,2D_workers.assigned_parking_spot,2D_parking_spots.spot_label  
from 2D_workers
				
				left join 2D_parking_spots
					on 2D_parking_spots.id=2D_workers.assigned_parking_spot
				left join 2D_departments
					on 2D_departments.id=2D_workers.department_id
					
					where department_id=".$this->department_id.";";//added last line condition to filter only this department
		$result=$this->db_handle->runQuery($query);
		if (is_null($result)){
			$this->workers=array();
		}else{
			foreach ($result as $row) {
				$worker_object=new worker_object($row['worker_id'],$row['worker_name'],$row['department_id'],$row['department_name'],$row['car_model'],$row['assigned_parking_spot'],$row['spot_label'],$this->db_handle);
				array_push($all_workers,$worker_object);
			}
			$this->all_workers=$all_workers;
		}
	}

	public function get_num_parked()
	{
		$num_parked=0;
		foreach ($this->all_workers as $worker) {
			if (!is_null($worker->assigned_parking_spot) && (int)$worker->assigned_parking_spot!==108){
				$num_parked++;
			}
		}
		return $num_parked;
	}
}


/*******************************************
*test cases:
*******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $department_object=new department_object(1,$db_handle);//IT department
// var_dump($department_object->all_workers);