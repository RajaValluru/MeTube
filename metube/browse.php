<html>
    <head>
	<title>MeTube</title>
    </head>
    <body>


        <h1>Browse Media Content</h1>
	<br>
	<form action="browse.php" method="post" enctype="multipart/form-data">
	    <label for="mediatype">Choose which media type to browse:</label>
	    <select name="mediatype" id="mediatype">
	        <option value="pictures">Pictures</option>
	        <option value="videos">Videos</option>
	        <option value="audio">Audio</option>
	    </select>
	    <label for="sortby">Sort by:</label>
	    <select name="sortby" id="sortby">
	        <option value="name">Name</option>
	        <option value="size">File Size</option>
	        <option value="views">Views</option>
		<option value="uploadtime">Upload Time</option>
	    </select>
	    <br>
	    <input type="text" name="search">
            <input type="submit" name="submit" value="Search">
	    <br>
	</form>


	<?php

	    include_once "config.php";
	    include_once "mysql_function.php";
	    session_start();



	    $db_connection = db_connect($dbhost, $dbuser, $dbpass, $database);

	    //Check if logged in
            if(isset($_SESSION['username']))
	    {
                echo "Logged in as: " . $_SESSION["username"] . "<br>";
            } else {
                echo 'Not logged in. Log in <a href="/~dlee9/metube_daniel_raja/metube/index.php">Here<a><br>';
            }

	    //Get media type from drop down
	    $mediatype = "pictures";
	    if(isset($_POST["mediatype"]))
	    {
		$mediatype = $_POST["mediatype"];
	    }


	    //Select table
	    $table = "imagelist";
	    switch ($mediatype)
	    {
		case "videos":
		    $table = "videolist";
		    break;
		case "audio":
		    $table = "audiolist";
		    break;
		default:
		    $table = "imagelist";
	    }

	    //Create sql
	    $sql = "SELECT * FROM " . $table;

	    $result = mysqli_query($db_connection, $sql);



	    if (!$result)
	    {
		die(mysqli_error($db_connection));
	    } else {

		if (mysqli_num_rows($result) > 0)
		{
		    while ($row = mysqli_fetch_assoc($result))
		    {

			echo "<br>";
			echo '<img src="/~dlee9/metube_daniel_raja/metube' . $row['ImagePath'] . '" style="width:128px;">';
			echo "<h4>" . $row['ImageName'] . "</h4>";
		    }

		}

		else
		{
		    echo "No Results Found";
		}
	    }


	    db_connect_close($db_connection);

	?>
    </body>
</html>
