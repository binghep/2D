<?php

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

//--------------------get a list of workers objects-------------------
$workers=new workers($db_handle);
//--------------------get a list of parking spot objects-------------------
$parking_spots_table=new parking_spots_table($db_handle);
// var_dump($parking_spots_table->all_rows);//each array element is like:
//array(2) { ["id"]=> string(1) "1" ["spot_label"]=> string(1) "1" }
//--------------------replace 1...10 by worker names, cardID by worker id-----------------------

//--------------------replace slots name to parking spot label--------------------------

?>
<!doctype html>
<html lang="en">
<head>
 
<title>2D Parking</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" href="style_6.css">
 
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
  //   $('<div>' + numbers[i] + '</div>').data( 'number', numbers[i] ).attr( 'id', 'card'+numbers[i] ).appendTo( '#cardPile' ).draggable( {
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
  
    foreach ($workers->all_workers as $worker){
        array_push($worker_names, $worker->worker);
        array_push($worker_ids, $worker->id);
    }

    $worker_names_js='["' . implode('", "', $worker_names) . '"]';//to be used by js
    $worker_ids_js='["' . implode('", "', $worker_ids) . '"]';//to be used by js
  ?>
  var worker_ids=<?php echo $worker_ids_js?>;
  var worker_names=<?php echo $worker_names_js?>;
  var arrayLength = worker_ids.length;
  // for ( var i=0; i<10; i++ ) {
  //   $('<div>' + numbers[i] + '</div>').data( 'number', numbers[i] ).attr( 'id', 'card'+numbers[i] ).appendTo( '#cardPile' ).draggable( {
  //     containment: '#content',
  //     stack: '#cardPile div',
  //     cursor: 'move',
  //     revert: false
  //   } );
  // }

  for (var i = 0; i < arrayLength; i++) {
      $('<div>' + worker_names[i] + '</div>').data( 'worker_id', worker_ids[i] ).attr( 'id', 'card'+worker_ids[i] ).appendTo( '#cardPile' ).draggable( {
      containment: '#content',
      stack: '#cardPile div',
      cursor: 'move',
      revert: false
    } );
  }

  //====================Create the car slots=====================
  //====================east: 60-50==============================
  <?php
    $east_region_1_spot_id=array();
    $east_region_1_spot_label=array(60,59,58,57,56,55,53,52,51,50);//54 not exist

    //build the $east_region_1_spot_id array accroding to $east_region_1_spot_label array:
    foreach ($east_region_1_spot_label as $label) {
      $spot_id=getSpotIdByLabel((string)$label,$parking_spots_table);
      if ($spot_id!==false){
        array_push($east_region_1_spot_id, $spot_id);
      }else{
        echo 'weird';
      }
    }

    $e_r1_labels='["' . implode('", "', $east_region_1_spot_label) . '"]';//to be used by js
    $e_r1_ids='["' . implode('", "', $east_region_1_spot_id) . '"]';//to be used by js

  ?>
  // var spots_labels = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
  var spots_labels=<?php echo $e_r1_labels ?>;
  var spots_ids=<?php echo $e_r1_ids ?>;

  var arrayLength = spots_ids.length;
  for (var i = 0; i < arrayLength; i++) {
      // alert(myStringArray[i]);
      //Do something
      $('<div>' + spots_labels[i] + '</div>').data( 'spot_id', spots_ids[i] ).appendTo( '#cardSlots' ).droppable( {
      accept: '#cardPile div',
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );
  }
  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 39-32==============================
  <?php
    $east_region_1_spot_id=array();
    $east_region_1_spot_label=array(39,38,37,36,35,33,32);//34 not exist

    //build the $east_region_1_spot_id array accroding to $east_region_1_spot_label array:
    foreach ($east_region_1_spot_label as $label) {
      $spot_id=getSpotIdByLabel((string)$label,$parking_spots_table);
      if ($spot_id!==false){
        array_push($east_region_1_spot_id, $spot_id);
      }else{
        echo 'weird';
      }
    }


    $e_r1_labels='["' . implode('", "', $east_region_1_spot_label) . '"]';//to be used by js
    $e_r1_ids='["' . implode('", "', $east_region_1_spot_id) . '"]';//to be used by js

  ?>
  // var spots_labels = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
  var spots_labels=<?php echo $e_r1_labels ?>;
  var spots_ids=<?php echo $e_r1_ids ?>;

  var arrayLength = spots_ids.length;
  for (var i = 0; i < arrayLength; i++) {
      // alert(myStringArray[i]);
      //Do something
      $('<div>' + spots_labels[i] + '</div>').data( 'spot_id', spots_ids[i] ).appendTo( '#cardSlots' ).droppable( {
      accept: '#cardPile div',
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );
  }
  //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 31-21==============================
  <?php
    $east_region_1_spot_id=array();
    $east_region_1_spot_label=array(31,30,29,28,27,26,25,23,22,21);//24 not exist

    //build the $east_region_1_spot_id array accroding to $east_region_1_spot_label array:
    foreach ($east_region_1_spot_label as $label) {
      $spot_id=getSpotIdByLabel((string)$label,$parking_spots_table);
      if ($spot_id!==false){
        array_push($east_region_1_spot_id, $spot_id);
      }else{
        echo 'weird';
      }
    }


    $e_r1_labels='["' . implode('", "', $east_region_1_spot_label) . '"]';//to be used by js
    $e_r1_ids='["' . implode('", "', $east_region_1_spot_id) . '"]';//to be used by js

  ?>
  // var spots_labels = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
  var spots_labels=<?php echo $e_r1_labels ?>;
  var spots_ids=<?php echo $e_r1_ids ?>;

  var arrayLength = spots_ids.length;
  for (var i = 0; i < arrayLength; i++) {
      // alert(myStringArray[i]);
      //Do something
      $('<div>' + spots_labels[i] + '</div>').data( 'spot_id', spots_ids[i] ).appendTo( '#cardSlots' ).droppable( {
      accept: '#cardPile div',
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );
  }
   //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 20-12==============================
   <?php
    $east_region_1_spot_id=array();
    $east_region_1_spot_label=array(20,19,18,17,16,15,13,12);//14 not exist

    //build the $east_region_1_spot_id array accroding to $east_region_1_spot_label array:
    foreach ($east_region_1_spot_label as $label) {
      $spot_id=getSpotIdByLabel((string)$label,$parking_spots_table);
      if ($spot_id!==false){
        array_push($east_region_1_spot_id, $spot_id);
      }else{
        echo 'weird';
      }
    }


    $e_r1_labels='["' . implode('", "', $east_region_1_spot_label) . '"]';//to be used by js
    $e_r1_ids='["' . implode('", "', $east_region_1_spot_id) . '"]';//to be used by js

  ?>
  // var spots_labels = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
  var spots_labels=<?php echo $e_r1_labels ?>;
  var spots_ids=<?php echo $e_r1_ids ?>;

  var arrayLength = spots_ids.length;
  for (var i = 0; i < arrayLength; i++) {
      // alert(myStringArray[i]);
      //Do something
      $('<div>' + spots_labels[i] + '</div>').data( 'spot_id', spots_ids[i] ).appendTo( '#cardSlots' ).droppable( {
      accept: '#cardPile div',
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );
  }
   //====================bush=====================================
  $('<div class="bush"></div>').appendTo('#cardSlots');
  //====================east: 11-1==============================
     <?php
    $east_region_1_spot_id=array();
    $east_region_1_spot_label=array(11,10,9,8,7,6,5,3,2,1);//4 not exist

    //build the $east_region_1_spot_id array accroding to $east_region_1_spot_label array:
    foreach ($east_region_1_spot_label as $label) {
      $spot_id=getSpotIdByLabel((string)$label,$parking_spots_table);
      if ($spot_id!==false){
        array_push($east_region_1_spot_id, $spot_id);
      }else{
        echo 'weird';
      }
    }


    $e_r1_labels='["' . implode('", "', $east_region_1_spot_label) . '"]';//to be used by js
    $e_r1_ids='["' . implode('", "', $east_region_1_spot_id) . '"]';//to be used by js

  ?>
  // var spots_labels = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
  var spots_labels=<?php echo $e_r1_labels ?>;
  var spots_ids=<?php echo $e_r1_ids ?>;

  var arrayLength = spots_ids.length;
  for (var i = 0; i < arrayLength; i++) {
      // alert(myStringArray[i]);
      //Do something
      $('<div>' + spots_labels[i] + '</div>').data( 'spot_id', spots_ids[i] ).appendTo( '#cardSlots' ).droppable( {
      accept: '#cardPile div',
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );
  }

  //====================east: 61-66==============================
  //====================east: 67-75==============================
  //====================east: 76-86==============================
  //====================east: 87-92==============================
 


}
 
</script>
 
 <script type="text/javascript">
 var request;
 function handleCardDrop( event, ui ) {
	  var slotNumber = $(this).data( 'spot_id' );
	  var cardNumber = ui.draggable.data( 'worker_id' );
	 
	  // If the card was dropped to the correct slot,
	  // change the card colour, position it directly
	  // on top of the slot, and prevent it being dragged
	  // again
	 
	  // if ( slotNumber == cardNumber ) {
//-------------------ajax checking if the spot has owner---------------------
	var slot1=this;
    // Variable to hold request
  
	if (request){
        request.abort();
    }
    request= $.ajax({
        url:"check_if_occupied.php",
        type: "get",
        data: {'parking_spot_id': slotNumber}
    });
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        //console.log("Hooray, it worked, got response!");
        console.log(response);
        /*only has 3 possibilities: 
		"(1)spot id not valid"
		"(2)occupied"
		"(3)not occupied"
        */
        var response_obj=JSON.parse(response);
        // console.log(response_obj.is_valid_query);
        if (response_obj.is_valid_query===true){
        	if (response_obj.data.is_occupied===true){
        		console.log("Not OK (Already taken)");
	           	$('#box').html("Not OK (Already taken)");

				// ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left top' } );
				ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left bottom' } );//pop it off
				// ui.draggable.draggable( 'option', 'revert', true );//switched from false to true
        	}else if (response_obj.data.is_occupied===false){
        			//empty and can be occupied now
	           	console.log("OK");
	           	$('#box').html('OK');
	           	// $(slot1).data('occupied',true);
				// ui.draggable.addClass( 'correct' );
				console.log(ui);
				// ui.draggable.draggable( 'disable' );
				// $(slot1).droppable( 'disable' );
				ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left top' } );//pop it in
				// ui.draggable.draggable( 'option', 'revert', false );
	    
				// ui.draggable.draggable( 'enable' );
				// $(slot1).droppable( 'enable' );
			    // ui.draggable.draggable( 'option', 'revert', true );			
	        }else{
	        	console.log("weird. param not true or false");
	       		$('#box').html("weird. param not true or false");
				ui.draggable.position( { of: $(slot1), my: 'left top', at: 'left bottom' } );//pop it off

	        }
        }else{//spot id is not valid/does not exist. 
       		console.log("param id not valid. spot id does not exist.");
	        $('#box').html("param id not valid. spot id does not exist.");
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
 
<div id="content" style="width:1765px;height:1400px">
	<div id="box">...</div>
	<div id="cardSlots"  style="display:inline;height:100%;float: left;margin:0px!important;width: 1592px;"> </div>
	<div id="cardPile"   style="display:inline;height:100%;float: right;width:85px;"> </div>
	
	<div id="successMessage">
		<h2>You did it!</h2>
		<button onclick="init()">Play Again</button>
	</div>
 
</div>
 
</body>
</html>