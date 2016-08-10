<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
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
	}else{
		$response['data']['error_msg']="ERROR: update query failed.";
	}
}

die (json_encode($response, JSON_FORCE_OBJECT));
