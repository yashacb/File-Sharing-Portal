<?php 
	session_start() ;
	if(isset($_POST['file']) && isset($_POST['pass']))
	{
		if($_POST['pass'] === "no")
		{
			$main = "folders/{$_SESSION['username']}/" ;
		}
		else
		{
			$main = "folders/{$_SESSION['username']}/password/" ;
		}
		$res = "" ;
		if(file_exists($main . "/" . $_POST['file']))
		{
			$s = filesize($main . $_POST['file']) ;
			$terminal = "rm -f " . $main . "/" . $_POST['file'] ;
			system($terminal) ;
			$res =  $_POST['file'] . " deleted" ;
			#MySQL stuff
			$dbhost = "localhost";
			$dbuser = "root";
			$dbpass = "appocalypse007";
			$dbname = "project_db";
			$connection = mysqli_connect($dbhost , $dbuser , $dbpass , $dbname);
			if(mysqli_connect_errno())
			{
				die("Database connection failed " . "(" . mysqli_connect_error() . ")");
			}
			else
			{
				$q1 = "SELECT left_size FROM user_info WHERE user_name = '{$_SESSION['username']}' ;" ;
				$result = mysqli_query($connection , $q1) ;
				$row = mysqli_fetch_row($result) ;
				$left = (int)$row[0] ;
				$left = $left + $s ;
				$q2 = "UPDATE user_info SET left_size = $left WHERE user_name = '{$_SESSION['username']}' ;" ;
				$re = mysqli_query($connection , $q2) ;
				if(!$re)
					die("Database error .") ;
				mysqli_free_result($result) ;
				mysqli_close($connection) ;
			}
			#End of database stuff
		}
		else
			$res = "File does not exist.It has been deleted." ;
		echo $res ;
	}
?>