<?php 
	session_start();
	if(isset($_POST['filename']))
	{
		if(!empty(trim($_POST['filename'])) && preg_match("/[a-zA-Z0-9_]+/", $_POST['filename']) )
		{
			$f = fopen("abc.txt", "w");
			fwrite($f, $_POST['filename']);
			$main = "folders/{$_SESSION['username']}/" ;
			$filelist = scandir($main) ;
			foreach ($filelist as $file) 
			{
				fwrite($f , basename($file , ".zip"). "\n");
				if(basename($file , ".zip") === $_POST['filename'])
				{
					echo "File with that name already exists" ;
					exit ;
				}
			}
			$main = "folders/{$_SESSION['username']}/password/" ;
			$filelist = scandir($main) ;
			foreach ($filelist as $file) 
			{
				fwrite($f , basename($file , ".zip") . "\n");
				if(basename($file , ".zip") === $_POST['filename'])
				{
					echo "File with that name already exists" ;
					exit ;
				}
			}
			echo "File name accepted" ;
			fclose($f) ;
		}
		else
			echo "Unacceptable filename" ;
	}
?>