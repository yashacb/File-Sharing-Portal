<?php 
	echo $_POST['link'] ;
	if(isset($_POST['link']))
	{
		$a = strlen("10.10.3.40/download.php?") ;
		$actual = substr($_POST['link'] , $a) ;
		echo $_POST['link'] ;
		$parts =explode("&", $actual) ;
		if(count($parts) === 3)
		{
			$user = substr($parts[0], 5) ;
			$pass = substr($parts[1] , 5) ;
			$filename = substr($parts[2], 5) . ".zip" ;
			$path = $user . "/" ;
			if($pass === "yes")
				$path .= "password/" ;
			$path .= $filename ;
			echo $path ;
			if(file_exists($path))
				echo "<a id = \"ajaxmess\" href = \"link\" ></a>" ;
			// else
			// 	echo "Not a valid link" ;
		}
		//  else
		// 	echo "Not a valid link" ;
	}
?>