<?php
    session_start();

    global $fname;
    global $userid;

    include_once "../config.php";
    include_once "../mysql_function.php";

    if(!isset($_SESSION["userid"])) {
        $_SESSION["userid"] = 1;
    }
    $userid = $_SESSION["userid"];
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
    }
    if (isset($_POST["rating"])){
	$rating = $_POST["rating"];
    }
    if (isset($_POST['mediatype'])) {
        $_SESSION['post'] = $_POST;
    }
    if(isset($_SESSION['post']) && count($_SESSION['post'])) {
	$_POST = $_SESSION['post'];
    }



    //echo $_REQUEST['mediatype'];

    //get media type and ID
    //need get for self references
    if(isset($_POST['mediatype'])) {
        $mediatype = $_POST['mediatype'];
    } else if (isset($_GET['mediatype'])) {
        $mediatype = $_GET['mediatype'];
    }

    if(isset($_POST['media_id'])) {
        $media_id = $_POST['media_id'];
    } else if (isset($_GET['media_id'])) {
	$media_id = $_GET['media_id'];
    }

    $table = "imagelist";
    $column = "Image_ID";
    $comment_table = "imagecomments";
    $ratings_table = "imageratings";
    $tag_table = "imagetags";
    switch($mediatype)
    {
	case "videos":
	    $table = "videolist";
	    $column = "Video_ID";
	    $comment_table = "videocomments";
	    $ratings_table = "videoratings";
	    $tag_table = "videotags";
	    break;
	case "audio";
	    $table = "audiolist";
	    $column = "Audio_ID";
	    $comment_table = "audiocomments";
	    $ratings_table = "audioratings";
	    $tag_table = "audiotags";
	    break;
    }


    $connection = db_connect($dbhost, $dbuser, $dbpass, $database);
    $sql = "select * from " . $table . " natural join users where " . $column . "=" . $media_id . ";";
    if ($mediatype == "videos") {
        $sql = "select * from " . $table . " natural join users natural join videochannel where " . $column . "=" . $media_id . ";";
    } else if ($mediatype == "audio") {
        $sql = "select * from " . $table . " natural join users natural join audiochannel where " . $column . "=" . $media_id . ";";
    }
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0)
    {
	$row = mysqli_fetch_assoc($result);
	$keys = array_keys($row);
	$path = $row["Path"];
	$desc = $row["Description"];
	$views = $row["Views"];
	$authorfname = $row["fname"];
	$authorlname = $row["lname"];
	$author = $authorfname . " " . $authorlname;
    }

    //get tags
    $sql = "select tag from " . $tag_table . " natural join " . $table . " where " . $column . "=" . $media_id . ";";
    $result = mysqli_query($connection, $sql);
    $tags = array();
    if (mysqli_num_rows($result) > 0)
    {
	while($row = mysqli_fetch_assoc($result))
	{
	    array_push($tags, $row["tag"]);
	}
    }

    //check if comment is submitted
    if(isset($comment) and trim($comment, " ") != "") {
	$sql = "insert into " . $comment_table . " ( UserID, " . $column . ", comment ) values ( " . $_SESSION["userid"] . ", " . $media_id . ", '" . $comment . "' );";
	$result = mysqli_query($connection, $sql);
	header("Location: view_media.php");
	exit();
    }

    //check if rating is submitted
    if(isset($rating)) {
	$sql = "select * from " . $ratings_table . " where UserID=" . $_SESSION["userid"] . " and " . $column . "=" . $media_id . ";";
	$result = mysqli_query($connection, $sql);
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		if ($row["rating"] == 1 and $rating == "dislike") {
		    $sql = "update " . $ratings_table . " set rating = -1 where " . $column . "=" . $media_id . " and UserID= " . $_SESSION["userid"] . ";";
		    $flag = "true";
		}
		else if ($row["rating"] == -1 and $rating == "like") {
		    $sql = "update " . $ratings_table . " set rating = 1 where " . $column . "=" . $media_id . " and UserID= " . $_SESSION["userid"] . ";";
		}
		$result = mysqli_query($connection, $sql);
	} else {
	    if($rating == "like") {
                $num = 1;
	    } else {
	        $num = -1;
	    }
	    $sql = "insert into " . $ratings_table . " ( UserID, " . $column . ", rating ) values ( " . $_SESSION["userid"] . ", " . $media_id . ", " . $num . " );";
	    $result = mysqli_query($connection, $sql);
	}
	header("Location: view_media.php");
	exit();
    }

    //get ratings
    $sql = "select sum(rating) from " . $ratings_table . " where " . $column . "=" . $media_id . ";";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0)
    {
	while ($row = mysqli_fetch_assoc($result))
	{
	    $rating = $row["sum(rating)"];
	}
    } else { $rating = 0; }

    //Update views
    $views = $views + 1;
    $sql = "update " . $table . " set TimeStamp = TimeStamp, Views = " . $views . " where " . $column . " = " . $media_id . ";";
    $result = mysqli_query($connection, $sql);


    //get comments
    $sql = "select * from " . $comment_table . " where " . $column . " = " . $media_id . ";";
    $result = mysqli_query($connection, $sql);
    $comments = array();
    if (mysqli_num_rows($result) > 0)
    {
	while ($row = mysqli_fetch_assoc($result))
	{
	    array_push($comments, $row);
	}
    }

    $addToPlaylistOk = True;
    if(isset($_REQUEST['addtoplaylist']))
	{
	    switch($mediatype)
		    {
		    case "videos":
		    	$sql1 = "INSERT INTO videosinplaylist (playlistid, Video_id) VALUES (".$_REQUEST['playlistid'].",$media_id);";
			break;
		    case "audio":
		    	$sql1 = "INSERT INTO audiosinplaylist (playlistid, audio_id) VALUES (".$_REQUEST['playlistid'].",$media_id);";
			break;
		}
	   
	    if(mysqli_query($connection, $sql1)){
	        $addToPlaylistOk = True;
	    } else{
	        $addToPlaylistOk = False;
	        //echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
	    }
	    
	}
	if(isset($_REQUEST['addtofavorites']))
	{
	    switch($mediatype)
		    {
		    case "videos":
		    	$sql1 = "INSERT INTO favoritevideos (video_id, userid) VALUES (".$media_id.",$userid);";
			break;
		    case "audio":
		    	$sql1 = "INSERT INTO favoriteaudios (audio_id, userid) VALUES (".$media_id.",$userid);";
			break;
		}
	   
	    if(mysqli_query($connection, $sql1)){
	        echo "Added to Favorites.";
	    } else{
	        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
	    }
	    
	}


?>

<html>
    <head>
        <title>MeTube</title>
	<meta name="viewport" content="width:device-width initial-scale-1">
	<link rel="stylesheet" href="../metube_style.css">
    </head>
    <body>


	<div class="navbar">
	    <a href="../index.php">Home</a>
	    <a href="./browse_media.php">Browse</a>
	</div>
	<br>
	<br>
	<?php

            echo "<div class='container'>";
	    switch($mediatype)
	    {
	    case "images":
	        echo "<img src='./" . $path . "' style='width:200px;'>";
		break;
	    case "videos":
		echo "<video style='width:800px;' controls>";
		echo "    <source src='./" . $path . "'>";
		echo "</video>";
		break;
            case "audio";
		echo "<audio controls>";
		echo "    <source src='./" . $path . "'>";
		echo "</audio>";
		break;


	    }
	    echo "</div>";

	    echo "<br>";
	    echo "<a href='" . $path . "' download>Download</a>";
	    echo "<br>";
	    echo "Uploader: " . $author;
	    echo "<br>";
	    echo "Views: " . $views;
	    echo "<br>";
	    echo "Rating: " . $rating;
	    echo "<br>";
	    echo "Description: " . $desc;
	    echo "<br>";
	    echo "Tags: ";
	    foreach($tags as $tag) {echo $tag . ", ";}
	    echo "<br>";

	    if($_SESSION["userid"] != 1) {
	    //create form for like/dislikes
            echo "<form action='view_media.php' method='post'>";
            echo "    <label for='rating'>Add a rating:</label>";
	    echo "    <br>";
	    echo "    <label for='like'>Like:</label>";
            echo "    <input type='radio' id='like' name='rating' value='like'>";
	    echo "    <label for='dislike'>Dislike:</label>";
            echo "    <input type='radio' id='dislike' name='rating' value='dislike'>";
	    echo "    <br>";
            echo "    <input type='submit' value='Add Rating'>";
            echo "</form><br><br>";
			
			//for adding to a playlist
            switch($mediatype)
		    {
		    case "videos":
		    	$result = $connection->query("select * from videoplaylist where userid=$userid");
			break;
		    case "audio":
		    	$result = $connection->query("select * from videoplaylist where userid=$userid");
			break;
		    }
			
			if(!$addToPlaylistOk) { echo "Failed"; }
		    if($mediatype != "images") {
			echo "<form method='post'>";			    
			echo "<select name='playlistid'>";

			while ($row = $result->fetch_assoc()) {

			    unset($id, $name);
			    $playlistid = $row['playlistid'];
			    $playlistname = $row['Playlist_Name']; 
			    echo '<option value="'.$playlistid.'">'.$playlistname.'</option>';
			}
			echo "<input type='submit' name='addtoplaylist' value='Add to Playlist'>";
			echo "</select>";
			echo "</form><br><br>";

			//favorites button
			echo "<form method='post'>";			    
			echo "<input type='submit' name='addtofavorites' value='Add to Favorites'>";
			echo "</form><br><br>";
		    }


	    //Comment form
	        echo "<form action='view_media.php' method='post'>";
	        echo "    <label for='comment'>Add a comment:</label>";
	        echo "    <input type='text' id='comment' name='comment'>";
	        echo "    <input type='submit' value='Add Comment'>";
	        echo "</form>";
	    }
	    //Display comments
	    echo "<table>";
	    echo "<tr>";
	    echo "<th>Author</th>";
	    echo "<th>Comment</th>";
	    echo "<th>TimeStamp</th>";
	    echo "</tr>";

	    foreach($comments as $comment) {
		$text = $comment["comment"];
		$ts = $comment["TimeStamp"];

		$sql = "select fname, lname from users where UserID = " . $comment["UserID"];
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_assoc($result);

		echo "<tr>";
		echo "<th>" . $row['fname'] . " </th>";
		echo "<th> $text </th>";
		echo "<th> $ts </th>";
		echo "</tr>";
	    }
	    echo "</table>";

	?>
    </body>

</html>
