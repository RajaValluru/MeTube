<?php
    session_start();
    global $fname;
    global $userid;

    if(!isset($_SESSION['userid']))
    {
	$_SESSION['userid']='1';
    }

    $userid = $_SESSION['userid'];

    if(!isset($_SESSION['fname']))
    {
	$_SESSION['fname']="guest";
    }

    $fname = $_SESSION['fname'];

?>




<html>
    <head>
        <title>MeTube</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="metube_style.css">
    </head>
    <body>

	<div class="navbar">
	    <a href="#home">Home</a>

	    <div class="navbar-right">
    		<?php
		    echo "<a>Hello $fname</a>";
    		    if($userid=='1'){echo "<a href='login.php'>Login</a>";}
    		    else{echo "<a href='signout.php'>Logout</a>";}
		?>
	    </div>

	</div>	


        <div class="container">
	<div class="container">
            <h1> Would you like to browse forums? <a href="./forum/search_view.php">Click Here!</a> </h1>
        </div>
	<div class="container">
            <h1> Would you like to browse media? <a href="./media/browse_media.php">Click Here!</a> </h1>
	</div>
    <div class="container">
            <h1> Would you like to update your profile? <a href="./profile/profile.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to View your Contacts? <a href="./profile/contactlist.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to Send and View Messages? <a href="./profile/viewmessage.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to Maintain your Video Channels? <a href="./videocnp/viewchannels.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to View your Favorite Videos? <a href="./videocnp/favorites.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to Maintain your Video Playlists? <a href="./videocnp/viewplaylists.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to Maintain your Audio Channels? <a href="./audiocnp/viewchannels.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to View your Favorite Audio? <a href="./audiocnp/favorites.php">Click Here!</a> </h1>
    </div>
    <div class="container">
            <h1> Would you like to Maintain your Audio Playlists? <a href="./audiocnp/viewplaylists.php">Click Here!</a> </h1>
    </div>
    
    
    
	</div>


    </body>

</html>
