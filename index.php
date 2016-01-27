<?php 
	if(( isset($_GET['logout']) && $_GET['logout'] === "1" ) || isset($_POST['logout']))
	{
		session_start();
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		session_destroy();
	}
?>

<?php 
	session_start();
	if(isset($_SESSION['username']) && isset($_SESSION['password']))
	{	
		header("Location: home.php");
	}
?>

<?php 
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "appocalypse007";
	$dbname = "project_db";
	$error = 0 ;
	if (isset($_POST['submit_sign'])) 
	{
		if(trim($_POST['username_sign']) === "")
			{$sign_username_err = "Username must be provided." ; $error = 1 ;}
		else if(!preg_match("/^[a-zA-z_0-9]+$/", $_POST['username_sign']))
			{$sign_username_err = "Incorrect username format." ; $error = 1 ;}
		else
		{
			$connection = mysqli_connect($dbhost , $dbuser , $dbpass , $dbname);
			if(mysqli_connect_errno())
			{
				die("Database connection failed " . "(" . mysqli_connect_error() . ")");
			}
			else
			{
				$query = "SELECT * FROM user_info WHERE user_name = '{$_POST['username_sign']}' ;";
				if($result = mysqli_query($connection , $query))
				{
					$row_count = mysqli_num_rows($result);
					if($row_count > 0 )
					{
						$sign_username_err = "Username already taken.";
						$error = 1 ;
					}
				}
				mysqli_free_result($result);
				mysqli_close($connection);

			}
		}
		if(trim($_POST['password_sign']) === "")
			{$sign_password_err = "password must be provided." ; $error = 1 ;}
		else if(!preg_match("/^[a-zA-z_0-9]+$/", $_POST['password_sign']))
			{$sign_password_err = "Incorrect password format." ; $error = 1 ;}
		else if(trim($_POST['password_sign']) === "")
			{$sign_password_err = "password must be provided." ; $error = 1 ;}
		if($_POST['password_sign'] !== $_POST['repassword_sign'])
			{$sign_repass_err = "Both password are not equal."; $error = 1 ;}
	}
	if( $error === 0 && isset($_POST['submit_sign']))
	{
		session_start();
		$_SESSION['username'] = $_POST['username_sign'];
		$_SESSION['password'] = $_POST['password_sign'];
		$date = date("Y/m/d");
		$query_s = "INSERT INTO user_info (user_name , password ) VALUES ('{$_POST['username_sign']}' , '{$_POST['password_sign']}' ) ;" ;
		$connection = mysqli_connect($dbhost , $dbuser , $dbpass , $dbname); 
		if(mysqli_connect_errno())
		{
			die("Database connection failed " . "(" . mysqli_connect_error() . ")");
		}
		$result = mysqli_query($connection , $query_s);
		if( ! $result)
		{
			die("Database error");
		}
		mysqli_close($connection);
		mkdir("folders/{$_POST['username_sign']}");
		mkdir("folders/{$_POST['username_sign']}/password");
		mkdir("folders/{$_POST['username_sign']}/temp_storage");
		chmod("folders/{$_POST['username_sign']}", 0777);
		chmod("folders/{$_POST['username_sign']}/password" , 0777);
		chmod("folders/{$_POST['username_sign']}/temp_storage" , 0777);
		header("Location: home.php");
		exit ;
	}
?>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>File Transfer</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
	<div id="body">
	<div id="title">
		<header id="header">
			<p>
				<p><span style="font-size:220%;"><a href="#">File Transfer</a></span></p>
				<span style="font-size:140%;">Upload - Share - Download</span>
			</p>
		</header>
		<div id="login">
			<form action="login.php" method="post">
			<div class="row">
				<input required name="username" id="username" value="" placeholder="User Name" type="text">
				<input required name="password" id="password" value="" placeholder="Password" type="password">
				<input name = "login" value="Login" class="submit" id="submit1" type="submit">
			</div>
			</form>
		</div>
	</div>
	<div id="error">
	<?php
		if(isset($_GET['logerr']) && $_GET['logerr'] === "1")
			echo "Invalid Username or Password " ;
	?>
	</div>
	<div id="bottom">
		<div id="info">
			<p><span style="font-size:200%;">Want to send large files?? We've got the answer.</h1></span><br><br>
			<div id="image1">
				<p><img alt="Files too big to send by email?" src="images/compressed-file.png"></p>
				<span style="font-size:100%">Files too big to send by email</span>
			</div>
			<div id="image2">
				<p><img src="images/padlock.png"></p>
				<span style="font-size:100%;">Want Security Encryption??</span>
			</div>
			<div id="image3">
				<p><img src="images/software.png"></p>
				<span style="font-size:100%;">No need to install any software - try it now!</span>
			</div>
		</div>
		<div id="signup">
			<p><span style="font-size:250%;">Create an account.</span></p>
			<form action="index.php" method="post">
			<ul>
				<li><input required name = "username_sign" type="text" value="" placeholder="User Name" id="username1"></li><?php  if(isset($sign_username_err)) echo "<span class = \"error\">*{$sign_username_err}</span>" ?>
				<li><input required name = "password_sign" type="password" value="" placeholder="Password" id="password1"></li><?php if(isset($sign_password_err)) echo "<span class = \"error\">*{$sign_password_err}</span>" ?>
				<li><input required name = "repassword_sign" type="password" value="" placeholder="Re-enter password" id="password1"></li><?php if(isset($sign_repass_err)) echo "<span class = \"error\">*{$sign_repass_err}</span>"  ?>
				<li><input name = "submit_sign" type="submit" class="submit" id="submit2" value="Sign up"></li>
				<li><p id="rules">Note: *Username and Password should contain only alphanumeric characters and '_'.</p></li>
			</ul>
			</form>
		</div>
	</div>
	</div>
	</body>
</html>