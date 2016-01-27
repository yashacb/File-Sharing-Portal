<?php 
	function convert($size)
	{
		if($size < 1024)
			return $size . " B" ;
		$kb = ( (int) $size ) / 1024 ;
		if($kb < 1024)
			return round($kb , 3) . " KB" ;
		$mb = $kb / 1024 ;
		if($mb < 1024)
			return round($mb , 3) . " MB" ;
		$gb = $mb / 1024 ;
		if($gb < 1024)
			return round($gb , 3) . " GB" ;		
	}
?>