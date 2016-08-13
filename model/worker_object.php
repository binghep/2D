<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

require "worker_record_object.php";

/********************************************************************************
* This object represents a row/worker in 2D_workers table,
* plus joining the 2 tables to get the parking spot label as well. 
********************************************************************************/
class worker_object{
	public $id;
	public $worker;//name
	public $department_id;
	public $department_name;
	public $car_model;
	public $assigned_parking_spot;
	public $parking_spot_label;//joining tables get this value

	public $db_handle;
	function __construct($id,$worker,$department_id,$department_name,$car_model,$assigned_parking_spot,$parking_spot_label,$db_handle){
		$this->db_handle=$db_handle;
		$this->id=$id;
		$this->worker=$worker;
		$this->department_id=$department_id;
		$this->department_name=$department_name;
		$this->car_model=$car_model;
		$this->assigned_parking_spot=$assigned_parking_spot;

		$this->parking_spot_label=$parking_spot_label;
		// $this->init();
	}	
	// function init(){
		// $query="select * from 2D_workers
		// 		inner join 2D_parking_spots
		// 		on 2D_parking_spots.id=2D_workers.assigned_parking_spot";
		// $result=$this->db_handle->runQuery($query);

	// }

	/**
	 * Returns an array of worker_record object
	 * Returns false if no record in database
	 */ 
	public function get_records(){
		$query="select * from 2D_history where worker_id=".$this->id;
		$result=$this->db_handle->runQuery($query);
		if (is_null($result)){
			return false;
		}
		$worker_record_objects=array();
		$park_start_row="";
		// var_dump($result);
		// return true;
		foreach ($result as $row) {
			if ($park_start_row===""){//if is first row
				$park_start_row=$row;
			}else{
				if ($row['new_value']===(string)$park_start_row['new_value']){
					continue;
				}else{
					$spot_id=(int)$park_start_row['new_value'];
					$start_timestamp=$park_start_row['time_stamp'];
					$end_timestamp=$row['time_stamp'];
					$worker_record_object=new worker_record_object($this->id,$this->worker,$spot_id, $this->getSpotLabelById($spot_id),$start_timestamp,$end_timestamp);//complete a record
					array_push($worker_record_objects,$worker_record_object);
					//---------init again--------------
					$park_start_row=$row;
				}
			}
		}
		$spot_id=(int)$park_start_row['new_value'];
		$start_timestamp=$park_start_row['time_stamp'];
		$worker_record_object=new worker_record_object($this->id,$this->worker,$spot_id, $this->getSpotLabelById($spot_id),$start_timestamp,'now');//complete last record
		array_push($worker_record_objects,$worker_record_object);
		return $worker_record_objects;
	}

	/**
	 * returns spot label
	 * returns false if not found or is invalid param. 
	 */ 
	function getSpotLabelById($spot_id){
		if (!is_numeric($spot_id)) return false;
		$query="select * from 2D_parking_spots where id=".$spot_id;
		$result=$this->db_handle->runQuery($query);
		if (is_null($result)){
			return false;
		}else{
			return $result[0]['spot_label'];
		}
	}
}


/*******************************************
*test cases:
*******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $worker_object=new worker_object('1',"Alice",'3',"IT","alice car","105","TT",$db_handle);
// var_dump($worker_object->get_records());