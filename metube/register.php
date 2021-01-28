<html>
    <head>
        <title>MeTube</title>
    </head>
    <body>

        <form method="post" action="<?php echo "register.php"; ?>">
	<p>First name:</p>
        <input class="text" type="text" name="fname"><br/>
	<p>Last name:</p>
        <input class="text" type="text" name="lname"><br/>
	<p>Email Address:</p>
        <input class="text" type="email" name="username"><br/>
	<p>Password:</p>
        <input class="text" type="password" name="password"><br/>
        <input name="register" type="submit" value="Register">
        </form>

        <?php
	    include_once "config.php";
	    include_once "mysql_function.php";

	    if (isset($_POST['register'])) {
	        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['password'])) {
	            $connection = db_connect($dbhost, $dbuser, $dbpass, $database);
		    $sql = "SELECT * FROM users WHERE email LIKE " . $_POST['username'] . ";" ;
		    $result = mysqli_query($connection, $sql);


		    if($result) {
		        if(mysqli_num_rows($result) > 0) {
		            echo "Email already in use";
		        }
		    } else {
		        $sql = "INSERT INTO users (email, password, fname, lname)";
			$sql = $sql . " VALUES ( '" . $_POST['username'] . "', '" . $_POST['password'] . "', '" . $_POST['fname'] . "', '" . $_POST['lname'] . "');" ;

		        if (mysqli_query($connection, $sql)) {
			    echo "New user added";
			    $userid = mysqli_insert_id($connection);
			    $sql = "INSERT INTO videochannel ( UserID, ChannelName, SubscriptionCount ) values ( " . $userid . ", '" . $_POST['fname'] . "\'s Video Channel', 0 );";
			    $sql = "INSERT INTO audiochannel ( UserID, ChannelName, SubscriptionCount ) values ( " . $userid . ", '" . $_POST['fname'] . "\'s Audio Channel', 0 );";
			    $result = mysqli_query($connection, $sql);
			    if ($result) {

			    header("Location: ./index.php");
			    exit();
			    } else { echo mysqli_error($connection); }
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
			}

		        echo $result;
		    }
		}

		db_connect_close($connection);
	    }
	    unset($_POST['username']);
	?>


    </body>
</html>
