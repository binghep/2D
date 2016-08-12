$(document).ready(function(){
	 if (is_IE() || is_safari()){
        $("#btnSave2").hide();
        $("#vertical_delimiter2").hide();
      }

      $("#top_right_menu").show();
})



function is_IE(){
	var ms_ie = false;
	var ua = window.navigator.userAgent;
	var old_ie = ua.indexOf('MSIE ');
	var new_ie = ua.indexOf('Trident/');

	if ((old_ie > -1) || (new_ie > -1)) {
	    ms_ie = true;
	}
	return ms_ie;//true or false
	// if ( ms_ie ) {
	    //IE specific code goes here
	// }
}

function is_safari(){
	// var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)
	// return isSafari;

  var is_chrome = window.navigator.userAgent.indexOf('Chrome') > -1;
	var is_explorer = window.navigator.userAgent.indexOf('MSIE') > -1;
	var is_firefox = window.navigator.userAgent.indexOf('Firefox') > -1;
	var is_safari = window.navigator.userAgent.indexOf("Safari") > -1;
	var is_opera = window.navigator.userAgent.toLowerCase().indexOf("op") > -1;
	if ((is_chrome)&&(is_safari)) {is_safari=false;}
	if ((is_chrome)&&(is_opera)) {is_chrome=false;}
	// alert(is_safari);
	return is_safari;
}
