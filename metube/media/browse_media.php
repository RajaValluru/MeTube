<?php
    include_once "../config.php";
    include_once "../mysql_function.php";
    session_start();
    global $fname;
    global $userid;
    if(!isset($_SESSION['userid']))
    {
        $_SESSION['userid']='1';
    }
    $userid = $_SESSION['userid'];
    //$fname = $_SESSION['fname'];
?>


<html>
    <head>
	<title>MeTube</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../metube_style.css">
    </head>
    <body>


        <div class="navbar">
	    <a href="../index.php">Home</a>
	    <?php
		if ($userid!='1'){echo "<a href='upload.php'>Upload</a>";}
	    ?>
	    <div class="navbar-right">
		<?php
		    echo "<a>Hello $fname</a>";
		    if ($userid=='1'){echo "<a href='../login.php'>Login</a>";}
		    else {echo "<a href='../signout.php'>Logout</a>";}
		?>
	    </div>
	</div>


        <h1>Browse Media Content</h1>
	<br>
	<form action="browse_media.php" method="post" enctype="multipart/form-data">
	    <label for="mediatype">Choose which media type to browse:</label>
	    <select name="mediatype" id="mediatype">
	        <option value="images">Images</option>
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
	    <label for="order">Order:</label>
	    <select name="order" id="order">
		<option value="ASC">Ascending</option>
		<option value="DESC">Descending</option>
	    </select>
	    <br>
	    <input type="text" name="search">
            <input type="submit" name="submit" value="Search">
	    <br>
	</form>


	<?php

	    $db_connection = db_connect($dbhost, $dbuser, $dbpass, $database);

	    //Get media type from drop down
	    $mediatype = "images";
	    if(isset($_POST["mediatype"]))
	    {
		$mediatype = $_POST["mediatype"];
	    }


	    //Select table
	    $table = "imagelist";
	    $ratings_table = "imageratings";
	    $tag_table = "imagetags";
	    switch ($mediatype)
	    {
		case "videos":
		    $table = "videolist";
		    $ratings_table = "videoratings";
		    $column = "Video_ID";
		    $tag_table = "videotags";
		    break;
		case "audio":
		    $table = "audiolist";
		    $ratings_table = "audioratings";
		    $column = "Audio_ID";
		    $tag_table = "audiotags";
		    break;
		default:
		    $table = "imagelist";
		    $ratings_table = "imageratings";
                    $column = "Image_ID";
		    $tag_table = "imagetags";
	    }

	    $sortby = "";
	    if(isset($_POST["sortby"])) {
	        switch ($_POST["sortby"])
	        {
		    case "name":
		        $sortby = "Name";
		        break;
		    case "size":
		        $sortby = "Size";
		        break;
		    case "views":
		        $sortby = "Views";
		        break;
		    case "uploadtime":
		        $sortby = "TimeStamp";
	    	        break;
	        }
	    }

	    //Create SQL for selecting media
	    $sql = "SELECT * FROM " . $table;
	    if ($mediatype == "videos") {
		$sql = $sql . " natural join videochannel";
	    }
	    if ($mediatype == "audio") {
		$sql = $sql . " natural join audiochannel";
	    }
	    if ($sortby != "")
	    {
		$sql = $sql . " ORDER BY " . $sortby . " " . $_POST["order"];
	    }
	    $sql = $sql . ";";
	    $result_array = array();

	    //Get search terms
	    if(isset($_POST["search"]) and "" != trim($_POST["search"], " ")) {
		$search_terms = explode(" ", $_POST["search"]);

	        foreach($search_terms as $term) {
		    $sql = "select * from " . $table . " natural join " . $tag_table . " where tag like '%" . $term . "%'";

          	    if ($sortby != "")
	            {
		        $sql = $sql . " ORDER BY " . $sortby . " " . $_POST["order"];
	            }

		    $sql = $sql . ";";

		    $result = mysqli_query($db_connection, $sql);
		    if (!$result) { die(mysqli_error($db_connection)); }
		    else {
			if(mysqli_num_rows($result) > 0) {
			    while ($row = mysqli_fetch_assoc($result)) {
				array_push($result_array, $row);
			    }
			}
		    }
	        }
	    } else {
                $result = mysqli_query($db_connection, $sql);
	        if (!$result) { die(mysqli_error($db_connection)); }
	        else {
		    if(mysqli_num_rows($result) > 0) {
		        while ($row = mysqli_fetch_assoc($result)){
			    array_push($result_array, $row);
		        }
		}
	    }

	    }

		if (count($result_array) > 0)
		{
		echo '<table style="width:100%; border: 1px solid black">';
		echo '<tr>';
		echo '<th>Preview</th>';
		echo '<th>Name</th>';
		echo '<th>Views</th>';
		echo '<th>Rating</th>';
		echo '<th>Upload Time</th>';
		echo '<th>Link</th>';
	    	echo '</tr>';
		    foreach ($result_array as $row)
		    {

			switch ($mediatype)
			{
			    case "images":
				$column = "Image_ID";
				$media_id = $row["Image_ID"];
				break;
			    case "videos":
				$column = "Video_ID";
				$media_id = $row["Video_ID"];
				break;
			    case "audio":
				$column = "Audio_ID";
				$media_id = $row["Audio_ID"];
				break;
			}

			$user = $row["UserID"];

			//Get post information
			$accesstype = $row["AccessType"];
			$pub = substr($accesstype, 0, 1);
			$family = substr($accesstype, 1, 1);
			$friends = substr($accesstype, 2, 1);
			$acquaintances = substr($accesstype, 3, 1);



			//Get Rating
			$sql = "select sum(rating) from " . $ratings_table . " where " . $column . "=" . $media_id . ";";
			$ratingResult = mysqli_query($db_connection, $sql);
			if($ratingResult) {
			    if(mysqli_num_rows($ratingResult) > 0) {
				while($ratingRow = mysqli_fetch_assoc($ratingResult))
				{

					if($ratingRow["sum(rating)"] != "NULL") {
					    $rating = $ratingRow["sum(rating)"];
					}
				}
			    }
			}
			if(!isset($rating)) { $rating = 0; }

			//Get blocklist for uploader of media
			$sql = "Select * from blocklist where O_UserID = " . $user . ";";
			$blockedResult = mysqli_query($db_connection, $sql);
			$blockedList = array();
			if($blockedResult) {
                            if(mysqli_num_rows($blockedResult) > 0)
			    {
			        while($blockedRow = mysqli_fetch_assoc($blockedResult))
				{
				    array_push($blockedList, $blockedRow["B_UserID"]);
				}
			    }
			}


			//Get contactlist for uploader of media
			$sql = "Select * from contactlist where O_UserID = " . $user . ";";
			$contactsResult = mysqli_query($db_connection, $sql);
			$friendsList = array();
			$familyList = array();
			$acquaintanceList = array();
			if($contactsResult) {
			if(mysqli_num_rows($contactsResult) > 0)
			{
			    while($contactRow = mysqli_fetch_assoc($contactsResult))
			    {
				if ($contactRow["type"] == "family") { array_push($familyList, $contactRow["C_UserID"]); }
				if ($contactRow["type"] == "friends") { array_push($friendsList, $contactRow["C_UserID"]); }
				if ($contactRow["type"] == "acquaintance") { array_push($acquaintanceList, $contactRow["C_UserID"]); }
			    }
			}
			}

			//Check if permission bits are set. if so, continue if current user not in contact list and isn't uploading user
			if ($pub != "1" and $family == "1" and !in_array($_SESSION["userid"], $familyList) and $user != $_SESSION["userid"]) {continue;}
			if ($pub != "1" and $friends == "1" and !in_array($_SESSION["userid"], $friendsList) and $user != $_SESSION["userid"]) {continue;}
			if ($pub != "1" and $acquaintances == "1" and !in_array($_SESSION["userid"], $acquaintanceList) and $user != $_SESSION["userid"]) {continue;}

			//check if current user in uploader's blocklist
			if (!in_array($_SESSION["userid"], $blockedList)) {
			//check if public or if user is uploader
			if ($pub == "1" or $user == $_SESSION["userid"]) {

			    echo "<tr>";
			    switch ($mediatype)
			    {
			        case "images":
				    echo '<th> <img src="./' . $row['Path'] . '" style="width:128px;"> </th>';
				    echo "<th>" . $row['Name'] . "</th>";
				    echo "<th>" . $row['Views'] . "</th>";
				    echo "<th>" . $rating . "</th>";
				    echo "<th>" . $row['TimeStamp'] . "</th>";
				    echo "<th>";
				    echo "<form action='view_media.php' method='post'>";
				    echo "<input type='text' name='media_id' value='" . $row['Image_ID'] . "' style='display:none;'>";
				    break;
			        case "videos";
				    echo '<th> Preview </th>';
				    echo "<th>" . $row['Name'] . "</th>";
				    echo "<th>" . $row['Views'] . "</th>";
				    echo "<th>" . $rating . "</th>";
				    echo "<th>" . $row['TimeStamp'] . "</th>";
				    echo "<th>";
				    echo "<form action='view_media.php' method='post'>";
				    echo "<input type='text' name='media_id' value='" . $row['Video_ID'] . "' style='display:none;'>";
				    break;
			        case "audio";
				    echo "<th> Preview </th>";
				    echo "<th>" . $row['Name'] . "</th>";
				    echo "<th>" . $row['Views'] . "</th>";
				    echo "<th>" . $rating . "</th>";
				    echo "<th>" . $row['TimeStamp'] . "</th>";
				    echo "<th>";
				    echo "<form action='view_media.php' method='post'>";
				    echo "<input type='text' name='media_id' value='" . $row['Audio_ID'] . "' style='display:none;'>";
				    break;
			    }

			    echo "<input type='text' name='mediatype' value='" . $mediatype . "' style='display:none;'>";
			    echo "<input type='submit' value='View'>";
			    echo "</form>";
                            echo "</th>";

			    echo "</tr>";
			}
			}
		    }
		echo '</table>';
		}

		else
		{
		    echo "No Results Found";
		}
	    


	    db_connect_close($db_connection);

	?>
    </body>
</html>
