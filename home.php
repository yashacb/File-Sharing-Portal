<?php 
	if(isset($_GET['upload_error']))
	{
		$upload_err = "No files chosen to upload ." ;
	}
?>

<?php 
	session_start();
	if((! isset($_SESSION['username'])) || (!isset($_SESSION['password'])))
		header("Location: index.php");
	$user = $_SESSION['username'];

?>

<?php
	$command = "rm -rf folders/{$user}/temp_storage/*.*" ;
	exec($command) ;
?>

<?php 
	if(isset($_POST['search_submit']))
	{
		$search_string = $_POST['search_text'];
		if( !preg_match("/^[a-zA-Z0-9 -_]+$/", $search_string)) 
			$search_error = "Incorrect format of search string.<br>" ;
		else
		{
			$exact = array() ;
			$partial = array() ;
			$main = "folders/" ;
			function search_file($directory , $file , $actual , $p="")
			{
				global $exact ;
				global $partial ;
				$list_files = scandir($directory);
				foreach ($list_files as $file_name) 
				{
					if(is_file($directory . "/" . $file_name))
					{
						if(basename($directory . "/" . $file_name , ".zip") === $actual)
							$exact[] = $directory . "/" . $file_name . "{$p}" ;
						else
						{
							foreach ($file as $words) 
							{
								if(stripos(basename($file_name , ".zip"), $words) !== false)
									$partial[] = $directory . "/" . $file_name . "{$p}"  ;
							}
						}
					}
				}
			}
			$a = preg_split("/[ - _]+/", $search_string);
			$users = scandir($main) ;
			foreach($users as $user_name)
			{
				if( $user_name !== "." && $user_name !== ".."  && $user_name !== $user)
				{
					$main = "folders/{$user_name}" ;
					search_file($main , $a , $search_string);
					// search_file($main . "/" . "password" , $a , $search_string , "(Password protected)") ;
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File Transfer</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="home.css">
	<script type="text/javascript">
	function enable_password(status)
	{
		var showhide=document.getElementById("hide");
		showhide.style.display=status?"block":"none";
	}
	</script>
	
</head>
<body>
<div id="body">
	<header id="header">
		<div id="title">
		<p><span style="font-size:200%;"><a href="home.php">File Transfer</a></span></p>
		<p><span style="font-size:100%;">Upload - Share - Download</span></p>
		</div>
		<div id="search">
		<form action = "home.php" method = "POST" >
		<input type="search" value="" class="searchbox" placeholder="Search uploads" name = "search_text" pattern = "[A-Za-z0-9 _]{1,}" required >
		<input type="submit" name="search_submit" value="Search" class="button" id="search_button">
		</form>
		</div>
		<div id="menu">
		<form id="list">
			<ul>
				<li id="current"><a href="home.php">Home</a></li>
				<li><a href="help.php">Help</a></li>
				<li><a href="feedback.php">Feedback Form</a></li>
				<li>
				<a href="home.php" id = "user__name" ><?php   echo $user ?></a>
				<ul class="dropdown">
				<li><a href="myuploads.php">Uploads</a></li>
				<li><a href="index.php?logout=1">Log Out</a></li>
				</ul>
				</li>
			</ul>
		</form>
		</div>
	</header>	
	<div id="upload">
		<span style="font-size:300%;">File Transfer</span><br>
		<span style="font-size:150%;">Fast,Easy&amp;Secure</span>
		<div id="upload1">
		<?php  
			if(! isset($_POST['search_submit'])) : 
		?>
		<form id="upload2" name="upload2" action="upload.php" method="POST" enctype="multipart/form-data" onsubmit = "return validate_the_form()"  >
		<fieldset>
			<legend>File Upload</legend>	
			<div>
				<label for="fileselect">Files to upload:</label>
				<input type="file" id="fileselect" name="fileselect[]" multiple="multiple" required  />
				<div class = "filedrag" id="filedrag">
				or drop files here
				<p>
				<label for="zip_name">Name of the zip file : </label>
				<input  type="text" name="zip_name" id="zip_name" onkeyup="checkName(this.value)" autocomplete = "off" required ></p>
				<div id = "name_stat" >
				File name should not be empty
				</div>
				<input type="checkbox" name="check" id="checkbox2" onclick="enable_password(this.checked)">
				<label for="checkbox2">Private File</label><br>
				<div id="hide" style="display:none">
					<p>Enter password for the zip file</p>
					<input type="password" name="pass_word" id="pass">
					<input type="checkbox" onchange="document.getElementById('pass').type = this.checked ? 'text' : 'password'"> Show password
				</div>

				</div>
			</div>
			<div id="submitbutton">
				<input  name = "upload_files" type="submit" id ="upload_button" value = "Upload Files" >
			</div>
		</fieldset>
		</form>
		<span id="down_link" ></span><br>
		<button id="gener" onclick="generate()" class = "button" >Generate Link</button>
		<br><br>Upload Progress :
		<div class = "bar" >
			<span class = "barfill" id = "pb" ><span class = "bar-fill-text" id = "pt" ></span></span>
		</div>
		<br>
		<div id="status">
			<p>Status Messages</p>
			<div id="messages">
			<table id = "messa" >

			</table>
			</div>
		</div>
		
		</div>
		<?php  else :  ?>
		<?php 
			echo "<h2>Exact matches : <br></h2>";
			if(empty($exact))
				echo "No exact matches :( <br>" ;
			else
			{
				foreach ($exact as $value) 
				{
					$separate = explode("/", $value);
					$a = strlen($value) ;
					$b = strlen("(Password protected)");
					$c = $a - $b ;
					if(substr($value, -$b) === "(Password protected)")
						$value = substr($value, 0 , $c) ;
					echo "<h3>User : {$separate[1]}  <br> File :" .  end($separate) . "</h3><a class =\"phpdown\" href = \"{$value} \" >Download</a>" ;
				}
			}
			if(!empty($partial))
			{
				echo "<h2>You may like to check out these : <br></h2>";
				foreach ($partial as $value) 
				{
					$separate = explode("/", $value);
					$a = strlen($value) ;
					$b = strlen("(Password protected)");
					$c = $a - $b ;
					if(substr($value, -$b) === "(Password protected)")
						$value = substr($value, 0 , $c) ;
					echo "<h3>User : {$separate[1]}  <br> File : " . end($separate) . ".</h3><a class =\"phpdown\" href = \"{$value}\">Download</a>" ;
				}
			}
			else
			{
				echo "<br><h2> No partial matches :( </h2>" ;
			}
		?>
	
	<?php endif ; ?>
	<br>
		<p><span style="color:red;">*Search string and zip file name should contain only alphanumeric characters , underscore and spaces .</span></p>
	</div>
	<div id="features">
	<p id="heading"><span style="font-size:250%;">Features of our website</span></p>
	<div id="feature_upload">
	<p align="middle"><img src="images/upload.png"></p>
	<p class="details" align="middle"><span style="font-size:120%;">Upload upto 2 GB storage data</span></p>
	</div>
	<div id="feature_download">
	<p align="middle"><img src="images/download.png"></p>
	<p class="details" align="middle"><span style="font-size:120%;">Unlimited Downloads</span></p>
	</div>
	<div id="feature_password">
	<p align="middle"><img src="images/password.png"></p>
	<p class="details" align="middle"><span style="font-size:120%;">Protect your files with password.</span></p>
	</div>
	<div id="feature_zip">
	<p align="middle"><img src="images/zip.png"></p>
	<p class="details" align="middle"><span style="font-size:120%;">Compress your files.</span></p>
	</div>
	</div>
	<div id="footer">
		<hr>
		<p>Best viewed on 1920x1080 resolution.</p>
	</div>
	</div>
<script src="filedrag.js"></script>
<script src="progress.js"></script>
		<script type="text/javascript">
			document.getElementById("upload_button").addEventListener('click' , function(e)
			{
				console.log("Prevented");
				e.preventDefault();

				var f = document.getElementById("fileselect");
				var pb = document.getElementById("pb") ;
				var pt = document.getElementById("pt");

				if(validate_the_form() === false)
					return ;

				app.uploader({files:f,
						  progressBar:pb,
						  progressText:pt,
						  processor:'upload.php'});
			});

			
		</script>

		<script type="text/javascript">
			function getLink(str)
			{
				if(str.length == 0)
				{
					document.getElementById("pastelink").innerHTML = "" ;
					return ;
				}
				else
				{
					document.getElementById("test").innerHTML = "RR" ;
					var xmlhttp = new XMLHttpRequest() ;
					xmlhttp.onreadystatechange = function()
					{
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							document.getElementById("ajax_text").innerHTML = xmlhttp.responseText;
						}
					};
					xmlhttp.open("POST" , "ajax_test.php" , "true") ;
					console.log(str) ;
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send("link="+str) ;
				}
			}
		</script>
		<script type="text/javascript">
			function checkName(str)
			{
				if(str.length == 0)
				{
					document.getElementById("name_stat").innerHTML = "File name should not be empty" ;
					return ;
				}
				else
				{
					var xmlhttp = new XMLHttpRequest() ;
					xmlhttp.onreadystatechange = function()
					{
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							document.getElementById("name_stat").innerHTML = xmlhttp.responseText;
						}
					};
					xmlhttp.open("POST" , "check_name.php" , "true") ;
					xmlhttp.setRequestHeader("Content-type" , "application/x-www-form-urlencoded") ;
					xmlhttp.send("filename="+str) ;
				}
			}
			function generate()
			{
				var fname = document.getElementById("zip_name").value ;
				var link = "" ;
				var user = document.getElementById("user__name").innerHTML ;
				console.log(user+" "+fname) ;
				if(fname.length == 0 || document.getElementById("name_stat") == "File with that name already exists" || document.getElementById("name_stat") =="Unacceptable filename" || document.getElementById("name_stat") == "Empty filename not acceptable" )
				{
					document.getElementById("down_link").innerHTML = "Cannot generate link" ;
					return ;
				}
				if(document.getElementById("checkbox2").checked)
					link = "<br><strong>localhost/download.php?user="+user+"&amp;pass=yes&amp;"+"file="+fname+".zip</strong><br>" ; 
				else
					link = "<br><strong>localhost/download.php?user="+user+"&amp;pass=no&amp;"+"file="+fname + ".zip</strong><br>"; 
				document.getElementById("down_link").innerHTML = link ;
			}
			function validate_the_form()
			{
				if(document.getElementById("fileselect").value.length === 0)
				{
					alert("No files selected !");
					return false ;
				}
				if( document.getElementById("name_stat").innerHTML.trim() != "File name accepted" )
				{
					alert("Unacceptable filename or pattern !")
					return false ;
				}
				if(document.getElementById("checkbox2").checked)
				{
					var a = document.getElementById("pass").value ;
					if( ! a.match(/[a-zA-Z0-9_]/))
					{
						alert("Password field is of incorrect pattern .")
						return false ;
					}
					else
						return true ;
				}
				else
					return true ;
			}
		</script>
</body>
</html>