<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

require_once __DIR__.'/../../../app/Mage.php';
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
// require_once __DIR__.'/parking_spot_object.php';

/********************************************************************************
* This object contains $all_stock, which holds a list of product_stock_object represeting each item we actually keep in stock (e.g. fitbit)
********************************************************************************/
class parking_spots_table{
	//an array of product_stock_object, which is used in providing first half of stock report
	public $all_rows;

	public $db_handle;
	function __construct($db_handle){
		$this->db_handle=$db_handle;
		$this->init();//fill the all_stock array
	}	
	/**
	 * this function initialize the array $product_stock_objects
	 */ 
	function init(){
		$all_rows=array();
		$result=$this->db_handle->runQuery("select * from 2D_parking_spots");
		if (!is_null($result)){
			$this->all_rows=$result;
		}
	}
}


/*******************************************
*test cases:
*******************************************/
// echo "<pre>";
// require_once __DIR__.'/../database/dbcontroller.php';
// $db_handle=new DBController();
// $parking_spots_table=new parking_spots_table($db_handle);
// var_dump($parking_spots_table->all_rows);