<?php 
	session_start();
	if((! isset($_SESSION['username'])) || (!isset($_SESSION['password'])))
		header("Location: index.php");
	$user = $_SESSION['username'];
	include 'convert_fun.php' ;

?>

<?php
    $dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "appocalypse007";
	$dbname = "project_db";
	$connection = mysqli_connect($dbhost , $dbuser , $dbpass , $dbname);
	if( ! $connection)
		die("Database connection failed .");
	$query = "SELECT left_size FROM user_info WHERE user_name='{$user}' ;" ;
	$result = mysqli_query($connection , $query) ;
	if($row = mysqli_fetch_row($result))
		$left_size = $row[0] ;
	$left_size = convert($left_size) . " ( ". "appx."  . " )" ;
	$left_size = "Free space left : " . $left_size ;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File Transfer</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="upload.css">	
	
	<script type="text/javascript">
	function delete_np(str)
	{
		var xmlhttp = new  XMLHttpRequest() ;
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("status").innerHTML = xmlhttp.responseText ;
				location.reload(true);
			}
		};
		xmlhttp.open("POST" , "delete_file.php" , "true") ;
		xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
		xmlhttp.send("file="+str+"&pass=no") ;
		document.getElementById("status").innerHTML = "Processing........." ;
	}
	function delete_p(str)
	{
		var xmlhttp = new  XMLHttpRequest() ;
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("status").innerHTML = xmlhttp.responseText ;
				location.reload(true);
			}
		};
		xmlhttp.open("POST" , "delete_file.php" , "true") ;
		xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
		xmlhttp.send("file="+str+"&pass=yes") ;
		document.getElementById("status").innerHTML = "Processing........." ;
	}
	function check_np(str)
	{
		var xmlhttp = new  XMLHttpRequest() ;
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("status").innerHTML = xmlhttp.responseText ;
			}
		};
		xmlhttp.open("POST" , "test_zip.php" , "true") ;
		xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
		xmlhttp.send("file="+str+"&pass=no") ;
		document.getElementById("status").innerHTML = "Processing........." ;
	}
	function check_p(str)
	{
		var xmlhttp = new  XMLHttpRequest() ;
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("status").innerHTML = xmlhttp.responseText ;
			}
		};
		xmlhttp.open("POST" , "test_zip.php" , "true") ;
		xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
		var i = str + "_p" ;
		var s = document.getElementById(i).value ;
		xmlhttp.send("file="+str+"&pass=yes"+"&value="+s) ;
		document.getElementById("status").innerHTML = "Processing........." ;
	}
	function view_np(str)
	{
		var xmlhttp = new  XMLHttpRequest() ;
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("status").innerHTML = "<pre>" + xmlhttp.responseText + "</pre>" ;
			}
		};
		xmlhttp.open("POST" , "view_zip.php" , "true") ;
		xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
		xmlhttp.send("file="+str+"&pass=no") ;
	}
	function view_p(str)
	{
		var xmlhttp = new  XMLHttpRequest() ;
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				document.getElementById("status").innerHTML = "<pre>" + xmlhttp.responseText + "</pre>" ;
			}
		};
		xmlhttp.open("POST" , "view_zip.php" , "true") ;
		xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
		xmlhttp.send("file="+str+"&pass=yes") ;
	}
	function generate_np(user , file)
	{
		var link = "localhost/download.php?user="+user+"\&pass=no\&file="+file ;
		document.getElementById("status").innerHTML = "Download Link : <span style=\"color:green;\"><strong>" + link + "</strong></span>";
	}
	function generate_p(user,file)
	{
		var link = "localhost/download.php?user="+user+"\&pass=yes\&file="+file ;
		document.getElementById("status").innerHTML = "Download Link : <span style=\"color:green;\"><strong>" + link + "</strong></span>";
	}
	</script>
	<script src="progress.js"></script>
</head>
<body>
<div id="body">
	<header id="header">
		<div id="title">
		<p><a href="home.php"><span style="font-size:200%;color:#FFFFFF;">File Transfer</span></a></p>
		<p><span style="font-size:100%;">Upload - Share - Download</span></p>
		</div>
		<div id="search">
		<form action = "home.php" method = "POST" >
		<input type="search" value="" class="searchbox" placeholder="Search uploads" name = "search_text" >
		<input type="submit" name="search_submit" value="Search" class="button" id="search_button">
		</form>
		</div>
		<div id="menu">
		<form id="list">
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="help.php">Help</a></li>
				<li><a href="feedback.php">Feedback Form</a></li>
				<li id="current">
				<a href="home.php"><?php   echo $user ?></a>
				<ul class="dropdown">
				<li><a href="myuploads.php">Uploads</a></li>
				<li><a href="index.php?logout=1">Log Out</a></li>
				</ul>
				</li>
			</ul>
		</form>
		</div>
	</header>
	<?php 
		if(isset($left_size))
			echo "<br><h3 align = \"center\" >{$left_size}</h3>" ;
	?>
	<div id="myuploads">
	<?php 
	$main = "folders/$user/" ;
	function print_files($directory)
	{
		$list_files = scandir($directory) ;
		foreach ($list_files as $file) 
		{
			if($file !== "." && $file !== ".." && $file !== "password" && $file != "temp_storage" )
			{
				$id = $directory . "/" . $file ;
				$size = filesize($directory . "/" . $file) ;
				echo "<tr><td>". "<a href = \"download.php?user={$_SESSION['username']}&pass=no&file={$file}\">" . basename($file) . "</a>" . (isset($_GET[basename($file , ".zip")]) ? " ( new ) " : "") . " </td><td align=\"right\"> " . convert($size) . "</td>" ;
				echo " <td align=\"middle\"> <button onclick = \"delete_np('{$file}')\" >Delete</button></td><td align=\"middle\"><button onclick = \"check_np('{$file}')\" >Check</button></td><td align=\"middle\"><button onclick = \"view_np('{$file}')\" >View</button></td>
				<td align=\"middle\"><button onclick = \"generate_np('{$_SESSION['username']}' , '{$file}')\" "." >Generate</button></td></tr>" ;
			}
		}
	}
	function print_files_pass($directory)
	{
		$list_files = scandir($directory) ;
		foreach ($list_files as $file) 
		{
			if($file !== "." && $file !== ".." && $file !== "password" && $file != "temp_storage")
			{
				$id = $directory . "/" . $file ;
				$size = filesize($directory . "/" . $file) ;
				echo "<tr><td>". "<a href = \"download.php?user={$_SESSION['username']}&pass=yes&file={$file}\" >" . basename($file) . "</a>" .  (isset($_GET[basename($file , ".zip")]) ? " ( new ) " : "")  ." </td><td align=\"right\"> " . convert($size) . "</td>" ;
				echo "<td align=\"middle\"><button onclick = \"delete_p('{$file}')\" >Delete</button></td><td align=\"middle\"><input id = \"{$file}_p\" type = \"password\"  ></td><td align=\"middle\"><button onclick = \"check_p('{$file}')\" >Check</button></td><td align=\"middle\"><button onclick = \"view_p('{$file}')\" >View</button></td>
				<td align=\"middle\"><button onclick = \"generate_p('{$_SESSION['username']}' , '{$file}')\" "." >Generate</button></td>" ;
			}
		}
	}
	echo "Normal files :" ;
	echo "<br><br>";
	echo "<table>" ;
	echo "<tr><td>File Name</td><td align=\"right\">Size</td><td align=\"middle\">Delete File</td><td align=\"middle\">Check Integrity</td><td align=\"middle\">View Contents</td><td align = \"center\">Link</td></tr>";
	print_files($main) ;
	echo "</table>";
	echo "<br>Password protected files:<br><br>" ;
	echo "<table>";
	echo "<tr><td>File Name</td><td align=\"right\">Size</td><td align=\"middle\">Delete File</td><td align=\"middle\">Enter Password</td><td align=\"middle\">Check Integrity</td><td align=\"middle\">View Contents</td><td align = \"center\">Link</td></tr>";
	print_files_pass($main . "password/");
	echo "</table>";
	?>
	</div>
	<fieldset>
	<legend>Status Message</legend>
	<div id = "status" >
	</div>
	</fieldset>
</div>
</body>
</html>