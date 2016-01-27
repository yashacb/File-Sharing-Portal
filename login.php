<?php
    $user_name = $_POST['username'];
    $password = $_POST['password'] ;
    $dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "appocalypse007";
	$dbname = "project_db";
	$error = 0 ;
    $login_error = "" ;
    if( ! preg_match("/^[a-zA-z0-9 _]+$/", $user_name) || (! preg_match("/^[a-zA-z0-9 _]+$/", $password)))
        $login_error = "Username or password incorrect" ;
    else
    {
        $connection = mysqli_connect($dbhost , $dbuser , $dbpass , $dbname);
        if(! $connection)
            die("Database connection failed");
        else
        {
            $query = "SELECT password FROM user_info WHERE user_name = '$user_name' AND password = '$password' ;" ;
            $result = mysqli_query($connection , $query) ;
            if( $result )
            {
                $row = mysqli_num_rows($result);
                if($row !== 1)
                    $login_error = "Username or password incorrect" ;
                else
                {
                    session_start();
                    $_SESSION['username'] = $user_name ;
                    $_SESSION['password'] = $password ;
                    header("Location: home.php");
                }
            }
            mysqli_free_result($result);
            mysqli_close($connection);
            // session_start();
            // $_SESSION['username'] = $user_name;
            // $_SESSION['password'] = $password ;
        }
    }
    if(! isset($login_error))
    {
        header("Location: home.php");
        exit ;
    }
    else
    {
        header("Location: index.php?logerr=1");
        exit ;
    }
?>

<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login Error</h1>
</body>
</html>