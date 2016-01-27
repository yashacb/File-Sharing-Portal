<?php 
	session_start();
	$main = "" ;
	if($_POST['pass'] === "yes")
		$main = "folders/{$_SESSION['username']}/password/" ;
	else
		$main = "folders/{$_SESSION['username']}/" ;
	$f = "{$_POST['file']}" ;
	system("cd $main &&  unzip -l " . $f) ;
?>