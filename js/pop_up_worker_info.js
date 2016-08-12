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