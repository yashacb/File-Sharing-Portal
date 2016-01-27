<?php 
	if(isset($_GET['pass']) && isset($_GET['user']) && isset($_GET['file']))
	{
		$username = $_GET['user'];
		$pass = $_GET['pass'] ;
		$filename = basename($_GET['file'] , ".zip") ;
		$dd = "folders/" . $username . "/" ;
		if($pass === "yes")
			$dd .= "password/" ;
		$dd .= "$filename.zip" ;
		echo $dd ;
		$file = $dd ;
		if(file_exists($dd))
		{
			header("Location: $file") ;
		}
	}
	else
		echo "dasdsa" ;
?>