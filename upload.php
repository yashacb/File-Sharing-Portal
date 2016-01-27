<?php 
	session_start();
	$tot = 0 ;
	$zip_name = $_POST['zip_name'] . ".zip" ;
	$username = $_SESSION['username'] ;
	if(! empty($_FILES['file']['name'][0]) && ! (isset($_POST['upload_files'])) && !isset($_POST['ajax']) )
	{
		$dest = "folders/{$username}/temp_storage/" ;
		foreach ($_FILES['file']['name'] as $position => $filename) 
		{
			$temp = $_FILES['file']['tmp_name'][$position] ;
			move_uploaded_file($temp, $dest . "{$filename}") ;
			chmod($dest . $filename, 0777) ;
			echo "dadasd<br>";
		}
	}
	else if(isset($_POST['ajax']))
	{
		$dest = "folders/{$username}/temp_storage/" ;
		var_dump($_FILES['fileselect']);
		foreach ($_FILES['fileselect']['name'] as $position => $filename) 
		{
			$temp = $_FILES['fileselect']['tmp_name'][$position] ;
			move_uploaded_file($temp, $dest . "{$filename}") ;
			chmod($dest . $filename, 0777) ;
		}
		$zip_command = "cd folders/{$username}/temp_storage/ && ";
		if(  isset($_POST['check']) && !empty($_POST['pass_word']) )
			$zip_command .= "zip -P {$_POST['pass_word']} {$zip_name} " ;
		else
			$zip_command .= "zip $zip_name " ;
		$zip_command .= "*.*" ;
		system($zip_command) ;
		echo "<br>{$zip_command}<br>" ;
		chmod("folders/{$username}/temp_storage/{$zip_name}", 0777) ;
		$size = filesize("folders/{$username}/temp_storage/{$zip_name}");
		$per_dir = "" ;
		if(isset($_POST['pass_word']) && !empty($_POST['pass_word']) && isset($_POST['check']))
			$per_dir = "folders/{$username}/password/";
		else
			$per_dir = "folders/{$username}/" ;
		$move_command = "mv folders/{$username}/temp_storage/{$zip_name} " . $per_dir.$zip_name ;
		echo $move_command ;
		system($move_command) ;
		system("cd folders/{$username} && rm -rf temp_storage" ) ;
		mkdir("folders/$username/temp_storage") ;
		chmod("folders/$username/temp_storage", 0777) ;
		#DB stuff
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
			$left = $left - $size ;
			$q2 = "UPDATE user_info SET left_size = $left WHERE user_name = '{$_SESSION['username']}' ;" ;
			$re = mysqli_query($connection , $q2) ;
			if(!$re)
				die("Database error .") ;
			mysqli_free_result($result) ;
			mysqli_close($connection) ;
		}
	}
?>