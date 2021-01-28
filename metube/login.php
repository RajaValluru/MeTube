<?php
	
include_once "config.php";
include_once "mysql_function.php";
session_start();
if (!isset($_SESSION["username"]))
{
    $_SESSION["username"] = "guest";
}

if(isset($_POST['username'])) {

    $db_connection = db_connect($dbhost, $dbuser, $dbpass, $database);
    $sql_string = "select * from users where email like '" . $_POST['username'] . "' and password like '" . $_POST['password'] . "'";
    $result = mysqli_query($db_connection, $sql_string);


    if (!$result)
    {
        die ("mysqli_query() failed. Could not query the database: <br />". mysqli_error($db_connection));
    }
    else
    {
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
		echo "<p> Authenticated </p>";
		$_SESSION["userid"] = $row["UserID"];
		$_SESSION["fname"] = $row["fname"];
		header("Location: index.php");
	  	exit();
	    }
        }
 	else {
        echo "<p> Could not authenticate </p>";
        }
    }



    unset($_POST);
    db_connect_close($db_connection);
}
?>

<html>
    <head>
	<title>Metube</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="metube_style.css">
    </head>
    <body>

	<div class="navbar">
	    <a href="index.php">Home</a>
	</div>


	<div class="container">
        <form method="post" action="login.php">
	<h6>Email Address:</h6>	
	<input class="text" type="email" name="username"><br />
	<h6>Password:</h6>
	<input class="text" type="password" name="password"><br />
	<input name="signin" type="submit" value="Sign-in">
	</form>

	<br />
	<form action="https://webapp.cs.clemson.edu/~dlee9/metube_daniel_raja/metube/register.php">
	    <input name="register" type="submit" value="Register">
	</form>
	</div>


    </body>

</html>
