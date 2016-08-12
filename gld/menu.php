<?php 
$aclin = $_SESSION['aclin']; 
$aclout = $_SESSION['aclout']; 
$aclinv = $_SESSION['aclinv']; 
$aclacct = $_SESSION['aclacct']; 
$aclport = $_SESSION['aclport'];
$aclroutingreport = $_SESSION['aclroutingreport'];
$aclpackinglist = $_SESSION['aclpackinglist'];
$username = $_SESSION['username'];
$su = $_SESSION['su'];
$cyear = date("Y"); 
?>
<!-- --------------------------------------------------------------------------------------------- /-->
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif
}
-->
</style>
<script type="text/javascript">
function checkForm(form) {
    var mailCheck = checkMail(form.elements['findme']);
    return mailCheck;
}

function checkMail(input) {
    var check = input.value.length >= 3;
    input.style.borderColor = check ? 'black' : 'red'; 
    return check;
}
</script>


<style type="text/css">
#login input {
    border: 2px solid black;
}
</style>
<script type="text/javascript">
$(function() 
{
$(".view_comments").click(function() 
{

var ID = $(this).attr("id");

$.ajax({
type: "POST",
url: "viewajax.php",
data: "msg_id="+ ID, 
cache: false,
success: function(html){
$("#view_comments"+ID).prepend(html);
$("#view"+ID).remove();
$("#two_comments"+ID).remove();
}
});

return false;
});
});
</script>
<style type="text/css">
#notemenu {
}
#notemenu a {
	display: block;
	width: 60px;
}
#notemenu ul {
	list-style-type: none;
}
#notemenu li {
	float: right;
	position: relative;
	text-align: center;
	padding-top:5px;
	z-index: 901;
}
#notemenu ul.sub-menu {
	position: absolute;
	left: -50px;
	z-index: 90;
	display:none;
}
#notemenu ul.sub-menu li {
	text-align: left;
}
#notemenu li:hover ul.sub-menu {
	display: block;
}
a
{	text-decoration:none; }

.egg{
position:relative;
box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
background-color:#fff;
border-radius: 3px 3px 3px 3px;
border: 1px solid rgba(100, 100, 100, 0.4);
}
.egg_Body{border-top:1px solid #D1D8E7;color:#808080;}
.egg_Message{font-size:13px !important;font-weight:normal;overflow:hidden}

h3{font-size:13px;color:#333;margin:0;padding:0}
.comment_ui
{
border-bottom:1px solid #e5eaf1;clear:left;float:none;overflow:hidden;padding:6px 4px 3px 6px;width:350px; cursor:pointer;
}
.comment_ui:hover{
background-color: #F7F7F7;
}
.dddd
{
background-color:#f2f2f2;border-bottom:1px solid #e5eaf1;clear:left;float:none;overflow:hidden;margin-bottom:2px;padding:6px 4px 3px 6px;width:350px; 
}
.comment_text{padding:2px 0 4px; color:#333333; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;}
.comment_actual_text{display:inline;padding-left:.4em}


ol { 
	list-style:none;
	margin:0 auto;
	width:500px;
	margin-top: 20px;
}
#mes{
	padding: 1px 4px;
	border-radius: 2px 2px 2px 2px;
	background-color: rgb(240, 61, 37);
	font-family:verdana,Helvetica,sans-serif;
	font-size: 9px;
	font-weight: normal;
	color: #fff;
	position: absolute;
	top: 5px;
	left: 39px;
}
.toppointer{
background-image:url(top.png);
    background-position: -82px 0;
    background-repeat: no-repeat;
    height: 11px;
    position: absolute;
    top: -15px;
    width: 20px;
	right: 311px;
	z-index:902;
}
.clean { display:none}

@media print
		{    
    	.no-print, .no-print *
    	{
        display: none !important;
    	}

</style>
<table id="company menu" width="100%" border="0" cellpadding="0" cellspacing="0">
<div class="no-print">
<div id="gld_header_block" style="position: relative; background: images/topborder.gif; width: (width)px; height: (height)px;">
  <img style="display:block; z-index:1" src="images/topborder.gif" width="100%" height="109"  />
  <div style="position: absolute; bottom: 0; left: 0.5em; width: 400px; font-weight: bold; color: #fff;">
<p></p>
</div>

<? 
if($su =='1')
{
print '<div id="notemenu" style="position: absolute; top: -12px; right: 280px; width: 250px; margin: 0;	padding: 0;">';
    print "<ul>
		<li>
			<a href=\"#\" style=\"padding:10px 0; outline:none;border: 0;\">
			<img src=\"images.png\" style=\"width: 36px; border: 0;\" />";
			
			require_once('connections/myDB.php');
				$sqlnote=mysql_query("select * from traker.comments");
				$comment_count=mysql_num_rows($sqlnote);
				if($comment_count!=0)
				{
				echo '<span id="mes">'.$comment_count.'</span>';
				}
	print "</a><ul class=\"sub-menu\">";
			$msql=mysql_query("select * from traker.messages order by msg_id desc");
			while($messagecount=mysql_fetch_array($msql))
			$id=$messagecount['msg_id'];
			$msgcontent=$messagecount['message'];
	print "<li class=\"egg\"><div class=\"toppointer\"><img src=\"top.png\" /></div>";
				$sql=mysql_query("select * from traker.comments where msg_id_fk='$id' order by com_id");
				$comment_count=mysql_num_rows($sql);
				if($comment_count>20)
				{
				$second_count=$comment_count-20;
				} 
				else 
				{
				$second_count=0;
				}
	print "<div id=\"view_comments".$id."\"></div><div id=\"two_comments". $id."\">";
				$listsql=mysql_query("select * from traker.comments where msg_id_fk='$id' order by com_id limit $second_count,8 ");
				while($rowsmall=mysql_fetch_array($listsql))
				{ 
				$c_id=$rowsmall['com_id'];
				$comment=$rowsmall['comments'];
				$url=$rowsmall['url'];
	print "<div class=\"comment_ui\"><div class=\"comment_text\">
				<div  class=\"comment_actual_text\"><a href=\"$url\" style=\"display:inline;padding-left:.4em\">$comment</a></div>
				</div>
				</div>";
				}
	print "<div class=\"bbbbbbb\" id=\"view".$id."\"></div>";
	print "</li>
		   </ul>
	  	   </li>
		   </ul>
		   </div>";
}
		   
?>
<p align="left" class="style1 style1" style="position: absolute; top: -1px; right: 11px; width: 250px; padding: 4px; ; font-weight: 100; font-size: 11px; color:black; font:Verdana; height: 88px;">
&nbsp;5388 Arrow Highway<br />
&nbsp;Montclair, CA 91763  USA</br>&nbsp;Tel: 909-399-9688   Fax: 909-399-9699</br>&nbsp;Email: info@gld-usa.com
<?
if($su =='1')
{
print '
<form id="ui_element" method="post" action="search_results.php" style="z-index:900;" onsubmit="return checkForm(this)">
<input type="text" name="findme" id="findme" onkeyup="checkMail(this)">
<input class="sb_search" type="submit" value="All"></form><br>&nbsp;<font color="white">Search Cannot be Blank</font>
';
}
?>
</p>

  <h3 align="left" style="display:block; position:absolute; width:414px; top:70px; left:51px; z-index:2; text-align:left; color: white; font: 13px Verdana;"><span class="style4"></span>
  <?php 
  if($username != "GLD_"){
  echo "Login as:"; 
  echo $username; 
  echo " | "; 
  echo date("F j, Y, g:i a"); 
  }
  ?></h3>
  <h3 align="left" style="display:block; position:absolute; width:293px; top:10px; left:37px; z-index:2; text-align:left; color: white; font: 13px Verdana; background-image: url(images/GLD-Website---Logo.png); height: 57px;"><span class="style4"></span></h3>
  <ul class="menu">
	<li class="top"><a href="#" class="top_link"><span>Warehouse</span></a>
    	<?php if($aclinv == '1'){
		print '<ul class="sub">
			<li>
			  <div align="left"><a href="inventory_style.php">Inventory Summary</a></div>
			</li>			
			<li>
			  <div align="left"><a href="inventory_act.php">Inventory Activity</a></div>
			</li>
            <li>
              <div align="left"><a href="inventory_cartons.php">Inventory by Cartons</a></div>
            </li>
			<li>
              <div align="left"><a href="inventory_style_update.php">Inventory Location</a></div>
            </li>
      </ul>';}?>
	</li>
	<li class="top"><a href="#" class="top_link"><span>Inbound <? //print $aclpackinglist;?></span></a>
    <ul class="sub">
    	<?php if($aclin =='1'){print '
			<li>
		    <div align="left"><a href="inbound2.php">Receiving Report</a></div>
		  	</li>	
			<li>
              <div align="left"><a href="inbound_inwork.php">Receiving In Work</a></div>
            </li>		
            <li>
              <div align="left"><a href="inbound_fc2.php">Receiving Forcast</a></div>
            </li>';
			
		  	if($su =='1'){
			print '
			<li>
              <div align="left"><a href="inbound_ytd.php">Receiving Year To Date</a></div>
            </li>';
			}
			if($su =='1'){
			print '
			<li>
			  <div align="left"><a href="inbound_customer_date.php">Receiving By End Buyer</a></div>
			</li>';
				}
			if($su =='1'){
			print '
			<li>
			  <div align="left"><a href="inbound_update.php">Receiving Update + CSV</a></div>
			</li>	
			';}
			if($su =='1'){
			print '
			<li>
			  <div align="left"><a href="inbound_dates_csv.php">Receiving Batch CSV</a></div>
			</li>	
			';}
	print "<li>
			<div align=\"left\">
			<a href=\"javascript: void(0)\" onclick=\"window.open('2/fileupload_inboundcsv.php'
                          ,'newWin','width=600,height=450,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No')\">CSV Converter</a>
			</div>
			</li>";
	print '
			<li>
			  <div align="left"><a href="inbound_search_results.php">Inbound Search All</a></div>
			</li>	
			';		
			}
			if($aclpackinglist =='1'){ print'
			<li>
			  <div align="left"><a href="http://portal.gld-usa.com/luxcal/index.php" target="_blank">Trucking Schedule</a></div>
			</li>
			<li>
		    <div align="left"><a href="inbound_pl.php">Receiving Packing List</a></div>
		  	</li>
			<li>
		    <div align="left"><a href="resend_flatfile.php">Resend Flatfile</a></div>
		  	</li>';
			}
	print '</ul>';?>
			
 	
	</li>
	<li class="top"><a href="#" class="top_link"><span>Outbound</span></a>
    	<?php if($aclout =='1'){
		print '
		<ul class="sub">
			<li>
			  <div align="left"><a href="order.php">Release Report</a></div>
			</li>
			<li>
			  <div align="left"><a href="outbound_shipping3.php">Outbound Shipping</a></div>
			</li>';
			if($su =='1'){
			print '
			<li>
              <div align="left"><a href="order_ytd.php">Release Year To Date</a></div>
            </li>
			<li>
              <div align="left"><a href="reunited_shipping_csv.php">Reunited CSV Maker</a></div>
            </li>';
			}
			print '	
			<li>
              <div align="left"><a href="walmartloads.php">Walmart Load Report</a></div>
            </li>			
            <li>
              <div align="left"><a href="forward_pick.php">Forward Picking</a></div>
            </li>		
            <li>
              <div align="left"><a href="order_open.php">Open Release / Schedule</a></div>
            </li>
			<li>
              <div align="left"><a href="order_schedule.php">Outbound Scheduler</a></div>
            </li>
			<li>
              <div align="left"><a href="search_results3.php">Pickup Schedule</a></div>
            </li>';
			/*if($aclroutingreport =='1'){
			print '
			<li>
			  <div align="left"><a href="order_routingguides.php">Routing Guides</a></div>
			</li>
				
			';}*/
			if($su =='1'){
			print '
			<li>
              <div align="left"><a href="palletpaper.php">Create Pallet Paper</a></div>
            </li>
			<li>
              <div align="left"><a href="palletpaper2.php">Create Pallet Paper Manually</a></div>
            </li>';
			}
			
          ?>
 		
        <li>
        <div align="left"><a href="javascript: void(0)" onclick="window.open('2/fileupload_outboundcsv.php','newWin','width=600,height=450,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No')">CSV Converter</a></div></li>
        <li>
        <div align="left"><a href="javascript: void(0)" onclick="window.open('2/fileupload_outboundcsv2.php','newWin','width=600,height=450,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No')">CSV Converter 1 Release #</a></div></li>
	<? print "<li>
        <div align=\"left\"><a href=\"javascript: void(0)\" onclick=\"window.open('2/contentlabel_sears.php','newWin','width=750,height=490,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No')\">Sears Content Label</a></div></li>";
	print "<li>
        <div align=\"left\"><a href=\"javascript: void(0)\" onclick=\"window.open('2/contentlabel_macy.php','newWin','width=750,height=490,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No')\">Macy Content Label</a></div></li>";   	

print '</ul>';}?>
	</li>
    <!--
    <li class="top">
    <a href="" class="top_link""><span>Work Order</span></a>
    <ul class="sub">
    	<li>
		    <div align="left"><a href="">Work Order Summary</a></div>
		  </li>	
		  <li>
		    <div align="left"><a href="">Add Work Order</a></div>
		  </li>			
    </ul>
    </li>
    -->
     <?php if($aclroutingreport =='1'){
	print '
    <li class="top">
    <a class="top_link"><span>Reports</span></a>
    <ul class="sub">
		<li><div align="left"><a href="reports_dv.php">Outbound Pick Sheet</a></div></li>
        ';
	
print '</ul>
    </li>';}?>
	<li class="top"><a href="#" class="top_link"><span>Accounting</span></a>
    	<?php if($aclacct =='1'){
		print '
		<ul class="sub">
			<li>
			  <div align="left"><a href="acct.php">Invoice Report</a></div>
			</li>			
            <li>
              <div align="left"><a href="acct_open2.php">Unpaid Invoices</a></div>
            </li>
			<li>
              <div align="left"><a href="acct_open3.php">Short Paid Invoices</a></div>
            </li>
			<li>
              <div align="left"><a href="acct_inventory.php">Accounting Inventory Export</a></div>
            </li>
			<li>
              <div align="left"><a href="acct_storage.php">Accounting Storage</a></div>
            </li>
          <li><div align="left">
		  <a href="javascript: void(0)" onclick="window.open(\'http://192.168.0.8/update_invoices.php\',\'newWin\',\'width=300,height=250,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No\')">Update Invoice Data</a></div>
		  </li><li>';
		   
        print "<div align=\"left\"><a href=\"javascript: void(0)\" onclick=\"window.open('2/fileupload_acctar.php','newWin','width=600,height=450,left=300,top=300,toolbar=No,location=No,scrollbars=no,status=No,resizable=no,fullscreen=No')\">Etraker AR CSV</a></div></li>
 		</ul>";
		}?>
        </li>
        
    <li class="top">
    <a href="http://portal.gld-usa.com/asnv2/index.php" class="top_link""><span>ASN</span></a>
    </li>
    <?php if($aclport =='1'){
	print '
    <li class="top">
    <a class="top_link"><span>Portal</span></a>
    <ul class="sub">
		<li>
		<div align="left"><a href="Adduserform.php">Add User</a></div>
			
        <li>
        <div align="left"><a href="acct_open.php">Edit / Delete User</a></div>
        </li>
        <li>
        <div align="left"><a href="acct_open.php">Change Password</a></div>
        </li>';
	
print '</ul>
    </li>';}?>
     <li class="top">
    <a href="http://portal.gld-usa.com/V2/WP/2D.php" class="top_link""><span>Parking</span></a>
    </li>
     <li class="top"><a href="start.php" class="top_link"><span>Upload Files</span></a>
	 </li>
    <li class="top"><a href="logout.php" class="top_link"><span>Logout</span></a>
	 </li>
</ul>

</div>
</div>
<!-- end main menu /-->
<!-- --------------------------------------------------------------------------------------------- /-->


