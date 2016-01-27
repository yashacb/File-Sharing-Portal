<?php 
	session_start() ;
	if(isset($_POST['file']))
	{
		$terminal = "" ;
		$main = "" ;
		if($_POST['pass'] === "yes")
		{
			$main = "folders/{$_SESSION['username']}/password/" ;
			if(!empty(trim($_POST['value'])))
				$terminal = "unzip" . " -P {$_POST['value']} " ;
			else
			{
				echo "Incorrect password" ;
				exit ;
			}

		}
		else
		{
			$main = "folders/{$_SESSION['username']}/" ;
			$terminal = "unzip " ;
		}
		$to_check = $main . $_POST['file'] ;
		$terminal .= "-t {$to_check}";
		$result = exec($terminal) ;
		$result = str_replace($main , "", $result) ;
		echo $result ;
	}
?>