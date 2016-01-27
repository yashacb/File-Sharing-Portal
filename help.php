<!DOCTYPE html>
<?php
	session_start();
	$user = $_SESSION['username'];
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File Transfer</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" type="text/css" href="help.css">
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
				<li id="current"><a href="help.php">Help</a></li>
				<li><a href="feedback.php">Feedback Form</a></li>
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
	<div id="dhtmlgoodies_slideshow">
	<div id="previewPane">
		<img src="images/image1_big.jpg">
		<span id="waitMessage">Loading image. Please wait</span>	
		<div id="largeImageCaption">File Transfer</div>
	</div>
	<div id="galleryContainer">
		<div id="arrow_left"><img src="images/arrow_left.gif"></div>
		<div id="arrow_right"><img src="images/arrow_right.gif"></div>
		<div id="theImages">
				<!-- Thumbnails -->
				<a href="#" onclick="showPreview('images/image1_big.jpg','1');return false"><img src="images/image1.jpg"></a>		
				<a href="#" onclick="showPreview('images/image2_big.png','2');return false"><img src="images/image2.png"></a>		
				<a href="#" onclick="showPreview('images/image3_big.png','3');return false"><img src="images/image3.png"></a>		
				<a href="#" onclick="showPreview('images/image4_big.png','4');return false"><img src="images/image4.png"></a>				
				<a href="#" onclick="showPreview('images/image5_big.png','6');return false"><img src="images/image5.png"></a>		
				<a href="#" onclick="showPreview('images/image5 (2)_big.png','7');return false"><img src="images/image5 (2).png"></a>		
				<a href="#" onclick="showPreview('images/image6_big.png','8');return false"><img src="images/image6.png"></a>

				<a href="#" onclick="showPreview('images/image7_big.png','2');return false"><img src="images/image7.png"></a>

				<a href="#" onclick="showPreview('images/image8_big.png','2');return false"><img src="images/image8.png"></a>	

				<a href="#" onclick="showPreview('images/image9_big.png','2');return false"><img src="images/image9.png"></a>

				<a href="#" onclick="showPreview('images/image10_big.png','2');return false"><img src="images/image10.png"></a>

				<a href="#" onclick="showPreview('images/image11_big.png','2');return false"><img src="images/image11.png"></a>

				<a href="#" onclick="showPreview('images/image12_big.png','2');return false"><img src="images/image12.png"></a>

				<a href="#" onclick="showPreview('images/image13_big.png','2');return false"><img src="images/image13.png"></a>
				<!-- End thumbnails -->
				
				<!-- Image captions -->	
				
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				<div class="imageCaption">File Transfer</div>
				
				<!-- End image captions -->
				
				<div id="slideEnd"></div>
		</div>
	</div>
</div>
<script src="slider.js"></script>
</body>
</html>