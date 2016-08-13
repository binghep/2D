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
	    $('#box').html("ERROR: cannot remove assigned spot for this worker. Ajax request failed. ");

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