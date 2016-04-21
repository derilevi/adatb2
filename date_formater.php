<?php
	function FormatDate($date)
	{
		$d = explode("-", $date);
		
		$year = $d[0];
		$month = getMonth($d[1]);
		$day = $d[2];

		return $year . ". " .  $month . " " . $day . ".";		
	}
	
	function getMonth($m)
	{
		switch($m)
		{
			case "01": return "január";
			case "02": return "február";
			case "03": return "március";
			case "04": return "április";
			case "05": return "május";
			case "06": return "június";
			case "07": return "július";
			case "08": return "augusztus";
			case "09": return "szeptember";
			case "10": return "október";
			case "11": return "november";
			case "12": return "december";
		}
	}
?>