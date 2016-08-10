<?php
require "database/dbcontroller.php";
require "model/workers.php";
require "model/parking_spots_table.php";
$db_handle=new DBController();

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
<link rel="stylesheet" type="text/css" href="style.css">
 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
 <style type="text/css">
 	#content{
 		width:1774px;
 	}

 </style>
<script type="text/javascript">
 
var correctCards = 0;
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
  correctCards = 0;
  $('#cardPile').html( '' );
  $('#cardSlots').html( '' );
 
  // Create the pile of shuffled cards
  var numbers = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ];
  numbers.sort( function() { return Math.random() - .5 } );
 
  for ( var i=0; i<10; i++ ) {
    $('<div>' + numbers[i] + '</div>').data( 'number', numbers[i] ).attr( 'id', 'card'+numbers[i] ).appendTo( '#cardPile' ).draggable( {
      containment: '#content',
      stack: '#cardPile div',
      cursor: 'move',
      revert: true
    } );
  }
 
  // Create the card slots
  var words = [ 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten' ];
  for ( var i=1; i<=10; i++ ) {
    $('<div>' + words[i-1] + '</div>').data( 'number', i ).appendTo( '#cardSlots' ).droppable( {
      accept: '#cardPile div',
      hoverClass: 'hovered',
      drop: handleCardDrop
    } );
  }
 
}
 
</script>
 
 <script type="text/javascript">
 	
 function handleCardDrop( event, ui ) {
	  var slotNumber = $(this).data( 'number' );
	  var cardNumber = ui.draggable.data( 'number' );
	 
	  // If the card was dropped to the correct slot,
	  // change the card colour, position it directly
	  // on top of the slot, and prevent it being dragged
	  // again
	 
	  // if ( slotNumber == cardNumber ) {
	    // ui.draggable.addClass( 'correct' );
	    ui.draggable.draggable( 'disable' );
	    $(this).droppable( 'disable' );
	    ui.draggable.position( { of: $(this), my: 'left top', at: 'left top' } );
	    ui.draggable.draggable( 'option', 'revert', false );
	    
      ui.draggable.draggable( 'enable' );
      $(this).droppable( 'enable' );
	    // ui.draggable.draggable( 'option', 'revert', true );


      // correctCards++;
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
	<div id="cardSlots"  style="display:inline;height:100%;float: left;margin:0px!important;width:1477px;"> </div>
	<div id="cardPile"   style="display:inline;height:100%;float: right;width:200px;"> </div>
	
	<div id="successMessage">
		<h2>You did it!</h2>
		<button onclick="init()">Play Again</button>
	</div>
 
</div>
 
</body>
</html>