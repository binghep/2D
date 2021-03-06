<?php

/**
 * Draggable/Card: Every car div has following data attributes:
 * worker_id, worker_name, assigned_spot_id (accept false)
 * id=car_of_worker_id_16
 * 
 * Droppable/slot: Every spot div has following data attributes: 
 * spot_id, spot_label, owner_id (accept false)
 */ 

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

require "database/dbcontroller.php";
require "model/workers.php";
require "model/parking_spots_table.php";

// require "model/department_object.php";
require "model/departments.php";



$db_handle=new DBController();

//--------------------get a list of workers objects-------------------
// $workers=new workers($db_handle);
//     // var_dump($workers->all_workers);


// //--------------------get a list of parking spot objects-------------------
// $parking_spots_table=new parking_spots_table($db_handle);


//------------------sanitize $_GET-----------------------------
$filter_by_department_id=$_GET['select_department_id'];

$response=array();
$response['input']['select_department_id']=$filter_by_department_id;

if (isset($filter_by_department_id)&& !empty($filter_by_department_id) && is_numeric($filter_by_department_id)){
    $filter_by_department_id=(int)$filter_by_department_id;
}elseif (!isset($filter_by_department_id) || $filter_by_department_id==="all_departments" || empty($filter_by_department_id)){
    $filter_by_department_id="all_departments";
}else{
    $response['data']['status']="error";
    $response['data']['error_msg']="get param value invalid";
    die (json_encode($response, JSON_FORCE_OBJECT));
}



//-----------------build a list of department objects--------------------
$departments=new departments($db_handle);
// foreach ($departments->all_departments as $department_object) {
    // var_dump($department_object);
// }

// var_dump($filter_by_department_id);
// var_dump($departments->all_departments);
// return;
//-----------------display required department or all departments-----------------
if ($filter_by_department_id==="all_departments"){//export all department
    $content=EXPORT_DEPARTMENTS($departments->all_departments,"Parking Details - 2D Parking Planner");
    $response['data']['status']="ok";
    $response['data']['content']=$content;
    die (json_encode($response, JSON_FORCE_OBJECT));
}else{//export one department
    $found_department=false;
    // var_dump($filter_by_department_id);
    foreach ($departments->all_departments as $department_object) {
      // var_dump($department_object->department_id);
      if ($department_object->department_id===$filter_by_department_id){
          $found_department=true;
          $content=EXPORT_DEPARTMENTS(array($department_object),"Parking Details - 2D Parking Planner");
          $response['data']['status']="ok";
          $response['data']['content']=$content;
          break;
      }
    }

    //--------output success or not------------
    if ($found_department===false){
        $response['data']['status']="error";
        $response['data']['error_msg']="cannot find department requested. department id not valid";
    }else{
        $response['data']['status']="ok";
    }
    die (json_encode($response, JSON_FORCE_OBJECT));
}


/**
 * param: $department_object - an array of department_object
 *        $name - csv name
 */ 
function EXPORT_DEPARTMENTS($department_objects,$name){
    $content='';
    foreach ($department_objects as $department_object) {
        // $num_parked=$department_object->get_num_parked();
        // $num_total=count($department_object->all_workers);
        $content.="<div><h3>".$department_object->department_name."</h3></div>";
        foreach ($department_object->all_workers as $worker) {
            $content.='<table class="report" width="80%"" align="center" style="border-collapse:collapse;display:block">';
            $content.="<caption>".$worker->worker."</caption>";
            
            $content.='<tr><th><strong>Parked At Spot</strong></th><th><strong>Start</strong></th><th><strong>End</strong></th><th><strong>Duration</strong></th></tr>';

            // $parking_spot_id=$worker->assigned_parking_spot;
            $style="";
           
            // if ((int)$parking_spot_id===108){
            //     $parking_spot_id="none";
            //     $style=" class='yellow' ";
            // }
            
            $worker_records=$worker->get_records();
            // var_dump($worker_records);

            if($worker_records===false){continue;}
            
            foreach ($worker_records as $record_object) {
                $content.="<tr>";
            
                $content.="<td style='width:30px;'>".$record_object->parked_at_spot_label."</td><td style='width: 100px;'>".$record_object->start_timestamp."</td><td style='width: 160px;'>".$record_object->end_timestamp."</td><td ".$style.">".$record_object->duration."</td>";
                $content.="</tr>";
            }
            $content.="</table>\n";
        }
        // break;//first department only: IT
    }

    // $backup_name = $backup_name ? $backup_name : $name . "___(" . date('H-i-s') . "_" . date('d-m-Y') . ")__rand" . rand(1, 11111111) . ".csv";
    // header('Content-Type: application/octet-stream');
    // header("Content-Transfer-Encoding: Binary");
    // header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");

    $content=str_replace("\n", "<br>", $content);
    return $content;
}


           


