<html>

    <head>
        <title>MeTube</title>
    </head>

    <body>

	<?php
	    session_start();


		if (!empty($_GET['yes'])) 
		{
		    header("Location: index.php");
		    session_unset();
		    session_destroy();
		    exit();
		}

		if(isset($_SESSION['username'])) 
		{
		    echo	'<h1>Sign out</h1>';
		    echo	'<p>Are you sure you want to sign out?</p>';
		    echo	'<form action="signout.php" method="get">';
		    echo	'  <input type="hidden" name="yes" value="yes">';
		    echo	'  <input type = "submit" value="Yes">';
		    echo	'</form>';
		    echo	'<form action="index.php" method="get">';
		    echo	'  <input type = "submit" value="No">';
		    echo	'</form>';

		} else
		{
		    echo	'<h3>You are not signed in</h3>';
		}
	?>

    </body>

</html>
