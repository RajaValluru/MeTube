<?php
    session_start();
    global $fname;
    global $userid;

    if(!isset($_SESSION["userid"]))
    {
	location("Header: ../index.php");
    }
    $userid = $_SESSION["userid"];
    $fname = $_SESSION["fname"];
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
	    <div class="navbar-right">
	    <?php echo "<a>Hello $fname</a>";

	    ?>
	    </div>
        </div>


	<?php
	    //session_start();
	    global $userid;
	    global $fname;
	    if(isset($_SESSION['userid']))
	    {
		$userid = $_SESSION['userid'];;
	    }
	    include_once "../config.php";
	    include_once "../mysql_function.php";
	    $db_connection = db_connect($dbhost, $dbuser, $dbpass, $database);

	    //Require user to be signed in
	    if($userid != "1")
	    {

		$sql = "select * from videochannel where UserID=" . $userid . ";";
		$result = mysqli_query($db_connection, $sql);


		//Echo HTML
		echo '<div class="container">';
	        echo '<form action="upload_video.php" method="post" enctype="multipart/form-data">';
		echo '    <h3>Name</h3>';
		echo '    <input type="text" name="name">';
		echo '    <input type="file" name="uploadFile" id="uploadFile">';
		echo '    <br>';
		echo '    Select a channel';
		if ($result) {
		echo '    <select id="channel" name="channel">';
		    if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
			    echo '    <option value="' . $row['VChannel_ID'] . '">' . $row['ChannelName'] . '</option>';
			}
		    }
		echo '    </select>';
		}
		echo '    <br>';
		echo '    <label for="access">Access Type:</label>';
		echo '    <input type="checkbox" name="public" value="Public" checked>';
		echo '    <label for="public">Public</label>';
		echo '    <input type="checkbox" name="family" value="Family">';
		echo '    <label for="family">Family</label>';
		echo '    <input type="checkbox" name="friends" value="Friends">';
		echo '    <label for="friends">Friends</label>';
		echo '    <input type="checkbox" name="acquaintance" value="Acquaintances">';
		echo '    <label for="acquaintance">Acquaintance</label>';
		echo '    <br>';
		echo '    Description: ';
		echo '    <br>';
		echo '    <textarea type="text" name="description"> </textarea>';
		echo '    <br>';
		echo '    Tags: (seperate by comma , )';
		echo '    <br>';
		echo '    <textarea type="text" name="tags"> </textarea>';
		echo '	  <input type="submit" value="Upload" name="submit">';
	 	echo '</form>';
		echo '</div>';


                if(isset($_FILES["uploadFile"])) {

		    if (!isset($_POST["name"]))
		    {
		        $mediaName = "Untitled";
		    } else
		    {
                        $mediaName = $_POST["name"];
		    }

                    $target_dir = "videos/";
	            $target_file = $target_dir . basename($_FILES["uploadFile"]["tmp_name"]);
	            $uploadOK = 1;
	            $fileType = "." . strtolower(pathinfo(basename($_FILES["uploadFile"]["name"]), PATHINFO_EXTENSION));
	            $fileSize = $_FILES["uploadFile"]["size"];
                    $target_file = $target_file . $fileType;
		    echo $target_file . "<br>";

		    //get the tags
		    $tags = $_POST["tags"];
		    $tags = explode(",", $tags);

		    //Get the description
		    $description = $_POST["description"];
		    $accesstype="";
		    $accesstype .=isset($_POST['public'])?"1":"0";
		    $accesstype .=isset($_POST['family'])?"1":"0";
		    $accesstype .=isset($_POST['friends'])?"1":"0";
		    $accesstype .=isset($_POST['acquaintance'])?"1":"0";

                    
		    //Do the SQL
	            if(isset($_POST["submit"]))
	            {

			$vchannel_id = $_POST["channel"];

	                if ($uploadOK == 0)
	                {
		            echo "Error uploading file";
	                } else
	                {
			    //insert image data into table
		            if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file))
		            {
		                echo "The file has been uploaded";
				chmod($target_file, 0644);
		                $sql = "INSERT INTO videolist (vchannel_id, Name, Path, Size, Format, AccessType, Views, Description) VALUES ( " . $vchannel_id . " , '" . $mediaName . "' , '/" . $target_file . "' , " . $fileSize . " , '" . $fileType . "' , '" . $accesstype . "', 0, '" . $description . "');";
				$result = mysqli_query($db_connection, $sql);
				if (!$result)
				{
				    echo mysqli_error($db_connection);
				}

				//get primary key of inserted record
				//$sql = "select LAST_INSERT_ID();";

				/*
				$key = mysqli_insert_id($db_connection);
				echo $key;
				foreach ($tags as $tag)
				{
				    $sql = "insert into videotags values (" . $key . ", '" . $tag . "');";
				    $result = mysqli_query($db_connection, $sql);
				    if (!$result)
				    {
					echo mysqli_error($db_connection) . "<br>";
				    }
				}
				*/
				//Return user to upload.php so parameters don't hang around in POST
//				header("Location: upload.php");

                            } else
		            {
		                echo "Error uploading file";
		            }
	                }
		    }
		    db_connect_close($db_connection);
                }
	    } else
	    {
		echo "You must be signed in to upload files. <a href='/~dlee9/metube_daniel_raja/metube/index.php'>Sign in here</a>";
	    }

	?>


    </body>
</html>
