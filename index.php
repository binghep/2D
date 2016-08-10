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
// 	array_push($labels, $i);
// 	$temp.="(".$i.")";
// 	if ($i!==92){
// 		$temp.=",";
// 	}
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
 
<title>2D Parking</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" href="style_22.css">
 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
 <style type="text/css">
 	#content{
 		width:1774px;
 	}

 </style>
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
  ?>
  var worker_ids=<?php echo $worker_ids_js?>;
  var worker_names=<?php echo $worker_names_js?>;
  var department_ids=<?php echo $department_ids_js?>;
  var department_names=<?php echo $department_names_js?>;
  var assigned_spot_ids=<?php echo $assigned_spot_ids_js?>;
  var assigned_spot_labels=<?php echo $assigned_spot_labels_js?>;
  var car_models=<?php echo $car_models_js?>;

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
 
 <script type="text/javascript">
 var request;
var request_drag_start;

function handleDragStart( event, ui ) {
  // var offsetXPos = parseInt( ui.offset.left );
  // var offsetYPos = parseInt( ui.offset.top );
  // alert( "Drag started!\n\nOffset: (" + offsetXPos + ", " + offsetYPos + ")\n");
    var worker_id = ui.helper.data( 'worker_id' );
    // console.log(worker_id);
    // var worker_name = ui.draggable.data( 'worker_name' );
    var worker_name = ui.helper.data( 'worker_name' );
    // console.log(ui.helper);
    // console.log(ui.helper.draggable);
    ui.helper.removeClass( 'occupied' );
    $('#car_of_worker_id_'+worker_id).html(worker_name); //remove the span(spot label) on top of the car below worker. and change back to white span
    //-------------------ajax removing any assigned spot for this worker---------------------
    if (request_drag_start){
        request_drag_start.abort();
    }
    request_drag_start= $.ajax({
        url:"remove_assigned_spot.php",
        type: "get",
        data: {'worker_id': worker_id}
    });
    // Callback handler that will be called on success
    request_drag_start.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        console.log(response);
        var response_obj=JSON.parse(response);
        if (response_obj.data.status=='ok'){
        		console.log("OK. Removed assigned parking spot for worker.");
	           	$('#box').html("OK. Removed assigned parking spot for worker.");
        	}else if (response_obj.data.status=='error'){
	           	console.log("ERROR MSG: "+response_obj.data.error_msg);
	           	$('#box').html(response_obj.data.error_msg);
        }
    });
    // Callback handler that will be called on failure
    request_drag_start.fail(function (jqXHR, textStatus, errorThrown) {
	    $('#box').html("ERROR: cannot remove assgiend spot for this worker. Ajax request failed. ");

        // Log the error to the console
        console.error(
            "The following error occurred: " +
            textStatus, errorThrown
        );
        // $('#isCaptchaMatch').val('false');
        // $('.error_msg').html('请先输入正确的图片验证码 (please enter correct captha first)');
        // return;
    });
}

 function handleCardDrop( event, ui ) {
	  var slotNumber = $(this).data( 'spot_id' );
    var spot_label=$(this).data( 'spot_label' );
    var car_id = ui.draggable.data( 'worker_id' );
	  var worker_name = ui.draggable.data( 'worker_name' );
	  var worker_id=ui.draggable.data('worker_id');
	 
	  // If the card was dropped to the correct slot,
	  // change the card colour, position it directly
	  // on top of the slot, and prevent it being dragged
	  // again
	 
	  // if ( slotNumber == car_id ) {
//-------------------ajax checking if the spot has owner---------------------
	var slot1=this;
    // Variable to hold request
  
	if (request){
        request.abort();
    }
    request= $.ajax({
        url:"check_if_occupied.php",
        type: "get",
        data: {'parking_spot_id': slotNumber, 
    			'worker_id':worker_id}
    });
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        console.log(response);
       	var response_obj=JSON.parse(response);

        if (response_obj.data.status==="ok"){//ok means successfully occupied the empty spot
	           	console.log("OK");
	           	$('#box').html('OK');
	           	// $(slot1).data('occupied',true);
				// ui.draggable.addClass( 'correct' );
        		ui.draggable.addClass( 'occupied' );

		        $('#car_of_worker_id_'+car_id).html('<span style="color:white">'+worker_name+'</span><span style="    color: white;position: relative;display: block;top: -12px;">'+spot_label+'</span>'); //add a span(spot label) on top of the car below worker.
				
				// ui.draggable.draggable( 'disable' );
				// $(slot1).droppable( 'disable' );
				ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left top' } );//pop it in
				// ui.draggable.draggable( 'option', 'revert', false );
	    
				// ui.draggable.draggable( 'enable' );
				// $(slot1).droppable( 'enable' );
			    // ui.draggable.draggable( 'option', 'revert', true );			
	    }else if (response_obj.data.status==="error"){
        		console.log("Error: "+response_obj.data.error_msg);
	       		$('#box').html("Error: "+response_obj.data.error_msg);

				ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left bottom' } );//pop it off
        }else{
        	console.log("Error: contact IT");
	       	$('#box').html("Error: contact IT");

			ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left bottom' } );//pop it off
        }

    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
		// ui.draggable.draggable( 'option', 'revert', true );
		ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left bottom' } );//pop it off

        // Log the error to the console
        console.error(
            "The following error occurred: " +
            textStatus, errorThrown
        );
        // $('#isCaptchaMatch').val('false');
        // $('.error_msg').html('请先输入正确的图片验证码 (please enter correct captha first)');
        // return;
    });

//----------------------------------------------------------------------------
	  // if ($(this).data('occupied')==false){
			
	  // } 
	   
	  // If all the cards have been placed correctly then display a message
	  // and reset the cards for another go
	 /*
	  if ( correctCards == 10 ) {
	    $('#successMessage').show();
	    $('#successMessage').animate( {
	      left: '380px',
	      top: '200px',
	      width: '400px',
	      height: '100px',
	      opacity: 1
	    } );
	  }
  */
}
 </script>
</head>
<body>
 
<div id="content" style="width:1765px;height:580px"><!--was 1400-->
	<!-- <div id="box">...</div> -->

	<div id="box">
		...
	</div>
	<div id="cardSlots"  style="display:inline;height:100%;float: left;margin:0px!important;width: 1592px;"> </div>
	<div id="cardPile"   style="display:inline;height:100%;float: right;width:85px;"> </div>
	


	<div id="successMessage">
		<h2>You did it!</h2>
		<button onclick="init()">Play Again</button>
	</div>
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

 	<script type="text/javascript">
	$(document).ready(function(){
	    $("#close_pop_up").click(function(){
	        document.getElementById("whole_pop_up_with_transparent").style.display="none";
	        // document.getElementById("fade").style.display="none";
	    });
	    $(".ui-draggable").click(function(){
	    	var worker_id=$(this).data('worker_id');
	    	var worker_name=$(this).data('worker_name');
	    	var department_id=$(this).data('department_id');//not used now
	    	var department_name=$(this).data('department_name');
	    	var assigned_spot_id=$(this).data('assigned_spot_id');
	    	var assigned_spot_label=$(this).data('assigned_spot_label');
	    	var car_model=$(this).data('car_model');
	    	//-------------make it user friendly by translating 108 and 4 to N/A-------------
	    	console.log(department_id);
	    	console.log(parseInt(department_id));
	    	if (parseInt(department_id)===4){
	    		//no department assigned yet. like Sam
	    		department_name='N/A';
	    	}
	    	if (parseInt(assigned_spot_id)===108){
	    		//no spot assigned to this worker yet. 
	    		assigned_spot_label='N/A';
	    	}
	    	//------------change all worker data on popup span-----------------------------------
	    	$('span.pop_up_worker_id').html(worker_id);//ids all start with pop_up
	    	$('span.pop_up_worker_name').html(worker_name);
	    	$('span.pop_up_department_name').html(department_name);
	    	$('span.pop_up_assigned_spot_id').html(assigned_spot_id);
	    	$('span.pop_up_assigned_spot_label').html(assigned_spot_label);
	    	$('span.pop_up_car_model').html(car_model);
	    	//------------change all worker data on popup input field----------------------------
	    	$('input.pop_up_worker_id').val(worker_id);//ids all start with pop_up
	    	$('input.pop_up_worker_name').val(worker_name);
	    	$('input.pop_up_department_name').val(department_name);
	    	$('input.pop_up_assigned_spot_id').val(assigned_spot_id);
	    	$('input.pop_up_assigned_spot_label').val(assigned_spot_label);
	    	$('input.pop_up_car_model').val(car_model);

	        document.getElementById("whole_pop_up_with_transparent").style.display="block";
	        // document.getElementById("fade").style.display="block";
	    })
	});
	</script>

	<style type="text/css">

		table.pop_up_table{
			width:600px;/*left cell 136px, right cell 440px*/
			border:1px;
			align:"center";
			cellpadding:4px;
			cellspacing:0px;
		}
		table.green2 {
		    border-width: 1px;
		    border-spacing: 0px;
		    border-style: inset;
		    border-color: #BBB99D;
		    border-collapse: collapse;
		    background-color: white;

		    margin: 0 auto;
		}
		table.green2 th {
		    border-width: 1px;
		    padding: 4px;
		    border-style: solid;
		    border-color: #BBB99D;
		    background-color: rgb(250, 240, 230);
		    background-color: #4EB106;
		    color: white;
		    -moz-border-radius: ;
		    span-family: Verdana;
		    span-size: 13px;
		    span-weight: 100;
		}

		table.green2 td {
		    border-width: 1px;
		    padding: 4px;
		    border-style: solid;
		    border-color: #BBB99D;
		    span-family: Verdana;
		    span-size: 13px;
		    span-weight: 100;
		    color: #404040;
		    -moz-border-radius: ;
		}
		.hidden{
			display:none;
		}
		#filter_close_button_wrapper{
			width: 100%;
    		height: 50px;
		}

		#close_pop_up{
			float: right;
		    width: 80px;
		    height: 30px;
		    padding: 13px 13px;
		}
		.d__black_overlay{
			display: none;
			/*position: absolute;*/
			position: fixed;/*This fills the whole screen even when scroll down*/
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		#whole_pop_up_with_transparent {

			width:100%;height:100%;
			/*background-color: black;*/
		    background-color: rgba(0,0,0,0.8);
			z-index:1001;
			/*-moz-opacity: 0.8;*/
			/*opacity:.80;*/
			/*filter: alpha(opacity=80);*/
			position:fixed;left:0%;top:0%;
			
			display: none;

			
		}

		#pop_up_itself{
			/*display: none;*/
			/*position: absolute;*/
			/*position: fixed;*/
			/*This make it in the same center place of the screen even when scroll down*/
			/*top: 25%;*/
			/*left: 25%;*/
			/*width: 50%;
			height: 50%;*/
			padding: 16px;
			/*border: 16px solid orange;*/
			border-radius: 20px;
			background-color: white;
			z-index:1002;
			overflow: auto;

			 margin: 0 auto;
		    width:800px; 
		    position:relative; 
		    top: 25%;

		    /*shadow*/
		     -webkit-box-shadow:0 0 10px rgba(0,0,0,0.4);
		    -moz-box-shadow:0 0 10px rgba(0,0,0,0.4); 
		    box-shadow:0 0 10px rgba(0,0,0,0.4);
		}
	</style>
	<!------------------finish pop up box----------------------\-->

</div>
 
</body>
</html>