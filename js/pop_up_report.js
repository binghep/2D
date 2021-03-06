	$(document).ready(function(){
	    $("#close_pop_up3").click(function(){
	        document.getElementById("whole_pop_up_with_transparent3").style.display="none";
	        // document.getElementById("fade").style.display="none";
	    });


	    var request;
	    $("#open_report").click(function() {
    		if (request){
                request.abort();
            }
            request= $.ajax({
                url:"get_html_content_for_report_pop_up.php",
                type: "get",
                data: {'select_department_id': ""}
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                console.log(response);
                var response_obj=JSON.parse(response);
                if (response_obj.data.status=='ok'){
                    console.log("successfully get pop up html from ajax. ");
                    $('#report_div_to_fill').html(response_obj.data.content);
                    document.getElementById("whole_pop_up_with_transparent3").style.display="block";
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
	    	// $("#whole_pop_up_with_transparent3").show();
	    });
	});