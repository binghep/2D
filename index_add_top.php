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
/*
Param: the spot label
Return: the spot id.
If this label not found: returns false.
*/
function getSpotIdByLabel($label,$parking_spots_table){
  foreach ($parking_spots_table->all_rows as $row) {
    if ($row['spot_label']===$label){
      return $row['id'];
    }
  }
  return false;
}


//--------------------get a list of workers objects-------------------
$workers=new workers($db_handle);
    // var_dump($workers->all_workers);


//--------------------get a list of parking spot objects-------------------
$parking_spots_table=new parking_spots_table($db_handle);
// var_dump($parking_spots_table->all_rows);//each array element is like:
//array(2) { ["id"]=> string(1) "1" ["spot_label"]=> string(1) "1" }


/**
 * param: parking spot id
 * returns the id of worker that this spot is assigned to. 
 * if not found or no owner found, return false. 
 */ 
function getSpotOwnerIdBySpotId($spot_id){
  global $workers;
  foreach ($workers->all_workers as $worker) {
    if ($worker->assigned_parking_spot===$spot_id){
      return $worker->id;
    }
  }
  return false;
}

/**
 * Param: $region_1_spot_labels: an array of text representing parting spot labels. e.g. array("A",2,3)
 * This function prints out parking spot divs accroding to the param. 
 */
function display_spots($region_1_spot_labels){
  global $parking_spots_table;
  $region_1_spot_ids=array();
    $region_1_spot_owner_ids=array();
    // $region_1_spot_labels=array(60,59,58,57,56,55,53,52,51,50);//54 not exist

    //build the $region_1_spot_ids array accroding to $region_1_spot_labels array:
    foreach ($region_1_spot_labels as $label) {
      $spot_id=getSpotIdByLabel((string)$label,$parking_spots_table);
      
      if ($spot_id!==false){
        array_push($region_1_spot_ids, $spot_id);
      }else{
        echo 'weird';
      }
    }
    foreach ($region_1_spot_ids as $spot_id) {
      $spot_owner_id=getSpotOwnerIdBySpotId($spot_id);
      // if ($spot_owner_id!==false){
          array_push($region_1_spot_owner_ids, $spot_owner_id);//accept false if spot has no owner
        // }else{
          // echo 'weird';
        // }
    }

    $r1_labels='["' . implode('", "', $region_1_spot_labels) . '"]';//to be used by js
    $r1_ids='["' . implode('", "', $region_1_spot_ids) . '"]';//to be used by js
    $r1_owner_ids='["' . implode('", "', $region_1_spot_owner_ids) . '"]';//to be used by js

    $to_display="
    // var spots_labels = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
    var spots_labels=".$r1_labels.";
    var spots_ids=".$r1_ids.";
    var owner_ids=".$r1_owner_ids.";

    var arrayLength = spots_ids.length;//if no owner, owner_id data attribute could be null
    for (var i = 0; i < arrayLength; i++) {
        // alert(myStringArray[i]);
        //Do something
        $('<div>' + spots_labels[i] + '</div>').data( 'spot_id', spots_ids[i] ).data( 'spot_label', spots_labels[i] ).data('owner_id',owner_ids[i]).appendTo( '#cardSlots' ).droppable( {
        accept: '#cardPile div',
        hoverClass: 'hovered',
        drop: handleCardDrop
      } );
    }";
    echo $to_display;
}

// $labels=array();
// $temp="";
// for($i=1;$i<93;$i++){
//  array_push($labels, $i);
//  $temp.="(".$i.")";
//  if ($i!==92){
//    $temp.=",";
//  }
// }

// $query="insert into 2D_parking_spots(spot_label) values ".$temp;
// var_dump($query);
// $result=$db_handle->runQuery($query);
// var_dump($result);
// return;


//--------------------replace 1...10 by worker names, cardID by worker id-----------------------

//--------------------replace slots name to parking spot label--------------------------

?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/linenav.css"/>
  
  <title>2D Parking</title>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <link rel="stylesheet" type="text/css" href="css/style_22.css">
  <link rel="stylesheet" type="text/css" href="css/pop_up_window_statistics.css">
  <link rel="stylesheet" type="text/css" href="css/pop_up_window_report.css">
  <link rel="stylesheet" type="text/css" href="css/pop_up_window_worker_info.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

  <script type="text/javascript" src="js/html2canvas.js"></script>
  <script type="text/javascript" src="js/FileSaver.js-1.3.2/FileSaver.js"></script>
<script type="text/javascript">
 
$( init );
 
function init() {
 
  // Hide the success message
  $('#successMessage').hide();
  $('#successMessage').css( {
    left: '580px',
    top: '250px',
    width: 0,
    height: 0
  } );
 
  // Reset the game
  $('#cardPile').html( '' );
  $('#cardSlots').html( '' );
 
  // Create the pile of shuffled cards
  // var numbers = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ];
  // numbers.sort( function() { return Math.random() - .5 } );
 
  // for ( var i=0; i<10; i++ ) {
  //   $('<div>' + numbers[i] + '</div>').data( 'number', numbers[i] ).attr( 'id', 'car_of_worker_id_'+numbers[i] ).appendTo( '#cardPile' ).draggable( {
  //     containment: '#content',
  //     stack: '#cardPile div',
  //     cursor: 'move',
  //     revert: false
  //   } );
  // }

  //====================Create the pile of workers cards=====================
  <?php 
    $worker_names=array();
    $worker_ids=array();
    $department_ids=array();
    $department_names=array();
    $assigned_spot_ids=array();
    $assigned_spot_labels=array();
    $car_models=array();

    foreach ($workers->all_workers as $worker){
        array_push($worker_names, $worker->worker);
        array_push($worker_ids, $worker->id);
        array_push($department_ids, $worker->department_id);
        array_push($department_names, $worker->department_name);
        array_push($assigned_spot_ids,$worker->assigned_parking_spot);//could be null
        array_push($assigned_spot_labels, $worker->parking_spot_label);//could be null
        array_push($car_models,$worker->car_model);
    }
    // var_dump($worker_ids);

    $worker_names_js='["' . implode('", "', $worker_names) . '"]';//to be used by js
    $worker_ids_js='["' . implode('", "', $worker_ids) . '"]';//to be used by js
    $department_ids_js='["' . implode('", "', $department_ids) . '"]';//to be used by js
    $department_names_js='["' . implode('", "', $department_names) . '"]';//to be used by js
    $assigned_spot_ids_js='["' . implode('", "', $assigned_spot_ids) . '"]';//to be used by js
    $assigned_spot_labels_js='["' . implode('", "', $assigned_spot_labels) . '"]';//to be used by js
    $car_models_js='["' . implode('", "', $car_models) . '"]';//to be used by js

    //-------------------calculate worker visibility based on filter---------------------
    $worker_visibility=array();
    $filter_by_department_id=$_GET['select_department_id'];

    if (isset($filter_by_department_id)&& !empty($filter_by_department_id) && is_numeric($filter_by_department_id)){
        $filter_by_department_id=(int)$filter_by_department_id;
        foreach ($workers->all_workers as $worker) {
          // var_dump($worker->department_id."-".$filter_by_department_id);
            if ((int)$worker->department_id===$filter_by_department_id){
              // echo 'yes';
              array_push($worker_visibility, "1");//1 means visible
            }else{
              // echo 'no';
              array_push($worker_visibility, "0");//0 means invisible - must be string in order to work
            }
        }
    }else{
      $filter_by_department_id="all_departments";
      foreach ($workers->all_workers as $worker) {
         array_push($worker_visibility,"1");//1 means visible
      }
    }
    //-------------------finished calculating----------------------------------------
    $worker_visibility_js='["' . implode('", "', $worker_visibility) . '"]';//to be used by js
  ?>
  var worker_ids=<?php echo $worker_ids_js?>;
  var worker_names=<?php echo $worker_names_js?>;
  var department_ids=<?php echo $department_ids_js?>;
  var department_names=<?php echo $department_names_js?>;
  var assigned_spot_ids=<?php echo $assigned_spot_ids_js?>;
  var assigned_spot_labels=<?php echo $assigned_spot_labels_js?>;
  var car_models=<?php echo $car_models_js?>;

  var worker_visibility=<?php echo $worker_visibility_js?>;

  var arrayLength = worker_ids.length;
  // for ( var i=0; i<10; i++ ) {
  //   $('<div>' + numbers[i] + '</div>').data( 'number', numbers[i] ).attr( 'id', 'car_of_worker_id_'+numbers[i] ).appendTo( '#cardPile' ).draggable( {
  //     containment: '#content',
  //     stack: '#cardPile div',
  //     cursor: 'move',
  //     revert: false
  //   } );
  // }

  for (var i = 0; i < arrayLength; i++) {
      // console.log(worker_visibility[i]);
      if (worker_visibility[i]==="0"){continue;}
      console.log('creating car for '+worker_names[i]);
      $('<div style="color:skyblue">' + worker_names[i] + '</div>').data( 'worker_id', worker_ids[i] ).data( 'worker_name', worker_names[i] ).data('department_id',department_ids[i]).data('department_name',department_names[i]).data('assigned_spot_id',assigned_spot_ids[i]).data('assigned_spot_label',assigned_spot_labels[i]).data('car_model',car_models[i]).attr( 'id', 'car_of_worker_id_'+worker_ids[i] ).appendTo( '#cardPile' ).draggable( {
      start:handleDragStart,
      containment: '#content',
      stack: '#cardPile div',
      cursor: 'move',
      revert: false
    } );
  }

  //====================Create the car slots=====================
  //====================EAST PARKING SPACE: text=================
  $('<div class="text_div">EAST PARKING SPACE</div>').appendTo('#cardSlots');
  //====================east: 60-50==============================

  <?php
    $region_1_spot_labels=array(60,59,58,57,56,55,53,52,51,50);//24 not exist
    display_spots($region_1_spot_labels);
  ?>

  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 39-32==============================
  <?php
    $region_1_spot_labels=array(39,38,37,36,35,33,32);//34 not exist
    display_spots($region_1_spot_labels);
  ?>
  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 31-21==============================
  <?php
    $region_1_spot_labels=array(31,30,29,28,27,26,25,23,22,21);//24 not exist
    display_spots($region_1_spot_labels);
  ?>
   //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 20-12==============================
   <?php
    $region_1_spot_labels=array(20,19,18,17,16,15,13,12);//14 not exist
    display_spots($region_1_spot_labels);
   ?>
   //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 11-1==============================
     <?php
    $region_1_spot_labels=array(11,10,9,8,7,6,5,3,2,1);//4 not exist
    display_spots($region_1_spot_labels);
    ?>
  //====================ROAD=====================================
  
  $('<div class="road"></div>').appendTo('#cardSlots');

  //====================east: 61-66==============================
  <?php
    $region_1_spot_labels=array(61,62,63,65,65,66);//64 not exist
    display_spots($region_1_spot_labels);
  ?>
  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 67-75==============================
  <?php
    $region_1_spot_labels=array(67,68,69,70,71,72,73,75);//74 not exist
    display_spots($region_1_spot_labels);
  ?>
    
  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 76-86==============================
    <?php
    $region_1_spot_labels=array(76,77,78,79,80,81,82,83,85,86);//84 not exist
    display_spots($region_1_spot_labels);
  ?>
  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');  
  //====================east: 87-92==============================
   <?php
    $region_1_spot_labels=array(87,88,89,90,91,92);
    display_spots($region_1_spot_labels);
  ?>
  //====================finished all regions in EAST PARKING SPACE================
  //====================ROAD=====================================
  $('<div class="text_div"></div>').appendTo('#cardSlots');//make a little gap between EAST and WEST parking spot
  //====================starting regions in WEST PARKING SPACE================
  //====================WEST PARKING SPACE: text=================
  $('<div class="text_div">WEST PARKING LOT</div>').appendTo('#cardSlots');
  //====================west: 160-155==============================
   <?php
    $region_1_spot_labels=array(160,159,158,157,156,155);
    display_spots($region_1_spot_labels);
    ?>
  //=========================bush==================================
  $('<div class="bush"></div>').appendTo('#cardSlots');  
  //====================west: 153-151==============================
   <?php
    $region_1_spot_labels=array(153,152,151);
    display_spots($region_1_spot_labels);
   ?>
  //=========================blue line spot: no parking==================================
  $('<div class="blue_line_spot"></div>').appendTo('#cardSlots');  
  //====================west: 150-149==============================
   <?php
    $region_1_spot_labels=array(150,149);
    display_spots($region_1_spot_labels);
  ?>
  //====================ROAD=====================================
  
  $('<div class="road"></div>').appendTo('#cardSlots');
  //====================stairway=====================================
  $('<div class="stairway"></div>').appendTo('#cardSlots');
  //====================west: A==============================
   <?php
    $region_1_spot_labels=array("A");
    display_spots($region_1_spot_labels);
    ?>
  //=========================blue line spot: no parking==================================
  $('<div class="blue_line_spot"></div>').appendTo('#cardSlots'); 
  //==================B,C===================================
   <?php
    $region_1_spot_labels=array("B","C");
    display_spots($region_1_spot_labels);
   ?>
  //=========================blue line spot: no parking==================================
  $('<div class="blue_line_spot"></div>').appendTo('#cardSlots'); 
  //==================D=====================================
    <?php
    $region_1_spot_labels=array("D");
    display_spots($region_1_spot_labels);
  ?>
  //=================finished WEST PARKING LOT=======================


  //======================put the cars into their own spot, rearrange the rest====================
  var arrayLength = worker_ids.length;
  // console.log(arrayLength);
  for (var i = 0; i < arrayLength; i++) {
    // console.log(worker_ids[i]);
    if (parseInt(assigned_spot_ids[i])===108) continue;
    var car=$('#car_of_worker_id_'+worker_ids[i]);
    // console.log(car.);
    car.position({
      my:"left top",
      at:"left top",
      of:$('div.ui-droppable').filter(function(index) { return $(this).data('owner_id') === worker_ids[i]; })
    });

    car.html('<span style="color:white">'+worker_names[i]+'</span><span style="    color: white;position: relative;display: block;top: -12px;">'+assigned_spot_labels[i]+'</span>');
    // var spot=
    // car.draggable.position( { of: $(slot1), my: 'left top', at: 'left top' } );
    // break;
  }
  //======================change the color and text of cars having their own spot=================
}
 
</script>
 
 <script type="text/javascript" src="js/handle_drag_start_n_stop.js">
 </script>
</head>
<body>
    <?php //var_dump($worker_visibility);?>
 

    <table id="exlucde_menu_html" width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
          <tr> 
            <td  width="27" height="59" valign="middle"></td>
            <td width="705" height="59" valign="bottom" align="left">
            	<font size="-1" face="Arial, Helvetica, sans-serif"><strong>Parking Planner</strong></font></br>
           
	           <span class="spanFormat">
	                 <form action="index_add_top.php" method="GET">
	                   <?php
	                      //-----------------build a list of department objects--------------------
	                      $departments=new departments($db_handle);
	                      // foreach ($departments->all_departments as $department_object) {
	                          // var_dump($department_object);
	                      // }

	                      ////select Owner////
	                      echo "<select name='select_department_id'>";
	                      echo "<option value='all_departments' >All Departments</option>";
	                      //-----------------echo out each department as an option-----------------
	                      foreach ($departments->all_departments as $department_object) {
	                          // var_dump($department_object);
	                          $selected=($filter_by_department_id===(int)$department_object->department_id)?"selected":"";
	                          echo "<option value='".$department_object->department_id."' ".$selected.">".$department_object->department_name."</option>";
	                      }
	                      echo "</select>"; 
	                      ////select Owner////
	                    ?>
	                   <!--  <font size="2" face="Arial, Helvetica, sans-serif">Style:
	                    <input type="text" name="style" size="10" maxlength="40"/>
	                    <font size="2" face="Arial, Helvetica, sans-serif"><input name="nozero" type="checkbox" value="nozero" /><span class="style2">SHOW "0"</span>  -->
	                    
	                    <input type="submit" name="submit2" class="button" value="Find" />
	                    <!-- </font><span class="style2">To view all inventory - leave Style blank and submit</span>  -->
	                </form> 
	            </span> 
           </td>
           <td style="width:200px;">
           	
           </td>
           <td style="padding-top: 20px;width:330px;">
           <?php
            echo '<span  id="top_right_menu" style="display:none; z-index:2; color: black; font: 13px Verdana; float:left;width:330px;">';
            echo '<a href="#" id="open_statistics"><font>Statistics</font></a>';
            echo '<span> | </span>';
            echo '<a href="#" id="open_report"><font>Report</font></a>';
            echo '<span> | </span>';
            echo '<a id="export_csv" href="export_csv.php?select_department_id='.$filter_by_department_id.'" style="target-new: tab;"><font>Export CSV</font></a>';
            echo '<span id="vertical_delimiter2"> | </span>';
             echo '<a href="#" id="btnSave2"><font>Screenshot</font></a>'; 
            // echo ' | ';
            // echo '<a href="#" id="btnSave1"><font>Screenshot Small</font></a>';             
            echo '</span>'; 
            ?>
           </td>
           <script type="text/javascript">
             // $('#export_csv').click(function(e) {
             //      window.location.href = "export_csv.php?select_department_id=<?php echo $filter_by_department_id;?>";
             //  });
           </script>
          </tr>
          <tr> 
            <td colspan="4" height="12" valign="top"><img src="images/greenbar2.jpg" width="100%" height="7" ></td>
          </tr>
          <tr> 
            <td colspan="4" valign="top"> <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr> 
                  <td height="1000" valign="top">
                      <!-- This is the divs displayed all the time -->
                                      <div id="content" style="width:1760px;height:612px;"><!--was 1400-->
                                        <!-- <div id="box">...</div> -->

                                        <div id="box">
                                          ...
                                        </div>
                                        <div id="cardSlots"  style="display:inline;height:100%;float: left;margin:0px!important;width: 1592px;"> </div>
                                        <div id="cardPile"   style="display:inline;height:100%;float: right;width:85px;"> 
                                          <!-- <div id="open_statistics">Statistics</div> -->
                                        </div>
                      <!-- Done -->
            &nbsp;</td>
                </tr>
              </table></td>
          </tr>
    </table>


<!--  <div id="successMessage">
    <h2>You did it!</h2>
    <button onclick="init()">Play Again</button>
  </div> -->
  <!------------------pop up box+full screen transparent background----------------------\-->
  <!-- The box itself-->
  <div id="whole_pop_up_with_transparent">
    <div id="pop_up_itself" ><!--800px-->
            <div id="filter_close_button_wrapper">
                <a href="javascript:void(0)" id="close_pop_up">Close</a>
            </div>

            <div style="padding: 80px 20px;">
              <table class="green2 pop_up_table"><!--600px-->
                <tr>
            <th nowrap="" width="136"><div align="right"><span>Worker Name:</span></div></th>
            <td nowrap="" width="440">
              <div align="right">
                <span class="pop_up_worker_name">
                  ...
                      </span>
                      <input class="hidden" type="text" class="pop_up_worker_name" value="">
                    </div>
                  </td>
                </tr>
                <tr>
            <th nowrap="" width="136"><div align="right"><span>Department:</span></div></th>
            <td nowrap="" width=500>
              <div align="right">
                <span class="pop_up_department_name">
                  ...
                      </span>
                      <input class="hidden" type="text" class="pop_up_department_name" value="">
                    </div>
                  </td>
                </tr>
                <tr>
            <th nowrap="" width="136"><div align="right"><span>Car Model:</span></div></th>
            <td nowrap="" width="440">
              <div align="right">
                <span class="pop_up_car_model">
                  ...
                      </span>
                      <input class="hidden" type="text" class="pop_up_car_model" value="">
                    </div>
                  </td>
                </tr>
                <tr>
            <th nowrap="" width="136"><div align="right"><span>Parking Spot:</span></div></th>
            <td nowrap="" width="440">
              <div align="right">
                <span class="pop_up_assigned_spot_label">
                ...
                      </span>

                      <input class="hidden" type="text" class="pop_up_assigned_spot_id" value="">
                      <input class="hidden" type="text" class="pop_up_assigned_spot_label" value="">
                    </div>
                  </td>
                </tr>
        </table>
      </div>
       </div>
     </div>
     <!-- the full screen transparent background -->
     <div id="fade" class="black_overlay" style="display: none;"></div>

  <script type="text/javascript" src="js/pop_up_worker_info.js"></script>

  <!------------------finish pop up box (worker info)----------------------\-->
  <!------------------start pop up box (statistics)----------------------\-->
  <!-- The box itself-->
  <div id="whole_pop_up_with_transparent2">
    <div id="pop_up_itself2" style="height: 550px;" ><!--800px-->
            <div id="filter_close_button_wrapper2">
                <a href="javascript:void(0)" id="close_pop_up2">Close</a>
            </div>
            <div style="padding:10px">
	            <div id="statistics_div_to_fill" style="padding:0px 20px 50px;"> <!--will be filled by ajax-->
	              <!-- h4>Logistics Department <?php //echo "(".$num_parked."/".$total." Parked)" ?></h4>
	              <table class="green2 pop_up_table2"> 
	        </table> -->
	      		</div>
      		</div>
       </div>
     </div>
     <!-- the full screen transparent background -->
     <div id="fade" class="black_overlay" style="display: none;"></div>
     <!-- The following script has to be hardcoded in his php because it has a php variable -->
    <script type="text/javascript">
    	$(document).ready(function(){
		 	  $("#close_pop_up2").click(function(){
	         	 document.getElementById("whole_pop_up_with_transparent2").style.display="none";
	          // document.getElementById("fade").style.display="none";
		      });
		      
		      var request;
		      $("#open_statistics").click(function(){
		           if (request){
		                request.abort();
		            }
		            request= $.ajax({
		                url:"get_html_content_for_statistics_pop_up.php",
		                type: "get",
		                data: {'select_department_id': "<?php echo $filter_by_department_id;?>"}
		            });

		            // Callback handler that will be called on success
		            request.done(function (response, textStatus, jqXHR) {
		                // Log a message to the console
		                console.log(response);
		                var response_obj=JSON.parse(response);
		                if (response_obj.data.status=='ok'){
		                    console.log("successfully get pop up html from ajax. ");
		                    $('#statistics_div_to_fill').html(response_obj.data.content);
		                    document.getElementById("whole_pop_up_with_transparent2").style.display="block";
		                    // document.getElementById("fade").style.display="block";
		                }else if (response_obj.data.status=='error'){
		                    console.log("ERROR MSG: "+response_obj.data.error_msg);
		                    $('#box').html(response_obj.data.error_msg);
		                }
		            });
		            // Callback handler that will be called on failure
		            request.fail(function (jqXHR, textStatus, errorThrown) {
		              $('#box').html("ERROR: ajax failed to get pop up html. ");
		                // Log the error to the console
		                console.error(
		                    "The following error occurred: " +
		                    textStatus, errorThrown
		                );
		            });
		       });
		})

    </script>
  <!------------------finish pop up box (statistics)----------------------\-->
  <!------------------start pop up box (report)----------------------\-->
  <!-- The box itself-->
  <div id="whole_pop_up_with_transparent3">
    <div id="pop_up_itself3" style="height: 550px;" ><!--800px-->
            <div id="filter_close_button_wrapper3">
                <a href="javascript:void(0)" id="close_pop_up3">Close</a>
            </div>
            <div style="padding:10px">
	            <div id="report_div_to_fill" style="padding:0px 20px 50px;"> <!--will be filled by ajax-->
	              <!-- h4>Logistics Department <?php //echo "(".$num_parked."/".$total." Parked)" ?></h4>
	              <table class="green2 pop_up_table2"> 
	        </table> -->
	      		</div>
      		</div>
       </div>
     </div>
     <!-- the full screen transparent background -->
     <div id="fade" class="black_overlay" style="display: none;"></div>
  <script type="text/javascript" src="js/pop_up_report.js"></script>
  <!------------------finish pop up box (report)----------------------\-->
  <!------------------other js----------------------\-->
    <script type="text/javascript" src="js/download_screenshot.js"></script>
  <script type="text/javascript" src="js/hide_btnSave_screenshot_for_ie_n_safari.js"></script>
</div>
 
</body>
</html>