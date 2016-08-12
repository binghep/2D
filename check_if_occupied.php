<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

date_default_timezone_set("America/Los_Angeles");

$parking_spot_id=$_GET['parking_spot_id'];
$worker_id=$_GET['worker_id'];

$response['input']['parking_spot_id']=$parking_spot_id;
$response['input']['worker_id']=$worker_id;

//-----------sanitize  $_GET input-------------------------------------
if (!isset($parking_spot_id) || !is_numeric($parking_spot_id)){
	$response['data']['status']="error";//param: spot id exists. 
	$response['data']['error_msg']="Error: param not set or not numeric.";
	die (json_encode($response, JSON_FORCE_OBJECT));
}


if (!isset($worker_id) || !is_numeric($worker_id)){
	$response['data']['status']="error";
	$response['data']['error_msg']="Error: param not set or not numeric.";
	die (json_encode($response, JSON_FORCE_OBJECT));
}




require "database/dbcontroller.php";
require "model/workers.php";
require "model/parking_spots_table.php";

$db_handle=new DBController();

//--------------------get a list of spots objects---------------------
$parking_spots_table=new parking_spots_table($db_handle);
// var_dump($parking_spots_table);

//--------------------check if $parking_spot_id exists/is valid-------
$spot_exists=false;
foreach ($parking_spots_table->all_rows as $row) {
	if ($row['id']===$parking_spot_id){
		//is valid:
		$spot_exists=true;
		break;
	}
}


if (!$spot_exists){
	$response['data']['status']="error";//param: spot id exists. 
	$response['error_msg']="spot_id not valid";
	die (json_encode($response, JSON_FORCE_OBJECT));
}


//--------------------get a list of workers objects-------------------
$workers=new workers($db_handle);
$occupied=false;
// var_dump($workers->all_workers);


//------------------set $occupied to true or false--------------------
$spot_owner=null;
foreach ($workers->all_workers as $worker) {
	// var_dump($worker);
	// var_dump($worker->assigned_parking_spot);
	// var_dump($parking_spot_id);
	if ($worker->assigned_parking_spot==$parking_spot_id){
		$spot_owner=$worker->name;
		$occupied=true;
		break;
	}
}


//-----------------update if $occupied===false------------------------
if ($occupied===true){
	$response['data']['status']="error";//ok means successfully occupied the empty spot
	$response['data']['is_empty_spot']=false;
	$response['data']['error_msg']="Not OK (Already taken by $spot_owner)";
}else{
	$response['data']['is_empty_spot']=true;
	//-------update database: add this spot to worker table:--------
	$query="update 2D_workers SET assigned_parking_spot=$parking_spot_id where id=".$worker_id;


	$result=$db_handle->runQuery($query);
	if ($result===true){
		$response['data']['status']="ok";//ok means successfully occupied the empty spot

		//--------record successful update in database-----------
		$field_name="assigned_parking_spot";
		$new_value=$parking_spot_id;
		$result=add_history($field_name,$new_value,$worker_id,$db_handle);
		if($result===false){
			$response['data']['status']="error";
			$response['data']['error_msg']="mysql insert error: cannot insert new row into database";
		}
	}else{
		$response['data']['status']="error";	
		$response['data']['error_msg']="mysql update error: cannot add this spot to worker";
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