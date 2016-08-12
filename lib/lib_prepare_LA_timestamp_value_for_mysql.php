<?php
	date_default_timezone_set("America/Los_Angeles");

	$date = new DateTime(); //this returns the current date time
	echo date_format($date,"Y-m-d H:i:s");