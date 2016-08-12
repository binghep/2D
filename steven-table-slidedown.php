<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type="text/javascript" src="js/show_box_left.js"></script>
    <script type="text/javascript" src="js/show_box_center.js"></script>
    <link rel="stylesheet" type="text/css" href="css/linenav.css"/>
    <script src="jquery.min.js" type="text/javascript"></script>
    <!--[if IE ]>
    <link rel="stylesheet" type="text/css" href="iecsshorizontalmenu.css">
    <![endif]-->

    <style type="text/css">
        <!--
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

        -->
    </style>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        span.reference {
            position: fixed;
            left: 10px;
            bottom: 10px;
            font-size: 11px;
        }

        span.reference a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            text-shadow: 0 1px 0 #000;
        }

        span.reference a:hover {
            color: #f0f0f0;
        }

        .box {
            margin: 0px auto 0 auto;
            height: 120px;
            width: 100%;
            position: absolute;
            -moz-box-shadow: 0px 0px 5px #444;
            -webkit-box-shadow: 0px 0px 5px #444;
            box-shadow: 0px 0px 5px #444;
            background: #1783BF;
        }

        .box h2 {
            background-color: #1275AD;
            border-color: #0E5A85 #0E5A85 #0E5A85;
            border-style: ridge ridge solid;
            border-width: 1px;
            color: #FFFFFF;
            font-size: 22px;
            padding: 10px;
            text-shadow: 1px 1px 1px #000000;
        }

        .bottombox {
            margin: 150px auto 0 auto;
            height: 100%;
            width: 100%;
            position: absolute;
            -moz-box-shadow: 0px 0px 5px #444;
            -webkit-box-shadow: 0px 0px 5px #444;
            box-shadow: 0px 0px 0px #444;
            background: #fff;
            z-index: -1;
        }

    </style>
    <style type="text/css">
        body1 {
            font-family: Verdana;
            font-size: 0.8em;
        }

        #report1 {
            border-collapse: collapse;
        }

        #report1 h4 {
            margin: 0px;
            padding: 0px;
        }

        #report1 img {
            float: right;
        }

        #report1 ul {
            margin: 10px 0 10px 40px;
            padding: 0px;
        }

        #report1 th {
            border-width: 1px;
            padding: 4px;
            border-style: solid;
            border-color: #CDCDCD;
            background-color: #E8F2E5;
            color: #3D3D3D;
            -moz-border-radius:;
            font-family: Verdana;
            font-size: 11px;
            font-weight: 100;
        }

        #report1 td {
            border-width: 1px;
            padding: 4px;
            border-style: solid;
            border-color: #BBB99D;
            font-family: Verdana;
            font-size: 11px;
            font-weight: 100;
            color: #3D3D3D;
            -moz-border-radius:;
            height: 0px;
        }

        #report1 tr.odd td {
            border-width: 1px;
            padding: 4px;
            border-style: solid;
            border-color: #BBB99D;
            font-family: Verdana;
            font-size: 11px;
            font-weight: 100;
            color: #3D3D3D;
            -moz-border-radius:;
        }

        #report1 div.arrow {
            background: transparent url(arrows.png) no-repeat scroll 0px -16px;
            width: 16px;
            height: 16px;
            display: block;
        }

        #r1 {
            display: none;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>
<script type="text/javascript">
    $("#report1 tr:odd").addClass("odd");
    $("#report1 tr:not(.odd)").hide();
    $("#report1 tr:first-child").show();

    $(document).ready(function () {
        $(".message_head").live("click", function () {
            $("." + this.id).slideToggle("slow");

            $(this).toggleClass("active");

            $(this).find(".arrow").toggleClass("up");

        });
        //$("#report").jExpand();
    });
</script>
<body>
<!-------------------------PUT EVERYTHING IN HERE---------------------------------->

<div align="center" class="bottombox">
    <style>
        h2 {
            position: absolute;
            left: 25px;
            top: -15px;
            text-align: left;
            color: black;
            font: 13px Verdana;
        }
    </style>
    <style>
        label {
            width: 70px;
            font-weight: 100;
            margin-top: 3px;
        }
    </style>
    <style>
        h5 {
            position: absolute;
            left: 200px;
            top: -16px;
            text-align: left;
            font: 13px Verdana;
        }
    </style>
    </br>

    <h3 align="right"
        style="position:absolute; width:130px; top:-15px; right:25px; z-index:2; text-align:left; color: black; font: 13px Verdana; ">
        <span class="style4"></span>
        <a href="http://portal.gld-usa.com/v2/wp/iPZMall_1661/info_csv.php?year=2016&month=0" style="target-new: tab;">Export</font></a>
    </h3>
    <table id='report1' width='80%' align="center" style="border-collapse:collapse">
        <tr>
            <th><strong>#</strong></th>
            <th><strong>Account</strong></th>
            <th><strong>Orders</strong></th>
            <th><strong>Gross</strong></th>
            <th><strong>Pcs</strong></th>
            <th><strong>Paypal Fee</strong></th>
            <th><strong>Shipping Fee</strong></th>
            <th><strong>+</strong></th>
        </tr>
        <tr>
            <td align='center'>1</td>
            <td style='background:#fff  repeat-x scroll center center; ' align='left'>iPZMall</td>
            <td style='background:#fff  repeat-x scroll center center; ' align='right'>324</td>
            <td style='background:#fff  repeat-x scroll center center; ' align='right'>$36320.12</td>
            <td style='background:#fff  repeat-x scroll center center; ' align='right'>336</td>
            <td style='background:#fff  repeat-x scroll center center; ' align='right'>-$1102.45</td>
            <td style='background:#fff  repeat-x scroll center center; ' align='right'>-$1249.03</td>
            <td style='background:#fff  repeat-x scroll center center; cursor:pointer;' align='center'>
                <a class='message_head' id='31'>
                    <div class='arrow'></div>
                </a></td>
        </tr>
        <tr>
            <td colspan='8' style="border-collapse:collapse;background-color:#F8F8F8;">
                <div class='31' id='r1'>
                    <table border="0" width="100%" style="border-collapse:collapse;background-color:#fff;">
                        <tr>
                            <th>Month</th>
                            <th># of orders</th>
                            <th>Gross</th>
                            <th>Total Pcs</th>
                            <th>Paypal Fee</th>
                            <th>Shipping Fee</th>
                            <th>Details</th>

                        </tr>
                        here
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Jan</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>View</font></div>
                            </td>
                        </tr>
                        here
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Feb</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>View</font></div>
                            </td>
                        </tr>
                        here
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Mar</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>0</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>View</font></div>
                            </td>
                        </tr>
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Apr</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>24</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$2754.30</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>24</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$88.75</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$77.52</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><a href='ipzmall_info_details.php?cmonth=4&cyear=2016'><font
                                            color='#0066cc' size='1' face='Verdana'>View</font></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>May</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>250</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$28300.49</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>261</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$890.56</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$1044.11</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><a href='ipzmall_info_details.php?cmonth=5&cyear=2016'><font
                                            color='#0066cc' size='1' face='Verdana'>View</font></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Jun</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>29</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$2921.27</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>29</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$76.07</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$87.60</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><a href='ipzmall_info_details.php?cmonth=6&cyear=2016'><font
                                            color='#0066cc' size='1' face='Verdana'>View</font></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Jul</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>11</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$1312.69</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>12</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$37.30</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$36.15</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><a href='ipzmall_info_details.php?cmonth=7&cyear=2016'><font
                                            color='#0066cc' size='1' face='Verdana'>View</font></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>Aug</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>10</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>$1031.37</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>10</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$9.77</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><font color='#404040' size='1' face='Verdana'>-$3.65</font></div>
                            </td>
                            <td NOWRAP align='left'>
                                <div align='left'><a href='ipzmall_info_details.php?cmonth=8&cyear=2016'><font
                                            color='#0066cc' size='1' face='Verdana'>View</font></a></div>
                            </td>
                        </tr>
                    </table>
            </td>
        </tr>
    </table>
    <br/><br/><br/>

</div>

</html>


<!-------------------------PUT EVERYTHING IN HERE----------------------------------> 
               
