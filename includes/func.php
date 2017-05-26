<?php 

function getMyDateFormat() {
	
	date_default_timezone_set("Europe/Paris");
	$date = date('Y-m-d H:i:s');

	return $date;
}

