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
	function get_client_ip() 
	{
	$ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
	}
		session_start();
		$_SESSION['username'] = $_POST['username_sign'];
		$_SESSION['password'] = $_POST['password_sign'];
		$date = date("Y/m/d");
		$ip = get_client_ip();
		$query_s = "INSERT INTO user_info (user_name , password , last_time , last_ip) VALUES ('{$_POST['username_sign']}' , '{$_POST['password_sign']}' , 'Just Now' , '$ip') ;" ;
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
		mkdir("folders/{$_POST['username_sign']}/public");
		mkdir("folders/{$_POST['username_sign']}/private");
		header("Location: home.php");
		exit ;
	}
?>
<html>
	<head>
		<title>Drop File</title>
		<style type="text/css">
		body{
			font-size: 20px;
			background-image: url("back_pat.png");
			background-attachment: fixed;
		}
		a {
			text-decoration: none;
		}
		#login{
			background-color: #0099FF;
			margin-left: -1%;
			margin-top: -1%;
			margin-right: -1%;
			padding : 1% ;
			padding-top: 2% ;
			padding-left: 2% ;
			color : white;
		}
		#content{
			margin-left : 50%;
		}
		input{
			margin-left : 2%;
			margin-right : 2%;
		}
		hr{
			margin-top: 2%;
			margin-bottom: 2%;
		}
		#left{
			color : white;
			background-color: #09F;
			margin : 1%;
			margin-left : 3%;
			padding : 2%;
			width : 35%;
			height : 55%;
			position: relative;
			bottom: 1%;
		}
		.sup{
			margin:1%;
		}
		#signup,h2{
			text-align: center;
		}
		#right
		{
			float : right;
			padding : 2%;
			margin:1%;
			margin-right: 3%;
			width: 35%;
			background-color: #09F;
			text-align: center;
			height: 55%;
			width: 35%;
			vertical-align: middle;
			position: relative;
			top : 1%;
		}
		#searchbut{
			width: 65%;
			height: 10%;
			margin:2%;
			vertical-align: middle;
		}
		#sbut{
			margin-top:2%;
			width : 15%;
			height : 5%;
			font-weight: bold;
		}
		#searchcontent{
			position: relative;
			top : 25%;
		}
		h2{
			color: white;
		}
		h4{
			font-weight: bold;
			color : #CC2929;
		}
		</style>
	</head>
	<body>
		<form action = "login.php" method = "POST" id = "login">
			<div id = "content">
			<strong>Username</strong> : <input type="text" name = username>
			<strong>Password</strong> : <input type="password" name = "password">
			<input type = "submit" name = "submit" value = "Log In">
			</div><br>
		</form>
		<hr>
		<div id = "right">
		<form method="GET" action = "normal_user.php">
		<h2>Search in public uploads</h2>
		<div id = "searchcontent">
			<input id = "searchbut" type = "text" name = "browse"><br>
			<input id = "sbut" type = "submit" value = "Search">
		</div>
		</form>
		</div><br>
		<div id = "left">
			<h2>Sign Up for free !</h2><hr>
			<form id = "signup" action = "new_page.php" method="POST">
				<h3>Username : <br><input class = "sup" type = "text" name = "username_sign"></h3><?php  if(isset($sign_username_err)) echo "<h4>$sign_username_err</h4>" ?>
				<h3>Password : <br><input class = "sup" type = "password" name = "password_sign"></h3><?php if(isset($sign_password_err)) echo "<h4>$sign_password_err</h4>" ?>
				<h3>Renter password : <br><input class = "sup" type = "password" name = "repassword_sign"></h3><?php if(isset($sign_repass_err)) echo "<h4>$sign_repass_err</h4>"  ?>
				<input type = "submit" name = "submit_sign" value = "Sign Up" >
			</form>
		</div>
		<hr>
	</body>
</html>