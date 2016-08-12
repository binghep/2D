<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
date_default_timezone_set("America/Los_Angeles");


$worker_id=$_GET['worker_id'];
$response['data']['queried_worker_id']=$worker_id;

if (!isset($worker_id) || !is_numeric($worker_id)){
	$response['data']['status']='error';
	$response['data']['error_msg']="ERROR: param not set or not numeric.";
	die (json_encode($response, JSON_FORCE_OBJECT));
}



require "database/dbcontroller.php";
// require "model/workers.php";
// require "model/parking_spots_table.php";

$db_handle=new DBController();


$query="select * from 2D_workers where id=".$worker_id;
$result=$db_handle->runQuery($query);
if (is_null($result)){
	$response['data']['status']='error';
	$response['data']["error_msg"]='ERROR: Work ID does not exist in database.';
}else{
	$query="UPDATE 2D_workers SET assigned_parking_spot=108 WHERE id=".$worker_id;	//108 spot means no spot. if set to NULL it mess up jquery. 
	$result=$db_handle->runQuery($query);
	if ($result===true){
		$response['data']['status']='ok';

		//--------record successful update in database-----------
		$field_name="assigned_parking_spot";
		$new_value=108;
		$result=add_history($field_name,$new_value,$worker_id,$db_handle);
		if($result===false){
			$response['data']['status']="error";
			$response['data']['error_msg']="mysql insert error: cannot insert new row into database";
		}
	}else{
		$response['data']['error_msg']="ERROR: update query failed.";
	}
}

die (json_encode($response, JSON_FORCE_OBJECT));





/**
 * In 2D_history table record that for $worker_id, $field_name is changed to (string)$new_value
 * Returns: bool
 *  		true means mysql update success
 * 			false means mysql update failed
 */ 
function add_history($field_name,$new_value,$worker_id,$db_handle){
	//------------prepare LA timestamp for mysql auto timestamp, otherwise it is UTC even though I changed //$ sudo dpkg-reconfigure tzdata
	//-----------------------------------------------------------------------------------------------------
	$date = new DateTime(); //this returns the current date time
	$time_stamp=date_format($date,"Y-m-d H:i:s");

	$query="INSERT INTO `global_link_distribution`.`2D_history` (`worker_id`,`field_name`, `new_value`) VALUES ('$worker_id','$field_name', '$new_value');";//auto timestamp
	$result=$db_handle->runQuery($query);
	return $result;
}