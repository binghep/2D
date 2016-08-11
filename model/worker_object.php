<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");



/********************************************************************************
* This object represents a row/worker in 2D_workers table,
* plus joining the 2 tables to get the parking spot label as well. 
********************************************************************************/
class worker_object{
	//an array of product_stock_object, which is used in providing first half of stock report
	public $id;
	public $worker;//name
	public $department_id;
	public $department_name;
	public $car_model;
	public $assigned_parking_spot;
	public $parking_spot_label;//joining tables get this value

	public $db_handle;
	function __construct($id,$worker,$department_id,$department_name,$car_model,$assigned_parking_spot,$parking_spot_label){
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

}


/*******************************************
*test cases:
*******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $stock=new stock($db_handle);
// var_dump($stock->all_stock);