<?php

		function dateTime7GMT(){
			$date = new DateTime(Date('Y-m-d H:i:s'), new DateTimeZone(env('APP_TIMEZONE')));
			return date_format($date, 'Y-m-d H:i:s');

		}

		function isValidDate($date){
		    //echo $date; die;
		    if (false === strtotime($date)) {
		        return false;
		    }else {
		        return true;
		    }
		}

		function isValidDateTime($dateTime){
			$format = 'Y-m-d H:i:s'; 
		    $d = DateTime::createFromFormat($format, $dateTime);
    		return $d && $d->format($format) == $dateTime;
		}

		function llformat($str = "", $dec = 4){

			return sprintf("%.".$dec."f", $str); 
		}

		

   
?>