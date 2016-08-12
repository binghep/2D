<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" media="all" href="calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="calendar.js"></script>
<script type="text/javascript" src="lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar-setup.js"></script>
<title>GLD</title>
<link rel="stylesheet" href="menu_style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />
<!--[if IE ]>
<link rel="stylesheet" type="text/css" href="iecsshorizontalmenu.css">
<![endif]-->


<style type="text/css">

body {
	background-image: url("./share/images/bk.jpg");
}

</style>
<link href="./share/style.css" rel="stylesheet" type="text/css">

<style type="text/css">

a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.style2 {
	font-size: xx-small;
	font-family: Genava, Arial, Helvetica, sans-serif;
}

</style>
</head>
<?php

require_once('connections/myDB.php');
// include("./includes/header.html");
if (!isset($_SESSION['webuserID'])) {

	// Start defining the URL.
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	// Check for a trailing slash.
	if ((substr($url, -1) == '/') OR (substr($url, -1) == '\\') ) {
		$url = substr ($url, 0, -1); 
	}
	$url .= '/login_error.php'; // Add the page.
	header("Location: $url");
	exit(); // Quit the script.

}

?>
<body style="margin:0px !important;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

<center>
<table width="95%" cellpadding="0" cellspacing="0" border="0">
<tr>
		<td width="1" valign="top"><img src="./share/images/838A7B.gif" height="1143" width="1"></td>
      	<td valign="top" width="100%">

<!-- top utility menu  /-->

<?php //include("topheader.php"); ?>
<!-- end top utility menu /-->


<!-- company menu /-->
<?php include("menu.php"); ?>
<?php 
$username = $_SESSION['username'];
$sql = "select buyer_access.buyer_name, buyer_access.buyer_id
from traker.buyer_access where buyer_access.userid = '$username'";
$result0 = mysql_query($sql); ?> 
<!-- end main menu /-->
<!-- --------------------------------------------------------------------------------------------- /-->
<!-- main article /-->
<?php 
$default = $_SESSION['default'];
$acl = $_SESSION['acl'];
$su = $_SESSION['su'];
//echo $username;
?>
 <!-- <iframe src="http://awe.1661hk.cn/alice/2D/index_add_top.php" width="100%" height="100%" style="border:none"></iframe> -->
 <table class="hide_overflow" border=0 cellspacing=0 cellpadding=0 id="hold_my_iframe">
 <iframe  scrolling="no" src="http://www.1661hk.com/alice/2D/index_add_top.php" width="100%" height="870px" style="border:none;overflow:hidden;"></iframe>
</table>

<style type="text/css">
	#hold_my_iframe { padding:0px; margin:0 auto; width: 100%; height: 100% ; overflow: hidden;}


</style>
<!-- --------------------------------------------------------------------------------------------- /-->	
<!-- bottom term of use /-->

<!-- end bottom term of use /-->		
		<td width="1" valign="top"><img src="./share/images/838A7B.gif" height="1600" width="1"></td>
	</tr>
</table>
</body>
</html>
