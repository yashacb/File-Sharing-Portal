<?php 
	session_start();
	if((! isset($_SESSION['username'])) || (!isset($_SESSION['password'])))
		header("Location: index.php");
	$user = $_SESSION['username'];

?>

<?php 
	if( isset($_POST['feedback'])) 
	{
		$question1 = $_POST['question1'] ;
		$count_num = fopen("feedback/count.dat" , "r+") ;
		$count = fread($count_num, filesize("feedback/count.dat"));
		$c = (int) $count ;
		rewind($count_num);
		fwrite($count_num, ++$c);
		fclose($count_num);
		$feedb = fopen("feedback/feed{$count}.dat" , "w");
		$q1 = "" ;
		foreach($question1 as $value)
			$q1 = $q1 . "$value " ;
		fwrite($feedb , $q1 . "\n");
		fwrite($feedb , $_POST['question2'] . "\n");
		fwrite($feedb , $_POST['question3'] . "\n");
		fwrite($feedb , $_POST['question4'] . "\n");
		fwrite($feedb , $_POST['question5'] . "\n");
		if(isset($_POST['suggest']))
		{
			fwrite($feedb , $_POST['suggest'] . "\n");
		}
		else
			fwrite($feedb , "No Comments\n");
		fclose($feedb) ;
		$count_num = fopen("feedback/count.dat" , "r") ;
		$count = fread($count_num, filesize("feedback/count.dat"));
		fclose($count_num);
	}
	
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
						if(basename($directory . "/" . $file_name , "zip") === $actual)
							$exact[] = $directory . "/" . $file_name . $p ;
						else
						{
							foreach ($file as $words) 
							{
								if(stripos(basename($file_name , "zip"), $words) !== false)
									$partial[] = $directory . "/" . $file_name . $p  ;
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
					search_file($main . "/" . "password" , $a , $search_string , "(Password protected)") ;
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
	<link rel="stylesheet" type="text/css" href="feedback.css">	
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
		<input type="search" value="" class="searchbox" placeholder="Search uploads" name = "search_text" >
		<input type="submit" name="search_submit" value="Search" class="button" id="search_button">
		</div>
		<div id="menu">
		<form id="list">
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="help.php">Help</a></li>
				<li id="current"><a href="feedback.php">Feedback Form</a></li>
				<li>
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
	<div id="rest">
		<div id="para">
			<p><h1>Feedback Form</h1></p>
			<p><h2>“There can be so many suggestions and opinions too; What matters is that you acknowledge at your depths and stand by it like a Rock...” </h2></p>
		</div>
		</div>
		<div id="feedback">
		<?php 
			if(!isset($_POST['feedback'])) :
		?>
		<form method = "POST" action = "feedback.php">
			<p><h3>1. What task did you accomplish on this website?</h3></p>
			<div id="options">
  				<input type="checkbox" id="checkbox11" name="question1[]" value = "Upload_Files" />
  				<label for="checkbox11"><span></span>Upload Files</label><br>
 				<input type="checkbox" id="checkbox12" name="question1[]" value = "Download_Files" />
 				<label for="checkbox12"><span></span>Download Files</label><br>
 				<input type="checkbox" id="checkbox13" name="question1[]" value = "Share_Files" />
  				<label for="checkbox13"><span></span>Share Files</label><br>
 				<input type="checkbox" id="checkbox14" name="question1[]" value = "None" />
 				<label for="checkbox14"><span></span>None</label><br>
			</div>
			<p><h3>2. Were you able to accomplish the task you were looking for on our website?</h3></p>
			<div id="options">
  				<input type="radio" id="checkbox21" name="question2" value = "Q2_Yes" />
  				<label for="checkbox21"><span></span>Yes.</label><br>
 				<input type="radio" id="question2" name="question2" value = "Q2_No" />
 				<label for="checkbox22"><span></span>No.</label><br>
			</div>
			<p><h3>3. Would you recommend this website to a friend?</h3></p>
			<div id="options">
  				<input type="radio" id="checkbox31" name="question3" value = "Q3_Yes" />
  				<label for="checkbox31"><span></span>Yes. I'd recommend it.</label><br>
 				<input type="radio" id="checkbox32" name="question3" value = "Q3_No" />
 				<label for="checkbox32"><span></span>No. I wouldn't recommend it.</label><br>
			</div>
			<p><h3>4. If you were to review  this website what score would you give it out of 5?</h3></p>
			<div id="options">
  				<input type="radio" id="checkbox41" name="question4" value = "1" />
  				<label for="checkbox41"><span></span>1</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 				<input type="radio" id="checkbox42" name="question4" value = "2" />
 				<label for="checkbox42"><span></span>2</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 				<input type="radio" id="checkbox43" name="question4" value = "3" />
  				<label for="checkbox43"><span></span>3</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 				<input type="radio" id="checkbox44" name="question4" value = "4" />
 				<label for="checkbox44"><span></span>4</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 				<input type="radio" id="checkbox45" name="question4" value = "5" />
 				<label for="checkbox45"><span></span>5</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<p><h3>5. Overall, how easy to use do you find this website?</h3></p>
			<div id="options">
  				<input type="radio" id="checkbox51" name="question5" value="Easy" />
  				<label for="checkbox51"><span></span>Easy to use</label><br>
 				<input type="radio" id="checkbox52" name="question5" value="Neutral" />
 				<label for="checkbox52"><span></span>Neither easy nor difficult to use</label><br>
 				<input type="radio" id="checkbox53" name="question5" value="Difficult" />
  				<label for="checkbox53"><span></span>Difficult to use</label><br>
			</div>
			<p><h3>6. Anything else you care to share or get off your heart?</h3></p>
			<label>
				<textarea name="suggest" id="suggest" cols="45" rows="5" placeholder="Enter your suggestions here"></textarea>
			</label><br><br>
			<input name = "feedback" type="submit" class="submit" value="Submit">
			</form>
		<?php else : ?>
			<h2>Thank You for sharing your opinion . Have a good day . </h2>
		<?php endif; ?>
		</div>
	</div>
</div>
</body>
</html>
