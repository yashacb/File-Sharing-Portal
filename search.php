<?php 
	if(isset($_POST['search']))
	{
		$search_string = $_POST['search'];
		if( !preg_match("/^[a-zA-Z0-9 -_]+$/", $search_string)) 
			$search_error = "Incorrect format of search string.<br>" ;
		else
		{
			$exact = array() ;
			$partial = array() ;
			$main = "folders" ;
			function search_file($directory , $file , $actual)
			{
				global $exact ;
				global $partial ;
				$list_files = scandir($directory);
				foreach ($list_files as $value) 
				{
					if($value !== "." && $value !== ".." )
					{
						$files = scandir($directory . "/" . $value) ;
						foreach ($files as $file_in) 
						{
							if($file_in !== "." && $file_in !== ".." && is_file($directory . "/" . $value . "/" . $file_in))
							{
								if(basename($file_in , "zip") === $actual)
								$exact[] = $value . "/" . "file_in" ;
								else
								{
									foreach ($file as $words) 
									{
										if(strpos(basename($directory . "/" . $value . "/" . $file_in , "zip"), $words) !== false)
											$partial[] = $value . "/" . "password/" . $file_in ;
									}
								}
							}
							else if($file_in !== "." && $file_in !== "..")
							{
								$pass_files = scandir($directory . "/" . $value . "/" . "password");
								foreach ($pass_files as $files_pass) 
								{
									if(basename($files_pass , "zip") === $actual)
									$exact[] = $value . "/password/" . $files_pass . "(Password protected)" ;
									else
									{
										foreach ($file as $words) 
										{
											if(strpos(basename($directory . "/" . $value . "/" . $files_pass , "zip"), $words) !== false)
												$partial[] = $value . "/" . "password/" . $files_pass . "(Password protected)" ;
										}
									}
								}
							}
						}
					}
				}
			}
			$a = preg_split("/[ - _]+/", $search_string);
			search_file($main , $a , $search_string);
		}
	}
?>


<html>
	<head>
		<title>Search</title>
	</head>
	<body>
		<?php 
		if(!empty($exact))
		{
			foreach ($exact as $file => $size) 
			{
				echo basename($file) . " - " . $size . "<br" ; 
			}
		}
		else
			echo "No exact matches" ;
		?>
		<br><br>
		<?php 
			if(!empty($partial))
			{
				foreach ($partial as $key => $value) 
				{
					echo basename($key) . " " . $value . "<br>" ;
				}
			}
			else
				echo "No partial matches" ;
		?>
	</body>
</html>